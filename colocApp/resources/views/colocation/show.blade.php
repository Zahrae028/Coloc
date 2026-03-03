@extends('layouts.app')

@section('content')
    <div class="coloc-show">
        <h2 class="coloc-name">{{ $colocation->name }}</h2>
        <p class="coloc-owner">Owner: {{ $colocation->owner->name }}</p>

        <h3>Members</h3>
        <ul class="coloc-members">
            @foreach($colocation->members as $member)
                <li class="member">{{ $member->name }}</li>
            @endforeach
        </ul>

        <div class="coloc-links">
            <a href="{{ route('expense.index', $colocation->id) }}" class="link-expenses">View Expenses</a>
            @if(auth()->id() === $colocation->owner_id)
                <a href="{{ route('colocation.edit', $colocation->id) }}" class="link-edit">
                    Edit Colocation
                </a>
            @endif
        </div>
    </div>
@endsection