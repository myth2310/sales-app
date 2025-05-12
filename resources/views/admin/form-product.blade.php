@extends('layouts.base')

@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <h4 class="mb-4">Edit Produk</h4>
        <form action="{{ route('products.store') }}" method="POST">
          @csrf
          @method('POST') 

          <div class="mb-3">
            <label for="productName" class="form-label">Nama Produk</label>
            <input type="text" class="form-control" id="productName" name="name" value="{{ old('name') }}" placeholder="Masukan Nama Produk" required>
          </div>
          
          <div class="mb-3">
            <label for="productDescription" class="form-label">Deskripsi Produk</label>
            <textarea class="form-control" id="productDescription" name="description" placeholder="Masukan Deskripsi Produk">{{ old('description') }}</textarea>
          </div>

          <div class="mb-3">
            <label for="productBonus" class="form-label">Bonus</label>
            <textarea class="form-control" id="productBonus" name="bonus" placeholder="Masukan Bonus">{{ old('bonus') }}</textarea>
          </div>

          <div class="mb-3">
            <label for="productPrice" class="form-label">Harga</label>
            <input type="number" class="form-control" id="productPrice" name="price" value="{{ old('price') }}" placeholder="Masukan Harga Produk" required>
          </div>

          <div class="mb-3">
            <label for="productPrice" class="form-label">Stok Barang</label>
            <input type="number" class="form-control" id="stok" name="stok" value="{{ old('stok') }}" placeholder="Masukan Stok Produk" required>
          </div>

          <div class="mb-3">
            <label for="productGaransi" class="form-label">Garansi</label>
            <input type="text" class="form-control" name="garansi" value="{{ old('garansi') }}" placeholder="Masukan Garansi" required>
          </div>

          <div class="mb-3">
            <label for="productDiskon" class="form-label">Diskon</label>
            <input type="number" class="form-control" id="productDiskon" name="discount" value="{{ old('discount') }}" placeholder="Masukan Diskon Produk">
          </div>

          <div class="mb-3">
            <label for="productCategory" class="form-label">Kategori</label>
            <select class="form-select" id="productCategory" name="category_id" required>
              <option value="" disabled selected>Pilih kategori</option>
              @foreach ($category as $category)
                <option value="{{ $category->id }}" {{ $category->id == old('category_id') ? 'selected' : '' }}>
                  {{ $category->name }}
                </option>
              @endforeach
            </select>
          </div>

          <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection
