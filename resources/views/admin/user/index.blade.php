@extends('layouts.app_fix')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header mb-4">
            <h1 class="h3 fw-bold">Users</h1>
        </div>

        <div class="section-body">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <h4 class="mb-0">
                        <i class="fas fa-users me-2"></i> Users
                    </h4>
                </div>

                <div class="card-body">
                    {{-- Search & Tambah --}}
                    <form action="{{ route('admin.user.index') }}" method="GET" class="mb-3">
                        <div class="input-group">
                            @can('users.create')
                                <a href="{{ route('admin.user.create') }}" class="btn btn-primary me-2">
                                    <i class="fa fa-plus-circle me-1"></i> Tambah
                                </a>
                            @endcan
                            <input type="text" class="form-control" name="q" placeholder="Cari berdasarkan nama user">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-search me-1"></i> Cari
                            </button>
                        </div>
                    </form>

                    {{-- Table --}}
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" class="text-center" style="width: 6%">No.</th>
                                    <th scope="col">Nama User</th>
                                    <th scope="col">Role</th>
                                    <th scope="col" class="text-center" style="width: 15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $no => $user)
                                    <tr>
                                        <td class="text-center">
                                            {{ ++$no + ($users->currentPage()-1) * $users->perPage() }}
                                        </td>
                                        <td>{{ $user->name }}</td>
                                        <td>
                                            @if(!empty($user->getRoleNames()))
                                                @foreach($user->getRoleNames() as $role)
                                                    <span class="badge bg-success mb-1">{{ $role }}</span>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @can('users.edit')
                                                <a href="{{ route('admin.user.edit', $user->id) }}" 
                                                   class="btn btn-sm btn-primary me-1">
                                                    <i class="fa fa-pencil-alt"></i>
                                                </a>
                                            @endcan
                                            
                                            @can('users.delete')
                                                <button onClick="Delete(this.id)" 
                                                        class="btn btn-sm btn-danger" 
                                                        id="{{ $user->id }}">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">
                                            <em>Belum ada data user</em>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{-- Pagination --}}
                        <div class="d-flex justify-content-center mt-3">
                            {{ $users->links("vendor.pagination.bootstrap-5") }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    // Ajax Delete
    function Delete(id) {
        let token = $("meta[name='csrf-token']").attr("content");

        swal({
            title: "APAKAH KAMU YAKIN ?",
            text: "INGIN MENGHAPUS DATA INI!",
            icon: "warning",
            buttons: ['TIDAK','YA'],
            dangerMode: true,
        }).then(function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: "/admin/user/destroy/" + id,
                    data: { "id": id, "_token": token },
                    type: 'DELETE',
                    success: function (response) {
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
                    }
                });
            }
        });
    }
</script>
@stop
