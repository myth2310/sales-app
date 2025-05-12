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
                                <th>Deskripsi</th>
                                <th>Harga</th>
                                <th>Stok</th>
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
                                <td style="white-space: normal; max-width: 300px;">{{ $product->description }}</td>
                                <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td>{{ $product->stok }}</td>
                                <td>{{ $product->garansi }}</td>
                                <td>{{ $product->discount }}%</td>
                                <td>{{ $product->bonus }}</td>
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
                                @endif
                            </tr>
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

@endsection