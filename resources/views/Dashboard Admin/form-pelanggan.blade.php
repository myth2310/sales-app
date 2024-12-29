@extends('layouts.base')

@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <h4 class="mb-4">Tambah Pelanggan Baru</h4>
        <form action="" method="POST">
          @csrf
          <div class="mb-3">
            <label for="customerName" class="form-label">Nama Pelanggan</label>
            <input type="text" class="form-control" id="customerName" name="name" placeholder="Masukkan nama pelanggan" required>
          </div>
          <div class="mb-3">
            <label for="customerEmail" class="form-label">Email</label>
            <input type="email" class="form-control" id="customerEmail" name="email" placeholder="Masukkan email pelanggan" required>
          </div>
          <div class="mb-3">
            <label for="customerPhone" class="form-label">Nomor Telepon</label>
            <input type="text" class="form-control" id="customerPhone" name="phone" placeholder="Masukkan nomor telepon pelanggan" required>
          </div>
          <div class="mb-3">
            <label for="customerAddress" class="form-label">Alamat</label>
            <textarea class="form-control" id="customerAddress" name="address" rows="3" placeholder="Masukkan alamat pelanggan"></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection
