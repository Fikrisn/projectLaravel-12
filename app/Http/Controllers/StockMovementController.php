<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class StockMovementController extends Controller
{
    public function store(Request $request, Item $item): RedirectResponse
    {
        $data = $request->validate([
            'jenis' => ['required', Rule::in(['masuk', 'keluar'])],
            'jumlah' => ['required', 'integer', 'min:1'],
            'keterangan' => ['nullable', 'string', 'max:255'],
            'tanggal' => ['required', 'date'],
        ]);

        DB::transaction(function () use ($item, $data) {
            $lockedItem = Item::lockForUpdate()->findOrFail($item->id);

            if ($data['jenis'] === 'keluar' && $data['jumlah'] > $lockedItem->stok) {
                throw ValidationException::withMessages([
                    'jumlah' => "Stok tidak mencukupi. Stok tersedia: {$lockedItem->stok} {$lockedItem->satuan}.",
                ]);
            }

            $lockedItem->stok += $data['jenis'] === 'masuk' ? $data['jumlah'] : -$data['jumlah'];
            $lockedItem->save();

            $lockedItem->movements()->create($data);
        });

        $label = $data['jenis'] === 'masuk' ? 'Barang masuk' : 'Barang keluar';

        return back()->with('status', "{$label} berhasil dicatat.");
    }
}
