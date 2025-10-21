<?php

namespace App\Http\Controllers\admin;

use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::paginate(10);
        return view('admin.Kategori.index', compact('kategoris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.Kategori.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama'      => 'required|string|max:100',
            'slug'      => 'required|string|max:100|unique:kategoris,slug',
            'deskripsi' => 'required|string',
        ], [
            'nama.required'      => 'Nama wajib diisi.',
            'nama.string'        => 'Nama harus berupa teks.',
            'nama.max'           => 'Nama maksimal 100 karakter.',
            'slug.required'      => 'Slug wajib diisi.',
            'slug.string'        => 'Slug harus berupa teks.',
            'slug.max'           => 'Slug maksimal 100 karakter.',
            'slug.unique'        => 'Slug sudah digunakan, gunakan nama lain.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'deskripsi.string'   => 'Deskripsi harus berupa teks.',
        ]);

        Kategori::create($validatedData);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Kosong karena tidak digunakan
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('admin.Kategori.edit', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $validatedData = $request->validate([
            'nama'      => 'required|string|max:100',
            'slug'      => 'required|string|max:100|unique:kategoris,slug,' . $kategori->id,
            'deskripsi' => 'required|string',
        ]);

        $kategori->update($validatedData);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus');
    }
}
