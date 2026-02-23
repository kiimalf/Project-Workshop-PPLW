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
        }

        .header {
            text-align: center;
            border-bottom: 2px solid black;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="header">
    <h4>FAKULTAS VOKASI</h4>
    <p>Universitas Airlangga</p>
</div>

<h4 style="text-align:center;">{{ $judul }}</h4>

<p>Dengan hormat, <strong>{{ $nama }}</strong> </p> 

<p>Kami mengundang Anda untuk menghadiri rapat yang akan dilaksanakan pada:</p>

<ul>
    <li><strong>Tanggal:</strong> {{ $tanggal }}</li>
    <li><strong>Tempat:</strong> {{ $tempat }}</li>
</ul>

<p>Demikian undangan ini disampaikan.</p>

<br><br>

<p>Hormat kami,</p>
<p><strong>Dekan Fakultas</strong></p>

</body>
</html>