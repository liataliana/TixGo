{{-- [Magfi Adi Radza Putra] --}}
@extends('layouts.app')

@section('content')
<style>
    .cat-tabs { display: flex; gap: 0.5rem; flex-wrap: wrap; margin-bottom: 1.5rem; }
    .cat-tab {
        padding: 0.45rem 1.1rem; border-radius: 100px; font-size: 0.82rem; font-weight: 700;
        border: 2px solid #e2e8f0; color: #64748b; background: white;
        text-decoration: none; transition: all 0.2s;
    }
    .cat-tab:hover { border-color: #059669; color: #059669; }
    .cat-tab.active { background: #059669; border-color: #059669; color: white; }
</style>

<div class="mb-6 flex justify-between items-end flex-wrap gap-3">
    <div>
        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Kelola Tiket</h2>
        <p class="text-gray-500 mt-1 text-sm">Filter tiket berdasarkan kategori layanan</p>
    </div>
    <a href="{{ route('manager.tickets.create') }}" class="btn-primary">
        <i class="fa-solid fa-plus"></i> Tambah Tiket
    </a>
</div>

{{-- TAB FILTER KATEGORI --}}
<div class="cat-tabs">
    <a href="{{ route('manager.tickets.index') }}" class="cat-tab {{ !$selectedCategory ? 'active' : '' }}">
        🎫 Semua
    </a>
    @foreach($categories as $cat)
    <a href="{{ route('manager.tickets.index', ['category' => $cat->name]) }}" class="cat-tab {{ $selectedCategory == $cat->name ? 'active' : '' }}">
        @php
            $catIcons = ['hotel'=>'🏨','villa'=>'🏡','bus'=>'🚌','kereta'=>'🚂','penerbangan'=>'✈️'];
            $icon = $catIcons[strtolower($cat->name)] ?? '🎟️';
        @endphp
        {{ $icon }} {{ $cat->name }}
    </a>
    @endforeach
</div>

@if(session('success'))
    <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl font-semibold text-sm">
        ✅ {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-600 font-semibold border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4">Kode Tiket</th>
                    <th class="px-6 py-4">Nama Tiket</th>
                    <th class="px-6 py-4">Kategori</th>
                    <th class="px-6 py-4">Harga</th>
                    <th class="px-6 py-4">Stok</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($tickets as $ticket)
                <tr class="hover:bg-gray-50 transition-colors duration-200 group">
                    <td class="px-6 py-4 font-medium text-primary font-mono text-xs">{{ $ticket->ticket_code }}</td>
                    <td class="px-6 py-4 font-semibold text-gray-800">{{ $ticket->name }}</td>
                    <td class="px-6 py-4">
                        @php
                            $catName = $ticket->category->name ?? '-';
                            $catIcons2 = ['hotel'=>'🏨','villa'=>'🏡','bus'=>'🚌','kereta'=>'🚂','penerbangan'=>'✈️'];
                            $catIcon = $catIcons2[strtolower($catName)] ?? '🎟️';
                        @endphp
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                            {{ $catIcon }} {{ $catName }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-green-600 font-bold">Rp {{ number_format($ticket->price, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">{{ $ticket->stock }}</td>
                    <td class="px-6 py-4">
                        @if($ticket->is_active)
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">✅ Aktif</span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">❌ Nonaktif</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('manager.tickets.edit', $ticket->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-colors">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <form action="{{ route('manager.tickets.destroy', $ticket->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus tiket ini?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-colors">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-16 text-center text-gray-400">
                        <i class="fa-solid fa-ticket text-5xl mb-3 block"></i>
                        @if($selectedCategory)
                            Belum ada tiket untuk kategori <strong>{{ $selectedCategory }}</strong>.
                        @else
                            Belum ada data tiket.
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($tickets->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
        {{ $tickets->links() }}
    </div>
    @endif
</div>
@endsection
