<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Market;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MarketController extends Controller
{
    public function index()
    {
        $markets = Market::orderBy('jenis')->orderBy('nama')->get();

        return view('admin.markets.index', compact('markets'));
    }

    public function create()
    {
        return view('admin.markets.form', ['market' => new Market]);
    }

    public function store(Request $request)
    {
        Market::create($this->data($request));

        return redirect()->route('admin.markets.index')->with('ok', 'Pasar berhasil ditambahkan.');
    }

    public function edit(Market $market)
    {
        return view('admin.markets.form', compact('market'));
    }

    public function update(Request $request, Market $market)
    {
        $market->update($this->data($request, $market));

        return redirect()->route('admin.markets.index')->with('ok', 'Pasar berhasil diperbarui.');
    }

    // Tidak menghapus, hanya menonaktifkan agar data harga tetap utuh.
    public function destroy(Market $market)
    {
        $market->update(['aktif' => false]);

        return redirect()->route('admin.markets.index')->with('ok', 'Pasar dinonaktifkan.');
    }

    private function data(Request $request, ?Market $market = null): array
    {
        $data = $request->validate([
            'nama'   => ['required', 'max:100', Rule::unique('markets', 'nama')->ignore($market?->id)],
            'jenis'  => ['required', 'in:produsen,konsumen'],
            'lokasi' => ['nullable', 'max:150'],
        ]);

        $data['aktif'] = $request->boolean('aktif');

        return $data;
    }
}