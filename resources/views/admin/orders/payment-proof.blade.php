@extends('layouts.app')

@section('title', 'Bukti Pembayaran #' . $order->id . ' - FreshWash Laundry')

@section('content')
<div class="row justify-content-center py-4">
    <div class="col-lg-7">
        <div class="card card-custom p-4 text-center">
            <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                <h3 class="fw-bold text-dark mb-0">Bukti Pembayaran Pesanan #{{ $order->id }}</h3>
                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-theme-outline btn-sm">
                    <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                </a>
            </div>

            @if($order->payment_proof)
                <div class="bg-light p-4 rounded-4 border mb-3">
                    <img src="{{ asset('storage/' . $order->payment_proof) }}" class="img-fluid rounded-3 border shadow-sm" style="max-height: 450px;" alt="Bukti Pembayaran">
                </div>
                <div>
                    <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank" class="btn btn-theme-primary">
                        <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> Buka Gambar Ukuran Penuh
                    </a>
                </div>
            @else
                <div class="alert alert-secondary py-5 rounded-4">
                    <i class="fa-solid fa-image-slash fa-3x mb-3 text-muted d-block"></i>
                    <h5 class="fw-bold">Tidak Ada Bukti Pembayaran</h5>
                    <p class="text-muted mb-0">Pelanggan belum mengunggah foto bukti pembayaran untuk pesanan ini.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
