@extends('layouts.app')

@section('content')

<div class="expense-show-container">

    <div class="expense-card">
        <h2 class="expense-title">{{ $expense->title }}</h2>

        <div class="expense-meta">
            <p class="expense-amount">
                <strong>Amount:</strong> {{ $expense->amount }} €
            </p>


            <p class="expense-payer">
                <strong>Paid by:</strong> {{ $expense->payer->name }}
            </p>

            <p class="expense-category">
                <strong>Category:</strong> {{ $expense->category->name ?? 'N/A' }}
            </p>
        </div>
    </div>

    <div class="expense-members-section">
        <h3 class="members-heading">Members Shares</h3>

        <ul class="members-list">
            @foreach($expense->members as $member)
                <li class="member-share-item">

                    <div class="member-info">
                        <span class="member-name">{{ $member->name }}</span>
                        <span class="member-share">
                            Owes: {{ $member->pivot->share }} €
                        </span>
                    </div>

                    <div class="member-payment-status">
                        @if($member->pivot->paid)
                            <span class="payment-paid">✅ Paid</span>
                        @else
                            <span class="payment-unpaid">❌ Not Paid</span>

                            @if(auth()->id() === $expense->colocation->owner_id)
                                <form method="POST"
                                      action="{{ route('expenses.markPaid', [$expense->id, $member->id]) }}"
                                      class="mark-paid-form">
                                    @csrf
                                    <button type="submit" class="btn-mark-paid">
                                        Mark as Paid
                                    </button>
                                </form>
                            @endif
                        @endif
                    </div>

                </li>
            @endforeach
        </ul>
    </div>

    <div class="expense-actions">
        <a href="{{ route('expense.index') }}" class="btn-back">
            Back to Expenses
        </a>
    </div>

</div>

@endsection