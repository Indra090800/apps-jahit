<?php

namespace App\Http\Controllers;

use App\Models\Saksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $id = Auth::guard()->user()->admin_id;
        $setting = DB::table('tb_admin')->where('admin_id', $id)->first();

        return view('master.setting', compact('setting'));
    }

    public function upsetting(Request $request)
    {
        $email            = $request->email;
        $username     = $request->username;
        $alamat         = $request->alamat;
        $nohp          = $request->nohp;
        $nama_users          = $request->nama_users;
        $id = Auth::guard()->user()->admin_id;
        $id_role = Auth::guard()->user()->id_role;

        $c = $request->password;
        if($c = null){
          $password = Hash::make('12345');
        }else{
          $password = Hash::make($request->password);
        }
        try {
            $data = [
                'nama_users'    => $nama_users,
                'alamat'        => $alamat,
                'nohp'         => $nohp,
                'email'         => $email,
                'id_role'       => $id_role,
                'username'       => $username,
                'password'      => $password,
            ];
            $update = DB::table('tb_admin')->where('admin_id', $id)->update($data);
            if($update){
                return Redirect('/settings')->with(['success' => 'Data Berhasil Di Update!!']);
            }
        } catch (\Exception $e) {
            return Redirect('/settings')->with(['error' => 'Data Gagal Di Update!!']);
        }
    }
}
