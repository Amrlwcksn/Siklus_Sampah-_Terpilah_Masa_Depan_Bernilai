<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless($request->user()->role === 'admin', 403);

        $search = trim((string) $request->query('search', ''));

        $pelanggan = User::query()
            ->where('role', 'user')
            ->with('subscription')
            ->withCount('addresses')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $totalPelanggan = User::where('role', 'user')->count();

        $langgananAktif = User::where('role', 'user')
            ->whereHas('subscription', function ($query) {
                $query->where('status', 'active');
            })
            ->count();

        return view('admin.customers.index', compact(
            'pelanggan',
            'search',
            'totalPelanggan',
            'langgananAktif'
        ));
    }
}