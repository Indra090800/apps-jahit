<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pembayaran::query();
        $query->select('tb_pembayaran.*');
        $query->orderBy('status');
        if(!empty($request->pesanan_id)){
            $query->where('pesanan_id', 'like', '%'. $request->pesanan_id.'%');
        }
        $pembayaran = $query->paginate(25);
        
        return view('master.pembayaran', compact('pembayaran'));
    }

    public function addPembayaran(Request $request)
    {
        $pesanan_id          = $request->pesanan_id;
        $metode_bayar        = $request->metode_bayar;
        $total_bayar         = $request->total_bayar;
        $status_bayar        = $request->status_bayar;

        if($request->hasFile('bukti_bayar')){
            $bukti_bayar = $pesanan_id.".".$request->file('bukti_bayar')->getClientOriginalExtension();
        }else{
            $bukti_bayar = null;
        }

        try {
            $data = [
                'pesanan_id'          => $pesanan_id,
                'metode_bayar'        => $metode_bayar,
                'total_bayar'         => $total_bayar,
                'bukti_bayar'         => $bukti_bayar,
                'stastatus_bayartus'  => $status_bayar,
            ];
            $simpan = DB::table('tb_pembayaran')->insert($data);
        if($simpan){
            if($request->hasFile('bukti_bayar')){
                $folderPath = "public/uploads/bukti_bayar/";
                $request->file('bukti_bayar')->storeAs($folderPath, $bukti_bayar);
            }
            return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!!']);
        }
        } catch (\Exception $e) {
            if($e->getCode()==23000){
                $message = "Data Sudah Ada!!";
            }else {
                $message = "Hubungi Tim IT";
            }
            return Redirect::back()->with(['error' => 'Data Gagal Di Simpan!! '. $message]);
        }
    }

    public function editPembayaran($pembayaran_id, Request $request)
    {
        $pesanan_id          = $request->pesanan_id;
        $metode_bayar        = $request->metode_bayar;
        $total_bayar         = $request->total_bayar;
        $status_bayar        = $request->status_bayar;

        $bayar = DB::table('tb_pembayaran')->where('pembayaran_id', $pembayaran_id)->first();
        $old_bukti_bayar = $bayar->bukti_bayar;

        if($request->hasFile('bukti_bayar')){
            $bukti_bayar = $pesanan_id.".".$request->file('bukti_bayar')->getClientOriginalExtension();
        }else{
            $bukti_bayar = null;
        }

        try {
            $data = [
                'pesanan_id'          => $pesanan_id,
                'metode_bayar'        => $metode_bayar,
                'total_bayar'         => $total_bayar,
                'bukti_bayar'         => $bukti_bayar,
                'stastatus_bayartus'  => $status_bayar,
            ];
            $update = DB::table('tb_pembayaran')->where('pembayaran_id', $pembayaran_id)->update($data);
        if($update){
            if($request->hasFile('bukti_bayar')){
                $folderPath = "public/uploads/bukti_bayar/";
                $folderPathOld = "public/uploads/bukti_bayar/".$old_bukti_bayar;
                Storage::delete($folderPathOld);
                $request->file('bukti_bayar')->storeAs($folderPath, $bukti_bayar);
            }
            return Redirect::back()->with(['success' => 'Data Berhasil Di Update!!']);
        }
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => 'Data Gagal Di Update!!']);
        }
    }

    public function editSPembayaran($pembayaran_id, Request $request)
    {
        $status_bayar           = $request->status_bayar;

        try {
            $data = [
                'status_bayar'             => $status_bayar,
            ];
            $update = DB::table('tb_pembayaran')->where('pembayaran_id', $pembayaran_id)->update($data);
        if($update){
            return Redirect::back()->with(['success' => 'Data Berhasil Di Update!!']);
        }
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => 'Data Gagal Di Update!!']);
        }
    }

    public function delete($pembayaran_id)
    {
        $delete =  DB::table('tb_pembayaran')->where('pembayaran_id', $pembayaran_id)->delete();

        if($delete){
            return Redirect::back()->with(['success' => 'Data Berhasil Di Delete!!']);
        }else{
            return Redirect::back()->with(['error' => 'Data Gagal Di Delete!!']);
        }
    }
}
