@extends('layouts.app_fix')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header mb-4">
            <h1 class="h3 fw-bold">Permissions</h1>
        </div>

        <div class="section-body">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <h4 class="mb-0">
                        <i class="fas fa-key me-2"></i> Permissions
                    </h4>
                </div>

                <div class="card-body">
                    <!-- Search -->
                    <form action="{{ route('admin.permission.index') }}" method="GET" class="mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" name="q"
                                   placeholder="Cari berdasarkan nama permission">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-search me-1"></i> Cari
                            </button>
                        </div>
                    </form>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" class="text-center" style="width: 6%">No.</th>
                                    <th scope="col">Nama Permission</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($permissions as $no => $permission)
                                    <tr>
                                        <th scope="row" class="text-center">
                                            {{ ++$no + ($permissions->currentPage()-1) * $permissions->perPage() }}
                                        </th>
                                        <td>{{ $permission->name }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center text-muted">
                                            <em>Belum ada data permission</em>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $permissions->links("vendor.pagination.bootstrap-5") }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
    