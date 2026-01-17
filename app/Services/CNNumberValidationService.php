<?php

namespace App\Services;

use App\Models\CNBook;
use App\Models\CNNumberUsage;
use App\Models\Shipment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CNNumberValidationService
{
    /**
     * Validate if a CN number can be issued
     * 
     * @param string $cnNumber The CN number to validate
     * @param string|null $cityCode Optional city code
     * @param string|null $systemYear Optional system year
     * @return array ['valid' => bool, 'message' => string, 'book' => CNBook|null]
     */
    public function validateCNNumber(string $cnNumber, ?string $cityCode = null, ?string $systemYear = null): array
    {
        // Check if CN number is already used in shipments
        $existingShipment = Shipment::where('shipment_number', $cnNumber)->first();
        if ($existingShipment) {
            return [
                'valid' => false,
                'message' => 'CN number already issued / already exists in system',
                'book' => null,
            ];
        }

        // Check if CN number is already in usage table
        $existingUsage = CNNumberUsage::where('cn_number', $cnNumber)
            ->where('status', 'issued')
            ->first();
        
        if ($existingUsage) {
            return [
                'valid' => false,
                'message' => 'CN number not available / already issued',
                'book' => null,
            ];
        }

        // Try to find a matching CN book
        $book = $this->findMatchingBook($cnNumber, $cityCode, $systemYear);
        
        if (!$book) {
            // If no book found, we can still allow it but log a warning
            Log::warning("CN number issued without matching book", [
                'cn_number' => $cnNumber,
                'city_code' => $cityCode,
                'system_year' => $systemYear,
            ]);
            
            return [
                'valid' => true,
                'message' => 'CN number validated (no matching book found)',
                'book' => null,
            ];
        }

        // Extract numeric part from CN number (e.g., "2526-KHI-000001" -> 1)
        $numericPart = $this->extractNumericPart($cnNumber);
        
        if ($numericPart === null) {
            return [
                'valid' => false,
                'message' => 'Invalid CN number format',
                'book' => null,
            ];
        }

        // Check if number is in book range
        if ($numericPart < $book->start_number || $numericPart > $book->end_number) {
            return [
                'valid' => false,
                'message' => "CN number {$numericPart} is not in book range ({$book->start_number} - {$book->end_number})",
                'book' => $book,
            ];
        }

        // Check if number is available in book
        if (!$book->isNumberAvailable($numericPart)) {
            return [
                'valid' => false,
                'message' => 'CN number not available / already issued',
                'book' => $book,
            ];
        }

        return [
            'valid' => true,
            'message' => 'CN number is available',
            'book' => $book,
        ];
    }

    /**
     * Issue a CN number and create usage record
     * 
     * @param string $cnNumber The CN number to issue
     * @param int|null $shipmentId The shipment ID (if available)
     * @param int|null $userId The user ID who is issuing
     * @param string|null $cityCode Optional city code
     * @param string|null $systemYear Optional system year
     * @return array ['success' => bool, 'message' => string, 'usage' => CNNumberUsage|null]
     */
    public function issueCNNumber(
        string $cnNumber,
        ?int $shipmentId = null,
        ?int $userId = null,
        ?string $cityCode = null,
        ?string $systemYear = null
    ): array {
        // Validate first
        $validation = $this->validateCNNumber($cnNumber, $cityCode, $systemYear);
        
        if (!$validation['valid']) {
            return [
                'success' => false,
                'message' => $validation['message'],
                'usage' => null,
            ];
        }

        try {
            DB::beginTransaction();

            // Create usage record
            $usage = CNNumberUsage::create([
                'cn_book_id' => $validation['book']?->id,
                'cn_number' => $cnNumber,
                'shipment_id' => $shipmentId,
                'issued_by' => $userId ?? auth()->id(),
                'issued_at' => now(),
                'status' => 'issued',
            ]);

            // Update book counts if book exists
            if ($validation['book']) {
                $validation['book']->updateCounts();
            }

            DB::commit();

            Log::info("CN number issued successfully", [
                'cn_number' => $cnNumber,
                'shipment_id' => $shipmentId,
                'user_id' => $userId ?? auth()->id(),
                'book_id' => $validation['book']?->id,
            ]);

            return [
                'success' => true,
                'message' => 'CN number issued successfully',
                'usage' => $usage,
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error("Failed to issue CN number", [
                'cn_number' => $cnNumber,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Failed to issue CN number: ' . $e->getMessage(),
                'usage' => null,
            ];
        }
    }

    /**
     * Find a matching CN book for the given CN number
     */
    protected function findMatchingBook(string $cnNumber, ?string $cityCode = null, ?string $systemYear = null): ?CNBook
    {
        $query = CNBook::where('status', 'active');

        if ($systemYear) {
            $query->where('system_year', $systemYear);
        }

        if ($cityCode) {
            $query->where('city_code', $cityCode);
        }

        // Get all active books and check which one contains this number
        $books = $query->get();
        
        $numericPart = $this->extractNumericPart($cnNumber);
        
        if ($numericPart === null) {
            return null;
        }

        foreach ($books as $book) {
            if ($numericPart >= $book->start_number && $numericPart <= $book->end_number) {
                return $book;
            }
        }

        return null;
    }

    /**
     * Extract numeric part from CN number
     * Examples:
     * "2526-KHI-000001" -> 1
     * "2526-GEN-000050" -> 50
     * "000001" -> 1
     */
    protected function extractNumericPart(string $cnNumber): ?int
    {
        // Remove all non-numeric characters and get the last numeric sequence
        preg_match('/\d+$/', $cnNumber, $matches);
        
        if (empty($matches)) {
            return null;
        }

        return (int) $matches[0];
    }

    /**
     * Get next available CN number from a book
     */
    public function getNextAvailableCNNumber(?string $cityCode = null, ?string $systemYear = null): ?string
    {
        $query = CNBook::where('status', 'active')
            ->where('remaining_count', '>', 0);

        if ($systemYear) {
            $query->where('system_year', $systemYear);
        }

        if ($cityCode) {
            $query->where('city_code', $cityCode);
        }

        $book = $query->orderBy('start_number')->first();

        if (!$book) {
            return null;
        }

        $nextNumber = $book->getNextAvailableNumber();
        
        if ($nextNumber === null) {
            return null;
        }

        // Format the number based on book's city code and system year
        $formattedNumber = sprintf(
            '%s-%s-%06d',
            $book->system_year ?? $systemYear ?? date('Y'),
            $book->city_code ?? $cityCode ?? 'GEN',
            $nextNumber
        );

        return $formattedNumber;
    }
}

