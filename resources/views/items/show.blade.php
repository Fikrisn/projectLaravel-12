@extends('layouts.app')

@section('title', 'Riwayat '.$item->nama)

@section('content')
    <div
        x-data="{
            movementOpen: {{ old('item_id') ? 'true' : 'false' }},
            movementJenis: @js(old('jenis', 'masuk')),
            movementItem: @js($item->only('id', 'nama', 'satuan', 'stok')),
            openMovement(jenis) {
                this.movementJenis = jenis;
                this.movementOpen = true;
            },
        }"
    >
        <a href="{{ route('items.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-800">&larr; Kembali ke daftar barang</a>

        <section class="mt-4 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div>
                    <p class="font-mono text-xs text-slate-500">{{ $item->kode }}</p>
                    <h1 class="mt-1 text-2xl font-semibold text-slate-900">{{ $item->nama }}</h1>
                    <p class="mt-2 text-sm text-slate-500">
                        Stok tersedia:
                        <span class="text-lg font-semibold {{ $item->stok > 0 ? 'text-emerald-700' : 'text-red-600' }}">{{ $item->stok }}</span>
                        {{ $item->satuan }}
                    </p>
                </div>
                <div class="flex gap-2">
                    <button type="button" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-500" @click="openMovement('masuk')">Barang Masuk</button>
                    <button type="button" class="rounded-lg bg-amber-500 px-4 py-2 text-sm font-medium text-white hover:bg-amber-400" @click="openMovement('keluar')">Barang Keluar</button>
                    <a href="{{ route('items.edit', $item) }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Edit</a>
                </div>
            </div>
        </section>

        <section class="mt-6 rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="flex flex-wrap items-end justify-between gap-4 border-b border-slate-200 p-5">
                <div>
                    <h2 class="font-semibold text-slate-900">Riwayat Mutasi</h2>
                    <p class="mt-1 text-sm text-slate-500">Filter berdasarkan tanggal untuk mempersempit riwayat.</p>
                </div>
                <form method="GET" action="{{ route('items.show', $item) }}" class="flex flex-wrap items-end gap-2">
                    <div>
                        <label for="from" class="block text-xs font-medium text-slate-500">Dari tanggal</label>
                        <input type="date" name="from" id="from" value="{{ old('from', request('from')) }}" class="mt-1 rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-500">
                    </div>
                    <div>
                        <label for="to" class="block text-xs font-medium text-slate-500">Sampai tanggal</label>
                        <input type="date" name="to" id="to" value="{{ old('to', request('to')) }}" class="mt-1 rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-500">
                    </div>
                    <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700">Filter</button>
                    @if (request()->filled('from') || request()->filled('to'))
                        <a href="{{ route('items.show', $item) }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Reset</a>
                    @endif
                </form>
            </div>

            @error('from')
                <p class="px-5 pt-3 text-sm text-red-600">{{ $message }}</p>
            @enderror
            @error('to')
                <p class="px-5 pt-3 text-sm text-red-600">{{ $message }}</p>
            @enderror

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                        <tr>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">Jenis</th>
                            <th class="px-4 py-3 text-right">Jumlah</th>
                            <th class="px-4 py-3">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($movements as $movement)
                            <tr>
                                <td class="whitespace-nowrap px-4 py-3 text-slate-600">{{ $movement->tanggal->format('d-m-Y') }}</td>
                                <td class="whitespace-nowrap px-4 py-3">
                                    <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $movement->jenis === 'masuk' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                                        {{ ucfirst($movement->jenis) }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-right font-medium {{ $movement->jenis === 'masuk' ? 'text-emerald-700' : 'text-amber-700' }}">
                                    {{ $movement->jenis === 'masuk' ? '+' : '-' }}{{ $movement->jumlah }} {{ $item->satuan }}
                                </td>
                                <td class="px-4 py-3 text-slate-600">{{ $movement->keterangan ?: '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-10 text-center text-slate-500">Belum ada mutasi pada rentang tanggal ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($movements->hasPages())
                <div class="border-t border-slate-200 px-5 py-4">
                    {{ $movements->links() }}
                </div>
            @endif
        </section>

        <x-stock-movement-modal />
    </div>
@endsection
