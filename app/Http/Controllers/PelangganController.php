<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PelangganController extends Controller
{
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
                'no_hp'           => $nohp,
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
}
