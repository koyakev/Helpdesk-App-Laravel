<div>
    @php($user = session('user'))

    @if($user->role == 'L4')
        <nav class="h-full bg-black text-white p-2 w-40">
            <a href="{{ route('admin_users') }}" class="block mt-15 m-2 hover:font-bold">Users</a>
            <a href="{{ route('admin_departments') }}" class="block m-2 hover:font-bold">Departments</a>
        </nav>

    @else
        <nav class="h-full bg-black text-white p-2 w-40">
            <a href="#" class="block mt-15 m-2 hover:font-bold">MSRF</a>
            <a href="#" class="block m-2 hover:font-bold">Tracc Concern</a>
            <a href="#" class="block m-2 hover:font-bold">Tracc Request</a>

        </nav>
    @endif
</div>