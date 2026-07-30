@extends('layouts.app')

@section('title', 'Detail Pesanan #' . $order->id . ' - FreshWash Laundry')

@section('content')
<div class="row justify-content-center py-4">
    <div class="col-lg-9">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-muted fw-semibold">
                    <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Dashboard
                </a>
                <h2 class="fw-bold text-dark mt-2 mb-0">Detail Pesanan #{{ $order->id }}</h2>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-theme-outline">
                    <i class="fa-solid fa-pen-to-square me-1"></i> Edit Pesanan
                </a>
            </div>
        </div>

        <div class="row g-4">
            <!-- Informasi Pelanggan -->
            <div class="col-md-6">
                <div class="card card-custom p-4 h-100">
                    <h5 class="fw-bold text-primary mb-3 pb-2 border-bottom">
                        <i class="fa-solid fa-user me-2"></i> Data Pelanggan
                    </h5>
                    <div class="mb-3">
                        <small class="text-muted d-block fs-7">Nama Pelanggan:</small>
                        <span class="h5 fw-bold text-dark">{{ $order->customer->name }}</span>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block fs-7">Nomor Telepon / WhatsApp:</small>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->customer->phone) }}" target="_blank" class="fw-semibold text-primary text-decoration-none">
                            <i class="fa-brands fa-whatsapp text-success me-1"></i> {{ $order->customer->phone }}
                        </a>
                    </div>
                    <div class="mb-0">
                        <small class="text-muted d-block fs-7">Alamat Penjemputan / Pengantaran:</small>
                        <p class="text-dark mb-0">{{ $order->customer->address }}</p>
                    </div>
                </div>
            </div>

            <!-- Detail Layanan & Biaya -->
            <div class="col-md-6">
                <div class="card card-custom p-4 h-100">
                    <h5 class="fw-bold text-primary mb-3 pb-2 border-bottom">
                        <i class="fa-solid fa-receipt me-2"></i> Detail Pengerjaan & Biaya
                    </h5>
                    <div class="row g-3">
                        <div class="col-6">
                            <small class="text-muted d-block fs-7">Jenis Layanan:</small>
                            <span class="badge bg-primary-subtle text-primary fw-bold px-3 py-2 fs-7">{{ $order->service_type }}</span>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block fs-7">Berat Pakaian:</small>
                            <span class="fw-bold text-dark fs-6">{{ $order->weight }} kg</span>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block fs-7">Tanggal Pemesanan:</small>
                            <span class="fw-semibold text-dark">{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</span>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block fs-7">Total Tagihan:</small>
                            <span class="h5 fw-extrabold text-success mb-0">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </div>
                        <div class="col-12 border-top pt-2">
                            <small class="text-muted d-block fs-7 mb-1">Ubah Status Pesanan:</small>
                            <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="d-flex gap-2">
                                @csrf
                                <select name="order_status" class="form-select">
                                    <option value="Baru" {{ $order->order_status == 'Baru' ? 'selected' : '' }}>Baru</option>
                                    <option value="Diproses" {{ $order->order_status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                    <option value="Selesai" {{ $order->order_status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="Diambil" {{ $order->order_status == 'Diambil' ? 'selected' : '' }}>Diambil</option>
                                </select>
                                <button type="submit" class="btn btn-theme-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bukti Pembayaran -->
            <div class="col-12">
                <div class="card card-custom p-4">
                    <h5 class="fw-bold text-primary mb-3 pb-2 border-bottom">
                        <i class="fa-solid fa-file-invoice-dollar me-2"></i> Bukti Pembayaran
                    </h5>
                    @if($order->payment_proof)
                        <div class="text-center bg-light p-4 rounded-4 border">
                            <img src="{{ asset('storage/' . $order->payment_proof) }}" class="img-fluid rounded-3 shadow-sm border mb-3" style="max-height: 380px;" alt="Bukti Pembayaran">
                            <div>
                                <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank" class="btn btn-theme-outline">
                                    <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> Buka Gambar Ukuran Penuh
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-secondary mb-0 rounded-4 text-center py-4">
                            <i class="fa-solid fa-circle-info fa-2x mb-2 d-block text-muted"></i>
                            <span class="fw-semibold">Pelanggan belum mengunggah bukti pembayaran online. (Pembayaran Tunai / Bayar di Tempat)</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
