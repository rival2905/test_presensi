@extends('layouts.app_fix')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Events</h1>
        </div>

        <div class="section-body">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <h4 class="mb-0">
                        <i class="fa-solid fa-calendar-days me-2"></i> Daftar Event
                    </h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.events.index') }}" method="GET">
                        <div class="mb-3">
                            <div class="input-group">
                                @can('events.create')
                                <a href="{{ route('admin.events.create') }}" class="btn btn-primary me-2">
                                    <i class="fa-solid fa-circle-plus me-1"></i> TAMBAH
                                </a>
                                @endcan

                                <input type="text" class="form-control" name="q" placeholder="Cari berdasarkan judul event" value="{{ request('q') }}">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa-solid fa-magnifying-glass me-1"></i> CARI
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" style="width:6%">NO.</th>
                                    <th>JUDUL</th>
                                    <th>DESKRIPSI</th>
                                    <th>LOKASI</th>
                                    <th>BANNER</th>
                                    <th>MULAI</th>
                                    <th>SELESAI</th>
                                    <th class="text-center" style="width:15%">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php $no = 1; @endphp
                            @forelse ($events as $event)
                                <tr>
                                    <td class="text-center">{{ $no++ + ($events->currentPage()-1) * $events->perPage() }}</td>
                                    <td>{{ $event->title }}</td>
                                    <td>{{ Str::limit($event->description, 50) }}</td>
                                    <td>{{ $event->location }}</td>
                                    <td class="text-center">
    @if($event->banner_url)
        <img src="{{ Storage::url($event->banner_url) }}" 
             alt="Banner" 
             class="rounded shadow-sm border" 
             style="max-height:50px;">
    @else
        <span class="text-muted">-</span>
    @endif
</td>

                                    <td>{{ \Carbon\Carbon::parse($event->start_date)->format('d M Y H:i') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($event->end_date)->format('d M Y H:i') }}</td>
                                    <td class="text-center">
                                        @can('events.edit')
                                            <a href="{{ route('admin.events.edit', $event->event_id) }}" class="btn btn-sm btn-primary me-1">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                        @endcan
                                        @can('events.delete')
                                            <button onClick="Delete(this.id)" class="btn btn-sm btn-danger" id="{{ $event->event_id }}">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">Belum ada data event</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-center">
                            {{ $events->links('vendor.pagination.bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    function Delete(id) {
        var token = document.querySelector("meta[name='csrf-token']").getAttribute("content");

        swal({
            title: "APAKAH KAMU YAKIN ?",
            text: "INGIN MENGHAPUS DATA INI!",
            icon: "warning",
            buttons: ['TIDAK','YA'],
            dangerMode: true,
        }).then(function(isConfirm) {
            if (isConfirm) {
                fetch(`/admin/events/${id}`, {
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
                            text: 'DATA BERHASIL DIHAPUS!',
                            icon: 'success',
                            timer: 1000,
                            buttons: false,
                        }).then(() => location.reload());
                    } else {
                        swal({
                            title: 'GAGAL!',
                            text: 'DATA GAGAL DIHAPUS!',
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
