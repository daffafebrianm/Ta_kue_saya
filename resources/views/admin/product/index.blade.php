@extends('admin.layouts.main')
@section('content')

<div class="container">
    <h1 class="mb-4">Daftar Order</h1>

    <!-- Tombol Tambah Order -->
    <a href="{{ route('admin.orders.create') }}" class="btn mb-3" style="background-color: #4CAF50; color: white;">
        <i class="bi bi-plus-circle-fill"></i> Tambah Order
    </a>

    <!-- Tabel Order -->
    <table class="table table-bordered table-hover text-center align-middle">
        <thead style="background-color: #f2f2f2;">
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
                    <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($order->payment_status) }}</td>
                    <td>{{ ucfirst($order->shipping_status) }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-eye-fill"></i> Lihat
                        </a>
                        <!-- Bisa ditambahkan Edit/Hapus jika perlu -->
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">Belum ada order.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-3">
        {{ $orders->links() }}
    </div>
</div>
@endsection
