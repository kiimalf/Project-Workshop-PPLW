@extends('layouts.main')

@section('style-page')
    <link rel="stylesheet"
    href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <style>
    .preview-container {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 8px;
    }

    .preview-label {
        height: 100px;
        border: 1px solid #ccc;
        background: #ffffff;
        text-align: center;
        padding: 10px;
        font-size: 13px;
        border-radius: 4px;
    }

    .preview-label:hover {
        background: #f8f9fa;
    }
    </style>
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

                    </div>
                    <form action="{{ route('barang.previewPdf') }}" method="POST">
                        @csrf

                        <table class="table" id="tableBarang">
                            <thead>
                                <tr>
                                    <th>Pilih</th>
                                    <th>ID</th>
                                    <th>Nama Barang</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th>created_at</th>
                                    <th>updated_at</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($barang as $item)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="idbarang[]" value="{{ $item->idbarang }}">
                                        </td>
                                        <td>{{ $item->idbarang }}</td>
                                        <td>{{ $item->nama_barang }}</td>
                                        <td>{{ $item->harga }}</td>
                                        <td>{{ $item->stok }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ $item->updated_at }}</td>
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
                        <div class="mb-3">
                            X (1-5):
                            <input type="number" name="posisi_x" min="1" max="5" required>

                            Y (1-8):
                            <input type="number" name="posisi_y" min="1" max="8" required>

                            <button type="submit" class="btn btn-success btn-sm">
                                Cetak PDF
                            </button>
                        </div>
                    </form>
                    @if(!empty($previewData))
                        <hr>

                        <div class="mt-4">
                            <h5 class="mb-3">Preview Label (5 x 8)</h5>

                            <div class="preview-container">
                                @php $total = 40; @endphp

                                @for($i = 1; $i <= $total; $i++)
                                    <div class="preview-label">
                                        @if($i >= $startIndex && isset($previewData[$i - $startIndex]))
                                            <div class="fw-bold">
                                                {{ $previewData[$i - $startIndex]->nama_barang }}
                                            </div>
                                            <div>
                                                Rp {{ number_format(
                                                    $previewData[$i - $startIndex]->harga,
                                                    0, ',', '.'
                                                ) }}
                                            </div>
                                        @endif
                                    </div>
                                @endfor
                            </div>
                        </div>
                    @endif
                    @if(!empty($previewData))
                        <form action="{{ route('barang.print') }}" method="POST" target="_blank">
                            @csrf

                            {{-- Kirim ulang data yang dipilih --}}
                            @foreach($previewData as $item)
                                <input type="hidden" name="idbarang[]" value="{{ $item->idbarang }}">
                            @endforeach

                            <input type="hidden" name="posisi_x" value="{{ request('posisi_x') }}">
                            <input type="hidden" name="posisi_y" value="{{ request('posisi_y') }}">
                            <input type="hidden" name="startIndex" value="{{ $startIndex }}">
                            <button type="submit" class="btn btn-primary mt-3">
                                Download PDF
                            </button>
                        </form>

                    @endif
                </div>
            </div>
        </div>
    </div>

    
@endsection

@section('script-page')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function () {
    $('#tableBarang').DataTable();
});
</script>
@endsection