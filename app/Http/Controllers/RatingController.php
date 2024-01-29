<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class RatingController extends Controller
{
    public function index(Request $request)
    {
        $query = Rating::query();
        $query->select('tb_rating.*');
        $query->orderBy('status');
        if(!empty($request->penilaian)){
            $query->where('penilaian', 'like', '%'. $request->penilaian.'%');
        }
        $rating = $query->paginate(25);

        return view('master.rating', compact('rating'));
    }

    public function addRating(Request $request)
    {
        $pesanan_id       = $request->pesanan_id;
        $penilaian        = $request->penilaian;
        $komentar         = $request->komentar;
        $status           = 0;
        $pelid            = Auth::guard('buy')->user()->pelanggan_id;

        try {
            $data = [
                'pesanan_id'         => $pesanan_id,
                'penilaian'          => $penilaian,
                'komentar'           => $komentar,
                'status'             => $status,
                'pelanggan_id'       => $pelid,
            ];
            $simpan = DB::table('tb_rating')->insert($data);
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

    public function editRating($rating_id, Request $request)
    {
        $pesanan_id       = $request->pesanan_id;
        $penilaian        = $request->penilaian;
        $komentar         = $request->komentar;
        $status           = 1;
        $pelid            = Auth::guard('buy')->user()->pelanggan_id;

        try {
            $data = [
                'pesanan_id'         => $pesanan_id,
                'penilaian'          => $penilaian,
                'komentar'           => $komentar,
                'status'             => $status,
                'pelanggan_id'       => $pelid,
            ];
            $update = DB::table('tb_rating')->where('rating_id', $rating_id)->update($data);
        if($update){
            return Redirect::back()->with(['success' => 'Data Berhasil Di Update!!']);
        }
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => 'Data Gagal Di Update!!']);
        }
    }

    public function editSRating($rating_id, Request $request)
    {
        $status           = $request->status;

        try {
            $data = [
                'status'             => $status,
            ];
            $update = DB::table('tb_rating')->where('rating_id', $rating_id)->update($data);
        if($update){
            return Redirect::back()->with(['success' => 'Data Berhasil Di Update!!']);
        }
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => 'Data Gagal Di Update!!']);
        }
    }

    public function delete($rating_id)
    {
        $delete =  DB::table('tb_rating')->where('rating_id', $rating_id)->delete();

        if($delete){
            return Redirect::back()->with(['success' => 'Data Berhasil Di Delete!!']);
        }else{
            return Redirect::back()->with(['error' => 'Data Gagal Di Delete!!']);
        }
    }

    public function deleteS($rating_id)
    {
        $delete =  DB::table('tb_rating')->where('rating_id', $rating_id)->delete();

        if($delete){
            return Redirect::back()->with(['success' => 'Data Berhasil Di Delete!!']);
        }else{
            return Redirect::back()->with(['error' => 'Data Gagal Di Delete!!']);
        }
    }

    public function myrate()
    {
        $my = DB::table('tb_rating')
        ->leftJoin('tb_pesanan', 'tb_rating.pesanan_id', '=', 'tb_pesanan.pesanan_id')
        ->where('tb_rating.pelanggan_id', Auth::guard('buy')->user()->pelanggan_id)
        ->get();
        return view('pesanan.myrate',compact('my'));
    }

    public function addrate()
    {
        $rate = DB::table('tb_pesanan')
        ->leftJoin('tb_jenis', 'tb_jenis.jenis_id', '=', 'tb_pesanan.jenis_id')
        ->get();
        return view('pesanan.addrate', compact('rate'));
    }
}
