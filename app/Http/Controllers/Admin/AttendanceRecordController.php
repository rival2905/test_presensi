<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRecord;
use App\Models\Activity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AttendanceRecordController extends Controller
{
    /**
     * Tampilkan semua attendance records
     */
    public function index(Request $request)
    {
        $q = $request->q;

        $records = AttendanceRecord::with(['user', 'activity'])
            ->when($q, function($query) use ($q) {
                $query->whereHas('user', fn($q1) => $q1->where('name', 'like', "%$q%"))
                      ->orWhereHas('activity', fn($q2) => $q2->where('name', 'like', "%$q%"));
            })
            ->orderBy('timestamp', 'desc')
            ->paginate(10);

        return view('admin.attendance_records.index', compact('records'));
    }

    /**
     * Form create
     */
    public function create()
    {
        $users = User::all();
        $activities = Activity::all();

        return view('admin.attendance_records.form', [
            'action' => 'store',
            'record' => null,
            'users' => $users,
            'activities' => $activities
        ]);
    }

    /**
     * Simpan attendance record baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'activity_id' => 'required|exists:activities,activity_id',
            'status' => 'required|in:masuk,izin,sakit', // sesuai enum DB
            'reason' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:2048',
            'attachment' => 'nullable|file|max:5120',
            'timestamp' => 'required|date',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $data = $request->only([
            'user_id','activity_id','status','reason','timestamp','latitude','longitude'
        ]);

        // format timestamp ke MySQL datetime
        $data['timestamp'] = Carbon::parse($data['timestamp'])->format('Y-m-d H:i:s');

        if ($request->hasFile('photo')) {
            $data['photo_url'] = $request->file('photo')->store('attendance/photos', 'public');
        }

        if ($request->hasFile('attachment')) {
            $data['attachment_url'] = $request->file('attachment')->store('attendance/attachments', 'public');
        }

        AttendanceRecord::create($data);

        return redirect()->route('admin.attendance-records.index')
            ->with('success', 'Attendance record berhasil ditambahkan!');
    }

    /**
     * Form edit
     */
    public function edit($id)
    {
        $record = AttendanceRecord::findOrFail($id);
        $users = User::all();
        $activities = Activity::all();

        return view('admin.attendance_records.form', [
            'action' => 'update',
            'record' => $record,
            'users' => $users,
            'activities' => $activities
        ]);
    }

    /**
     * Update attendance record
     */
    public function update(Request $request, $id)
    {
        $record = AttendanceRecord::findOrFail($id);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'activity_id' => 'required|exists:activities,activity_id',
            'status' => 'required|in:masuk,izin,sakit', // sesuai enum DB
            'reason' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:2048',
            'attachment' => 'nullable|file|max:5120',
            'timestamp' => 'required|date',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $data = $request->only([
            'user_id','activity_id','status','reason','timestamp','latitude','longitude'
        ]);

        // format timestamp ke MySQL datetime
        $data['timestamp'] = Carbon::parse($data['timestamp'])->format('Y-m-d H:i:s');

        if ($request->hasFile('photo')) {
            if ($record->photo_url) Storage::disk('public')->delete($record->photo_url);
            $data['photo_url'] = $request->file('photo')->store('attendance/photos', 'public');
        }

        if ($request->hasFile('attachment')) {
            if ($record->attachment_url) Storage::disk('public')->delete($record->attachment_url);
            $data['attachment_url'] = $request->file('attachment')->store('attendance/attachments', 'public');
        }

        $record->update($data);

        return redirect()->route('admin.attendance-records.index')
            ->with('success', 'Attendance record berhasil diperbarui!');
    }

    /**
     * Hapus attendance record
     */
    public function destroy($id)
    {
        $record = AttendanceRecord::findOrFail($id);

        try {
            if ($record->photo_url) Storage::disk('public')->delete($record->photo_url);
            if ($record->attachment_url) Storage::disk('public')->delete($record->attachment_url);

            $record->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Attendance record berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Attendance record gagal dihapus!'
            ]);
        }
    }
}
