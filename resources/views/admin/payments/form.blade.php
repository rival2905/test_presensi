@extends('layouts.app_fix')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ $action == 'store' ? 'Tambah' : 'Edit' }} Payment</h1>
        </div>

        <div class="section-body">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <form action="{{ $action == 'store' ? route('admin.payments.store') : route('admin.payments.update', $payment->payment_id) }}" method="POST">
                        @csrf
                        @if($action == 'update')
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label class="form-label">Registrasi</label>
                            <select name="registration_id" class="form-control" required>
                                <option value="">-- Pilih Registrasi --</option>
                                @foreach($registrations as $reg)
                                    <option value="{{ $reg->registration_id }}" {{ $payment->registration_id == $reg->registration_id ? 'selected' : '' }}>
                                        {{ $reg->user->name ?? '-' }} - {{ $reg->schedule->event->title ?? '-' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Amount (Rp)</label>
                            <input type="number" name="amount" class="form-control" value="{{ old('amount', $payment->amount) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Payment Method</label>
                            <select name="payment_method" class="form-control" required>
                                <option value="">-- Pilih Metode --</option>
                                <option value="cash" {{ $payment->payment_method=='cash' ? 'selected' : '' }}>Cash</option>
                                <option value="transfer" {{ $payment->payment_method=='transfer' ? 'selected' : '' }}>Transfer</option>
                                <option value="ewallet" {{ $payment->payment_method=='ewallet' ? 'selected' : '' }}>E-wallet</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="pending" {{ $payment->status=='pending' ? 'selected' : '' }}>Pending</option>
                                <option value="paid" {{ $payment->status=='paid' ? 'selected' : '' }}>Paid</option>
                                <option value="failed" {{ $payment->status=='failed' ? 'selected' : '' }}>Failed</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Paid At</label>
                            <input type="datetime-local" name="paid_at" class="form-control" value="{{ old('paid_at', $payment->paid_at ? date('Y-m-d\TH:i', strtotime($payment->paid_at)) : '') }}">
                        </div>

                        <button type="submit" class="btn btn-success">{{ $action == 'store' ? 'Simpan' : 'Update' }}</button>
                        <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
