<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class EventController extends Controller
{
    /**
     * List Event
     */
    public function index(Request $request)
    {
        $q = $request->q;

        $events = Event::with(['parent','group'])
            ->when($q, function($query) use ($q) {
                $query->where('title','like',"%$q%")
                      ->orWhere('location','like',"%$q%");
            })
            ->orderBy('start_date','desc')
            ->paginate(10);

        return view('admin.events.index', compact('events'));
    }

    /**
     * Form Create
     */
    public function create()
    {
        $groups = Group::all();
        $events = Event::all(); // untuk parent dropdown

        return view('admin.events.form', [
            'action' => 'store',
            'event'  => null,
            'groups' => $groups,
            'events' => $events
        ]);
    }

    /**
     * Store Event
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'location'       => 'nullable|string|max:255',
            'banner_url'     => 'nullable|image|max:2048',
            'start_date'     => 'required|date',
            'end_date'       => 'nullable|date|after_or_equal:start_date',
            'host_group_id'  => 'nullable|exists:groups,group_id',
            'parent_event_id'=> 'nullable|exists:events,event_id',
        ]);

        $data = $request->only([
            'parent_event_id','host_group_id','title','description',
            'location','start_date','end_date'
        ]);

        $data['start_date'] = Carbon::parse($data['start_date'])->format('Y-m-d H:i:s');
        if (!empty($data['end_date'])) {
            $data['end_date'] = Carbon::parse($data['end_date'])->format('Y-m-d H:i:s');
        }

        if ($request->hasFile('banner_url')) {
            $data['banner_url'] = $request->file('banner_url')->store('events/banners', 'public');
        }

        Event::create($data);

        return redirect()->route('admin.events.index')->with('success','Event berhasil ditambahkan!');
    }

    /**
     * Form Edit
     */
    public function edit($id)
    {
        $event  = Event::findOrFail($id);
        $groups = Group::all();
        $events = Event::where('event_id','!=',$id)->get(); // exclude dirinya sendiri

        return view('admin.events.form', [
            'action' => 'update',
            'event'  => $event,
            'groups' => $groups,
            'events' => $events
        ]);
    }

    /**
     * Update Event
     */
    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'location'       => 'nullable|string|max:255',
            'banner_url'     => 'nullable|image|max:2048',
            'start_date'     => 'required|date',
            'end_date'       => 'nullable|date|after_or_equal:start_date',
            'host_group_id'  => 'nullable|exists:groups,group_id',
            'parent_event_id'=> 'nullable|exists:events,event_id',
        ]);

        $data = $request->only([
            'parent_event_id','host_group_id','title','description',
            'location','start_date','end_date'
        ]);

        $data['start_date'] = Carbon::parse($data['start_date'])->format('Y-m-d H:i:s');
        if (!empty($data['end_date'])) {
            $data['end_date'] = Carbon::parse($data['end_date'])->format('Y-m-d H:i:s');
        }

        if ($request->hasFile('banner_url')) {
            if ($event->banner_url) {
                Storage::disk('public')->delete($event->banner_url);
            }
            $data['banner_url'] = $request->file('banner_url')->store('events/banners', 'public');
        }

        $event->update($data);

        return redirect()->route('admin.events.index')->with('success','Event berhasil diperbarui!');
    }

    /**
     * Destroy Event
     */
    public function destroy($id)
    {
        $event = Event::findOrFail($id);

        try {
            if ($event->banner_url) {
                Storage::disk('public')->delete($event->banner_url);
            }
            $event->delete();

            return response()->json([
                'status'=>'success',
                'message'=>'Event berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'=>'error',
                'message'=>'Event gagal dihapus!'
            ]);
        }
    }
}
