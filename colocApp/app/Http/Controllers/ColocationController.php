<?php

namespace App\Http\Controllers;

use App\Http\Requests\ColocationRequest;
use App\Models\Colocation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ColocationController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $colocation = $user->colocations()->first();
    $expenses = $user->expenses();
$invitations = collect();
    if (!$colocation) {
        $invitations = $user->invitations()->where('status', 'pending')->with('colocation.owner')->get();
    }

    return view('home', compact('colocation', 'expenses', 'invitations'));
        return view('home' , compact('colocation','expenses'));
    }


    public function create()
    {
        if (Auth::user()->colocation_id) {
            return back()->with('error', 'You already have a colocation.');
        } else {
            return view('colocation.create');
        }
    }


    public function store(ColocationRequest $request)
    {
        if (Auth::user()->colocations()->exists()) {
            return back()->with('error', 'You already have a colocation.');
        }

        $name = $request->input('name');

        if (!$name || strlen($name) < 3) {
            return back()->with('error', 'Colocation name must be at least 3 characters.');
        }


        $colocation = new Colocation();
        $colocation->name = $name;
        $colocation->owner_id = Auth::id();
        $colocation->status = 'active';
        $colocation->save();


        $user = Auth::user();
        $colocation->members()->attach($user->id);

        return redirect()->route('colocation.show', $colocation->id)->with('success', 'Colocation created successfully');
    }


    public function show()
    {
        $user = Auth::user();
        $colocation = $user->colocations()->with('owner', 'members')->first();
        $members = $colocation->members;
        $expenses = $user->expenses();

        return view('colocation.show', compact('colocation'));
    }


    public function edit(string $id)
    {
        $user = Auth::user();
        if ($user->colocations()->id != $id) {
            abort(403);
        }
        $colocation = Colocation::with('owner', 'members')->findOrFail($id);
        $members = $colocation->members;

        return view('colocation.edit', compact('colocation', 'members'));
    }


    public function update(ColocationRequest $request, string $id)
    {
        $user = Auth::user();
        $colocation = $user->colocation;

        if ($colocation->owner_id != $user->id) {
            abort(403);
        }

        $name = $request->input('name');
        $status = $request->input('status');
        $newOwner = $request->input('owner');

        if (!$name || strlen($name) < 3) {
            return back()->with('error', 'Colocation name must be at least 3 characters.');
        }
        $colocation->name = $name;
        $colocation->owner_id = $newOwner;
        $colocation->status = $status;
        $colocation->save();

    }


    public function destroy(Colocation $colocation)
    {
        $colocation->delete();

        return redirect()->route(('user.index'));
    }

      public function removeMember($colocationId, $userId)
    {
        $colocation = Colocation::with('members')->findOrFail($colocationId);
        // $user = Auth::user();


        $colocation->members()->detach($userId);

        return back()->with('success', "Member removed successfully.");
    }

     public function transferOwnership(Request $request, $colocationId)
    {
        $colocation = Colocation::with('members')->findOrFail($colocationId);
        // $user = Auth::user();
        $newOwnerId = $request->input('new_owner_id');
    

        $colocation->owner_id = $newOwnerId;
        $colocation->save();

        return back()->with('success', "Ownership transferred successfully.");
    }

}
