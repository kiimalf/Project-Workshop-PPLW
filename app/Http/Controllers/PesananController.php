<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Customer;
use App\Models\Vendor;

class PesananController extends Controller
{
    public function index() {
        $pesanan = Pesanan::all();
        return view('customer.pesanan', compact('pesanan'));
    }

    public function getPesananByCustomer($idcustomer) {
        $pesanan = Pesanan::where('idcustomer', $idcustomer)->get();
        return response()->json([
            'status' => 'success',
            'data' => $pesanan
        ]);
    }

    public function getPesananByVendor($idvendor) {
        $pesanan = Pesanan::whereHas('detailPesanan.menu', function($query) use ($idvendor) {
            $query->where('idvendor', $idvendor);
        })->get();

        return response()->json([
            'status' => 'success',
            'data' => $pesanan
        ]);
    }

    public function getDetail($idpesanan) {
        $detailPesanan = DetailPesanan::where('idpesanan', $idpesanan)->get();
        return response()->json([
            'status' => 'success',
            'data' => $detailPesanan
        ]);
    }
}