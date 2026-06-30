<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'TaskFlow') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased bg-slate-100 text-slate-900 scroll-smooth">

<style>
    [wire\:loading] [wire\:loading\:target], [wire\:loading\.delay] [wire\:loading\.delay\:target] { display: none; }
    [x-cloak] { display: none !important; }

    /* Livewire Navigation Progress Bar */
    .livewire-progress-bar {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #6366f1, #8b5cf6, #ec4899);
        z-index: 9999;
        transform: translateX(-100%);
        transition: transform 0.1s linear;
    }
    .livewire-progress-bar.active {
        transform: translateX(0%);
    }
    .livewire-progress-bar.complete {
        transform: translateX(0%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
</style>

<div x-data="{ sidebarOpen: false }" class="min-h-screen flex">
    <!-- Mobile Overlay -->
    <div x-show="sidebarOpen"
         @click="sidebarOpen = false"
         x-transition:enter="transition-opacity duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-20 bg-black/60 backdrop-blur-sm lg:hidden"
         style="display: none;">
    </div>

    <!-- Sidebar -->
    <aside x-bind:class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           x-transition:enter="transition-transform duration-300 ease-in-out"
           x-transition:enter-start="-translate-x-full"
           x-transition:enter-end="translate-x-0"
           x-transition:leave="transition-transform duration-200 ease-in-out"
           x-transition:leave-start="translate-x-0"
           x-transition:leave-end="-translate-x-full"
           class="fixed inset-y-0 left-0 z-30 w-64 bg-sidebar-bg flex flex-col lg:translate-x-0 lg:static lg:z-auto lg:transition-none">

        <!-- Logo -->
        <div class="h-16 flex items-center justify-between px-6 border-b border-slate-700/50">
            <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <span class="text-lg font-bold text-white tracking-tight">TaskFlow</span>
            </a>
            <!-- Mobile Close -->
            <button @click="sidebarOpen = false" class="lg:hidden p-1.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-700/50 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
            <a href="{{ route('dashboard') }}" wire:navigate
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-150 group {{ request()->routeIs('dashboard') ? 'bg-indigo-600/20 text-white shadow-sm' : 'text-sidebar-text hover:bg-sidebar-hover hover:text-white' }}">
                <span class="flex items-center justify-center w-5 h-5 mr-3 {{ request()->routeIs('dashboard') ? 'text-indigo-400' : 'text-sidebar-text group-hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </span>
                Dashboard
            </a>

            <a href="{{ route('projects.index') }}" wire:navigate
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-150 group {{ request()->routeIs('projects.*') ? 'bg-indigo-600/20 text-white shadow-sm' : 'text-sidebar-text hover:bg-sidebar-hover hover:text-white' }}">
                <span class="flex items-center justify-center w-5 h-5 mr-3 {{ request()->routeIs('projects.*') ? 'text-indigo-400' : 'text-sidebar-text group-hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                    </svg>
                </span>
                Projects
            </a>

            <a href="{{ route('activity.index') }}" wire:navigate
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-150 group {{ request()->routeIs('activity.*') ? 'bg-indigo-600/20 text-white shadow-sm' : 'text-sidebar-text hover:bg-sidebar-hover hover:text-white' }}">
                <span class="flex items-center justify-center w-5 h-5 mr-3 {{ request()->routeIs('activity.*') ? 'text-indigo-400' : 'text-sidebar-text group-hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
                Activity
            </a>

            @can('users.manage')
            <a href="{{ route('users.index') }}" wire:navigate
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-150 group {{ request()->routeIs('users.*') ? 'bg-indigo-600/20 text-white shadow-sm' : 'text-sidebar-text hover:bg-sidebar-hover hover:text-white' }}">
                <span class="flex items-center justify-center w-5 h-5 mr-3 {{ request()->routeIs('users.*') ? 'text-indigo-400' : 'text-sidebar-text group-hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                    </svg>
                </span>
                Users
            </a>
            @endcan

            <!-- Spacer -->
            <div class="pt-4 mt-4 border-t border-slate-700/50">
                <p class="px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Overview</p>
            </div>

            <div class="px-3 py-2">
                <div class="bg-slate-700/30 rounded-xl p-3">
                    <div class="flex items-center justify-between text-xs text-slate-400 mb-1">
                        <span>Storage</span>
                        <span>45%</span>
                    </div>
                    <div class="w-full h-1.5 bg-slate-700 rounded-full overflow-hidden">
                        <div class="h-full w-[45%] bg-indigo-500 rounded-full"></div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- User Menu -->
        <div class="border-t border-slate-700/50 p-3">
            <x-dropdown align="left" width="56" class="w-full">
                <x-slot name="trigger">
                    <button class="w-full flex items-center px-3 py-2.5 text-sm font-medium text-sidebar-text rounded-xl hover:bg-sidebar-hover hover:text-white transition-all duration-150 group">
                        <span class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold text-sm mr-3 shadow-sm">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </span>
                        <span class="flex-1 text-left truncate">{{ auth()->user()->name }}</span>
                        <svg class="w-4 h-4 text-sidebar-text group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                </x-slot>
                <x-slot name="content">
                    <div class="px-4 py-3 border-b border-slate-100">
                        <p class="text-sm font-medium text-slate-900">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-slate-500 truncate">{{ auth()->user()->email }}</p>
                    </div>
                    <x-dropdown-link :href="route('profile')" wire:navigate class="hover:bg-indigo-50 hover:text-indigo-700">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            {{ __('Profile') }}
                        </div>
                    </x-dropdown-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-start">
                            <x-dropdown-link class="hover:bg-red-50 hover:text-red-700">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    {{ __('Log Out') }}
                                </div>
                            </x-dropdown-link>
                        </button>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0">
        <!-- Top Bar -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 lg:px-8 sticky top-0 z-10">
            <div class="flex items-center">
                <!-- Mobile Hamburger -->
                <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden mr-4 p-2 rounded-lg text-slate-500 hover:bg-slate-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <!-- Breadcrumb placeholder -->
                <h1 class="text-lg font-semibold text-slate-900 hidden sm:block">
                    @yield('page_title', config('app.name', 'TaskFlow'))
                </h1>
            </div>

            <div class="flex items-center space-x-3">
                <!-- Navigation Loading Indicator -->
                <div wire:loading.delay.long class="flex items-center space-x-1.5 text-xs text-indigo-600">
                    <svg class="animate-spin w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Loading...</span>
                </div>

                <!-- Notification Bell -->
                <button class="relative p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full ring-2 ring-white"></span>
                </button>
            </div>
        </header>

        <!-- Flash Messages (auto-dismiss) -->
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)">
            @if (session('message'))
                <div x-show="show" x-transition:enter="transition-all duration-500" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition-all duration-500" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-4"
                     class="mx-4 lg:mx-8 mt-4 px-4 py-3 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-800 text-sm font-medium flex items-center shadow-lg shadow-emerald-200/50">
                    <svg class="w-5 h-5 mr-2 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="flex-1">{{ session('message') }}</span>
                    <button @click="show = false" class="ml-2 text-emerald-500 hover:text-emerald-700 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div x-show="show" x-transition:enter="transition-all duration-500" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition-all duration-500" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-4"
                     class="mx-4 lg:mx-8 mt-4 px-4 py-3 bg-red-50 border border-red-200 rounded-xl text-red-800 text-sm font-medium flex items-center shadow-lg shadow-red-200/50">
                    <svg class="w-5 h-5 mr-2 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="flex-1">{{ session('error') }}</span>
                    <button @click="show = false" class="ml-2 text-red-500 hover:text-red-700 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endif
        </div>

        <!-- Page Content with fade transition on navigation -->
        <main class="flex-1 overflow-y-auto"
              wire:loading.class="opacity-60 pointer-events-none transition-opacity duration-300">
            <div wire:transition.fade.duration.300ms>
                {{ $slot }}
            </div>
        </main>
    </div>
</div>

@livewireScripts
</body>
</html>
