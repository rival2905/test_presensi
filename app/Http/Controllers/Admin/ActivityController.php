<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Group;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ActivityController extends Controller
{
    /**
     * Tampilkan semua aktivitas
     */
    public function index(Request $request)
    {
        $q = $request->q;

        $activities = Activity::with('group')
            ->when($q, fn($query) => $query->where('name', 'like', "%$q%"))
            ->orderBy('start_date', 'desc')
            ->paginate(10);

        // Tambahkan status ongoing / selesai / belum dimulai
        $activities->map(function($activity) {
            $now = Carbon::now();
            if ($now->between(Carbon::parse($activity->start_date), Carbon::parse($activity->end_date))) {
                $activity->status = 'Ongoing';
            } elseif ($now->gt(Carbon::parse($activity->end_date))) {
                $activity->status = 'Selesai';
            } else {
                $activity->status = 'Belum Dimulai';
            }
            return $activity;
        });

        return view('admin.activities.index', compact('activities'));
    }

    /**
     * Tampilkan form create
     */
    public function create()
    {
        $groups = Group::all();

        return view('admin.activities.form', [
            'action' => 'store',
            'activity' => null,
            'groups' => $groups
        ]);
    }

    /**
     * Simpan aktivitas baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'group_id' => 'required|exists:groups,group_id',
            'name' => 'required|string|max:255|unique:activities,name',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        Activity::create($request->only(['group_id','name','description','start_date','end_date']));

        return redirect()->route('admin.activities.index')
            ->with('success', 'Activity berhasil ditambahkan!');
    }

    /**
     * Tampilkan form edit
     */
    public function edit($id)
    {
        $activity = Activity::findOrFail($id);
        $groups = Group::all();

        return view('admin.activities.form', [
            'action' => 'update',
            'activity' => $activity,
            'groups' => $groups
        ]);
    }

    /**
     * Update aktivitas
     */
    public function update(Request $request, $id)
    {
        $activity = Activity::findOrFail($id);

        $request->validate([
            'group_id' => 'required|exists:groups,group_id',
            'name' => 'required|string|max:255|unique:activities,name,' . $activity->activity_id . ',activity_id',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $activity->update($request->only(['group_id','name','description','start_date','end_date']));

        return redirect()->route('admin.activities.index')
            ->with('success', 'Activity berhasil diperbarui!');
    }

    /**
     * Hapus aktivitas
     */
    public function destroy($id)
    {
        $activity = Activity::findOrFail($id);

        try {
            $activity->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Activity berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Activity gagal dihapus!'
            ]);
        }
    }
}
