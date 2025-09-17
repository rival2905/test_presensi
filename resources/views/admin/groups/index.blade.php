@extends('layouts.app_fix')

@section('content')
<div class="main-content">
    <section class="section">
        <!-- Header -->
        <div class="section-header">
            <h1>Groups</h1>
        </div>

        <div class="section-body">
            <div class="card shadow-sm border-0">
                <!-- Card Header -->
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fa-solid fa-users me-2"></i> Groups
                    </h4>
                </div>

                <div class="card-body">
                    <!-- Search + Tambah -->
                    <form action="{{ route('admin.groups.index') }}" method="GET" class="mb-3">
                        <div class="input-group">
                            @can('groups.create')
                                <a href="{{ route('admin.groups.create') }}" class="btn btn-primary me-2">
                                    <i class="fa-solid fa-circle-plus me-1"></i> TAMBAH
                                </a>
                            @endcan
                            <input type="text" class="form-control" name="q"
                                   placeholder="Cari berdasarkan nama grup"
                                   value="{{ request('q') }}">
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
                                    <th class="text-center" style="width: 5%">NO.</th>
                                    <th>NAMA GROUP</th>
                                    <th>ORGANIZATION</th>
                                    <th>TYPE</th>
                                    <th>DESKRIPSI</th>
                                    <th class="text-center" style="width: 15%">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse ($groups as $no => $group)
                                <tr>
                                    <td class="text-center">
                                        {{ ++$no + ($groups->currentPage()-1) * $groups->perPage() }}
                                    </td>
                                    <td>{{ $group->name }}</td>
                                    <td>{{ $group->organization?->name ?? '-' }}</td>
                                    <td>
                                        <span class="badge {{ $group->type == 'formal' ? 'bg-success' : 'bg-info' }}">
                                            {{ ucfirst($group->type) }}
                                        </span>
                                    </td>
                                    <td>{{ $group->description ?? '-' }}</td>
                                    <td class="text-center">
                                        @can('groups.edit')
                                            <a href="{{ route('admin.groups.edit', $group->group_id) }}" 
                                               class="btn btn-sm btn-warning me-1">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                        @endcan

                                        @can('groups.delete')
                                            <button onClick="Delete(this.id)" 
                                                    class="btn btn-sm btn-danger" 
                                                    id="{{ $group->group_id }}">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Data group tidak ditemukan</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $groups->links('vendor.pagination.bootstrap-5') }}
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
                fetch(`/admin/groups/${id}`, {
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
