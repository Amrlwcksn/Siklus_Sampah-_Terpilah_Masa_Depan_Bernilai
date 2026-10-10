<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><title>@yield('title', 'Dashboard Admin') — Siklus</title></title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 text-slate-800 antialiased">
    <div class="min-h-screen md:flex">

        {{-- Sidebar --}}
        <aside class="flex w-full flex-col bg-emerald-950 text-white md:min-h-screen md:w-64 md:shrink-0">
            <div class="border-b border-white/10 px-6 py-6">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-400 font-bold text-emerald-950">
                        BS
                    </div>
                    <div>
                        <p class="text-sm font-semibold tracking-wide">Siklus</p>
                        <p class="mt-1 text-xs text-emerald-200">Sistem Berlangganan</p>
                    </div>
                </div>
            </div>

            <nav class="flex-1 space-y-2 px-4 py-6">
                <p class="mb-3 px-3 text-xs font-semibold uppercase tracking-widest text-emerald-300">
                    Menu Utama
                </p>

                <a href="{{ route('dashboard.admin') }}"
                   class="flex items-center gap-3 rounded-xl bg-emerald-800 px-4 py-3 text-sm font-medium text-white">
                    <span class="text-lg">▦</span>
                    Dashboard
                </a>

                <a href="{{ route('admin.customers.index') }}"
                    class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm transition
                    {{ request()->routeIs('admin.customers.*')
                            ? 'bg-emerald-800 font-medium text-white'
                            : 'text-emerald-100/80 hover:bg-white/10 hover:text-white' }}">
                    <span class="text-lg">♙</span>
                    Pelanggan
                </a>

                <div class="flex items-center justify-between rounded-xl px-4 py-3 text-sm text-emerald-100/80">
                    <span class="flex items-center gap-3"><span class="text-lg">↻</span> Langganan</span>
                    <span class="rounded-md bg-white/10 px-2 py-1 text-xs">Segera</span>
                </div>

                <div class="flex items-center justify-between rounded-xl px-4 py-3 text-sm text-emerald-100/80">
                    <span class="flex items-center gap-3"><span class="text-lg">▤</span> Tagihan</span>
                    <span class="rounded-md bg-white/10 px-2 py-1 text-xs">Segera</span>
                </div>

                <div class="flex items-center justify-between rounded-xl px-4 py-3 text-sm text-emerald-100/80">
                    <span class="flex items-center gap-3"><span class="text-lg">♧</span> Penjemputan</span>
                    <span class="rounded-md bg-white/10 px-2 py-1 text-xs">Segera</span>
                </div>
            </nav>

            <div class="border-t border-white/10 p-4">
                <div class="mb-4 rounded-xl bg-white/5 p-4">
                    <p class="text-xs text-emerald-200">Login sebagai</p>
                    <p class="mt-1 truncate text-sm font-semibold">{{ auth()->user()->name }}</p>
                    <p class="mt-1 text-xs capitalize text-emerald-200">Administrator</p>
                </div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full rounded-xl border border-white/15 px-4 py-3 text-left text-sm text-emerald-50 transition hover:bg-white/10">
                        ↪ Keluar
                    </button>
                </form>
            </div>
        </aside>

        {{-- Konten --}}
        <main class="min-w-0 flex-1">
            <header class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-200 bg-white px-5 py-5 md:px-8">
                <div>
                    <p class="text-sm text-slate-500">Panel Administrator</p>
                    <h1 class="mt-1 text-xl font-bold tracking-tight text-slate-900">
                        @yield('page-heading', 'Dashboard')
                    </h1>
                </div>
                <div class="rounded-xl border border-slate-200 px-4 py-2">
                    <p class="text-xs text-slate-500">Hari ini</p>
                    <p class="mt-1 text-sm font-semibold">{{ now()->translatedFormat('d M Y') }}</p>
                </div>
            </header>

            <div class="p-5 md:p-8">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
