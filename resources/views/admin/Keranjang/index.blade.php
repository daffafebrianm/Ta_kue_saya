@extends('admin.layouts.main')
@section('content')

<div class="container">
    <h1 class="mb-4">Daftar Keranjang</h1>

    <!-- Tombol Tambah Keranjang -->
    <a href="{{ route('admin.keranjang.create') }}" class="btn mb-3" style="background-color: #4CAF50; color: white;">
        <i class="bi bi-plus-circle-fill"></i> Tambah Keranjang
    </a>

    <!-- Tabel Keranjang -->
    <table class="table table-bordered table-hover text-center align-middle">
        <thead>
            <tr>
                <th>No</th>
                <th>User</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($keranjangs as $keranjang)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $keranjang->user->nama ?? '-' }}</td>
                    <td>{{ $keranjang->produk->nama ?? '-' }}</td>
                    <td>{{ $keranjang->jumlah }}</td>
                    <td>
                        <form action="{{ route('admin.keranjang.destroy', $keranjang->id) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Yakin akan menghapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="bi bi-trash-fill"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">Belum ada keranjang.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-3">
        {{ $keranjangs->links() }}
    </div>
</div>
@endsection
