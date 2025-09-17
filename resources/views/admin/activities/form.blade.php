@extends('layouts.app_fix')

@section('content')
<div class="main-content">
    <section class="section">
        <!-- Header -->
        <div class="section-header">
            <h1>{{ $action == 'store' ? 'Tambah Activity' : 'Edit Activity' }}</h1>
        </div>

        <div class="section-body">
            <div class="card shadow-sm border-0">
                <!-- Card Header -->
                <div class="card-header bg-white">
                    <h4 class="mb-0">
                        <i class="fa-solid fa-calendar-days me-2"></i> {{ $action == 'store' ? 'Tambah' : 'Edit' }} Activity
                    </h4>
                </div>

                <div class="card-body">
                    @if ($action == 'store')
                        <form action="{{ route('admin.activities.store') }}" method="POST">
                    @else
                        <form action="{{ route('admin.activities.update', $activity->activity_id) }}" method="POST">
                        @method('PUT')
                    @endif
                        @csrf

                        {{-- Group --}}
                        <div class="mb-3">
                            <label for="groupSelect" class="form-label">Group</label>
                            <select id="groupSelect" name="group_id" class="form-select @error('group_id') is-invalid @enderror">
                                <option value="">-- Pilih Group --</option>
                                @foreach($groups as $group)
                                    <option value="{{ $group->group_id }}" 
                                        {{ old('group_id', @$activity->group_id) == $group->group_id ? 'selected' : '' }}>
                                        {{ $group->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('group_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Nama Activity --}}
                        <div class="mb-3">
                            <label for="activityName" class="form-label">Nama Activity</label>
                            <input type="text" id="activityName" name="name" 
                                   value="{{ old('name', @$activity->name) }}" 
                                   placeholder="Masukkan Nama Activity"
                                   class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-3">
                            <label for="activityDescription" class="form-label">Deskripsi</label>
                            <textarea id="activityDescription" name="description" 
                                      placeholder="Masukkan Deskripsi Activity"
                                      class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description', @$activity->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Start Date --}}
                        <div class="mb-3">
                            <label for="startDate" class="form-label">Start Date</label>
                            <input type="date" id="startDate" name="start_date" 
                                   value="{{ old('start_date', isset($activity->start_date) ? \Carbon\Carbon::parse($activity->start_date)->format('Y-m-d') : '') }}" 
                                   class="form-control @error('start_date') is-invalid @enderror">
                            @error('start_date')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- End Date --}}
                        <div class="mb-3">
                            <label for="endDate" class="form-label">End Date</label>
                            <input type="date" id="endDate" name="end_date" 
                                   value="{{ old('end_date', isset($activity->end_date) ? \Carbon\Carbon::parse($activity->end_date)->format('Y-m-d') : '') }}" 
                                   class="form-control @error('end_date') is-invalid @enderror">
                            @error('end_date')
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
