@extends('layouts.app')

@section('content')
<div class="coloc-show">
    <h2 class="coloc-name">{{ $colocation->name }}</h2>
    <p class="coloc-owner">Owner: {{ $colocation->owner->name }}</p>

    <h3>Members</h3>
    <ul class="coloc-members">
        @foreach($colocation->members as $member)
            <li class="member">
                {{ $member->name }}
                @if($member->id === $colocation->owner->id)
                    👑
                @endif

                @if(auth()->id() === $colocation->owner_id && $member->id !== $colocation->owner_id)
                    <form action="{{ route('colocation.removeMember', [$colocation->id, $member->id]) }}" method="POST" class="kick-member-form" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-kick">Kick</button>
                    </form>
                @endif
            </li>
        @endforeach
    </ul>

    @if(auth()->id() === $colocation->owner_id)
        <div class="transfer-ownership">
            <h4>Transfer Ownership</h4>
            <form action="{{ route('colocation.transferOwnership', $colocation->id) }}" method="POST">
                @csrf
                <select name="new_owner_id" class="member-select">
                    @foreach($colocation->members as $member)
                        @if($member->id !== $colocation->owner_id)
                            <option value="{{ $member->id }}">{{ $member->name }}</option>
                        @endif
                    @endforeach
                </select>
                <button type="submit" class="btn-transfer">Transfer</button>
            </form>
        </div>

        <div class="invite-member mt-4">
            <a href="{{ route('invitations.create') }}" class="btn-invite">Invite New Member</a>
        </div>
    @endif

    <div class="coloc-links mt-4">
        <a href="{{ route('expense.index', $colocation->id) }}" class="link-expenses">View Expenses</a>
        @if(auth()->id() === $colocation->owner_id)
            <a href="{{ route('colocation.edit', $colocation->id) }}" class="link-edit">Edit Colocation</a>
        @endif
    </div>
</div>
@endsection