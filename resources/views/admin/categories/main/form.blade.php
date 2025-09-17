@extends('layouts.app_fix')

@section('content')
<div class="main-content">
    <section class="section">
        <!-- Header -->
        <div class="section-header">
            <h1>{{ $action == 'store' ? 'Tambah Main Category' : 'Edit Main Category' }}</h1>
        </div>

        <div class="section-body">
            <div class="card shadow-sm border-0">
                <!-- Card Header -->
                <div class="card-header bg-white">
                    <h4 class="mb-0">
                        <i class="fa-solid fa-folder me-2"></i> {{ $action == 'store' ? 'Tambah' : 'Edit' }} Main Category
                    </h4>
                </div>

                <div class="card-body">
                    @if ($action == 'store')
                        <form action="{{ route('admin.maincategories.store') }}" method="POST">
                    @else
                        <form action="{{ route('admin.maincategories.update', $maincategory->main_category_id) }}" method="POST">
                        @method('PUT')
                    @endif
                        @csrf

                        {{-- Nama Kategori --}}
                        <div class="mb-3">
                            <label for="categoryName" class="form-label">NAMA KATEGORI</label>
                            <input type="text" id="categoryName" name="name" 
                                   value="{{ old('name', @$maincategory->name) }}" 
                                   placeholder="Masukkan Nama Kategori"
                                   class="form-control @error('name') is-invalid @enderror">

                            @error('name')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Action Buttons --}}
                        <div class="mt-4">
                            <button class="btn btn-primary me-2" type="submit">
                                <i class="fa-solid fa-paper-plane me-1"></i> SIMPAN
                            </button>
                            <button class="btn btn-warning" type="reset">
                                <i class="fa-solid fa-rotate-right me-1"></i> RESET
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
