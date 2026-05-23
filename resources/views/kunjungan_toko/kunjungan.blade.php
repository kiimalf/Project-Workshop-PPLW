@extends('layouts.main')

@section('content')
    <div class="page-header">
        <h3 class="page-title"> Index Kunjungan </h3>
    </div>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Riwayat Kunjungan Sales</h4>

                    <!-- BUTTON CREATE KUNJUNGAN -->
                    <a href="{{ route('kunjungan_toko.kunjungan.create') }}" class="btn btn-primary btn-sm">
                        + Tambah Kunjungan (Scan QR)
                    </a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <table class="table" id="tableKunjungan">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Timestamp</th>
                            <th>Nama Toko</th>
                            <th>Lat</th>
                            <th>Long</th>
                            <th>Accuracy</th>
                            <th>Jarak Aktual</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kunjungan as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td>{{ $item->toko->nama_toko ?? 'Toko Tidak Ditemukan' }}</td>
                                <td>{{ $item->latitude }}</td>
                                <td>{{ $item->longitude }}</td>
                                <td>{{ $item->accuracy }} m</td>
                                <td>{{ $item->jarak }} m</td>
                                <td>
                                    @if($item->status == 'DITERIMA')
                                        <span class="badge badge-success">{{ $item->status }}</span>
                                    @else
                                        <span class="badge badge-danger">{{ $item->status }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    Tidak ada data Kunjungan
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