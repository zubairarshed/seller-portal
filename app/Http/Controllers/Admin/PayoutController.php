<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payout;
use App\Models\SellerBalance;
use App\Models\User;
use Illuminate\Http\Request;

class PayoutController extends Controller
{
    public function index()
    {
        $sellers = User::where('role', 'seller')->with('balance')->get();
        $payouts = Payout::with('seller')->latest()->get();

        return view('admin.payouts.index', compact('sellers', 'payouts'));
    }

    public function pay(Request $request, User $seller)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1|min:0.01|regex:/^\d+(\.\d{1,2})?$/',
        ]);

        $balance = $seller->balance;

        if (!$balance || $balance->available_balance < $request->amount) {
            return back()->with('error', 'Not enough balance to payout.');
        }

        // Create payout record
        $payout = Payout::create([
            'seller_id' => $seller->id,
            'amount' => $request->amount,
            'status' => 'paid',
        ]);

        // Update seller balance
        $balance->decrement('available_balance', $request->amount);
        $balance->increment('total_paid', $request->amount);

        return back()->with('message', "Payout of {$request->amount} to {$seller->name} recorded.");
    }

    public function exportCsv()
    {
        $payouts = Payout::with('seller')->latest()->get();

        $csvData = "Date,Seller,Amount,Status\n";
        foreach ($payouts as $payout) {
            $csvData .= "{$payout->created_at},{$payout->seller->name},{$payout->amount},{$payout->status}\n";
        }

        return response($csvData)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename=payouts.csv');
    }

    public function exportPdf()
    {
        $payouts = Payout::with('seller')->latest()->get();

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin.payouts.pdf', compact('payouts'));

        return $pdf->download('payouts.pdf');
    }
}
