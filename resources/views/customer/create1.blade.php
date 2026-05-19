@extends('layouts.main')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Tambah Customer 1 </h3>
</div>

<div class="row">
    <div class="col-lg-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Form Tambah Customer 1</h4>

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif

                <form id="form" action="{{ route('customer.store1') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text"
                            name="nama"
                            class="form-control"
                            value="{{ old('nama') }}">
                    </div>

                    <div class="form-group">
                        <label>Alamat</label>
                        <input type="text"
                            name="alamat"
                            class="form-control"
                            value="{{ old('alamat') }}">
                    </div>

                    <div class="form-group">
                        <label>Provinsi</label>
                        <select class="form-control" id="provinsi" name="provinsi">
                            <option value="0">Pilih Provinsi</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Kota</label>
                        <select class="form-control" id="kota" name="kota">
                            <option value="0">Pilih Kota</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Kecamatan</label>
                        <select class="form-control" id="kecamatan" name="kecamatan">
                            <option value="0">Pilih Kecamatan</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Kelurahan</label>
                        <select class="form-control" id="kelurahan" name="kelurahan">
                            <option value="0">Pilih Kelurahan</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Foto Customer</label><br>
                        <div class="d-flex">
                            <img id="hasil_foto_utama" src="" alt="Foto" class="img-thumbnail" width="320" height="240" />
                            <div class="d-flex align-items-end ms-4">
                                <button type="button" class="btn btn-info" id="btn_buka_kamera">
                                    Buka Kamera
                                </button>
                            </div>
                        </div>
                        <input type="hidden" name="foto" id="foto">
                    </div>
                </form>

                <!-- Modal Kamera -->
                <div class="modal fade" id="modalKamera">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5>Ambil Foto</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                <!-- Area kamera dan preview di dalam modal -->
                                <div id="my_camera" class="mx-auto"></div>
                                <div id="hasil_sementara" class="d-none mx-auto"></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary d-none" id="btn_retake" onclick="retake_foto()">Ulangi</button>
                                <button type="button" class="btn btn-primary" id="btn_take" onclick="take_snapshot()">Ambil Foto</button>
                                <button type="button" class="btn btn-success d-none" id="btn_simpan" onclick="simpan_foto()">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-3">
                    <button id="submit" class="btn btn-primary">
                        Simpan
                    </button>

                    <a href="{{ route('customer.index') }}" class="btn btn-light">
                        Kembali
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('script-page')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Inisialisasi variabel untuk menampung hasil foto
    let foto_base64 = '';
    $(document).ready(function() {
        loadProvinsi();

        // Pemicu buka modal menggunakan jQuery
        $('#btn_buka_kamera').click(function(e) {
            e.preventDefault();
            $('#modalKamera').modal('show');
        });

        $('#provinsi').change(function() {
            var id = $(this).val();

            $('#kota').html('<option value="0">Pilih Kota</option>');
            $('#kecamatan').html('<option value="0">Pilih Kecamatan</option>');
            $('#kelurahan').html('<option value="0">Pilih Kelurahan</option>');

            if (id != 0) {
                axios.get("{{ route('modul_5.getKota') }}", {
                    params: {
                        province_id: id
                    }
                }).then(response => {
                    appendOptions('kota', response.data.data);
                }).catch(error => console.log(error));
            }
        });

        $('#kota').change(function() {
            var id = $(this).val();

            $('#kecamatan').html('<option value="0">Pilih Kecamatan</option>');
            $('#kelurahan').html('<option value="0">Pilih Kelurahan</option>');

            if (id != 0) {
                axios.get("{{ route('modul_5.getKecamatan') }}", {
                    params: {
                        regency_id: id
                    }
                }).then(response => {
                    appendOptions('kecamatan', response.data.data);
                }).catch(error => console.log(error));
            }
        });

        $('#kecamatan').change(function() {
            var id = $(this).val();

            $('#kelurahan').html('<option value="0">Pilih Kelurahan</option>');

            if (id != 0) {
                axios.get("{{ route('modul_5.getKelurahan') }}", {
                    params: {
                        district_id: id
                    }
                }).then(response => {
                    appendOptions('kelurahan', response.data.data);
                }).catch(error => console.log(error));
            }
        });



        $('#submit').click(function() {
            let form = document.getElementById('form');

            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            $('#submit').html(
                '<span class="spinner-border spinner-border-sm"></span> Loading'
            )
            $('#submit').prop('disabled', true);

            form.submit();
        });
    });

    Webcam.set({
        width: 320,
        height: 240,
        image_format: 'jpeg',
        jpeg_quality: 90
    });

    $('#modalKamera').on('shown.bs.modal', function() {
        Webcam.attach('#my_camera');
    });

    $('#modalKamera').on('hidden.bs.modal', function() {
        Webcam.reset();
        // Reset tampilan modal menggunakan d-none
        $('#my_camera').removeClass('d-none');
        $('#hasil_sementara').addClass('d-none');
        $('#btn_take').removeClass('d-none');
        $('#btn_retake').addClass('d-none');
        $('#btn_simpan').addClass('d-none');
    });

    function take_snapshot() {
        Webcam.snap(function(data_uri) {
            foto_base64 = data_uri;
            // Sembunyikan kamera live, tampilkan jepretan
            $('#my_camera').addClass('d-none');
            $('#hasil_sementara').html('<img src="' + data_uri + '" width="320" height="240" class="img-thumbnail"/>');
            $('#hasil_sementara').removeClass('d-none');

            // Ganti tombol
            $('#btn_take').addClass('d-none');
            $('#btn_retake').removeClass('d-none');
            $('#btn_simpan').removeClass('d-none');
        });
    }

    function retake_foto() {
        $('#my_camera').removeClass('d-none');
        $('#hasil_sementara').addClass('d-none');

        $('#btn_take').removeClass('d-none');
        $('#btn_retake').addClass('d-none');
        $('#btn_simpan').addClass('d-none');
    }

    function simpan_foto() {
        // Set ke input form utama
        $('#foto').val(foto_base64);

        // Tampilkan gambar di layar utama
        $('#hasil_foto_utama').attr('src', foto_base64);
        $('#hasil_foto_utama').removeClass('d-none');

        // Tutup modal
        $('#modalKamera').modal('hide');
    }

    function loadProvinsi() {
        axios.get("{{ route('modul_5.getProvinsi') }}").then(response => {
            resetSelect('provinsi', 'Pilih Provinsi');
            appendOptions('provinsi', response.data.data);
        }).catch(error => console.log(error));
    }

    function resetSelect(id, label) {
        document.getElementById(id).innerHTML = `<option value="0">${label}</option>`;
    }

    function appendOptions(id, data) {
        let select = document.getElementById(id);

        data.forEach(item => {
            let option = document.createElement("option");
            option.value = item.id;
            option.text = item.name;
            select.appendChild(option);
        });
    }
</script>
@endsection