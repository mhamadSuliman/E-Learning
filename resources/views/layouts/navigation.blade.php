<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">

    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- Left Side -->
            <div class="flex">

                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="url(Auth::user()->dashboardRoute())">
                        Dashboard
                    </x-nav-link>

                  <x-nav-link href="{{ url('/admin/courses') }}">
    Courses
</x-nav-link>
 <x-nav-link href="{{ url('/users') }}">
    Users
</x-nav-link>
<x-nav-link href="{{ url('/notifications') }}">
    🔔 Notifications

    @if(auth()->user()->unreadNotifications->count())
        <span class="bg-red-500 text-white px-2 py-1 text-xs rounded-full">
            {{ auth()->user()->unreadNotifications->count() }}
        </span>
    @endif
</x-nav-link>
 </div>

                 
               


            </div>


           
            <!-- Right Side -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">

                <!-- Dropdown -->
                <div class="relative inline-block text-left group focus-within">

                    <!-- Button -->
                    <button type="button"
                            class="inline-flex items-center px-3 py-2 text-sm text-gray-700 hover:text-gray-900 focus:outline-none">

                        {{ Auth::user()->name }}

                        <svg class="ml-1 h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                  clip-rule="evenodd" />
                        </svg>

                    </button>

                    <!-- Dropdown Menu -->
                    <div class="absolute right-0 mt-2 w-48 bg-white border rounded shadow-lg z-50
                                opacity-0 invisible
                                group-hover:opacity-100 group-hover:visible
                                group-focus-within:opacity-100 group-focus-within:visible
                                transition">

                        <!-- Profile -->
                        <a href="{{ route('profile.edit') }}"
                           class="block px-4 py-2 text-sm hover:bg-gray-100">
                            Profile
                        </a>

                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100">
                                Log Out
                            </button>
                        </form>

                    </div>
                </div>

            </div>

            <!-- Mobile Button -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100">
                    ☰
                </button>
            </div>

        </div>
    </div>

</nav>