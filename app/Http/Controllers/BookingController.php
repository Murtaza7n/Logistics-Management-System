<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Vendor;
use App\Models\City;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['customer', 'vendor', 'creator'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('booking_number')) {
            $query->where('booking_number', 'like', '%' . $request->booking_number . '%');
        }

        if ($request->filled('pickup_city')) {
            $query->where('pickup_city', $request->pickup_city);
        }

        if ($request->filled('delivery_city')) {
            $query->where('delivery_city', $request->delivery_city);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('booking_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('booking_date', '<=', $request->date_to);
        }

        $bookings = $query->paginate(15);
        $customers = Customer::where('status', 'active')->get();
        $vendors = Vendor::where('status', 'active')->get();
        $cities = City::where('is_active', true)->orderBy('name')->get();

        return view('bookings.index', compact('bookings', 'customers', 'vendors', 'cities'));
    }

    public function create()
    {
        $customers = Customer::where('status', 'active')->get();
        $vendors = Vendor::where('status', 'active')->get();
        $cities = City::where('is_active', true)->orderBy('name')->get();
        $systemYear = session('system_year', '2526');

        return view('bookings.create', compact('customers', 'vendors', 'cities', 'systemYear'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_number' => 'required|string|max:50|unique:bookings,booking_number',
            'booking_date' => 'required|date',
            'shipper_name' => 'required|string|max:255',
            'consignee_name' => 'required|string|max:255',
            'pickup_city' => 'required|string|max:100',
            'delivery_city' => 'required|string|max:100',
            'cargo_type' => 'nullable|string|max:50',
            'weight' => 'nullable|numeric|min:0',
            'quantity' => 'nullable|integer|min:1',
            'estimated_freight' => 'nullable|numeric|min:0',
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $validated['system_year'] = session('system_year', '2526');
        $validated['created_by'] = auth()->id();

        $booking = Booking::create($validated);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'created',
            'model_type' => 'Booking',
            'model_id' => $booking->booking_id,
            'description' => "Created booking: {$booking->booking_number}",
        ]);

        return redirect()->route('bookings.index')->with('success', 'Booking created successfully.');
    }

    public function show(Booking $booking)
    {
        $booking->load(['customer', 'vendor', 'creator', 'shipments']);
        return view('bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        $customers = Customer::where('status', 'active')->get();
        $vendors = Vendor::where('status', 'active')->get();
        $cities = City::where('is_active', true)->orderBy('name')->get();
        return view('bookings.edit', compact('booking', 'customers', 'vendors', 'cities'));
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'booking_number' => 'required|string|max:50|unique:bookings,booking_number,' . $booking->booking_id . ',booking_id',
            'booking_date' => 'required|date',
            'shipper_name' => 'required|string|max:255',
            'consignee_name' => 'required|string|max:255',
            'pickup_city' => 'required|string|max:100',
            'delivery_city' => 'required|string|max:100',
            'cargo_type' => 'nullable|string|max:50',
            'weight' => 'nullable|numeric|min:0',
            'quantity' => 'nullable|integer|min:1',
            'estimated_freight' => 'nullable|numeric|min:0',
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $booking->update($validated);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'updated',
            'model_type' => 'Booking',
            'model_id' => $booking->booking_id,
            'description' => "Updated booking: {$booking->booking_number}",
        ]);

        return redirect()->route('bookings.index')->with('success', 'Booking updated successfully.');
    }

    public function destroy(Booking $booking)
    {
        $bookingNumber = $booking->booking_number;
        $booking->delete();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'deleted',
            'model_type' => 'Booking',
            'model_id' => $booking->booking_id,
            'description' => "Deleted booking: {$bookingNumber}",
        ]);

        return redirect()->route('bookings.index')->with('success', 'Booking deleted successfully.');
    }
}
