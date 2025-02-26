@extends('layouts.base')

@section('content')

<div class="row">
    <div class="col-lg d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body p-4">
                <div class="row mb-4">
                    <div class="col">
                        <h5 class="card-title fw-semibold mb-4">Daftar Product</h5>
                    </div>
                    <div class="col d-flex justify-content-end">
                        <a href="{{ route('dashboard.form-product') }}" class="btn btn-primary m-1"><i class="ti ti-plus m-1"></i>Tambah Product</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle" id="myTable">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th class="border-bottom-0">Id</th>
                                <th class="border-bottom-0">Nama Produk</th>
                                <th class="border-bottom-0">Deskripsi Produk</th>
                                <th class="border-bottom-0">Harga</th>
                                <th class="border-bottom-0">Diskon</th>
                                <th class="border-bottom-0">Kategori</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border-bottom-0">1</td>
                                <td class="border-bottom-0">
                                    <h6 class="fw-semibold mb-1">Asus</h6>
                                </td>
                                <td class="border-bottom-0 word-wrap">
                                    <p class="mb-0 fw-normal">
                                        Intel® Celeron® N4020 Processor 1.1 GHz (4M Cache, up to 2.8 GHz)
                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-primary rounded-3 fw-semibold">12juta</span>
                                    </div>
                                </td>
                                <td class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0 fs-4">10%</h6>
                                </td>
                                <td class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0 fs-4">leptop</h6>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection