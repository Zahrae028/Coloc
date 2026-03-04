@extends('layouts.app')

@section('content')

<div class="home-container container">

    <div class="colocation-section">
        @if($colocation)
            <h2 class="colocation-name">{{ $colocation->name }}</h2>
            <p class="colocation-owner">Owner: {{ $colocation->owner->name }}</p>

            <div class="expenses-section">
                <h3>My Expenses:</h3>
                <ul class="expenses-list">
                    @foreach($expenses as $expense)
                        <li class="expense-item">
                            <span class="expense-title">{{ $expense->title }}</span>
                            -
                            <span class="expense-amount">{{ $expense->amount }} €</span>
                            -
                            <span class="expense-date">{{ $expense->created_at->format('Y-m-d') }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(auth()->user()->colocations->isEmpty())
            <h2>You are not in a colocation yet</h2>
            <a href="{{ route('colocation.create') }}" class="join-colocation-link">Create or Join a Colocation</a>

            @if($invitations && $invitations->isNotEmpty())
                <div class="invitations-section mt-4">
                    <h3>Pending Invitations:</h3>
                    <ul class="invitation-list">
                        @foreach($invitations as $invitation)
                            <li class="invitation-item">
                                Invitation from {{ $invitation->colocation->owner->name }} for colocation "{{ $invitation->colocation->name }}"
                                <form method="POST" action="{{ route('invitations.accept', $invitation->token) }}" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="accept-btn">Accept</button>
                                </form>
                                <form method="POST" action="{{ route('invitations.refuse', $invitation->token) }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="reject-btn">Reject</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        @endif
    </div>

</div>

@endsection