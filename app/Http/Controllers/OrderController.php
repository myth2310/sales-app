<?php

namespace App\Http\Controllers;

use App\Models\OrderModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = OrderModel::select('kode_pembayaran', 'name_pelanggan', 'no_telpon', 'alamat', 'status', 'name_seles', 'created_at')
            ->whereDate('created_at', Carbon::today())
            ->groupBy('kode_pembayaran', 'name_pelanggan', 'no_telpon', 'status', 'alamat', 'name_seles', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.sales-order', compact('orders'));
    }

    public function filterOrders(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $orders = OrderModel::select('kode_pembayaran', 'name_pelanggan', 'no_telpon', 'alamat', 'status', 'name_seles', 'created_at')
            ->when($startDate && !$endDate, function ($query) use ($startDate) {
                return $query->whereDate('created_at', '=', Carbon::parse($startDate)->format('Y-m-d'));
            })
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                return $query->whereBetween('created_at', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()]);
            })
            ->groupBy('kode_pembayaran', 'name_pelanggan', 'no_telpon', 'status', 'alamat', 'name_seles', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.sales-order', compact('orders'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $prefix = 'ELS';
            $tanggal = Carbon::now()->format('dmy');
            $kodeTerakhir = OrderModel::whereDate('created_at', Carbon::today())
                ->where('kode_pembayaran', 'like', $prefix . $tanggal . '%')
                ->orderBy('kode_pembayaran', 'desc')
                ->pluck('kode_pembayaran')
                ->first();

            if ($kodeTerakhir) {
                $urutanTerakhir = (int) substr($kodeTerakhir, -2);
                $urutan = str_pad($urutanTerakhir + 1, 2, '0', STR_PAD_LEFT);
            } else {
                $urutan = '01';
            }

            $kodePembayaran = $prefix . $tanggal . $urutan;
            foreach ($request->barang as $item) {
                OrderModel::create([
                    'id_product'      => $item['id_product'],
                    'kode_pembayaran' => $kodePembayaran,
                    'name_pelanggan'  => $request->name_pelanggan,
                    'no_telpon'       => $request->no_telepon,
                    'alamat'          => $request->alamat,
                    'email'           => $request->email,
                    'name_seles'      => $request->name_sales,
                    'status'          => 'pending',
                ]);
            }

            DB::commit();
            if (Auth::user()->role == 'sales') {
                return redirect()->back()->with('success', [
                    'title' => 'Order Disimpan',
                    'text'  => 'Order berhasil disimpan! Menunggu konfirmasi.',
                ]);
            }

            return redirect('/sales-order')->with('success', [
                'title' => 'Order Disimpan',
                'text'  => 'Order berhasil disimpan!',
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function getOrderDetail($kodePembayaran)
    {
        $order = DB::table('orders')
            ->join('products', 'orders.id_product', '=', 'products.id')
            ->where('orders.kode_pembayaran', $kodePembayaran)
            ->select('orders.*', 'products.name as product_name', 'products.price as product_price')
            ->get();
        return response()->json(['products' => $order]);
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'kode_pembayaran' => 'required'
        ]);
        $orders = OrderModel::where('kode_pembayaran', $request->kode_pembayaran)->get();
        if ($orders->isEmpty()) {
            return response()->json(['message' => 'Data order tidak ditemukan.'], 404);
        }

        foreach ($orders as $order) {
            $order->status = 'dibayar';
            $order->save();
        }

        return response()->json(['message' => 'Status semua pesanan berhasil diperbarui.']);
    }

    public function destroy($kode_pembayaran)
    {
        $orders = OrderModel::where('kode_pembayaran', $kode_pembayaran)->get();
    
        if ($orders->isNotEmpty()) {
            $orders->each(function ($order) {
                $order->delete();
            });
    
            return response()->json(['message' => 'Semua pesanan dengan kode pembayaran ini telah dihapus.'], 200);
        }
    
        return response()->json(['message' => 'Pesanan dengan kode pembayaran ini tidak ditemukan.'], 404);
    }
    

}
