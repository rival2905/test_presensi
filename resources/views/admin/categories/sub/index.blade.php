@extends('layouts.app_fix')

@section('content')
<div class="main-content">
    <section class="section">
        <!-- Header -->
        <div class="section-header">
            <h1>Sub Categories</h1>
        </div>

        <div class="section-body">
            <div class="card shadow-sm border-0">
                <!-- Card Header -->
                <div class="card-header bg-white">
                    <h4 class="mb-0">
                        <i class="fa-solid fa-list me-2"></i> Sub Categories
                    </h4>
                </div>

                <div class="card-body">
                    <!-- Search + Tambah -->
                    <form action="{{ route('admin.subcategories.index') }}" method="GET">
                        <div class="mb-3">
                            <div class="input-group">
                                @can('categories.create')
                                    <a href="{{ route('admin.subcategories.create') }}" class="btn btn-primary me-2">
                                        <i class="fa-solid fa-circle-plus me-1"></i> TAMBAH
                                    </a>
                                @endcan
                                <input type="text" class="form-control" name="q"
                                       placeholder="Cari berdasarkan nama sub kategori"
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
                                    <th>NAMA SUB KATEGORI</th>
                                    <th>MAIN CATEGORY</th>
                                    <th class="text-center" style="width: 15%">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($subcategories as $no => $sub)
                                <tr>
                                    <td class="text-center">
                                        {{ ++$no + ($subcategories->currentPage()-1) * $subcategories->perPage() }}
                                    </td>
                                    <td>{{ $sub->name }}</td>
                                    <td>{{ $sub->mainCategory->name ?? '-' }}</td>
                                    <td class="text-center">
                                        @can('categories.edit')
                                            <a href="{{ route('admin.subcategories.edit', $sub->subcategory_id) }}" 
                                               class="btn btn-sm btn-primary me-1">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                        @endcan

                                        @can('categories.delete')
                                            <button onClick="Delete(this.id)" 
                                                    class="btn btn-sm btn-danger" 
                                                    id="{{ $sub->subcategory_id }}">
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
                            {{ $subcategories->links('vendor.pagination.bootstrap-5') }}
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
                fetch(`/admin/subcategories/${id}`, {
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
