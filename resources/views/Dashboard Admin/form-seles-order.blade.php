@extends('layouts.base')

@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <h4 class="mb-4">Seles Order</h4>
        <form action="" method="POST">
          @csrf
          <div class="mb-4">
            <label for="NameBarang" class="form-label">Nama Barang</label>
            <input type="text" class="form-control" id="NameBarang" name="name barang" placeholder="Masukkan nama barang" required>
          </div>
          <div class="mb-4">
            <label for="garansi" class="form-label">Garansi</label>
            <input type="text" class="form-control" id="garansi" name="garansi" placeholder="Masukkan garansi" required>
          </div>
          <div class="mb-4">
            <label for="harga" class="form-label">Harga</label>
            <input type="text" class="form-control" id="customerPhone" name="phone" placeholder="Masukkan Harga" required>
          </div>
          <div class="mb-4">
            <label for="Diskon" class="form-label">Diskon</label>
            <input type="text" class="form-control" id="Diskon" name="Diskon" placeholder="Masukkan Diskon" required>
          </div>
          <div class="mb-4">
            <label for="bonus" class="form-label">Bonus</label>
            <textarea class="form-control" id="bonus" name="bonus" rows="4" placeholder="Masukkan Bonus"></textarea>
          </div>
          <div class="mb-4">
            <label for="tambahan" class="form-label">Tambahan</label>
            <textarea class="form-control" id="tambahan" name="tambahan" rows="4" placeholder="Masukkan Tambahan Pesanan "></textarea>
          </div>
          <div class="mb-4">
            <label for="NamePelanggan" class="form-label">Nama Pelanggan</label>
            <input type="text" class="form-control" id="NamePelanggan" name="name barang" placeholder="Masukkan Nama Pelanggan" required>
          </div>
          <div class="mb-4">
            <label for="Alamat" class="form-label">Alamat</label>
            <input type="text" class="form-control" id="Alamat" name="Alamat" placeholder="Masukkan Alamat" required>
          </div>
          <div class="mb-4">
            <label for="Email" class="form-label">Email</label>
            <input type="email" class="form-control" id="Email" name="Email" placeholder="Masukkan Email" required>
          </div>
          <div class="mb-4">
            <label for="NoTelpon" class="form-label">No. Telpon</label>
            <input type="number" class="form-control" id="NoTelpon" name="NoTelpon" placeholder="Masukkan No Telpon" required>
          </div>
          <div class="mb-4">
            <label for="NameSeles" class="form-label">Nama Seles</label>
            <input type="text" class="form-control" id="NameSeles" name="NameSeles" placeholder="Masukkan NameSeles" required>
          </div>

          <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection
