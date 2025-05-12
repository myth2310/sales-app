@extends('layouts.base')

@section('content')
<div class="container py-4">
  <h4 class="mb-4">Form Order Pelanggan</h4>

  <form action="/order" method="POST">
    @csrf
    <div class="card mb-4">
      <div class="card-header d-flex justify-content-between align-items-center">
        <span class="fw-bold">Daftar Barang</span>
        <button type="button" id="add-barang" class="btn btn-sm btn-success">+ Tambah Barang</button>
      </div>
      <div class="card-body" id="barang-container">
        <div class="barang-item row g-3 mb-3 position-relative">
          <div class="col-md-3 position-relative">
            <input type="text" name="barang[0][name_barang]" class="form-control name-barang" placeholder="Nama Barang" autocomplete="off" required>
            <input type="hidden" name="barang[0][id_product]" class="product-id">
            <div class="suggestion-box position-absolute w-100" style="z-index: 1000;"></div>
          </div>
          <div class="col-md-2">
            <input type="text" name="barang[0][garansi]" class="form-control garansi-field" placeholder="Garansi">
          </div>
          <div class="col-md-2">
            <input type="number" name="barang[0][price]" class="form-control price-field" placeholder="Harga" readonly>
          </div>
          <div class="col-md-2">
            <input type="number" name="barang[0][Diskon]" class="form-control diskon-field" placeholder="Diskon" readonly>
          </div>
          <div class="col-md-2">
            <input type="text" name="barang[0][bonus]" class="form-control" placeholder="Bonus" readonly>
          </div>
          <div class="col-md-1 d-flex align-items-center">
            <button type="button" class="btn btn-outline-danger btn-sm remove-item">X</button>
          </div>
        </div>
      </div>
      <div class="card-footer text-end">
        <strong>Total Harga: Rp <span id="total-harga">0</span></strong>
      </div>
    </div>
    <div class="card mb-4">
      <div class="card-header fw-bold">Informasi Pelanggan</div>
      <div class="card-body row g-3">
        <div class="col-md-6">
          <label class="form-label">Nama Pelanggan</label>
          <input type="text" name="name_pelanggan" placeholder="Masukan Nama Pelanggan" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">No HP</label>
          <input type="text" name="no_telepon" placeholder="Masukan No HP/Telp" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Alamat</label>
          <input type="text" name="alamat" placeholder="Masukan Alamat Pelanggan" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" placeholder="Masukan Email Pelanggan" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Nama Sales</label>
          <input type="text" name="name_sales" placeholder="Masukan Nama Sales" class="form-control" required>
        </div>
      </div>
    </div>
    <div class="text-end">
      <button type="submit" class="btn btn-primary">Simpan Order</button>
    </div>
  </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  let index = 1;

  function updateTotalHarga() {
    let total = 0;
    $('.barang-item').each(function() {
      const price = parseFloat($(this).find('.price-field').val()) || 0;
      const diskon = parseFloat($(this).find('.diskon-field').val()) || 0;
      total += price - diskon;
    });
    $('#total-harga').text(total.toLocaleString('id-ID'));
  }

  $('#add-barang').on('click', function() {
    const html = `
      <div class="barang-item row g-3 mb-3 position-relative">
        <div class="col-md-3 position-relative">
          <input type="text" name="barang[${index}][name_barang]" class="form-control name-barang" placeholder="Nama Barang" autocomplete="off" required>
          <input type="hidden" name="barang[${index}][id_product]" class="product-id">
          <div class="suggestion-box position-absolute w-100" style="z-index: 1000;"></div>
        </div>
        <div class="col-md-2">
          <input type="text" name="barang[${index}][garansi]" class="form-control garansi-field" placeholder="Garansi">
        </div>
        <div class="col-md-2">
          <input type="number" name="barang[${index}][price]" class="form-control price-field" placeholder="Harga" readonly>
        </div>
        <div class="col-md-2">
          <input type="number" name="barang[${index}][Diskon]" class="form-control diskon-field" placeholder="Diskon" readonly>
        </div>
        <div class="col-md-2">
          <input type="text" name="barang[${index}][bonus]" class="form-control" placeholder="Bonus" readonly>
        </div>
        <div class="col-md-1 d-flex align-items-center">
          <button type="button" class="btn btn-outline-danger btn-sm remove-item">X</button>
        </div>
      </div>`;
    $('#barang-container').append(html);
    index++;
  });

  $(document).on('click', '.remove-item', function() {
    $(this).closest('.barang-item').remove();
    updateTotalHarga();
  });

  $(document).on('keyup', '.name-barang', function() {
    const input = $(this);
    const query = input.val();
    const suggestionBox = input.closest('.col-md-3').find('.suggestion-box');

    if (query.length > 1) {
      $.ajax({
        url: "{{ route('search.product') }}",
        type: "GET",
        data: {
          query
        },
        success: function(data) {
          let list = '<ul class="list-group">';
          if (data.length > 0) {
            $.each(data, function(_, product) {
              list += `<li class="list-group-item list-product" 
                data-id="${product.id}" 
                data-name="${product.name}" 
                data-price="${product.price}" 
                data-bonus="${product.bonus}" 
                data-garansi="${product.garansi}" 
                data-diskon="${product.discount}" 
                style="cursor:pointer;">${product.name}</li>`;
            });
          } else {
            list += '<li class="list-group-item">Produk tidak ditemukan</li>';
          }
          list += '</ul>';
          suggestionBox.html(list).show();
        }
      });
    } else {
      suggestionBox.hide();
    }
  });

  $(document).on('click', '.list-product', function() {
    const li = $(this);
    const parent = li.closest('.barang-item');

    parent.find('.name-barang').val(li.data('name'));
    parent.find('.product-id').val(li.data('id'));
    parent.find('.price-field').val(li.data('price'));
    parent.find('.diskon-field').val(li.data('diskon'));
    parent.find('.garansi-field').val(li.data('garansi'));
    parent.find('input[name$="[bonus]"]').val(li.data('bonus'));
    li.closest('.suggestion-box').hide();
    updateTotalHarga();
  });

  $(document).on('click', function(e) {
    if (!$(e.target).closest('.name-barang, .suggestion-box').length) {
      $('.suggestion-box').hide();
    }
  });
</script>
@endsection