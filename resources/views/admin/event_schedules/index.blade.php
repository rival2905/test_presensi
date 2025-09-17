@extends('layouts.app_fix')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Event Schedules</h1>
        </div>

        <div class="section-body">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <h4 class="mb-0">
                        <i class="fa-solid fa-clock me-2"></i> Daftar Event Schedules
                    </h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.schedules.index') }}" method="GET">
                        <div class="mb-3">
                            <div class="input-group">
                                @can('schedules.create')
                                <a href="{{ route('admin.schedules.create') }}" class="btn btn-primary me-2">
                                    <i class="fa-solid fa-circle-plus me-1"></i> TAMBAH
                                </a>
                                @endcan

                                <input type="text" class="form-control" name="q" placeholder="Cari berdasarkan event atau waktu mulai" value="{{ request('q') }}">
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
                                    <th>EVENT</th>
                                    <th>MULAI</th>
                                    <th>SELESAI</th>
                                    <th>PRICE</th>
                                    <th>QUOTA</th>
                                    <th class="text-center" style="width:15%">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php $no = 1; @endphp
                            @forelse ($schedules as $schedule)
                                <tr>
                                    <td class="text-center">{{ $no++ + ($schedules->currentPage()-1) * $schedules->perPage() }}</td>
                                    <td>{{ $schedule->event?->title ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('d M Y H:i') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($schedule->end_time)->format('d M Y H:i') }}</td>
                                    <td>Rp {{ number_format($schedule->price, 0, ',', '.') }}</td>
                                    <td>{{ $schedule->quota }}</td>
                                    <td class="text-center">
                                        @can('schedules.edit')
                                            <a href="{{ route('admin.schedules.edit', $schedule->schedule_id) }}" class="btn btn-sm btn-primary me-1">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                        @endcan
                                        @can('schedules.delete')
                                            <button onClick="Delete(this.id)" class="btn btn-sm btn-danger" id="{{ $schedule->schedule_id }}">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Belum ada data schedule</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-center">
                            {{ $schedules->links('vendor.pagination.bootstrap-5') }}
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
                fetch(`/admin/schedules/${id}`, {
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
