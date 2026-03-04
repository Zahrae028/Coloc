@extends('layouts.app')

@section('content')
<div class="expenses-index container">

    <h2>Expenses for {{ $colocation->name }}</h2>

    @if(auth()->id() === $colocation->owner_id)
        <div class="top-actions">
            <a href="{{ route('expense.create') }}" class="btn-add-expense">
                Add New Expense
            </a>
        </div>

        <div class="add-category-section">
            <h4 class="add-category-title">Add New Category</h4>

            <form action="{{ route('category.store') }}" method="POST" class="form-add-category">
                @csrf
                <input type="hidden" name="colocation_id" value="{{ $colocation->id }}">

                <div class="category-input-group">
                    <input type="text"
                           name="name"
                           class="input-category-name"
                           placeholder="Category name"
                           required>

                    <button type="submit" class="btn-add-category">
                        Add
                    </button>
                </div>
            </form>
        </div>
    @endif


    <table class="expenses-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Amount (€)</th>
                <th>Category</th>
                <th>Payer</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($expenses as $expense)
            <tr class="expense-row">
                <td>
                    <a href="{{ route('expense.show', $expense->id) }}" class="expense-title-link">
                        {{ $expense->title }}
                    </a>
                </td>
                <td>{{ $expense->amount }}</td>
                <td>{{ $expense->category->name }}</td>
                <td>{{ $expense->payer->name }}</td>
                <td class="expense-actions">
                    @if(auth()->id() === $colocation->owner_id)
                        <a href="{{ route('expense.edit', $expense->id) }}" class="btn-edit">Edit</a>

                        <form action="{{ route('expense.destroy', $expense->id) }}"
                              method="POST"
                              class="form-delete-expense"
                              style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete">
                                Delete
                            </button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection