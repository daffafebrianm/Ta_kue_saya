@extends('admin.layouts.main')
@section('content')

<div class="container">
    <h3>Order {{ $order->order_code }}</h3>
    <p>User: {{ $order->user->nama ?? '-' }}</p>
    <p>Total: Rp {{ number_format($order->total,0,',','.') }}</p>

    <table class="table table-bordered table-hover text-center">
        <thead>
            <tr>
                <th>No</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderDetails as $index => $detail)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $detail->produk->nama ?? '-' }}</td>
                <td>{{ $detail->jumlah }}</td>
                <td>Rp {{ number_format($detail->harga,0,',','.') }}</td>
                <td>Rp {{ number_format($detail->total,0,',','.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
