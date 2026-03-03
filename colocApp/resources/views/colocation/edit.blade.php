@extends('layouts.app')

@section('content')
<div class="coloc-edit">
    <h2>Edit Colocation</h2>

    <form action="{{ route('colocation.update', $colocation->id) }}" method="POST" class="coloc-edit-form">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Colocation Name</label>
            <input type="text" name="name" id="name" class="input-name" value="{{ $colocation->name }}">
        </div>

        <div class="form-group">
            <label for="owner">Owner</label>
            <select name="owner" id="owner" class="select-owner">
                @foreach($members as $member)
                    <option value="{{ $member->id }}" {{ $colocation->owner_id == $member->id ? 'selected' : '' }}>
                        {{ $member->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="select-status">
                <option value="active" {{ $colocation->status == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $colocation->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <button type="submit" class="btn-submit">Save Changes</button>
    </form>
</div>
@endsection