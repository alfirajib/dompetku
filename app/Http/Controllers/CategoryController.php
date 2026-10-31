<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = $request->user()->categories()
            ->withCount('transactions')->orderBy('type')->orderBy('name')->get();

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.form', ['category' => null]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['name'] = strip_tags($data['name']);

        $request->user()->categories()->create($data);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Request $request, string $id)
    {
        // Query lewat relasi user => user lain tidak bisa mengakses data ini (404)
        $category = $request->user()->categories()->findOrFail($id);

        return view('categories.form', compact('category'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $category = $request->user()->categories()->findOrFail($id);

        $data = $this->validated($request, $category->id);
        $data['name'] = strip_tags($data['name']);

        $category->update($data);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Request $request, string $id): RedirectResponse
    {
        $category = $request->user()->categories()->findOrFail($id);

        if ($category->transactions()->exists()) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih dipakai transaksi.');
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus.');
    }

    private function validated(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'name' => [
                'required', 'string', 'max:50',
                Rule::unique('categories')
                    ->where(fn ($q) => $q->where('user_id', $request->user()->id)->where('type', $request->input('type')))
                    ->ignore($ignoreId),
            ],
            'type' => ['required', 'in:income,expense'],
        ]);
    }
}
