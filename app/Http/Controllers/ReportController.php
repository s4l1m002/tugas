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
        // Commission calculation based on harga_jual:
        // office_fee = 3% of harga_jual
        // marketing_gross = office_fee * 70%
        // office_share = office_fee * 30%
        // marketing_tax = marketing_gross * 2.5%
        // marketing_net = marketing_gross - marketing_tax
        $transactions = Transaction::with(['property','marketing'])
            ->where('status_pembayaran','paid')
            ->orderBy('tanggal_transaksi','desc')
            ->get();

        $details = [];
        $marketingSummary = []; // keyed by marketing_id

        foreach ($transactions as $t) {
            $harga = floatval($t->harga_jual ?? $t->property->harga ?? 0);
            $officeFee = $harga * 0.03;
            $marketingGross = $officeFee * 0.7;
            $officeShare = $officeFee * 0.3;
            $marketingTax = $marketingGross * 0.025;
            $marketingNet = $marketingGross - $marketingTax;

            $details[] = (object) [
                'transaction' => $t,
                'harga' => $harga,
                'office_fee' => $officeFee,
                'marketing_gross' => $marketingGross,
                'office_share' => $officeShare,
                'marketing_tax' => $marketingTax,
                'marketing_net' => $marketingNet,
            ];

            $mid = $t->marketing_id ?? ($t->property->marketing_id ?? null);
            if ($mid) {
                if (! isset($marketingSummary[$mid])) {
                    $marketingSummary[$mid] = ['marketing_id' => $mid, 'name' => $t->marketing->name ?? ($t->property->marketing->name ?? 'N/A'), 'gross' => 0, 'tax' => 0, 'net' => 0];
                }
                $marketingSummary[$mid]['gross'] += $marketingGross;
                $marketingSummary[$mid]['tax'] += $marketingTax;
                $marketingSummary[$mid]['net'] += $marketingNet;
            }
        }

        return view('reports.commissions', compact('details','marketingSummary'));
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
        // Show taxes per paid transaction: buyer+seller tax = 7.5% of harga_jual
        $transactions = Transaction::with('property')->where('status_pembayaran','paid')->orderBy('tanggal_transaksi','desc')->get();

        $taxDetails = [];
        $totalTax = 0;
        foreach ($transactions as $t) {
            $harga = floatval($t->harga_jual ?? $t->property->harga ?? 0);
            $tax = $harga * 0.075; // 7.5%
            $taxDetails[] = (object)['transaction' => $t, 'harga' => $harga, 'tax' => $tax];
            $totalTax += $tax;
        }

        return view('reports.taxes', compact('taxDetails','totalTax'));
    }
}

