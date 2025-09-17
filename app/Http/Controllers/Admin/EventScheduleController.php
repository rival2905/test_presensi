<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventSchedule;
use App\Models\Event;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EventScheduleController extends Controller
{
    /**
     * List Schedule
     */
    public function index(Request $request)
    {
        $q = $request->q;

        $schedules = EventSchedule::with('event')
            ->when($q, function($query) use ($q) {
                $query->whereHas('event', function($sub) use ($q) {
                    $sub->where('title','like',"%$q%");
                });
            })
            ->orderBy('start_time','asc')
            ->paginate(10);

        return view('admin.event_schedules.index', compact('schedules'));
    }

    /**
     * Form Create
     */
    public function create()
    {
        $events = Event::orderBy('title')->get();

        return view('admin.event_schedules.form', [
            'action'   => 'store',
            'schedule' => null,
            'events'   => $events
        ]);
    }

    /**
     * Store Schedule
     */
    public function store(Request $request)
    {
        $request->validate([
            'event_id'   => 'required|exists:events,event_id',
            'start_time' => 'required|date',
            'end_time'   => 'nullable|date|after_or_equal:start_time',
            'price'      => 'nullable|numeric|min:0',
            'quota'      => 'nullable|integer|min:0',
        ]);

        $data = $request->only(['event_id','start_time','end_time','price','quota']);
        $data['start_time'] = Carbon::parse($data['start_time'])->format('Y-m-d H:i:s');
        if (!empty($data['end_time'])) {
            $data['end_time'] = Carbon::parse($data['end_time'])->format('Y-m-d H:i:s');
        }

        EventSchedule::create($data);

        return redirect()
            ->route('admin.schedules.index')
            ->with('success','Jadwal berhasil ditambahkan!');
    }

    /**
     * Form Edit
     */
    public function edit($id)
    {
        $schedule = EventSchedule::findOrFail($id);
        $events = Event::orderBy('title')->get();

        return view('admin.event_schedules.form', [
            'action'   => 'update',
            'schedule' => $schedule,
            'events'   => $events
        ]);
    }

    /**
     * Update Schedule
     */
    public function update(Request $request, $id)
    {
        $schedule = EventSchedule::findOrFail($id);

        $request->validate([
            'event_id'   => 'required|exists:events,event_id',
            'start_time' => 'required|date',
            'end_time'   => 'nullable|date|after_or_equal:start_time',
            'price'      => 'nullable|numeric|min:0',
            'quota'      => 'nullable|integer|min:0',
        ]);

        $data = $request->only(['event_id','start_time','end_time','price','quota']);
        $data['start_time'] = Carbon::parse($data['start_time'])->format('Y-m-d H:i:s');
        if (!empty($data['end_time'])) {
            $data['end_time'] = Carbon::parse($data['end_time'])->format('Y-m-d H:i:s');
        }

        $schedule->update($data);

        return redirect()
            ->route('admin.schedules.index')
            ->with('success','Jadwal berhasil diperbarui!');
    }

    /**
     * Destroy Schedule
     */
    public function destroy($id)
    {
        $schedule = EventSchedule::findOrFail($id);

        try {
            $schedule->delete();

            return response()->json([
                'status'=>'success',
                'message'=>'Jadwal berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'=>'error',
                'message'=>'Jadwal gagal dihapus!'
            ]);
        }
    }
}
