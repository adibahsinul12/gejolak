<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReasonTemplate;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ReasonTemplateController extends Controller
{
    public function index()
    {
        $templates = ReasonTemplate::orderByDesc('aktif')->orderBy('teks')->get();

        return view('admin.reason-templates.index', compact('templates'));
    }

    public function create()
    {
        return view('admin.reason-templates.form', ['template' => new ReasonTemplate(['aktif' => true])]);
    }

    public function store(Request $request)
    {
        ReasonTemplate::create($this->data($request));

        return redirect()->route('admin.reason-templates.index')->with('ok', 'Template alasan berhasil ditambahkan.');
    }

    public function edit(ReasonTemplate $reasonTemplate)
    {
        return view('admin.reason-templates.form', ['template' => $reasonTemplate]);
    }

    public function update(Request $request, ReasonTemplate $reasonTemplate)
    {
        $reasonTemplate->update($this->data($request, $reasonTemplate));

        return redirect()->route('admin.reason-templates.index')->with('ok', 'Template alasan berhasil diperbarui.');
    }

    // Tidak menghapus, hanya menonaktifkan agar alasan yang sudah dipakai tetap utuh.
    public function destroy(ReasonTemplate $reasonTemplate)
    {
        $reasonTemplate->update(['aktif' => false]);

        return redirect()->route('admin.reason-templates.index')->with('ok', 'Template alasan dinonaktifkan.');
    }

    private function data(Request $request, ?ReasonTemplate $template = null): array
    {
        $data = $request->validate([
            'teks' => ['required', 'max:150', Rule::unique('reason_templates', 'teks')->ignore($template?->id)],
        ]);

        $data['aktif'] = $request->boolean('aktif');

        return $data;
    }
}