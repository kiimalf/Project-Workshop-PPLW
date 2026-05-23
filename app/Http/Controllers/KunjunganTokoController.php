<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Toko;
use App\Models\Kunjungan;
use Picqer\Barcode\BarcodeGeneratorSVG;
use Endroid\QrCode\Builder\Builder;

class KunjunganTokoController extends Controller
{
    public function indexToko()
    {
        $toko = Toko::all();
        return view('kunjungan_toko.toko', compact('toko'));
    }

    public function createToko()
    {
        return view('kunjungan_toko.createToko');
    }

    public function editToko(Request $request)
    {
        $toko = Toko::findOrFail($request->id);
        return view('kunjungan_toko.editToko', compact('toko'));
    }

    public function storeToko(Request $request)
    {
        $request->validate([
            'nama_toko' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'accuracy' => 'required|numeric'
        ]);

        Toko::create($request->all());
        return redirect()->route('kunjungan_toko.toko')->with('success', 'Toko berhasil ditambahkan!');
    }

    public function updateToko(Request $request, String $id)
    {
        $request->validate([
            'nama_toko' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'accuracy' => 'required|numeric'
        ]);

        $toko = Toko::findOrFail($id);
        $toko->update([
            'nama_toko' => $request->nama_toko,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'accuracy' => $request->accuracy
        ]);
        return redirect()->route('kunjungan_toko.toko')->with('success', 'Toko berhasil diperbarui!');
    }

    public function deleteToko(String $id)
    {
        $toko = Toko::findOrFail($id);
        $toko->delete();
        return redirect()->route('kunjungan_toko.toko')->with('success', 'Toko berhasil dihapus!');
    }

    public function generateQrCode($idpesanan)
    {
        $builder = new Builder(
            writerOptions: [],
            validateResult: false,
            data: $idpesanan,
            size: 300,
            margin: 10,
            labelText: $idpesanan,
        );

        $qrCode = $builder->build();

        return response($qrCode->getString())->header('Content-Type', $qrCode->getMimeType());
    }

    public function indexKunjungan()
    {
        $kunjungan = Kunjungan::with('toko')->get();
        return view('kunjungan_toko.kunjungan', compact('kunjungan'));
    }

    public function createKunjungan()
    {
        $toko = Toko::all();
        return view('kunjungan_toko.createKunjungan', compact('toko'));
    }

    public function storeKunjungan(Request $request)
    {
        $request->validate([
            'idtoko' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'accuracy' => 'required|numeric',
            'jarak' => 'required|numeric',
            'status' => 'required|string'
        ]);

        Kunjungan::create([
            'idtoko' => $request->idtoko,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'accuracy' => $request->accuracy,
            'jarak' => $request->jarak,
            'status' => $request->status
        ]);

        $pesan = "Kunjungan " . $request->status . " (Jarak Aktual: " . $request->jarak . "m)";
        
        if($request->status == 'DITERIMA'){
            return redirect()->route('kunjungan_toko.kunjungan')->with('success', $pesan);
        } else {
            return redirect()->route('kunjungan_toko.kunjungan')->with('error', $pesan);
        }
    }
}