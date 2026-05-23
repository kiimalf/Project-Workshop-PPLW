<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Picqer\Barcode\BarcodeGeneratorSVG;
use Endroid\QrCode\Builder\Builder;

class BarcodeController extends Controller
{
    public function generateBarcode($data)
    {
        $generator = new BarcodeGeneratorSVG();
        $barcode = $generator->getBarcode($data, $generator::TYPE_CODE_128, 3);

        return response($barcode)->header('Content-Type', 'image/svg+xml');
    }

    public function generateQrCode($data)
    {
        $builder = new Builder(
            writerOptions: [],
            validateResult: false,
            data: $data,
            size: 300,
            margin: 10,
            labelText: $data,
        );

        $qrCode = $builder->build();

        return response($qrCode->getString())->header('Content-Type', $qrCode->getMimeType());
    }
}
