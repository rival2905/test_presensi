@extends('layouts.app_fix')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ $action == 'store' ? 'Tambah Attendance Record' : 'Edit Attendance Record' }}</h1>
        </div>

        <div class="section-body">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <h4 class="mb-0">
                        <i class="fa-solid fa-user-check me-2"></i> {{ $action == 'store' ? 'Tambah' : 'Edit' }} Record
                    </h4>
                </div>

                <div class="card-body">
                    @if($action == 'store')
                        <form action="{{ route('admin.attendance-records.store') }}" method="POST" enctype="multipart/form-data">
                    @else
                        <form action="{{ route('admin.attendance-records.update', $record->record_id) }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                    @endif
                        @csrf

                        {{-- Activity --}}
                        <div class="mb-3">
                            <label for="activitySelect" class="form-label">Activity</label>
                            <select id="activitySelect" name="activity_id" class="form-select @error('activity_id') is-invalid @enderror">
                                <option value="">-- Pilih Activity --</option>
                                @foreach($activities as $activity)
                                    <option value="{{ $activity->activity_id }}" 
                                        {{ old('activity_id', @$record->activity_id) == $activity->activity_id ? 'selected' : '' }}>
                                        {{ $activity->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('activity_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- User --}}
                        <div class="mb-3">
                            <label for="userSelect" class="form-label">User</label>
                            <select id="userSelect" name="user_id" class="form-select @error('user_id') is-invalid @enderror">
                                <option value="">-- Pilih User --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" 
                                        {{ old('user_id', @$record->user_id) == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div class="mb-3">
                            <label for="statusSelect" class="form-label">Status</label>
                            <select id="statusSelect" name="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="">-- Pilih Status --</option>
                                <option value="masuk" {{ old('status', @$record->status) == 'masuk' ? 'selected' : '' }}>Masuk</option>
                                <option value="izin" {{ old('status', @$record->status) == 'izin' ? 'selected' : '' }}>Izin</option>
                                <option value="sakit" {{ old('status', @$record->status) == 'sakit' ? 'selected' : '' }}>Sakit</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Reason --}}
                        <div class="mb-3">
                            <label for="reasonInput" class="form-label">Reason</label>
                            <textarea id="reasonInput" name="reason" class="form-control @error('reason') is-invalid @enderror" rows="3" placeholder="Masukkan alasan (optional)">{{ old('reason', @$record->reason) }}</textarea>
                            @error('reason')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Photo --}}
                        <div class="mb-3">
                            <label for="photoInput" class="form-label">Photo</label>
                            <input type="file" id="photoInput" name="photo" accept="image/*" class="form-control @error('photo') is-invalid @enderror">
                            @if(isset($record->photo_url))
                                <img src="{{ asset('storage/' . $record->photo_url) }}" alt="Photo" class="mt-2" style="max-height:100px;">
                            @endif
                            @error('photo')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Attachment --}}
                        <div class="mb-3">
                            <label for="attachmentInput" class="form-label">Attachment</label>
                            <input type="file" id="attachmentInput" name="attachment" class="form-control @error('attachment') is-invalid @enderror">
                            @if(isset($record->attachment_url))
                                <a href="{{ asset('storage/' . $record->attachment_url) }}" target="_blank" class="d-block mt-2">Lihat Attachment</a>
                            @endif
                            @error('attachment')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Latitude --}}
                        <div class="mb-3">
                            <label for="latitudeInput" class="form-label">Latitude</label>
                            <input type="text" id="latitudeInput" name="latitude" value="{{ old('latitude', @$record->latitude) }}" class="form-control @error('latitude') is-invalid @enderror" placeholder="Masukkan Latitude">
                            @error('latitude')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Longitude --}}
                        <div class="mb-3">
                            <label for="longitudeInput" class="form-label">Longitude</label>
                            <input type="text" id="longitudeInput" name="longitude" value="{{ old('longitude', @$record->longitude) }}" class="form-control @error('longitude') is-invalid @enderror" placeholder="Masukkan Longitude">
                            @error('longitude')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Timestamp --}}
                        <div class="mb-3">
                            <label for="timestampInput" class="form-label">Timestamp</label>
                            <input type="datetime-local" id="timestampInput" name="timestamp" 
                                   value="{{ old('timestamp', isset($record->timestamp) ? date('Y-m-d\TH:i', strtotime($record->timestamp)) : '') }}"
                                   class="form-control @error('timestamp') is-invalid @enderror">
                            @error('timestamp')
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
