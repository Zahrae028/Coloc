<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseRequest;
use App\Models\Category;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    
    public function index()
    {
        $user = Auth::user();
        $colocation = $user->colocations()->first();
        $expenses = $user->expenses();

        return view ('expense.index', compact('expenses','colocation'));
        
    }

    public function create()
    {
            $colocation = Auth::user()->colocations()->first();
            $categories = Category::all() ;
            return view('expense.create',compact('colocation','categories'));
    }

    public function store(ExpenseRequest $request)
    {       
        $user = Auth::user();
        $colocation = $user->colocations()->first();
        // 'colocation_id',
        // 'title',
        // 'amount',
        // 'date',
        // 'category_id',
        // 'payer_id',

        $expense = new Expense();
        $expense->colocation_id = $colocation->id;
        $expense->payer_id = $user->id;
        $expense->title = $request->input('title');
        $expense->amount = $request->input('amount');
        $expense->category_id = $request->input('category');
        $expense->date = $request->input('date');

        $expense->save();
    }

   
    public function show(string $id)
    {
        //
    }

    public function edit($id)
{
    $expense = Expense::findOrFail($id);
    $colocation = $expense->colocation;
    $categories = Category::where('colocation_id', $colocation->id)->get();

    return view('expense.edit', compact('expense', 'colocation', 'categories'));
}
    
    public function update(ExpenseRequest $request, $id)
{
    $user = Auth::user();
    $expense = Expense::findOrFail($id);

    if ($expense->payer_id != $user->id) {
        abort(403); // only the payer can update
    }

    $expense->update([
        'title' => $request->title,
        'amount' => $request->amount,
        'category_id' => $request->category,
        'date' => $request->date,
    ]);

    return redirect()->route('expense.index')->with('success', 'Expense updated successfully!');
}

    
    public function destroy($id)
{
    $user = Auth::user();
    $expense = Expense::findOrFail($id);

    if ($expense->payer_id != $user->id) {
        abort(403); // only payer can delete
    }

    $expense->delete();

    return redirect()->route('expense.index')->with('success', 'Expense deleted successfully!');
}
}
