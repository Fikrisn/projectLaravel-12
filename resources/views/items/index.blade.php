@extends('layouts.app')

@section('title', 'Daftar Barang')

@section('content')
    <div
        x-data="{
            search: '',
            movementOpen: {{ old('item_id') ? 'true' : 'false' }},
            movementJenis: @js(old('jenis', 'masuk')),
            movementItem: @js(old('item_id') ? $items->firstWhere('id', old('item_id'))?->only('id', 'nama', 'satuan', 'stok') : null),
            openMovement(item, jenis) {
                this.movementItem = item;
                this.movementJenis = jenis;
                this.movementOpen = true;
            },
        }"
    >
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Daftar Barang</h1>
                <p class="mt-1 text-sm text-slate-500">Kelola barang dan catat setiap mutasi stok.</p>
            </div>
            <div class="w-full sm:w-64">
                <label for="search" class="sr-only">Cari barang</label>
                <input
                    type="search"
                    id="search"
                    x-model="search"
                    placeholder="Cari kode, nama, atau satuan..."
                    class="block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-500"
                >
            </div>
        </div>

        <section class="mt-6 rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="font-semibold text-slate-900">Tambah Barang</h2>
            <form method="POST" action="{{ route('items.store') }}" class="mt-4 grid gap-4 sm:grid-cols-4">
                @csrf
                <div>
                    <label for="kode" class="block text-sm font-medium text-slate-700">Kode</label>
                    <input type="text" name="kode" id="kode" required value="{{ old('kode') }}" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-500">
                    @error('kode')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="sm:col-span-2">
                    <label for="nama" class="block text-sm font-medium text-slate-700">Nama</label>
                    <input type="text" name="nama" id="nama" required value="{{ old('nama') }}" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-500">
                    @error('nama')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex items-end gap-3">
                    <div class="flex-1">
                        <label for="satuan" class="block text-sm font-medium text-slate-700">Satuan</label>
                        <input type="text" name="satuan" id="satuan" required value="{{ old('satuan') }}" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-500">
                        @error('satuan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700">Tambah</button>
                </div>
            </form>
        </section>

        <section class="mt-6 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                        <tr>
                            <th class="px-4 py-3">Kode</th>
                            <th class="px-4 py-3">Nama</th>
                            <th class="px-4 py-3">Satuan</th>
                            <th class="px-4 py-3 text-right">Stok</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($items as $item)
                            <tr
                                data-search="{{ Str::lower($item->kode.' '.$item->nama.' '.$item->satuan) }}"
                                x-show="!search || $el.dataset.search.includes(search.toLowerCase())"
                            >
                                <td class="whitespace-nowrap px-4 py-3 font-mono text-xs text-slate-500">{{ $item->kode }}</td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('items.show', $item) }}" class="font-medium text-slate-900 hover:underline">{{ $item->nama }}</a>
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-slate-600">{{ $item->satuan }}</td>
                                <td class="whitespace-nowrap px-4 py-3 text-right">
                                    <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $item->stok > 0 ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-700' }}">
                                        {{ $item->stok }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-4 py-3">
                                    <div class="flex justify-end gap-2 text-xs">
                                        <button type="button" class="rounded-md bg-emerald-600 px-2.5 py-1.5 font-medium text-white hover:bg-emerald-500" @click="openMovement(@js($item->only('id', 'nama', 'satuan', 'stok')), 'masuk')">Masuk</button>
                                        <button type="button" class="rounded-md bg-amber-500 px-2.5 py-1.5 font-medium text-white hover:bg-amber-400" @click="openMovement(@js($item->only('id', 'nama', 'satuan', 'stok')), 'keluar')">Keluar</button>
                                        <a href="{{ route('items.show', $item) }}" class="rounded-md border border-slate-300 px-2.5 py-1.5 font-medium text-slate-700 hover:bg-slate-50">Riwayat</a>
                                        <a href="{{ route('items.edit', $item) }}" class="rounded-md border border-slate-300 px-2.5 py-1.5 font-medium text-slate-700 hover:bg-slate-50">Edit</a>
                                        <form method="POST" action="{{ route('items.destroy', $item) }}" onsubmit="return confirm('Hapus barang ini beserta seluruh riwayat mutasinya?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-md border border-red-200 px-2.5 py-1.5 font-medium text-red-600 hover:bg-red-50">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-10 text-center text-slate-500">Belum ada barang. Tambahkan barang pertama di atas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <x-stock-movement-modal />
    </div>
@endsection
