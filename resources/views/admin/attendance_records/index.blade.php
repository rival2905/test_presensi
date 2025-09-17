@extends('layouts.app_fix')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Attendance Records</h1>
        </div>

        <div class="section-body">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <h4 class="mb-0">
                        <i class="fa-solid fa-user-check me-2"></i> Attendance Records
                    </h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.attendance-records.index') }}" method="GET">
                        <div class="mb-3">
                            <div class="input-group">
                                @can('attendances.create')
                                <a href="{{ route('admin.attendance-records.create') }}" class="btn btn-primary me-2">
                                    <i class="fa-solid fa-circle-plus me-1"></i> TAMBAH
                                </a>
                                @endcan

                                <input type="text" class="form-control" name="q" placeholder="Cari berdasarkan nama user atau activity" value="{{ request('q') }}">
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
                                    <th>USER</th>
                                    <th>ACTIVITY</th>
                                    <th>STATUS</th>
                                    <th>REASON</th>
                                    <th>PHOTO</th>
                                    <th>ATTACHMENT</th>
                                    <th>TIMESTAMP</th>
                                    <th class="text-center" style="width:15%">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($records as $no => $record)
                                <tr>
                                    <td class="text-center">{{ ++$no + ($records->currentPage()-1) * $records->perPage() }}</td>
                                    <td>{{ $record->user ? $record->user->name : '-' }}</td>
                                    <td>{{ $record->activity ? $record->activity->name : '-' }}</td>
                                    <td>
                                        @if($record->status == 'present')
                                            <span class="badge bg-success">Hadir</span>
                                        @elseif($record->status == 'late')
                                            <span class="badge bg-warning">Terlambat</span>
                                        @else
                                            <span class="badge bg-secondary">Absen</span>
                                        @endif
                                    </td>
                                    <td>{{ $record->reason ?? '-' }}</td>
                                    <td>
                                        @if($record->photo_url)
                                            <img src="{{ asset('storage/'.$record->photo_url) }}" style="max-height:50px;" alt="Photo">
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if($record->attachment_url)
                                            <a href="{{ asset('storage/'.$record->attachment_url) }}" target="_blank">Lihat</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($record->timestamp)->format('d M Y H:i') }}</td>
                                    <td class="text-center">
                                        @can('attendances.edit')
                                            <a href="{{ route('admin.attendance-records.edit', $record->record_id) }}" class="btn btn-sm btn-primary me-1">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                        @endcan
                                        @can('attendances.delete')
                                            <button onClick="Delete(this.id)" class="btn btn-sm btn-danger" id="{{ $record->record_id }}">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-center">
                            {{ $records->links('vendor.pagination.bootstrap-5') }}
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
                fetch(`/admin/attendance-records/${id}`, {
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
