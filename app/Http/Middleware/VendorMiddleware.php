<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VendorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('kantin_vendor_id')) {
            return redirect()->route('kantin.vendor.enter')
                ->with('info', 'Silakan masukkan ID Vendor kamu terlebih dahulu.');
        }
        return $next($request);
    }
}
