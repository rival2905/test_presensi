<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Organization;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * List groups
     */
    public function index(Request $request)
    {
        $q = $request->q;

        $groups = Group::with('organization')
            ->when($q, fn($query) => $query->where('name', 'like', "%$q%"))
            ->paginate(10);

        return view('admin.groups.index', compact('groups'));
    }

    /**
     * Form create
     */
    public function create()
    {
        return view('admin.groups.form', [
            'action' => 'store',
            'group' => null,
            'organizations' => Organization::all()
        ]);
    }

    /**
     * Store new group
     */
    public function store(Request $request)
    {
        $request->validate([
            'organization_id' => 'required|exists:organizations,organization_id',
            'name' => 'required|string|max:255|unique:groups,name,NULL,group_id,organization_id,' . $request->organization_id,
            'type' => 'required|in:formal,informal',
            'description' => 'nullable|string'
        ]);

        Group::create([
            'organization_id' => $request->organization_id,
            'name' => $request->name,
            'type' => $request->type,
            'description' => $request->description
        ]);

        return redirect()->route('admin.groups.index')
            ->with('success', 'Group berhasil ditambahkan!');
    }

    /**
     * Form edit
     */
    public function edit($id)
    {
        $group = Group::findOrFail($id);

        return view('admin.groups.form', [
            'action' => 'update',
            'group' => $group,
            'organizations' => Organization::all()
        ]);
    }

    /**
     * Update group
     */
    public function update(Request $request, $id)
    {
        $group = Group::findOrFail($id);

        $request->validate([
            'organization_id' => 'required|exists:organizations,organization_id',
            'name' => 'required|string|max:255|unique:groups,name,' . $group->group_id . ',group_id,organization_id,' . $request->organization_id,
            'type' => 'required|in:formal,informal',
            'description' => 'nullable|string'
        ]);

        $group->update([
            'organization_id' => $request->organization_id,
            'name' => $request->name,
            'type' => $request->type,
            'description' => $request->description
        ]);

        return redirect()->route('admin.groups.index')
            ->with('success', 'Group berhasil diperbarui!');
    }

    /**
     * Delete group
     */
    public function destroy($id)
    {
        $group = Group::findOrFail($id);

        try {
            $group->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Group berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Group gagal dihapus!'
            ]);
        }
    }
}
