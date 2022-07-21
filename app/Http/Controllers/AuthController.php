<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

use Carbon\Carbon;
use Session;
use Alert;
use Hash;

class AuthController extends Controller
{
    public function loginPage()
    {
        return view('layout.login');
        // Alert::alert('Title', 'Message', 'Type');
    }

    public function loginProcess(Request $req)
    {
        $validated = $req->validate([
            'input' => 'required',
            'password' => 'required'
        ]);

        $username = User::where('username', $req->input)->first();
        $email = User::where('email', $req->input)->first();
        $userData = $email ?? $username;

        if(!$userData){
            return redirect()->back()->withErrors(['not_found' => 'Akun tidak Ditemukan, silahkan cek kembali']);
        }

        $check = Hash::check($req->password, $userData->password);

        if(!$check){
            return redirect()->back()->withErrors(['not_found' => 'Password Salah, silahkan cek kembali']);
        }

        $userData->last_login = Carbon::now('Asia/Jakarta');
        $userData->save();

        Session::put('login', true);
        Session::put('user', $userData);
        Alert::success('Login', 'Success Login');
        return redirect('/');
    }

    public function logoutProcess()
    {
        Session::flush();
        return redirect('/');
    }
}
