<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index()
    {
        return view('vouchers.index');
    }

    public function create($type = null)
    {
        $voucherTypes = [
            'bpv' => 'Bank Payment Voucher',
            'brv' => 'Bank Receipt Voucher',
            'cpv' => 'Cash Payment Voucher',
            'crv' => 'Cash Receipt Voucher',
            'jvr' => 'Journal Voucher',
        ];

        $voucherType = $type ?? 'bpv';
        $voucherTypeName = $voucherTypes[$voucherType] ?? 'Voucher';

        return view('vouchers.create', compact('voucherType', 'voucherTypeName'));
    }

    public function store(Request $request)
    {
        // TODO: Implement voucher storage logic
        return redirect()->route('vouchers.index')->with('success', 'Voucher created successfully.');
    }

    public function show($id)
    {
        return view('vouchers.show');
    }

    public function edit($id)
    {
        return view('vouchers.edit');
    }

    public function update(Request $request, $id)
    {
        // TODO: Implement voucher update logic
        return redirect()->route('vouchers.index')->with('success', 'Voucher updated successfully.');
    }

    public function destroy($id)
    {
        // TODO: Implement voucher deletion logic
        return redirect()->route('vouchers.index')->with('success', 'Voucher deleted successfully.');
    }
}
