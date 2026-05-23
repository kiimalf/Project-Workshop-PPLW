@extends('layouts.main')

@section('content')
    <div class="page-header">
        <h3 class="page-title"> Tambah Kunjungan (Scan QR) </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('kunjungan_toko.kunjungan') }}">Kunjungan</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Scan QR
                </li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-6 grid-margin stretch-card mx-auto">
            <div class="card">
                <div class="card-body text-center">
                    
                    <!-- STEP 1: SCANNER -->
                    <div id="step-1-scanner">
                        <h4 class="card-title">Arahkan Kamera ke QR Code Toko</h4>
                        <div id="reader" style="width: 100%; margin-bottom: 20px;"></div>
                        <h5 class="text-info d-none" id="scanner-loading">Memproses QR Code...</h5>
                    </div>

                    <!-- STEP 2: DATA TOKO -->
                    <div id="step-2-toko" class="d-none">
                        <h4 class="card-title text-success">Toko Ditemukan!</h4>
                        <table class="table table-bordered mb-4 text-left">
                            <tr><th>Nama Toko</th><td id="ui-nama-toko"></td></tr>
                            <tr><th>Latitude</th><td id="ui-lat-toko"></td></tr>
                            <tr><th>Longitude</th><td id="ui-lng-toko"></td></tr>
                            <tr><th>Accuracy</th><td id="ui-acc-toko"></td></tr>
                        </table>
                        
                        <button class="btn btn-info w-100" id="btn-ambil-lokasi">
                            <i class="mdi mdi-map-marker"></i> Ambil Lokasi Saya
                        </button>
                        
                        <div id="lokasi-loading" class="d-none mt-3">
                            <div class="spinner-border text-primary" role="status"></div>
                            <h5 class="mt-2 text-info">Sedang mencari lokasi akurat (maks 20 detik)...</h5>
                        </div>
                    </div>

                    <!-- STEP 3: HASIL VALIDASI -->
                    <div id="step-3-hasil" class="d-none">
                        <h4 class="card-title">Hasil Validasi Kunjungan</h4>
                        <div class="alert alert-secondary text-left mb-4">
                            <strong>Jarak Aktual:</strong> <span id="ui-jarak-aktual"></span><br>
                            <strong>Status:</strong> <span id="ui-status" class="font-weight-bold"></span>
                        </div>

                        <!-- Hidden Form -->
                        <form id="form-kunjungan" action="{{ route('kunjungan_toko.kunjungan.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="idtoko" id="input-idtoko">
                            <input type="hidden" name="latitude" id="input-lat">
                            <input type="hidden" name="longitude" id="input-lng">
                            <input type="hidden" name="accuracy" id="input-acc">
                            <input type="hidden" name="jarak" id="input-jarak">
                            <input type="hidden" name="status" id="input-status">
                            
                            <button type="submit" class="btn btn-primary w-100" id="btn-submit">
                                Submit / Simpan
                            </button>
                        </form>
                    </div>

                    <a href="{{ route('kunjungan_toko.kunjungan') }}" class="btn btn-light mt-4">
                        Batal & Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script-page')
<!-- Memanggil library html5-qrcode dari CDN -->
<script src="https://unpkg.com/html5-qrcode"></script>

