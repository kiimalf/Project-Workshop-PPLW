<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\DetailPesanan;

class VendorController extends Controller
{
    // public function getAllMenu() {
    //     $menus = Menu::all();
    //     return view('vendor.menu.index', compact('menus'));
    // }

    public function getMenuByVendor()
    {
        $idvendor = '1';
        $menus = Menu::where('idvendor', $idvendor)->get();
        return view('vendor.menu.index', compact('menus', 'idvendor'));
    }

    public function createMenu($idvendor) {
        return view('vendor.menu.create', compact('idvendor'));
    }

    public function editMenu(Request $request) {
        $menu = Menu::findOrFail($request->idmenu);
        return view('vendor.menu.edit', compact('menu'));
    }

    public function updateMenu(Request $request, String $idvendor, String $idmenu) {
        $request->validate([
            'nama_menu' => 'required|string',
            'harga' => 'required|numeric',
            'stok' => 'required|integer'
        ]);

        $menu = Menu::findOrFail($idmenu);
        $menu->update([
            'nama_menu' => $request->nama_menu,
            'harga' => $request->harga,
            'stok' => $request->stok
        ]);
        return redirect()->route('vendor.menu.index', $idvendor)->with('success', 'Menu berhasil diperbarui!');
    }

    public function storeMenu(Request $request, String $idvendor) {
        $request->validate([
            'nama_menu' => 'required|string',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'idvendor' => 'required|integer|exists:vendor,idvendor',
        ]);

        Menu::create($request->all());
        return redirect()->route('vendor.menu.index', $idvendor)->with('success', 'Menu berhasil ditambahkan!');
    }
    
    public function deleteMenu(Request $request) {
        $menu = Menu::findOrFail($request->idmenu);
        $idvendor = $menu->idvendor;
        $menu->delete();
        return redirect()->route('vendor.menu.index', $idvendor)->with('success', 'Menu berhasil dihapus!');
    }

    public function getPesananByVendor() {
        // $vendor = Vendor::findOrFail($idvendor);
        $idvendor = '1';
        $pesanan = Pesanan::with(['customer', 'detail.menu'])->whereHas('detail.menu', function ($menu) use ($idvendor) {
            $menu->where('idvendor', $idvendor);
        })->get();
        return view('vendor.pesanan.index', compact('pesanan', 'idvendor'));
    }
    
    public function getPesananLunasByVendor() {
        $idvendor = '1';
        $vendor = Vendor::findOrFail($idvendor);
        $pesanan = Pesanan::where('idvendor', $idvendor)->where('status', 'lunas')->with(['customer', 'detail.menu'])->get();
        return view('vendor.pesanan.index', compact('pesanan'));
    }

    public function getDetailPesanan($idvendor, $idpesanan)
    {
        $pesanan = Pesanan::with(['customer', 'payment'])
            ->where('idpesanan', $idpesanan)
            ->firstOrFail();

        $detailPesanan = DetailPesanan::where('idpesanan', $idpesanan)
            ->whereHas('menu', function ($q) use ($idvendor) {
                $q->where('idvendor', $idvendor);
            })
            ->with('menu')
            ->get();

        return view('vendor.pesanan.detail', compact('idvendor', 'detailPesanan', 'pesanan'));
    }
}
