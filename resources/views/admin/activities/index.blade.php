@extends('layouts.app_fix')

@section('content')
<div class="main-content">
    <section class="section">
        <!-- Header -->
        <div class="section-header">
            <h1>Activities</h1>
        </div>

        <div class="section-body">
            <div class="card shadow-sm border-0">
                <!-- Card Header -->
                <div class="card-header bg-white">
                    <h4 class="mb-0">
                        <i class="fa-solid fa-calendar-days me-2"></i> Activities
                    </h4>
                </div>

                <div class="card-body">
                    <!-- Search + Tambah -->
                    <form action="{{ route('admin.activities.index') }}" method="GET">
                        <div class="mb-3">
                            <div class="input-group">
                                @can('activities.create')
                                    <a href="{{ route('admin.activities.create') }}" class="btn btn-primary me-2">
                                        <i class="fa-solid fa-circle-plus me-1"></i> TAMBAH
                                    </a>
                                @endcan
                                <input type="text" class="form-control" name="q"
                                       placeholder="Cari berdasarkan nama aktivitas"
                                       value="{{ request('q') }}">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa-solid fa-magnifying-glass me-1"></i> CARI
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle table-hover">
                            <thead class="table-light text-center">
                                <tr>
                                    <th style="width:5%">NO.</th>
                                    <th style="width:12%">GROUP</th>
                                    <th style="width:18%">NAMA AKTIVITAS</th>
                                    <th style="width:25%">DESKRIPSI</th>
                                    <th style="width:10%">START DATE</th>
                                    <th style="width:10%">END DATE</th>
                                    <th style="width:10%">STATUS</th>
                                    <th style="width:10%">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($activities as $no => $activity)
                                <tr>
                                    <td class="text-center">
                                        {{ ++$no + ($activities->currentPage()-1) * $activities->perPage() }}
                                    </td>
                                    <td>{{ $activity->group ? $activity->group->name : '-' }}</td>
                                    <td>{{ $activity->name }}</td>
                                    <td title="{{ $activity->description ?? '-' }}">
                                        {{ \Illuminate\Support\Str::limit($activity->description, 50, '...') ?? '-' }}
                                    </td>
                                    <td class="text-center">{{ \Carbon\Carbon::parse($activity->start_date)->format('d M Y') }}</td>
                                    <td class="text-center">{{ \Carbon\Carbon::parse($activity->end_date)->format('d M Y') }}</td>
                                    <td class="text-center">
                                        @if($activity->status == 'Ongoing')
                                            <span class="badge bg-success">{{ $activity->status }}</span>
                                        @elseif($activity->status == 'Selesai')
                                            <span class="badge bg-secondary">{{ $activity->status }}</span>
                                        @else
                                            <span class="badge bg-warning">{{ $activity->status }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @can('activities.edit')
                                            <a href="{{ route('admin.activities.edit', $activity->activity_id) }}" 
                                               class="btn btn-sm btn-primary me-1" title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                        @endcan

                                        @can('activities.delete')
                                            <button onClick="Delete(this.id)" 
                                                    class="btn btn-sm btn-danger" 
                                                    id="{{ $activity->activity_id }}" title="Hapus">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $activities->links('vendor.pagination.bootstrap-5') }}
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
            text: "INGIN MENGHAPUS DATA INI!",
            icon: "warning",
            buttons: ['TIDAK','YA'],
            dangerMode: true,
        }).then(function(isConfirm) {
            if (isConfirm) {
                fetch(`/admin/activities/${id}`, {
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
