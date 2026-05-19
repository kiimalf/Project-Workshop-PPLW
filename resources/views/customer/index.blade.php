@extends('layouts.main')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Daftar Customer </h3>
</div>
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Index Customer</h4>

                    <div class="justify-content-between align-items-center">
                        <a href="{{ route('customer.create1') }}" class="btn btn-primary btn-sm">
                            + Tambah Customer 1
                        </a>
                        <a href="{{ route('customer.create2') }}" class="btn btn-primary btn-sm">
                            + Tambah Customer 2
                        </a>
                    </div>
                </div>

                <table class="table">
                    <thead>
                        <tr class="text-center">
                            <th class="col-1">Foto</th>
                            <th>ID</th>
                            <th>Nama</th>
                            <th class="col-6">Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers as $item)
                        <tr class="text-center">
                            <td>
                                @if ($item->foto_blob)
                                <img src="{{ $item->foto_blob }}" class="w-100 h-auto rounded-0 img-thumbnail">
                                @elseif ($item->foto_path)
                                <img src="{{ asset('storage/' . $item->foto_path) }}" class="w-100 h-auto rounded-0 img-thumbnail">
                                @else
                                <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png" class="w-100 h-auto rounded-0 img-thumbnail">
                                @endif
                            </td>
                            <td>{{ $item->idcustomer }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>
                                @if($item->alamat)
                                {{ $item->alamat ?? '-' }},
                                {{ $item->kelurahan->name ?? '-' }},
                                {{ $item->kecamatan->name ?? '-' }},
                                {{ $item->kota->name ?? '-' }},
                                {{ $item->provinsi->name ?? '-' }}
                                @else
                                -
                                @endif
                            </td>
                            <td>
                                <a href=""
                                    class="btn btn-warning btn-sm">
                                    Edit
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">
                                Tidak ada data Customer
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