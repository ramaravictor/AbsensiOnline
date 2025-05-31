<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboardAdmin');
    }

    public function karyawan()
    {
        return view('admin.dataKaryawan');
    }

    public function login()
    {
        return view('admin.loginAdmin');
    }

    public function rekapAbsensi()
    {
        return view('admin.rekapAbsensi');
    }

    public function profilAdmin()
    {
        return view('admin.profilAdmin');
    }
}
