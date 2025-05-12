<?php

namespace App\Http\Controllers;

use App\Models\OrderModel;
use App\Models\Product;
use App\Models\TransaksiModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index()
    {
        $orders = DB::table('transaksi')
            ->whereDate('created_at', Carbon::today())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.sales-order', compact('orders'));
    }

    public function filterOrders(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $orders = TransaksiModel::select('kode_pembayaran', 'name_pelanggan', 'no_telpon', 'alamat', 'status', 'name_seles', 'created_at')
            ->when($startDate && !$endDate, function ($query) use ($startDate) {
                return $query->whereDate('created_at', '=', Carbon::parse($startDate)->format('Y-m-d'));
            })
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                return $query->whereBetween('created_at', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()]);
            })

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

            $totalHarga = 0;
            foreach ($request->barang as $item) {
                $harga = isset($item['harga'])
                    ? (int) $item['harga']
                    : (Product::find($item['id_product'])->price ?? 0);

                if ($harga <= 0) {
                    throw new \Exception('Harga produk tidak valid.');
                }

                OrderModel::create([
                    'id_product'      => $item['id_product'],
                    'kode_pembayaran' => $kodePembayaran,
                ]);
                $totalHarga += $harga;
            }

            TransaksiModel::create([
                'kode_pembayaran' => $kodePembayaran,
                'name_pelanggan'  => $request->name_pelanggan,
                'no_telpon'       => $request->no_telepon,
                'alamat'          => $request->alamat,
                'email'           => $request->email,
                'name_seles'      => $request->name_sales,
                'total_belanja'   => $totalHarga,
            ]);
            DB::commit();
            return redirect(Auth::user()->role === 'sales' ? url()->previous() : '/sales-order')
                ->with('success', [
                    'title' => 'Order Disimpan',
                    'text'  => 'Order berhasil disimpan!' . (Auth::user()->role === 'sales' ? ' Menunggu konfirmasi.' : ''),
                ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function getOrderDetail($kodePembayaran)
    {

        $order = DB::table('orders')
            ->join('products', 'orders.id_product', '=', 'products.id')
            ->join('transaksi', 'orders.kode_pembayaran', '=', 'transaksi.kode_pembayaran')
            ->where('orders.kode_pembayaran', $kodePembayaran)
            ->select(
                'orders.*',
                'products.name as product_name',
                'products.price as product_price',
                'products.bonus',
                'products.garansi',
                'transaksi.name_pelanggan',
                'transaksi.no_telpon',
                'transaksi.name_seles',
                'transaksi.status'
            )
            ->get();

        Log::info('Data order detail yang diambil:', $order->toArray());

        return response()->json(['products' => $order]);
    }


    public function updateStatus(Request $request)
    {
        $request->validate([
            'kode_pembayaran'    => 'required',
            'metode_pembayaran'  => 'required',
            'uang_bayar'         => 'required|numeric',
        ]);

        $orders = OrderModel::where('kode_pembayaran', $request->kode_pembayaran)->get();

        if ($orders->isEmpty()) {
            return response()->json(['message' => 'Data order tidak ditemukan.'], 404);
        }

        $totalBelanja = 0;

        foreach ($orders as $order) {
            $product = $order->product;

            if (!$product) {
                return response()->json([
                    'message' => 'Produk tidak ditemukan untuk order ID: ' . $order->id
                ], 400);
            }

            $qty = $order->jumlah ?? 1;

            if ($product->stok >= $qty) {
                $product->stok -= $qty;
                $product->save();
            } else {
                return response()->json([
                    'message' => "Stok tidak cukup untuk produk: {$product->name}. Stok tersedia: {$product->stok}, diminta: {$qty}"
                ], 400);
            }

            $totalBelanja += $product->price * $qty;
        }

        $kembalian = $request->uang_bayar - $totalBelanja;

        $transaksi = TransaksiModel::where('kode_pembayaran', $request->kode_pembayaran)->first();

        if ($transaksi) {
            $transaksi->metode_pembayaran = $request->metode_pembayaran;
            $transaksi->uang_dibayar = $request->uang_bayar;
            $transaksi->kembalian = $kembalian;
            $transaksi->status = 'dibayar';
            $transaksi->waktu_pembayaran = now();
            $transaksi->save();
        }

        return response()->json([
            'message' => 'Pembayaran berhasil dilakukan!'
        ]);
    }


    public function destroy($kode_pembayaran)
    {
        $orders = TransaksiModel::where('kode_pembayaran', $kode_pembayaran)->get();

        if ($orders->isNotEmpty()) {
            $orders->each(function ($order) {
                $order->delete();
            });

            return response()->json(['message' => 'Semua pesanan dengan kode pembayaran ini telah dihapus.'], 200);
        }

        return response()->json(['message' => 'Pesanan dengan kode pembayaran ini tidak ditemukan.'], 404);
    }
}
