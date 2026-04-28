<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk sebagai Vendor</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icon -->
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
            font-family: 'Segoe UI', sans-serif;
        }

        .card-purple {
            border: none;
            border-radius: 12px;
        }

        .btn-purple {
            background-color: #6f42c1;
            color: white;
        }

        .btn-purple:hover {
            background-color: #5a35a0;
            color: white;
        }

        .form-control:focus {
            border-color: #6f42c1;
            box-shadow: none;
        }
    </style>
</head>

<body>

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="w-100" style="max-width: 420px;">

        <!-- BACK -->
        <a href="{{ route('kantin.welcome') }}" class="text-muted text-decoration-none mb-3 d-inline-block">
            ← Kembali
        </a>

        <!-- CARD -->
        <div class="card card-purple shadow-sm">
            <div class="card-body">

                <!-- ICON -->
                <div class="text-center mb-3">
                    <i class="mdi mdi-store fs-1 text-success"></i>
                </div>

                <!-- TITLE -->
                <h5 class="text-center fw-bold mb-1">Masuk sebagai Vendor</h5>
                <p class="text-center text-muted small mb-4">
                    Masukkan ID Vendor untuk mengakses dashboard
                </p>

                <!-- ERROR GLOBAL -->
                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <!-- FORM -->
                <form method="POST" action="{{ route('kantin.vendor.store') }}" id="form">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">ID Vendor</label>
                        <input type="text"
                               name="idvendor"
                               class="form-control"
                               placeholder="Contoh: 1"
                               value="{{ old('idvendor') }}"
                               required>

                        @error('idvendor')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-purple w-100" id="submitBtn">
                        Masuk ke Dashboard
                    </button>
                </form>

                <!-- INFO -->
                <div class="alert alert-light mt-3 small">
                    💡 ID Vendor diberikan oleh admin. Hubungi admin jika belum punya.
                </div>

            </div>
        </div>

    </div>
</div>

<script>
    document.getElementById('form').addEventListener('submit', function() {
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.innerHTML = 'Memverifikasi...';
    });
</script>

</body>
</html>