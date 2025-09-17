@extends('layouts.app_fix')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ $action == 'store' ? 'Tambah Registrasi Event' : 'Edit Registrasi Event' }}</h1>
        </div>

        <div class="section-body">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <h4 class="mb-0">
                        <i class="fa-solid fa-clipboard-list me-2"></i>
                        {{ $action == 'store' ? 'Tambah' : 'Edit' }} Registrasi Event
                    </h4>
                </div>

                <div class="card-body">
                    @if($action == 'store')
                        <form action="{{ route('admin.registrations.store') }}" method="POST">
                    @else
                        <form action="{{ route('admin.registrations.update', $registration->registration_id) }}" method="POST">
                        @method('PUT')
                    @endif
                        @csrf

                        {{-- User --}}
                        <div class="mb-3">
                            <label for="userSelect" class="form-label">User</label>
                            <select id="userSelect" name="user_id" class="form-select @error('user_id') is-invalid @enderror">
                                <option value="">-- Pilih User --</option>
                                @foreach($users as $usr)
                                    <option value="{{ $usr->id }}"
                                        {{ old('user_id', @$registration->user_id) == $usr->id ? 'selected' : '' }}>
                                        {{ $usr->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Jadwal Event --}}
                        <div class="mb-3">
                            <label for="scheduleSelect" class="form-label">Jadwal Event</label>
                            <select id="scheduleSelect" name="schedule_id" class="form-select @error('schedule_id') is-invalid @enderror">
                                <option value="">-- Pilih Jadwal --</option>
                                @foreach($schedules as $sch)
                                    <option value="{{ $sch->schedule_id }}"
                                        {{ old('schedule_id', @$registration->schedule_id) == $sch->schedule_id ? 'selected' : '' }}>
                                        {{ $sch->event->title }} - {{ date('d M Y H:i', strtotime($sch->start_time)) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('schedule_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div class="mb-3">
                            <label for="statusSelect" class="form-label">Status</label>
                            <select id="statusSelect" name="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="pending" {{ old('status', @$registration->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ old('status', @$registration->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ old('status', @$registration->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Team Name --}}
                        <div class="mb-3">
                            <label for="teamNameInput" class="form-label">Nama Tim</label>
                            <input type="text" id="teamNameInput" name="team_name"
                                   value="{{ old('team_name', @$registration->team_name) }}"
                                   class="form-control @error('team_name') is-invalid @enderror"
                                   placeholder="Masukkan nama tim (jika ada)">
                            @error('team_name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Action Buttons --}}
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="fa-solid fa-paper-plane me-1"></i> SIMPAN
                            </button>
                            <button type="reset" class="btn btn-warning me-2">
                                <i class="fa-solid fa-rotate-right me-1"></i> RESET
                            </button>
                            <a href="{{ route('admin.registrations.index') }}" class="btn btn-secondary">
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
