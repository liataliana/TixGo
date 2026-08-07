{{-- [Magfi Adi Radza Putra] --}}
@extends('layouts.app')

@section('content')
<div class="mb-8">
    <div class="flex items-center gap-3 text-sm text-gray-500 mb-2">
        <a href="{{ route('manager.tickets.index') }}" class="hover:text-primary transition-colors"><i class="fa-solid fa-arrow-left mr-1"></i> Kembali</a>
        <span>/</span>
        <span class="text-gray-400">Edit Tiket</span>
    </div>
    <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Edit Data Tiket</h2>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8 transform transition-all duration-300 hover:shadow-lg" style="transform-style: preserve-3d; perspective: 1000px;">
    <form action="{{ route('manager.tickets.update', $ticket->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Nama Tiket -->
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Tiket <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $ticket->name) }}" class="w-full rounded-xl border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition-shadow @error('name') border-red-500 @enderror" required>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Kategori -->
            <div>
                <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                <select name="category_id" id="category_id" class="w-full rounded-xl border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition-shadow @error('category_id') border-red-500 @enderror" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $ticket->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Harga -->
            <div>
                <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">Harga (Rp) <span class="text-red-500">*</span></label>
                <input type="number" name="price" id="price" value="{{ old('price', $ticket->price) }}" min="0" class="w-full rounded-xl border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition-shadow @error('price') border-red-500 @enderror" required>
                @error('price')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Stok -->
            <div>
                <label for="stock" class="block text-sm font-semibold text-gray-700 mb-2">Stok <span class="text-red-500">*</span></label>
                <input type="number" name="stock" id="stock" value="{{ old('stock', $ticket->stock) }}" min="0" class="w-full rounded-xl border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition-shadow @error('stock') border-red-500 @enderror" required>
                @error('stock')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tanggal Event -->
            <div>
                <label for="event_date" class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Event <span class="text-red-500">*</span></label>
                <input type="date" name="event_date" id="event_date" value="{{ old('event_date', $ticket->event_date) }}" class="w-full rounded-xl border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition-shadow @error('event_date') border-red-500 @enderror" required>
                @error('event_date')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Lokasi -->
            <div>
                <label for="location" class="block text-sm font-semibold text-gray-700 mb-2">Lokasi <span class="text-red-500">*</span></label>
                <input type="text" name="location" id="location" value="{{ old('location', $ticket->location) }}" class="w-full rounded-xl border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition-shadow @error('location') border-red-500 @enderror" required>
                @error('location')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                <select name="status" id="status" class="w-full rounded-xl border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition-shadow @error('status') border-red-500 @enderror">
                    <option value="active" {{ old('status', $ticket->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ old('status', $ticket->status) == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Deskripsi -->
        <div class="mb-6">
            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi <span class="text-red-500">*</span></label>
            <textarea name="description" id="description" rows="4" class="w-full rounded-xl border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition-shadow @error('description') border-red-500 @enderror" required>{{ old('description', $ticket->description) }}</textarea>
            @error('description')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end gap-3 mt-8">
            <a href="{{ route('manager.tickets.index') }}" class="btn-primary-outline">Batal</a>
            <button type="submit" class="btn-primary">
                <i class="fa-solid fa-save mr-1"></i> Perbarui Tiket
            </button>
        </div>
    </form>
</div>
@endsection
