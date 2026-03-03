@extends('layouts.app')

@section('content')
<div class="payments-container">
    <h2>Payments</h2>

    @if($payments->isEmpty())
        <p class="no-payments">No payments recorded yet.</p>
    @else
        <ul class="payment-list">
            @foreach($payments as $payment)
                <li class="payment-item">
                    <span class="payer-name">{{ $payment->payer->name }}</span>
                    <span class="amount">Amount: {{ $payment->amount }}</span>
                    <span class="date">Date: {{ $payment->date }}</span>
                    <span class="expense-title">Expense: {{ $payment->expense->title }}</span>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection