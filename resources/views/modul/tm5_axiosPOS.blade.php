@extends('layouts.main')

@section('content')
    <div class="page-header">
        <h3 class="page-title"> Index Barang dengan Table HTML </h3>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <form id="inputForm">
                        <div class="form-group">
                            <label>Kode Barang</label>
                            <input type="text" class="form-control" id="kodeBarang">
                        </div>
                        
                        <div class="form-group">
                            <label>Nama Barang</label>
                            <input type="text" class="form-control" id="namaBarang" readonly>
                        </div>

                        <div class="form-group">
                            <label>Harga Barang</label>
                            <input type="text" class="form-control" id="hargaBarang" readonly>
                        </div>

                        <div class="form-group">
                            <label>Jumlah</label>
                            <input type="number" class="form-control" id="jumlahBarang" readonly>
                        </div>
                    </form>

                    <button id="buttonTambah" class="btn btn-primary" disabled>
                        Tambah
                    </button>

                    <hr>

                    <table id="tableBarang" class="table table-bordered">
                        <thead>
                            <tr>
                                <td>Kode</td>
                                <td>Nama</td>
                                <td>Harga</td>
                                <td>Jumlah</td>
                                <td>Subtotal</td>
                                <td>Aksi</td>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>

                    <h3>Total: <span id="totalHarga">0</span></h3>

                    <button id="buttonBayar" class="btn btn-primary" disabled>
                        Bayar
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script-page')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        var totalHarga = 0;

        $(document).ready(function() {
            $('#kodeBarang').keypress(function(e) {
                if (e.which == 13) {
                    let kodeBarang = $(this).val();

                    axios.get("{{ route('findBarang') }}", {
                        params: { idbarang: kodeBarang }
                    }).then(res => {
                        let response = res.data;

                        if(response.status == 'success') {
                            $('#namaBarang').val(response.data.nama_barang);
                            $('#hargaBarang').val(response.data.harga);
                            $('#jumlahBarang').prop('readonly', false).val(1);
                            $('#buttonTambah').prop('disabled', false);
                        } else {
                            alert(response.message);
                        }
                    }).catch(() => {
                        Swal.fire('Error', 'Server Error', 'error');
                    });
                }
            });

            $('#buttonTambah').click(function() {
                $('#buttonTambah').html(
                    '<span class="spinner-border spinner-border-sm"></span> Loading'
                )
                $('#buttonTambah').prop('disabled', true);

                setTimeout(function(){
                    tambahBarang();
                },1000);
            });

            $('#buttonBayar').click(function() {
                $('#buttonBayar').html(
                    '<span class="spinner-border spinner-border-sm"></span> Loading'
                )
                $('#buttonBayar').prop('disabled', true);

                setTimeout(function(){
                    pembayaran();
                },1000);
            })

            $(document).on('input', '.jumlah', function() {
                let row = $(this).closest('tr');

                let harga = parseInt(row.find('td:eq(2)').text());
                let jumlah = parseInt($(this).val());

                if (jumlah < 1 || isNaN(jumlah)) {
                    jumlah = 1;
                    $(this).val(1);
                }

                let subtotal = harga * jumlah;

                row.find('.subtotal').text(subtotal);

                hitungTotal();
            });

            $(document).on('click', '.buttonHapus', function() {
                let row = $(this).closest('tr');
                let button = $(this);

                button.html(
                    '<span class="spinner-border spinner-border-sm"></span>'
                )
                button.prop('disabled', true);

                setTimeout(function(){
                    row.remove();
                    hitungTotal();
                },1000);
                
            });
        });

        function tambahBarang() {
            let kode = $('#kodeBarang').val().toUpperCase();
            let nama = $('#namaBarang').val();
            let harga = parseInt($('#hargaBarang').val());
            let jumlah = parseInt($('#jumlahBarang').val());

            let subtotal = harga * jumlah;
            
            let existingRow = $(`#tableBarang tbody tr[data-kode="${kode}"]`);

            if (existingRow.length > 0) {
                existingRow.find('.jumlah').val(jumlah);
                existingRow.find('.subtotal').text(subtotal);
            } else {
                let row = `
                    <tr data-kode="${kode}">
                        <td>${kode}</td>
                        <td>${nama}</td>
                        <td>${harga}</td>
                        <td>
                            <input type="number" class="jumlah" value="${jumlah}">
                        </td>
                        <td class="subtotal">${subtotal}</td>
                        <td><button class="buttonHapus btn btn-danger btn-sm">X</button></td>
                    </tr>
                `
                $('#tableBarang tbody').append(row);
            }
            hitungTotal();

            $('#kodeBarang').val("");
            $('#namaBarang').val("");
            $('#hargaBarang').val("");
            $('#jumlahBarang').val("");

            $('#jumlahBarang').prop('readonly', true)
            $('#buttonTambah').html("Tambah");
        }

        function pembayaran() {

            let dataBarang = [];

            $('#tableBarang tbody tr').each(function() {
                let row = $(this);

                let kode = row.find('td:eq(0)').text();
                let nama = row.find('td:eq(1)').text();
                let harga = parseInt(row.find('td:eq(2)').text());
                let jumlah = parseInt(row.find('.jumlah').val());
                let subtotal = parseInt(row.find('.subtotal').text());

                dataBarang.push({
                    kode: kode,
                    nama: nama,
                    harga: harga,
                    jumlah: jumlah,
                    subtotal: subtotal
                });
            });

            if (dataBarang.length === 0) {
                Swal.fire('Warning', 'Tidak ada barang!', 'warning');
                $('#buttonBayar').html('Bayar').prop('disabled', false);
                return;
            }

            axios.post("{{ route('store') }}", {
                total: totalHarga,
                items: dataBarang
            }, {
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            }).then(res => {
                Swal.fire('Sukses', 'Transaksi berhasil!', 'success');
                resetTransaksi();
            }).catch(() => {
                Swal.fire('Error', 'Gagal menyimpan transaksi', 'error');
            }).finally(() => {
                $('#buttonBayar').html('Bayar');
                $('#buttonBayar').prop('disabled', false);
            });
        }

        function hitungTotal() {
            totalHarga = 0;

            $('.subtotal').each(function() {
                totalHarga += parseInt($(this).text());
            });

            $('#totalHarga').text(totalHarga);

            if(totalHarga > 0) {
                $('#buttonBayar').prop('disabled', false);
            } else {
                $('#buttonBayar').prop('disabled', true);
            }
        }

        function resetTransaksi() {
            $('#tableBarang tbody').html('');
            $('#totalHarga').text(0);

            $('#kodeBarang').val('');
            $('#namaBarang').val('');
            $('#hargaBarang').val('');
            $('#jumlahBarang').val('').prop('readonly', true);

            $('#buttonTambah').prop('disabled', true);
            $('#buttonBayar').prop('disabled', true);

            totalHarga = 0;
        }
        
    </script>
@endsection