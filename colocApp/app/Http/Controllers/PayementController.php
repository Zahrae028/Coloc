<?php

namespace App\Http\Controllers;

use App\Models\Payement;
use App\Models\Payment;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    
    public function index()
    {
        $user = Auth::user();
        $colocation = $user->colocations()->first();

        $payments = Payement::whereIn('expense_id', $colocation->expenses->pluck('id'))
            ->with(['payer', 'receiver', 'expense'])
            ->get();

        return view('payment.index', compact('payments', 'colocation'));
    }

    
    
    public function create()
    {
        $user = Auth::user();
        $colocation = $user->colocations()->first();
        $expenses = $colocation->expenses;

        return view('payment.create', compact('expenses', 'colocation'));
    }

    
    public function store(Request $request)
    {
        $user = Auth::user();
        $payment = new Payement();
        $payment->expense_id = $request->input('expense_id');
        $payment->payer_id = $user->id;
        $payment->receiver_id = $request->input('receiver_id'); // member who owes
        $payment->amount = $request->input('amount');
        $payment->save();

        return redirect()->route('payment.index')->with('success', 'Payment recorded successfully.');
    }

    
    public function show($id)
    {
        $payment = Payement::with(['payer', 'receiver', 'expense'])->findOrFail($id);
        return view('payment.show', compact('payment'));
    }

    
    public function edit($id)
    {
        $payment = Payement::findOrFail($id);
        $user = Auth::user();

        // Only the payer or colocation owner can edit
        if ($payment->payer_id != $user->id) {
            abort(403);
        }

        return view('payment.edit', compact('payment'));
    }

    
    public function update(Request $request, $id)
    {
        $payment = Payement::findOrFail($id);
        $user = Auth::user();

        if ($payment->payer_id != $user->id) {
            abort(403);
        }

        $payment->amount = $request->input('amount');
        $payment->save();

        return redirect()->route('payment.index')->with('success', 'Payment updated successfully.');
    }

    
    public function destroy($id)
    {
        $payment = Payement::findOrFail($id);
        $user = Auth::user();

        if ($payment->payer_id != $user->id) {
            abort(403);
        }

        $payment->delete();
        return redirect()->route('payment.index')->with('success', 'Payment deleted successfully.');
    }
}