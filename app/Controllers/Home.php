<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('welcome_message');
    }
    public function kntl($name, $umur){
        echo "Nama saya : " . $name . "<br>" . "Umur saya : " . $umur;
    }
}
