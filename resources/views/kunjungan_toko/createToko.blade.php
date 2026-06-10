@extends('layouts.main')

@section('content')
    <div class="page-header">
        <h3 class="page-title"> Tambah Toko </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('kunjungan_toko.toko') }}">Toko</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Tambah Toko
                </li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Form Tambah Toko</h4>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form id="form" action="{{ route('kunjungan_toko.toko.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label>Nama Toko</label>
                            <input type="text"
                                name="nama_toko"
                                class="form-control"
                                value="{{ old('nama_toko') }}"
                                required>
                        </div>
                        
                        <div class="form-group">
                            <button type="button" id="btn-get-location" class="btn btn-info btn-sm">
                                <i class="mdi mdi-map-marker"></i> Ambil Lokasi Saat Ini
                            </button>
                            <small id="location-status" class="text-muted ml-2"></small>
                        </div>

                        <div class="form-group">
                            <label>Latitude</label>
                            <input type="number"
                                id="latitude"
                                name="latitude"
                                class="form-control"
                                value="{{ old('latitude') }}"
                                required
                                step="any" readonly>
                        </div>
                        <div class="form-group">
                            <label>Longitude</label>
                            <input type="number"
                                id="longitude"
                                name="longitude"
                                class="form-control"
                                value="{{ old('longitude') }}"
                                required
                                step="any" readonly>
                        </div>
                        <div class="form-group">
                            <label>Accuracy (meter)</label>
                            <input type="number"
                                id="accuracy"
                                name="accuracy"
                                class="form-control"
                                value="{{ old('accuracy') }}"
                                required
                                step="any" readonly>
                        </div>
                    </form>
                    
                    <button id="submit" class="btn btn-primary">
                        Simpan
                    </button>

                    <a href="{{ route('kunjungan_toko.toko') }}" class="btn btn-light">
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script-page')
    <script>
        function getAccuratePosition(targetAccuracy = 50, maxWait = 2000) { 
            return new Promise((resolve, reject) => { 
                let bestResult = null; 
                const startTime = Date.now(); 
                const watchId = navigator.geolocation.watchPosition( 
                    (position) => { 
                        const acc = position.coords.accuracy; 
                        // Simpan hasil terbaik sejauh ini 
                        if (!bestResult || acc < bestResult.coords.accuracy) { 
                            bestResult = position; 
                        } 
                        // Kalau sudah cukup akurat, berhenti 
                        if (acc <= targetAccuracy) { 
                            navigator.geolocation.clearWatch(watchId); 
                            resolve(bestResult); 
                        } 
                        // Kalau timeout, pakai hasil terbaik yang ada 
                        if (Date.now() - startTime >= maxWait) { 
                            navigator.geolocation.clearWatch(watchId); 
                            if (bestResult) resolve(bestResult); 
                            else reject(new Error("Timeout, tidak dapat posisi")); 
                        } 
                    }, 
                    (error) => reject(error), 
                    { enableHighAccuracy: true, maximumAge: 0, timeout: maxWait } 
                ); 
            }); 
        }

        $(document).ready(function() {
            // Geolocation Logic
            $('#btn-get-location').click(async function() {
                let statusText = $('#location-status');
                
                if (navigator.geolocation) {
                    statusText.text('Mencari lokasi paling akurat (maks 20 detik)...');
                    statusText.removeClass('text-muted text-danger text-success').addClass('text-info');
                    $('#btn-get-location').prop('disabled', true);
                    
                    try {
                        const position = await getAccuratePosition(50, 20000);
                        
                        $('#latitude').val(position.coords.latitude);
                        $('#longitude').val(position.coords.longitude);
                        $('#accuracy').val(position.coords.accuracy);
                        
                        statusText.text(`Lokasi didapatkan! (Akurasi: ${position.coords.accuracy} meter)`);
                        statusText.removeClass('text-info').addClass('text-success');
                    } catch (error) {
                        let errorMessage = 'Gagal mengambil lokasi: ' + error.message;
                        if(error.code === 1) { // error.PERMISSION_DENIED
                            errorMessage = 'Izin lokasi ditolak oleh browser.';
                        }
                        
                        statusText.text(errorMessage);
                        statusText.removeClass('text-info').addClass('text-danger');
                        console.error("Error getting geolocation: ", error);
                    } finally {
                        $('#btn-get-location').prop('disabled', false);
                    }
                } else {
                    statusText.text('Geolocation tidak didukung di browser ini.');
                    statusText.removeClass('text-muted').addClass('text-danger');
                }
            });

            // Form Submit Logic
            $('#submit').click(function() {
                let form = document.getElementById('form');

                if(!form.checkValidity()) {
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
    </script>
@endsection