@extends('layouts.app_fix')

@section('content')
<div class="main-content">
    <section class="section">
        <!-- Header -->
        <div class="section-header">
            <h1>Organizations</h1>
        </div>

        <div class="section-body">
            <div class="card shadow-sm border-0">
                <!-- Card Header -->
                <div class="card-header bg-white">
                    <h4 class="mb-0">
                        <i class="fa-solid fa-building me-2"></i> Organizations
                    </h4>
                </div>

                <div class="card-body">
                    <!-- Search + Tambah -->
                    <form action="{{ route('admin.organizations.index') }}" method="GET">
                        <div class="mb-3">
                            <div class="input-group">
                                @can('organizations.create')
                                    <a href="{{ route('admin.organizations.create') }}" class="btn btn-primary me-2">
                                        <i class="fa-solid fa-circle-plus me-1"></i> TAMBAH
                                    </a>
                                @endcan
                                <input type="text" class="form-control" name="q"
                                       placeholder="Cari berdasarkan nama organisasi"
                                       value="{{ request('q') }}">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa-solid fa-magnifying-glass me-1"></i> CARI
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" style="width: 6%">NO.</th>
                                    <th>LOGO</th>
                                    <th>NAMA ORGANISASI</th>
                                    <th>PARENT</th>
                                    <th>ALAMAT</th>
                                    <th>KONTAK</th>
                                    <th class="text-center" style="width: 15%">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
@forelse ($organizations as $no => $org)
    <tr>
        <td class="text-center">
            {{ ++$no + ($organizations->currentPage()-1) * $organizations->perPage() }}
        </td>
        <td>
            @if($org->logo_url)
                <img src="{{ asset('storage/'.$org->logo_url) }}" width="50" alt="Logo">
            @else
                <span class="text-muted">-</span>
            @endif
        </td>
        <td>{{ $org->name }}</td>
        <td>{{ $org->parent?->name ?? '-' }}</td>
        <td>{{ $org->address ?? '-' }}</td>
        <td>{{ $org->contact ?? '-' }}</td>
        <td class="text-center">
            @can('organizations.edit')
                <a href="{{ route('admin.organizations.edit', $org->organization_id) }}" 
                   class="btn btn-sm btn-primary me-1">
                    <i class="fa-solid fa-pen-to-square"></i>
                </a>
            @endcan

            @can('organizations.delete')
                <button onClick="Delete(this.id)" 
                        class="btn btn-sm btn-danger" 
                        id="{{ $org->organization_id }}">
                    <i class="fa-solid fa-trash"></i>
                </button>
            @endcan
        </td>
    </tr>
@empty
    <tr>
        <td colspan="7" class="text-center text-muted">Data tidak ditemukan</td>
    </tr>
@endforelse
</tbody>

                        </table>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $organizations->links('vendor.pagination.bootstrap-5') }}
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
                fetch(`/admin/organizations/${id}`, {
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
