<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelloController extends Controller
{
    public function hello() {
        return view('hello');
    }

    public function helloNama($nama) {
        return view('hello-nama', ['nama' => $nama]);
    }
}