@extends('layouts.app')

@section('content')

<div class="home-container">

  
    <div class="colocation-section">
        @if($colocation)
            <h2 class="colocation-name">{{ $colocation->name }}</h2>
            <p class="colocation-owner">Owner: {{ $colocation->owner->name }}</p>
            
            <div class="expenses-section">
    <h3>My Expenses:</h3>

    @if($expenses->isEmpty())
        <p class="no-expenses">You have no expenses yet.</p>
    @else
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
    @endif
</div>

           
            <div class="expenses-link">
            </div>

        @else
            <h2>You are not in a colocation yet</h2>
            <a href="{{ route('colocation.create') }}" class="join-colocation-link">Create or Join a Colocation</a>
        @endif
    </div>


</div>

@endsection