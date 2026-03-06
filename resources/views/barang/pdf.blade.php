<!DOCTYPE html>
<html>
<head>
<style>
@page {
    size: A4 landscape;
    margin: 12mm 7mm 12mm 7mm; /* top right bottom left */
}

body {
    margin: 0;
    padding: 0;
}

.label {
    width: 38mm;
    height: 18mm;
    float: left;
    margin-right: 2mm;   /* jarak horizontal */
    margin-bottom: 3mm;  /* jarak vertikal */
    
    display: flex;
    text-align: center;
    align-items: center;
    justify-content: center;
    
    font-size: 11px;
    box-sizing: border-box;
    border: 0.5px solid black; /* untuk testing */
}
</style>
</head>
<body>

@php
    $cols = 5;
    $rows = 8;
    $dataIndex = 0;
    $position = 1;
@endphp

@for($i = 1; $i <= $rows; $i++)
    @for($j = 1; $j <= $cols; $j++)
        <div class="label">
            @if($position >= $startIndex && $dataIndex < count($barang))
                <strong>
                    {{ $barang[$dataIndex]->nama_barang }}
                </strong>
                <br>
                Rp {{ number_format($barang[$dataIndex]->harga, 0, ',', '.') }}

                @php $dataIndex++; @endphp
            @endif
        </div>

        @php $position++; @endphp
    @endfor

    <div style="clear: both;"></div>
@endfor

</body>
</html>