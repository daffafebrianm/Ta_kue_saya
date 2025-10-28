@extends('admin.layouts.main')
@section('content')

<div class="container">
    <h1 class="mb-4">Daftar Order</h1>

    <table class="table table-bordered table-hover text-center align-middle">
        <thead>
            <tr>
                <th>No</th>
                <th>Order Code</th>
                <th>User</th>
                <th>Total</th>
                <th>Payment Status</th>
                <th>Shipping Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $index => $order)
            <tr>
                <td>{{ $orders->firstItem() + $index }}</td>
                <td>{{ $order->order_code }}</td>
                <td>{{ $order->user->nama ?? '-' }}</td>
                <td>Rp {{ number_format($order->total,0,',','.') }}</td>
                <td>{{ ucfirst($order->payment_status) }}</td>
                <td>{{ ucfirst($order->shipping_status) }}</td>
                <td>
                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary btn-sm">Lihat</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Belum ada order.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center mt-3">
        {{ $orders->links() }}
    </div>
</div>

@endsection
