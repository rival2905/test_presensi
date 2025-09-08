@extends('layouts.app_fix')

@section('content')
<div class="main-content">
    <section class="section">
        <!-- Header -->
        <div class="section-header">
            <h1>Tambah Role</h1>
        </div>

        <div class="section-body">
            <div class="card shadow-sm border-0">
                <!-- Card Header -->
                <div class="card-header bg-white">
                    <h4 class="mb-0">
                        <i class="fa-solid fa-unlock-keyhole me-2"></i> Tambah Role
                    </h4>
                </div>

                <div class="card-body">
                    @if ($action=='store')
                        <form action="{{ route('admin.role.store') }}" method="POST" enctype="multipart/form-data">
                    @else
                        <form action="{{ route('admin.role.update', $role->id) }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                    @endif
                        @csrf

                        {{-- Nama Role --}}
                        <div class="mb-3">
                            <label for="roleName" class="form-label">NAMA ROLE</label>
                            <input type="text" id="roleName" name="name" 
                                value="{{ old('name', @$role->name) }}" 
                                placeholder="Masukkan Nama Role"
                                class="form-control @error('name') is-invalid @enderror">

                            @error('name')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Permissions --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">PERMISSIONS</label>
                            <div class="d-flex flex-wrap gap-3">
                                @foreach ($permissions as $permission)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               name="permissions[]" 
                                               value="{{ $permission->name }}" 
                                               id="check-{{ $permission->id }}" 
                                               @if(@$role->permissions && @$role->permissions->contains($permission)) checked @endif>
                                        <label class="form-check-label" for="check-{{ $permission->id }}">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
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
