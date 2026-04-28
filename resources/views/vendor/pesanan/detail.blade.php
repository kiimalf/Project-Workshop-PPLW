@extends('layouts.main')

@section('content')
<div class="page-header">
    <h3 class="page-title">
        Detail Pesanan <code>{{ $pesanan->order_id }}</code>
    </h3>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card mt-3">
            <div class="card-body">

                {{-- INFO --}}
                <table class="table table-sm table-borderless">
                    <tr>
                        <td class="text-muted">Order ID</td>
                        <td class="text-right">
                            <code>{{ $pesanan->order_id }}</code>
                        </td>
                    </tr>

                    <tr>
                        <td class="text-muted">Customer</td>
                        <td class="text-right">
                            <strong>{{ $pesanan->customer->idcustomer }}</strong>
                        </td>
                    </tr>

                    <tr>
                        <td class="text-muted">Waktu</td>
                        <td class="text-right">
                            {{ \Carbon\Carbon::parse($pesanan->created_at)->format('d M Y H:i') }}
                        </td>
                    </tr>

                    <tr>
                        <td class="text-muted">Metode</td>
                        <td class="text-right">
                            {{ strtoupper(optional($pesanan->payment)->metode_bayar) }}
                        </td>
                    </tr>

                    <tr>
                        <td class="text-muted">Status</td>
                        <td class="text-right">
                            @if($pesanan->status == 'lunas')
                                <span class="badge badge-success">✓ Lunas</span>
                            @elseif($pesanan->status == 'pending')
                                <span class="badge badge-warning">⏳ Pending</span>
                            @else
                                <span class="badge badge-danger">✕ Batal</span>
                            @endif
                        </td>
                    </tr>
                </table>

                <hr>

                {{-- DETAIL KHUSUS VENDOR --}}
                @php $totalVendor = 0; @endphp

                @forelse($detailPesanan as $d)
                    @php $totalVendor += $d->subtotal; @endphp

                    <div class="d-flex justify-content-between mb-1">
                        <span>
                            {{ $d->menu->nama_menu }}
                            <span class="text-muted">×{{ $d->jumlah }}</span>
                        </span>
                        <span>
                            Rp {{ number_format($d->subtotal, 0, ',', '.') }}
                        </span>
                    </div>
                @empty
                    <div class="text-center text-muted">
                        Tidak ada item dari vendor ini
                    </div>
                @endforelse

                <hr>

                {{-- TOTAL KHUSUS VENDOR --}}
                <div class="d-flex justify-content-between">
                    <strong>Total Vendor</strong>
                    <strong class="text-primary">
                        Rp {{ number_format($totalVendor, 0, ',', '.') }}
                    </strong>
                </div>

                {{-- TOTAL GLOBAL --}}
                <div class="d-flex justify-content-between mt-2">
                    <small class="text-muted">Total Semua Pesanan</small>
                    <small class="text-muted">
                        Rp {{ number_format($pesanan->total, 0, ',', '.') }}
                    </small>
                </div>

                <a href="{{ route('vendor.pesanan.index', $idvendor) }}"
                    class="btn btn-light btn-block mt-3">
                    Kembali
                </a>

            </div>
        </div>
    </div>
</div>
@endsection