@extends('layouts.base')

@section('content')

<div class="row">
  <div class="col-lg-4">
    <!-- Total Pelanggan -->
    <div class="card overflow-hidden">
      <div class="card-body p-4">
        <h5 class="card-title mb-9 fw-semibold">Total Pelanggan</h5>
        <div class="row align-items-center">
          <div class="col-8">
            <h4 class="fw-semibold mb-3">10</h4>
          </div>
          <div class="col-4">
            <div class="d-flex justify-content-center">
            <i class="fa-solid fa-user fa-2xl"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-4">
    <!-- Total Pelanggan -->
    <div class="card overflow-hidden">
      <div class="card-body p-4">
        <h5 class="card-title mb-9 fw-semibold">Total Order</h5>
        <div class="row align-items-center">
          <div class="col-8">
            <h4 class="fw-semibold mb-3">10</h4>
          </div>
          <div class="col-4">
            <div class="d-flex justify-content-center">
          <i class="fa-solid fa-cart-shopping fa-2xl"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-4">
    <!-- Total Pelanggan -->
    <div class="card overflow-hidden">
      <div class="card-body p-4">
        <h5 class="card-title mb-9 fw-semibold">Total Sales</h5>
        <div class="row align-items-center">
          <div class="col-8">
            <h4 class="fw-semibold mb-3">10</h4>
          </div>
          <div class="col-4">
            <div class="d-flex justify-content-center">
            <i class="fa-solid fa-universal-access fa-2xl"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>


@endsection