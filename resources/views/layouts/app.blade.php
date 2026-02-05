<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Koperasi Cahaya Gemilang') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="h-full">
    <div class="min-h-full" x-data="{ mobileMenuOpen: false }">
        <nav class="bg-indigo-600 shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <div class="shrink-0">
                            <a href="{{ route('dashboard') }}" class="text-white font-bold text-xl tracking-tight">
                                Koperasi <span class="text-indigo-200">CG</span>
                            </a>
                        </div>
                        <div class="hidden md:block">
                            <div class="ml-10 flex items-baseline space-x-4">
                                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'bg-indigo-700 text-white' : 'text-indigo-100 hover:bg-indigo-500 hover:text-white' }} px-3 py-2 rounded-md text-sm font-medium transition-colors">Dashboard</a>
                                
                                @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'manager', 'kasir']))
                                   <a href="{{ route('members.index') }}" class="{{ request()->routeIs('members.*') ? 'bg-indigo-700 text-white' : 'text-indigo-100 hover:bg-indigo-500 hover:text-white' }} px-3 py-2 rounded-md text-sm font-medium transition-colors">Anggota</a>
                                   <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'bg-indigo-700 text-white' : 'text-indigo-100 hover:bg-indigo-500 hover:text-white' }} px-3 py-2 rounded-md text-sm font-medium transition-colors">Pengguna</a>
                                @endif
   
                                <a href="{{ route('savings.index') }}" class="{{ request()->routeIs('savings.*') ? 'bg-indigo-700 text-white' : 'text-indigo-100 hover:bg-indigo-500 hover:text-white' }} px-3 py-2 rounded-md text-sm font-medium transition-colors">{{ auth()->check() && auth()->user()->role == 'member' ? 'Simpanan Saya' : 'Simpanan' }}</a>
                                <a href="{{ route('loans.index') }}" class="{{ request()->routeIs('loans.*') ? 'bg-indigo-700 text-white' : 'text-indigo-100 hover:bg-indigo-500 hover:text-white' }} px-3 py-2 rounded-md text-sm font-medium transition-colors">{{ auth()->check() && auth()->user()->role == 'member' ? 'Pinjaman Saya' : 'Pinjaman' }}</a>
                                <a href="{{ route('installments.index') }}" class="{{ request()->routeIs('installments.*') ? 'bg-indigo-700 text-white' : 'text-indigo-100 hover:bg-indigo-500 hover:text-white' }} px-3 py-2 rounded-md text-sm font-medium transition-colors">Angsuran</a>
   
                                @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'manager']))
                                   <a href="{{ route('reports.index') }}" class="{{ request()->routeIs('reports.*') ? 'bg-indigo-700 text-white' : 'text-indigo-100 hover:bg-indigo-500 hover:text-white' }} px-3 py-2 rounded-md text-sm font-medium transition-colors">Laporan</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-4 flex items-center md:ml-6">
                            @auth
                                <div class="ml-3 relative" x-data="{ open: false }">
                                    <button @click="open = !open" type="button" class="max-w-xs bg-indigo-600 rounded-full flex items-center text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-indigo-600 focus:ring-white text-white">
                                        <span class="sr-only">Open user menu</span>
                                        <span class="font-medium mr-2">{{ Auth::user()->name }}</span>
                                        <svg class="h-5 w-5 text-indigo-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    
                                    <div x-show="open" @click.away="open = false" style="display: none;" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
                                        <div class="px-4 py-2 border-b">
                                            <p class="text-sm text-gray-500">Masuk sebagai</p>
                                            <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->email }}</p>
                                            <p class="text-xs text-indigo-600 font-semibold uppercase mt-1">{{ Auth::user()->role }}</p>
                                        </div>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Keluar</button>
                                        </form>
                                    </div>
                                </div>
                            @endauth
                        </div>
                    </div>
                    <div class="-mr-2 flex md:hidden">
                        <!-- Mobile menu button -->
                         <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="bg-indigo-600 inline-flex items-center justify-center p-2 rounded-md text-indigo-200 hover:text-white hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-indigo-600 focus:ring-white">
                            <span class="sr-only">Open main menu</span>
                            <svg x-show="!mobileMenuOpen" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <svg x-show="mobileMenuOpen" style="display: none;" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile menu, show/hide based on menu state. -->
            <div x-show="mobileMenuOpen" style="display: none;" class="md:hidden bg-indigo-700">
                <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                     <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'bg-indigo-800 text-white' : 'text-indigo-100 hover:bg-indigo-600 hover:text-white' }} block px-3 py-2 rounded-md text-base font-medium">Dashboard</a>
                    @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'manager', 'kasir']))
                       <a href="{{ route('members.index') }}" class="{{ request()->routeIs('members.*') ? 'bg-indigo-800 text-white' : 'text-indigo-100 hover:bg-indigo-600 hover:text-white' }} block px-3 py-2 rounded-md text-base font-medium">Anggota</a>
                       <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'bg-indigo-800 text-white' : 'text-indigo-100 hover:bg-indigo-600 hover:text-white' }} block px-3 py-2 rounded-md text-base font-medium">Pengguna</a>
                    @endif
                    <a href="{{ route('savings.index') }}" class="{{ request()->routeIs('savings.*') ? 'bg-indigo-800 text-white' : 'text-indigo-100 hover:bg-indigo-600 hover:text-white' }} block px-3 py-2 rounded-md text-base font-medium">Simpanan</a>
                    <a href="{{ route('loans.index') }}" class="{{ request()->routeIs('loans.*') ? 'bg-indigo-800 text-white' : 'text-indigo-100 hover:bg-indigo-600 hover:text-white' }} block px-3 py-2 rounded-md text-base font-medium">Pinjaman</a>
                    <a href="{{ route('installments.index') }}" class="{{ request()->routeIs('installments.*') ? 'bg-indigo-800 text-white' : 'text-indigo-100 hover:bg-indigo-600 hover:text-white' }} block px-3 py-2 rounded-md text-base font-medium">Angsuran</a>
                    @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'manager']))
                       <a href="{{ route('reports.index') }}" class="{{ request()->routeIs('reports.*') ? 'bg-indigo-800 text-white' : 'text-indigo-100 hover:bg-indigo-600 hover:text-white' }} block px-3 py-2 rounded-md text-base font-medium">Laporan</a>
                    @endif
                </div>
                <div class="pt-4 pb-4 border-t border-indigo-800">
                    <div class="flex items-center px-5">
                        <div class="flex-shrink-0">
                             <div class="h-10 w-10 rounded-full bg-indigo-600 flex items-center justify-center border-2 border-indigo-400 text-white font-bold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium leading-none text-white">{{ Auth::user()->name }}</div>
                            <div class="text-sm font-medium leading-none text-indigo-300">{{ Auth::user()->email }}</div>
                        </div>
                    </div>
                    <div class="mt-3 px-2 space-y-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-indigo-100 hover:text-white hover:bg-indigo-600">Keluar</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                @hasSection('header')
                    @yield('header')
                @else
                    <!-- Breadcrumbs or simple title could go here if sections defined checks -->
                @endif
            </div>
        </header>
        <main>
             <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
