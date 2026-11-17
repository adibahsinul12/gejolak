<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JenisController extends Controller
{
    public function set(Request $request)
    {
        $request->validate(['jenis' => ['required', 'in:produsen,konsumen']]);
        session(['jenis' => $request->jenis]);

        return back();
    }
}