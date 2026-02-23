@extends('layouts.main')

@section('content')
    <div class="page-header">
        <h3 class="page-title"> Kategori </h3>
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Kategori</li>
        </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title mb-0">Index Kategori</h4>

                <!-- BUTTON CREATE -->
                <a href="{{ route('kategori.create') }}" class="btn btn-primary btn-sm">
                    + Tambah Kategori
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
                        <th>ID</th>
                        <th>Nama Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategori as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama_kategori }}</td>
                            <td>
                                <a href="{{ route('kategori.edit', $item->idkategori) }}"
                                    class="btn btn-warning btn-sm">
                                    Edit
                                </a>
                                <form action="{{ route('kategori.destroy', $item->idkategori) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
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
                            <td colspan="2" class="text-center text-muted">
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