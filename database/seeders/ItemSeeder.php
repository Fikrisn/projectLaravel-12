<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['kode' => 'BRG-001', 'nama' => 'Kertas HVS A4', 'satuan' => 'rim', 'stok' => 25],
            ['kode' => 'BRG-002', 'nama' => 'Pulpen Hitam', 'satuan' => 'pcs', 'stok' => 120],
            ['kode' => 'BRG-003', 'nama' => 'Spidol Whiteboard', 'satuan' => 'pcs', 'stok' => 40],
            ['kode' => 'BRG-004', 'nama' => 'Map Plastik', 'satuan' => 'pack', 'stok' => 15],
            ['kode' => 'BRG-005', 'nama' => 'Tinta Printer', 'satuan' => 'botol', 'stok' => 8],
        ];

        foreach ($items as $item) {
            Item::firstOrCreate(['kode' => $item['kode']], $item);
        }
    }
}
