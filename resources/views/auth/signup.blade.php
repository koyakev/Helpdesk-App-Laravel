<div>
    <p>Signup</p>
    @if(session('message'))
        <p>{{ session('message') }}</p>
    @endif
    <form method="POST" action="{{ route('signup') }}">
        @csrf
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="password" placeholder="Password">
        <input type="password" name="c_password" placeholder="Confirm Password">
        <select name="department">
            <option selected disabled>Select Department</option>
            @foreach($departments as $department)
                <option value={{ $department->id }}>{{ $department->department_description }}</option>
            @endforeach
        </select>
        <input type="text" name="position" placeholder="Position">
        <button>Signup</button>
    </form>
    <a href="{{ route('login_form') }}">Login</a>
</div>
