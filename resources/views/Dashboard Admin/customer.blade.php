@extends('layouts.base')

@section('content')

<div class="row">
    <div class="col-lg d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body p-4">
                <div class="row mb-4">
                    <div class="col">
                        <h5 class="card-title fw-semibold mb-4">Daftar Pelanggan</h5>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle" id="myTable">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th class="border-bottom-0">Id</th>
                                <th class="border-bottom-0">Nama Pelanggan</th>
                                <th class="border-bottom-0">Barang Pembelian</th>
                                <th class="border-bottom-0">Tanggal</th>
                                <th class="border-bottom-0">Struk</th>
                                <th class="border-bottom-0">Alamat</th>
                                <th class="border-bottom-0">Email</th>
                                <th class="border-bottom-0">Nomer Telepon</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border-bottom-0">1</td>
                                <td class="border-bottom-0">
                                    <h6 class="fw-semibold mb-1">Joshi</h6>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">Assus</p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">23 feb 2025</p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">Lihat Struk</p>
                                </td>
                                <td class="border-bottom-0">
                                    <h6 class="mb-0 fw-normal">Alamat</h6>
                                </td>
                                <td class="border-bottom-0">
                                    <h6 class="mb-0 fw-normal">Email</h6>
                                </td>
                                <td class="border-bottom-0">
                                    <h6 class="mb-0 fw-normal">085783643829</h6>
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