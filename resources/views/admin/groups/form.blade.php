@extends('layouts.app_fix')

@section('content')
<div class="main-content">
    <section class="section">
        <!-- Header -->
        <div class="section-header">
            <h1>{{ $action == 'store' ? 'Tambah Group' : 'Edit Group' }}</h1>
        </div>

        <div class="section-body">
            <div class="card shadow-sm border-0">
                <!-- Card Header -->
                <div class="card-header bg-white">
                    <h4 class="mb-0">
                        <i class="fa-solid fa-users me-2"></i> {{ $action == 'store' ? 'Tambah' : 'Edit' }} Group
                    </h4>
                </div>

                <div class="card-body">
                    @if ($action == 'store')
                        <form action="{{ route('admin.groups.store') }}" method="POST">
                    @else
                        <form action="{{ route('admin.groups.update', $group->group_id) }}" method="POST">
                        @method('PUT')
                    @endif
                        @csrf

                        {{-- Organization --}}
                        <div class="mb-3">
                            <label for="organization" class="form-label">ORGANIZATION <span class="text-danger">*</span></label>
                            <select id="organization" name="organization_id" 
                                    class="form-select @error('organization_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Organization --</option>
                                @foreach($organizations as $org)
                                    <option value="{{ $org->organization_id }}" 
                                        {{ old('organization_id', @$group->organization_id) == $org->organization_id ? 'selected' : '' }}>
                                        {{ $org->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('organization_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Nama Group --}}
                        <div class="mb-3">
                            <label for="groupName" class="form-label">NAMA GROUP <span class="text-danger">*</span></label>
                            <input type="text" id="groupName" name="name" 
                                   value="{{ old('name', @$group->name) }}" 
                                   placeholder="Masukkan Nama Group"
                                   class="form-control @error('name') is-invalid @enderror" required>
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Type --}}
                        <div class="mb-3">
                            <label for="type" class="form-label">TYPE <span class="text-danger">*</span></label>
                            <select id="type" name="type" 
                                    class="form-select @error('type') is-invalid @enderror" required>
                                <option value="">-- Pilih Type --</option>
                                <option value="formal" {{ old('type', @$group->type) == 'formal' ? 'selected' : '' }}>Formal</option>
                                <option value="informal" {{ old('type', @$group->type) == 'informal' ? 'selected' : '' }}>Informal</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-3">
                            <label for="description" class="form-label">DESKRIPSI</label>
                            <textarea id="description" name="description" rows="3" 
                                      placeholder="Masukkan Deskripsi (Opsional)" 
                                      class="form-control @error('description') is-invalid @enderror">{{ old('description', @$group->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
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
