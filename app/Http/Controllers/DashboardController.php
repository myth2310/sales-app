<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderModel;
use App\Models\TransaksiModel;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPelanggan = DB::table('transaksi')->distinct('name_pelanggan')->count('name_pelanggan');
        $totalOrders = DB::table('transaksi')->count('id');
        $salesPerProduct = DB::table('orders')
        ->join('products', 'orders.id_product', '=', 'products.id')
        ->join('transaksi', 'orders.kode_pembayaran', '=', 'transaksi.kode_pembayaran')
        ->select('products.name as product_name', DB::raw('COUNT(orders.id) as total_sales'))
        ->where('transaksi.status', '=', 'dibayar')
        ->groupBy('products.id', 'products.name')
        ->orderByDesc('total_sales')
        ->get();
    
        $outOfStockProducts = Product::where('stok', 0)->get();
     
    
        $products = DB::table('products')->pluck('name', 'id');
    
        return view('admin.dashboard', compact('totalPelanggan', 'totalOrders', 'salesPerProduct', 'products','outOfStockProducts'));
    }
    

    public function customer()
    {
        $customers = TransaksiModel::select('name_pelanggan', 'alamat', 'email', 'no_telpon')
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

        $outOfStockProducts = Product::where('stok', 0)->get();
        return view('admin.product', compact('products', 'outOfStockProducts'));
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
