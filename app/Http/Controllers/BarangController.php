<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use Barryvdh\DomPDF\Facade\Pdf;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barang = Barang::all();
        return view('barang.index', compact ('barang'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('barang.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'harga' => 'required',
            'stok' => 'required',
        ]);

        Barang::create(request()->all());

        return redirect()->route('barang.index')->with('success', 'Data barang berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $barang = Barang::findOrFail($id);
        return view('barang.show', compact('barang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $barang = Barang::findOrFail($id);

        return view('barang.edit', compact('barang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_barang' => 'required',
            'harga' => 'required',
            'stok' => 'required',
        ]);

        $barang = Barang::findOrFail($id);
        $barang->update($request->all());

        return redirect()->route('barang.index')->with('success', 'Data barang berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Data barang berhasil dihapus');
    }

    public function preview() {
        $barang = Barang::all();
        return view('barang.previewPdf', compact('barang'));
    }
    public function previewPdf(Request $request){
        $barang = Barang::all();

        $previewData = [];
        $startIndex = null;

        if ($request->isMethod('post')) {

            $request->validate([
                'idbarang' => 'required',
                'posisi_x' => 'required|integer|min:1|max:5',
                'posisi_y' => 'required|integer|min:1|max:8',
            ]);

            $previewData = Barang::whereIn(
                'idbarang', 
                $request->idbarang
            )->get();

            $startIndex = (($request->posisi_y - 1) * 5) 
                        + $request->posisi_x;
        }

        return view('barang.previewPdf', compact(
            'barang',
            'previewData',
            'startIndex'
        ));
    }

    public function printPdf(Request $request) {
        
        $request->validate([
            'idbarang' => 'required',
            'posisi_x' => 'required|integer|min:1|max:5',
            'posisi_y' => 'required|integer|min:1|max:8',
        ]);

        $barang = Barang::whereIn(
            'idbarang',
            $request->idbarang
        )->get()->values();

        $startIndex = (($request->posisi_y - 1) * 5)
                    + $request->posisi_x;
                    
        $pdf = Pdf::loadView('barang.pdf', compact(
            'barang',
            'startIndex'
        ));

        return $pdf->download('tag-harga.pdf');

        }
}
