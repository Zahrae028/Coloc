@extends('layouts.app')

@section('content')

<div class="category-edit">

    <h1 class="page-title">Edit Category</h1>

    <form action="{{ route('categories.update', $category->id) }}" method="POST" class="form">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="form-label">Category Name</label>
            <input 
                type="text" 
                name="name" 
                class="form-input" 
                value="{{ $category->name }}" 
                required
            >
        </div>

        <button type="submit" class="submit-button">
            Update
        </button>
    </form>

</div>

@endsection