@extends('layouts.app')

@section('content')
<div class="expenses-edit">
    <h2>Edit Expense for {{ $colocation->name }}</h2>

    <form action="{{ route('expenses.update', $expense->id) }}" method="POST" class="expense-edit-form">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="input-title" value="{{ $expense->title }}">
        </div>

        <div class="form-group">
            <label for="amount">Amount (€)</label>
            <input type="number" step="0.01" name="amount" id="amount" class="input-amount" value="{{ $expense->amount }}">
        </div>

        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" name="date" id="date" class="input-date" value="{{ $expense->date->format('Y-m-d') }}">
        </div>

        <div class="form-group">
            <label for="category">Category</label>
            <select name="category" id="category" class="select-category">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" 
                        @if($category->id == $expense->category_id) selected @endif>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn-submit">Update Expense</button>
    </form>
</div>
@endsection