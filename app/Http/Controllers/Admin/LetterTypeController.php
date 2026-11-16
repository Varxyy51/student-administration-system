<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LetterType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LetterTypeController extends Controller
{
    public function index()
    {
        $letterTypes = LetterType::withCount('submissions')->latest()->get();

        return view('admin.letter-types.index', compact('letterTypes'));
    }

    public function create()
    {
        return view('admin.letter-types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:letter_types,name'],
            'description' => ['required', 'string', 'max:1000'],
            'requirements_text' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $requirements = $this->parseRequirements($validated['requirements_text'] ?? '');

        LetterType::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']) . '-' . Str::lower(Str::random(4)),
            'description' => $validated['description'],
            'requirements' => $requirements,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.letter-types.index')
            ->with('success', 'Jenis surat baru berhasil ditambahkan.');
    }

    public function edit(LetterType $letterType)
    {
        return view('admin.letter-types.edit', compact('letterType'));
    }

    public function update(Request $request, LetterType $letterType)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:letter_types,name,' . $letterType->id],
            'description' => ['required', 'string', 'max:1000'],
            'requirements_text' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $requirements = $this->parseRequirements($validated['requirements_text'] ?? '');

        $letterType->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'requirements' => $requirements,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.letter-types.index')
            ->with('success', 'Data jenis surat berhasil diperbarui.');
    }

    public function destroy(LetterType $letterType)
    {
        if ($letterType->submissions()->exists()) {
            return back()->with('error', 'Jenis surat tidak bisa dihapus karena sudah memiliki riwayat pengajuan. Silakan nonaktifkan saja statusnya.');
        }

        $letterType->delete();

        return redirect()->route('admin.letter-types.index')
            ->with('success', 'Jenis surat berhasil dihapus.');
    }

    private function parseRequirements(string $text): array
    {
        return collect(explode(',', $text))
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values()
            ->all();
    }
}