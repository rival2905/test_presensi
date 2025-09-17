@extends('layouts.app_fix')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ $action == 'store' ? 'Tambah Event' : 'Edit Event' }}</h1>
        </div>

        <div class="section-body">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <h4 class="mb-0">
                        <i class="fa-solid fa-calendar-days me-2"></i> {{ $action == 'store' ? 'Tambah' : 'Edit' }} Event
                    </h4>
                </div>

                <div class="card-body">
                    @if($action == 'store')
                        <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
                    @else
                        <form action="{{ route('admin.events.update', $event->event_id) }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                    @endif
                        @csrf

                        {{-- Parent Event --}}
                        <div class="mb-3">
                            <label for="parentEventSelect" class="form-label">Parent Event</label>
                            <select id="parentEventSelect" name="parent_event_id" class="form-select @error('parent_event_id') is-invalid @enderror">
                                <option value="">-- Pilih Parent Event (opsional) --</option>
                                @foreach($events as $ev)
                                    <option value="{{ $ev->event_id }}" 
                                        {{ old('parent_event_id', @$event->parent_event_id) == $ev->event_id ? 'selected' : '' }}>
                                        {{ $ev->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('parent_event_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Host Group --}}
<div class="mb-3">
    <label for="hostGroupSelect" class="form-label">Host Group</label>
    <select id="hostGroupSelect" name="host_group_id" class="form-select @error('host_group_id') is-invalid @enderror">
        <option value="">-- Pilih Group --</option>
        @foreach($groups as $group)
            <option value="{{ $group->group_id }}" 
                {{ old('host_group_id', @$event->host_group_id) == $group->group_id ? 'selected' : '' }}>
                {{ $group->name }}
            </option>
        @endforeach
    </select>
    @error('host_group_id')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>


                        {{-- Title --}}
                        <div class="mb-3">
                            <label for="titleInput" class="form-label">Judul Event</label>
                            <input type="text" id="titleInput" name="title" value="{{ old('title', @$event->title) }}" class="form-control @error('title') is-invalid @enderror" placeholder="Masukkan Judul Event">
                            @error('title')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="mb-3">
                            <label for="descriptionInput" class="form-label">Deskripsi</label>
                            <textarea id="descriptionInput" name="description" class="form-control @error('description') is-invalid @enderror" rows="4" placeholder="Masukkan Deskripsi Event">{{ old('description', @$event->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Location --}}
                        <div class="mb-3">
                            <label for="locationInput" class="form-label">Lokasi</label>
                            <input type="text" id="locationInput" name="location" value="{{ old('location', @$event->location) }}" class="form-control @error('location') is-invalid @enderror" placeholder="Masukkan Lokasi Event">
                            @error('location')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Banner --}}
<div class="mb-3">
    <label for="bannerInput" class="form-label">Banner</label>
    <input type="file" id="bannerInput" name="banner_url" accept="image/*" 
           class="form-control @error('banner_url') is-invalid @enderror">

    @if(!empty($event) && $event->banner_url)
        <div class="mt-2">
            <img src="{{ Storage::url($event->banner_url) }}" alt="Banner" 
                 class="rounded border" style="max-height: 120px;">
        </div>
    @endif

    @error('banner_url')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>


                        {{-- Start Date --}}
                        <div class="mb-3">
                            <label for="startDateInput" class="form-label">Tanggal Mulai</label>
                            <input type="datetime-local" id="startDateInput" name="start_date" 
                                   value="{{ old('start_date', isset($event->start_date) ? date('Y-m-d\TH:i', strtotime($event->start_date)) : '') }}"
                                   class="form-control @error('start_date') is-invalid @enderror">
                            @error('start_date')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- End Date --}}
                        <div class="mb-3">
                            <label for="endDateInput" class="form-label">Tanggal Selesai</label>
                            <input type="datetime-local" id="endDateInput" name="end_date" 
                                   value="{{ old('end_date', isset($event->end_date) ? date('Y-m-d\TH:i', strtotime($event->end_date)) : '') }}"
                                   class="form-control @error('end_date') is-invalid @enderror">
                            @error('end_date')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Action Buttons --}}
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="fa-solid fa-paper-plane me-1"></i> SIMPAN
                            </button>
                            <button type="reset" class="btn btn-warning">
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
