<?php

namespace App\Http\Controllers\Perawat;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (!Auth::check() || Auth::user()->role !== User::ROLE_PERAWAT) {
            return redirect()->route('auth.login')->with('error', 'Akses hanya untuk perawat.');
        }

        $user    = Auth::user();
        $profile = $user->perawatProfile;

        $certificates = $profile ? $profile->certificates : collect();

        $total = $certificates->count();
        $today = date('Y-m-d');

        $aktif = $certificates->filter(function ($c) use ($today) {
            $startOk = !$c->date_start || $c->date_start->toDateString() <= $today;
            $endOk   = !$c->date_end   || $c->date_end->toDateString()   >= $today;
            return $startOk && $endOk;
        })->count();

        $akanHabis = $certificates->filter(function ($c) use ($today) {
            if (!$c->date_end) return false;
            $end = $c->date_end->toDateString();
            return $end >= $today && $end <= date('Y-m-d', strtotime('+90 days'));
        })->count();

        return view('perawat.dashboard', compact('user', 'total', 'aktif', 'akanHabis'));
    }
}
