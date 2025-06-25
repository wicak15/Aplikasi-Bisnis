<!-- resources/views/gudang/index.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Data Gudang</h1>
    <a href="{{ route('gudang.create') }}">Tambah Stok</a>
    <table border="1">
        <tr>
            <th>Barcode</th>
            <th>Nama</th>
            <th>Satuan</th>
            <th>Jumlah Stok</th>
            <th>Aksi</th>
        </tr>
        @foreach ($gudangs as $gudang)
<tr>
    <td>{{ $gudang->barcode }}</td>
    <td>{{ $gudang->nama }}</td>
    <td>{{ $gudang->jumlah_stok }}</td>
    <td>{{ $gudang->satuan }}</td>
    <td>
        <a href="{{ route('gudang.edit', $gudang->id) }}">Edit</a>
        <form action="{{ route('gudang.destroy', $gudang->id) }}" method="POST" style="display:inline">
            @csrf
            @method('DELETE')
            <button type="submit">Delete</button>
        </form>
    </td>
</tr>
@endforeach

    </table>
@endsection