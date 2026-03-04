@extends('layouts.app')

@section('content')
<div class="container">
    <h2>All Colocations</h2>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Owner</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($colocations as $colocation)
            <tr>
                <td>{{ $colocation->id }}</td>
                <td>{{ $colocation->name }}</td>
                <td>{{ $colocation->owner->name ?? 'N/A' }}</td>
                <td>{{ $colocation->status }}</td>
                <td>{{ $colocation->created_at }}</td>
                <td class="d-flex gap-2">
                    <!-- Delete button -->
                    <form action="{{ route('admin.colocations.destroy', $colocation->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection