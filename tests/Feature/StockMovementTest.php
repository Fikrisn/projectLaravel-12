<?php

namespace Tests\Feature;

use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StockMovementTest extends TestCase
{
    use RefreshDatabase;

    public function test_barang_keluar_tidak_boleh_melebihi_stok(): void
    {
        $item = Item::create([
            'kode' => 'BRG-TEST',
            'nama' => 'Barang Uji',
            'satuan' => 'pcs',
            'stok' => 3,
        ]);

        $response = $this->post(route('items.movements.store', $item), [
            'jenis' => 'keluar',
            'jumlah' => 4,
            'tanggal' => now()->toDateString(),
            'keterangan' => 'Melebihi stok',
        ]);

        $response->assertSessionHasErrors('jumlah');
        $this->assertSame(3, $item->fresh()->stok);
        $this->assertDatabaseCount('stok_movements', 0);
    }

    public function test_barang_masuk_menambah_stok_dan_mencatat_mutasi(): void
    {
        $item = Item::create([
            'kode' => 'BRG-IN',
            'nama' => 'Barang Masuk',
            'satuan' => 'pcs',
            'stok' => 5,
        ]);

        $this->post(route('items.movements.store', $item), [
            'jenis' => 'masuk',
            'jumlah' => 7,
            'tanggal' => now()->toDateString(),
            'keterangan' => 'Restock',
        ])->assertSessionHasNoErrors();

        $this->assertSame(12, $item->fresh()->stok);
        $this->assertDatabaseHas('stok_movements', [
            'item_id' => $item->id,
            'jenis' => 'masuk',
            'jumlah' => 7,
        ]);
    }

    public function test_barang_keluar_mengurangi_stok_dan_mencatat_mutasi(): void
    {
        $item = Item::create([
            'kode' => 'BRG-OUT',
            'nama' => 'Barang Keluar',
            'satuan' => 'pcs',
            'stok' => 10,
        ]);

        $this->post(route('items.movements.store', $item), [
            'jenis' => 'keluar',
            'jumlah' => 4,
            'tanggal' => now()->toDateString(),
        ])->assertSessionHasNoErrors();

        $this->assertSame(6, $item->fresh()->stok);
        $this->assertDatabaseHas('stok_movements', [
            'item_id' => $item->id,
            'jenis' => 'keluar',
            'jumlah' => 4,
        ]);
    }

    public function test_kode_barang_harus_unik(): void
    {
        Item::create([
            'kode' => 'BRG-UNIK',
            'nama' => 'Barang Pertama',
            'satuan' => 'pcs',
            'stok' => 1,
        ]);

        $this->post(route('items.store'), [
            'kode' => 'BRG-UNIK',
            'nama' => 'Barang Kedua',
            'satuan' => 'box',
        ])->assertSessionHasErrors('kode');

        $this->assertDatabaseCount('items', 1);
    }
}
