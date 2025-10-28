@extends('user.layouts.main')

@section('content')
<div class="container my-4">
    <div class="row">
        <div class="col-md-12 mb-3">
            <a href="{{ url('/') }}" class="btn btn-outline-primary btn-sm rounded-pill"><i class="fa fa-arrow-left"></i> Kembali</a>
        </div>


        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light p-3 rounded-4">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Keranjang</li>
                </ol>
            </nav>
        </div>

        <div class="col-md-12">
            <div class="card shadow-lg border-0 rounded-4 mb-4">
                <div class="card-body p-5">
                    <h3 class="fw-bold"><i class="fa fa-shopping-cart"></i> Keranjang</h3>

                    @if($keranjangs->count() > 0)
                    <!-- Menampilkan tanggal pemesanan -->


                    <div class="table-responsive">
                        <!-- Tabel yang menampilkan produk dalam keranjang -->
                        <table class="table table-striped table-bordered mt-3">
                            <thead class="text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Gambar</th>
                                    <th>Nama Produk</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                    <th>Total Harga</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach($keranjangs as $keranjang)
                                <tr>
                                    <td class="text-center">{{ $no++ }}</td>
                                    <!-- Menampilkan gambar produk -->
                                    <td class="text-center">
                                        <img src="{{ $keranjang->produk->gambar_produk ? Storage::url($keranjang->produk->gambar_produk) : asset('default-image.jpg') }}" width="100" alt="Gambar Produk">
                                    </td>
                                    <!-- Menampilkan nama produk -->
                                    <td class="text-center">{{ $keranjang->produk->nama_produk }}</td>
                                    <td>
                                        <!-- Form untuk mengupdate jumlah produk -->
                                        <form action="{{ route('keranjang.update', $keranjang->id) }}" method="post" class="d-flex align-items-center justify-content-center" id="form-keranjang-{{ $keranjang->id }}">
                                            @csrf
                                            @method('PATCH')

                                            <!-- Tombol untuk mengurangi jumlah -->
                                            <button type="button" class="btn btn-sm btn-outline-secondary" id="btn-minus-{{ $keranjang->id }}" @if($keranjang->jumlah <= 1) disabled @endif>-</button>

                                            <!-- Input untuk jumlah produk -->
                                            <input type="number" name="jumlah" id="jumlah-{{ $keranjang->id }}" value="{{ $keranjang->jumlah }}" class="form-control mx-2 text-center" style="width: 70px;" min="1" max="{{ $keranjang->produk->stok }}" readonly>

                                            <!-- Tombol untuk menambah jumlah -->
                                            <button type="button" class="btn btn-sm btn-outline-secondary" id="btn-plus-{{ $keranjang->id }}" @if($keranjang->jumlah >= $keranjang->produk->stok) disabled @endif>+</button>
                                        </form>
                                    </td>

                                    <script>
                                        // Menambahkan event listener pada tombol minus dan plus
                                        document.getElementById('btn-minus-{{ $keranjang->id }}').addEventListener('click', function() {
                                            var jumlahInput = document.getElementById('jumlah-{{ $keranjang->id }}');
                                            var jumlah = parseInt(jumlahInput.value);

                                            if (jumlah > 1) {
                                                jumlahInput.value = jumlah - 1; // Kurangi jumlah
                                                // Mengirimkan form dengan jumlah yang baru
                                                document.getElementById('form-keranjang-{{ $keranjang->id }}').submit();
                                            }
                                        });

                                        document.getElementById('btn-plus-{{ $keranjang->id }}').addEventListener('click', function() {
                                            var jumlahInput = document.getElementById('jumlah-{{ $keranjang->id }}');
                                            var jumlah = parseInt(jumlahInput.value);

                                            if (jumlah < {{ $keranjang->produk->stok }}) {
                                                jumlahInput.value = jumlah + 1; // Tambah jumlah
                                                // Mengirimkan form dengan jumlah yang baru
                                                document.getElementById('form-keranjang-{{ $keranjang->id }}').submit();
                                            }
                                        });
                                    </script>

                                    <!-- Menampilkan harga produk per unit -->
                                    <td class="text-center">Rp. {{ number_format($keranjang->produk->harga, 0, ',', '.') }}</td>
                                    <!-- Menampilkan total harga berdasarkan jumlah produk -->
                                    <td class="text-center">Rp. {{ number_format(($keranjang->produk->harga ?? 0) * ($keranjang->jumlah ?? 0), 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        <!-- Form untuk menghapus produk dari keranjang -->
                                        <form action="{{ route('keranjang.destroy', $keranjang->id) }}" method="post" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm delete-btn">
                                                <i class="fa fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                                {{--  <!-- Menampilkan total harga semua produk dalam keranjang -->
                                <tr>
                                    <td colspan="5" class="text-end"><strong>Total Harga :</strong></td>
                                    <td class="text-center"><strong>Rp. {{ number_format($total, 0, ',', '.') }}</strong></td>
                                    <td class="text-center">
                                        <a href="{{ route('order.index') }}" class="btn btn-success">
                                            <i class="fa fa-check"></i> Checkout
                                        </a>
                                    </td>
                                </tr>  --}}
                            </tbody>
                        </table>
                    </div>
                    @else
                    <!-- Menampilkan pesan jika keranjang kosong -->
                    <p class="text-center">Tidak ada Produk didalam keranjang  Silakan tambahkan produk ke keranjang terlebih dahulu.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

