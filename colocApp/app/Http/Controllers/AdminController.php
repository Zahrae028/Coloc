<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Colocation;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if ($user->role !== 'admin') {
        abort(403, 'Unauthorized');
    }
        $usersCount = User::count();
        $colocationsCount = Colocation::count();
        $expensesCount = Expense::count();
        $colocation = $user->colocations()->first();

 return view('admin.dashboard', compact(
            'usersCount',
            'colocationsCount',
            'expensesCount',
            'colocation'
        ));    }

    public function users()
    {
        $user = auth()->user();
        $colocation = $user->colocations()->first();
        $users = User::latest()->get();
        return view('admin.user', compact('users','colocation'));
    }
public function makeAdmin(User $user)
{
    $authUser = auth()->user();
        if ($authUser->role !== 'admin') {
        abort(403, 'Unauthorized');
    }

    if(auth()->id() === $user->id || $user->role === 'admin'){
        return redirect()->back()->with('error', "Cannot promote this user.");
    }

    $user->role = 'admin';
    $user->save();

    return redirect()->back()->with('success', "$user->name is now an admin!");
}


    public function colocations()
    {
        $colocations = Colocation::latest()->get();

        return view('admin.colocations', compact('colocations'));
    }

    public function destroyUser($id)
    {
        $user = auth()->user();
        if ($user->role !== 'admin') {
        abort(403, 'Unauthorized');
    }

        $usertodelete = User::findOrFail($id);

        $usertodelete->delete();
        return back()->with('success', 'User deleted successfully!');
    }

    public function destroyColocation($id)
    {
        $user = auth()->user();
        if ($user->role !== 'admin') {
        abort(403, 'Unauthorized');
    }
        $colocation = Colocation::findOrFail($id);
        $colocation->delete();
        return back()->with('success', 'Colocation deleted successfully!');
    }
}