<script>
    // Menyuntikkan data PHP ke dalam variabel Javascript
    const tokoList = @json($toko);
    
    let html5QrcodeScanner;
    let isScanned = false;
    let tokoData = null;

    // Fungsi Haversine di JS
    function calculateHaversine(lat1, lng1, lat2, lng2) {
        const R = 6371000; // Radius Bumi dalam meter
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLng = (lng2 - lng1) * Math.PI / 180;
        
        const a = Math.sin(dLat/2) * Math.sin(dLat/2) + 
                  Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * 
                  Math.sin(dLng/2) * Math.sin(dLng/2);
        
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        return Math.round(R * c);
    }

    // Fungsi untuk mendapatkan koordinat GPS secara akurat
    function getAccuratePosition(targetAccuracy = 50, maxWait = 20000) { 
        return new Promise((resolve, reject) => { 
            let bestResult = null; 
            const startTime = Date.now(); 
            const watchId = navigator.geolocation.watchPosition( 
                (position) => { 
                    const acc = position.coords.accuracy; 
                    if (!bestResult || acc < bestResult.coords.accuracy) { 
                        bestResult = position; 
                    } 
                    if (acc <= targetAccuracy) { 
                        navigator.geolocation.clearWatch(watchId); 
                        resolve(bestResult); 
                    } 
                    if (Date.now() - startTime >= maxWait) { 
                        navigator.geolocation.clearWatch(watchId); 
                        if (bestResult) resolve(bestResult); 
                        else reject(new Error("Timeout, tidak dapat posisi. (Silakan pastikan GPS aktif)")); 
                    } 
                }, 
                (error) => {
                    let errMsg = "Terjadi kesalahan.";
                    if (error.code === 1) errMsg = "Akses lokasi ditolak oleh browser.";
                    reject(new Error(errMsg));
                }, 
                { enableHighAccuracy: true, maximumAge: 0, timeout: maxWait } 
            ); 
        }); 
    }

    $(document).ready(function() {
        // 1. INISIALISASI SCANNER
        html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", { fps: 10 }, false
        );
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);

        function onScanSuccess(decodedText, decodedResult) {
            if(isScanned) return;
            isScanned = true;
            
            // Matikan scanner
            html5QrcodeScanner.clear().then(() => {
                $('#reader').addClass('d-none');
                $('#scanner-loading').removeClass('d-none');
                
                // Cari toko dari data tokoList (Javascript array hasil lemparan Controller)
                // decodedText adalah idtoko hasil scan
                tokoData = tokoList.find(t => t.id == decodedText || t.idtoko == decodedText);

                if(tokoData) {
                    // Isi UI Step 2
                    $('#ui-nama-toko').text(tokoData.nama_toko);
                    $('#ui-lat-toko').text(tokoData.latitude);
                    $('#ui-lng-toko').text(tokoData.longitude);
                    $('#ui-acc-toko').text(tokoData.accuracy + " m");
                    
                    // Masukkan idtoko ke form
                    // Pastikan kita mengambil property id yang benar sesuai database (id / idtoko)
                    let storeId = tokoData.id ? tokoData.id : tokoData.idtoko;
                    $('#input-idtoko').val(storeId);
                    
                    // Tampilkan Step 2
                    $('#step-1-scanner').addClass('d-none');
                    $('#step-2-toko').removeClass('d-none');
                } else {
                    alert("Toko dengan ID " + decodedText + " tidak ditemukan!");
                    // Ulangi scanner
                    isScanned = false;
                    $('#scanner-loading').addClass('d-none');
                    $('#reader').removeClass('d-none');
                    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
                }
            });
        }

        function onScanFailure(error) { }

        // 2. KLIK TOMBOL AMBIL LOKASI
        $('#btn-ambil-lokasi').click(function() {
            $('#btn-ambil-lokasi').prop('disabled', true).addClass('d-none');
            $('#lokasi-loading').removeClass('d-none');
            
            if (navigator.geolocation) {
                getAccuratePosition(50, 20000)
                    .then(function(position) {
                        let salesLat = position.coords.latitude;
                        let salesLng = position.coords.longitude;
                        let salesAcc = position.coords.accuracy;
                        
                        // Hitung Haversine langsung di Javascript
                        let jarak = calculateHaversine(
                            parseFloat(tokoData.latitude), parseFloat(tokoData.longitude),
                            salesLat, salesLng
                        );
                        
                        let threshold_base = 300;
                        let threshold_efektif = threshold_base + parseFloat(tokoData.accuracy) + salesAcc;
                        
                        let statusVal = (jarak <= threshold_efektif) ? 'DITERIMA' : 'DITOLAK';
                        
                        let statusText = "";
                        if(statusVal === 'DITERIMA') {
                            statusText = `<span class="text-success">DITERIMA ✓</span>`;
                        } else {
                            statusText = `<span class="text-danger">DITOLAK ✗</span>`;
                        }
                        
                        $('#ui-jarak-aktual').text(jarak + " meter (Batas: " + Math.round(threshold_efektif) + "m)");
                        $('#ui-status').html(statusText);

                        // Masukkan semua data ke hidden form
                        $('#input-lat').val(salesLat);
                        $('#input-lng').val(salesLng);
                        $('#input-acc').val(salesAcc);
                        $('#input-jarak').val(jarak);
                        $('#input-status').val(statusVal);
                        
                        // Tampilkan Step 3
                        $('#step-2-toko').addClass('d-none');
                        $('#step-3-hasil').removeClass('d-none');
                    })
                    .catch(function(error) {
                        alert(error.message);
                        $('#btn-ambil-lokasi').prop('disabled', false).removeClass('d-none');
                        $('#lokasi-loading').addClass('d-none');
                    });
            } else {
                alert("Geolocation tidak didukung browser ini.");
            }
        });
        
        // 3. KLIK SUBMIT
        $('#form-kunjungan').submit(function() {
            $('#btn-submit').prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Menyimpan...');
        });
    });
</script>
@endsection