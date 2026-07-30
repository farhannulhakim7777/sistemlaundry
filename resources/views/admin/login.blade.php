@extends('layouts.app')

@section('title', 'Login Admin - FreshWash Laundry')

@section('content')
<div class="row justify-content-center py-5">
    <div class="col-md-6 col-lg-5">
        <div class="card card-custom p-4 p-md-5">
            <div class="text-center mb-4">
                <div class="brand-icon bg-primary text-white mx-auto mb-3" style="width: 56px; height: 56px; font-size: 1.5rem;">
                    <i class="fa-solid fa-user-gear"></i>
                </div>
                <h3 class="fw-bold text-dark mb-1">Login Admin</h3>
                <p class="text-muted fs-7">Masuk untuk mengelola pesanan & status pelanggan</p>
            </div>

            @if($errors->any())
                <div class="alert alert-danger rounded-4 mb-4">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <div>{{ $errors->first() }}</div>
                    </div>
                </div>
            @endif

            <form action="{{ route('admin.login.post') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">Username</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fa-solid fa-user text-muted"></i></span>
                        <input type="text" name="username" class="form-control" value="{{ old('username', 'admin') }}" placeholder="Masukkan username" required autofocus>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fa-solid fa-key text-muted"></i></span>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required>
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                            <i class="fa-solid fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-theme-primary btn-lg w-100 mb-3">
                    <i class="fa-solid fa-right-to-bracket me-2"></i> Masuk Dashboard
                </button>
            </form>

            <div class="bg-light p-3 rounded-4 text-center border">
                <small class="text-muted d-block fw-semibold mb-1"><i class="fa-solid fa-info-circle me-1"></i> Default Akun Admin:</small>
                <code class="text-primary fw-bold">Username: admin | Password: admin123</code>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');

        if (togglePassword) {
            togglePassword.addEventListener('click', function () {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                toggleIcon.classList.toggle('fa-eye');
                toggleIcon.classList.toggle('fa-eye-slash');
            });
        }
    });
</script>
@endpush
