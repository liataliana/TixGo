@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="card">
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-3">
                <i class="fa-solid fa-credit-card text-primary text-2xl"></i>
            </div>
            <h2 class="text-2xl font-black text-gray-900">Konfirmasi Pembayaran</h2>
            <p class="text-gray-500 text-sm">Upload bukti transfer untuk memverifikasi pembayaran Anda</p>
        </div>

        <div class="bg-gray-50 rounded-xl p-4 mb-6">
            <div class="grid grid-cols-2 gap-2 text-sm">
                <span class="text-gray-500">Kode Booking</span>
                <span class="font-bold font-mono">{{ $booking->booking_code }}</span>
                <span class="text-gray-500">Total</span>
                <span class="font-bold text-primary">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                <span class="text-gray-500">Metode</span>
                <span class="font-semibold">Transfer Bank</span>
            </div>
        </div>

        <form action="{{ route('user.payment.upload', $booking->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-bold text-gray-700 mb-2">Upload Bukti Transfer</label>
                <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-primary transition cursor-pointer" id="dropzone">
                    <input type="file" name="payment_proof" accept="image/*,.pdf" class="hidden" id="fileInput" required>
                    <i class="fa-regular fa-cloud-arrow-up text-4xl text-gray-300 mb-2"></i>
                    <p class="text-gray-500 text-sm">Klik atau drag & drop bukti transfer</p>
                    <p class="text-xs text-gray-400">Format: JPG, PNG, PDF (max 5MB)</p>
                    <div id="fileName" class="mt-2 text-sm text-primary font-bold hidden"></div>
                </div>
                @error('payment_proof')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-4">
                <p class="text-sm text-blue-700">
                    <i class="fa-regular fa-info-circle mr-1"></i>
                    Transfer ke rekening: <span class="font-bold">BCA 1234567890 a/n PT TixGo</span>
                </p>
            </div>

            <button type="submit" class="btn-primary w-full py-3 text-base">
                <i class="fa-regular fa-circle-check mr-2"></i> Konfirmasi Pembayaran
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    const dropzone = document.getElementById('dropzone');
    const fileInput = document.getElementById('fileInput');
    const fileName = document.getElementById('fileName');

    dropzone.addEventListener('click', () => fileInput.click());
    dropzone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropzone.classList.add('border-primary', 'bg-primary/5');
    });
    dropzone.addEventListener('dragleave', () => {
        dropzone.classList.remove('border-primary', 'bg-primary/5');
    });
    dropzone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropzone.classList.remove('border-primary', 'bg-primary/5');
        if (e.dataTransfer.files.length) {
            fileInput.files = e.dataTransfer.files;
            updateFileName();
        }
    });
    fileInput.addEventListener('change', updateFileName);

    function updateFileName() {
        if (fileInput.files.length) {
            fileName.textContent = '📎 ' + fileInput.files[0].name;
            fileName.classList.remove('hidden');
        }
    }
</script>
@endpush
@endsection