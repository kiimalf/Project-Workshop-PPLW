@extends('layouts.main')

@section('style-page')
    <link rel="stylesheet"
href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endsection

@section('content')
    <div class="page-header">
        <h3 class="page-title"> Index Barang </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('barang.index') }}">Barang</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Index Barang
                </li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title mb-0">Index Barang</h4>

                <!-- BUTTON CREATE -->
                <a href="{{ route('barang.create') }}" class="btn btn-primary btn-sm">
                    + Tambah barang
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table" id="tableBarang">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Barang</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>created_at</th>
                        <th>updated_at</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barang as $item)
                        <tr>
                            <td>{{ $item->idbarang }}</td>
                            <td>{{ $item->nama_barang }}</td>
                            <td>{{ $item->harga }}</td>
                            <td>{{ $item->stok }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td>{{ $item->updated_at }}</td>
                            <td>
                                <a href="{{ route('barang.edit', $item->idbarang) }}"
                                    class="btn btn-warning btn-sm">
                                    Edit
                                </a>
                                <form action="{{ route('barang.destroy', $item->idbarang) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
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
                            <td colspan="7" class="text-center text-muted">
                                Tidak ada data barang
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <a href="{{ route('barang.preview') }}" class="btn btn-primary btn-sm">
                + Cetak Harga
            </a>
            </div>
        </div>
        </div>
    </div>
@endsection

@section('script-page')
<script>
$(document).ready(function () {
    $('#tableBarang').DataTable();
});
</script>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
@endsection