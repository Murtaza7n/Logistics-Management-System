<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChartOfAccountController extends Controller
{
    public function index()
    {
        return view('chart-of-accounts.index');
    }

    public function create()
    {
        return view('chart-of-accounts.create');
    }

    public function store(Request $request)
    {
        // TODO: Implement chart of account storage logic
        return redirect()->route('chart-of-accounts.index')->with('success', 'Account created successfully.');
    }

    public function show($id)
    {
        return view('chart-of-accounts.show');
    }

    public function edit($id)
    {
        return view('chart-of-accounts.edit');
    }

    public function update(Request $request, $id)
    {
        // TODO: Implement chart of account update logic
        return redirect()->route('chart-of-accounts.index')->with('success', 'Account updated successfully.');
    }

    public function destroy($id)
    {
        // TODO: Implement chart of account deletion logic
        return redirect()->route('chart-of-accounts.index')->with('success', 'Account deleted successfully.');
    }
}
