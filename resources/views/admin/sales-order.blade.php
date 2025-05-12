@extends('layouts.base')

@section('content')
<div class="row">
    <div class="col-lg d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body p-4">
                <div class="row mb-4">
                    <div class="col">
                        <h5 class="card-title fw-semibold mb-4">Sales Order</h5>
                    </div>
                    <div class="col d-flex justify-content-end">
                        @if(Auth::user()->role == 'super admin')
                        <a href="{{ route('dashboard.form-seles-order') }}" class="btn btn-primary m-1">
                            <i class="ti ti-plus m-1"></i>Tambah Pembelian
                        </a>
                        @endif
                    </div>
                </div>
                <form action="{{ route('sales-order.filter') }}" method="POST" class="mb-4">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <label for="start_date">Tanggal Mulai</label>
                            <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                        </div>
                        <div class="col">
                            <label for="end_date">Tanggal Akhir (Opsional)</label>
                            <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                        </div>
                        <div class="col d-flex align-items-end">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </form>

                <div class="alert alert-info">
                    <strong>Tanggal Hari Ini </strong>: {{ \Carbon\Carbon::today()->translatedFormat('l, d F Y') }}
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped datatable" id="orderTable">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th>#</th>
                                <th>Kode Pembayaran</th>
                                <th>Tanggal</th>
                                <th>Nama Pelanggan</th>
                                <th>No Telepon</th>
                                <th>Sales</th>

                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $index => $order)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $order->kode_pembayaran }}</td>
                                <td>{{ $order->waktu_pembayaran }}</td>
                                <td>{{ $order->name_pelanggan }}</td>
                                <td>{{ $order->no_telpon }}</td>
                                <td>{{ $order->name_seles }}</td>

                                <td>
                                    @if ($order->status == 'pending')
                                    <button class="btn btn-sm btn-warning btn-bayar"
                                        data-kode="{{ $order->kode_pembayaran }}"
                                        data-name="{{ $order->name_pelanggan }}"
                                        data-phone="{{ $order->no_telpon }}"
                                        data-sales="{{ $order->name_seles }}">
                                        <i class="fa-solid fa-money-bill"></i>
                                    </button>
                                    @elseif ($order->status == 'dibayar')
                                    <button class="btn btn-sm btn-info btn-detail"
                                        data-kode="{{ $order->kode_pembayaran }}"
                                        data-name="{{ $order->name_pelanggan }}"
                                        data-phone="{{ $order->no_telpon }}"
                                        data-sales="{{ $order->name_seles }}">
                                        <i class="fa-solid fa-receipt"></i>
                                    </button>
                                    @endif
                                    <button class="btn btn-sm btn-danger btn-delete" data-kode="{{ $order->kode_pembayaran }}">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>

                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Tidak ada data ditemukan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Payment -->
<div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white">Detail Pesanan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="kodePembayaranInput">

                <div class="row mb-3">
                    <div class="col-md-4">
                        <p><strong>Kode Pembayaran : </strong> <span id="modalKode"></span></p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Nama Pelanggan : </strong> <span id="modalName"></span></p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>No Telepon : </strong> <span id="modalPhone"></span></p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Sales : </strong> <span id="modalSales"></span></p>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                            </tr>
                        </thead>
                        <tbody id="modalProducts"></tbody>
                    </table>
                </div>

                <p class="text-end mt-3"><strong>Total Harga : </strong> <span id="modalTotalPrice">0</span></p>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="metodePembayaran" class="form-label">Metode Pembayaran</label>
                        <select class="form-select" id="metodePembayaran" name="metode_pembayaran" required>
                            <option value="" disabled selected>Pilih metode pembayaran</option>
                            <option value="tunai">Tunai</option>
                            <option value="transfer">Transfer Bank</option>
                            <option value="qris">QRIS</option>
                            <option value="debit">Kartu Debit</option>
                            <option value="kredit">Kartu Kredit</option>
                        </select>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <label for="uangDibayar" class="form-label">Uang Dibayar</label>
                        <input type="number" class="form-control" id="uangDibayar" placeholder="Masukkan nominal uang dibayar" required>
                    </div>
                    <div class="col-md-6">
                        <label for="kembalian" class="form-label">Kembalian</label>
                        <input type="text" class="form-control" id="kembalian" name="kembalian" readonly>
                    </div>
                </div>

            </div>

            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success" id="btnSimpan">Selesaikan Pembayaran</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Order Details -->
