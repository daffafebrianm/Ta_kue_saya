@extends('admin.layouts.main')
@section('content')

<div class="container">
    <h1 class="mb-4">Daftar Kategori</h1>

    <!-- Tombol Tambah Kategori -->
    <a href="{{ route('kategori.create') }}" class="btn mb-3" style="background-color: #4CAF50; color: white;">
        <i class="bi bi-plus-circle-fill"></i> Tambah Kategori
    </a>

    <!-- Tabel Kategori -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center align-middle">
            <thead style="background-color: #f2f2f2;">
                <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kategoris as $kategori)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $kategori->nama }}</td>
                        <td>
                            <a href="{{ route('kategori.edit', $kategori->id) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil-fill"></i> Edit
                            </a>
                            <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" class="d-inline"
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
                        <td colspan="5" class="text-center text-muted">Belum ada kategori.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-3">
        {{ $kategoris->links() }}
    </div>
</div>
@endsection
