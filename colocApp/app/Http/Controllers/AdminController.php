<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Colocation;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
        public function index(){

            $users = User::count();
            $colocations = Colocation::count();
            $categories = Category::count();
            
            return view('admin.dashboard',compact('users','colocations','categories'));
        }

        public function users(){
            $users = User::latest()->get();
            return view('admin.user',compact('users'));
        }

        public function deleteUser($id){
            $user = User::findOrFail($id);
            $user->delete();
            return back()->with('success','User deleted successfully!');
        }

        public function colocations(){
            $colocations = Colocation::latest()->get();

            return view('admin.colocations',compact('colocations'));
        }

        public function deleteColocation($id){
            $colocation = Colocation::findOrFail($id);
            $colocation->delete();
            return back()->with('success','Colocation deleted successfully!');
        }
        
}
