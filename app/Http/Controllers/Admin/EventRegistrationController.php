<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventRegistration;
use App\Models\EventSchedule;
use App\Models\User;
use Illuminate\Http\Request;

class EventRegistrationController extends Controller
{
    /**
     * List Registration
     */
    public function index(Request $request)
    {
        $q = $request->q;

        $registrations = EventRegistration::with(['user','schedule.event'])
            ->when($q, function($query) use ($q) {
                $query->whereHas('user', function($sub) use ($q) {
                    $sub->where('name','like',"%$q%");
                })->orWhereHas('schedule.event', function($sub) use ($q) {
                    $sub->where('title','like',"%$q%");
                })->orWhere('team_name','like',"%$q%");
            })
            ->orderBy('created_at','desc')
            ->paginate(10);

        return view('admin.registrations.index', compact('registrations'));
    }

    /**
     * Show form create
     */
    public function create()
    {
        $users     = User::orderBy('name')->get();
        $schedules = EventSchedule::with('event')->orderBy('start_time')->get();

        return view('admin.registrations.form', [
            'action'        => 'store',
            'registration'  => new EventRegistration(),
            'users'         => $users,
            'schedules'     => $schedules,
        ]);
    }

    /**
     * Store new registration
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id'     => 'required|exists:users,id',
            'schedule_id' => 'required|exists:event_schedules,schedule_id',
            'status'      => 'required|in:pending,approved,rejected',
            'team_name'   => 'nullable|string|max:255',
        ]);

        EventRegistration::create($request->only(['user_id','schedule_id','status','team_name']));

        return redirect()->route('admin.registrations.index')
                         ->with('success','Registrasi berhasil ditambahkan!');
    }

    /**
     * Show form edit
     */
    public function edit($registration_id)
    {
        $registration = EventRegistration::findOrFail($registration_id);
        $users        = User::orderBy('name')->get();
        $schedules    = EventSchedule::with('event')->orderBy('start_time')->get();

        return view('admin.registrations.form', [
            'action'        => 'update',
            'registration'  => $registration,
            'users'         => $users,
            'schedules'     => $schedules,
        ]);
    }

    /**
     * Update registration
     */
    public function update(Request $request, $registration_id)
    {
        $registration = EventRegistration::findOrFail($registration_id);

        $request->validate([
            'user_id'     => 'required|exists:users,id',
            'schedule_id' => 'required|exists:event_schedules,schedule_id',
            'status'      => 'required|in:pending,approved,rejected',
            'team_name'   => 'nullable|string|max:255',
        ]);

        $registration->update($request->only(['user_id','schedule_id','status','team_name']));

        return redirect()->route('admin.registrations.index')
                         ->with('success','Registrasi berhasil diperbarui!');
    }

    /**
     * Destroy registration
     */
    public function destroy($registration_id)
    {
        $registration = EventRegistration::findOrFail($registration_id);

        try {
            $registration->delete();

            return response()->json([
                'status'  => 'success',
                'message' => 'Registrasi berhasil dihapus!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Registrasi gagal dihapus!',
            ]);
        }
    }
}
