@extends('layouts.app_fix')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Payments</h1>
        </div>

        <div class="section-body">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fa-solid fa-credit-card me-2"></i> Daftar Payments
                    </h4>
                    @can('payments.create')
                    <a href="{{ route('admin.payments.create') }}" class="btn btn-primary">
                        <i class="fa-solid fa-plus me-1"></i> Tambah Payment
                    </a>
                    @endcan
                </div>

                <div class="card-body">
                    <!-- Search -->
                    <form action="{{ route('admin.payments.index') }}" method="GET" class="mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" name="q" placeholder="Cari berdasarkan user atau event" value="{{ request('q') }}">
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
                                    <th>AMOUNT</th>
                                    <th>METHOD</th>
                                    <th>STATUS</th>
                                    <th class="text-center" style="width:15%">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php $no = 1; @endphp
                            @forelse ($payments as $payment)
                                <tr>
                                    <td class="text-center">{{ $no++ + ($payments->currentPage()-1) * $payments->perPage() }}</td>
                                    <td>{{ $payment->registration->user?->name ?? '-' }}</td>
                                    <td>{{ $payment->registration->schedule->event?->title ?? '-' }}</td>
                                    <td>Rp {{ number_format($payment->amount,0,',','.') }}</td>
                                    <td>{{ ucfirst($payment->payment_method) }}</td>
                                    <td>
                                        @if($payment->status == 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif($payment->status == 'paid')
                                            <span class="badge bg-success">Paid</span>
                                        @elseif($payment->status == 'failed')
                                            <span class="badge bg-danger">Failed</span>
                                        @else
                                            <span class="badge bg-secondary">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            @can('payments.edit')
                                                <a href="{{ route('admin.payments.edit', $payment->payment_id) }}" class="btn btn-sm btn-primary me-1">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                            @endcan
                                            @can('payments.delete')
                                                <button onClick="Delete(this.id)" class="btn btn-sm btn-danger" id="{{ $payment->payment_id }}">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Belum ada data payment</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-center">
                            {{ $payments->links('vendor.pagination.bootstrap-5') }}
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
                fetch(`/admin/payments/${id}`, {
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
