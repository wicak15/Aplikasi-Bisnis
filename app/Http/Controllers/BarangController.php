<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class BarangController extends Controller
{
    
    public function index()
    {
        $items = Barang::all();

        return view('barang.index', ['items' => $items]);
    }

    public function create()
    {
        return view('barang.form', [
            'item' => new Barang(),
            'action' => route('barang.store'),
        ]);
    }

    public function store(Request $request)
{
    Barang::create([
        'nama' => $request->input('nama'),
        'barcode' => $request->input('barcode'),
        'satuan' => $request->input('satuan'),
        'version' => 1, // ⬅ isi langsung
    ]);

    return redirect(route('barang.index'));
}

    public function show(string $id)
    {
        $item = Barang::findOrFail($id);

        return view('barang.show', ['item' => $item]);
    }

    
    public function edit(string $id)
    {
        $item = Barang::findOrFail($id);

        return view('barang.form', [
            'item' => $item,
            'action' => route('barang.update', $item->id)
        ]);
    }

    public function update(Request $request, string $id)
{
    $barang = Barang::findOrFail($id);

    $barang->update([
        'nama' => $request->input('nama'),
        'barcode' => $request->input('barcode'),
        'satuan' => $request->input('satuan'),
        'version' => $barang->version + 1, 
    ]);

    return redirect(route('barang.index'));
}


    public function destroy(string $id)
    {
        //
    }
}