@extends('layouts.app_fix')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ isset($user) ? 'Edit User' : 'Tambah User' }}</h1>
        </div>

        <div class="section-body">

            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-user-plus me-2"></i>
                        {{ isset($user) ? 'Edit User' : 'Tambah User' }}
                    </h4>
                </div>

                <div class="card-body">
                    <form 
                        action="{{ isset($user) ? route('admin.user.update', $user->id) : route('admin.user.store') }}" 
                        method="POST" 
                        enctype="multipart/form-data">

                        @csrf
                        @if(isset($user))
                            @method('PUT')
                        @endif

                        {{-- NAMA --}}
                        <div class="mb-3">
                            <label class="form-label">Nama User</label>
                            <input type="text" name="name" 
                                value="{{ old('name', $user->name ?? '') }}" 
                                placeholder="Masukkan Nama User"
                                class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- EMAIL --}}
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" 
                                value="{{ old('email', $user->email ?? '') }}" 
                                placeholder="Masukkan Email"
                                class="form-control @error('email') is-invalid @enderror">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- PASSWORD --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    Password {{ isset($user) ? '(Kosongkan jika tidak diganti)' : '' }}
                                </label>
                                <input type="password" name="password" 
                                    placeholder="Masukkan Password"
                                    class="form-control @error('password') is-invalid @enderror">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" 
                                    placeholder="Masukkan Konfirmasi Password"
                                    class="form-control">
                            </div>
                        </div>

                        {{-- ROLE --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Role</label>
                            <div>
                                @foreach ($roles as $role)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" 
                                            type="checkbox" 
                                            name="role[]" 
                                            value="{{ $role->name }}" 
                                            id="check-{{ $role->id }}"
                                            {{ (isset($user) && $user->roles->pluck('name')->contains($role->name)) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="check-{{ $role->id }}">
                                            {{ $role->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="d-flex justify-content-start gap-2">
                            <button class="btn btn-primary" type="submit">
                                <i class="fa fa-paper-plane me-1"></i>
                                {{ isset($user) ? 'Update' : 'Simpan' }}
                            </button>
                            <a href="{{ route('admin.user.index') }}" class="btn btn-secondary">
                                <i class="fa fa-arrow-left me-1"></i> Kembali
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@stop
