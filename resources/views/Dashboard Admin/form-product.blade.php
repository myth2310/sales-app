@extends('layouts.base')

@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <h4 class="mb-4">Tambah Product Baru</h4>
        <form action="" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="mb-3">
            <label for="productName" class="form-label">Nama Produk</label>
            <input type="text" class="form-control" id="productName" name="name" placeholder="Masukkan nama produk" required>
          </div>
          <div class="mb-3">
            <label for="productDescription" class="form-label">Deskripsi Produk</label>
            <textarea class="form-control" id="productDescription" name="description" rows="3" placeholder="Masukkan deskripsi produk"></textarea>
          </div>
          <div class="mb-3">
            <label for="productPrice" class="form-label">Harga</label>
            <input type="number" class="form-control" id="productPrice" name="price" placeholder="Masukkan harga produk" required>
          </div>
          <div class="mb-3">
            <label for="productDiskon" class="form-label">Diskon</label>
            <input type="text" class="form-control" id="productDiskon" name="Diskon" placeholder="Masukkan Diskon" required>
          </div>
          <div class="mb-3">
            <label for="productCategory" class="form-label">Kategori</label>
            <select class="form-select" id="productCategory" name="category_id" required>
              <option value="" selected disabled>Pilih kategori</option>
              <option value="">Aksesoris</option>
              <option value="">Aksesoris</option>
              <option value="">Aksesoris</option>
              <option value="">Aksesoris</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection
