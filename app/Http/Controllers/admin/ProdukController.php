<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\File;

class ProdukController extends Controller
{
    public function index()
    {
        $produks = Produk::with('kategori')->paginate(10);

        return view('admin.product.index', compact('produks'));
    }

    /**
     * Tampilkan form tambah produk baru.
     */
    public function create()
    {
        $kategoris = Kategori::all();

        return view('admin.product.create', compact('kategoris'));
    }

    /**
     * Simpan data produk baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_kategori' => 'required|integer|exists:kategoris,id',
            'nama' => 'required|string|max:150',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'gambar' => ['nullable', File::image()->types(['jpg','jpeg','png','webp'])->max('2mb')],
            'berat' => 'required|numeric|min:0',
            'status' => 'required|in:aktif,nonaktif',
        ], [
            'id_kategori.required' => 'Kategori wajib dipilih.',
            'id_kategori.integer' => 'Kategori harus berupa angka.',
            'id_kategori.exists' => 'Kategori tidak ditemukan di database.',

            'nama.required' => 'Nama produk wajib diisi.',
            'nama.string' => 'Nama produk harus berupa teks.',
            'nama.max' => 'Nama produk tidak boleh lebih dari 150 karakter.',

            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'deskripsi.string' => 'Deskripsi harus berupa teks.',

            'harga.required' => 'Harga wajib diisi.',
            'harga.numeric' => 'Harga harus berupa angka.',
            'harga.min' => 'Harga tidak boleh kurang dari 0.',

            'stok.required' => 'Stok wajib diisi.',
            'stok.integer' => 'Stok harus berupa angka.',
            'stok.min' => 'Stok minimal 0.',

            'gambar.image' => 'File yang diunggah harus berupa gambar.',
            'gambar.mimes' => 'Gambar harus berformat jpg, jpeg, atau png.',
            'gambar.max' => 'Ukuran gambar maksimal 2MB.',

            'berat.required' => 'Berat wajib diisi.',
            'berat.numeric' => 'Berat harus berupa angka.',
            'berat.min' => 'Berat tidak boleh kurang dari 0.',

            'status.required' => 'Status wajib diisi.',
            'status.in' => 'Status hanya boleh diisi dengan "aktif" atau "nonaktif".',
        ]);

        // Handle upload gambar (jika ada)
        if ($request->hasFile('gambar')) {
            // simpan ke storage/app/public/produk
            $path = $request->file('gambar')->store('produk', 'public');
            $validatedData['gambar'] = $path; // simpan path relatif: 'produk/namafile.jpg'
        }

        Produk::create($validatedData);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit produk.
     */
    public function edit(string $id)
    {
        $produk = Produk::findOrFail($id);
        $kategoris = Kategori::all();

        return view('admin.product.edit', compact('produk', 'kategoris'));
    }

    /**
     * Update data produk di database.
     */
    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $validatedData = $request->validate([
            'id_kategori' => 'required|integer|exists:kategoris,id',
            'nama' => 'required|string|max:150',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'berat' => 'required|numeric|min:0',
            'status' => 'required|in:aktif,nonaktif',
        ], [
            'id_kategori.required' => 'Kategori wajib dipilih.',
            'id_kategori.integer' => 'Kategori harus berupa angka.',
            'id_kategori.exists' => 'Kategori tidak ditemukan di database.',

            'nama.required' => 'Nama produk wajib diisi.',
            'nama.string' => 'Nama produk harus berupa teks.',
            'nama.max' => 'Nama produk tidak boleh lebih dari 150 karakter.',

            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'deskripsi.string' => 'Deskripsi harus berupa teks.',

            'harga.required' => 'Harga wajib diisi.',
            'harga.numeric' => 'Harga harus berupa angka.',
            'harga.min' => 'Harga tidak boleh kurang dari 0.',

            'stok.required' => 'Stok wajib diisi.',
            'stok.integer' => 'Stok harus berupa angka.',
            'stok.min' => 'Stok minimal 0.',

            'gambar.image' => 'File yang diunggah harus berupa gambar.',
            'gambar.mimes' => 'Gambar harus berformat jpg, jpeg, atau png.',
            'gambar.max' => 'Ukuran gambar maksimal 2MB.',

            'berat.required' => 'Berat wajib diisi.',
            'berat.numeric' => 'Berat harus berupa angka.',
            'berat.min' => 'Berat tidak boleh kurang dari 0.',

            'status.required' => 'Status wajib diisi.',
            'status.in' => 'Status hanya boleh diisi dengan "aktif" atau "nonaktif".',
        ]);

        $produk->update($validatedData);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui.');
    }

        public function show()
    {
      //
    }

    /**
     * Hapus produk dari database.
     */
    public function destroy(string $id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
    }
}
