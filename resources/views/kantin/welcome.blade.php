<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kantin Digital</title>

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
            transition: 0.2s;
        }

        .card-purple:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .bg-purple {
            background: linear-gradient(135deg, #6f42c1, #8e5de7);
            color: white;
        }

        .btn-purple {
            background-color: #6f42c1;
            color: white;
        }

        .btn-purple:hover {
            background-color: #5a35a0;
            color: white;
        }

        .btn-outline-purple {
            border-color: #6f42c1;
            color: #6f42c1;
        }

        .btn-outline-purple:hover {
            background-color: #6f42c1;
            color: white;
        }
    </style>
</head>

<body>

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="text-center w-100" style="max-width: 700px;">

        <!-- HEADER -->
        <h2 class="fw-bold mb-2">🍽️ Kantin Digital</h2>
        <p class="text-muted mb-4">
            Pilih peranmu untuk mulai menggunakan sistem
        </p>

        <!-- CARD -->
        <div class="row g-3">

            <!-- CUSTOMER -->
            <div class="col-md-6">
                <div class="card card-purple shadow-sm h-100">
                    <div class="card-body">

                        <div class="mb-3">
                            <i class="mdi mdi-account fs-1 text-primary"></i>
                        </div>

                        <h5 class="fw-bold">Customer</h5>
                        <br>
                        <a href="{{ route('kantin.customer.enter') }}"
                            class="btn btn-outline-purple w-100">
                            Masuk sebagai Customer
                        </a>

                    </div>
                </div>
            </div>

            <!-- VENDOR -->
            <div class="col-md-6">
                <div class="card card-purple shadow-sm h-100">
                    <div class="card-body">

                        <div class="mb-3">
                            <i class="mdi mdi-store fs-1 text-success"></i>
                        </div>

                        <h5 class="fw-bold">Vendor</h5>
                        <br>
                        <a href="{{ route('kantin.vendor.enter') }}"
                            class="btn btn-outline-purple w-100">
                            Masuk sebagai Vendor
                        </a>

                    </div>
                </div>
            </div>

        </div>

        <!-- ADMIN -->
        <div class="mt-4">
            <a href="{{ route('login') }}" class="text-muted text-decoration-none">
                🔐 Login sebagai Admin
            </a>
        </div>

    </div>
</div>

</body>
</html>