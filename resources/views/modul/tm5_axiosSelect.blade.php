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
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
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
                    axios.get("{{ route('modul.tm5_getKota') }}", {
                        params: { province_id: id }
                    }).then(response => {
                        appendOptions('kota', response.data.data);
                    }).catch(error => console.log(error));
                }
            });

            $('#kota').change(function() {
                var id = $(this).val();

                $('#kecamatan').html('<option value="0">Pilih Kecamatan</option>');
                $('#kelurahan').html('<option value="0">Pilih Kelurahan</option>');

                if(id != 0) {
                    axios.get("{{ route('modul.tm5_getKecamatan') }}", {
                        params: { regency_id: id }
                    }).then(response => {
                        appendOptions('kecamatan', response.data.data);
                    }).catch(error => console.log(error));
                }
            });

            $('#kecamatan').change(function() {
                var id = $(this).val();

                $('#kelurahan').html('<option value="0">Pilih Kelurahan</option>');
                
                if(id != 0) {
                    axios.get("{{ route('modul.tm5_getKelurahan') }}", {
                        params: { district_id: id }
                    }).then(response => {
                        appendOptions('kelurahan', response.data.data);
                    }).catch(error => console.log(error));
                }
            });
        });

        function loadProvinsi() {
            axios.get("{{ route('modul.tm5_getProvinsi') }}").then(response => {
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

// -----------------------------
        // document.addEventListener("DOMContentLoaded", function () {
        //     loadProvinsi();

        //     document.getElementById('provinsi').addEventListener('change', function () {
        //         let id = this.value;

        //         resetSelect('kota', 'Pilih Kota');
        //         resetSelect('kecamatan', 'Pilih Kecamatan');
        //         resetSelect('kelurahan', 'Pilih Kelurahan');

        //         if (id != 0) {
        //             axios.get("{{ route('modul.tm5_getKota') }}", {
        //                 params: { province_id: id }
        //             })
        //             .then(response => {
        //                 appendOptions('kota', response.data.data);
        //             })
        //             .catch(error => console.log(error));
        //         }
        //     });

        //     document.getElementById('kota').addEventListener('change', function () {
        //         let id = this.value;

        //         resetSelect('kecamatan', 'Pilih Kecamatan');
        //         resetSelect('kelurahan', 'Pilih Kelurahan');

        //         if (id != 0) {
        //             axios.get("{{ route('modul.tm5_getKecamatan') }}", {
        //                 params: { regency_id: id }
        //             })
        //             .then(response => {
        //                 appendOptions('kecamatan', response.data.data);
        //             })
        //             .catch(error => console.log(error));
        //         }
        //     });

        //     document.getElementById('kecamatan').addEventListener('change', function () {
        //         let id = this.value;

        //         resetSelect('kelurahan', 'Pilih Kelurahan');

        //         if (id != 0) {
        //             axios.get("{{ route('modul.tm5_getKelurahan') }}", {
        //                 params: { district_id: id }
        //             })
        //             .then(response => {
        //                 appendOptions('kelurahan', response.data.data);
        //             })
        //             .catch(error => console.log(error));
        //         }
        //     });
        // });

        function loadProvinsi() {
            axios.get("{{ route('modul.tm5_getProvinsi') }}")
                .then(response => {
                    resetSelect('provinsi', 'Pilih Provinsi');
                    appendOptions('provinsi', response.data.data);
                })
                .catch(error => console.log(error));
        }

        // function resetSelect(id, label) {
        //     document.getElementById(id).innerHTML = `<option value="0">${label}</option>`;
        // }

        // function appendOptions(id, data) {
        //     let select = document.getElementById(id);

        //     data.forEach(item => {
        //         let option = document.createElement("option");
        //         option.value = item.id;
        //         option.text = item.name;
        //         select.appendChild(option);
        //     });
        // }
    </script>
@endsection