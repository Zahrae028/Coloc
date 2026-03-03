@extends('layouts.app')

@section('content')
<div class="invitation-form-container">
    <h2>Invite a User to Join Your Colocation</h2>

    <form method="POST" action="{{ route('invitations.store') }}" class="invitation-form">
        @csrf
        <label for="email">User Email:</label>
        <input type="email" name="email" id="email" class="email-input" placeholder="Enter user email" required>

        <button type="submit" class="send-invite-btn">Send Invitation</button>
    </form>
</div>
@endsection