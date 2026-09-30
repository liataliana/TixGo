{{-- [Magfi Adi Radza Putra] --}}
@extends('layouts.app')

@section('content')
<div class="mb-8 flex justify-between items-end">
    <div>
        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Kelola Tiket</h2>
        <p class="text-gray-500 mt-1 text-sm">Manajemen data tiket untuk aplikasi TixGo.</p>
    </div>
    <a href="{{ route('superadmin.tickets.create') }}" class="btn-primary">
        <i class="fa-solid fa-plus"></i> Tambah Tiket
    </a>
</div>

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
                <tr class="hover:bg-gray-50 transition-colors duration-200 group transform hover:-translate-y-1 hover:shadow-md" style="transform-style: preserve-3d; perspective: 1000px;">
                    <td class="px-6 py-4 font-medium text-primary">{{ $ticket->ticket_code }}</td>
                    <td class="px-6 py-4 font-semibold text-gray-800">{{ $ticket->name }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                            {{ $ticket->category->name ?? '-' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-green-600 font-bold">Rp {{ number_format($ticket->price, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">{{ $ticket->stock }}</td>
                    <td class="px-6 py-4">
                        @if($ticket->status == 'active')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                Tidak Aktif
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('superadmin.tickets.edit', $ticket->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-colors">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <form action="{{ route('superadmin.tickets.destroy', $ticket->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tiket ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-colors">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                        <i class="fa-solid fa-ticket text-4xl mb-3 text-gray-300 block"></i>
                        Belum ada data tiket.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if(isset($tickets) && $tickets->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
        {{ $tickets->links() }}
    </div>
    @endif
</div>
@endsection
