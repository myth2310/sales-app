@extends('layouts.base')

@section('content')

<div class="row">
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

  <div class="col-lg-6">
    <!-- Total Pelanggan -->
    <div class="card overflow-hidden">
      <div class="card-body p-4">
        <h5 class="card-title mb-9 fw-semibold">Total Pelanggan</h5>
        <div class="row align-items-center">
          <div class="col-8">
            <h4 class="fw-semibold mb-3">{{ $totalPelanggan }}</h4>
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
  <div class="col-lg-6">
    <!-- Total Orders -->
    <div class="card overflow-hidden">
      <div class="card-body p-4">
        <h5 class="card-title mb-9 fw-semibold">Total Order</h5>
        <div class="row align-items-center">
          <div class="col-8">
            <h4 class="fw-semibold mb-3">{{ $totalOrders }}</h4>
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
</div>

<!-- Pie Chart -->
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title mb-4">Penjualan Per Produk</h5>
        <div class="d-flex justify-content-center align-items-center" style="width: 350px; height: 350px; margin: 0 auto;">
          <canvas id="salesPieChart"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('salesPieChart').getContext('2d');
  const salesData = @json($salesPerProduct);
  const labels = salesData.map(item => item.product_name);
  const data = salesData.map(item => item.total_sales);

  new Chart(ctx, {
    type: 'pie',
    data: {
      labels: labels,
      datasets: [{
        label: 'Total Penjualan',
        data: data,
        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#FF9F40'],
        hoverOffset: 4
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'top',
        },
        tooltip: {
          callbacks: {
            label: function(context) {
              return context.label + ': ' + context.raw + ' Penjualan';
            }
          }
        }
      }
    }
  });
</script>
@endsection