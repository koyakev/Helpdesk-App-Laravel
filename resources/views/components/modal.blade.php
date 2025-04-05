<div x-show="open" x-cloak class="modal-screen">
    <div class="overlay"></div>
    <div class="modal-body" x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform scale-90" x-transition:leave="transition ease-out duration-100" x-transition:leave-end="transform scale-90">
        <div class="modal-close">
            <button @click="open = false">
                <i class="fa fa-times-circle text-green-900" aria-hidden="true"></i>
            </button>
        </div>
        <div class="modal-content">
            {{ $slot }}
        </div>
    </div>
</div>