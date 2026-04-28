@extends('layouts.main')

@section('content')
    <div class="page-header">
    <h3 class="page-title">Pembayaran Berhasil</h3>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card text-center">
            <div class="card-body py-5">
                <div style="font-size:4rem">✅</div>
                <h3 class="mt-3 font-weight-bold">Pembayaran Berhasil!</h3>
                <p class="text-muted">
                    Pesanan Anda sedang diproses
                </p>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <table class="table table-sm table-borderless">
                    <tr><td class="text-muted">Order ID</td>
                        <td class="text-right"><code>{{ $pesanan->order_id }}</code></td></tr>
                    <tr><td class="text-muted">Guest ID</td>
                        <td class="text-right"><strong>{{ $pesanan->customer->idcustomer }}</strong></td></tr>
                    <tr><td class="text-muted">Waktu</td>
                        <td class="text-right">{{ \Carbon\Carbon::parse($pesanan->created_at)->format('d M Y H:i') }}</td></tr>
                    <tr><td class="text-muted">Metode</td>
                        <td class="text-right">
                            {{ strtoupper($pesanan->payment->metode_bayar) }}
                        </td></tr>
                    <tr><td class="text-muted">Status</td>
                        <td class="text-right">
                            <span class="badge badge-success">✓ Lunas</span>
                        </td></tr>
                </table>

                <hr>

                @foreach($pesanan->detail as $d)
                    <div class="d-flex justify-content-between mb-1">
                        <span>{{ $d->menu->nama_menu }}
                            <span class="text-muted">×{{ $d->jumlah }}</span>
                        </span>
                        <span>Rp {{ number_format($d->subtotal, 0, ',', '.') }}</span>
                    </div>
                @endforeach

                <hr>
                <div class="d-flex justify-content-between">
                    <strong>Total</strong>
                    <strong class="text-success" style="font-size:1.2rem">
                        Rp {{ number_format($pesanan->total, 0, ',', '.') }}
                    </strong>
                </div>
            </div>
            <div class="card-footer d-flex gap-2 justify-content-center" style="gap:.5rem">
                <a href="{{ route('customer.index') }}" class="btn btn-success">Pesan Lagi</a>
                <a href="{{ route('customer.pesanan') }}" class="btn btn-outline-secondary">Daftar Pesanan</a>
            </div>
        </div>
    </div>
</div>
@endsection