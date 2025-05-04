<div class="barang-item row g-3 mb-3">
  <div class="col-md-3">
    <select name="barang[{{ $index }}][id]" class="form-select barang-select" id="barang-select-{{ $index }}" required></select>
  </div>
  <div class="col-md-2">
    <input type="text" name="barang[{{ $index }}][garansi]" class="form-control" id="garansi-{{ $index }}" placeholder="Garansi" readonly>
  </div>
  <div class="col-md-2">
    <input type="number" name="barang[{{ $index }}][price]" class="form-control" id="price-{{ $index }}" placeholder="Harga" readonly>
  </div>
  <div class="col-md-2">
    <input type="number" name="barang[{{ $index }}][Diskon]" class="form-control" placeholder="Diskon">
  </div>
  <div class="col-md-2">
    <input type="text" name="barang[{{ $index }}][bonus]" class="form-control" placeholder="Bonus">
  </div>
  <div class="col-md-1 d-flex align-items-center">
    <button type="button" class="btn btn-danger btn-sm remove-item">X</button>
  </div>
</div>
