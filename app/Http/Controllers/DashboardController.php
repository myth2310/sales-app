<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        return view('Dashboard Admin.dashboard');
    }

    public function customer(){
        return view('Dashboard Admin.customer');
    }
    
    public function salesOrder(){
        return view('Dashboard Admin.sales-order');
    }

    public function product(){
        return view('Dashboard Admin.product');
    }

    public function formProduct(){
        return view('Dashboard Admin.form-product');
    }
    public function formPelanggan(){
        return view('Dashboard Admin.form-seles-order');
    }


}
