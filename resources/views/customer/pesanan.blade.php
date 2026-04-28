@extends('layouts.main')

@section('content')
    <div class="page-header">
        <h3 class="page-title"> Daftar Pesanan </h3>
    </div>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                <table class="table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pesanan as $p)
                            <tr>
                                <td><code>{{ $p->order_id }}</code></td>
                                <td>{{ $p->created_at }}</td>
                                <td class="text-success">
                                    Rp {{ number_format($p->total) }}
                                </td>
                                <td>
                                    @if($p->status == 'lunas')
                                        <span class="badge bg-success">Lunas</span>
                                    @elseif($p->status == 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @else
                                        <span class="badge bg-danger">Batal</span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    @if($p->status != 'lunas')
                                        <a href="{{ route('customer.payment', $p->idpesanan) }}"
                                        class="btn btn-primary btn-sm">
                                            Bayar
                                        </a>
                                    @else
                                        <a href="{{ route('customer.paymentSuccess', $p->idpesanan) }}"
                                        class="btn btn-success btn-sm">
                                            Detail
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">
                                    Tidak ada pesanan.
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