@extends('layouts.app')

@section('content')
<div class="invitations-container">
    <h2>My Invitations</h2>

    @if($invitations->isEmpty())
        <p class="no-invitations">You have no pending invitations.</p>
    @else
        <ul class="invitation-list">
            @foreach($invitations as $invitation)
                <li class="invitation-item">
                    <span class="colocation-name">{{ $invitation->colocation->name }}</span>
                    <span class="inviter-name">Invited by: {{ $invitation->sender->name }}</span>
                    
                    <form class="invitation-actions" method="POST" action="{{ route('invitations.accept', $invitation->id) }}">
                        @csrf
                        <button type="submit" class="accept-btn">Accept</button>
                    </form>

                    <form class="invitation-actions" method="POST" action="{{ route('invitations.reject', $invitation->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="reject-btn">Reject</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection