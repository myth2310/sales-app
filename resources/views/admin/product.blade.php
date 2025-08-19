@extends('layouts.base')

@section('content')
<div class="row">
    <div class="col-lg d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body p-4">
                <div class="row mb-4">
                    <div class="col">
                        <h5 class="card-title fw-semibold mb-4">Daftar Produk</h5>
                    </div>
                    <div class="col d-flex justify-content-end">
                        @if(Auth::user()->role == 'super admin' || Auth::user()->role == 'admin')
                        <a href="{{ route('dashboard.form-product') }}" class="btn btn-primary m-1">
                            <i class="ti ti-plus m-1"></i>Tambah Produk
                        </a>
                        @endif
                    </div>
                </div>

                @if (isset($outOfStockProducts) && $outOfStockProducts->count() > 0)
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Perhatian!</strong> Produk berikut memiliki stok kosong:
                    <ul>
                        @foreach ($outOfStockProducts as $product)
                        <li>- {{ $product->name ?? 'Tidak ditemukan nama produk' }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif


                <div class="table-responsive">
                    <table class="table table-bordered table-striped datatable" id="orderTable">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Pre Order</th>
                                <th>Tgl Tersedia</th>
                                <th>Deskripsi</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Stok Pre Order</th>
                                <th>Jumlah Pre Order</th>
                                <th>Garansi</th>
                                <th>Diskon</th>
                                <th>Bonus</th>
                                @if(Auth::user()->role == 'super admin' || Auth::user()->role == 'admin')
                                <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td class="fw-semibold">{{ $product->name }}</td>
                                <td>{{ $product->category->name ?? 'Tidak ada kategori' }}</td>
                                <td>{{ $product->is_preorder ? 'Ya' : 'Tidak' }}</td>
                                <td>
                                    {{ $product->available_date ? \Carbon\Carbon::parse($product->available_date)->format('d-m-Y') : '-' }}
                                </td>
                                <td style="white-space: normal; max-width: 300px;">{{ $product->description }}</td>
                                <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td>
                                    <strong></strong> {{ $product->stok }}
                                    <button class="btn btn-sm btn-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#updateStockModal{{ $product->id }}">
                                        Ubah Stok Fisik
                                    </button>
                                </td>
                                <td>
                                    <div>
                                        <strong>Pre-Order:</strong> {{ $product->stok_preorder }}
                                    </div>
                                    <div class="text-muted small">
                                        <i class="bi bi-calendar-event"></i>
                                        Tgl Datang: {{ $product->available_date }}

                                        <div>
                                            @if($product->is_preorder == 1 && $product->stok_preorder > 0)
                                            <form id="sync-preorder-form-{{ $product->id }}"
                                                action="{{ route('product.syncPreorder', $product->id) }}"
                                                method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="button" class="btn btn-sm btn-warning"
                                                    onclick="confirmSync({{ $product->id }})">
                                                    <i class="fa fa-sync"></i> Sync Stok Pre-Order
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </div>
                                </td>


                                <td>{{ $product->preorder_quantity }}</td>
                                <td>{{ $product->garansi }}</td>
                                <td>{{ $product->discount ?? 0 }}%</td>
                                <td>{{ $product->bonus ?? '-' }}</td>
                                @if(Auth::user()->role == 'super admin' || Auth::user()->role == 'admin')
                                <td>
                                    <a href="{{ route('product.edit', $product->id) }}" class="btn btn-warning btn-sm">
                                        <i class="ti ti-pencil"></i> Edit
                                    </a>
                                    <form action="{{ route('product.destroy', $product->id) }}" method="POST" style="display:inline;" id="delete-form-{{ $product->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="{{ $product->id }}">
                                            <i class="ti ti-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>

                                <!-- Modal Update Stok -->
                                <div class="modal fade" id="updateStockModal{{ $product->id }}" tabindex="-1" aria-labelledby="updateStockLabel{{ $product->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('product.updateStock', $product->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="updateStockLabel{{ $product->id }}">Update Stok & Status Produk</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Jenis Produk</label><br>

                                                        @if($product->stok == 0 && $product->stok_preorder == 0)
                                                        {{-- Jika stok fisik = 0 dan stok preorder = 0 → tampilkan keduanya --}}
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input toggle-preorder" type="radio"
                                                                name="is_preorder" id="ready{{ $product->id }}"
                                                                value="0" {{ $product->is_preorder == 0 ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="ready{{ $product->id }}">Ready Stock</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input toggle-preorder" type="radio"
                                                                name="is_preorder" id="preorder{{ $product->id }}"
                                                                value="1" {{ $product->is_preorder == 1 ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="preorder{{ $product->id }}">Pre-Order</label>
                                                        </div>

                                                        @elseif($product->stok > 0)
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input toggle-preorder" type="radio"
                                                                name="is_preorder" id="ready{{ $product->id }}"
                                                                value="0" {{ $product->is_preorder == 0 ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="ready{{ $product->id }}">Ready Stock</label>
                                                        </div>

                                                        @elseif($product->stok_preorder > 0)
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input toggle-preorder" type="radio"
                                                                name="is_preorder" id="preorder{{ $product->id }}"
                                                                value="1" {{ $product->is_preorder == 1 ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="preorder{{ $product->id }}">Pre-Order</label>
                                                        </div>
                                                        @elseif($product->stok > 0 && $product->stok_preorder == 0 )
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input toggle-preorder" type="radio"
                                                            name="is_preorder" id="ready{{ $product->id }}"
                                                            value="0" {{ $product->is_preorder == 0 ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="ready{{ $product->id }}">Ready Stock</label>
                                                        </div>
                                                        @elseif($product->stok_preorder > 0 && $product->stok == 0 )
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input toggle-preorder" type="radio"
                                                                name="is_preorder" id="preorder{{ $product->id }}"
                                                                value="1" {{ $product->is_preorder == 1 ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="preorder{{ $product->id }}">Pre-Order</label>
                                                        </div>
                                                        @endif

                                                    </div>
                                                    <div class="mb-3 stock-group" id="stockGroup{{ $product->id }}" style="{{ $product->is_preorder == 0 ? '' : 'display:none;' }}">
                                                        <label for="stok{{ $product->id }}" class="form-label">Jumlah Stok Fisik</label>
                                                        <input type="number" class="form-control" id="stok{{ $product->id }}" name="stok" value="{{ $product->stok }}">
                                                    </div>
                                                    <div class="preorder-group" id="preorderGroup{{ $product->id }}" style="{{ $product->is_preorder == 1 ? '' : 'display:none;' }}">
                                                        <div class="mb-3">
                                                            <label for="stok_preorder{{ $product->id }}" class="form-label">Jumlah Stok Pre-Order</label>
                                                            <input type="number" class="form-control" id="stok_preorder{{ $product->id }}"
                                                                name="stok_preorder" value="{{ $product->stok_preorder }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="available_date{{ $product->id }}" class="form-label">Tanggal Tersedia</label>
                                                            <input type="date" class="form-control" id="available_date{{ $product->id }}"
                                                                name="available_date" value="{{ $product->available_date }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>




<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.querySelectorAll('.delete-btn').forEach((btn) => {
        btn.addEventListener('click', function() {
            const productId = btn.getAttribute('data-id');
            const form = document.getElementById('delete-form-' + productId);
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Produk ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                    Swal.fire(
                        'Dihapus!',
                        'Produk telah dihapus.',
                        'success'
                    );
                }
            });
        });
    });
</script>

<script>
    function confirmSync(productId) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Stok preorder akan dipindahkan ke stok fisik!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, sync sekarang!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('sync-preorder-form-' + productId).submit();
            }
        });
    }
</script>

<script>
    $(function() {
        $('.toggle-preorder').on('change', function() {
            let productId = $(this).attr('id').replace(/\D/g, '');
            if ($(this).val() == "1") {
                $('#stockGroup' + productId).hide();
                $('#preorderGroup' + productId).show();
            } else {
                $('#stockGroup' + productId).show();
                $('#preorderGroup' + productId).hide();
            }
        });
    });
</script>


@endsection