@extends('layouts.main')

@section('content')
<div class="page-header">
    <h3 class="page-title">Pemesanan Kantin</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Pemesanan</li>
        </ol>
    </nav>
</div>

<div class="row">

    {{-- Kiri: Daftar Menu (List View) --}}
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">🍽️ Daftar Menu</h5>
                <span class="badge badge-secondary">{{ $menus->count() }} menu</span>
            </div>
            <div class="card-body p-0">
                @if($menus->isEmpty())
                    <div class="text-center py-5 text-muted">
                        <p>Belum ada menu tersedia.</p>
                    </div>
                @else
                    <div class="list-group list-group-flush" id="menuList">
                        @foreach($menus as $menu)
                        <div class="list-group-item d-flex align-items-center"
                            id="menu-row-{{ $menu->idmenu }}">

                            {{-- Info menu --}}
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center">
                                    <span style="font-size:1.5rem; margin-right:10px">🍽️</span>
                                    <div>
                                        <div class="font-weight-bold">{{ $menu->nama_menu }}</div>
                                        <small class="text-muted">
                                            {{ $menu->vendor->nama_vendor }}
                                            &nbsp;·&nbsp;
                                            Stok: {{ $menu->stok }}
                                        </small>
                                    </div>
                                </div>
                            </div>

                            {{-- Harga --}}
                            <div class="text-success font-weight-bold mr-3"
                                style="min-width:110px; text-align:right; white-space:nowrap">
                                Rp {{ number_format($menu->harga, 0, ',', '.') }}
                            </div>

                            {{-- Tombol Tambah / Qty Control --}}
                            <div class="qty-wrap" style="min-width:140px; text-align:right">
                                <button class="btn btn-primary btn-sm btn-tambahMenu"
                                        data-id="{{ $menu->idmenu }}"
                                        data-nama="{{ $menu->nama_menu }}"
                                        data-harga="{{ $menu->harga }}"
                                        data-jumlah="0">
                                    + Tambah
                                </button>
                            </div>

                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Kanan: Keranjang --}}
    <div class="col-lg-4">

        {{-- Placeholder keranjang kosong --}}
        <div id="cartEmpty" class="card">
            <div class="card-body text-center text-muted py-4">
                <div style="font-size:2.5rem">🛒</div>
                <p class="mt-2 mb-0" style="font-size:.9rem">
                    Keranjang masih kosong.<br>Pilih menu untuk mulai pesan.
                </p>
            </div>
        </div>

        {{-- Keranjang berisi --}}
        <div class="card" id="cartCard" style="display:none">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Keranjang</h5>
                <button class="btn btn-link btn-sm text-danger p-0" id="btnKosongkan">
                    Kosongkan
                </button>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Menu</th>
                            <th class="text-center">Harga</th>
                            <th class="text-center">Qty</th>
                            <th class="text-right">Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="cartBody"></tbody>
                </table>
            </div>
            <div class="card-footer bg-white">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <strong>Total</strong>
                    <strong class="text-success" id="totalHarga" style="font-size:1.15rem">Rp 0</strong>
                </div>

                <div class="d-flex justify-content-center">
                    <button id="btnCheckout" class="btn btn-success btn-block m-auto">
                        Check Out
                    </button>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection

