<!DOCTYPE html>
<html>
<head>
    <style>
        @page {
            margin: 20mm;
        }

        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        h1 {
            font-size: 36px;
        }

        .nama {
            font-size: 28px;
            font-weight: bold;
            margin: 20px 0;
        }
    </style>
</head>
<body>

<h1>SERTIFIKAT</h1>

<p>Diberikan kepada:</p>

<div class="nama">{{ $nama }}</div>

<p>Atas partisipasi dalam kegiatan</p>

<h3>{{ $kegiatan }}</h3>

<p>{{ $tanggal }}</p>

</body>
</html>