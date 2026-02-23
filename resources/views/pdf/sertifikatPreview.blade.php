@extends('layouts.main')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Preview Sertifikat</h3>

        <a href="{{ route('sertifikat.download') }}"
           class="btn btn-primary">
            <i class="mdi mdi-download"></i> Download PDF
        </a>
    </div>

    <div class="d-flex justify-content-center">
        <div class="bg-white shadow p-4"
            style="width: 297mm; min-height: 210mm; padding:20mm; box-sizing:border-box;">

            @include('pdf.sertifikat')

        </div>
    </div>

</div>

@endsection