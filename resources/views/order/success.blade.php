@extends('layouts.app')

@section('title', 'Pesanan Berhasil - FreshWash Laundry')

@section('content')
<div class="row justify-content-center py-4">
    <div class="col-lg-7">
        <div class="card card-custom p-4 p-md-5 text-center">
            <div class="rounded-circle bg-success-subtle text-success mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; font-size: 2.5rem;">
                <i class="fa-solid fa-circle-check"></i>
            </div>

            <h2 class="fw-bold text-dark mb-1">Pesanan Anda Berhasil dibuat!</h2>
            <p class="text-muted mb-4">Simpan ID Pesanan Anda untuk melakukan pengecekan status laundry.</p>

            <div class="bg-light border rounded-4 p-4 text-start mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                    <div>
                        <small class="text-muted d-block text-uppercase fw-bold fs-7">ID PESANAN</small>
                        <span class="h4 fw-extrabold text-primary mb-0">#{{ $order->id }}</span>
                    </div>
                    <div class="text-end">
                        <small class="text-muted d-block text-uppercase fw-bold fs-7">STATUS</small>
                        <span class="status-pill status-baru">
                            <i class="fa-solid fa-clock"></i> {{ $order->order_status }}
                        </span>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-sm-6">
                        <small class="text-muted d-block fs-7">Nama Pelanggan:</small>
                        <strong class="text-dark">{{ $order->customer->name }}</strong>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-muted d-block fs-7">Nomor Telepon:</small>
                        <strong class="text-dark">{{ $order->customer->phone }}</strong>
                    </div>
                    <div class="col-12">
                        <small class="text-muted d-block fs-7">Alamat Penjemputan:</small>
                        <span class="text-dark">{{ $order->customer->address }}</span>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-muted d-block fs-7">Jenis Layanan:</small>
                        <strong class="text-dark">{{ $order->service_type }}</strong>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-muted d-block fs-7">Berat Pakaian:</small>
                        <strong class="text-dark">{{ $order->weight }} kg</strong>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-muted d-block fs-7">Tanggal Pemesanan:</small>
                        <strong class="text-dark">{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</strong>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-muted d-block fs-7">Total Biaya:</small>
                        <strong class="text-primary fs-5">Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong>
                    </div>
                    <div class="col-12">
                        <small class="text-muted d-block fs-7">Bukti Pembayaran:</small>
                        @if($order->payment_proof)
                            <span class="badge bg-success-subtle text-success fw-bold"><i class="fa-solid fa-image me-1"></i> Telah Diunggah</span>
                        @else
                            <span class="badge bg-secondary-subtle text-secondary fw-bold"><i class="fa-solid fa-circle-minus me-1"></i> Belum Diunggah (Bayar di tempat)</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                <a href="{{ route('order.track', ['query' => $order->id]) }}" class="btn btn-theme-primary btn-lg">
                    <i class="fa-solid fa-magnifying-glass me-2"></i> Lacak Status Pesanan Ini
                </a>
                <a href="{{ route('home') }}" class="btn btn-theme-outline btn-lg">
                    <i class="fa-solid fa-house me-2"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
