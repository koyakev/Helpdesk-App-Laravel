<div>
    @php($user = session('user')[0])

    @if($user->role == 'L4')
        <nav class="h-screen bg-black text-white p-2 w-40">
            <a href="{{ route('admin_users') }}" class="block m-2 hover:font-bold">Users</a>
            <a href="{{ route('admin_departments') }}" class="block m-2 hover:font-bold">Departments</a>
        </nav>
    @else

        <nav>
            <a href="{{ route('logout') }}">Logout</a>
        </nav>

    @endif
</div>