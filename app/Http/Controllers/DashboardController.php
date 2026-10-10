<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\PickupSchedule;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function admin(Request $request): View
    {
        abort_unless($request->user()->role === 'admin', 403);

        $stats = [
            'total_pelanggan' => User::where('role', 'user')->count(),

            'total_petugas' => User::where('role', 'petugas')->count(),

            'langganan_aktif' => Subscription::where(
                'status',
                'active'
            )->count(),

            'tagihan_belum_bayar' => Invoice::where(
                'status',
                'unpaid'
            )->count(),

            'penjemputan_hari_ini' => PickupSchedule::whereDate(
                'scheduled_for',
                today()
            )->count(),

            'total_pendapatan' => Invoice::where(
                'status',
                'paid'
            )->sum('amount'),
        ];

        $jadwalTerbaru = PickupSchedule::with([
            'subscription.user',
            'assignedUser',
        ])
            ->orderByDesc('scheduled_for')
            ->limit(6)
            ->get();

        $langgananTerbaru = Subscription::with('user')
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard.admin', compact(
            'stats',
            'jadwalTerbaru',
            'langgananTerbaru'
        ));
    }

    public function pelanggan(Request $request): View
    {
        abort_unless($request->user()->role === 'user', 403);

        return view('dashboard.pelanggan');
    }

    public function petugas(Request $request): View
    {
        abort_unless($request->user()->role === 'petugas', 403);

        return view('dashboard.petugas');
    }
}