@extends('layouts.main')

@section('content')
    <div class="page-header">
        <h3 class="page-title"> Daftar Pesanan </h3>
    </div>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Order ID</th>
                        <th>Tanggal</th>
                        <th>Nama Customer</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pesanan as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><code>{{ $p->order_id }}</code></td>
                            <td>{{ $p->created_at }}</td>
                            <td>{{ $p->customer->nama }}</td>
                            <td class="text-success">
                                    Rp {{ number_format($p->total) }}
                                </td>
                            <td>
                                <a href="{{ route('vendor.pesanan.detail', ['idvendor' => $idvendor, 'idpesanan' => $p->idpesanan]) }}" class="btn btn-warning btn-sm">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                Tidak ada data Pesanan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
        </div>
        </div>
    </div>
@endsection