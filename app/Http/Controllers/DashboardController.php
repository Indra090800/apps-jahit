<?php

namespace App\Http\Controllers;

use App\Models\Caleg;
use App\Models\TPS;
use App\Models\Saksi;
use App\Models\Voters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {

        return view('dashboard.dashboard');
    }

    public function dashboardadmin()
    {   
        $cpel = DB::table('tb_pelanggan')
        ->selectRaw('COUNT(pelanggan_id) as jpel')
        ->first();
        $cpes = DB::table('tb_pesanan')
        ->selectRaw('COUNT(pesanan_id) as jpes')
        ->first();
        return view('dashboard.dashboardadmin', compact('cpel', 'cpes'));
    }

}
