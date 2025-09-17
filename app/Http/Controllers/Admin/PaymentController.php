<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\EventRegistration;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:payments.index')->only('index');
        $this->middleware('permission:payments.create')->only(['create','store']);
        $this->middleware('permission:payments.edit')->only(['edit','update']);
        $this->middleware('permission:payments.delete')->only('destroy');
    }

    // List Payments
    public function index(Request $request)
    {
        $q = $request->q;

        $payments = Payment::with('registration.user','registration.schedule.event')
            ->when($q, function($query) use ($q) {
                $query->whereHas('registration.user', fn($sub) => $sub->where('name','like',"%$q%"))
                      ->orWhereHas('registration.schedule.event', fn($sub) => $sub->where('title','like',"%$q%"));
            })
            ->orderBy('created_at','desc')
            ->paginate(10);

        return view('admin.payments.index', compact('payments'));
    }

    // Show create form
    public function create()
    {
        $registrations = EventRegistration::with('user','schedule.event')->orderBy('created_at','desc')->get();
        return view('admin.payments.form', [
            'action' => 'store',
            'payment' => new Payment(),
            'registrations' => $registrations
        ]);
    }

    // Store payment
    public function store(Request $request)
    {
        $request->validate([
            'registration_id' => 'required|exists:event_registrations,registration_id',
            'amount'         => 'required|numeric',
            'payment_method' => 'required|in:cash,transfer,ewallet',
            'status'         => 'required|in:pending,paid,failed',
            'paid_at'        => 'nullable|date',
        ]);

        Payment::create($request->only(['registration_id','amount','payment_method','status','paid_at']));

        return redirect()->route('admin.payments.index')->with('success','Payment berhasil ditambahkan!');
    }

    // Show edit form
    public function edit($payment_id)
    {
        $payment = Payment::findOrFail($payment_id);
        $registrations = EventRegistration::with('user','schedule.event')->orderBy('created_at','desc')->get();

        return view('admin.payments.form', [
            'action' => 'update',
            'payment' => $payment,
            'registrations' => $registrations
        ]);
    }

    // Update payment
    public function update(Request $request, $payment_id)
    {
        $payment = Payment::findOrFail($payment_id);

        $request->validate([
            'registration_id' => 'required|exists:event_registrations,registration_id',
            'amount'         => 'required|numeric',
            'payment_method' => 'required|in:cash,transfer,ewallet',
            'status'         => 'required|in:pending,paid,failed',
            'paid_at'        => 'nullable|date',
        ]);

        $payment->update($request->only(['registration_id','amount','payment_method','status','paid_at']));

        return redirect()->route('admin.payments.index')->with('success','Payment berhasil diperbarui!');
    }

    // Delete payment
    public function destroy($payment_id)
    {
        $payment = Payment::findOrFail($payment_id);

        try {
            $payment->delete();
            return response()->json(['status'=>'success','message'=>'Payment berhasil dihapus!']);
        } catch (\Exception $e) {
            return response()->json(['status'=>'error','message'=>'Payment gagal dihapus!']);
        }
    }
}
