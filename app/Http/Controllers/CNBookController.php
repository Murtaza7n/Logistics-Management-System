<?php

namespace App\Http\Controllers;

use App\Models\CNBook;
use App\Models\CNNumberUsage;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CNBookController extends Controller
{
    /**
     * Display a listing of CN books
     */
    public function index(Request $request)
    {
        $query = CNBook::withCount(['usages as issued_count_calc' => function($q) {
            $q->where('status', 'issued');
        }]);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by city code
        if ($request->filled('city_code')) {
            $query->where('city_code', $request->city_code);
        }

        // Filter by system year
        if ($request->filled('system_year')) {
            $query->where('system_year', $request->system_year);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('book_number', 'like', "%{$search}%")
                  ->orWhere('book_name', 'like', "%{$search}%");
            });
        }

        $books = $query->orderBy('created_at', 'desc')->paginate(20);
        $cities = City::where('is_active', true)->orderBy('name')->get();
        
        // Get low stock books
        $lowStockBooks = CNBook::where('status', 'active')
            ->get()
            ->filter(fn($book) => $book->isLowStock());

        return view('cn-books.index', compact('books', 'cities', 'lowStockBooks'));
    }

    /**
     * Show the form for creating a new CN book
     */
    public function create()
    {
        $cities = City::where('is_active', true)->orderBy('name')->get();
        return view('cn-books.create', compact('cities'));
    }

    /**
     * Store a newly created CN book
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_number' => 'required|string|max:255|unique:cn_books,book_number',
            'book_name' => 'nullable|string|max:255',
            'city_code' => 'nullable|string|max:10',
            'system_year' => 'nullable|string|max:10',
            'start_number' => 'required|integer|min:1',
            'end_number' => 'required|integer|gt:start_number',
            'issue_date' => 'nullable|date',
            'expiry_date' => 'nullable|date|after:issue_date',
            'notes' => 'nullable|string',
        ]);

        // Calculate total numbers
        $totalNumbers = $validated['end_number'] - $validated['start_number'] + 1;

        $book = CNBook::create([
            'book_number' => $validated['book_number'],
            'book_name' => $validated['book_name'] ?? null,
            'city_code' => $validated['city_code'] ?? null,
            'system_year' => $validated['system_year'] ?? null,
            'start_number' => $validated['start_number'],
            'end_number' => $validated['end_number'],
            'total_numbers' => $totalNumbers,
            'issued_count' => 0,
            'remaining_count' => $totalNumbers,
            'status' => 'active',
            'issue_date' => $validated['issue_date'] ?? now(),
            'expiry_date' => $validated['expiry_date'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('cn-books.index')
            ->with('success', "CN Book '{$book->book_number}' created successfully.");
    }

    /**
     * Display the specified CN book with usage details
     */
    public function show(CNBook $cnBook)
    {
        $cnBook->load(['usages.shipment', 'usages.issuedBy']);
        
        // Get issued numbers
        $issuedNumbers = $cnBook->issuedNumbers()
            ->with(['shipment', 'issuedBy'])
            ->orderBy('issued_at', 'desc')
            ->paginate(50);

        // Statistics
        $stats = [
            'total_numbers' => $cnBook->total_numbers,
            'issued_count' => $cnBook->issued_count,
            'remaining_count' => $cnBook->remaining_count,
            'usage_percentage' => $cnBook->total_numbers > 0 
                ? round(($cnBook->issued_count / $cnBook->total_numbers) * 100, 2) 
                : 0,
            'is_low_stock' => $cnBook->isLowStock(),
            'is_exhausted' => $cnBook->isExhausted(),
        ];

        return view('cn-books.show', compact('cnBook', 'issuedNumbers', 'stats'));
    }

    /**
     * Show the form for editing the specified CN book
     */
    public function edit(CNBook $cnBook)
    {
        $cities = City::where('is_active', true)->orderBy('name')->get();
        return view('cn-books.edit', compact('cnBook', 'cities'));
    }

    /**
     * Update the specified CN book
     */
    public function update(Request $request, CNBook $cnBook)
    {
        $validated = $request->validate([
            'book_number' => 'required|string|max:255|unique:cn_books,book_number,' . $cnBook->id,
            'book_name' => 'nullable|string|max:255',
            'city_code' => 'nullable|string|max:10',
            'system_year' => 'nullable|string|max:10',
            'start_number' => 'required|integer|min:1',
            'end_number' => 'required|integer|gt:start_number',
            'issue_date' => 'nullable|date',
            'expiry_date' => 'nullable|date|after:issue_date',
            'status' => 'required|in:active,exhausted,archived',
            'notes' => 'nullable|string',
        ]);

        // Recalculate if range changed
        if ($validated['start_number'] != $cnBook->start_number || 
            $validated['end_number'] != $cnBook->end_number) {
            $totalNumbers = $validated['end_number'] - $validated['start_number'] + 1;
            $validated['total_numbers'] = $totalNumbers;
            $cnBook->updateCounts(); // This will recalculate remaining
        }

        $cnBook->update($validated);
        $cnBook->updateCounts();

        return redirect()->route('cn-books.index')
            ->with('success', "CN Book '{$cnBook->book_number}' updated successfully.");
    }

    /**
     * Remove the specified CN book
     */
    public function destroy(CNBook $cnBook)
    {
        // Check if book has issued numbers
        if ($cnBook->issuedNumbers()->count() > 0) {
            return redirect()->route('cn-books.index')
                ->with('error', "Cannot delete CN Book '{$cnBook->book_number}' because it has issued CN numbers. Archive it instead.");
        }

        $bookNumber = $cnBook->book_number;
        $cnBook->delete();

        return redirect()->route('cn-books.index')
            ->with('success', "CN Book '{$bookNumber}' deleted successfully.");
    }

    /**
     * Update book counts (manual refresh)
     */
    public function refreshCounts(CNBook $cnBook)
    {
        $cnBook->updateCounts();
        
        return back()->with('success', 'CN Book counts refreshed successfully.');
    }

    /**
     * Get remaining CN numbers for a book
     */
    public function getRemainingNumbers(CNBook $cnBook)
    {
        $issuedNumbers = $cnBook->issuedNumbers()
            ->pluck('cn_number')
            ->map(fn($n) => (int) preg_replace('/\D/', '', $n))
            ->toArray();

        $allNumbers = range($cnBook->start_number, $cnBook->end_number);
        $remainingNumbers = array_diff($allNumbers, $issuedNumbers);

        return response()->json([
            'book' => $cnBook,
            'remaining_numbers' => array_values($remainingNumbers),
            'count' => count($remainingNumbers),
        ]);
    }
}
