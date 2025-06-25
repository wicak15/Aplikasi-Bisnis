<form method="POST" action="{{ $action }}">
    @csrf
    @if($item && $item->exists)
        @method('PUT')
    @endif

    <label>barcode:</label>
    <input type="text" name="barcode" value="{{ old('barcode', $item->barcode ?? '') }}" required><br>

    <label>nama:</label>
    <input type="text" name="nama" value="{{ old('nama', $item->nama ?? '') }}" required><br>

    <label>satuan:</label>
    <input type="text" name="satuan" value="{{ old('satuan', $item->satuan ?? '') }}" required><br>

    <label>jumlah Stok:</label>
    <input type="number" name="jumlah_stok" value="{{ old('jumlah_stok', $item->jumlah_stok ?? '') }}" required><br>
    <br>

    <button type="submit">Simpan</button>
</form>