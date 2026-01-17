<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CNBook extends Model
{
    use HasFactory;

    protected $table = 'cn_books';

    protected $fillable = [
        'book_number',
        'book_name',
        'city_code',
        'system_year',
        'start_number',
        'end_number',
        'total_numbers',
        'issued_count',
        'remaining_count',
        'status',
        'issue_date',
        'expiry_date',
        'notes',
    ];

    protected $casts = [
        'start_number' => 'integer',
        'end_number' => 'integer',
        'total_numbers' => 'integer',
        'issued_count' => 'integer',
        'remaining_count' => 'integer',
        'issue_date' => 'date',
        'expiry_date' => 'date',
    ];

    /**
     * Get all CN number usages for this book
     */
    public function usages()
    {
        return $this->hasMany(CNNumberUsage::class, 'cn_book_id');
    }

    /**
     * Get issued CN numbers
     */
    public function issuedNumbers()
    {
        return $this->usages()->where('status', 'issued');
    }

    /**
     * Check if a CN number is available in this book
     */
    public function isNumberAvailable(int $number): bool
    {
        // Check if number is within range
        if ($number < $this->start_number || $number > $this->end_number) {
            return false;
        }

        // Check if number is already issued
        $exists = $this->usages()
            ->where('cn_number', (string)$number)
            ->where('status', 'issued')
            ->exists();

        return !$exists;
    }

    /**
     * Get next available CN number in this book
     */
    public function getNextAvailableNumber(): ?int
    {
        // Get all issued numbers
        $issuedNumbers = $this->issuedNumbers()
            ->pluck('cn_number')
            ->map(fn($n) => (int)$n)
            ->toArray();

        // Find first available number in range
        for ($i = $this->start_number; $i <= $this->end_number; $i++) {
            if (!in_array($i, $issuedNumbers)) {
                return $i;
            }
        }

        return null; // No available numbers
    }

    /**
     * Check if book is exhausted
     */
    public function isExhausted(): bool
    {
        return $this->remaining_count <= 0 || $this->status === 'exhausted';
    }

    /**
     * Check if book is low on stock (less than 10% remaining)
     */
    public function isLowStock(): bool
    {
        if ($this->total_numbers == 0) {
            return false;
        }
        
        $percentageRemaining = ($this->remaining_count / $this->total_numbers) * 100;
        return $percentageRemaining < 10 && $percentageRemaining > 0;
    }

    /**
     * Update issued and remaining counts
     */
    public function updateCounts(): void
    {
        $this->issued_count = $this->issuedNumbers()->count();
        $this->remaining_count = $this->total_numbers - $this->issued_count;
        
        // Update status if exhausted
        if ($this->remaining_count <= 0 && $this->status === 'active') {
            $this->status = 'exhausted';
        }
        
        $this->save();
    }
}
