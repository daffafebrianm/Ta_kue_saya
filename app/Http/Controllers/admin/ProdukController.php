<?php

namespace App\Http\Controllers\admin;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produks = Produk::with('kategori')->paginate(10);
        return view('admin.product.index', compact('produks'));
    }

    /**
     * Show the form for creating a new resource.
     */


    /**
     * Store a newly created resource in storage.
     */
    public function create()
{
    $kategoris = Kategori::all();
    return view('admin.product.create', compact('kategoris'));
}

    public function store(Request $request)
    {
        $validateData= $request->validate([
        'id_kategori' => 'required|integer|exists:kategoris,id',
        'nama'        => 'required|string|max:150',
        'deskripsi'   => 'required|string',
        'harga'       => 'required|numeric|min:0',
        'stok'        => 'required|integer|min:0',
        'gambar'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'berat'       => 'required|numeric|min:0',
        'status'      => 'required|in:aktif,nonaktif',
        ],
        [
            'id_kategori.required' => 'Kategori wajib dipilih.',
            'id_kategori.integer'  => 'Kategori harus berupa angka.',
            'id_kategori.exists'   => 'Kategori tidak ditemukan dalam database.',

            'nama.required' => 'Nama produk wajib diisi.',
            'nama.string'   => 'Nama produk harus berupa teks.',
            'nama.max'      => 'Nama produk tidak boleh lebih dari 150 karakter.',

            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'deskripsi.string'   => 'Deskripsi harus berupa teks.',

            'harga.required' => 'Harga wajib diisi.',
            'harga.numeric'  => 'Harga harus berupa angka.',
            'harga.min'      => 'Harga tidak boleh kurang dari 0.',

            'stok.required' => 'Stok wajib diisi.',
            'stok.integer'  => 'Stok harus berupa angka.',
            'stok.min'      => 'Stok minimal 0.',

            'gambar.image' => 'File yang diunggah harus berupa gambar.',
            'gambar.mimes' => 'Gambar harus berformat jpg, jpeg, atau png.',
            'gambar.max'   => 'Ukuran gambar maksimal 2MB.',

            'berat.required' => 'Berat wajib diisi.',
            'berat.numeric'  => 'Berat harus berupa angka.',
            'berat.min'      => 'Berat tidak boleh kurang dari 0.',

            'status.required' => 'Status wajib diisi.',
            'status.in'       => 'Status hanya boleh diisi dengan "aktif" atau "nonaktif".',
        ]
        );

        Produk::create($validateData);

        return redirect()->route('admin.produk.index')->with('sucsess','produk berhasil di tambahkan');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id){}


    /**
     * Show the form for editing the specified resource.
     */
public function edit(string $id)
{
    $produk = Produk::findOrFail($id);
    $kategoris = Kategori::all(); // <— ini bagian penting

    return view('admin.product.edit', compact('produk', 'kategoris'));
}



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $produks   =  Produk::findOrFail($id);

        $validatedData = $request->validate([
        'id_kategori' => 'required|integer|exists:kategoris,id',
        'nama'        => 'required|string|max:150',
        'deskripsi'   => 'required|string',
        'harga'       => 'required|numeric|min:0',
        'stok'        => 'required|integer|min:0',
        'gambar'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'berat'       => 'required|numeric|min:0',
        'status'      => 'required|in:aktif,nonaktif',
    ], [
        'id_kategori.required' => 'Kategori wajib dipilih.',
        'id_kategori.integer'  => 'Kategori harus berupa angka.',
        'id_kategori.exists'   => 'Kategori tidak ditemukan di database.',

        'nama.required' => 'Nama produk wajib diisi.',
        'nama.string'   => 'Nama produk harus berupa teks.',
        'nama.max'      => 'Nama produk tidak boleh lebih dari 150 karakter.',

        'deskripsi.required' => 'Deskripsi wajib diisi.',
        'deskripsi.string'   => 'Deskripsi harus berupa teks.',

        'harga.required' => 'Harga wajib diisi.',
        'harga.numeric'  => 'Harga harus berupa angka.',
        'harga.min'      => 'Harga tidak boleh kurang dari 0.',

        'stok.required' => 'Stok wajib diisi.',
        'stok.integer'  => 'Stok harus berupa angka.',
        'stok.min'      => 'Stok minimal 0.',

        'gambar.image' => 'File gambar harus berupa format gambar.',
        'gambar.mimes' => 'Gambar harus berformat jpg, jpeg, atau png.',
        'gambar.max'   => 'Ukuran gambar maksimal 2MB.',

        'berat.required' => 'Berat wajib diisi.',
        'berat.numeric'  => 'Berat harus berupa angka.',
        'berat.min'      => 'Berat tidak boleh kurang dari 0.',

        'status.required' => 'Status wajib diisi.',
        'status.in'       => 'Status hanya boleh "aktif" atau "nonaktif".',
    ]);
    $produks-> update($validatedData);

    return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil diperbarui');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil dihapus');
    }
}
