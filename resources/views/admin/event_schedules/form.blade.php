@extends('layouts.app_fix')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ $action == 'store' ? 'Tambah Jadwal Event' : 'Edit Jadwal Event' }}</h1>
        </div>

        <div class="section-body">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <h4 class="mb-0">
                        <i class="fa-solid fa-clock me-2"></i> 
                        {{ $action == 'store' ? 'Tambah' : 'Edit' }} Jadwal Event
                    </h4>
                </div>

                <div class="card-body">
                    @if($action == 'store')
                        <form action="{{ route('admin.schedules.store') }}" method="POST">
                    @else
                        <form action="{{ route('admin.schedules.update', $schedule->schedule_id) }}" method="POST">
                        @method('PUT')
                    @endif
                        @csrf

                        {{-- Event --}}
                        <div class="mb-3">
                            <label for="eventSelect" class="form-label">Event</label>
                            <select id="eventSelect" name="event_id" class="form-select @error('event_id') is-invalid @enderror">
                                <option value="">-- Pilih Event --</option>
                                @foreach($events as $ev)
                                    <option value="{{ $ev->event_id }}"
                                        {{ old('event_id', @$schedule->event_id) == $ev->event_id ? 'selected' : '' }}>
                                        {{ $ev->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('event_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Start Time --}}
                        <div class="mb-3">
                            <label for="startTimeInput" class="form-label">Waktu Mulai</label>
                            <input type="datetime-local" id="startTimeInput" name="start_time" 
                                   value="{{ old('start_time', isset($schedule->start_time) ? date('Y-m-d\TH:i', strtotime($schedule->start_time)) : '') }}"
                                   class="form-control @error('start_time') is-invalid @enderror">
                            @error('start_time')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- End Time --}}
                        <div class="mb-3">
                            <label for="endTimeInput" class="form-label">Waktu Selesai</label>
                            <input type="datetime-local" id="endTimeInput" name="end_time" 
                                   value="{{ old('end_time', isset($schedule->end_time) ? date('Y-m-d\TH:i', strtotime($schedule->end_time)) : '') }}"
                                   class="form-control @error('end_time') is-invalid @enderror">
                            @error('end_time')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Price --}}
                        <div class="mb-3">
                            <label for="priceInput" class="form-label">Harga Tiket</label>
                            <input type="number" id="priceInput" name="price" 
                                   value="{{ old('price', @$schedule->price) }}"
                                   class="form-control @error('price') is-invalid @enderror" placeholder="Masukkan harga tiket">
                            @error('price')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Quota --}}
                        <div class="mb-3">
                            <label for="quotaInput" class="form-label">Kuota</label>
                            <input type="number" id="quotaInput" name="quota" 
                                   value="{{ old('quota', @$schedule->quota) }}"
                                   class="form-control @error('quota') is-invalid @enderror" placeholder="Masukkan kuota peserta">
                            @error('quota')
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
                            <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary">
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
