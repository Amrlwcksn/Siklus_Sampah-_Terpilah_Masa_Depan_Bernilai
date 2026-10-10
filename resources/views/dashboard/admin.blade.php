@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-heading', 'Ringkasan Dashboard')

@section('content')
    <div class="mb-7">
        <p class="text-sm text-slate-500">
            Selamat datang kembali, {{ auth()->user()->name }}.
        </p>
        <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">
            Pantau operasional Siklus
        </h2>
        <p class="mt-2 text-sm text-slate-500">
            Ringkasan pelanggan, langganan, tagihan, dan jadwal penjemputan.
        </p>
    </div>

    {{-- Kartu statistik --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Pelanggan</p>
                    <p class="mt-3 text-3xl font-bold text-slate-900">
                        {{ number_format($stats['total_pelanggan'], 0, ',', '.') }}
                    </p>
                </div>
                <div class="rounded-xl bg-emerald-50 px-3 py-2 text-xl text-emerald-700">♙</div>
            </div>
            <p class="mt-4 text-xs text-slate-400">Akun dengan peran pelanggan</p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Petugas</p>
                    <p class="mt-3 text-3xl font-bold text-slate-900">
                        {{ number_format($stats['total_petugas'], 0, ',', '.') }}
                    </p>
                </div>
                <div class="rounded-xl bg-sky-50 px-3 py-2 text-xl text-sky-700">♧</div>
            </div>
            <p class="mt-4 text-xs text-slate-400">Akun petugas terdaftar</p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Langganan Aktif</p>
                    <p class="mt-3 text-3xl font-bold text-slate-900">
                        {{ number_format($stats['langganan_aktif'], 0, ',', '.') }}
                    </p>
                </div>
                <div class="rounded-xl bg-emerald-50 px-3 py-2 text-xl text-emerald-700">↻</div>
            </div>
            <p class="mt-4 text-xs text-slate-400">Status langganan active</p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Tagihan Belum Dibayar</p>
                    <p class="mt-3 text-3xl font-bold text-slate-900">
                        {{ number_format($stats['tagihan_belum_bayar'], 0, ',', '.') }}
                    </p>
                </div>
                <div class="rounded-xl bg-amber-50 px-3 py-2 text-xl text-amber-700">▤</div>
            </div>
            <p class="mt-4 text-xs text-slate-400">Tagihan dengan status unpaid</p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Penjemputan Hari Ini</p>
                    <p class="mt-3 text-3xl font-bold text-slate-900">
                        {{ number_format($stats['penjemputan_hari_ini'], 0, ',', '.') }}
                    </p>
                </div>
                <div class="rounded-xl bg-violet-50 px-3 py-2 text-xl text-violet-700">◷</div>
            </div>
            <p class="mt-4 text-xs text-slate-400">Jadwal berdasarkan tanggal hari ini</p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Tagihan Terbayar</p>
                    <p class="mt-3 text-2xl font-bold text-slate-900">
                        Rp{{ number_format($stats['total_pendapatan'], 0, ',', '.') }}
                    </p>
                </div>
                <div class="rounded-xl bg-teal-50 px-3 py-2 text-xl text-teal-700">Rp</div>
            </div>
            <p class="mt-4 text-xs text-slate-400">Akumulasi invoice berstatus paid</p>
        </div>
    </div>

    {{-- Jadwal penjemputan terbaru --}}
    <section class="mt-8 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 px-5 py-5 md:px-6">
            <div>
                <h3 class="font-bold text-slate-900">Jadwal Penjemputan Terbaru</h3>
                <p class="mt-1 text-sm text-slate-500">Enam jadwal terakhir yang tercatat.</p>
            </div>
            <span class="rounded-lg bg-emerald-50 px-3 py-2 text-xs font-semibold text-emerald-700">
                {{ $jadwalTerbaru->count() }} jadwal
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[720px] text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                    <tr>
                        <a href="{{ route('admin.customers.index') }}"
                        class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm transition
                        {{ request()->routeIs('admin.customers.*')
                                ? 'bg-emerald-800 font-medium text-white'
                                : 'text-emerald-100/80 hover:bg-white/10 hover:text-white' }}">
                            <span class="text-lg">♙</span>
                            Pelanggan
                        </a>
                        <th class="px-6 py-4 font-semibold">Tanggal Penjemputan</th>
                        <th class="px-6 py-4 font-semibold">Petugas</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($jadwalTerbaru as $jadwal)
                        @php
                            $statusClass = match ($jadwal->status) {
                                'completed' => 'bg-emerald-50 text-emerald-700',
                                'in_progress' => 'bg-sky-50 text-sky-700',
                                'assigned' => 'bg-violet-50 text-violet-700',
                                'failed' => 'bg-rose-50 text-rose-700',
                                'skipped' => 'bg-slate-100 text-slate-600',
                                default => 'bg-amber-50 text-amber-700',
                            };

                            $statusLabel = match ($jadwal->status) {
                                'in_progress' => 'Sedang Berjalan',
                                'completed' => 'Selesai',
                                'assigned' => 'Ditugaskan',
                                'scheduled' => 'Terjadwal',
                                'skipped' => 'Dilewati',
                                'failed' => 'Gagal',
                                default => ucfirst($jadwal->status),
                            };
                        @endphp
                        <tr class="transition hover:bg-slate-50/70">
                            <td class="px-6 py-4">
                                <p class="font-semibold text-slate-800">
                                    {{ $jadwal->subscription?->user?->name ?? 'Pelanggan tidak ditemukan' }}
                                </p>
                                <p class="mt-1 text-xs text-slate-400">
                                    Jadwal #{{ $jadwal->id }}
                                </p>
                            </td>
                            <td class="px-6 py-4 text-slate-600">
                                {{ $jadwal->scheduled_for?->translatedFormat('d M Y, H:i') ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-slate-600">
                                {{ $jadwal->assignedUser?->name ?? 'Belum ditugaskan' }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex rounded-full px-3 py-1.5 text-xs font-semibold {{ $statusClass }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <p class="font-medium text-slate-600">Belum ada jadwal penjemputan</p>
                                <p class="mt-1 text-sm text-slate-400">
                                    Jadwal yang dibuat akan muncul di bagian ini.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    {{-- Langganan terbaru --}}
    <section class="mt-6 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-5 py-5 md:px-6">
            <h3 class="font-bold text-slate-900">Langganan Terbaru</h3>
            <p class="mt-1 text-sm text-slate-500">Lima langganan terakhir yang dibuat.</p>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse ($langgananTerbaru as $langganan)
                @php
                    $subscriptionClass = match ($langganan->status) {
                        'active' => 'bg-emerald-50 text-emerald-700',
                        'past_due' => 'bg-amber-50 text-amber-700',
                        'suspended' => 'bg-rose-50 text-rose-700',
                        'cancelled' => 'bg-slate-100 text-slate-600',
                        default => 'bg-sky-50 text-sky-700',
                    };

                    $subscriptionLabel = match ($langganan->status) {
                        'pending_payment' => 'Menunggu Pembayaran',
                        'past_due' => 'Terlambat',
                        'suspended' => 'Ditangguhkan',
                        'cancelled' => 'Dibatalkan',
                        'active' => 'Aktif',
                        default => ucfirst($langganan->status),
                    };
                @endphp

                <div class="flex flex-wrap items-center justify-between gap-3 px-5 py-4 md:px-6">
                    <div class="flex min-w-0 items-center gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-emerald-50 font-semibold text-emerald-700">
                            {{ strtoupper(substr($langganan->user?->name ?? '?', 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <p class="truncate text-sm font-semibold text-slate-800">
                                {{ $langganan->user?->name ?? 'Pengguna tidak ditemukan' }}
                            </p>
                            <p class="mt-1 text-xs text-slate-500">
                                Dibuat {{ $langganan->created_at?->translatedFormat('d M Y') ?? '-' }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <span class="text-sm font-semibold text-slate-700">
                            Rp{{ number_format($langganan->monthly_fee, 0, ',', '.') }}/bln
                        </span>
                        <span class="rounded-full px-3 py-1.5 text-xs font-semibold {{ $subscriptionClass }}">
                            {{ $subscriptionLabel }}
                        </span>
                    </div>
                </div>
            @empty
                <p class="px-6 py-10 text-center text-sm text-slate-500">
                    Belum ada data langganan.
                </p>
            @endforelse
        </div>
    </section>
@endsection