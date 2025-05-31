<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function absen()
    {
        return view('user.absen');
    }

    public function history()
    {
        return view('user.history');
    }

    public function home()
    {
        return view('user.home');
    }

    public function login()
    {
        return view('user.login');
    }

    public function profil()
    {
        return view('user.profil');
    }
}
