@extends('admin.layouts.main')

@section('content')
<div class="container mt-5">
    <h3 class="mb-4 fw-semibold text-primary">Edit Barang Masuk</h3>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('barang-masuk.update', $barangMasuk->id) }}" method="POST" id="form-barang-masuk">
                @csrf
                @method('PUT')

                {{-- Produk --}}
                <div class="mb-3">
                    <label for="id_produk" class="form-label fw-semibold" style="font-size: 14px;">Produk</label>
                    <select name="id_produk" id="id_produk" class="form-select" required>
                        <option value="" disabled>-- Pilih Produk --</option>
                        @foreach ($produks as $produk)
                            <option value="{{ $produk->id }}"
                                {{ old('id_produk', $barangMasuk->id_produk) == $produk->id ? 'selected' : '' }}>
                                {{ $produk->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Jumlah Barang --}}
                <div class="mb-3">
                    <label for="jumlah" class="form-label fw-semibold" style="font-size: 14px;">Jumlah Barang</label>
                    <input type="number" name="jumlah" id="jumlah" class="form-control"
                        value="{{ old('jumlah', $barangMasuk->jumlah) }}" required>
                </div>

                {{-- Harga Modal --}}
                <div class="mb-3">
                    <label for="harga_modal" class="form-label fw-semibold" style="font-size: 14px;">Harga Modal (Rp)</label>
                    <input type="number" name="harga_modal" id="harga_modal" class="form-control"
                        value="{{ old('harga_modal', $barangMasuk->harga_modal) }}" required>
                </div>

                {{-- Harga Jual --}}
                <div class="mb-3">
                    <label for="harga_jual" class="form-label fw-semibold" style="font-size: 14px;">Harga Jual (Rp)</label>
                    <input type="number" name="harga_jual" id="harga_jual" class="form-control"
                        value="{{ old('harga_jual', $barangMasuk->harga_jual) }}" required>
                </div>

                {{-- Tanggal Masuk --}}
                <div class="mb-3">
                    <label for="tanggal_masuk" class="form-label fw-semibold" style="font-size: 14px;">Tanggal Masuk</label>
                    <input type="date" name="tanggal_masuk" id="tanggal_masuk" class="form-control"
                        value="{{ old('tanggal_masuk', $barangMasuk->tanggal_masuk) }}" required>
                </div>

                {{-- Keterangan --}}
                <div class="mb-4">
                    <label for="keterangan" class="form-label fw-semibold" style="font-size: 14px;">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" class="form-control" rows="3"
                        placeholder="Masukkan keterangan (opsional)">{{ old('keterangan', $barangMasuk->keterangan) }}</textarea>
                </div>

                {{-- Tombol --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('barang-masuk.index') }}" class="btn btn-secondary px-4">
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

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {

    // ✅ Notifikasi sukses
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 1800
        });
    @endif

    // ⚠️ Notifikasi gagal
    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            confirmButtonColor: '#d33'
        });
    @endif

    // ⚠️ Validasi error
    @if ($errors->any())
        Swal.fire({
            icon: 'warning',
            title: 'Periksa Kembali!',
            html: `{!! implode('<br>', $errors->all()) !!}`,
            confirmButtonColor: '#ffc107'
        });
    @endif

    // ⚙️ Konfirmasi sebelum submit
    const form = document.getElementById('form-barang-masuk');
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
