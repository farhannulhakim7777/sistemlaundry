@extends('layouts.app')

@section('title', 'Beranda - FreshWash Laundry')

@section('content')
<div class="row align-items-center py-5">
    <div class="col-lg-7 mb-4 mb-lg-0">
        <span class="badge bg-primary-subtle text-primary fw-bold px-3 py-2 rounded-pill mb-3">
            <i class="fa-solid fa-sparkles me-1"></i> Solusi Laundry Praktis & Terpercaya
        </span>
        <h1 class="display-4 fw-extrabold text-dark mb-3">
            Layanan Laundry <span class="text-primary">Bersih, Rapih & Wangi</span> Kapan Saja
        </h1>
        <p class="lead text-muted mb-4">
            Nikmati kemudahan pesan laundry online. Bebas antre, harga terjangkau, dan dapatkan kepastian status pengerjaan pakaian kamu secara real-time.
        </p>

        <div class="d-flex flex-wrap gap-3 mb-4">
            <a href="{{ route('order.create') }}" class="btn btn-theme-primary btn-lg">
                <i class="fa-solid fa-basket-shopping me-2"></i> Pesan Laundry Sekarang
            </a>
            <a href="{{ route('order.track') }}" class="btn btn-theme-outline btn-lg">
                <i class="fa-solid fa-magnifying-glass me-2"></i> Cek Status Pesanan
            </a>
        </div>

        <!-- Highlights -->
        <div class="row g-3 pt-3 border-top">
            <div class="col-sm-4">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle bg-success-subtle text-success p-2">
                        <i class="fa-solid fa-clock fa-fw"></i>
                    </div>
                    <span class="fw-semibold text-dark fs-7">Proses Cepat 1 Hari</span>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle bg-primary-subtle text-primary p-2">
                        <i class="fa-solid fa-shield-halved fa-fw"></i>
                    </div>
                    <span class="fw-semibold text-dark fs-7">Pakaian Diuji Higienis</span>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle bg-info-subtle text-info p-2">
                        <i class="fa-solid fa-coins fa-fw"></i>
                    </div>
                    <span class="fw-semibold text-dark fs-7">Harga Terjangkau</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card card-custom p-4 bg-white shadow-lg border-0">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="brand-icon bg-primary text-white">
                    <i class="fa-solid fa-receipt"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-0">Cek Status Pesanan Cepat</h5>
                    <small class="text-muted">Masukkan ID Pesanan atau Nomor HP</small>
                </div>
            </div>

            <form action="{{ route('order.track.search') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark fs-7">ID Pesanan / No. Telepon</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-search"></i></span>
                        <input type="text" name="query" class="form-control border-start-0 bg-light" placeholder="Contoh: 101 atau 08123456789" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-theme-primary w-100">
                    <i class="fa-solid fa-magnifying-glass me-2"></i> Lacak Status Laundry
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Layanan & Daftar Harga -->
<div class="py-5">
    <div class="text-center mb-5">
        <span class="badge bg-info-subtle text-info fw-bold px-3 py-2 rounded-pill mb-2">Pilihan Paket</span>
        <h2 class="fw-bold text-dark">Daftar Layanan & Tariff Laundry</h2>
        <p class="text-muted">Pilih jenis cuci sesuai kebutuhan pakaian kesayangan Anda.</p>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card card-custom card-custom-hover h-100 p-4 text-center">
                <div class="rounded-circle bg-primary-subtle text-primary mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 64px; height: 64px; font-size: 1.6rem;">
                    <i class="fa-solid fa-wind"></i>
                </div>
                <h4 class="fw-bold mb-2">Cuci Kering</h4>
                <div class="display-6 fw-extrabold text-primary mb-3">
                    Rp 12.000 <span class="fs-6 text-muted font-normal">/ kg</span>
                </div>
                <p class="text-muted fs-7 mb-4">Pencucian bersih maksimal dengan pengering mesin modern hingga bebas kelembaban.</p>
                <a href="{{ route('order.create') }}" class="btn btn-theme-outline w-100 mt-auto">Pilih Cuci Kering</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-custom card-custom-hover h-100 p-4 text-center border-primary position-relative" style="box-shadow: 0 10px 30px rgba(79, 70, 229, 0.15);">
                <span class="position-absolute top-0 start-50 translate-middle badge rounded-pill bg-primary px-3 py-2">
                    <i class="fa-solid fa-star me-1"></i> Paling Populer
                </span>
                <div class="rounded-circle bg-primary text-white mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 64px; height: 64px; font-size: 1.6rem;">
                    <i class="fa-solid fa-shirt"></i>
                </div>
                <h4 class="fw-bold mb-2">Cuci Setrika</h4>
                <div class="display-6 fw-extrabold text-primary mb-3">
                    Rp 15.000 <span class="fs-6 text-muted font-normal">/ kg</span>
                </div>
                <p class="text-muted fs-7 mb-4">Pakaian dicuci, dikeringkan, distrika rapi, dan diberi pewangi premium siap pakai.</p>
                <a href="{{ route('order.create') }}" class="btn btn-theme-primary w-100 mt-auto">Pilih Cuci Setrika</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-custom card-custom-hover h-100 p-4 text-center">
                <div class="rounded-circle bg-info-subtle text-info mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 64px; height: 64px; font-size: 1.6rem;">
                    <i class="fa-solid fa-soap"></i>
                </div>
                <h4 class="fw-bold mb-2">Cuci Basah</h4>
                <div class="display-6 fw-extrabold text-primary mb-3">
                    Rp 10.000 <span class="fs-6 text-muted font-normal">/ kg</span>
                </div>
                <p class="text-muted fs-7 mb-4">Pencucian higienis dengan detergen pilihan, siap Anda keringkan sendiri di rumah.</p>
                <a href="{{ route('order.create') }}" class="btn btn-theme-outline w-100 mt-auto">Pilih Cuci Basah</a>
            </div>
        </div>
    </div>
</div>

<!-- Alur Pemesanan -->
<div class="py-5 bg-white rounded-4 p-4 p-md-5 my-4 border">
    <div class="text-center mb-5">
        <h3 class="fw-bold text-dark">Cara Mudah Pesan Laundry</h3>
        <p class="text-muted">Hanya butuh 3 langkah praktis</p>
    </div>

    <div class="row g-4">
        <div class="col-md-4 text-center">
            <div class="mb-3">
                <span class="badge rounded-circle bg-primary text-white p-3 fs-5" style="width: 50px; height: 50px;">1</span>
            </div>
            <h5 class="fw-bold mb-2">Isi Form Online</h5>
            <p class="text-muted fs-7">Masukkan data nama, nomor HP, alamat, serta jenis layanan laundry yang Anda butuhkan.</p>
        </div>

        <div class="col-md-4 text-center">
            <div class="mb-3">
                <span class="badge rounded-circle bg-primary text-white p-3 fs-5" style="width: 50px; height: 50px;">2</span>
            </div>
            <h5 class="fw-bold mb-2">Proses & Pengerjaan</h5>
            <p class="text-muted fs-7">Bawa / kirim pakaian Anda. Tim kami akan menimbang & memproses dengan standar kebersihan tinggi.</p>
        </div>

        <div class="col-md-4 text-center">
            <div class="mb-3">
                <span class="badge rounded-circle bg-primary text-white p-3 fs-5" style="width: 50px; height: 50px;">3</span>
            </div>
            <h5 class="fw-bold mb-2">Selesai & Diambil</h5>
            <p class="text-muted fs-7">Pantau status laundry Anda di fitur pelacakan dan ambil pakaian segar Anda yang telah siap.</p>
        </div>
    </div>
</div>
@endsection
