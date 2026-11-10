# Stok Gudang

Aplikasi web sederhana untuk mengelola stok barang gudang: daftar barang, pencatatan barang masuk/keluar, dan riwayat mutasi stok. Dibangun dengan Laravel 12, Tailwind CSS 4, Alpine.js, dan MySQL/SQLite.

## Fitur

- Daftar barang dengan pencarian langsung (client-side) menggunakan Alpine.js.
- Tambah barang dengan validasi kode wajib & unik, nama wajib, dan satuan wajib.
- Edit dan hapus barang. Stok tidak bisa diubah langsung, hanya melalui mutasi.
- Pencatatan barang masuk dan barang keluar melalui modal Alpine.js.
- Stok bertambah/berkurang otomatis setiap mutasi dicatat.
- Barang keluar ditolak jika jumlahnya melebihi stok tersedia; transaksi dibatalkan dan stok tidak berubah.
- Riwayat mutasi per barang di halaman detail, lengkap dengan filter rentang tanggal dan pagination.
- Seeder berisi 5 barang contoh.

## Skema Database

### `items`

| Kolom | Tipe | Keterangan |
| --- | --- | --- |
| `id` | bigint | Primary key |
| `kode` | string | Kode barang, unik |
| `nama` | string | Nama barang |
| `satuan` | string | Satuan (pcs, rim, box, dll.) |
| `stok` | unsigned integer | Stok saat ini, default 0 |
| `created_at`, `updated_at` | timestamp | Waktu dibuat/diubah |

### `stok_movements`

| Kolom | Tipe | Keterangan |
| --- | --- | --- |
| `id` | bigint | Primary key |
| `item_id` | foreign key | Relasi ke `items`, cascade delete |
| `jenis` | enum | `masuk` atau `keluar` |
| `jumlah` | unsigned integer | Jumlah mutasi, minimal 1 |
| `keterangan` | string, nullable | Catatan mutasi |
| `tanggal` | date | Tanggal mutasi |
| `created_at`, `updated_at` | timestamp | Waktu dicatat |

## Aturan Stok

- Mutasi disimpan dalam database transaction dengan `lockForUpdate` agar stok tetap konsisten saat ada transaksi bersamaan.
- Untuk mutasi `keluar`, sistem memeriksa `jumlah > stok`. Jika melebihi, transaksi dibatalkan dengan pesan "Stok tidak mencukupi" dan tidak ada mutasi yang tersimpan.
- Perubahan stok dan pencatatan mutasi terjadi dalam transaksi yang sama.
- Menghapus barang akan menghapus seluruh riwayat mutasinya (cascade).

## Route

| Method | URI | Keterangan |
| --- | --- | --- |
| GET | `/` | Redirect ke daftar barang |
| GET | `/items` | Daftar barang + form tambah |
| POST | `/items` | Simpan barang baru |
| GET | `/items/{item}` | Detail barang + riwayat mutasi |
| GET | `/items/{item}/edit` | Form edit barang |
| PUT | `/items/{item}` | Simpan perubahan barang |
| DELETE | `/items/{item}` | Hapus barang |
| POST | `/items/{item}/movements` | Catat barang masuk/keluar |

## Instalasi

Prasyarat: PHP >= 8.2, Composer, Node.js, dan database MySQL (atau SQLite).

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Sesuaikan koneksi database pada `.env`, lalu:

```bash
php artisan migrate --seed
npm install
npm run build
php artisan serve
```

Untuk pengembangan dengan hot reload:

```bash
npm run dev
```

Buka `http://127.0.0.1:8000`.

> Catatan Laragon: jika `php` di terminal masih versi 8.1, gunakan path PHP 8.3 secara eksplisit, misalnya `C:\laragon\bin\php\php-8.3.33-Win32-vs16-x64\php.exe artisan serve`.

## Menjalankan Test

Test menggunakan SQLite in-memory dan `RefreshDatabase`. Pastikan ekstensi `pdo_sqlite` aktif di PHP yang dipakai menjalankan test.

```bash
php artisan test
```

Test utama di `tests/Feature/StockMovementTest.php` memverifikasi:

- Barang keluar melebihi stok ditolak, stok tidak berubah, dan tidak ada mutasi tersimpan.
- Barang masuk menambah stok.
- Barang keluar valid mengurangi stok.
- Kode barang duplikat ditolak.

## Struktur Penting

```text
app/Http/Controllers/ItemController.php           # CRUD barang + riwayat
app/Http/Controllers/StockMovementController.php  # Pencatatan mutasi + aturan stok
app/Models/Item.php
app/Models/StockMovement.php
resources/views/items/index.blade.php             # Daftar, pencarian, form tambah
resources/views/items/show.blade.php              # Detail + riwayat + filter tanggal
resources/views/components/stock-movement-modal.blade.php
database/seeders/ItemSeeder.php
tests/Feature/StockMovementTest.php
```
