@extends('layouts.main')

@section('content')
    <div class="page-header">
        <h3 class="page-title"> Buku </h3>
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Buku</li>
        </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title mb-0">Index Buku</h4>

                <!-- BUTTON CREATE -->
                <a href="{{ route('buku.create') }}" class="btn btn-primary btn-sm">
                    + Tambah Buku
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Judul</th>
                        <th>Pengarang</th>
                        <th>Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($buku as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->kode }}</td>
                            <td>{{ $item->judul }}</td>
                            <td>{{ $item->pengarang }}</td>
                            <td>{{ $item->kategori->nama_kategori }}</td>
                            <td>
                                <a href="{{ route('buku.edit', $item->idbuku) }}"
                                    class="btn btn-warning btn-sm">
                                    Edit
                                </a>
                                <form action="{{ route('buku.destroy', $item->idbuku) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                Tidak ada data kategori
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