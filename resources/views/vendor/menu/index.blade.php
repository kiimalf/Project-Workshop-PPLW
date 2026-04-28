@extends('layouts.main')

@section('content')
    <div class="page-header">
        <h3 class="page-title"> Daftar Menu </h3>
    </div>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title mb-0">Index Menu</h4>

                <!-- BUTTON CREATE -->
                <a href="{{ route('vendor.menu.create', $idvendor) }}" class="btn btn-primary btn-sm">
                    + Tambah Menu
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
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($menus as $menu)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $menu->nama_menu }}</td>
                            <td>{{ $menu->harga }}</td>
                            <td>{{ $menu->stok }}</td>
                            <td>
                                <a href="{{ route('vendor.menu.edit', ['idvendor' => $idvendor, 'idmenu' => $menu->idmenu]) }}"
                                    class="btn btn-warning btn-sm">
                                    Edit
                                </a>
                                <form id="form-{{ $menu->idmenu }}"
                                    action="{{ route('vendor.menu.delete', ['idvendor' => $idvendor, 'idmenu' => $menu->idmenu]) }}"
                                    method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')

                                    <button type="button"
                                            id="deleteButton-{{ $menu->idmenu }}"
                                            class="btn btn-danger btn-sm">
                                        Hapus
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                Tidak ada data Menu
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