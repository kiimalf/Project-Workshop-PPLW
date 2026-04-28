@extends('layouts.main')

@section('content')
    <div class="page-header">
        <h3 class="page-title"> Tambah Menu </h3>
    </div>

    <div class="row">
        <div class="col-lg-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Form Tambah Menu</h4>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form id="form" action="{{ route('vendor.menu.store', $idvendor) }}" method="POST">
                        @csrf
                        <input type="hidden" name="idvendor" value="{{ $idvendor }}">

                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text"
                                name="nama_menu"
                                class="form-control"
                                value="{{ old('namaMenu') }}"
                                >
                        </div>

                        <div class="form-group">
                            <label>Harga</label>
                            <input type="number" name="harga" class="form-control" value="{{ old('hargaMenu') }}">
                        </div>

                        <div class="form-group">
                            <label>Stok</label>
                            <input type="number" name="stok" class="form-control" value="{{ old('stokMenu') }}">
                        </div>
                    </form>

                    <button id="submit" class="btn btn-primary">
                        Simpan
                    </button>

                    <a href="{{ route('vendor.menu.index', $idvendor) }}" class="btn btn-light">
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