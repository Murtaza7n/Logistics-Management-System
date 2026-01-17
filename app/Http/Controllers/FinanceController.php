<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function accountGroups()
    {
        return view('finance.account-groups');
    }

    public function groupCodes()
    {
        return view('finance.group-codes');
    }

    public function controlCodes()
    {
        return view('finance.control-codes');
    }

    public function balanceSheet(Request $request)
    {
        // TODO: Implement balance sheet logic
        return view('finance.balance-sheet');
    }

    public function profitLoss(Request $request)
    {
        // TODO: Implement profit & loss logic
        return view('finance.profit-loss');
    }
}
