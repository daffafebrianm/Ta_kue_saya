@extends('user.layouts.main')

@section('content')
<div class="container my-5">
    <h3 class="text-center mb-5">Checkout</h3>

    <form action="{{ route('Checkout.store') }}" method="POST">
        @csrf

        <!-- Section untuk Nama dan Nomor Telepon -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nama" class="h5 form-label">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Nama lengkap" required value="{{ old('nama', Auth::user()->nama) }}">
                    @error('nama')
                    <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="phone_number" class="h5 form-label">Nomor Telepon</label>
                    <input type="text" id="phone_number" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror" placeholder="Nomor telepon" required value="{{ old('phone_number', Auth::user()->phone_number) }}">
                    @error('phone_number')
                    <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Section untuk Alamat Pengiriman -->
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="form-group">
                    <label for="alamat" class="h5 form-label">Alamat Pengiriman</label>
                    <textarea id="alamat" name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="4" placeholder="Alamat pengiriman..." required>{{ old('alamat') }}</textarea>
                    @error('alamat')
                    <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Daftar Produk di Keranjang -->
        <h5 class="mt-4">Daftar Produk di Keranjang</h5>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($keranjangs as $keranjang)
                <tr>
                    <td>{{ $keranjang->produk->nama }}</td>
                    <td>{{ $keranjang->jumlah }}</td>
                    <td>Rp. {{ number_format($keranjang->produk->harga, 0, ',', '.') }}</td>
                    <td>Rp. {{ number_format($keranjang->produk->harga * $keranjang->jumlah, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-right">
            <h5>Total: Rp. {{ number_format($subtotal, 0, ',', '.') }}</h5>
        </div>

        <!-- Section untuk Metode Pengiriman -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="shipping_method" class="h5 form-label">Metode Pengiriman</label>
                    <select id="shipping_method" name="shipping_method" class="form-control @error('shipping_method') is-invalid @enderror" required>
                        <option value="picked up">Diambil</option>
                        <option value="delivered">Dikirim</option>
                    </select>
                    @error('shipping_method')
                    <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Section untuk Catatan -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="note" class="h5 form-label">Catatan</label>
                    <textarea id="note" name="note" class="form-control @error('note') is-invalid @enderror" rows="3" placeholder="Catatan tambahan (opsional)">{{ old('note') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Tombol untuk Proses Pembayaran -->
        <div class="text-right mt-4">
            <button type="submit" class="btn btn-lg btn-success px-5 mt-4">Proses Pembayaran</button>
        </div>
    </form>
</div>
@endsection
