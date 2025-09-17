@extends('layouts.app_fix')

@section('content')
<div class="main-content">
    <section class="section">
        <!-- Header -->
        <div class="section-header">
            <h1>{{ isset($subcategory) ? 'Edit Sub Category' : 'Tambah Sub Category' }}</h1>
        </div>

        <div class="section-body">
            <div class="card shadow-sm border-0">
                <!-- Card Header -->
                <div class="card-header bg-white">
                    <h4 class="mb-0">
                        <i class="fa-solid fa-list me-2"></i>
                        {{ isset($subcategory) ? 'Edit' : 'Tambah' }} Sub Category
                    </h4>
                </div>

                <div class="card-body">
                    <form action="{{ isset($subcategory) 
                                        ? route('admin.subcategories.update', $subcategory->subcategory_id) 
                                        : route('admin.subcategories.store') }}" 
                          method="POST">
                        @csrf
                        @if(isset($subcategory))
                            @method('PUT')
                        @endif

                        {{-- Main Category --}}
                        <div class="mb-3">
                            <label for="main_category_id" class="form-label">Main Category</label>
                            <select name="main_category_id" id="main_category_id" 
                                    class="form-select @error('main_category_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Main Category --</option>
                                @foreach($maincategories as $main)
                                    <option value="{{ $main->main_category_id }}"
                                        {{ old('main_category_id', $subcategory->main_category_id ?? '') == $main->main_category_id ? 'selected' : '' }}>
                                        {{ $main->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('main_category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Nama Sub Category --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Sub Category</label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $subcategory->name ?? '') }}" 
                                   placeholder="Masukkan nama sub kategori" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Action Buttons --}}
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="fa-solid fa-paper-plane me-1"></i>
                                {{ isset($subcategory) ? 'Update' : 'Simpan' }}
                            </button>
                            <button type="reset" class="btn btn-warning">
                                <i class="fa-solid fa-rotate-right me-1"></i> RESET
                            </button>
                            <a href="{{ route('admin.subcategories.index') }}" class="btn btn-secondary">
                                <i class="fa-solid fa-xmark me-1"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
