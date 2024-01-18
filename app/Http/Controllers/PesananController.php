<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class PesananController extends Controller
{
    public function index(Request $request)
    {
        $query = Pesanan::query();
        $query->select('tb_pesanan.*', 'nama_pelanggan', 'jenis_jahitan');
        $query->join('tb_pelanggan', 'tb_pesanan.pelanggan_id', '=', 'tb_pelanggan.pelanggan_id');
        $query->join('tb_jenis', 'tb_pesanan.jenis_id', '=', 'tb_jenis.jenis_id');
        if(!empty($request->no_antrian)){
            $query->where('no_antrian', 'like', '%'. $request->no_antrian.'%');
        }
        $pesanan = $query->paginate(25);
        
        return view('master.pesanan', compact('pesanan'));
    }

    public function addPesanan(Request $request)
    {
        $pelanggan_id       = $request->pelanggan_id;
        $jenis_id           = $request->jenis_id;
        $jumlah             = $request->jumlah;
        $bahan              = $request->bahan;
        $status_pesanan     = $request->status_pesanan;
        $no_antrian         = $request->no_antrian;
        $tgl_pemesanan      = $request->tgl_pemesanan;
        $tgl_kirim          = $request->tgl_kirim;

        try {
            $data = [
                'pelanggan_id'         => $pelanggan_id,
                'jenis_id'             => $jenis_id,
                'jumlah'               => $jumlah,
                'bahan'                => $bahan,
                'status_pesanan'       => $status_pesanan,
                'no_antrian'           => $no_antrian,
                'tgl_pemesanan'        => $tgl_pemesanan,
                'tgl_kirim'            => $tgl_kirim,
            ];
            $simpan = DB::table('tb_pesanan')->insert($data);
        if($simpan){
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

    public function editPesanan($pesanan_id, Request $request)
    {
        $pelanggan_id       = $request->pelanggan_id;
        $jenis_id           = $request->jenis_id;
        $jumlah             = $request->jumlah;
        $bahan              = $request->bahan;
        $status_pesanan     = $request->status_pesanan;
        $no_antrian         = $request->no_antrian;
        $tgl_pemesanan      = $request->tgl_pemesanan;
        $tgl_kirim          = $request->tgl_kirim;

        try {
            $data = [
                'pelanggan_id'         => $pelanggan_id,
                'jenis_id'             => $jenis_id,
                'jumlah'               => $jumlah,
                'bahan'                => $bahan,
                'status_pesanan'       => $status_pesanan,
                'no_antrian'           => $no_antrian,
                'tgl_pemesanan'        => $tgl_pemesanan,
                'tgl_kirim'            => $tgl_kirim,
            ];
            $update = DB::table('tb_pesanan')->where('pesanan_id', $pesanan_id)->update($data);
        if($update){
            return Redirect::back()->with(['success' => 'Data Berhasil Di Update!!']);
        }
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => 'Data Gagal Di Update!!']);
        }
    }

    public function delete($pesanan_id)
    {
        $delete =  DB::table('tb_pesanan')->where('pesanan_id', $pesanan_id)->delete();

        if($delete){
            return Redirect::back()->with(['success' => 'Data Berhasil Di Delete!!']);
        }else{
            return Redirect::back()->with(['error' => 'Data Gagal Di Delete!!']);
        }
    }

    public function editStatus($pesanan_id, Request $request)
    {
        $status_pesanan     = $request->status_pesanan;
        $tgl_kirim          = $request->tgl_kirim;

        try {
            $data = [
                'status_pesanan'       => $status_pesanan,
                'tgl_kirim'            => $tgl_kirim,
            ];
            $update = DB::table('tb_pesanan')->where('pesanan_id', $pesanan_id)->update($data);
        if($update){
            return Redirect::back()->with(['success' => 'Data Berhasil Di Update!!']);
        }
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => 'Data Gagal Di Update!!']);
        }
    }
}
