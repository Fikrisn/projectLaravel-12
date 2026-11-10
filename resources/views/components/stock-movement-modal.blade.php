{{-- Dipakai di dalam x-data halaman. Membutuhkan: movementOpen, movementItem, movementJenis. --}}
<div
    x-show="movementOpen"
    x-cloak
    class="fixed inset-0 z-50 overflow-y-auto"
    role="dialog"
    aria-modal="true"
    aria-labelledby="movement-title"
    @keydown.escape.window="movementOpen = false"
>
    <div class="absolute inset-0 bg-slate-900/50" @click="movementOpen = false"></div>

    <div class="relative mx-auto my-10 w-[calc(100%-2rem)] max-w-md rounded-xl bg-white p-6 shadow-xl">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h2 id="movement-title" class="text-lg font-semibold" x-text="movementJenis === 'masuk' ? 'Catat Barang Masuk' : 'Catat Barang Keluar'"></h2>
                <p class="mt-1 text-sm text-slate-500">
                    <span x-text="movementItem ? movementItem.nama : ''"></span>
                    &middot; stok tersedia
                    <span class="font-medium text-slate-700" x-text="movementItem ? movementItem.stok : 0"></span>
                    <span x-text="movementItem ? movementItem.satuan : ''"></span>
                </p>
            </div>
            <button type="button" class="rounded-md p-1 text-slate-400 hover:bg-slate-100 hover:text-slate-600" @click="movementOpen = false" aria-label="Tutup">
                &times;
            </button>
        </div>

        <form
            method="POST"
            :action="movementItem ? '{{ url('/items') }}/' + movementItem.id + '/movements' : ''"
            class="mt-5 space-y-4"
        >
            @csrf
            <input type="hidden" name="jenis" :value="movementJenis">
            <input type="hidden" name="item_id" :value="movementItem ? movementItem.id : ''">

            @error('jenis')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror

            <div>
                <label for="jumlah" class="block text-sm font-medium text-slate-700">Jumlah</label>
                <input
                    type="number"
                    name="jumlah"
                    id="jumlah"
                    min="1"
                    required
                    value="{{ old('jumlah') }}"
                    class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-500"
                >
                @error('jumlah')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="tanggal" class="block text-sm font-medium text-slate-700">Tanggal</label>
                <input
                    type="date"
                    name="tanggal"
                    id="tanggal"
                    required
                    value="{{ old('tanggal', now()->toDateString()) }}"
                    class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-500"
                >
                @error('tanggal')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="keterangan" class="block text-sm font-medium text-slate-700">Keterangan <span class="font-normal text-slate-400">(opsional)</span></label>
                <textarea
                    name="keterangan"
                    id="keterangan"
                    rows="3"
                    class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-500"
                >{{ old('keterangan') }}</textarea>
                @error('keterangan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <button type="button" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50" @click="movementOpen = false">Batal</button>
                <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700">Simpan</button>
            </div>
        </form>
    </div>
</div>
