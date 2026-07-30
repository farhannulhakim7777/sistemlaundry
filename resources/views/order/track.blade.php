@extends('layouts.app')

@section('title', 'Cek Status Pesanan - FreshWash Laundry')

@section('content')
<div class="row justify-content-center py-4">
    <div class="col-lg-9">
        <!-- Card Form Pencarian -->
        <div class="card card-custom p-4 mb-4">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="brand-icon bg-primary text-white">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <div>
                    <h3 class="fw-bold text-dark mb-0">Cek Status Laundry</h3>
                    <p class="text-muted mb-0">Masukkan ID Pesanan atau Nomor HP yang Anda daftarkan saat memesan</p>
                </div>
            </div>

            <form action="{{ route('order.track.search') }}" method="POST">
                @csrf
                <div class="row g-2">
                    <div class="col-md-9">
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-search"></i></span>
                            <input type="text" name="query" class="form-control border-start-0 bg-light" value="{{ $query ?? '' }}" placeholder="Masukkan ID Pesanan (cth: 1) atau No HP..." required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-theme-primary btn-lg w-100 h-100">
                            Cari Pesanan
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Hasil Pencarian -->
        @if($query)
            <div class="mb-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold text-dark mb-0">Hasil Pencarian untuk "{{ $query }}":</h5>
                <span class="badge bg-primary rounded-pill">{{ $orders->count() }} Pesanan Ditemukan</span>
            </div>

            @forelse($orders as $order)
                @php
                    $statuses = ['Baru', 'Diproses', 'Selesai', 'Diambil'];
                    $currentIndex = array_search($order->order_status, $statuses);
                    if ($currentIndex === false) $currentIndex = 0;
                @endphp

                <div class="card card-custom p-4 mb-4 border-start border-4 border-primary">
                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-3 border-bottom gap-2">
                        <div>
                            <span class="text-muted fs-7 d-block">ID PESANAN</span>
                            <h4 class="fw-extrabold text-primary mb-0">#{{ $order->id }}</h4>
                        </div>
                        <div>
                            <span class="text-muted fs-7 d-block text-end">STATUS SAAT INI</span>
                            <span class="status-pill status-{{ strtolower($order->order_status) }}">
                                <i class="fa-solid fa-circle-dot"></i> {{ $order->order_status }}
                            </span>
                        </div>
                    </div>

                    <!-- Progress Step Indicator Bar -->
                    <div class="py-3 mb-4 bg-light rounded-4 px-3">
                        <div class="row text-center position-relative">
                            @foreach($statuses as $index => $statusName)
                                @php
                                    $isPassed = $index <= $currentIndex;
                                    $isCurrent = $index == $currentIndex;
                                @endphp
                                <div class="col-3">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center mb-2 {{ $isPassed ? 'bg-primary text-white shadow-sm' : 'bg-secondary-subtle text-muted' }}" style="width: 40px; height: 40px; font-weight: 700;">
                                            @if($isPassed && !$isCurrent)
                                                <i class="fa-solid fa-check"></i>
                                            @else
                                                {{ $index + 1 }}
                                            @endif
                                        </div>
                                        <span class="fw-bold fs-7 {{ $isCurrent ? 'text-primary' : ($isPassed ? 'text-dark' : 'text-muted') }}">
                                            {{ $statusName }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Details Table -->
                    <div class="row g-3">
                        <div class="col-sm-6 col-md-3">
                            <small class="text-muted d-block fs-7">Nama Pelanggan:</small>
                            <strong class="text-dark">{{ $order->customer->name }}</strong>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <small class="text-muted d-block fs-7">Telepon:</small>
                            <strong class="text-dark">{{ $order->customer->phone }}</strong>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <small class="text-muted d-block fs-7">Jenis Layanan:</small>
                            <strong class="text-dark">{{ $order->service_type }}</strong>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <small class="text-muted d-block fs-7">Berat Laundry:</small>
                            <strong class="text-dark">{{ $order->weight }} kg</strong>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <small class="text-muted d-block fs-7">Tanggal Masuk:</small>
                            <strong class="text-dark">{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</strong>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <small class="text-muted d-block fs-7">Total Harga:</small>
                            <strong class="text-primary fs-6">Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block fs-7">Alamat Penjemputan:</small>
                            <span class="text-dark">{{ $order->customer->address }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="card card-custom p-5 text-center">
                    <div class="text-muted mb-3" style="font-size: 3rem;">
                        <i class="fa-solid fa-folder-open"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-2">Pesanan Tidak Ditemukan</h4>
                    <p class="text-muted">Tidak ada data pesanan yang cocok dengan "{{ $query }}". Pastikan ID Pesanan atau Nomor HP sudah benar.</p>
                </div>
            @endforelse
        @endif
    </div>
</div>
@endsection
