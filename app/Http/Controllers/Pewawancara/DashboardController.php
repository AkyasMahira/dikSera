<?php

namespace App\Http\Controllers\Pewawancara;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (!Auth::check() || Auth::user()->role !== 'pewawancara') {
            return redirect()->route('auth.login')->with('error','Akses hanya untuk pewawancara.');
        }

        return view('pewawancara.dashboard');
    }
}
