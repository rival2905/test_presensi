@extends('layouts.app_fix')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Roles</h1>
        </div>

        <div class="section-body">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h4 class="mb-0"><i class="fas fa-unlock"></i> Roles</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.role.index') }}" method="GET">
                        <div class="mb-3">
                            <div class="input-group">
                                @can('roles.create')
                                    <a href="{{ route('admin.role.create') }}" class="btn btn-primary me-2">
                                        <i class="fa fa-plus-circle"></i> TAMBAH
                                    </a>
                                @endcan
                                <input type="text" class="form-control" name="q"
                                       placeholder="Cari berdasarkan nama role">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-search"></i> CARI
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" style="width: 6%">NO.</th>
                                    <th style="width: 15%">NAMA ROLE</th>
                                    <th>PERMISSIONS</th>
                                    <th class="text-center" style="width: 15%">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($roles as $no => $role)
                                <tr>
                                    <td class="text-center">
                                        {{ ++$no + ($roles->currentPage()-1) * $roles->perPage() }}
                                    </td>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        @foreach($role->getPermissionNames() as $permission)
                                            <span class="badge bg-success mb-1">{{ $permission }}</span>
                                        @endforeach
                                    </td>
                                    <td class="text-center">
                                        @can('roles.edit')
                                            <a href="{{ route('admin.role.edit', $role->id) }}" 
                                               class="btn btn-sm btn-primary me-1">
                                                <i class="fa fa-pencil-alt"></i>
                                            </a>
                                        @endcan
                                        
                                        @can('roles.delete')
                                            <button onClick="Delete(this.id)" 
                                                    class="btn btn-sm btn-danger" 
                                                    id="{{ $role->id }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-center">
                            {{ $roles->links("vendor.pagination.bootstrap-5") }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    //ajax delete
    function Delete(id) {
        var token = $("meta[name='csrf-token']").attr("content");

        swal({
            title: "APAKAH KAMU YAKIN ?",
            text: "INGIN MENGHAPUS DATA INI!",
            icon: "warning",
            buttons: ['TIDAK','YA'],
            dangerMode: true,
        }).then(function(isConfirm) {
            if (isConfirm) {
                jQuery.ajax({
                    url: "/admin/role/"+id,
                    data: { "id": id, "_token": token },
                    type: 'DELETE',
                    success: function (response) {
                        if (response.status == "success") {
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
        })
    }
</script>
@stop
