<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class PelangganController extends Controller
{
    public function index(Request $request)
    {
        $query = Pelanggan::query();
        $query->select('tb_pelanggan.*');
        $query->orderBY('pelanggan_id', 'desc');
        if(!empty($request->nama_pelanggan)){
            $query->where('tb_pelanggan.nama_pelanggan', 'like', '%'. $request->nama_pelanggan.'%');
        }
        $pelanggan = $query->paginate(5);

        return view('master.pelanggan', compact('pelanggan'));
    }

    public function register()
    {
        return view('auth.register');
    }

    public function addreg(Request $request)
    {
        $nama   = $request->nama_pelanggan;
        $alamat = $request->alamat;
        $email  = $request->email;
        $nohp   = $request->no_hp;
        $user   = $request->username;
        $pass   = Hash::make($request->password);

        try {
            $data = [
                'nama_pelanggan' => $nama,
                'alamat'         => $alamat,
                'email'          => $email,
                'no_hp'          => $nohp,
                'username'       => $user,
                'password'       => $pass,
            ];
            $reg = DB::table('tb_pelanggan')->insert($data);
            if($reg){
                return redirect('/')->with(['success' => 'Akun Anda Telah Aktif Silahkan Login !!']);
            }
        } catch (\Exception $e) {
            return redirect('/register')->with(['warning' => 'Silahkan Coba Lagi !!']);
        }
    }

    public function addPelanggan(Request $request)
    {
        $nama   = $request->nama_pelanggan;
        $alamat = $request->alamat;
        $email  = $request->email;
        $nohp   = $request->no_hp;
        $user   = $request->username;
        $pass   = Hash::make('12345');

        if($request->hasFile('foto_pelanggan')){
            $foto_pelanggan = $user.".".$request->file('foto_pelanggan')->getClientOriginalExtension();
        }else{
            $foto_pelanggan = null;
        }

        try {
            $data = [
                'nama_pelanggan' => $nama,
                'alamat'         => $alamat,
                'email'          => $email,
                'no_hp'          => $nohp,
                'username'       => $user,
                'password'       => $pass,
                'foto_pelanggan' => $foto_pelanggan
            ];
            $simpan = DB::table('tb_pelanggan')->insert($data);
            if($simpan){
                if($request->hasFile('foto_pelanggan')){
                    $folderPath = "public/uploads/pelanggan/";
                    $request->file('foto_pelanggan')->storeAs($folderPath, $foto_pelanggan);
                }
                return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!!']);
            }

        } catch (\Exception $e) {
            if($e->getCode()==23000){
                $message = "Data Username = ".$user." Sudah Ada!!";
            }else {
                $message = "Hubungi Tim IT";
            }
            return Redirect::back()->with(['error' => 'Data Gagal Di Simpan!! '. $message]);
        }
    }

    public function editPelanggan($pelanggan_id, Request $request)
    {
        $nama   = $request->nama_pelanggan;
        $alamat = $request->alamat;
        $email  = $request->email;
        $nohp   = $request->no_hp;
        $user   = $request->username;
        $pass   = Hash::make('12345');

        $pelanggan = DB::table('tb_pelanggan')->where('pelanggan_id', $pelanggan_id)->first();
        $old_foto_pelanggan = $pelanggan->foto_pelanggan;

        if($request->hasFile('foto_pelanggan')){
            $foto_pelanggan = $user.".".$request->file('foto_pelanggan')->getClientOriginalExtension();
        }else{
            $foto_pelanggan = $old_foto_pelanggan;
        }

        try {
            $data = [
                'nama_pelanggan' => $nama,
                'alamat'         => $alamat,
                'email'          => $email,
                'no_hp'          => $nohp,
                'username'       => $user,
                'password'       => $pass,
                'foto_pelanggan' => $foto_pelanggan
            ];
            $update = DB::table('tb_pelanggan')->where('pelanggan_id', $pelanggan_id)->update($data);
            if($update){
                if($request->hasFile('foto_pelanggan')){
                    $folderPath = "public/uploads/pelanggan/";
                    $folderPathOld = "public/uploads/pelanggan/".$old_foto_pelanggan;
                    Storage::delete($folderPathOld);
                    $request->file('foto_pelanggan')->storeAs($folderPath, $foto_pelanggan);
                }
                return Redirect::back()->with(['success' => 'Data Berhasil Di Update!!']);
            }
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => 'Data Gagal Di Update!!']);
        }
    }

    public function delete($pelanggan_id)
    {
        $pelanggan = DB::table('tb_pelanggan')->where('pelanggan_id', $pelanggan_id)->first();
        $old_foto_pelanggan = $pelanggan->foto_pelanggan;
        $folderPathOld = "public/uploads/pelanggan/".$old_foto_pelanggan;
        Storage::delete($folderPathOld);
        $delete =  DB::table('tb_pelanggan')->where('pelanggan_id', $pelanggan_id)->delete();

        if($delete){
            return Redirect::back()->with(['success' => 'Data Berhasil Di Delete!!']);
        }else{
            return Redirect::back()->with(['error' => 'Data Gagal Di Delete!!']);
        }
    }

    public function pesan()
    {
        $jenis = DB::table('tb_jenis')->get();
        return view('pesanan.pesan', compact('jenis'));
    }
}
