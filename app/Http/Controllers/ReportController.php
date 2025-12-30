<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function transactions()
    {
        $transactions = Transaction::with('property')->orderBy('tanggal_transaksi','desc')->get();
        return view('reports.transactions', compact('transactions'));
    }

    public function commissions()
    {
        // simple commission report: komisi_marketing per transaction
        $transactions = Transaction::with('property')->whereNotNull('komisi_marketing')->orderBy('tanggal_transaksi','desc')->get();
        return view('reports.commissions', compact('transactions'));
    }

    public function visits()
    {
        // Use the properties.visited flag to show which properties were visited by marketing
        $properties = Property::with('marketing')->where('visited', true)->orderBy('updated_at', 'desc')->get();
        return view('reports.visits', compact('properties'));
    }

    public function documents()
    {
        $properties = Property::with('marketing')->orderBy('created_at','desc')->get();
        return view('reports.documents', compact('properties'));
    }

    public function taxes()
    {
        // Placeholder: summarize taxes (not implemented fully)
        $transactions = Transaction::where('status_pembayaran','paid')->get();
        return view('reports.taxes', compact('transactions'));
    }

    public function printTransactions()
    {
        $transactions = Transaction::with('property')->orderBy('tanggal_transaksi','desc')->get();
        return view('reports.print_transactions', compact('transactions'));
    }
}
