@extends('layouts.app')

@section('content')

<div class="category-index">

    <h1 class="page-title">Categories</h1>

    <a href="{{ route('categories.create') }}" class="create-link">
        Create New Category
    </a>

    <ul class="category-list">
        @foreach($categories as $category)
            <li class="category-item">
                <span class="category-name">{{ $category->name }}</span>

                <a href="{{ route('categories.edit', $category->id) }}" class="edit-link">
                    Edit
                </a>
            </li>
        @endforeach
    </ul>

</div>

@endsection