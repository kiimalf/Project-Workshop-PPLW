<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk sebagai Customer</title>

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
                    <i class="mdi mdi-account fs-1 text-primary"></i>
                </div>

                <!-- TITLE -->
                <h5 class="text-center fw-bold mb-1">Masuk sebagai Customer</h5>
                <p class="text-center text-muted small mb-4">
                    Masukkan nama untuk mulai memesan
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
                <form method="POST" action="{{ route('kantin.customer.store') }}" id="form">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Nama Kamu</label>
                        <input type="text"
                               name="nama"
                               class="form-control"
                               placeholder="Contoh: Budi Santoso"
                               value="{{ old('nama') }}"
                               required>

                        @error('nama')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-purple w-100" id="submitBtn">
                        Lanjut ke Menu
                    </button>
                </form>

                <!-- INFO -->
                <div class="alert alert-light mt-3 small">
                    ℹ️ ID akan dibuat otomatis. Gunakan untuk melihat pesanan.
                </div>

            </div>
        </div>

    </div>
</div>

<script>
    document.getElementById('form').addEventListener('submit', function() {
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.innerHTML = 'Memproses...';
    });
</script>

</body>
</html>