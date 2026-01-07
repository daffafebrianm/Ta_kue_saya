<?php

namespace App\Http\Controllers\admin;

use App\Models\Produk;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BarangMasukController extends Controller
{
    /**
     * Tampilkan daftar barang masuk.
     */
    public function index(Request $request)
    {
        $bulan = $request->input('bulan', date('n'));
        $tahun = $request->input('tahun', date('Y'));

        $barangMasuk = BarangMasuk::with('produk')
            ->when($bulan, fn($q) => $q->whereMonth('tanggal_masuk', $bulan))
            ->when($tahun, fn($q) => $q->whereYear('tanggal_masuk', $tahun))
            ->latest()
            ->get();

        return view('admin.Barang-Masuk.index', compact('barangMasuk', 'bulan', 'tahun'));
    }


    /**
     * Tampilkan form tambah barang masuk.
     */
    public function create()
    {
        $produks = Produk::where('status', 'aktif')->get();
        return view('admin.Barang-Masuk.create', compact('produks'));
    }

    /**
     * Simpan data barang masuk.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_produk'     => 'required|exists:produks,id',
            'jumlah'        => 'required|integer|min:1',
            'harga_modal'   => 'required|numeric|min:0',
            'harga_jual'    => 'required|numeric|min:0',
            'tanggal_masuk' => 'required|date',
            'keterangan'    => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request) {
            // 1️⃣ Simpan data barang masuk
            $barangMasuk = BarangMasuk::create([
                'id_produk'     => $request->id_produk,
                'jumlah'        => $request->jumlah,
                'harga_modal'   => $request->harga_modal,
                'harga_jual'    => $request->harga_jual,
                'tanggal_masuk' => $request->tanggal_masuk,
                'keterangan'    => $request->keterangan,
            ]);

            // 2️⃣ Update stok dan harga produk
            $produk = Produk::findOrFail($request->id_produk);
            $produk->stok += $request->jumlah; // tambah stok
            $produk->harga = $request->harga_jual; // update harga jual
            $produk->save();
        });

        return redirect()->route('barang-masuk.index')->with('success', 'Barang masuk berhasil ditambahkan dan stok produk diperbarui.');
    }

    /**
     * Tampilkan form edit barang masuk.
     */
    public function edit(string $id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);
        $produks = Produk::where('status', 'aktif')->get();
        return view('admin.Barang-Masuk.edit', compact('barangMasuk', 'produks'));
    }

    /**
     * Update data barang masuk.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'id_produk'     => 'required|exists:produks,id',
            'jumlah'        => 'required|integer|min:1',
            'harga_modal'   => 'required|numeric|min:0',
            'harga_jual'    => 'required|numeric|min:0',
            'tanggal_masuk' => 'required|date',
            'keterangan'    => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request, $id) {
            $barangMasuk = BarangMasuk::findOrFail($id);

            // Ambil produk lama untuk mengembalikan stok sebelum update
            $produkLama = Produk::findOrFail($barangMasuk->id_produk);
            $produkLama->stok -= $barangMasuk->jumlah; // kembalikan stok lama
            $produkLama->save();

            // Update data barang masuk
            $barangMasuk->update([
                'id_produk'     => $request->id_produk,
                'jumlah'        => $request->jumlah,
                'harga_modal'   => $request->harga_modal,
                'harga_jual'    => $request->harga_jual,
                'tanggal_masuk' => $request->tanggal_masuk,
                'keterangan'    => $request->keterangan,
            ]);

            // Tambahkan stok baru ke produk yang dipilih
            $produkBaru = Produk::findOrFail($request->id_produk);
            $produkBaru->stok += $request->jumlah;
            $produkBaru->harga = $request->harga_jual; // update harga jual
            $produkBaru->save();
        });

        return redirect()->route('barang-masuk.index')->with('success', 'Data barang masuk berhasil diperbarui.');
    }

    /**
     * Hapus data barang masuk.
     */
    public function destroy(string $id)
    {
        DB::transaction(function () use ($id) {
            $barangMasuk = BarangMasuk::findOrFail($id);
            $produk = Produk::findOrFail($barangMasuk->id_produk);

            // Kurangi stok sesuai jumlah barang masuk yang dihapus
            $produk->stok -= $barangMasuk->jumlah;
            if ($produk->stok < 0) $produk->stok = 0;
            $produk->save();

            $barangMasuk->delete();
        });

        return redirect()->route('barang-masuk.index')->with('success', 'Data barang masuk berhasil dihapus dan stok produk diperbarui.');
    }

    public function cetakPDF(Request $request)
    {
        // Ambil filter bulan & tahun dari request
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        $barangMasuk = BarangMasuk::with('produk')
            ->when($bulan, fn($q) => $q->whereMonth('tanggal_masuk', $bulan))
            ->when($tahun, fn($q) => $q->whereYear('tanggal_masuk', $tahun))
            ->latest()
            ->get();

        // Load view PDF dan kirim data ke dalamnya
        $pdf = Pdf::loadView('admin.Barang-Masuk.laporan', compact('barangMasuk', 'bulan', 'tahun'))
            ->setPaper('A4', 'portrait');

        // Menampilkan hasil PDF langsung di browser
        return $pdf->stream('laporan_barang_masuk.pdf');
    }
}
