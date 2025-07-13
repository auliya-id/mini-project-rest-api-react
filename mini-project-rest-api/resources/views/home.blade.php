@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Header -->
    <div class="mb-4">
        <center>
            <h3 class="fw-bold">Selamat Datang, {{ Auth::user()->name }}! 👋</h3>
            <h5 class="text-muted">Dashboard Mini Project Rest API</h5>
        </center>
    </div>

    <div class="row">
        <center>
            <img src="{{ asset('assets/img/banner.jpg') }}" alt="Banner Home" style="width: auto; height: 500px">
        </center>
        <form id="form-penjualan">
  <!-- Header Transaksi -->
  <div class="card mb-4">
    <div class="card-header">Form Penjualan</div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-4">
          <label>Tanggal</label>
          <input type="date" name="tanggal" class="form-control" required>
        </div>
        <div class="col-md-4">
          <label>Pelanggan</label>
          <select name="id_pelanggan" class="form-control" required>
            <option value="">-- Pilih Pelanggan --</option>
            <!-- Loop dari controller -->
            <option value="1">ANDI</option>
            <option value="2">BUDI</option>
          </select>
        </div>
        <div class="col-md-4">
          <label>Kode Transaksi</label>
          <input type="text" name="kode" class="form-control" value="AUTO123" readonly>
        </div>
      </div>
    </div>
  </div>

  <!-- Detail Barang -->
  <div class="card">
    <div class="card-header">Detail Barang</div>
    <div class="card-body">
      <table class="table table-bordered" id="item-table">
        <thead>
          <tr>
            <th>Barang</th>
            <th>Harga</th>
            <th>Qty</th>
            <th>Total</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody id="items">
          <!-- Row dinamis -->
        </tbody>
      </table>
      <button type="button" class="btn btn-sm btn-primary" onclick="addRow()">+ Tambah Item</button>
      <hr>
      <h5 class="text-end">Subtotal: <span id="subtotal">0</span></h5>
      <button type="submit" class="btn btn-success float-end">Simpan Transaksi</button>
    </div>
  </div>
</form>

<script>
  const barangList = [
    { id: 1, nama: 'PEN', harga: 15000 },
    { id: 2, nama: 'PENSIL', harga: 10000 },
    { id: 3, nama: 'PAYUNG', harga: 70000 }
  ];

  let itemIndex = 0;

  function addRow() {
    let html = `<tr data-index="${itemIndex}">
      <td>
        <select name="items[${itemIndex}][barang_id]" class="form-control" onchange="updateHarga(this)">
          <option value="">-- Pilih --</option>
          ${barangList.map(b => `<option value="${b.id}" data-harga="${b.harga}">${b.nama}</option>`).join('')}
        </select>
      </td>
      <td><input type="text" class="form-control harga" name="items[${itemIndex}][harga]" readonly></td>
      <td><input type="number" class="form-control qty" name="items[${itemIndex}][qty]" min="1" value="1" onchange="updateTotal(this)"></td>
      <td><input type="text" class="form-control total" name="items[${itemIndex}][total]" readonly></td>
      <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button></td>
    </tr>`;
    document.getElementById('items').insertAdjacentHTML('beforeend', html);
    itemIndex++;
  }

  function updateHarga(select) {
    let harga = select.options[select.selectedIndex].dataset.harga;
    let row = select.closest('tr');
    row.querySelector('.harga').value = harga;
    updateTotal(select);
  }

  function updateTotal(input) {
    let row = input.closest('tr');
    let harga = parseInt(row.querySelector('.harga').value || 0);
    let qty = parseInt(row.querySelector('.qty').value || 0);
    let total = harga * qty;
    row.querySelector('.total').value = total;
    updateSubtotal();
  }

  function updateSubtotal() {
    let subtotal = 0;
    document.querySelectorAll('.total').forEach(t => {
      subtotal += parseInt(t.value || 0);
    });
    document.getElementById('subtotal').textContent = subtotal;
  }

  function removeRow(button) {
    button.closest('tr').remove();
    updateSubtotal();
  }
</script>

    </div>
</div>
@endsection
