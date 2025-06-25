<?php

    use App\Http\Controllers\barangController;
    use App\Http\Controllers\HelloController;
    use App\Http\Controllers\GudangController;
    use Illuminate\Support\Facades\Route;

    Route::controller(BarangController::class)
        ->name('barang.')
        ->prefix('/barang')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{id}/edit', 'edit')->name('edit');
            Route::post('/{id}', 'update')->name('update');
            Route::get('/{id}/destroy', 'destroy')->name('destroy');
            Route::get('/{id}', 'show')->name('show');
        });


    Route::controller(GudangController::class)
        ->name('gudang.')
        ->prefix('/gudang')
        ->group(function () {
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/', 'index')->name('index');
        });

    route::get('/hello/{nama}', function ($nama) {
        return view('hello-nama', ['nama' => $nama]);
    });

    Route::controller(HelloController::class)
        ->name('hello.')
        ->group(function () {
        Route::get('/hello-vip/{nama}', 'helloVIP');   
        Route::get('/hello/{nama}','helloNama');
        Route::get('/hello','hello');
    });

    Route::get('/hello', function () {
        return view('hello');
    });

    Route::get('/', function () {
        return view('welcome');
    });