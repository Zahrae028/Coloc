<nav>
    <a href="/home">Home</a>
    <a href="{{ route('colocation.show') }}">Colocation</a>
    <a href="{{ route('expense.index', $colocation->id) }}">Expenses</a>
    @if(auth()->id() === $colocation->owner_id)
    <a href="/expense/create">Add Expense</a>
    @endif

    @if(auth()->user()?->role === 'admin')
        <a href="/admin">Admin</a>
    @endif

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</nav>