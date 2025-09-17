@extends('layouts.app_fix')

@section('content')
<div class="main-content">
    <section class="section">
        <!-- Header -->
        <div class="section-header">
            <h1>{{ $action == 'store' ? 'Tambah Organization' : 'Edit Organization' }}</h1>
        </div>

        <div class="section-body">
            <div class="card shadow-sm border-0">
                <!-- Card Header -->
                <div class="card-header bg-white">
                    <h4 class="mb-0">
                        <i class="fa-solid fa-building me-2"></i> {{ $action == 'store' ? 'Tambah' : 'Edit' }} Organization
                    </h4>
                </div>

                <div class="card-body">
                    @if ($action == 'store')
                        <form action="{{ route('admin.organizations.store') }}" method="POST" enctype="multipart/form-data">
                    @else
                        <form action="{{ route('admin.organizations.update', $organization->organization_id) }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                    @endif
                        @csrf

                        {{-- Logo --}}
                        <div class="mb-3">
                            <label for="logo_url" class="form-label">LOGO</label>
                            <input type="file" id="logo_url" name="logo_url" class="form-control @error('logo_url') is-invalid @enderror">
                            @if($action == 'update' && $organization->logo_url)
                                <img src="{{ asset('storage/'.$organization->logo_url) }}" width="100" class="mt-2 rounded border">
                            @endif
                            @error('logo_url')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Nama Organisasi --}}
                        <div class="mb-3">
                            <label for="organizationName" class="form-label">NAMA ORGANISASI</label>
                            <input type="text" id="organizationName" name="name" 
                                   value="{{ old('name', @$organization->name) }}" 
                                   placeholder="Masukkan Nama Organisasi"
                                   class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Parent Organization --}}
                        <div class="mb-3">
                            <label for="parentOrganization" class="form-label">PARENT ORGANIZATION</label>
                            <select id="parentOrganization" name="parent_organization_id" class="form-select @error('parent_organization_id') is-invalid @enderror">
                                <option value="">-- Pilih Parent (Opsional) --</option>
                                @foreach($parents as $parent)
                                    <option value="{{ $parent->organization_id }}" 
                                        {{ old('parent_organization_id', @$organization->parent_organization_id) == $parent->organization_id ? 'selected' : '' }}>
                                        {{ $parent->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('parent_organization_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Address --}}
                        <div class="mb-3">
                            <label for="address" class="form-label">ALAMAT</label>
                            <textarea id="address" name="address" rows="2" placeholder="Masukkan Alamat" class="form-control @error('address') is-invalid @enderror">{{ old('address', @$organization->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Contact --}}
                        <div class="mb-3">
                            <label for="contact" class="form-label">KONTAK</label>
                            <input type="text" id="contact" name="contact" 
                                   value="{{ old('contact', @$organization->contact) }}" 
                                   placeholder="Masukkan Kontak (HP/Email)"
                                   class="form-control @error('contact') is-invalid @enderror">
                            @error('contact')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Action Buttons --}}
                        <div class="mt-4">
                            <button class="btn btn-primary me-2" type="submit">
                                <i class="fa-solid fa-paper-plane me-1"></i> SIMPAN
                            </button>
                            <a href="{{ route('admin.organizations.index') }}" class="btn btn-secondary">
                                <i class="fa-solid fa-arrow-left me-1"></i> KEMBALI
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
