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
                                <form id="form-{{ $item->idkategori }}" action="{{ route('kategori.destroy', $item->idkategori) }}"
                                    method="POST"
                                    class="d-inline"
                                @csrf
                                @method('DELETE')
                                <button id="deleteButton-{{ $item->idkategori }}"class="btn btn-danger btn-sm">
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

@section('script-page')
    <script>
        $(document).ready(function(){

        $("button[id^='deleteButton-']").click(function(){

            let button = $(this);
            let form = button.closest('form')[0];

            button.html(
                '<span class="spinner-border spinner-border-sm"></span> Loading'
            );

            button.prop('disabled', true);

            form.submit();

            });
        });
    </script>
@endsection