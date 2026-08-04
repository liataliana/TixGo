@extends('layouts.app')

@section('content')
<style>
    .villa-result-wrapper { max-width: 1100px; margin: 20px auto; padding: 0 16px; }
    .top-search-summary { background: #fff; padding: 16px 20px; border-radius: 12px; border:1px solid #e2e8f0; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-bottom:24px;}
    
    .villa-grid-container { display: grid; grid-template-columns: 240px 1fr; gap: 24px; }
    
    /* FILTER SIDEBAR */
    .filter-sidebar { background: #fff; border-radius: 12px; border:1px solid #e2e8f0; padding: 16px; height: fit-content; }
    .filter-title { font-weight: 700; margin-bottom: 12px; font-size: 15px; }
    .filter-chip-group { display: flex; flex-wrap: wrap; gap:8px; margin-bottom: 16px; }
    .filter-chip { padding: 6px 14px; border:1px solid #e2e8f0; border-radius: 20px; font-size: 12px; background: #fff; cursor: pointer; transition: 0.2s; }
    .filter-chip:hover { background: #f1f5f9; border-color: #1e3a5f; }

    /* CARD VILLA */
    .villa-list { display: flex; flex-direction: column; gap: 12px; }
    .villa-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; display: flex; overflow: hidden; position: relative; }
    .villa-img { width: 320px; min-height: 200px; object-fit: cover; position: relative;}
    .badge-top { position: absolute; bottom: 10px; left: 10px; background: #ffedd5; color: #f97316; padding: 4px 10px; border-radius: 6px; font-weight: bold; font-size: 12px; border: 1px solid #fed7aa; }
    
    .villa-info { padding: 16px; flex: 1; display: flex; flex-direction: column; justify-content: space-between; gap: 10px; position: relative;}
    
    .villa-header { display: flex; justify-content: space-between; align-items: flex-start; }
    .villa-name { font-weight: 700; font-size: 16px; color: #1e293b; margin-bottom: 2px; }
    .villa-type { font-size: 13px; color: #64748b; }
    .stars { color: #f59e0b; font-size: 12px; }
    
    .rating-container { margin-top: 6px; }
    .rating-box { background: #1e3a5f; color: white; padding: 2px 8px; border-radius: 6px; font-weight: 700; font-size: 13px; }
    .rating-text { font-size: 13px; color: #64748b; margin-left: 6px; font-style: italic;}
    
    .spec-row { display: flex; gap: 16px; font-size: 13px; color: #334155; margin: 6px 0; }
    .spec-row i { color: #475569; margin-right: 4px; }
    
    .facility-row { display: flex; flex-wrap: wrap; gap: 8px; margin: 4px 0 10px 0; }
    .facility-tag { color: #16a34a; font-size: 13px; font-weight: 500; }
    
    .price-footer { display: flex; justify-content: space-between; align-items: flex-end; margin-top: 6px; border-top: 1px solid #f1f5f9; padding-top: 12px; }
    .cashback-box { font-size: 13px; color: #1e3a5f; }
    .cashback-icon { color: #3b82f6; margin-right: 4px; }
    
    .price-box-right { text-align: right; }
    .old-price { font-size: 14px; color: #94a3b8; text-decoration: line-through; }
    .discount-percent { color: #dc2626; background: #fef2f2; padding: 1px 6px; border-radius: 4px; font-size: 12px; margin-left: 4px; font-weight: bold; }
    .new-price { font-size: 22px; font-weight: 700; color: #dc2626; line-height: 1.2; }
    .tax-info { font-size: 12px; color: #64748b; }

    /* ========================================== */
    /* STYLING TOMBOL BOOKING BARU                 */
    /* ========================================== */
    .btn-book-wrapper { display: flex; flex-direction: column; align-items: flex-end; justify-content: flex-end; margin-top: 8px; gap: 4px; }
    .btn-book-villa {
        background: #0f172a; /* Warna hitam kebiruan sesuai tema */
        color: white;
        font-weight: 700;
        font-size: 14px;
        padding: 10px 24px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-block;
        box-shadow: 0 2px 4px rgba(15, 23, 42, 0.1);
    }
    .btn-book-villa:hover {
        background: #1e3a5f;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(15, 23, 42, 0.2);
    }
    .btn-book-villa i { margin-right: 6px; }

    /* Responsive */
    @media (max-width: 768px) {
        .villa-grid-container { grid-template-columns: 1fr; }
        .filter-sidebar { display: none; }
        .villa-card { flex-direction: column; }
        .villa-img { width: 100%; height: 180px; }
        .villa-header { flex-direction: column; }
        .price-footer { flex-direction: column; align-items: flex-start; gap: 10px; }
        .price-box-right { text-align: left; }
        
        /* Tombol booking di mobile full width */
        .btn-book-wrapper { width: 100%; align-items: stretch; }
        .btn-book-villa { text-align: center; }
    }
</style>

<div class="villa-result-wrapper">
    <!-- Header Pencarian -->
    <div class="top-search-summary">
        <div><strong>Jakarta</strong></div>
        <div>Min, 02 Agt 2026 - Sen, 03 Agt 2026 (1 malam)</div>
        <div>1 Dewasa, 0 Anak</div>
    </div>

    <div class="villa-grid-container">
        <!-- SIDEBAR KIRI -->
        <div class="filter-sidebar">
            <div class="filter-title">Promo & Pilihan Spesial</div>
            <div class="filter-chip-group">
                <div class="filter-chip">Diskon s.d. 50%</div>
                <div class="filter-chip">Yang Baru di tiket</div>
                <div class="filter-chip">Villa & Apt. Mewah</div>
            </div>
            <div class="filter-title">Filter Populer di Jakarta</div>
            <div class="filter-chip-group">
                <div class="filter-chip">Rating Villa & Apt. 4 (Awesome)</div>
                <div class="filter-chip">Rating Villa & Apt. 5 (Excellent)</div>
            </div>
        </div>

        <!-- LIST VILLA -->
        <div>
            @foreach($villas as $villa)
            <div class="villa-card">
                <div class="villa-img">
                    <img src="{{ $villa->image }}" style="width:100%; height:100%; object-fit:cover;">
                    <div class="badge-top">{{ $villa->badge }}</div>
                </div>
                <div class="villa-info">
                    <div>
                        <div class="villa-header">
                            <div>
                                <div class="villa-name">{{ $villa->name }}</div>
                                <div class="villa-type">{{ $villa->sub_title }} 
                                    <span class="stars">
                                        @for($i=0; $i<$villa->stars; $i++) ★ @endfor
                                    </span>
                                </div>
                                <div class="rating-container">
                                    <span class="rating-box">{{ $villa->rating }}/5</span>
                                    <span class="rating-text">({{ $villa->reviews }}) "{{ $villa->review_desc }}"</span>
                                </div>
                            </div>
                        </div>

                        <div class="spec-row">
                            <span><i class="fa-solid fa-bed"></i> {{ $villa->rooms }} Kamar</span>
                            <span><i class="fa-solid fa-user"></i> {{ $villa->guests }} Tamu</span>
                            <span><i class="fa-regular fa-square"></i> {{ $villa->area }}</span>
                        </div>

                        <div class="facility-row">
                            @foreach($villa->facilities as $fac)
                                <span class="facility-tag">{{ $fac }}</span>
                            @endforeach
                        </div>
                    </div>

                    <div class="price-footer">
                        <div class="cashback-box">
                            <i class="fa-solid fa-coins cashback-icon"></i> Dapetin hingga Rp {{ number_format($villa->cashback, 0, ',', '.') }} cashback
                        </div>
                        <div class="price-box-right">
                            <div class="old-price">
                                IDR {{ number_format($villa->old_price, 0, ',', '.') }}
                                <span class="discount-percent">{{ $villa->discount }}</span>
                            </div>
                            <div class="new-price">IDR {{ number_format($villa->price, 0, ',', '.') }}</div>
                            <div class="tax-info">(setelah pajak: IDR {{ number_format($villa->tax_price, 0, ',', '.') }})</div>
                            
                            <!-- TOMBOL BOOKING BARU -->
                            <div class="btn-book-wrapper">
                               <a href="{{ route('bookings.create.train') }}" class="btn-book-villa">
                                    <i class="fa-regular fa-circle-check"></i> Booking Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection