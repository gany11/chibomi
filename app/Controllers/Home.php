<?php

namespace App\Controllers;

class Home extends BaseController
{
    // Beranda
    public function indexBeranda()
    {
        return view('home');
    }

    // Beranda
    public function indexKontak()
    {
        return view('kontak');
    }
}
