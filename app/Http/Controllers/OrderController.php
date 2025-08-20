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
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;



class OrderController extends Controller
{

    public function index()
    {
        $orders = DB::table('transaksi as t')
            ->leftJoin('orders as o', 't.kode_pembayaran', '=', 'o.kode_pembayaran')
            ->leftJoin('products as p', 'o.id_product', '=', 'p.id')
            ->select(
                't.id',
                't.kode_pembayaran',
                't.name_pelanggan',
                't.no_telpon',
                't.alamat',
                't.email',
                't.name_seles',
                't.metode_pembayaran',
                't.total_belanja',
                't.uang_dibayar',
                't.kembalian',
                't.status',
                't.waktu_pembayaran',
                't.created_at',
                't.updated_at',
                DB::raw('SUM(CASE WHEN (p.is_preorder = 1 OR p.is_preorder = 0) AND o.preorder_status = "pending" THEN 1 ELSE 0 END) as preorder_pending_count')

            )
            ->whereDate('t.created_at', Carbon::today())
            ->groupBy(
                't.id',
                't.kode_pembayaran',
                't.name_pelanggan',
                't.no_telpon',
                't.alamat',
                't.email',
                't.name_seles',
                't.metode_pembayaran',
                't.total_belanja',
                't.uang_dibayar',
                't.kembalian',
                't.status',
                't.waktu_pembayaran',
                't.created_at',
                't.updated_at'
            )
            ->orderBy('t.created_at', 'desc')
            ->get();

        $pendapatanHariIni = DB::table('transaksi')
            ->whereDate('created_at', Carbon::today())
            ->sum('total_belanja');

        $pendapatanBulanIni = DB::table('transaksi')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total_belanja');

        $pendapatanTahunIni = DB::table('transaksi')
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total_belanja');

        $items = Product::all();

        return view('admin.sales-order', compact(
            'orders',
            'items',
            'pendapatanHariIni',
            'pendapatanBulanIni',
            'pendapatanTahunIni'
        ));
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

        $pendapatanHariIni = DB::table('transaksi')
            ->whereDate('created_at', Carbon::today())
            ->sum('total_belanja');

        $pendapatanBulanIni = DB::table('transaksi')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total_belanja');

        $pendapatanTahunIni = DB::table('transaksi')
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total_belanja');

        $items = Product::all();
        return view('admin.sales-order', compact(
            'orders',
            'items',
            'pendapatanHariIni',
            'pendapatanBulanIni',
            'pendapatanTahunIni'
        ));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            Log::info('Mulai menyimpan order');

            $prefix = 'ELS';
            $tanggal = Carbon::now()->format('dmy');

            $kodeTerakhir = OrderModel::whereDate('created_at', Carbon::today())
                ->where('kode_pembayaran', 'like', $prefix . $tanggal . '%')
                ->orderBy('kode_pembayaran', 'desc')
                ->pluck('kode_pembayaran')
                ->first();

            Log::info('Kode terakhir: ' . $kodeTerakhir);

            if ($kodeTerakhir) {
                $urutanTerakhir = (int) substr($kodeTerakhir, -2);
                $urutan = str_pad($urutanTerakhir + 1, 2, '0', STR_PAD_LEFT);
            } else {
                $urutan = '01';
            }

            $kodePembayaran = $prefix . $tanggal . $urutan;
            Log::info('Kode pembayaran baru: ' . $kodePembayaran);

            $totalHarga = 0;

            foreach ($request->barang as $item) {
                Log::info('Memproses item', $item);

                $product = Product::find($item['id_product']);
                if (!$product) {
                    throw new \Exception('Produk tidak ditemukan: ' . $item['id_product']);
                }

                $harga = $product->price ?? 0;
                $jumlah = (int) ($item['jumlah'] ?? 1);

                if ($harga <= 0) {
                    throw new \Exception('Harga produk tidak valid: ' . $product->name);
                }

                if ($product->stok > 0) {
                    Log::info("Produk ready stock: {$product->name}, jumlah: $jumlah");
                    $order = OrderModel::create([
                        'id_product'      => $item['id_product'],
                        'quantity'        => $jumlah,
                        'preorder_status' => 'picked_up',
                        'kode_pembayaran' => $kodePembayaran,
                    ]);

                    $product->stok -= $jumlah;
                    $product->save();
                } elseif ($product->stok <= 0 && $product->is_preorder) {
                    Log::info("Produk preorder: {$product->name}, jumlah: $jumlah");
                    $order = OrderModel::create([
                        'id_product'      => $item['id_product'],
                        'quantity'        => $jumlah,
                        'preorder_status'  => 'pending',
                        'kode_pembayaran' => $kodePembayaran,
                    ]);

                    $product->preorder_quantity = ($product->preorder_quantity ?? 0) + $jumlah;
                    $product->save();
                } else {
                    throw new \Exception('Stok habis dan produk tidak bisa preorder: ' . $product->name);
                }

                $totalHarga += $harga * $jumlah;
                Log::info("Subtotal item: " . ($harga * $jumlah));
            }

            Log::info('Total harga order: ' . $totalHarga);

            $transaksi = TransaksiModel::create([
                'kode_pembayaran' => $kodePembayaran,
                'name_pelanggan'  => $request->name_pelanggan,
                'no_telpon'       => $request->no_telepon,
                'alamat'          => $request->alamat,
                'email'           => $request->email,
                'name_seles'      => $request->name_sales,
                'total_belanja'   => $totalHarga,
            ]);

            Log::info('Transaksi berhasil dibuat', ['id' => $transaksi->id]);

            DB::commit();

            return redirect(Auth::user()->role === 'sales' ? url()->previous() : '/sales-order')
                ->with('success', [
                    'title' => 'Order Disimpan',
                    'text'  => 'Order berhasil disimpan!' . (Auth::user()->role === 'sales' ? ' Menunggu konfirmasi.' : ''),
                ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menyimpan order: ' . $e->getMessage());
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
                'orders.id as order_id',
                'products.name as product_name',
                'products.price as product_price',
                'products.bonus',
                'products.is_preorder',
                'products.available_date',
                'products.garansi',
                'transaksi.name_pelanggan',
                'transaksi.no_telpon',
                'transaksi.name_seles',
                'transaksi.status',
                'transaksi.uang_dibayar',
                'transaksi.kembalian'
            )
            ->get();

        $firstOrder = $order->first();

        $diskon = $firstOrder->diskon ?? 0;
        $uangBayar = $firstOrder->uang_dibayar ?? 0;
        $kembalian = $firstOrder->kembalian ?? 0;

        Log::info('Data order detail yang diambil:', $order->toArray());

        return response()->json([
            'products' => $order,
            'uang_bayar' => $uangBayar,
            'kembalian' => $kembalian
        ]);
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'kode_pembayaran'   => 'required|string',
            'metode_pembayaran' => 'required|string',
            'uang_bayar'        => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $transaksi = TransaksiModel::where('kode_pembayaran', $request->kode_pembayaran)->first();

            if (!$transaksi) {
                return response()->json(['message' => 'Transaksi tidak ditemukan.'], 404);
            }

            $totalBelanja = $transaksi->total_belanja;
            if ($request->uang_bayar < $totalBelanja) {
                return response()->json([
                    'message'       => 'Uang yang dibayarkan kurang dari total belanja',
                    'total_belanja' => $totalBelanja,
                    'uang_bayar'    => $request->uang_bayar
                ], 400);
            }


            $kembalian = $request->uang_bayar - $totalBelanja;
            $transaksi->metode_pembayaran = $request->metode_pembayaran;
            $transaksi->uang_dibayar      = $request->uang_bayar;
            $transaksi->kembalian         = $kembalian;
            $transaksi->status            = 'dibayar';
            $transaksi->waktu_pembayaran  = now();
            $transaksi->save();

            DB::commit();

            return response()->json([
                'message'       => 'Pembayaran berhasil dilakukan!',
                'total_belanja' => $totalBelanja,
                'uang_bayar'    => $request->uang_bayar,
                'kembalian'     => $kembalian
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
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

    public function approvePickup(Request $request)
    {
        try {
            $order = DB::table('orders')->where('id', $request->order_id)->first();

            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order tidak ditemukan'
                ]);
            }
            $items = DB::table('orders')
                ->where('id', $request->order_id)
                ->get();

            foreach ($items as $item) {
                DB::table('products')
                    ->where('id', $item->id_product)
                    ->decrement('stok', $item->quantity);

                DB::table('products')
                    ->where('id', $item->id_product)
                    ->decrement('preorder_quantity', $item->quantity);
            }

            DB::table('orders')
                ->where('id', $request->order_id)
                ->update([
                    'preorder_status' => 'picked_up',
                    'updated_at' => now()
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Pickup berhasil disetujui, stok & preorder_quantity dikurangi'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }



    public function downloadLaporan(Request $request)
    {
        $item       = $request->input('item');
        $start_date = $request->input('start_date');
        $end_date   = $request->input('end_date');

        $builder = DB::table('transaksi as t')
            ->join('orders as o', 't.kode_pembayaran', '=', 'o.kode_pembayaran')
            ->join('products as p', 'o.id_product', '=', 'p.id')
            ->select(
                't.id as transaksi_id',
                't.kode_pembayaran',
                't.metode_pembayaran',
                't.uang_dibayar',
                't.status',
                't.name_pelanggan',
                'p.name as produk',
                'o.quantity',
                't.total_belanja',
                't.created_at'
            )
            ->whereBetween(DB::raw('DATE(t.created_at)'), [$start_date, $end_date]);

        if (!empty($item)) {
            $builder->where('p.id', $item);
        }

        $data = $builder->get();

        if ($data->isEmpty()) {
            return back()->with('error', 'Data tidak ditemukan untuk periode ini.');
        }

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Pembayaran');
        $sheet->setCellValue('C1', 'Nama Pelanggan');
        $sheet->setCellValue('D1', 'Produk');
        $sheet->setCellValue('E1', 'Jumlah');
        $sheet->setCellValue('E1', 'Dibayar');
        $sheet->setCellValue('E1', 'Metode Pembayaran');
        $sheet->setCellValue('E1', 'Status');
        $sheet->setCellValue('F1', 'Total Belanja');
        $sheet->setCellValue('G1', 'Tanggal');

        $row = 2;
        foreach ($data as $d) {
            $no = 0;

            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $d->kode_pembayaran);
            $sheet->setCellValue('C' . $row, $d->name_pelanggan);
            $sheet->setCellValue('D' . $row, $d->produk);
            $sheet->setCellValue('E' . $row, $d->quantity);
            $sheet->setCellValue('E' . $row, $d->uang_dibayar);
            $sheet->setCellValue('E' . $row, $d->metode_pembayaran);
            $sheet->setCellValue('E' . $row, $d->status);
            $sheet->setCellValue('F' . $row, $d->total_belanja);
            $sheet->setCellValue('G' . $row, $d->created_at);
            $row++;
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'Laporan_Transaksi_' . date('YmdHis') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}