<div class="modal fade" id="orderDetailModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white">Detail Pesanan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <p><strong>Kode Pembayaran : </strong> <span id="modalKodeDetail"></span></p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Nama Pelanggan : </strong> <span id="modalNameDetail"></span></p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>No Telepon : </strong> <span id="modalPhoneDetail"></span></p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Sales : </strong> <span id="modalSalesDetail"></span></p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Status Pembayaran : </strong> <span class="badge text-bg-success" id="modalStatus"></span></p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Bonus : </strong> <span id="modalBonus"></span></p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Garansi : </strong> <span id="modalGaransi"></span></p>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                                <th>Bonus</th>
                                <th>Garansi</th>
                            </tr>
                        </thead>
                        <tbody id="modalProductsDetail"></tbody>
                    </table>
                </div>


                <p class="text-end mt-3"><strong>Total Harga : </strong> <span id="modalTotalPriceDetail"></span></p>
            </div>

            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-warning" id="btnPrintInvoice">
                    <i class="fa-solid fa-print" style="margin-right: 10px;"></i>Print Invoice
                </button>
            </div>
        </div>
    </div>
</div>

<div id="printArea" style="display: none;"></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.getElementById('btnPrintInvoice').addEventListener('click', function() {
        const kode = document.getElementById('modalKodeDetail').innerText;
        const name = document.getElementById('modalNameDetail').innerText;
        const phone = document.getElementById('modalPhoneDetail').innerText;
        const sales = document.getElementById('modalSalesDetail').innerText;
        const status = document.getElementById('modalStatus').innerText;
        const total = document.getElementById('modalTotalPriceDetail').innerText;
        const productsTable = document.getElementById('modalProductsDetail').innerHTML;
        const html = `
        <div style="font-family: Arial; padding: 20px;">
            <div style="text-align:center;">
                <h2>INVOICE PEMESANAN</h2>
                <hr>
            </div>
            <p><strong>Kode Pembayaran:</strong> ${kode}</p>
            <p><strong>Nama Pelanggan:</strong> ${name}</p>
            <p><strong>No Telepon:</strong> ${phone}</p>
            <p><strong>Sales:</strong> ${sales}</p>
            <p><strong>Status Pembayaran:</strong> ${status}</p>
            <br>
            <table border="1" cellspacing="0" cellpadding="8" width="100%" style="border-collapse: collapse;">
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Bonus</th>
                        <th>Garansi</th>
                    </tr>
                </thead>
                <tbody>
                    ${productsTable}
                </tbody>
            </table>
            <p style="text-align:right; margin-top:20px;"><strong>Total Harga:</strong> ${total}</p>
        </div>
    `;

        const printWindow = window.open('', '', 'width=800,height=600');
        printWindow.document.write(`<html><head><title>Invoice</title></head><body>${html}</body></html>`);
        printWindow.document.close();
        printWindow.focus();
        printWindow.print();
        printWindow.close();
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const uangDibayarInput = document.getElementById('uangDibayar');
        const kembalianInput = document.getElementById('kembalian');
        const totalPriceSpan = document.getElementById('modalTotalPrice');

        uangDibayarInput.addEventListener('input', function() {
            const totalText = totalPriceSpan.textContent.replace(/[^\d]/g, '');
            const total = parseInt(totalText) || 0;

            const dibayar = parseInt(this.value) || 0;
            const kembalian = dibayar - total;

            kembalianInput.value = kembalian >= 0 ?
                kembalian.toLocaleString('id-ID') :
                'Kurang';
        });
    });
</script>


