@extends('layouts.app')

@section('content')
<div class="expenses-index">
    <h2>Expenses for {{ $colocation->name }}</h2>
    @if(auth()->id() === $colocation->owner_id)
    <a href="{{ route('expense.create') }}" class="btn-add-expense">Add New Expense</a>
    @endif
    
    <table class="expenses-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Amount (€)</th>
                <th>Date</th>
                <th>Category</th>
                <th>Payer</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($expenses as $expense)
            <tr class="expense-row">
                <td>{{ $expense->title }}</td>
                <td>{{ $expense->amount }}</td>
                <td>{{ $expense->date->format('Y-m-d') }}</td>
                <td>{{ $expense->category->name }}</td>
                <td>{{ $expense->payer->name }}</td>
                <td class="expense-actions">
                    @if(auth()->id() === $colocation->owner_id)
                    <a href="{{ route('expense.edit', $expense->id) }}" class="btn-edit">Edit</a>
                
                    <form action="{{ route('expense.destroy', $expense->id) }}" method="POST" class="form-delete-expense" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete">Delete</button>
                    </form>

                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection