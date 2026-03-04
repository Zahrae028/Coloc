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
        $expenses = $colocation->expenses();

        return view('expense.index', compact('expenses', 'colocation'));

    }

    public function create()
    {
        $user = Auth::user();
        $colocation = $user->colocations()->first();

        $categories = $colocation->categories;
        $members = $colocation->members;

        return view('expense.create', compact('colocation', 'categories', 'members'));
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
        $expense->paid_by= $request->input('paid_by');
        $expense->title = $request->input('title');
        $expense->amount = $request->input('amount');
        $expense->category_id = $request->input('category_id');
        $expense->save();

        // $members = $colocation->members;
        // $membersCount = $members->count();
        // $perMember = $expense->amount / $membersCount;

        // foreach ($members as $member) {
        //     $expense->members()->attach($member->id, [
        //         'share' => $perMember,
        //         'paid' => $member->id === $user->id ? true : false
        //     ]);
        // }

        return redirect()->route('expense.index')->with('success', 'Expense added successfully.');
    }


    public function show($id)
    {
        $expense = Expense::with('members', 'colocation')->findOrFail($id);
        return view('expense.show', compact('expense'));
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

        if ($expense->paid_by != $user->id) {
            abort(403); 
        }

        $expense->update([
            'title' => $request->title,
            'amount' => $request->amount,
            'category_id' => $request->category,
         ]);

        return redirect()->route('expense.index')->with('success', 'Expense updated successfully!');
    }


    public function destroy($id)
    {
        $user = Auth::user();
        $expense = Expense::findOrFail($id);

        if ($expense->paid_by != $user->id) {
            abort(403); // only payer can delete
        }

        $expense->delete();

        return redirect()->route('expense.index')->with('success', 'Expense deleted successfully!');
    }

    public function markPaid($expenseId, $memberId)
    {
        $expense = Expense::findOrFail($expenseId);
        $user = auth()->user(); // currently logged-in user

        if ($expense->colocation->owner_id !== $user->id) {
            abort(403, 'Only the owner can mark payments.');
        }

        if (!$expense->members->contains($memberId)) {
            abort(404, 'Member not found for this expense.');
        }

        $expense->members()->updateExistingPivot($memberId, ['paid' => true]);

        return back()->with('success', 'Payment marked as paid.');
    }
}
