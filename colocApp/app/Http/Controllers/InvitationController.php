<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvitationRequest;
use App\Models\Colocation;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class InvitationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $invitations = Invitation::with('colocation', 'sender')
            ->where('email', $user->email)
            ->where('status', 'pending')
            ->get();

        return view('invitations.index', compact('invitations'));
    }
    public function create()
    {
        $user = Auth::user();
        $colocation = $user->colocations()->first();
        if ($user->id != $colocation->owner_id) {
            return back()->with('error', 'Only the owner can invite new members.');
        }
        return view('invitation.create', compact('colocation'));
    }


    public function store(InvitationRequest $request)
    {
        $user = Auth::user();
        $colocation = $user->colocations()->first();

        if ($user->id != $colocation->owner_id) {
            return back()->with('error', 'Only the owner can invite new members.');
        }
        $email = $request->input('email');
        if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return back()->with('error', 'Please enter a valid email.');
        }
        $token = Str::random(32);



        $invitation = new Invitation();
        $invitation->colocation_id = $colocation->id;
        $invitation->email = $email;
        $invitation->token = $token;
        $invitation->status = 'pending';
        $invitation->save();

        return back()->with('success', 'Invitation sent successfully.');

    }

    public function accept($token)
    {

        $invitation = Invitation::where('token', $token)->firstOrFail();
        if ($invitation->status !== 'pending') {
            return back()->with('error', 'Invitation already answered.');
        }


        $user = Auth::user();
        if ($user->email !== $invitation->email) {
            abort(403, 'This invitation is not for your account.');
        }

        if ($user->colocations()->exists()) {
            return back()->with('error', 'You already belong to a colocation.');
        }

        $colocation = Colocation::findOrFail($invitation->colocation_id);
        $colocation->members()->attach($user->id);

        $invitation->status = 'accepted';
        $invitation->save();

        return redirect()->route('colocation.show', $invitation->colocation_id)->with('success', ' You have joined the colocation !');

    }

    public function refuse($token)
    {
        $invitation = Invitation::where('token', $token)->firstOrFail();

        $user = Auth::user();
        if ($user->email !== $invitation->email) {
            abort(403, 'This invitation is not for your account.');
        }

        $invitation->status = 'refused';
        $invitation->save();

        return redirect()->route('dashboard');
    }



}
