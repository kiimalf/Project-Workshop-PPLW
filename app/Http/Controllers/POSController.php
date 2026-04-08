<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Barang;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;

class POSController extends Controller
{
    public function POS_ajax() {
        $barang = Barang::all();
        return view('modul.tm5_ajaxPOS', compact('barang'));
    }

    public function POS_axios() {
        $barang = Barang::all();
        return view('modul.tm5_axiosPOS', compact('barang'));
    }

    public function findBarang(Request $request) {
        $barang = Barang::where('idbarang', $request->idbarang)->first();
        if ($barang) {
            return response()->json([
                'status' => 'success',
                'data' => $barang
            ]);
        } else {
            return response()->json([
                'status' => 'error'
            ]);
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // 1. simpan penjualan
            $penjualan = Penjualan::create([
                'total' => $request->total,
                'created_at' => now()
            ]);

            // 2. simpan detail
            foreach ($request->items as $item) {
                DetailPenjualan::create([
                    'id_penjualan' => $penjualan->id_penjualan,
                    'idbarang' => $item['kode'], // pastikan ini = idbarang
                    'jumlah' => $item['jumlah'],
                    'subtotal' => $item['subtotal']
                ]);
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Transaksi berhasil disimpan'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyimpan transaksi',
                'error' => $e->getMessage()
            ]);
        }
    }
}