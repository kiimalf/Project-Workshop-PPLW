@extends('layouts.main')

@section('content')
    <div class="page-header">
        <h3 class="page-title"> Index Toko </h3>
    </div>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title mb-0">Index Toko</h4>

                <!-- BUTTON CREATE -->
                <a href="{{ route('kunjungan_toko.toko.create') }}" class="btn btn-primary btn-sm">
                    + Tambah Toko
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table" id="tableToko">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Toko</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Accuracy</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($toko as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama_toko }}</td>
                            <td>{{ $item->latitude }}</td>
                            <td>{{ $item->longitude }}</td>
                            <td>{{ $item->accuracy }}</td>
                            <td>
                                <button type="button" id="generateQr"
                                    class="btn btn-success btn-sm btn-qr"
                                    data-id="{{ $item->idtoko }}"
                                    data-nama="{{ $item->nama_toko }}"
                                    data-toggle="modal"
                                    data-target="#qrModal"
                                    data-bs-toggle="modal"
                                    data-bs-target="#qrModal">
                                    Cetak QR Code
                                </button>
                                <a href="{{ route('kunjungan_toko.toko.edit', $item->idtoko) }}"
                                    class="btn btn-warning btn-sm">
                                    Edit
                                </a>
                                <form id="form-{{ $item->idtoko }}" action="{{ route('kunjungan_toko.toko.delete', $item->idtoko) }}"
                                    method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        id="deleteButton-{{ $item->idtoko }}" class="btn btn-danger btn-sm">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                Tidak ada data Toko
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
        </div>
        </div>
    </div>

    <!-- Modal QR Code -->
    <div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="qrModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="qrModalLabel"></h5>
                    <!-- Gunakan attribute data-dismiss (BS4) dan data-bs-dismiss (BS5) untuk keamanan kompatibilitas -->
                    <button type="button" class="close btn-close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img id="qrImage" src="" alt="QR Code" class="img-fluid">
                    <br>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script-page')
<script>
    $(document).ready(function () {
        // $('#tableToko').DataTable();

        $(document).on("click","button[id^='deleteButton-']", function(){

            let button = $(this);
            let form = button.closest('form')[0];

            button.html(
                '<span class="spinner-border spinner-border-sm"></span> Loading'
            );

            button.prop('disabled', true);

            form.submit();
        });

        // Handler untuk tombol cetak QR
        $(document).on("click", "button[id^='generateQr']", function() {
            // Munculkan modal secara manual menggunakan jQuery
            $('#qrModal').modal('show');

            let idtoko = $(this).data("id");
            let namatoko = $(this).data("nama");
            
            // Set nama toko di modal
            $("#qrModalLabel").text("QR Code Toko " + namatoko);
            
            // Set loading atau kosongkan image dulu
            $("#qrImage").attr("src", "");
            
            // Generate URL ke BarcodeController (menggunakan route qrcode.generate)
            let qrUrl = "{{ route('qrcode.generate', ':id') }}".replace(':id', idtoko);
            
            // Set src image ke URL tersebut
            $("#qrImage").attr("src", qrUrl);
        });
    });
</script>
@endsection

