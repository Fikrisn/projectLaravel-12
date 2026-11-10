@extends('layouts.app')

@section('title', 'Edit Barang')

@section('content')
    <div class="mx-auto max-w-xl">
        <a href="{{ route('items.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-800">&larr; Kembali ke daftar barang</a>

        <section class="mt-4 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <h1 class="text-xl font-semibold text-slate-900">Edit Barang</h1>
            <p class="mt-1 text-sm text-slate-500">Stok hanya berubah melalui pencatatan barang masuk atau keluar.</p>

            <form method="POST" action="{{ route('items.update', $item) }}" class="mt-6 space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="kode" class="block text-sm font-medium text-slate-700">Kode</label>
                    <input type="text" name="kode" id="kode" required value="{{ old('kode', $item->kode) }}" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-500">
                    @error('kode')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="nama" class="block text-sm font-medium text-slate-700">Nama</label>
                    <input type="text" name="nama" id="nama" required value="{{ old('nama', $item->nama) }}" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-500">
                    @error('nama')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="satuan" class="block text-sm font-medium text-slate-700">Satuan</label>
                    <input type="text" name="satuan" id="satuan" required value="{{ old('satuan', $item->satuan) }}" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-500">
                    @error('satuan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="rounded-lg bg-slate-50 px-4 py-3 text-sm text-slate-600">
                    Stok saat ini: <span class="font-semibold text-slate-900">{{ $item->stok }} {{ $item->satuan }}</span>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2">
                    <a href="{{ route('items.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Batal</a>
                    <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700">Simpan Perubahan</button>
                </div>
            </form>
        </section>
    </div>
@endsection
