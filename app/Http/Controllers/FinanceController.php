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

    public function changeVoucherDate()
    {
        return view('finance.change-voucher-date');
    }

    public function listOfChartOfAccounts()
    {
        return view('finance.list-of-chart-of-accounts');
    }

    public function cnWiseExpensesDetail()
    {
        return view('finance.cn-wise-expenses-detail');
    }

    public function trialBalance()
    {
        return view('finance.trial-balance');
    }

    public function masterSchedule()
    {
        return view('finance.master-schedule');
    }

    public function accountsLedger()
    {
        return view('finance.accounts-ledger');
    }

    public function profitLossComparative()
    {
        return view('finance.profit-loss-comparative');
    }

    public function monthWiseClosingBalanceBreakup()
    {
        return view('finance.month-wise-closing-balance-breakup');
    }

    public function groupOutstandingDetail()
    {
        return view('finance.group-outstanding-detail');
    }

    public function groupLedger()
    {
        return view('finance.group-ledger');
    }

    public function trialBalanceConsole()
    {
        return view('finance.trial-balance-console');
    }

    public function masterScheduleConsole()
    {
        return view('finance.master-schedule-console');
    }

    public function accountsLedgerConsole()
    {
        return view('finance.accounts-ledger-console');
    }

    public function plComparativeConsole()
    {
        return view('finance.pl-comparative-console');
    }

    public function accountGroupingDetail()
    {
        return view('finance.account-grouping-detail');
    }

    public function salesTaxRegisterInvoiceWise()
    {
        return view('finance.sales-tax-register-invoice-wise');
    }

    public function salesTaxRegisterCustomerWise()
    {
        return view('finance.sales-tax-register-customer-wise');
    }

    public function partyWiseOutstandingDetailed()
    {
        return view('finance.party-wise-outstanding-detailed');
    }

    public function partyWiseOutstandingAging()
    {
        return view('finance.party-wise-outstanding-aging');
    }

    public function partyWiseClearedOutstandingDetail()
    {
        return view('finance.party-wise-cleared-outstanding-detail');
    }
}
