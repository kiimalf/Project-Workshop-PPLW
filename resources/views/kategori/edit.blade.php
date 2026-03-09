@extends('layouts.main')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Edit Kategori </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('kategori.index') }}">Kategori</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Edit Kategori
            </li>
        </ol>
    </nav>
</div>

    <div class="row">
        <div class="col-lg-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Form Edit Kategori</h4>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form id="form" action="{{ route('kategori.update', $kategori->idkategori) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Nama Kategori</label>
                            <input type="text" name="nama_kategori" class="form-control" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required>
                        </div>
                    </form>

                    <button id="submit" class="btn btn-warning">
                        Update
                    </button>

                    <a href="{{ route('kategori.index') }}" class="btn btn-light">
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