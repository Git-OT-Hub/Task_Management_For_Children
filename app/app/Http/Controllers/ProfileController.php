<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return view("profiles.index");
    }

    public function edit()
    {
        return view("profiles.edit");
    }

    public function update()
    {

    }
}
