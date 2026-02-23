@extends('layouts.main')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Preview Undangan</h3>

        <a href="{{ route('undangan.download') }}"
           class="btn btn-primary">
            <i class="mdi mdi-download"></i> Download PDF
        </a>
    </div>

    <div class="d-flex justify-content-center">
        <div class="bg-white shadow p-5"
             style="width: 210mm; min-height: 297mm;">

            @include('pdf.undangan')

        </div>
    </div>

</div>

@endsection