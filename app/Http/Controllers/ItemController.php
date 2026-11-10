<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ItemController extends Controller
{
    public function index(): View
    {
        return view('items.index', [
            'items' => Item::orderBy('nama')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Item::create($this->validated($request));

        return redirect()->route('items.index')->with('status', 'Barang berhasil ditambahkan.');
    }

    public function show(Request $request, Item $item): View
    {
        $filters = $request->validate([
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date', 'after_or_equal:from'],
        ]);

        $movements = $item->movements()
            ->when($filters['from'] ?? null, fn ($query, $date) => $query->whereDate('tanggal', '>=', $date))
            ->when($filters['to'] ?? null, fn ($query, $date) => $query->whereDate('tanggal', '<=', $date))
            ->latest('tanggal')
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('items.show', [
            'item' => $item,
            'movements' => $movements,
        ]);
    }

    public function edit(Item $item): View
    {
        return view('items.edit', [
            'item' => $item,
        ]);
    }

    public function update(Request $request, Item $item): RedirectResponse
    {
        $item->update($this->validated($request, $item));

        return redirect()->route('items.index')->with('status', 'Barang berhasil diperbarui.');
    }

    public function destroy(Item $item): RedirectResponse
    {
        $item->delete();

        return redirect()->route('items.index')->with('status', 'Barang berhasil dihapus.');
    }

    private function validated(Request $request, ?Item $item = null): array
    {
        return $request->validate([
            'kode' => ['required', 'string', 'max:50', Rule::unique('items', 'kode')->ignore($item)],
            'nama' => ['required', 'string', 'max:255'],
            'satuan' => ['required', 'string', 'max:50'],
        ]);
    }
}