<script>
    let kodePembayaranGlobal = '';
    $(document).on('click', '.btn-bayar', function() {
        const kodePembayaran = $(this).data('kode');
        const namePelanggan = $(this).data('name');
        const phone = $(this).data('phone');
        const sales = $(this).data('sales');
        const status = $(this).data('status');

        kodePembayaranGlobal = kodePembayaran;

        $('#modalName').text(namePelanggan);
        $('#modalPhone').text(phone);
        $('#modalSales').text(sales);
        $('#modalKode').text(kodePembayaran);
        $('#modalStatus').text(status);

        $.ajax({
            url: '/orders/' + kodePembayaran,
            type: 'GET',
            success: function(response) {
                let productsHtml = '';
                let totalPrice = 0;

                response.products.forEach(product => {
                    productsHtml += `<tr><td>${product.product_name}</td><td>Rp. ${parseInt(product.product_price).toLocaleString()}</td></tr>`;
                    totalPrice += parseInt(product.product_price);
                });

                $('#modalProducts').html(productsHtml);
                $('#modalTotalPrice').text('Rp. ' + totalPrice.toLocaleString());

                const modal = new bootstrap.Modal(document.getElementById('orderModal'));
                modal.show();
            },
            error: function() {
                alert('Gagal mengambil data produk.');
            }
        });
    });

    $(document).on('click', '.btn-detail', function() {
        const kodePembayaran = $(this).data('kode');
        const namePelanggan = $(this).data('name');
        const phone = $(this).data('phone');
        const sales = $(this).data('sales');

        $('#btnSimpan').hide();

        $('#modalNameDetail').text(namePelanggan);
        $('#modalPhoneDetail').text(phone);
        $('#modalSalesDetail').text(sales);
        $('#modalKodeDetail').text(kodePembayaran);

        $.ajax({
            url: '/orders/' + kodePembayaran,
            type: 'GET',
            success: function(response) {
                let productsHtml = '';
                let totalPrice = 0;

                response.products.forEach(product => {
                    productsHtml += `<tr>
                                    <td>${product.product_name}</td>
                                    <td>Rp. ${parseInt(product.product_price).toLocaleString()}</td>
                                    <td>${product.bonus || 'Tidak ada bonus'}</td>
                                    <td>${product.garansi || 'Tidak ada garansi'}</td>
                                  </tr>`;
                    totalPrice += parseInt(product.product_price);
                });

                $('#modalProductsDetail').html(productsHtml);
                $('#modalTotalPriceDetail').text('Rp. ' + totalPrice.toLocaleString());

                if (response.products.length > 0) {
                    $('#modalKodeDetail').text(response.products[0].kode_pembayaran);
                    $('#modalNameDetail').text(response.products[0].name_pelanggan);
                    $('#modalPhoneDetail').text(response.products[0].no_telpon);
                    $('#modalSalesDetail').text(response.products[0].name_sales);
                    $('#modalStatus').text(response.products[0].status);
                }

                const modal = new bootstrap.Modal(document.getElementById('orderDetailModal'));
                modal.show();
            },
            error: function() {
                alert('Gagal mengambil data produk.');
            }
        });
    });


    $('#btnSimpan').on('click', function() {
        const metodePembayaran = $('#metodePembayaran').val();
        const uangDibayarStr = $('#uangDibayar').val();
        const uangDibayar = parseInt(uangDibayarStr);
        const totalText = $('#modalTotalPrice').text().replace(/[^\d]/g, '');
        const totalHarga = parseInt(totalText) || 0;
        const kembalian = uangDibayar - totalHarga;

        console.log("Uang Dibayar:", uangDibayar);
        console.log("Total Harga:", totalHarga);
        console.log("Kembalian:", kembalian);


        // Validasi
        if (!metodePembayaran) {
            Swal.fire('Peringatan', 'Silakan pilih metode pembayaran terlebih dahulu.', 'warning');
            return;
        }

        if (uangDibayarStr.trim() === '' || isNaN(uangDibayar)) {
            Swal.fire('Peringatan', 'Masukkan jumlah uang yang dibayar.', 'warning');
            return;
        }

        if (kembalian < 0) {
            Swal.fire('Peringatan', 'Uang dibayar kurang dari total harga.', 'warning');
            return;
        }

        // Konfirmasi
        Swal.fire({
            title: 'Yakin ingin menyelesaikan pembayaran?',
            text: "Tindakan ini akan mengubah status semua transaksi terkait menjadi 'Dibayar'. Pastikan data sudah benar sebelum melanjutkan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Bayar!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("sales-order.updateStatus") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        kode_pembayaran: kodePembayaranGlobal,
                        metode_pembayaran: metodePembayaran,
                        uang_bayar: uangDibayarStr,
                        kembali: kembalian
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            $('#btnSimpan').hide();
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: 'Gagal!',
                            text: xhr.responseJSON.message || 'Terjadi kesalahan saat memperbarui status.',
                            icon: 'error'
                        });
                    }
                });

            }
        });
    });


    $(document).on('click', '.btn-delete', function() {
        const kodePembayaran = $(this).data('kode');

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data pesanan ini akan dihapus dan tidak dapat dikembalikan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/orders/delete/' + kodePembayaran,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Terhapus!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: 'Gagal!',
                            text: xhr.responseJSON.message || 'Terjadi kesalahan saat menghapus data.',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    });
</script>

@endsection