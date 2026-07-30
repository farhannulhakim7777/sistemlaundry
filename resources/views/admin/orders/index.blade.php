@extends('layouts.app')

@section('title', 'Dashboard Admin - FreshWash Laundry')

@section('content')
<!-- Header Dashboard -->
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h2 class="fw-bold text-dark mb-0">Dashboard Kelola Pesanan</h2>
        <p class="text-muted mb-0">Selamat datang kembali, <strong class="text-primary">{{ session('admin_name', 'Admin') }}</strong></p>
    </div>
    <a href="{{ route('order.create') }}" class="btn btn-theme-primary">
        <i class="fa-solid fa-plus me-1"></i> Tambah Pesanan Baru
    </a>
</div>

<!-- Stat Metric Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-3">
        <div class="card card-custom p-3 border-0 bg-white shadow-sm">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fs-7 font-weight-bold d-block">TOTAL PESANAN</span>
                    <h3 class="fw-extrabold text-dark mb-0">{{ $stats['total'] }}</h3>
                </div>
                <div class="rounded-circle bg-primary-subtle text-primary p-3">
                    <i class="fa-solid fa-boxes-packing fa-lg"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card card-custom p-3 border-0 bg-white shadow-sm">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fs-7 font-weight-bold d-block">TOTAL PENDAPATAN</span>
                    <h4 class="fw-extrabold text-success mb-0">Rp {{ number_format($stats['revenue'], 0, ',', '.') }}</h4>
                </div>
                <div class="rounded-circle bg-success-subtle text-success p-3">
                    <i class="fa-solid fa-wallet fa-lg"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card card-custom p-3 border-0 bg-white shadow-sm">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fs-7 font-weight-bold d-block">PESANAN BARU</span>
                    <h3 class="fw-extrabold text-info mb-0">{{ $stats['baru'] }}</h3>
                </div>
                <div class="rounded-circle bg-info-subtle text-info p-3">
                    <i class="fa-solid fa-bell fa-lg"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card card-custom p-3 border-0 bg-white shadow-sm">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fs-7 font-weight-bold d-block">SEDANG DIPROSES</span>
                    <h3 class="fw-extrabold text-warning mb-0">{{ $stats['diproses'] }}</h3>
                </div>
                <div class="rounded-circle bg-warning-subtle text-warning p-3">
                    <i class="fa-solid fa-arrows-spin fa-lg"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter & Search Controls -->
<div class="card card-custom p-4 mb-4">
    <form action="{{ route('admin.dashboard') }}" method="GET" class="row g-3 align-items-center">
        <div class="col-md-6">
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-sm {{ !$statusFilter ? 'btn-primary' : 'btn-outline-secondary' }} rounded-pill">
                    Semua ({{ $stats['total'] }})
                </a>
                <a href="{{ route('admin.dashboard', ['status' => 'Baru', 'search' => $searchQuery]) }}" class="btn btn-sm {{ $statusFilter == 'Baru' ? 'btn-primary' : 'btn-outline-primary' }} rounded-pill">
                    Baru ({{ $stats['baru'] }})
                </a>
                <a href="{{ route('admin.dashboard', ['status' => 'Diproses', 'search' => $searchQuery]) }}" class="btn btn-sm {{ $statusFilter == 'Diproses' ? 'btn-warning text-dark' : 'btn-outline-warning text-dark' }} rounded-pill">
                    Diproses ({{ $stats['diproses'] }})
                </a>
                <a href="{{ route('admin.dashboard', ['status' => 'Selesai', 'search' => $searchQuery]) }}" class="btn btn-sm {{ $statusFilter == 'Selesai' ? 'btn-success' : 'btn-outline-success' }} rounded-pill">
                    Selesai ({{ $stats['selesai'] }})
                </a>
                <a href="{{ route('admin.dashboard', ['status' => 'Diambil', 'search' => $searchQuery]) }}" class="btn btn-sm {{ $statusFilter == 'Diambil' ? 'btn-purple text-white' : 'btn-outline-secondary' }} rounded-pill" style="{{ $statusFilter == 'Diambil' ? 'background: #8b5cf6;' : '' }}">
                    Diambil ({{ $stats['diambil'] }})
                </a>
            </div>
        </div>
        <div class="col-md-6">
            <div class="input-group">
                <input type="hidden" name="status" value="{{ $statusFilter }}">
                <input type="text" name="search" class="form-control" placeholder="Cari nama pelanggan, no HP, atau ID..." value="{{ $searchQuery }}">
                <button type="submit" class="btn btn-theme-primary">
                    <i class="fa-solid fa-search me-1"></i> Cari
                </button>
                @if($searchQuery || $statusFilter)
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary" title="Reset Filter">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </div>
        </div>
    </form>
