<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrganizationController extends Controller
{
    /**
     * Tampilkan semua organization
     */
    public function index(Request $request)
    {
        $q = $request->q;

        $organizations = Organization::with('parent')
            ->when($q, fn($query) => $query->where('name', 'like', "%$q%"))
            ->paginate(10);

        return view('admin.organizations.index', compact('organizations'));
    }

    /**
     * Form create
     */
    public function create()
    {
        return view('admin.organizations.form', [
            'action' => 'store',
            'organization' => null,
            'parents' => Organization::all()
        ]);
    }

    /**
     * Simpan organization baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:organizations,name',
            'address' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:255',
            'logo_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'parent_organization_id' => 'nullable|exists:organizations,organization_id'
        ]);

        $logoPath = $request->file('logo_url')
            ? $request->file('logo_url')->store('logos', 'public')
            : null;

        Organization::create([
            'name' => $request->name,
            'address' => $request->address,
            'contact' => $request->contact,
            'logo_url' => $logoPath,
            'parent_organization_id' => $request->parent_organization_id
        ]);

        return redirect()->route('admin.organizations.index')
            ->with('success', 'Organization berhasil ditambahkan!');
    }

    /**
     * Form edit
     */
    public function edit($id)
    {
        $organization = Organization::findOrFail($id);

        return view('admin.organizations.form', [
            'action' => 'update',
            'organization' => $organization,
            'parents' => Organization::where('organization_id', '!=', $id)->get()
        ]);
    }

    /**
     * Update organization
     */
    public function update(Request $request, $id)
    {
        $organization = Organization::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:organizations,name,' . $organization->organization_id . ',organization_id',
            'address' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:255',
            'logo_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'parent_organization_id' => 'nullable|exists:organizations,organization_id'
        ]);

        // Upload logo baru dan hapus logo lama jika ada
        if ($request->hasFile('logo_url')) {
            if ($organization->logo_url) {
                Storage::disk('public')->delete($organization->logo_url);
            }
            $organization->logo_url = $request->file('logo_url')->store('logos', 'public');
        }

        $organization->name = $request->name;
        $organization->address = $request->address;
        $organization->contact = $request->contact;
        $organization->parent_organization_id = $request->parent_organization_id;
        $organization->save();

        return redirect()->route('admin.organizations.index')
            ->with('success', 'Organization berhasil diperbarui!');
    }

    /**
     * Hapus organization
     */
    public function destroy($id)
    {
        $organization = Organization::findOrFail($id);

        try {
            if ($organization->logo_url) {
                Storage::disk('public')->delete($organization->logo_url);
            }
            $organization->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Organization berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Organization gagal dihapus!'
            ]);
        }
    }
}
