@extends('layouts.app_fix')

@section('content')
<div class="main-content">
    <section class="section">
        <!-- Header -->
        <div class="section-header">
            <h1>{{ $action == 'store' ? 'Tambah Media' : 'Edit Media' }}</h1>
        </div>

        <div class="section-body">
            <div class="card shadow-sm border-0">
                <!-- Card Header -->
                <div class="card-header bg-white">
                    <h4 class="mb-0">
                        <i class="fa-solid fa-photo-film me-2"></i> {{ $action == 'store' ? 'Tambah' : 'Edit' }} Media
                    </h4>
                </div>

                <div class="card-body">
                    {{-- Form --}}
                    @if ($action == 'store')
                        <form action="{{ route('admin.medias.store') }}" method="POST" enctype="multipart/form-data">
                    @else
                        <form action="{{ route('admin.medias.update', $media->media_id) }}" method="POST" enctype="multipart/form-data">
                            @method('PUT')
                    @endif
                        @csrf

                        {{-- Tipe Media --}}
                        @if ($action == 'store')
                            @php $fixedType = $type ?? request('type'); @endphp
                            @if ($fixedType)
                                <input type="hidden" name="type" value="{{ $fixedType }}">
                                <div class="mb-3">
                                    <label class="form-label">Tipe Media</label>
                                    <input type="text" class="form-control" value="{{ strtoupper($fixedType) }}" disabled>
                                </div>
                            @else
                                <div class="mb-3">
                                    <label for="mediaType" class="form-label">Tipe Media</label>
                                    <select id="mediaType" name="type" class="form-select @error('type') is-invalid @enderror">
                                        <option value="">-- Pilih Tipe --</option>
                                        <option value="image" {{ old('type')=='image' ? 'selected' : '' }}>Foto</option>
                                        <option value="video" {{ old('type')=='video' ? 'selected' : '' }}>Video</option>
                                        <option value="document" {{ old('type')=='document' ? 'selected' : '' }}>Dokumen</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif
                        @else
                            <div class="mb-3">
                                <label class="form-label">Tipe Media</label>
                                <input type="text" class="form-control" value="{{ strtoupper($media->type ?? '') }}" disabled>
                            </div>
                        @endif

                        {{-- File Upload --}}
                        <div class="mb-3">
                            @if ($action == 'store')
                                <label for="mediaFile" class="form-label">File Media</label>
                                <input type="file" id="mediaFile" name="file" 
                                       class="form-control @error('file') is-invalid @enderror">
                                <small class="text-muted">Format: jpg, png, gif, mp4, mov, avi, pdf, docx, xlsx, pptx | Max: 10MB</small>
                                @error('file')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            @else
                                <label class="form-label">Preview</label><br>
                                @if($media->type == 'image')
                                    <img src="{{ asset('storage/'.$media->file_url) }}" 
                                         class="img-thumbnail rounded shadow-sm" style="max-height: 200px">
                                @elseif($media->type == 'video')
                                    <video controls class="rounded shadow-sm" style="max-height: 200px">
                                        <source src="{{ asset('storage/'.$media->file_url) }}" type="{{ $media->mime_type ?? 'video/mp4' }}">
                                        Browser anda tidak mendukung video.
                                    </video>
                                @elseif($media->type == 'document')
                                    <a href="{{ asset('storage/'.$media->file_url) }}" target="_blank" class="btn btn-outline-info btn-sm">
                                        <i class="fa-solid fa-file"></i> Lihat Dokumen
                                    </a>
                                @endif

                                {{-- Optional ganti file --}}
                                <div class="mt-3">
                                    <label for="mediaFileEdit" class="form-label">Ganti File (Opsional)</label>
                                    <input type="file" id="mediaFileEdit" name="file" class="form-control @error('file') is-invalid @enderror">
                                    <small class="text-muted">Biarkan kosong jika tidak ingin mengganti file.</small>
                                    @error('file')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif
                        </div>

                        {{-- Hidden mime_type --}}
                        <input type="hidden" name="mime_type" value="{{ old('mime_type', $media->mime_type ?? '') }}">

                        {{-- Deskripsi --}}
                        <div class="mb-3">
                            <label for="mediaDesc" class="form-label">Deskripsi</label>
                            <textarea id="mediaDesc" name="description" rows="3"
                                      placeholder="Tulis deskripsi media..."
                                      class="form-control @error('description') is-invalid @enderror">{{ old('description', $media->description ?? '') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Action Buttons --}}
                        <div class="mt-4">
                            <button class="btn btn-primary me-2" type="submit">
                                <i class="fa-solid fa-paper-plane me-1"></i> Simpan
                            </button>
                            <button class="btn btn-warning" type="reset">
                                <i class="fa-solid fa-rotate-right me-1"></i> Reset
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
