@extends('admin.layouts.main')
@section('content')

<div class="container">
    <h1 class="mb-4">Daftar Barang Masuk</h1>

    <!-- Tombol Tambah Barang Masuk -->
    <a href="{{ route('admin.kategori.create') }}" class="btn mb-3" style="background-color: #4CAF50; color: white;">
        <i class="bi bi-plus-circle-fill"></i> Tambah Data Barang Masuk
    </a>


    <!-- Tabel Produk -->
    <table class="table table-bordered table-hover text-center align-middle">
        <thead style="background-color:">
            <tr>
                <th>No</th>
                <th>Nama Bahan Baku</th>
                <th>Slug</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($kategoris as $dataKategori)
                <tr>
                    <!-- Nomor Urut -->
                    <td>{{ $loop->iteration }}</td>

                    <!-- Kode dan Nama Produk -->
                    <td>{{ $dataKategori->nama }}</td>
                    <td>{{ $dataKategori->slug }}</td>
                    <td>{{ $dataKategori->deskripsi }}</td>
                    <!-- Aksi -->
                    <td>
                        <a href="{{ route('admin.kategori.edit', $dataKategori->id) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-fill"></i> Edit
                        </a>
                    <form action="{{ route('admin.kategori.destroy', $dataKategori->id) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Yakin akan menghapus data?')">
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
                    <td colspan="9" class="text-center text-muted">Belum ada kategori.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-3">
        {{ $kategoris->links() }}
    </div>
</div>
@endsection
