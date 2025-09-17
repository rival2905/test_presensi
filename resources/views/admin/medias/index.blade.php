@extends('layouts.app_fix')

@section('content')
<div class="main-content">
    <section class="section">
        <!-- Header -->
        <div class="section-header">
            <h1>Galeri Media</h1>
        </div>

        <div class="section-body">
            <div class="card shadow-sm border-0">
                <!-- Card Header -->
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fa-solid fa-photo-film me-2"></i> Foto & Video
                    </h4>

                    {{-- Tombol tambah sesuai type & permission --}}
                    @if(($type === 'image' && auth()->user()->can('photos.create')) ||
                        ($type === 'video' && auth()->user()->can('videos.create')))
                        <a href="{{ route('admin.medias.create') }}?type={{ $type }}" 
                           class="btn btn-success">
                            <i class="fa-solid fa-circle-plus me-1"></i> 
                            Tambah {{ $type === 'video' ? 'Video' : 'Foto' }}
                        </a>
                    @endif
                </div>

                <div class="card-body">
                    <!-- Filter + Search -->
                    <form action="{{ route('admin.medias.index') }}" method="GET">
                        <div class="mb-3">
                            <div class="input-group">
                                <select name="type" class="form-select me-2" style="max-width: 160px" onchange="this.form.submit()">
                                    <option value="">Semua</option>
                                    <option value="image" {{ request('type')=='image' ? 'selected' : '' }}>Foto</option>
                                    <option value="video" {{ request('type')=='video' ? 'selected' : '' }}>Video</option>
                                </select>

                                <input type="text" class="form-control" name="q"
                                       placeholder="Cari deskripsi media"
                                       value="{{ request('q') }}">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa-solid fa-magnifying-glass me-1"></i> Cari
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" style="width: 5%">No.</th>
                                    <th style="width: 20%">Preview</th>
                                    <th>Deskripsi</th>
                                    <th class="text-center" style="width: 10%">Tipe</th>
                                    <th class="text-center" style="width: 18%">Tgl Upload</th>
                                    <th class="text-center" style="width: 15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse ($medias as $no => $media)
                                <tr>
                                    <td class="text-center">
                                        {{ ++$no + ($medias->currentPage()-1) * $medias->perPage() }}
                                    </td>
                                    <td>
                                        @if($media->type == 'image')
                                            <img src="{{ asset('storage/'.$media->file_url) }}" 
                                                 alt="Foto" class="img-fluid rounded" style="max-height: 120px">
                                        @elseif($media->type == 'video')
                                            <video controls class="img-fluid rounded" style="max-height: 120px">
                                                <source src="{{ asset('storage/'.$media->file_url) }}" type="{{ $media->mime_type ?? 'video/mp4' }}">
                                                Browser tidak mendukung video.
                                            </video>
                                        @else
                                            <a href="{{ asset('storage/'.$media->file_url) }}" target="_blank" class="btn btn-outline-secondary btn-sm">
                                                <i class="fa-solid fa-file"></i> Lihat Dokumen
                                            </a>
                                        @endif
                                    </td>
                                    <td>{{ $media->description ?? '-' }}</td>
                                    <td class="text-center">
                                        <span class="badge {{ $media->type == 'image' ? 'bg-primary' : ($media->type == 'video' ? 'bg-success' : 'bg-secondary') }}">
                                            {{ strtoupper($media->type) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        {{ $media->uploaded_at ? \Carbon\Carbon::parse($media->uploaded_at)->format('d M Y H:i') : '-' }}
                                    </td>
                                    <td class="text-center">
                                        {{-- Tombol Edit --}}
                                        @if(($media->type == 'image' && auth()->user()->can('photos.edit')) ||
                                            ($media->type == 'video' && auth()->user()->can('videos.edit')))
                                            <a href="{{ route('admin.medias.edit', $media->media_id) }}" 
                                               class="btn btn-sm btn-primary me-1">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                        @endif

                                        {{-- Tombol Delete --}}
                                        @if(($media->type == 'image' && auth()->user()->can('photos.delete')) ||
                                            ($media->type == 'video' && auth()->user()->can('videos.delete')))
                                            <button onClick="Delete(this.id)" 
                                                    class="btn btn-sm btn-danger" 
                                                    id="{{ $media->media_id }}">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Tidak ada media ditemukan</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $medias->links('vendor.pagination.bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    // Ajax delete
    function Delete(id) {
        var token = document.querySelector("meta[name='csrf-token']").getAttribute("content");

        swal({
            title: "APAKAH KAMU YAKIN ?",
            text: "Ingin menghapus media ini!",
            icon: "warning",
            buttons: ['TIDAK','YA'],
            dangerMode: true,
        }).then(function(isConfirm) {
            if (isConfirm) {
                fetch(`/admin/media/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: id })
                }).then(res => res.json())
                  .then(response => {
                    if (response.status === "success") {
                        swal({
                            title: 'BERHASIL!',
                            text: response.message,
                            icon: 'success',
                            timer: 1000,
                            buttons: false,
                        }).then(() => location.reload());
                    } else {
                        swal({
                            title: 'GAGAL!',
                            text: response.message,
                            icon: 'error',
                            timer: 1000,
                            buttons: false,
                        }).then(() => location.reload());
                    }
                });
            }
        });
    }
</script>
@endsection
