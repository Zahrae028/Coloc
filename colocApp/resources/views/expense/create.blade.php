@extends('layouts.app')

@section('content')
    <div class="expenses-create container">
        @if ($errors->any())
            <div style="color:red;">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
        <h2>Add Expense for {{ $colocation->name }}</h2>

        <form action="{{ route('expense.store') }}" method="POST" class="expense-form">
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
                <label for="payer_id">Paid By</label>
                <select name="paid_by" id="payer_id" class="select-payer">
                    @foreach($members as $member)
                        <option value="{{ $member->id }}">
                            {{ $member->name }}
                        </option>
                    @endforeach
                </select>
            </div>
             
            <div class="form-group">
                <label for="category">Category</label>
                <select name="category_id" id="category" class="select-category">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn-submit">Add Expense</button>
        </form>
    </div>
@endsection