<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MainCategory;
use Illuminate\Http\Request;

class MainCategoryController extends Controller
{
    /**
     * Tampilkan semua kategori
     */
    public function index(Request $request)
    {
        $q = $request->q;

        $categories = MainCategory::with('subcategories')
            ->when($q, fn($query) => $query->where('name', 'like', "%$q%"))
            ->paginate(10);

        return view('admin.categories.main.index', compact('categories'));
    }

    /**
     * Tampilkan form create
     */
    public function create()
    {
        return view('admin.categories.main.form', [
            'action' => 'store',
            'maincategory' => null
        ]);
    }

    /**
     * Simpan kategori baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:main_categories,name',
        ]);

        MainCategory::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.maincategories.index')
            ->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Tampilkan form edit
     */
    public function edit($id)
    {
        $maincategory = MainCategory::findOrFail($id);

        return view('admin.categories.main.form', [
            'action' => 'update',
            'maincategory' => $maincategory
        ]);
    }

    /**
     * Update kategori
     */
    public function update(Request $request, $id)
    {
        $maincategory = MainCategory::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100|unique:main_categories,name,' . $maincategory->main_category_id . ',main_category_id',
        ]);

        $maincategory->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.maincategories.index')
            ->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Hapus kategori
     */
    public function destroy($id)
    {
        $maincategory = MainCategory::findOrFail($id);

        try {
            $maincategory->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Kategori berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kategori gagal dihapus!'
            ]);
        }
    }
}
