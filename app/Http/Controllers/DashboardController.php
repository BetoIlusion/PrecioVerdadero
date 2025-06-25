<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function create()
    {
        return view('superadmin.producto.create');
    }
    public function indexCliente()
    {
        return redirect()->away('https://drive.google.com/drive/folders/191OrE3BQFsW0_ox2QBCRZJtKsebAzqa8?usp=sharing');
    }
}
