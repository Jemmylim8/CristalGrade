<h1>Admin Dashboard</h1>
<p>Welcome, Admin!</p>
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">Logout</button>
</form>