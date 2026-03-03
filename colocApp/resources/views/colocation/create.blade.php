@extends('layouts.app')

@section('content')
<div class="coloc-create">
    <h2>Create Colocation</h2>

    <form action="{{ route('colocation.store') }}" method="POST" class="coloc-form">
        @csrf
        <div class="form-group">
            <label for="name">Colocation Name</label>
            <input type="text" name="name" id="name" class="input-name" placeholder="Enter colocation name">
        </div>

        <button type="submit" class="btn-submit">Create</button>
    </form>
</div>
@endsection