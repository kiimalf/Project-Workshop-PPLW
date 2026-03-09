<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Modul4Controller extends Controller
{
    public function tableHTML() {
        return view('modul4.tableHTML');
    }

    public function datatables() {
        return view('modul4.datatables');
    }
    
    public function selectKota() {
        return view('modul4.2select');
    }
}
