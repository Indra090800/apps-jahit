<?php

namespace App\Http\Controllers;

use App\Models\Harga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Harga::query();
        $query->select('tb_jenis.*');
        if(!empty($request->jenis_jahitan)){
            $query->where('jenis_jahitan', 'like', '%'. $request->jenis_jahitan.'%');
        }
        $jenis = $query->paginate(5);
        return view('dashboard.dashboard', compact('jenis'));
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
