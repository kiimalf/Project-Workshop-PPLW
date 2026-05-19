<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Picqer\Barcode\BarcodeGeneratorSVG;
use Endroid\QrCode\Builder\Builder;

class BarcodeController extends Controller
{
    public function generateBarcode($idbarang)
    {
        $generator = new BarcodeGeneratorSVG();
        $barcode = $generator->getBarcode($idbarang, $generator::TYPE_CODE_128, 3);

        return response($barcode)->header('Content-Type', 'image/svg+xml');
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
}
