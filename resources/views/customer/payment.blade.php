@extends('layouts.main')

@section('content')
<div class="page-header">
    <h3 class="page-title">Pembayaran</h3>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">💳 Ringkasan Pesanan</h5>
            </div>

            <div class="card-body">

                {{-- INFO --}}
                <table class="table table-sm">
                    <tr>
                        <td class="text-muted">Order ID</td>
                        <td class="text-right">
                            <code>{{ $pesanan->order_id }}</code>
                        </td>
                    </tr>

                    <tr>
                        <td class="text-muted">Customer ID</td>
                        <td class="text-right">
                            <strong>{{ $pesanan->customer->idcustomer ?? '-' }}</strong>
                        </td>
                    </tr>
                </table>

                <hr>

                {{-- DETAIL --}}
                @foreach($pesanan->detail as $d)
                    <div class="d-flex justify-content-between mb-1">
                        <span>
                            {{ $d->menu->nama_menu }}
                            <span class="text-muted">×{{ $d->jumlah }}</span>
                        </span>
                        <span>
                            Rp {{ number_format($d->subtotal, 0, ',', '.') }}
                        </span>
                    </div>
                @endforeach

                <hr>

                {{-- TOTAL --}}
                <div class="d-flex justify-content-between">
                    <strong>Total Bayar</strong>
                    <strong class="text-success" style="font-size:1.2rem">
                        Rp {{ number_format($pesanan->total, 0, ',', '.') }}
                    </strong>
                </div>

                {{-- STATUS --}}
                <div id="statusMsg" class="alert mt-3 d-none "></div>

                {{-- BUTTON --}}
                <div class="d-flex justify-content-center">
                    <button id="btnPay"class="btn btn-success btn-block btn-lg mt-3" onclick="openSnap()">
                        💳 Bayar Sekarang
                    </button>
                </div>
                

                <p class="text-center text-muted mt-2" style="font-size:.8rem">
                    Pembayaran diproses oleh Midtrans
                </p>

            </div>
        </div>
    </div>
</div>
@endsection


@section('script-page')

{{-- SNAP JS --}}
<script src="{{ config('midtrans.snap_url') }}"
        data-client-key="{{ config('midtrans.clientKey') }}"></script>

<script>
    const SNAP_TOKEN = @json($pesanan->snap_token);
    const ORDER_ID   = @json($pesanan->order_id);
    const PESANAN_ID = @json($pesanan->idpesanan);

    function openSnap() {

        if (!SNAP_TOKEN) {
            alert('Snap token tidak ditemukan');
            return;
        }

        const btn = document.getElementById('btnPay');
        btn.disabled = true;
        btn.innerHTML = '⏳ Memuat pembayaran...';

        window.snap.pay(SNAP_TOKEN, {
            onSuccess: function(result) {
                showStatus('success', '✅ Pembayaran berhasil!');
                setTimeout(() => {
                    window.location.href = '{{ route('customer.paymentSuccess', [$pesanan->idpesanan]) }}';
                }, 2000);

                // axios.post('{{ route('customer.updateStatus') }}', {
                //     order_id: ORDER_ID,
                //     transaction_id: result.transaction_id,
                //     payment_type: result.payment_type,
                //     status: 'paid'
                // }).finally(() => {
                //     window.location.href = `{{ url('customer/paymentSuccess') }}/${PESANAN_ID}`;
                // });
            },

            onPending: function(result) {
                showStatus('warning', '⏳ Pembayaran pending');
                resetBtn();
            },

            onError: function(result) {
                alert('error');
                showStatus('danger', '❌ Pembayaran gagal');
                resetBtn();
            },

            onClose: function() {
                showStatus('warning', '⚠️ Pembayaran dibatalkan');
                resetBtn();
            }
        });
    }

    function showStatus(type, msg) {
        const message = document.getElementById('statusMsg');
        message.className = `alert alert-${type}`;
        message.innerHTML = msg;
        message.classList.remove('d-none');
    }

    function resetBtn() {
        const btn = document.getElementById('btnPay');
        btn.disabled = false;
        btn.innerHTML = '💳 Bayar Sekarang';
    }
</script>

@endsection