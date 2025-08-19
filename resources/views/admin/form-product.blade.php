@extends('layouts.base')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <h4 class="mb-4">Tambah Produk</h4>
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
            <label class="form-label">Jenis Produk</label><br>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="is_preorder" id="ready" value="0"
                {{ old('is_preorder', $product->is_preorder ?? 0) == 0 ? 'checked' : '' }}>
              <label class="form-check-label" for="ready">Ready Stock</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="is_preorder" id="preorder" value="1"
                {{ old('is_preorder', $product->is_preorder ?? 0) == 1 ? 'checked' : '' }}>
              <label class="form-check-label" for="preorder">Pre-Order</label>
            </div>
          </div>

          <!-- Stok Fisik -->
          <div class="mb-3" id="stokFisikDiv">
            <label for="stok" class="form-label">Stok Barang (Fisik)</label>
            <input type="number" class="form-control" id="stok" name="stok"
              value="{{ old('stok', $product->stok ?? '') }}" placeholder="Masukan Stok Produk">
          </div>

          <div class="preorder-fields mb-3" id="preorderDiv">
            <label for="stok_preorder" class="form-label">Stok Pre-Order</label>
            <input type="number" class="form-control mb-2" id="stok_preorder" name="stok_preorder"
              value="{{ old('stok_preorder', $product->stok_preorder ?? '') }}" placeholder="Masukan Stok Pre Order Produk">

            <label for="availableDate" class="form-label">Tanggal Ketersediaan (Pre-Order)</label>
            <input type="date" class="form-control" id="availableDate" name="available_date"
              value="{{ old('available_date', $product->available_date ?? '') }}">
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
              @foreach ($category as $cat)
              <option value="{{ $cat->id }}" {{ $cat->id == old('category_id') ? 'selected' : '' }}>
                {{ $cat->name }}
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


<script>
  document.addEventListener('DOMContentLoaded', function() {
    const readyRadio = document.getElementById('ready');
    const preorderRadio = document.getElementById('preorder');
    const stokFisikDiv = document.getElementById('stokFisikDiv');
    const preorderDiv = document.getElementById('preorderDiv');

    function toggleFields() {
      if (preorderRadio.checked) {
        preorderDiv.style.display = 'block';
        stokFisikDiv.style.display = 'none';
      } else {
        preorderDiv.style.display = 'none';
        stokFisikDiv.style.display = 'block';
      }
    }

    readyRadio.addEventListener('change', toggleFields);
    preorderRadio.addEventListener('change', toggleFields);
    toggleFields();
  });
</script>
@endsection