@extends('layouts.app_fix')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Event Registrations</h1>
        </div>

        <div class="section-body">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fa-solid fa-users me-2"></i> Daftar Event Registrations
                    </h4>
                    @can('registrations.create')
                    <a href="{{ route('admin.registrations.create') }}" class="btn btn-primary">
                        <i class="fa-solid fa-plus me-1"></i> Tambah Registrasi
                    </a>
                    @endcan
                </div>

                <div class="card-body">
                    <!-- Search -->
                    <form action="{{ route('admin.registrations.index') }}" method="GET" class="mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" name="q" placeholder="Cari berdasarkan user, event atau team name" value="{{ request('q') }}">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-magnifying-glass me-1"></i> CARI
                            </button>
                        </div>
                    </form>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" style="width:6%">NO.</th>
                                    <th>USER</th>
                                    <th>EVENT</th>
                                    <th>TEAM NAME</th>
                                    <th>STATUS</th>
                                    <th class="text-center" style="width:15%">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php $no = 1; @endphp
                            @forelse ($registrations as $registration)
                                <tr>
                                    <td class="text-center">{{ $no++ + ($registrations->currentPage()-1) * $registrations->perPage() }}</td>
                                    <td>{{ $registration->user?->name ?? '-' }}</td>
                                    <td>{{ $registration->schedule?->event?->title ?? '-' }}</td>
                                    <td>{{ $registration->team_name ?? '-' }}</td>
                                    <td>
                                        @if($registration->status == 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif($registration->status == 'approved')
                                            <span class="badge bg-success">Approved</span>
                                        @elseif($registration->status == 'rejected')
                                            <span class="badge bg-danger">Rejected</span>
                                        @else
                                            <span class="badge bg-secondary">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            @can('registrations.edit')
                                                <a href="{{ route('admin.registrations.edit', $registration->registration_id) }}" class="btn btn-sm btn-primary me-1">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                            @endcan
                                            @can('registrations.delete')
                                                <button onClick="Delete(this.id)" class="btn btn-sm btn-danger" id="{{ $registration->registration_id }}">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Belum ada data registrasi</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-center">
                            {{ $registrations->links('vendor.pagination.bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- SweetAlert Delete -->
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
                fetch(`/admin/registrations/${id}`, {
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
