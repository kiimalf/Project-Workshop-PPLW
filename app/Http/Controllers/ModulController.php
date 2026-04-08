<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Provinsi;
use App\Models\Kota;
use App\Models\Kecamatan;
use App\Models\Kelurahan;

class ModulController extends Controller
{
    public function tm4_tableHTML() {
        return view('modul.tm4_tableHTML');
    }

    public function tm4_datatables() {
        return view('modul.tm4_datatables');
    }
    
    public function tm4_selectKota() {
        return view('modul.tm4_2select');
    }

    public function tm5_index(){
        return view('modul.tm5_index');
    }

    public function tm5_ajaxSubmit(Request $req) {
        $data = $req->post('name');

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Data Received Successfully',
            'data' => [
                'name' => $data
            ]
        ]);
    }

    public function tm5_ajaxSelect() {
        return view('modul.tm5_ajaxSelect');
    }

    public function tm5_axiosSelect() {
        return view('modul.tm5_axiosSelect');
    }

    public function tm5_getProvinsi() {
        $provinsi = Provinsi::all();
        return response()->json([
            'status' => 'success',
            'data' => $provinsi
        ]);
    }

    public function tm5_getKota(Request $request) {
        $kota = Kota::where('province_id', $request->province_id)->get();
        return response()->json([
            'status' => 'success',
            'data' => $kota
        ]);
    }

    public function tm5_getKecamatan(Request $request) {
        $kecamatan = Kecamatan::where('regency_id', $request->regency_id)->get();
        return response()->json([
            'status' => 'success',
            'data' => $kecamatan
        ]);
    }

    public function tm5_getKelurahan(Request $request){
        $kelurahan = Kelurahan::where('district_id', $request->district_id)->get();
        return response()->json([
            'status' => 'success',
            'data' => $kelurahan
        ]);
    }

}