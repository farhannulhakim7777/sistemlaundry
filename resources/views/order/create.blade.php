@extends('layouts.app')

@section('title', 'Form Pemesanan Laundry - FreshWash Laundry')

@section('content')
<div class="row justify-content-center py-4">
    <div class="col-lg-8">
        <div class="card card-custom p-4 p-md-5">
            <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
                <div class="brand-icon">
                    <i class="fa-solid fa-basket-shopping"></i>
                </div>
                <div>
                    <h2 class="fw-bold text-dark mb-0">Form Pemesanan Laundry</h2>
                    <p class="text-muted mb-0">Lengkapi data diri dan detail laundry Anda di bawah ini</p>
                </div>
            </div>

            @if($errors->any())
                <div class="alert alert-danger rounded-4 mb-4">
                    <div class="fw-bold mb-2"><i class="fa-solid fa-circle-exclamation me-1"></i> Terjadi kesalahan input:</div>
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('order.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <h5 class="fw-bold text-primary mb-3">
                    <i class="fa-solid fa-user me-2"></i> Information Pelanggan
                </h5>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fa-solid fa-user-tag text-muted"></i></span>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Masukkan nama Anda" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nomor WhatsApp / HP <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fa-solid fa-phone text-muted"></i></span>
                            <input type="tel" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Alamat Lengkap Penjemputan / Pengantaran <span class="text-danger">*</span></label>
                        <textarea name="address" class="form-control" rows="3" placeholder="Tuliskan alamat lengkap Anda..." required>{{ old('address') }}</textarea>
                    </div>
                </div>

                <h5 class="fw-bold text-primary mb-3 pt-3 border-top">
                    <i class="fa-solid fa-shirt me-2"></i> Detail Layanan & Berat
                </h5>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Jenis Layanan Laundry <span class="text-danger">*</span></label>
                        <select name="service_type" id="service_type" class="form-select bg-light" required>
                            <option value="">-- Pilih Jenis Layanan --</option>
                            <option value="Cuci Kering" data-price="12000" {{ old('service_type') == 'Cuci Kering' ? 'selected' : '' }}>
                                Cuci Kering (Rp 12.000 / kg)
                            </option>
                            <option value="Cuci Setrika" data-price="15000" {{ old('service_type') == 'Cuci Setrika' ? 'selected' : '' }}>
                                Cuci Setrika (Rp 15.000 / kg)
                            </option>
                            <option value="Cuci Basah" data-price="10000" {{ old('service_type') == 'Cuci Basah' ? 'selected' : '' }}>
                                Cuci Basah (Rp 10.000 / kg)
                            </option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Perkiraan Berat (kg) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" name="weight" id="weight" min="0.5" step="0.1" class="form-control bg-light" value="{{ old('weight', '1.0') }}" placeholder="1.0" required>
                            <span class="input-group-text bg-light font-weight-bold">kg</span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Tanggal Pemesanan <span class="text-danger">*</span></label>
                        <input type="date" name="order_date" class="form-control bg-light" value="{{ old('order_date', now()->toDateString()) }}" required>
                    </div>

                    <!-- Live Calculated Price Card -->
                    <div class="col-md-6">
                        <div class="card bg-primary-subtle border-primary p-3 rounded-4 h-100 d-flex justify-content-center">
                            <span class="text-muted fs-7 font-weight-bold">ESTIMASI TOTAL BIAYA</span>
                            <div class="h3 fw-extrabold text-primary mb-0" id="total_price_display">
                                Rp 0
                            </div>
                            <small class="text-muted">*Harga akhir akan dikonfirmasi ulang saat penimbangan resmi.</small>
                        </div>
                    </div>
                </div>

                <h5 class="fw-bold text-primary mb-3 pt-3 border-top">
                    <i class="fa-solid fa-file-invoice-dollar me-2"></i> Bukti Pembayaran (Opsional)
                </h5>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Unggah Bukti Transfer / Pembayaran</label>
                    <input type="file" name="payment_proof" id="payment_proof" class="form-control" accept="image/png,image/jpeg">
                    <div class="form-text">Format yang diperbolehkan: JPG, JPEG, PNG (Maksimal 2 MB).</div>

                    <div id="image_preview_wrapper" class="mt-3 d-none">
                        <label class="form-label fw-semibold fs-7 text-muted">Preview Gambar Bukti Bayar:</label>
                        <div class="border rounded-4 p-2 d-inline-block bg-light">
                            <img id="image_preview" src="#" alt="Preview Bukti Bayar" style="max-height: 180px; max-width: 100%; border-radius: 8px;" />
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                    <a href="{{ route('home') }}" class="btn btn-theme-outline">
                        <i class="fa-solid fa-arrow-left me-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-theme-primary btn-lg">
                        <i class="fa-solid fa-paper-plane me-2"></i> Simpan & Kirim Pesanan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const serviceSelect = document.getElementById('service_type');
        const weightInput = document.getElementById('weight');
        const totalPriceDisplay = document.getElementById('total_price_display');
        const paymentProofInput = document.getElementById('payment_proof');
        const previewWrapper = document.getElementById('image_preview_wrapper');
        const previewImg = document.getElementById('image_preview');

        function calculatePrice() {
            const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
            const pricePerKg = parseFloat(selectedOption.getAttribute('data-price')) || 0;
            const weight = parseFloat(weightInput.value) || 0;
            const total = pricePerKg * weight;

            totalPriceDisplay.textContent = 'Rp ' + Math.round(total).toLocaleString('id-ID');
        }

        serviceSelect.addEventListener('change', calculatePrice);
        weightInput.addEventListener('input', calculatePrice);
        calculatePrice(); // Initial trigger

        // Live image preview
        paymentProofInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImg.src = e.target.result;
                    previewWrapper.classList.remove('d-none');
                }
                reader.readAsDataURL(file);
            } else {
                previewWrapper.classList.add('d-none');
            }
        });
    });
</script>
@endpush
