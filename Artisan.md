<div align="center">

# ⚡ Cheat Sheet Artisan Laravel 12

**Perintah `php artisan` yang paling berguna untuk belajar dan persiapan wawancara.**

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-%E2%89%A5%208.2-777BB4?logo=php&logoColor=white)
![Bahasa](https://img.shields.io/badge/Bahasa-Indonesia-red)

[📖 Dokumentasi Resmi Artisan](https://laravel.com/docs/12.x/artisan)

</div>

> 💡 Jalankan semua perintah dari **dalam folder project** Laravel kamu, dengan **PHP 8.2 atau lebih baru**.

---

## 📑 Daftar Isi

- [🚀 8 Perintah Wajib Hafal](#-8-perintah-wajib-hafal)
- [ℹ️ Informasi dan Bantuan](#ℹ️-informasi-dan-bantuan)
- [▶️ Menjalankan Aplikasi](#️-menjalankan-aplikasi)
- [🛠️ Membuat File (make)](#️-membuat-file-make)
- [🗄️ Database dan Migration](#️-database-dan-migration)
- [🧭 Route](#-route)
- [🧹 Cache dan Optimasi](#-cache-dan-optimasi)
- [⚙️ Setup Awal dan Konfigurasi](#️-setup-awal-dan-konfigurasi)
- [🧪 Tinker](#-tinker)
- [📬 Queue dan Scheduler](#-queue-dan-scheduler)
- [✅ Testing dan Maintenance](#-testing-dan-maintenance)
- [🔍 Beda Rollback, Refresh, dan Fresh](#-beda-rollback-refresh-dan-fresh)
- [🎬 Skenario Sehari-hari](#-skenario-sehari-hari)
- [🩺 Troubleshooting](#-troubleshooting)
- [🎯 Tips Cepat](#-tips-cepat)

---

## 🚀 8 Perintah Wajib Hafal

Kalau cuma sempat belajar sedikit, mulai dari sini.

| Perintah | Fungsi |
|----------|--------|
| `php artisan serve` | Menjalankan server development di http://127.0.0.1:8000 |
| `php artisan migrate` | Membuat tabel dari file migration |
| `php artisan make:model Nama -mcr` | Membuat model, migration, dan resource controller sekaligus |
| `php artisan route:list` | Melihat semua route |
| `php artisan tinker` | Konsol interaktif untuk mencoba kode |
| `php artisan optimize:clear` | Membersihkan semua cache |
| `php artisan migrate:fresh --seed` | Hapus semua tabel, buat ulang, lalu isi data seeder |
| `php artisan key:generate` | Membuat application key di `.env` |

---

## ℹ️ Informasi dan Bantuan

| Perintah | Fungsi |
|----------|--------|
| `php artisan list` | Semua perintah yang tersedia |
| `php artisan help migrate` | Bantuan untuk satu perintah |
| `php artisan --version` | Versi Laravel |
| `php artisan about` | Ringkasan aplikasi (versi PHP, driver, environment) |
| `php artisan env` | Environment yang sedang aktif |
| `php artisan list make` | Semua perintah berawalan `make:` |

---

## ▶️ Menjalankan Aplikasi

| Perintah | Fungsi |
|----------|--------|
| `php artisan serve` | Server di port 8000 |
| `php artisan serve --port=8080` | Pakai port lain |
| `php artisan serve --host=0.0.0.0` | Bisa diakses dari perangkat lain di jaringan |
| `composer run dev` | Server, queue, log, dan Vite sekaligus |

---

## 🛠️ Membuat File (make)

### Model dan kombinasinya

| Perintah | Hasil |
|----------|-------|
| `php artisan make:model Task` | Model |
| `php artisan make:model Task -m` | Model + migration |
| `php artisan make:model Task -mc` | Model + migration + controller |
| `php artisan make:model Task -mcr` | Model + migration + resource controller |
| `php artisan make:model Task -mfs` | Model + migration + factory + seeder |
| `php artisan make:model Task --all` | Model + migration, factory, seeder, policy, controller, dan form request |

### Controller

| Perintah | Hasil |
|----------|-------|
| `php artisan make:controller TaskController` | Controller kosong |
| `php artisan make:controller TaskController --resource` | Controller dengan method CRUD |
| `php artisan make:controller TaskController --resource --model=Task` | Resource controller yang terhubung ke model |
| `php artisan make:controller TaskController --api` | Resource controller untuk API (tanpa `create` dan `edit`) |
| `php artisan make:controller ShowDashboard --invokable` | Controller satu aksi |

### Migration

| Perintah | Hasil |
|----------|-------|
| `php artisan make:migration create_tasks_table` | Migration untuk membuat tabel |
| `php artisan make:migration add_status_to_tasks_table --table=tasks` | Migration untuk mengubah tabel yang sudah ada |

### File lainnya

| Perintah | Hasil |
|----------|-------|
| `php artisan make:seeder TaskSeeder` | Seeder |
| `php artisan make:factory TaskFactory` | Factory data contoh |
| `php artisan make:request StoreTaskRequest` | Form request untuk validasi |
| `php artisan make:middleware CekAdmin` | Middleware |
| `php artisan make:policy TaskPolicy --model=Task` | Policy otorisasi |
| `php artisan make:resource TaskResource` | API resource (format JSON) |
| `php artisan make:view tasks.index` | File Blade `resources/views/tasks/index.blade.php` |
| `php artisan make:component Alert` | Komponen Blade |
| `php artisan make:command KirimLaporan` | Perintah artisan buatan sendiri |
| `php artisan make:job ProsesGambar` | Job untuk antrian |
| `php artisan make:mail PesanSelamatDatang` | Class email |
| `php artisan make:event TugasSelesai` | Event |
| `php artisan make:listener KirimNotifikasi` | Listener event |
| `php artisan make:observer TaskObserver --model=Task` | Observer model |
| `php artisan make:rule Uppercase` | Aturan validasi kustom |
| `php artisan make:enum StatusTugas` | Enum |
| `php artisan make:class Services/LaporanService` | Class PHP biasa |
| `php artisan make:test TaskTest` | Feature test |
| `php artisan make:test TaskTest --unit` | Unit test |

---

## 🗄️ Database dan Migration

| Perintah | Fungsi |
|----------|--------|
| `php artisan migrate` | Jalankan migration yang belum dijalankan |
| `php artisan migrate:status` | Lihat migration mana yang sudah jalan |
| `php artisan migrate --pretend` | Tampilkan SQL tanpa menjalankannya |
| `php artisan migrate:rollback` | Batalkan batch migration terakhir |
| `php artisan migrate:rollback --step=1` | Batalkan 1 migration terakhir |
| `php artisan migrate:reset` | Batalkan semua migration |
| `php artisan migrate:refresh` | Rollback semua lalu migrate ulang |
| `php artisan migrate:fresh` | Hapus semua tabel lalu migrate ulang (data hilang) |
| `php artisan migrate:fresh --seed` | Fresh + jalankan seeder |
| `php artisan db:seed` | Jalankan `DatabaseSeeder` |
| `php artisan db:seed --class=TaskSeeder` | Jalankan seeder tertentu |
| `php artisan db:show` | Ringkasan database (koneksi, tabel) |
| `php artisan db:table tasks` | Detail kolom sebuah tabel |
| `php artisan db:wipe` | Hapus semua tabel (data hilang) |
| `php artisan model:show Task` | Info model: tabel, kolom, relasi |

> ⚠️ **Hati-hati:** `migrate:fresh`, `migrate:reset`, dan `db:wipe` **menghapus data**. Jangan dipakai pada database yang berisi data penting.

---

## 🧭 Route

| Perintah | Fungsi |
|----------|--------|
| `php artisan route:list` | Semua route |
| `php artisan route:list --except-vendor` | Tanpa route bawaan package |
| `php artisan route:list --path=tasks` | Filter berdasarkan URL |
| `php artisan route:list --name=tasks` | Filter berdasarkan nama route |
| `php artisan route:list --method=GET` | Filter berdasarkan method HTTP |
| `php artisan route:list -v` | Tampilkan middleware lengkap |
| `php artisan install:api` | Aktifkan dukungan API (Sanctum + `routes/api.php`), tidak aktif secara default di Laravel 12 |

---

## 🧹 Cache dan Optimasi

| Perintah | Fungsi |
|----------|--------|
| `php artisan optimize:clear` | Bersihkan semua cache sekaligus |
| `php artisan config:clear` | Cache konfigurasi (`.env`) |
| `php artisan cache:clear` | Cache aplikasi |
| `php artisan route:clear` | Cache route |
| `php artisan view:clear` | Cache view Blade |
| `php artisan event:clear` | Cache event |
| `php artisan optimize` | Buat cache config, route, view, event (untuk production) |
| `php artisan config:cache` | Cache konfigurasi saja |
| `php artisan route:cache` | Cache route saja |
| `php artisan view:cache` | Kompilasi semua view |

---

## ⚙️ Setup Awal dan Konfigurasi

| Perintah | Fungsi |
|----------|--------|
| `php artisan key:generate` | Buat `APP_KEY` |
| `php artisan storage:link` | Buat link `public/storage` ke `storage/app/public` |
| `php artisan install:api` | Pasang dukungan API |
| `php artisan vendor:publish` | Publikasikan file milik package |
| `php artisan lang:publish` | Publikasikan folder bahasa |
| `php artisan stub:publish` | Publikasikan stub untuk kustomisasi |

---

## 🧪 Tinker

Konsol interaktif untuk mencoba kode Laravel tanpa membuat route atau controller.

```bash
php artisan tinker        # buka konsol (keluar dengan: exit)
```

Lalu coba di dalamnya:

```php
App\Models\Task::create(['title' => 'Belajar Laravel']);   // Tambah data
App\Models\Task::all();                                     // Ambil semua data
App\Models\Task::count();                                   // Hitung data
App\Models\Task::where('is_done', false)->get();            // Filter data
App\Models\Task::find(1);                                   // Cari berdasarkan id
App\Models\Task::find(1)->update(['is_done' => true]);      // Ubah data
App\Models\Task::find(1)->delete();                         // Hapus data
App\Models\Task::factory()->count(5)->create();             // Buat 5 data contoh dari factory
```

---

## 📬 Queue dan Scheduler

| Perintah | Fungsi |
|----------|--------|
| `php artisan queue:work` | Jalankan worker antrian |
| `php artisan queue:listen` | Worker yang otomatis memuat ulang kode |
| `php artisan queue:failed` | Lihat job yang gagal |
| `php artisan queue:retry all` | Ulangi semua job gagal |
| `php artisan queue:flush` | Hapus semua job gagal |
| `php artisan queue:restart` | Restart worker setelah ubah kode |
| `php artisan schedule:list` | Daftar tugas terjadwal |
| `php artisan schedule:run` | Jalankan tugas yang jatuh tempo |
| `php artisan schedule:work` | Jalankan scheduler terus-menerus (development) |

---

## ✅ Testing dan Maintenance

| Perintah | Fungsi |
|----------|--------|
| `php artisan test` | Jalankan semua test |
| `php artisan test --filter=TaskTest` | Jalankan test tertentu |
| `php artisan test --stop-on-failure` | Berhenti di kegagalan pertama |
| `php artisan down` | Aktifkan mode maintenance |
| `php artisan up` | Nonaktifkan mode maintenance |

---

## 🔍 Beda Rollback, Refresh, dan Fresh

Pertanyaan favorit saat wawancara!

| Perintah | Perilaku |
|----------|----------|
| `migrate:rollback` | Membatalkan migration terakhir, data tabel lain tetap |
| `migrate:refresh` | Menjalankan semua `down()` lalu `up()` |
| `migrate:fresh` | Menghapus semua tabel (tanpa `down()`), lalu migrate dari awal |

---

## 🎬 Skenario Sehari-hari

### 🆕 Memulai project baru

```bash
composer create-project laravel/laravel nama-project "^12.0"
cd nama-project
php artisan key:generate
php artisan migrate
npm install
npm run build
php artisan serve
```

### 🧩 Membuat fitur CRUD baru

1. `php artisan make:model Task -mcr`
2. Isi file migration
3. `php artisan migrate`
4. Tambahkan di `routes/web.php`:
   ```php
   Route::resource('tasks', TaskController::class);
   ```
5. `php artisan route:list --path=tasks`

### 🔄 Mengulang database dari nol

```bash
php artisan migrate:fresh --seed
```

### 📝 Setelah mengubah `.env`

```bash
php artisan config:clear
# lalu restart php artisan serve
```

### 🤔 Ada yang aneh dan penyebabnya tidak jelas

```bash
php artisan optimize:clear
composer dump-autoload
```

### 🎭 Menyiapkan data contoh untuk demo

1. `php artisan make:factory TaskFactory`
2. `php artisan make:seeder TaskSeeder`
3. Isi factory dan seeder
4. `php artisan db:seed --class=TaskSeeder`

---

## 🩺 Troubleshooting

| Masalah | Solusi |
|---------|--------|
| `No application encryption key has been specified` | `php artisan key:generate` |
| Perubahan `.env` tidak terbaca | `php artisan config:clear` |
| Halaman 404 padahal route sudah dibuat | `php artisan route:list`, lalu `php artisan route:clear` |
| Tampilan Blade tidak berubah | `php artisan view:clear` |
| `Unknown database` | Buat database, lalu `php artisan migrate` |
| `Table doesn't exist` | `php artisan migrate` |
| `Class not found` | `composer dump-autoload` |
| Gambar upload tidak muncul | `php artisan storage:link` |
| Tabel sudah ada saat migrate | `php artisan migrate:fresh` ⚠️ (menghapus data) |
| Tidak tahu perintah apa yang tersedia | `php artisan list` |

---

## 🎯 Tips Cepat

- ⌨️ Tekan `Ctrl + C` untuk menghentikan server atau worker yang sedang berjalan.
- 🐞 Tambahkan `-v` atau `-vvv` untuk melihat detail error pada perintah artisan.
- 🧠 Gunakan `php artisan list make` untuk mengingat semua jenis file yang bisa dibuat.
- 🆘 Tambahkan `--help` ke perintah apa pun untuk melihat opsinya.

---

<div align="center">

Dibuat untuk belajar Laravel 12 ❤️ · [Dokumentasi Artisan](https://laravel.com/docs/12.x/artisan)

</div>
