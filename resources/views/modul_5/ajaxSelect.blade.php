@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-0">Select</h4>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Pilih Provinsi:</label>
                        <div class="col-md-10">
                            <select class="form-control" id="provinsi">
                                <option value="0">Pilih Provinsi</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Pilih Kota:</label>
                        <div class="col-md-10">
                            <select class="form-control" id="kota">
                                <option value="0">Pilih Kota</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Pilih Kecamatan:</label>
                        <div class="col-md-10">
                            <select class="form-control" id="kecamatan">
                                <option value="0">Pilih Kecamatan</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Pilih Kelurahan:</label>
                        <div class="col-md-10">
                            <select class="form-control" id="kelurahan">
                                <option value="0">Pilih Kelurahan</option>
                            </select>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script-page')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            loadProvinsi();

            $('#provinsi').change(function() {
                var id = $(this).val();

                $('#kota').html('<option value="0">Pilih Kota</option>');
                $('#kecamatan').html('<option value="0">Pilih Kecamatan</option>');
                $('#kelurahan').html('<option value="0">Pilih Kelurahan</option>');

                if(id != 0) {
                    $.ajax({
                        url: "{{ route('modul_5.getKota') }}",
                        type: 'GET',
                        data: {province_id: id},
                        success: function(response) {
                            $.each(response.data, function(index, item) {
                                $('#kota').append(
                                    `<option value="${item.id}">${item.name}</option>`
                                );
                            });
                        }
                    });
                }
            });

            $('#kota').change(function() {
                var id = $(this).val();

                $('#kecamatan').html('<option value="0">Pilih Kecamatan</option>');
                $('#kelurahan').html('<option value="0">Pilih Kelurahan</option>');

                if(id != 0) {
                    $.ajax({
                        url: "{{ route('modul_5.getKecamatan') }}",
                        type: 'GET',
                        data: {regency_id: id},
                        success: function(response) {
                            $.each(response.data, function(index, item) {
                                $('#kecamatan').append(
                                    `<option value="${item.id}">${item.name}</option>`
                                );
                            });
                        }
                    });
                }
            });

            $('#kecamatan').change(function() {
                var id = $(this).val();

                $('#kelurahan').html('<option value="0">Pilih Kelurahan</option>');
                
                if(id != 0) {
                    $.ajax({
                        url: "{{ route('modul_5.getKelurahan') }}",
                        type: 'GET',
                        data: {district_id: id},
                        success: function(response) {
                            $.each(response.data, function(index, item) {
                                $('#kelurahan').append(
                                    `<option value="${item.id}">${item.name}</option>`
                                );
                            });
                        }
                    });
                }
            });
        });

        function loadProvinsi() {
            $.ajax({
                url: "{{ route('modul_5.getProvinsi') }}",
                type: 'GET',
                success: function(response) {
                    $('#provinsi').html('<option value="0">Pilih Provinsi</option>');

                    $.each(response.data, function(index, item) {
                        $('#provinsi').append(
                            `<option value="${item.id}">${item.name}</option>`
                        );
                    });
                }
            });
        }
    </script>
@endsection