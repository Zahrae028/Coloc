@extends('layouts.app')

@section('content')
<div class="payment-form-container">
    <h2>Add Payment</h2>

    <form method="POST" action="{{ route('payments.store') }}" class="payment-form">
        @csrf

        <label for="expense_id">Expense:</label>
        <select name="expense_id" id="expense_id" class="expense-select" required>
            @foreach($expenses as $expense)
                <option value="{{ $expense->id }}">{{ $expense->title }} - {{ $expense->amount }}</option>
            @endforeach
        </select>

        <label for="amount">Amount Paid:</label>
        <input type="number" name="amount" id="amount" class="amount-input" step="0.01" required>

        <label for="date">Date:</label>
        <input type="date" name="date" id="date" class="date-input" required>

        <button type="submit" class="submit-payment-btn">Add Payment</button>
    </form>
</div>
@endsection