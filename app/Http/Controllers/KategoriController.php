<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    // Tampilkan semua kategori
    public function index()
    {
        $kategori = Kategori::all();
        return view('kategori.index', compact('kategori'));
    }

    // Tampilkan form tambah
    public function create()
    {
        return view('kategori.create');
    }

    // Simpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required'
        ]);

        Kategori::create($request->all());

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    // Tampilkan detail kategori
    public function show(string $id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('kategori.show', compact('kategori'));
    }

    // Tampilkan form edit
    public function edit(string $id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('kategori.edit', compact('kategori'));
    }

    // Update kategori
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_kategori' => 'required'
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update($request->all());

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil diperbarui');
    }

    // Hapus kategori
    public function destroy(string $id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil dihapus');
    }
}