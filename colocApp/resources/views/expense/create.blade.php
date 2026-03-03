@extends('layouts.app')

@section('content')
<div class="expenses-create">
    <h2>Add Expense for {{ $colocation->name }}</h2>

    <form action="{{ route('expense.store', $colocation->id) }}" method="POST" class="expense-form">
        @csrf

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="input-title" placeholder="Enter expense title">
        </div>

        <div class="form-group">
            <label for="amount">Amount (€)</label>
            <input type="number" step="0.01" name="amount" id="amount" class="input-amount" placeholder="Enter amount">
        </div>

        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" name="date" id="date" class="input-date">
        </div>

        <div class="form-group">
            <label for="category">Category</label>
            <select name="category" id="category" class="select-category">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn-submit">Add Expense</button>
    </form>
</div>
@endsection