@extends('layouts.admin')

@section('title', 'Manajemen Pelanggan')
@section('page-heading', 'Manajemen Pelanggan')

@section('content')
    {{-- Header halaman --}}
    <div class="mb-7 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
        <div>
            <p class="text-sm text-slate-500">Data dan informasi pelanggan</p>
            <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">
                Daftar Pelanggan
            </h2>
            <p class="mt-2 text-sm text-slate-500">
                Kelola pelanggan yang terdaftar di layanan Siklus.
            </p>
        </div>
    </div>

    {{-- Ringkasan --}}
    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Total Pelanggan</p>
            <p class="mt-3 text-3xl font-bold text-slate-900">
                {{ number_format($totalPelanggan, 0, ',', '.') }}
            </p>
            <p class="mt-2 text-xs text-slate-400">Seluruh akun dengan peran pelanggan</p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Langganan Aktif</p>
            <p class="mt-3 text-3xl font-bold text-emerald-700">
                {{ number_format($langgananAktif, 0, ',', '.') }}
            </p>
            <p class="mt-2 text-xs text-slate-400">Pelanggan dengan langganan berstatus aktif</p>
        </div>
    </div>

    {{-- Tabel pelanggan --}}
    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="flex flex-col gap-4 border-b border-slate-100 p-5 md:flex-row md:items-center md:justify-between md:px-6">
            <div>
                <h3 class="font-bold text-slate-900">Semua Pelanggan</h3>
                <p class="mt-1 text-sm text-slate-500">
                    Menampilkan {{ $pelanggan->firstItem() ?? 0 }}–{{ $pelanggan->lastItem() ?? 0 }}
                    dari {{ $pelanggan->total() }} pelanggan yang cocok.
                </p>
            </div>

            <form action="{{ route('admin.customers.index') }}" method="GET"
                  class="flex w-full flex-col gap-2 sm:flex-row md:w-auto">
                <div class="relative flex-1 md:w-72">
                    <input
                        type="search"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Cari nama, email, telepon..."
                        aria-label="Cari pelanggan"
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-emerald-600 focus:bg-white focus:ring-4 focus:ring-emerald-600/10"
                    >
                </div>

                <button type="submit"
                    class="rounded-xl bg-emerald-800 px-5 py-3 text-sm font-semibold text-white transition hover:bg-emerald-900">
                    Cari
                </button>

                @if ($search !== '')
                    <a href="{{ route('admin.customers.index') }}"
                       class="rounded-xl border border-slate-200 px-4 py-3 text-center text-sm font-medium text-slate-600 transition hover:bg-slate-50">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[900px] text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Pelanggan</th>
                        <th class="px-6 py-4 font-semibold">Nomor Telepon</th>
                        <th class="px-6 py-4 font-semibold">Alamat Tersimpan</th>
                        <th class="px-6 py-4 font-semibold">Status Langganan</th>
                        <th class="px-6 py-4 font-semibold">Biaya / Bulan</th>
                        <th class="px-6 py-4 font-semibold">Terdaftar</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse ($pelanggan as $item)
                        @php
                            $statusLangganan = $item->subscription?->status;

                            $badgeClass = match ($statusLangganan) {
                                'active' => 'bg-emerald-50 text-emerald-700',
                                'past_due' => 'bg-amber-50 text-amber-700',
                                'suspended' => 'bg-rose-50 text-rose-700',
                                'cancelled' => 'bg-slate-100 text-slate-600',
                                'pending_payment' => 'bg-sky-50 text-sky-700',
                                default => 'bg-slate-100 text-slate-600',
                            };

                            $statusLabel = match ($statusLangganan) {
                                'active' => 'Aktif',
                                'pending_payment' => 'Menunggu Pembayaran',
                                'past_due' => 'Terlambat',
                                'suspended' => 'Ditangguhkan',
                                'cancelled' => 'Dibatalkan',
                                default => 'Belum Berlangganan',
                            };
                        @endphp

                        <tr class="transition hover:bg-slate-50/70">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-emerald-50 font-bold text-emerald-800">
                                        {{ strtoupper(substr($item->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-slate-800">
                                            {{ $item->name }}
                                        </p>
                                        <p class="mt-1 text-xs text-slate-500">
                                            {{ $item->email }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-slate-600">
                                {{ $item->phone ?: '-' }}
                            </td>

                            <td class="px-6 py-4">
                                <span class="text-slate-700">
                                    {{ $item->addresses_count }}
                                </span>
                                <span class="text-slate-500">
                                    alamat
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                <span class="inline-flex rounded-full px-3 py-1.5 text-xs font-semibold {{ $badgeClass }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>

                            <td class="px-6 py-4 font-medium text-slate-700">
                                @if ($item->subscription)
                                    Rp{{ number_format($item->subscription->monthly_fee, 0, ',', '.') }}
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-slate-500">
                                {{ $item->created_at?->translatedFormat('d M Y') ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-14 text-center">
                                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                                    <span class="text-2xl">⌕</span>
                                </div>
                                <p class="mt-4 font-semibold text-slate-700">
                                    {{ $search !== '' ? 'Pelanggan tidak ditemukan' : 'Belum ada pelanggan' }}
                                </p>
                                <p class="mt-1 text-sm text-slate-500">
                                    {{ $search !== '' ? 'Coba gunakan nama, email, atau nomor telepon yang berbeda.' : 'Data pelanggan akan muncul di sini setelah tersedia.' }}
                                </p>
                                @if ($search !== '')
                                    <a href="{{ route('admin.customers.index') }}"
                                       class="mt-4 inline-flex text-sm font-semibold text-emerald-700 hover:text-emerald-900">
                                        Tampilkan semua pelanggan
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($pelanggan->hasPages())
            <div class="border-t border-slate-100 px-5 py-4 md:px-6">
                {{ $pelanggan->links() }}
            </div>
        @endif
    </section>
@endsection
