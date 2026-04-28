<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Menu;
use App\Models\Vendor;
use App\Models\Customer;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Payment;

class CustomerController extends Controller
{
    public function index() {
        $vendors = Vendor::all();
        $menus = Menu::all();
        return view('customer.index', compact('vendors', 'menus'));
    }

    public function checkout(Request $request) {
        $request->validate([
            'cart'         => 'required|array|min:1',
            'cart.*.idmenu'  => 'required|integer|exists:menu,idmenu',
            'cart.*.qty'     => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $customer = Customer::create(['nama' => 'Guest']);

            $customer = Customer::latest()->first();

            // 2. Hitung total dari cart
            $total     = 0;
            $cartItems = [];
            foreach ($request->cart as $item) {
                $menu = Menu::findOrFail($item['idmenu']);
                $sub  = $menu->harga * $item['qty'];
                $total += $sub;
                $cartItems[] = [
                    'menu'    => $menu,
                    'qty'     => $item['qty'],
                    'subtotal' => $sub,
                ];
            }

            $orderId = 'ORDER-' . strtoupper(Str::random(8)) . '-' . time();

            // 4. Simpan pesanan
            $pesanan = Pesanan::create([
                'order_id' => $orderId,
                'idcustomer'=> $customer->idcustomer,
                'total'=> $total,
                'status'=> 'pending',
            ]);

            // 5. Simpan detail pesanan
            foreach ($cartItems as $ci) {
                DetailPesanan::create([
                    'idpesanan'=> $pesanan->idpesanan,
                    'idmenu'=> $ci['menu']->idmenu,
                    'jumlah'=> $ci['qty'],
                    'harga'=> $ci['menu']->harga,
                    'subtotal'=> $ci['subtotal'],
                    'catatan'=> null,
                ]);
            }

            // 6. Minta Snap Token ke Midtrans
            $snapResult = $this->createSnapToken($pesanan, $cartItems, $customer);

            if (!$snapResult['success']) {
                DB::rollBack();
                return response()->json(['message' => 'Gagal membuat token Midtrans: ' . $snapResult['error']], 500);
            }

            // 7. Simpan snap_token & buat record payment
            $pesanan->update(['snap_token' => $snapResult['token']]);

            Payment::create([
                'idpesanan'    => $pesanan->idpesanan,
                'metode_bayar' => $request->metode_bayar,
                'transaction_id' => null,
                'status'       => 'pending',
            ]);

            DB::commit();

            return response()->json([
                'idpesanan'  => $pesanan->idpesanan,
                'snap_token' => $snapResult['token'],
                'order_id'   => $orderId,
                'guest_id'   => $customer->idcustomer,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    public function payment($idpesanan) {
        $pesanan = Pesanan::with(['detail.menu', 'customer'])->findOrFail($idpesanan);

        if ($pesanan->status === 'lunas') {
            return redirect()->route('customer.success', $idpesanan);
        }

        return view('customer.payment', compact('pesanan'));
    }

    public function paymentSuccess($idpesanan)
    {
        $pesanan = Pesanan::with(['detail.menu', 'customer', 'payment'])->findOrFail($idpesanan);
        return view('customer.paymentSuccess', compact('pesanan'));
    }

    public function updateStatus(Request $request)
    {
        $request->validate(['order_id' => 'required|string']);

        $pesanan = Pesanan::where('order_id', $request->order_id)->firstOrFail();

        if ($pesanan->status !== 'lunas') {
            $pesanan->update(['status' => 'lunas']);

            if ($pesanan->payment) {
                $pesanan->payment->update([
                    'status'       => 'settlement',
                    'payment_type' => $request->payment_type ?? null,
                    'transaction_id' => $request->transaction_id ?? null,
                    // 'va_number'    => $request->va_number ?? null,
                ]);
            }
        }

        return response()->json(['success' => true]);
    }

    public function webhook(Request $request)
    {
        logger('WEBHOOK MASUK');
        logger($request->all());
        $payload = $request->all();

        $orderId     = $payload['order_id'] ?? '';
        $statusCode  = $payload['status_code'] ?? '';
        $grossAmount = $payload['gross_amount'] ?? '';
        $signature   = $payload['signature_key'] ?? '';
        $txStatus    = $payload['transaction_status'] ?? '';
        $paymentType = $payload['payment_type'] ?? '';
        $txId        = $payload['transaction_id'] ?? '';

        logger($paymentType);

        // 🔐 Verifikasi signature
        $expected = hash(
            'sha512',
            $orderId . $statusCode . $grossAmount . config('midtrans.serverKey')
        );

        if ($signature !== $expected) {
            return response('Invalid signature', 403);
        }

        $pesanan = Pesanan::where('order_id', $orderId)->first();

        if (!$pesanan) {
            return response('Order tidak ditemukan', 404);
        }
        if (in_array($txStatus, ['settlement', 'capture'])) {

            $pesanan->update(['status' => 'lunas']);

            $pesanan->payment?->update([
                'status' => 'settlement',
                'metode_bayar' => strtoupper($paymentType),
                'transaction_id' => $txId,
            ]);

        } elseif (in_array($txStatus, ['cancel', 'deny', 'expire'])) {

            $pesanan->update(['status' => 'batal']);

            $pesanan->payment?->update([
                'status'         => $txStatus,
                'transaction_id' => $txId,
            ]);
        } elseif (in_array($txStatus, ['pending'])) {
            $pesanan->update(['status' => 'pending']);

            $pesanan->payment?->update([
                'status' => 'pending',
                'transaction_id' => $txId,
            ]);
        }

        return response('OK', 200);
    }

    private function createSnapToken(Pesanan $pesanan, array $cartItems, Customer $customer): array
    {
        try {
            // 🔧 Setup Midtrans
            \Midtrans\Config::$serverKey = config('midtrans.serverKey');
            \Midtrans\Config::$isProduction = config('midtrans.isProduction');
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            // 📦 Item details
            $itemDetails = collect($cartItems)->map(function ($i) {
                return [
                    'id'       => (string) $i['menu']->idmenu,
                    'price'    => (int) $i['menu']->harga,
                    'quantity' => (int) $i['qty'],
                    'name'     => substr($i['menu']->nama_menu, 0, 50),
                ];
            })->toArray();

            // 📤 Payload ke Midtrans
            $params = [
                'transaction_details' => [
                    'order_id'     => $pesanan->order_id, // ✅ pakai dari DB
                    'gross_amount' => (int) $pesanan->total,
                ],
                'item_details' => $itemDetails,
                'customer_details' => [
                    'first_name' => $customer->nama,
                ],
                'callbacks' => [
                    'finish' => route('customer.paymentSuccess', ['idpesanan' => $pesanan->idpesanan])
                ],
            ];


            // 🎯 Generate Snap Token
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            return [
                'success' => true,
                'token'   => $snapToken
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error'   => $e->getMessage()
            ];
        }
    }
}
