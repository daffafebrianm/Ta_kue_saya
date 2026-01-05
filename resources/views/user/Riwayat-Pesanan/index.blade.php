@extends('user.layouts.main')

@section('content')

<div class="container my-4">
    <h3 class="text-center mb-4 py-2" style="color: #0d6efd;">Daftar Pesanan Saya</h3>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($orders->isEmpty())
        <div class="alert alert-info text-center">Belum ada pesanan.</div>
    @else
        <div class="table-responsive shadow-sm rounded">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
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

                        $items = $o->orderDetails->take(3);
                        $lebih = max($o->orderDetails->count() - 3, 0);
                    @endphp

                    <tr class="align-middle">
                        <td class="text-monospace fw-bold">{{ $o->order_code }}</td>
                        <td>{{ \Carbon\Carbon::parse($o->order_date)->format('d M Y') }}</td>
                        <td>
                            @foreach($items as $d)
                                <div class="d-flex align-items-center mb-1">
                                    @if($d->produk->gambar)
                                        <img src="{{ asset('storage/'.$d->produk->gambar) }}" alt="{{ $d->produk->nama }}" style="width:50px; height:50px; object-fit:cover; border-radius:4px; margin-right:8px;">
                                    @else
                                        <div style="width:50px; height:50px; background:#e9ecef; display:inline-block; border-radius:4px; margin-right:8px;"></div>
                                    @endif
                                    <span>{{ $d->produk->nama ?? 'Produk' }} × {{ $d->jumlah }}</span>
                                </div>
                            @endforeach
                            @if($lebih > 0)
                                <small class="text-muted">+{{ $lebih }} item</small>
                            @endif
                        </td>
                        <td class="fw-semibold">Rp {{ number_format($o->totalharga, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge bg-{{ $payBadge }}">
                                {{ ucfirst(str_replace('_',' ',$o->payment_status)) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-{{ $shipBadge }}">
                                {{ ucfirst($o->shipping_status) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#detail-{{ $o->id }}">
                                Detail
                            </button>
                        </td>
                    </tr>

                    {{-- Row collapsible: rincian item --}}
                    <tr class="collapse bg-light" id="detail-{{ $o->id }}">
                        <td colspan="7">
                            <div class="p-3">
                                <div class="table-responsive">
                                    <table class="table table-sm mb-2">
                                        <thead class="table-secondary">
                                            <tr>
                                                <th>Produk</th>
                                                <th style="width:70px;">Gambar</th>
                                                <th style="width:120px;">Jumlah</th>
                                                <th style="width:160px;">Harga</th>
                                                <th style="width:180px;">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($o->orderDetails as $d)
                                            <tr>
                                                <td>{{ $d->produk->nama ?? 'Produk' }}</td>
                                                <td>
                                                    @if($d->produk->gambar)
                                                        <img src="{{ asset('storage/'.$d->produk->gambar) }}" alt="{{ $d->produk->nama }}" style="width:50px; height:50px; object-fit:cover; border-radius:4px;">
                                                    @else
                                                        <div style="width:50px; height:50px; background:#e9ecef; border-radius:4px;"></div>
                                                    @endif
                                                </td>
                                                <td>{{ $d->jumlah }}</td>
                                                <td>Rp {{ number_format($d->harga, 0, ',', '.') }}</td>
                                                <td>Rp {{ number_format($d->harga * $d->jumlah, 0, ',', '.') }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="d-flex justify-content-between mt-2">
                                    <div>
                                        <small class="text-muted">Metode Pengiriman:</small>
                                        <strong>{{ strtoupper($o->shipping_method) }}</strong>
                                    </div>
                                    <div class="fw-semibold">
                                        Total: Rp {{ number_format($o->totalharga, 0, ',', '.') }}
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
        <div class="mt-3 d-flex justify-content-center">
            {{ $orders->links() }}
        </div>
    @endif
</div>

@endsection
