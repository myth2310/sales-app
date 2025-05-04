<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderModel;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPelanggan = DB::table('orders')->distinct('name_pelanggan')->count('name_pelanggan');
        $totalOrders = DB::table('orders')->count('id');
        $salesPerProduct = DB::table('orders')
            ->select('id_product', DB::raw('COUNT(*) as total_sales'))
            ->where('status', 'dibayar')
            ->groupBy('id_product')
            ->get();

        $products = DB::table('products')->pluck('name', 'id');

        return view('admin.dashboard', compact('totalPelanggan', 'totalOrders', 'salesPerProduct', 'products'));
    }


    public function customer()
    {
        $customers = OrderModel::select('name_pelanggan', 'alamat', 'email', 'no_telpon')
            ->groupBy('name_pelanggan', 'alamat', 'email', 'no_telpon')
            ->get();


        return view('admin.customer', compact('customers'));
    }

    public function sales()
    {
        return view('admin.sales');
    }


    public function product()
    {
        $products = Product::with('category')->get();

        return view('admin.product', compact('products'));
    }

    public function formProduct()
    {
        $category = Category::get();
        return view('admin.form-product', compact('category'));
    }


    public function formPelanggan()
    {
        return view('admin.form-seles-order');
    }
}
