@extends('layouts.app_fix')

@section('content')
<div class="main-content">
    <section class="section">
        <!-- Header -->
        <div class="section-header">
            <h1>Edit Profile</h1>
        </div>

        <div class="section-body">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <!-- Card -->
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white">
                            <h4 class="mb-0">
                                <i class="fa-solid fa-user-circle me-2"></i> Edit Profile
                            </h4>
                        </div>

                        <div class="card-body">
                            <!-- Success Alert -->
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- Foto Profile -->
<div class="text-center mb-4">
  <img src="{{ $user->profile_url }}" 
       class="rounded-circle"
       style="width:120px; height:120px; object-fit: cover; object-position: center;">


                                    <div class="mt-2">
                                        <input type="file" name="profile_pic"
                                               class="form-control @error('profile_pic') is-invalid @enderror">
                                        @error('profile_pic')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Kiri -->
                                    <div class="col-md-6">
                                        <!-- Nama -->
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Nama</label>
                                            <input type="text" id="name" name="name" 
                                                   value="{{ old('name', $user->name) }}" 
                                                   class="form-control @error('name') is-invalid @enderror" 
                                                   required>
                                            @error('name')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Email -->
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" id="email" name="email" 
                                                   value="{{ old('email', $user->email) }}" 
                                                   class="form-control @error('email') is-invalid @enderror" 
                                                   required>
                                            @error('email')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Phone Number -->
                                        <div class="mb-3">
                                            <label for="phone_number" class="form-label">Nomor HP</label>
                                            <input type="text" id="phone_number" name="phone_number" 
                                                   value="{{ old('phone_number', $user->phone_number) }}" 
                                                   class="form-control @error('phone_number') is-invalid @enderror"
                                                   placeholder="0812xxxx">
                                            @error('phone_number')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Date of Birth -->
                                        <div class="mb-3">
                                            <label for="date_of_birth" class="form-label">Tanggal Lahir</label>
                                            <input type="date" id="date_of_birth" name="date_of_birth" 
                                                   value="{{ old('date_of_birth', $user->date_of_birth) }}" 
                                                   class="form-control @error('date_of_birth') is-invalid @enderror">
                                            @error('date_of_birth')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Kanan -->
                                    <div class="col-md-6">
                                        <!-- Address -->
                                        <div class="mb-3">
                                            <label for="address" class="form-label">Alamat</label>
                                            <textarea id="address" name="address" rows="5" 
                                                      class="form-control @error('address') is-invalid @enderror"
                                                      placeholder="Jl. Contoh No. 123">{{ old('address', $user->address) }}</textarea>
                                            @error('address')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Password -->
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password Baru (Opsional)</label>
                                            <input type="password" id="password" name="password" 
                                                   class="form-control @error('password') is-invalid @enderror"
                                                   placeholder="Kosongkan jika tidak ingin ganti">
                                            @error('password')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                            <input type="password" id="password_confirmation" name="password_confirmation" 
                                                   class="form-control"
                                                   placeholder="Ulangi password baru">
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="mt-4 text-end">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fa-solid fa-save me-1"></i> Simpan Perubahan
                                    </button>
                                    <a href="{{ url()->previous() }}" class="btn btn-secondary">
                                        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- End Card -->
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