@section('script-page')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function () {

    let cart     = [];
    let totalHarga = 0;

    $(document).on('click', '.btn-tambahMenu', function () {
        const id     = parseInt($(this).data('id'));
        const nama   = $(this).data('nama');
        const harga  = parseInt($(this).data('harga'));

        let qty = 1;

        Swal.fire({
            title: `Tambah ${nama}`,
            html: `
                <div class="d-flex justify-content-center align-items-center">
                    <button id="btnMinus" class="btn btn-outline-secondary">−</button>
                    <span id="qtyValue" class="mx-3 font-weight-bold" style="font-size:1.2rem">1</span>
                    <button id="btnPlus" class="btn btn-outline-secondary">+</button>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Tambahkan',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#28a745',
            didOpen: () => {
                const minusBtn = document.getElementById('btnMinus');
                const plusBtn  = document.getElementById('btnPlus');
                const qtyText  = document.getElementById('qtyValue');

                minusBtn.addEventListener('click', () => {
                    if (qty > 1) {
                        qty--;
                        qtyText.innerText = qty;
                    }
                });

                plusBtn.addEventListener('click', () => {
                    qty++;
                    qtyText.innerText = qty;
                });
            }
        }).then(result => {
            if (!result.isConfirmed) return;

            const exist = cart.find(c => c.idmenu === id);

            if (exist) {
                exist.qty += qty; // ✅ tambah qty
            } else {
                cart.push({
                    idmenu: id,
                    nama_menu: nama,
                    harga: harga,
                    qty: qty
                });
            }

            renderCart();
        });
    });

    $(document).on('click', '.btn-tambah-list', function () {
        const id  = parseInt($(this).data('id'));
        const idx = cart.findIndex(c => c.idmenu === id);
        if (idx > -1) cart[idx].qty++;
        renderCart();
    });

    $(document).on('click', '.btn-kurang', function () {
        const id  = parseInt($(this).data('id'));
        const idx = cart.findIndex(c => c.idmenu === id);
        if (idx === -1) return;

        cart[idx].qty--;
        if (cart[idx].qty <= 0) {
            cart.splice(idx, 1);
        }

        renderCart();
    });

    $(document).on('click', '.btn-hapus', function () {
        const id  = parseInt($(this).data('id'));
        cart = cart.filter(c => c.idmenu !== id);
        renderCart();
        renderListHighlight();
    });

    $('#btnKosongkan').on('click', function () {
        Swal.fire({
            title: 'Kosongkan keranjang?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
            confirmButtonColor: '#dc3545',
        }).then(r => {
            if (r.isConfirmed) {
                cart     = [];
                renderCart();
            }
        });
    });

    function renderCart() {
        if (cart.length === 0) {
            $('#cartCard').hide();
            $('#cartEmpty').show();
            $('#cartBody').html('');
            $('#totalHarga').text('Rp 0');
            return;
        }

        $('#cartEmpty').hide();
        $('#cartCard').show();

        let total = 0;
        let html  = '';

        cart.forEach(item => {
            const sub = item.harga * item.qty;
            total += sub;
            html += `
                <tr>
                    <td style="font-size:.85rem">${item.nama_menu}</td>
                    <td class="text-center" style="font-size:.85rem">${item.harga}</td>
                    <td class="text-center" style="white-space:nowrap">
                        <button class="btn btn-outline-secondary btn-xs btn-kurang"
                                data-id="${item.idmenu}" style="padding:0 6px">−</button>
                        <span class="mx-1 font-weight-bold">${item.qty}</span>
                        <button class="btn btn-outline-secondary btn-xs btn-tambah-list"
                                data-id="${item.idmenu}" style="padding:0 6px">+</button>
                    </td>
                    <td class="text-right" style="font-size:.85rem; white-space:nowrap">
                        ${formatRupiah(sub)}
                    </td>
                    <td class="text-center">
                        <button class="btn btn-link btn-sm text-danger p-0 btn-hapus"
                                data-id="${item.idmenu}">✕</button>
                    </td>
                </tr>`;
        });

        totalHarga = total;
        $('#cartBody').html(html);
        $('#totalHarga').text(formatRupiah(total));
    }

    $('#btnCheckout').on('click', function () {
        if (cart.length === 0) {
            Swal.fire({ icon: 'warning', title: 'Peringatan', text: 'Keranjang masih kosong!' });
            return;
        }

        const metode = 'qris';

        Swal.fire({
            title: 'Konfirmasi Pesanan',
            html: `Metode bayar: <b>QRIS</b><br>
                Total: <b style="color:#28a745">${$('#totalHarga').text()}</b>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Bayar!',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#28a745',
        }).then(result => {
            if (!result.isConfirmed) return;

            $('#btnCheckout')
                .prop('disabled', true)
                .html('<span class="spinner-border spinner-border-sm mr-1"></span> Memproses...');

            axios.post('{{ route(name: 'customer.checkout') }}', {
                cart: cart.map(i => ({
                    idmenu: i.idmenu,
                    qty: i.qty
                })),
                metode_bayar: metode,
                total: $('#totalHarga')
            }, {
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            })
            .then(res => {
                console.log(res.data);
                const idpesanan = res.data.idpesanan;
                window.location.href = `{{ url('customer/payment') }}/${idpesanan}`;
            })
            .catch(err => {
                const msg = err.response?.data?.message ?? 'Terjadi kesalahan server.';
                Swal.fire({ icon: 'error', title: 'Gagal', text: msg });
                $('#btnCheckout').prop('disabled', false).text('Check Out');
            });
        });
    });
    
    function formatRupiah(n) {
        return 'Rp ' + parseInt(n).toLocaleString('id-ID');
    }

});
</script>
@endsection
