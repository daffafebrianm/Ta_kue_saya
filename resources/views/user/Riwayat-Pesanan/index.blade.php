@extends('user.layouts.main')

@section('content')

<div class="container my-0" style="background-image: url('/path/to/your/image.png'); background-size: cover; background-position: center center; background-repeat: no-repeat;">
    <h3 class="text-center mb-5 py-3" style="color: #fff;">Daftar Pesanan Saya</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($orders->isEmpty())
        <div class="alert alert-info">Belum ada pesanan.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="thead-light">
                    <tr>
                        <th style="width:160px;">Kode Pesanan</th>
                        <th style="width:140px;">Tanggal</th>
                        <th>Produk (Ringkas)</th>
                        <th style="width:160px;">Total</th>
                        <th style="width:140px;">Status Pembayaran</th>
                        <th style="width:140px;">Status Pengiriman</th>
                        <th style="width:170px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $o)
                    @php
                        // Map badge untuk status
                        $payBadge = match($o->payment_status) {
                            'pending' => 'warning',
                            'waiting_verification' => 'info',
                            'paid' => 'success',
                            'failed' => 'danger',
                            default => 'secondary'
                        };
                        $shipBadge = match($o->shipping_status) {
                            'pending' => 'warning',
                            'packed' => 'info',
                            'shipped' => 'primary',
                            'delivered' => 'success',
                            default => 'secondary'
                        };

                        // Buat ringkasan 2-3 produk pertama
                        $items = $o->orderDetails->take(3)->map(function($d){
                            $nama = $d->produk->nama ?? 'Produk';
                            return "{$nama} × {$d->jumlah}";
                        })->implode(', ');
                        $lebih = max($o->orderDetails->count() - 3, 0);
                    @endphp

                    <tr>
                        <td class="text-monospace">{{ $o->order_code }}</td>
                        <td>{{ \Carbon\Carbon::parse($o->order_date)->format('d M Y') }}</td>
                        <td>
                            {{ $items ?: '—' }}
                            @if($lebih > 0)
                                <span class="text-muted">+{{ $lebih }} item</span>
                            @endif
                        </td>
                        <td>Rp {{ number_format($o->totalharga, 0, ',', '.') }}</td>
                        <td><span class="badge badge-{{ $payBadge }}">{{ ucfirst(str_replace('_',' ',$o->payment_status)) }}</span></td>
                        <td><span class="badge badge-{{ $shipBadge }}">{{ ucfirst($o->shipping_status) }}</span></td>
                        <td class="text-right">
                            <button class="btn btn-sm btn-primary" data-bs-toggle="collapse" data-bs-target="#detail-{{ $o->id }}">
                                Detail Pesanan
                            </button>
                        </td>
                    </tr>

                    {{-- Row collapsible: rincian item --}}
                    <tr class="collapse bg-light" id="detail-{{ $o->id }}">
                        <td colspan="7">
                            <div class="p-3">
                                <div class="table-responsive">
                                    <table class="table table-sm mb-0">
                                        <thead>
                                            <tr>
                                                <th>Produk</th>
                                                <th style="width:120px;">Jumlah</th>
                                                <th style="width:160px;">Harga</th>
                                                <th style="width:180px;">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($o->orderDetails as $d)
                                            <tr>
                                                <td>{{ $d->produk->nama ?? 'Produk' }}</td>
                                                <td>{{ $d->jumlah }}</td>
                                                <td>Rp {{ number_format($d->harga, 0, ',', '.') }}</td>
                                                <td>Rp {{ number_format($d->harga * $d->jumlah, 0, ',', '.') }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="d-flex justify-content-end mt-2">
                                    <div class="text-right">
                                        <div><small class="text-muted">Metode Pengiriman:</small> <strong>{{ strtoupper($o->shipping_method) }}</strong></div>
                                        <div class="h6 mb-0">Total: Rp {{ number_format($o->totalharga, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-3">
            {{ $orders->links() }}
        </div>
    @endif
</div>

@endsection
