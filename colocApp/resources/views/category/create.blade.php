@extends('layouts.app')

@section('content')

<div class="category-create">

    <h1 class="page-title">Create Category</h1>

    <form action="{{ route('categories.store') }}" method="POST" class="form">
        @csrf

        <div class="form-group">
            <label class="form-label">Category Name</label>
            <input type="text" name="name" class="form-input" required>
        </div>

        <button type="submit" class="submit-button">
            Create
        </button>
    </form>

</div>

@endsection