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
                <table class="table table-bordered table-striped datatable" id="orderTable">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th class="border-bottom-0">No</th>
                                <th class="border-bottom-0">Nama Pelanggan</th>
                                <th class="border-bottom-0">Alamat</th>
                                <th class="border-bottom-0">Email</th>
                                <th class="border-bottom-0">Nomer Telepon</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse ($customers as $index => $customer)
                            <tr>
                                <td class="border-bottom-0">{{ $index + 1 }}</td>
                                <td class="border-bottom-0">
                                    <h6 class="fw-semibold mb-1 text-dark">{{ $customer->name_pelanggan }}</h6>
                                </td>
                                <td class="border-bottom-0">
                                    <h6 class="mb-0 fw-normal text-muted">{{ $customer->alamat }}</h6>
                                </td>
                                <td class="border-bottom-0">
                                    <h6 class="mb-0 fw-normal text-muted">{{ $customer->email }}</h6>
                                </td>
                                <td class="border-bottom-0">
                                    <h6 class="mb-0 fw-normal text-muted">{{ $customer->no_telpon }}</h6>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data pelanggan yang tersedia</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection