<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlagiatCek;
use App\Models\PlagiatReferensi;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dasbor admin.
     */
    public function index(): View
    {
        $totalCv = DB::table('cvs')->count();
        $totalPlagiatCek = PlagiatCek::count();
        $totalReferensi = PlagiatReferensi::count();

        $recentPlagiat = PlagiatCek::latest()->take(5)->get();
        $recentCvs = DB::table('cvs')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalCv',
            'totalPlagiatCek',
            'totalReferensi',
            'recentPlagiat',
            'recentCvs'
        ));
    }
}

