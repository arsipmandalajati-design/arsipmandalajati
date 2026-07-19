<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">

    <!-- Navbar Atas -->
    <div class="fixed top-0 left-64 right-0 bg-white border-b h-16 z-40">

        <div class="flex justify-between items-center h-full px-6">

            <!-- Kiri -->
            <div class="flex items-center gap-4">

                <!-- Logo -->
                <a href="{{ route('dashboard') }}">
                    <x-application-logo
                        class="block h-9 w-auto fill-current text-gray-800" />
                </a>

                <h1 class="text-xl font-bold text-gray-800">
                    E - ARSIP
                </h1>

            </div>

            <!-- Profile -->
            <div class="hidden sm:flex sm:items-center">

                <x-dropdown align="right" width="48">

                    <x-slot name="trigger">

                        <button class="inline-flex items-center px-3 py-2 border border-transparent
                            text-sm leading-4 font-medium rounded-md text-gray-500
                            bg-white hover:text-gray-700 focus:outline-none transition">

                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">

                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586
                                        l3.293-3.293a1 1 0 111.414 1.414
                                        l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0
                                        010-1.414z"
                                        clip-rule="evenodd" />

                                </svg>
                            </div>

                        </button>

                    </x-slot>

                    <x-slot name="content">

                        <x-dropdown-link :href="route('profile.edit')">
                            Profile
                        </x-dropdown-link>

                        <form method="POST"
                            action="{{ route('logout') }}">

                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                this.closest('form').submit();">

                                Log Out

                            </x-dropdown-link>

                        </form>

                    </x-slot>

                </x-dropdown>

            </div>

        </div>

    </div>

    <!-- Sidebar -->
    <div class="fixed top-0 left-0 w-64 h-screen bg-white border-r border-gray-200 z-50">

        <div class="h-16 flex items-center px-6 border-b border-gray-200">

            <h2 class="text-2xl font-bold text-black">
                Menu
            </h2>

        </div>

        <!-- Menu -->
<div class="mt-20 px-4 flex flex-col justify-between h-[calc(100vh-120px)]">

    <!-- Menu Atas -->
    <div class="space-y-3">

        <a href="{{ route('dashboard') }}"
            class="block px-4 py-3 text-black border-b border-gray-200 hover:bg-gray-100 rounded-lg">
            Dashboard
        </a>

        <a href="{{ route('users.index') }}"
            class="block px-4 py-3 text-black border-b border-gray-200 hover:bg-gray-100 rounded-lg">
            Data User
        </a>

        <a href="#"
            class="block px-4 py-3 text-black border-b border-gray-200 hover:bg-gray-100 rounded-lg">
            Data Pejabat
        </a>

        <a href="{{ route('suratmasuk.index') }}"
            class="block px-4 py-3 text-black border-b border-gray-200 hover:bg-gray-100 rounded-lg">
            Surat Masuk
        </a>

        <a href="{{ route('suratkeluar.index') }}"
            class="block px-4 py-3 text-black border-b border-gray-200 hover:bg-gray-100 rounded-lg">
            Surat Keluar
        </a>

        <a href="{{ route('arsip.index') }}"
            class="block px-4 py-3 text-black border-b border-gray-200 hover:bg-gray-100 rounded-lg">
            Arsip
        </a>

        <a href="{{ route('laporan.index') }}"
            class="block px-4 py-3 text-black border-b border-gray-200 hover:bg-gray-100 rounded-lg">
            Laporan
        </a>

    </div>

    <!-- Profil + Logout -->
    <div class="border-t pt-4">

        <div class="flex items-center gap-3 mb-4">

            <div class="w-12 h-12 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-lg">

                {{ strtoupper(substr(Auth::user()->name,0,1)) }}

            </div>

            <div>

                <div class="font-semibold">
                    {{ Auth::user()->name }}
                </div>

                <div class="text-green-600 text-sm">
                    ● Online
                </div>

            </div>

        </div>

        <form id="logoutForm"
              method="POST"
              action="{{ route('logout') }}">

            @csrf

            <button type="button"
                    onclick="logoutConfirm()"
                    class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded-lg">

                🚪 Logout

            </button>

        </form>

    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

function logoutConfirm(){

    Swal.fire({

        title:'Logout',

        text:'Apakah Anda yakin ingin keluar dari Arsipedia?',

        icon:'question',

        showCancelButton:true,

        confirmButtonText:'Ya, Logout',

        cancelButtonText:'Batal',

        confirmButtonColor:'#2563eb',

        cancelButtonColor:'#dc2626'

    }).then((result)=>{

        if(result.isConfirmed){

            document.getElementById('logoutForm').submit();

        }

    });

}

</script>
</nav>