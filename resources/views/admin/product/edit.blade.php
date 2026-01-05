{{-- resources/views/admin/produk/edit.blade.php --}}
@extends('admin.layouts.main')

@section('content')
<div class="container mt-5">
    <h3 class="mb-4 fw-semibold text-primary">Edit Produk</h3>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data" id="form-produk">
                @csrf
                @method('PUT')

                {{-- Kategori --}}
                <div class="mb-3">
                    <label for="id_kategori" class="form-label fw-semibold" style="font-size: 14px;">Kategori</label>
                    <select name="id_kategori" id="id_kategori" class="form-select" required>
                        <option value="" disabled>-- Pilih Kategori --</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}"
                                {{ old('id_kategori', $produk->id_kategori) == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Nama Produk --}}
                <div class="mb-3">
                    <label for="nama" class="form-label fw-semibold" style="font-size: 14px;">Nama Produk</label>
                    <input type="text" name="nama" id="nama" class="form-control"
                           value="{{ old('nama', $produk->nama) }}" required>
                </div>

                {{-- Harga --}}
                <div class="mb-3">
                    <label for="harga" class="form-label fw-semibold" style="font-size: 14px;">Harga (Rp)</label>
                    <input type="number" name="harga" id="harga" class="form-control"
                           value="{{ old('harga', $produk->harga) }}" required>
                </div>

                {{-- Stok --}}
                <div class="mb-3">
                    <label for="stok" class="form-label fw-semibold" style="font-size: 14px;">Stok</label>
                    <input type="number" name="stok" id="stok" class="form-control"
                           value="{{ old('stok', $produk->stok) }}" required>
                </div>

                {{-- Berat --}}
                <div class="mb-3">
                    <label for="berat" class="form-label fw-semibold" style="font-size: 14px;">Berat (gram)</label>
                    <input type="number" name="berat" id="berat" class="form-control"
                           value="{{ old('berat', $produk->berat) }}" required>
                </div>

                {{-- Status --}}
                <div class="mb-3">
                    <label for="status" class="form-label fw-semibold" style="font-size: 14px;">Status</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="" disabled>-- Pilih Status --</option>
                        <option value="aktif" {{ old('status', $produk->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status', $produk->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>

                {{-- Gambar Produk --}}
                <div class="mb-3">
                    <label for="gambar" class="form-label fw-semibold" style="font-size: 14px;">Gambar Produk</label>
                    @if ($produk->gambar)
                        <div class="mb-2">
                            <img id="image-preview" src="{{ asset('storage/' . $produk->gambar) }}"
                                 class="img-fluid rounded shadow-sm border" style="max-height: 200px;">
                        </div>
                    @else
                        <img id="image-preview" src="#" class="mt-3 img-fluid rounded shadow-sm border"
                             style="display:none; max-height: 200px;">
                    @endif
                    <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*" onchange="previewImage(event)">
                    <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar.</small>
                </div>

                {{-- Deskripsi --}}
                <div class="mb-4">
                    <label for="deskripsi" class="form-label fw-semibold" style="font-size: 14px;">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3" placeholder="Masukkan deskripsi produk">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                </div>

                {{-- Tombol --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('produk.index') }}" class="btn btn-secondary px-4">
                        <i class="bi bi-arrow-left-circle"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-floppy-fill"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Preview Gambar --}}
<script>
function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('image-preview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 1800
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            confirmButtonColor: '#d33'
        });
    @endif

    @if ($errors->any())
        Swal.fire({
            icon: 'warning',
            title: 'Periksa Kembali!',
            html: `{!! implode('<br>', $errors->all()) !!}`,
            confirmButtonColor: '#ffc107'
        });
    @endif

    const form = document.getElementById('form-produk');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Simpan Perubahan?',
            text: "Pastikan semua data sudah benar!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, simpan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
@endsection
