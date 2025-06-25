@extends('layouts.app')



@section('content')

    <h1>Tambah Stok Gudang</h1>

    @include('gudang.form', ['item' => $item, 'action' => $action])

@endsection