@extends('layouts.main')

@section('content')
    <div class="page-header">
        <h3 class="page-title"> Tambah Buku </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('buku.index') }}">Buku</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Tambah Buku
                </li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Form Tambah Buku</h4>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form id="form" action="{{ route('buku.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label>Kode Buku</label>
                            <input type="text"
                                name="kode"
                                class="form-control"
                                value="{{ old('kode') }}"
                                >
                        </div>

                        <div class="form-group">
                            <label>Judul Buku</label>
                            <input type="text" name="judul" class="form-control" value="{{ old('judul') }}">
                        </div>

                        <div class="form-group">
                            <label>Pengarang</label>
                            <input type="text" name="pengarang"  class="form-control" value="{{ old('pengarang') }}" >
                        </div>

                        <div class="form-group">
                            <label>Kategori</label>
                            <select name="idkategori" class="form-control" >
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategori as $k)
                                    <option value="{{ $k->idkategori }}"
                                        {{ old('idkategori') == $k->idkategori ? 'selected' : '' }}>
                                        {{ $k->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>

                    <button id="submit" class="btn btn-primary">
                        Simpan
                    </button>

                    <a href="{{ route('buku.index') }}" class="btn btn-light">
                        Kembali
                    </a>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script-page')
    <script>
        $(document).ready(function() {
            $('#submit').click(function() {
                let form = document.getElementById('form');

                if(!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }

                $('#submit').html(
                    '<span class="spinner-border spinner-border-sm"></span> Loading'
                )
                $('#submit').prop('disabled', true);

                form.submit();
            });
        });
    </script>
@endsection