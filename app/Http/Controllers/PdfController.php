<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class PdfController extends Controller
{
    public function previewSertifikat()
    {
        $data = [
            'nama' => Auth::user()->name,
            'kegiatan' => 'Workshop Laravel Advanced',
            'tanggal' => date('d F Y'),
        ];

        return view('pdf.sertifikatPreview', $data);
    }

    public function downloadSertifikat() {
        $data = [
            'nama' => Auth::user()->name,
            'kegiatan' => 'Workshop Laravel Advanced',
            'tanggal' => date('d F Y'),
        ];

        $pdf = Pdf::loadView('pdf.sertifikat', $data)->setPaper('A4', 'Landscape');

        return $pdf->stream('sertifikat.pdf');
    }

    public function previewUndangan()
    {
        $data = [
            'nama' => Auth::user()->name,
            'judul' => 'UNDANGAN RAPAT AKADEMIK',
            'tanggal' => '25 Februari 2026',
            'tempat' => 'Ruang Seminar Fakultas',
        ];

        return view('pdf.undanganPreview', $data);
    }
    public function downloadUndangan() {
        $data = [
            'nama' => Auth::user()->name,
            'judul' => 'UNDANGAN RAPAT AKADEMIK',
            'tanggal' => '25 Februari 2026',
            'tempat' => 'Ruang Seminar Fakultas',
        ];

        $pdf = Pdf::loadView('pdf.undangan', $data)->setPaper('A4', 'Portrait');

        return $pdf->stream('undangan.pdf');
    }
}
