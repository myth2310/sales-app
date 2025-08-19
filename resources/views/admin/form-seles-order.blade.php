@extends('layouts.base')

@section('content')

<h4 class="mb-4">Form Order Pelanggan</h4>

<form id="formOrder" method="POST">
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
        <div class="col-md-1">
          <input type="number" name="barang[0][jumlah]" class="form-control jumlah-field" placeholder="Jumlah" min="1" value="1">
          <input type="hidden" class="stok-field" name="barang[0][stok]" value="0">
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
    <button type="submit" id="simpanOrder" class="btn btn-primary">Simpan Order</button>
  </div>
</form>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  let index = 1;

  function updateTotalHarga() {
    let total = 0;
    $('.barang-item').each(function() {
      const price = parseFloat($(this).find('.price-field').val()) || 0;
      const diskon = parseFloat($(this).find('.diskon-field').val()) || 0;
      const jumlah = parseInt($(this).find('.jumlah-field').val()) || 1;
      total += (price - diskon) * jumlah;
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
        <div class="col-md-1">
          <input type="number" name="barang[${index}][jumlah]" class="form-control jumlah-field" placeholder="Jumlah" min="1" value="1">
          <input type="hidden" class="stok-field" name="barang[${index}][stok]" value="0">
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
                data-stok="${product.stok}" 
                style="cursor:pointer;">${product.name} (Stok: ${product.stok})</li>`;
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
    parent.find('.stok-field').val(li.data('stok'));

    parent.find('.jumlah-field').val(1);

    li.closest('.suggestion-box').hide();
    updateTotalHarga();
  });


  $(document).on('keyup change', '.jumlah-field', function() {
    const parent = $(this).closest('.barang-item');
    const stok = parseInt(parent.find('.stok-field').val()) || 0;
    let jumlah = parseInt($(this).val()) || 1;

    if (stok > 0 && jumlah > stok) {
      Swal.fire({
        icon: 'warning',
        title: 'Jumlah Melebihi Stok!',
        text: 'Maksimal jumlah yang bisa dipesan adalah ' + stok,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
      });
      jumlah = stok;
      $(this).val(jumlah);
    }
    if (jumlah < 1) {
      $(this).val(1);
    }

    updateTotalHarga();
  });

  $(document).on('click', function(e) {
    if (!$(e.target).closest('.name-barang, .suggestion-box').length) {
      $('.suggestion-box').hide();
    }
  });
</script>

<script>
  $('#formOrder').on('submit', function(e) {
    e.preventDefault();
    Swal.fire({
      title: 'Konfirmasi Pesanan',
      text: "Apakah pesanan sudah sesuai?",
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Ya, Simpan',
      cancelButtonText: 'Periksa Lagi',
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '/order',
          type: 'POST',
          data: $('#formOrder').serialize(),
          success: function(response) {
            Swal.fire({
              title: 'Berhasil!',
              text: 'Pesanan berhasil disimpan.',
              icon: 'success',
              timer: 2000,
              showConfirmButton: false
            }).then(() => {
              location.reload();
            });
          },
          error: function() {
            Swal.fire({
              title: 'Gagal!',
              text: 'Terjadi kesalahan saat menyimpan pesanan.',
              icon: 'error',
              confirmButtonText: 'OK'
            });
          }
        });
      }
    });
  });
</script>
@endsection