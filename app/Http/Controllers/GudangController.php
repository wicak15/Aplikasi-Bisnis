<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gudang;

class GudangController extends Controller
{
    // Tampilkan daftar stok gudang
    public function index()
    {
        $items = Gudang::all();  
        return view('gudang.index', compact('items'));
    }

    // Tampilkan form input stok baru
    public function create()
    {
        $item = new Gudang();  
        $action = route('gudang.store');

        return view('gudang.create', compact('item', 'action'));  
    }

    // Simpan stok baru ke database
    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'nama' => 'required',
            'barcode' => 'required',
            'satuan' => 'required',
            'jumlah_stok' => 'required|integer',
        ]);

        // Simpan data
        Gudang::create($request->only('nama', 'barcode', 'satuan', 'jumlah_stok'));

        return redirect(route('gudang.index'))->with('success', 'Data gudang berhasil disimpan!');
    }
}