</div>

<!-- Table Pesanan -->
<div class="card card-custom overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="py-3 px-3">ID</th>
                    <th class="py-3">Pelanggan</th>
                    <th class="py-3">Layanan</th>
                    <th class="py-3">Berat</th>
                    <th class="py-3">Total Harga</th>
                    <th class="py-3">Bukti Bayar</th>
                    <th class="py-3">Status</th>
                    <th class="py-3 px-3 text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td class="px-3 fw-bold text-primary">#{{ $order->id }}</td>
                        <td>
                            <div class="fw-bold text-dark">{{ $order->customer->name }}</div>
                            <small class="text-muted"><i class="fa-solid fa-phone text-xs me-1"></i>{{ $order->customer->phone }}</small>
                        </td>
                        <td><span class="badge bg-light text-dark border">{{ $order->service_type }}</span></td>
                        <td><strong class="text-dark">{{ $order->weight }}</strong> kg</td>
                        <td class="fw-bold text-success">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td>
                            @if($order->payment_proof)
                                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-2 py-1 fs-7" data-bs-toggle="modal" data-bs-target="#proofModal{{ $order->id }}">
                                    <i class="fa-solid fa-image me-1"></i> Lihat Foto
                                </button>

                                <!-- Modal Bukti Bayar -->
                                <div class="modal fade" id="proofModal{{ $order->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content rounded-4 border-0">
                                            <div class="modal-header">
                                                <h5 class="modal-header-title fw-bold mb-0">Bukti Pembayaran Pesanan #{{ $order->id }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-center p-4">
                                                <img src="{{ asset('storage/' . $order->payment_proof) }}" class="img-fluid rounded-3 border" style="max-height: 400px;" alt="Bukti Pembayaran">
                                            </div>
                                            <div class="modal-footer">
                                                <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank" class="btn btn-theme-outline btn-sm">
                                                    <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> Buka Ukuran Penuh
                                                </a>
                                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary fs-7">Belum Upload</span>
                            @endif
                        </td>
                        <td>
                            <!-- Quick Status Updater Dropdown Form -->
                            <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="d-inline">
                                @csrf
                                <select name="order_status" class="form-select form-select-sm status-pill status-{{ strtolower($order->order_status) }} border-0 cursor-pointer" onchange="this.form.submit()">
                                    <option value="Baru" {{ $order->order_status == 'Baru' ? 'selected' : '' }}>Baru</option>
                                    <option value="Diproses" {{ $order->order_status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                    <option value="Selesai" {{ $order->order_status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="Diambil" {{ $order->order_status == 'Diambil' ? 'selected' : '' }}>Diambil</option>
                                </select>
                            </form>
                        </td>
                        <td class="px-3 text-end">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-outline-info" title="Detail Pesanan">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-outline-warning" title="Edit Pesanan">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Hapus pesanan #{{ $order->id }} secara permanen?')" title="Hapus">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-inbox fa-2x mb-3 d-block"></i>
                            <p class="mb-0 fw-semibold">Belum ada data pesanan yang sesuai.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($orders->hasPages())
        <div class="p-3 border-top d-flex justify-content-end">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
