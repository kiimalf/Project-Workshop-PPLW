<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('kantin_customer_id')) {
            return redirect()->route('kantin.customer.enter')
                ->with('info', 'Silakan masukkan nama kamu terlebih dahulu.');
        }
        return $next($request);
    }
}
