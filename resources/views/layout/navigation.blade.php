<div>
    <nav class="absolute flex justify-between w-full bg-red-700 p-3 text-white">
        <a href="{{ route('dashboard') }}" class="hover:font-bold">Dashboard</a>
        
        <div x-data="{ open: false }">
            <button @click="open = true"><i class="fa fa-user" aria-hidden="true"></i></button>
            <div x-show="open" x-cloak @click.outside="open = false" class="absolute right-0 text-black bg-green-100 rounded m-2 w-18 p-2">
                <div class="flex flex-col">
                    <a href="" class="hover:font-bold">Profile</a>
                    <a href="{{ route('logout') }}" class="hover:font-bold">Logout</a>
                </div>
            </div>
        </div>
    </nav>
</div>