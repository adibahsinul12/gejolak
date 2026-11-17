<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commodity;
use App\Models\CommodityAlias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CommodityController extends Controller
{
    public function index(Request $request)
    {
        $query = Commodity::with('aliases')->orderBy('kelompok')->orderBy('nama');

        if ($request->filled('cari')) {
            $query->where('nama', 'like', '%' . $request->cari . '%');
        }
        if (in_array($request->jenis, ['produsen', 'konsumen'], true)) {
            $query->untukJenis($request->jenis);
        }

        $commodities = $query->get();

        return view('admin.commodities.index', compact('commodities'));
    }

    public function create()
    {
        $commodity = new Commodity([
            'satuan'         => 'kg',
            'untuk_konsumen' => true,
            'aktif'          => true,
        ]);

        return view('admin.commodities.form', compact('commodity'));
    }

    public function store(Request $request)
    {
        $this->save($request);

        return redirect()->route('admin.commodities.index')->with('ok', 'Komoditas berhasil ditambahkan.');
    }

    public function edit(Commodity $commodity)
    {
        $commodity->load('aliases');

        return view('admin.commodities.form', compact('commodity'));
    }

    public function update(Request $request, Commodity $commodity)
    {
        $this->save($request, $commodity);

        return redirect()->route('admin.commodities.index')->with('ok', 'Komoditas berhasil diperbarui.');
    }

    // Tidak menghapus, hanya menonaktifkan agar data harga tetap utuh.
    public function destroy(Commodity $commodity)
    {
        $commodity->update(['aktif' => false]);

        return redirect()->route('admin.commodities.index')->with('ok', 'Komoditas dinonaktifkan.');
    }

    private function save(Request $request, ?Commodity $commodity = null): void
    {
        $data = $request->validate([
            'nama'     => ['required', 'max:100', Rule::unique('commodities', 'nama')->ignore($commodity?->id)],
            'satuan'   => ['required', 'max:20'],
            'kelompok' => ['nullable', 'max:100'],
            'aliases'  => ['nullable', 'max:2000'],
        ]);

        $flags = [
            'untuk_produsen' => $request->boolean('untuk_produsen'),
            'untuk_konsumen' => $request->boolean('untuk_konsumen'),
            'dipantau'       => $request->boolean('dipantau'),
            'aktif'          => $request->boolean('aktif'),
        ];

        if (! $flags['untuk_produsen'] && ! $flags['untuk_konsumen']) {
            throw ValidationException::withMessages([
                'untuk_konsumen' => 'Pilih minimal satu jenis (produsen atau konsumen).',
            ]);
        }

        $aliases = $this->aliasList($request, $data['nama']);
        $this->validateAliases($aliases, $commodity);

        DB::transaction(function () use ($data, $flags, $aliases, &$commodity) {
            $payload = [
                'nama'     => $data['nama'],
                'satuan'   => $data['satuan'],
                'kelompok' => $data['kelompok'] ?? null,
            ] + $flags;

            if ($commodity) {
                $commodity->update($payload);
            } else {
                $commodity = Commodity::create($payload);
            }

            // Buang alias yang dihapus dari daftar, tambah yang baru.
            $commodity->aliases()->whereNotIn('alias', $aliases)->delete();
            foreach ($aliases as $alias) {
                $commodity->aliases()->firstOrCreate(['alias' => $alias]);
            }
        });
    }

    // Satu alias per baris, dirapikan, tanpa duplikat dan tanpa yang sama dengan namanya.
    private function aliasList(Request $request, string $nama): array
    {
        return collect(preg_split('/\r\n|\r|\n/', (string) $request->input('aliases')))
            ->map(fn ($a) => trim($a))
            ->filter()
            ->reject(fn ($a) => strcasecmp($a, $nama) === 0)
            ->unique()
            ->values()
            ->all();
    }

    // Alias tidak boleh dipakai komoditas lain, dan tidak boleh sama dengan nama komoditas lain.
    private function validateAliases(array $aliases, ?Commodity $commodity): void
    {
        foreach ($aliases as $alias) {
            $dipakaiAlias = CommodityAlias::where('alias', $alias)
                ->when($commodity, fn ($q) => $q->where('commodity_id', '!=', $commodity->id))
                ->exists();

            $dipakaiNama = Commodity::where('nama', $alias)
                ->when($commodity, fn ($q) => $q->where('id', '!=', $commodity->id))
                ->exists();

            if ($dipakaiAlias || $dipakaiNama) {
                throw ValidationException::withMessages([
                    'aliases' => "Alias \"{$alias}\" sudah dipakai komoditas lain.",
                ]);
            }
        }
    }
}