@extends('layouts.main')

@section('style-page')
    <link rel="stylesheet"
href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endsection

@section('content')
    <div class="page-header">
        <h3 class="page-title"> Index Barang </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('barang.index') }}">Barang</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Index Barang
                </li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title mb-0">Index Barang</h4>

                <!-- BUTTON CREATE & SCAN -->
                <div class="d-flex gap-2">
                    <button class="btn btn-info btn-sm text-white" data-bs-toggle="modal" data-bs-target="#scanModal">
                        Scan Barcode
                    </button>
                    <a href="{{ route('barang.create') }}" class="btn btn-primary btn-sm">
                        + Tambah barang
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table" id="tableBarang">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Barang</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>created_at</th>
                        <th>updated_at</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barang as $item)
                        <tr>
                            <td>{{ $item->idbarang }}</td>
                            <td>{{ $item->nama_barang }}</td>
                            <td>{{ $item->harga }}</td>
                            <td>{{ $item->stok }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td>{{ $item->updated_at }}</td>
                            <td>
                                <a href="{{ route('barang.edit', $item->idbarang) }}"
                                    class="btn btn-warning btn-sm">
                                    Edit
                                </a>
                                <form id="form-{{ $item->idbarang }}" action="{{ route('barang.destroy',$item->idbarang) }}"
                                    method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        id="deleteButton-{{ $item->idbarang }}" class="btn btn-danger btn-sm">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                Tidak ada data barang
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <a href="{{ route('barang.preview') }}" class="btn btn-primary btn-sm">
                + Cetak Harga
            </a>
            </div>
        </div>
        </div>
    </div>

    <!-- Modal Scan Barcode -->
    <div class="modal fade" id="scanModal" tabindex="-1" aria-labelledby="scanModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scanModalLabel">Scan Barcode Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div id="reader" style="width: 100%;"></div>
                    
                    <div id="scanResult" class="mt-3 d-none">
                        <div class="alert alert-success text-start">
                            <h5 id="resultNama" class="mb-1"></h5>
                            <p id="resultHarga" class="mb-0 fw-bold"></p>
                        </div>
                    </div>
                    <div id="scanError" class="mt-3 d-none">
                        <div class="alert alert-danger">
                            Barang tidak ditemukan!
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script-page')
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#tableBarang').DataTable();

        $(document).on("click","button[id^='deleteButton-']", function(){

            let button = $(this);
            let form = button.closest('form')[0];

            button.html(
                '<span class="spinner-border spinner-border-sm"></span> Loading'
            );

            button.prop('disabled', true);

            form.submit();
        });

        // Setup Scanner Barcode
        const html5QrcodeScanner = new Html5QrcodeScanner(
            "reader",
            { fps: 10, qrbox: {width: 250, height: 250} },
            /* verbose= */ false);
            
        function onScanSuccess(decodedText, decodedResult) {
            // Panggil API backend untuk mendapatkan data barang
            axios.get('{{ route("POS.findBarang") }}', {
                params: {
                    idbarang: decodedText
                }
            })
            .then(function (response) {
                if(response.data.status === 'success') {
                    $('#scanResult').removeClass('d-none');
                    $('#scanError').addClass('d-none');
                    
                    $('#resultNama').text(response.data.data.nama_barang);
                    
                    // Format ke Rupiah
                    let hargaFormatted = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(response.data.data.harga);
                    $('#resultHarga').text(hargaFormatted);
                    
                } else {
                    $('#scanResult').addClass('d-none');
                    $('#scanError').removeClass('d-none');
                }
            })
            .catch(function (error) {
                console.log(error);
            });
        }
        
        function onScanFailure(error) {
            // Abaikan error saat kamera sedang mencari barcode
        }

        // Render scanner saat modal terbuka
        $('#scanModal').on('shown.bs.modal', function () {
            html5QrcodeScanner.render(onScanSuccess, onScanFailure);
        });

        // Hentikan scanner saat modal ditutup
        $('#scanModal').on('hidden.bs.modal', function () {
            html5QrcodeScanner.clear();
            $('#scanResult').addClass('d-none');
            $('#scanError').addClass('d-none');
        });
    });
</script>
@endsection

