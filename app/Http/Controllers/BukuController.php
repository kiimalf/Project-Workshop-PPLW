<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Kategori;

class BukuController extends Controller
{
    // Tampilkan semua data
    public function index()
    {
        $buku = Buku::with('kategori')->get();
        return view('buku.index', compact('buku'));
    }

    // Tampilkan form tambah
    public function create()
    {
        $kategori = Kategori::all();
        return view('buku.create', compact('kategori'));
    }

    // Simpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required',
            'judul' => 'required',
            'pengarang' => 'required',
            'idkategori' => 'required'
        ]);

        Buku::create($request->all());

        return redirect()->route('buku.index')
            ->with('success', 'Data buku berhasil ditambahkan');
    }

    // Tampilkan detail
    public function show(string $id)
    {
        $buku = Buku::findOrFail($id);
        return view('buku.show', compact('buku'));
    }

    // Tampilkan form edit
    public function edit(string $id)
    {
        $buku = Buku::findOrFail($id);
        $kategori = Kategori::all();

        return view('buku.edit', compact('buku', 'kategori'));
    }

    // Update data
    public function update(Request $request, string $id)
    {
        $request->validate([
            'kode' => 'required',
            'judul' => 'required',
            'pengarang' => 'required',
            'idkategori' => 'required'
        ]);

        $buku = Buku::findOrFail($id);
        $buku->update($request->all());

        return redirect()->route('buku.index')
            ->with('success', 'Data buku berhasil diperbarui');
    }

    // Hapus data
    public function destroy(string $id)
    {
        $buku = Buku::findOrFail($id);
        $buku->delete();

        return redirect()->route('buku.index')
            ->with('success', 'Data buku berhasil dihapus');
    }
}