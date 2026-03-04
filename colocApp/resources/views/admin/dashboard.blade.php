@extends('layouts.app')

@section('content')

<div class="admin-dashboard">

    <h1 class="admin-title">Admin Dashboard</h1>

   
    <div class="admin-stats">
        <div class="stat-card">
            <h3 class="stat-title">Total Users</h3>
            <p class="stat-number">{{ $usersCount }}</p>
        </div>

        <div class="stat-card">
            <h3 class="stat-title">Total Colocations</h3>
            <p class="stat-number">{{ $colocationsCount }}</p>
        </div>

        <div class="stat-card">
            <h3 class="stat-title">Total Expenses</h3>
            <p class="stat-number">{{ $expensesCount }}</p>
        </div>
    </div>

    
    <div class="admin-navigation">
        <h2 class="nav-title">Manage</h2>

        <ul class="admin-links">
            <li class="admin-link-item">
                <a href="{{ route('admin.users') }}" class="admin-link">Manage Users</a>
            </li>

            <li class="admin-link-item">
                <a href="{{ route('admin.colocations') }}" class="admin-link">Manage Colocations</a>
            </li>
        </ul>
    </div>

</div>

@endsection