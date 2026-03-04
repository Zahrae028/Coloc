<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $colocation = $user->colocations()->first();

        $categories = $colocation->categories;

        return view('category.index', compact('categories', 'colocation'));
    }

    public function create()
    {
        $user = Auth::user();
        $colocation = $user->colocations()->first();

        if ($user->id != $colocation->owner_id) {
            abort(403);
        }

        return view('category.create', compact('colocation'));
    }

    public function store(CategoryRequest $request)
    {
        $user = Auth::user();
        $colocation = $user->colocations()->first();

        if ($user->id != $colocation->owner_id) {
            abort(403);
        }

        $colocation->categories()->create([
            'name' => $request->name,
        ]);

        return back()->with('success', 'Category created successfully.');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $user = Auth::user();

        if ($user->id != $category->colocation->owner_id) {
            abort(403);
        }

        return view('category.edit', compact('category'));
    }

    public function update(CategoryRequest $request, $id)
    {
        $category = Category::findOrFail($id);
        $user = Auth::user();

        if ($user->id != $category->colocation->owner_id) {
            abort(403);
        }

        $category->name = $request->name;
        $category->save();

        return redirect()->route('category.index')->with('success', 'Category updated successfully.');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $user = Auth::user();

        if ($user->id != $category->colocation->owner_id) {
            abort(403);
        }

        $category->delete();

        return redirect()->route('category.index')->with('success', 'Category deleted successfully.');
    }
}