@extends('layouts.app')

@section('title', 'Edit Pesanan #' . $order->id . ' - FreshWash Laundry')

@section('content')
<div class="row justify-content-center py-4">
    <div class="col-lg-8">
        <div class="card card-custom p-4 p-md-5">
            <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom">
                <div>
                    <h2 class="fw-bold text-dark mb-0">Edit Pesanan #{{ $order->id }}</h2>
                    <p class="text-muted mb-0">Ubah data pelanggan atau rincian pengerjaan laundry</p>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-theme-outline">
                    <i class="fa-solid fa-arrow-left me-1"></i> Batal
                </a>
            </div>

            @if($errors->any())
                <div class="alert alert-danger rounded-4 mb-4">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.orders.update', $order) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <h5 class="fw-bold text-primary mb-3">
                    <i class="fa-solid fa-user me-2"></i> Data Pelanggan
                </h5>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Pelanggan</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $order->customer->name) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nomor Telepon / HP</label>
                        <input type="tel" name="phone" class="form-control" value="{{ old('phone', $order->customer->phone) }}" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Alamat</label>
                        <textarea name="address" class="form-control" rows="2" required>{{ old('address', $order->customer->address) }}</textarea>
                    </div>
                </div>

                <h5 class="fw-bold text-primary mb-3 pt-3 border-top">
                    <i class="fa-solid fa-shirt me-2"></i> Rincian Pengerjaan Laundry
                </h5>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Jenis Layanan</label>
                        <select name="service_type" class="form-select bg-light" required>
                            <option value="Cuci Kering" {{ $order->service_type == 'Cuci Kering' ? 'selected' : '' }}>Cuci Kering (Rp 12.000 / kg)</option>
                            <option value="Cuci Setrika" {{ $order->service_type == 'Cuci Setrika' ? 'selected' : '' }}>Cuci Setrika (Rp 15.000 / kg)</option>
                            <option value="Cuci Basah" {{ $order->service_type == 'Cuci Basah' ? 'selected' : '' }}>Cuci Basah (Rp 10.000 / kg)</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Berat (kg)</label>
                        <input type="number" name="weight" step="0.1" min="0.5" class="form-control bg-light" value="{{ old('weight', $order->weight) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Status Pesanan</label>
                        <select name="order_status" class="form-select bg-light" required>
                            <option value="Baru" {{ $order->order_status == 'Baru' ? 'selected' : '' }}>Baru</option>
                            <option value="Diproses" {{ $order->order_status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="Selesai" {{ $order->order_status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="Diambil" {{ $order->order_status == 'Diambil' ? 'selected' : '' }}>Diambil</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Tanggal Pemesanan</label>
                        <input type="date" name="order_date" class="form-control bg-light" value="{{ old('order_date', $order->order_date) }}" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Ganti Bukti Pembayaran (Opsional)</label>
                        <input type="file" name="payment_proof" class="form-control" accept="image/png,image/jpeg">
                        @if($order->payment_proof)
                            <small class="text-muted d-block mt-1">Bukti bayar saat ini: <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank">Lihat foto</a></small>
                        @endif
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-theme-outline">Batal</a>
                    <button type="submit" class="btn btn-theme-primary btn-lg">
                        <i class="fa-solid fa-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
