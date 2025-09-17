<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use App\Models\MainCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    /**
     * Tampilkan semua subcategory
     */
    public function index(Request $request)
    {
        $q = $request->q;

        $subcategories = SubCategory::with('mainCategory')
            ->when($q, fn($query) => $query->where('name', 'like', "%$q%"))
            ->orderByDesc('subcategory_id') // sesuaikan dengan model
            ->paginate(10);

        return view('admin.categories.sub.index', compact('subcategories'));
    }

    /**
     * Form create
     */
    public function create()
    {
        $maincategories = MainCategory::all();

        return view('admin.categories.sub.form', [
            'action' => 'store',
            'subcategory' => null,
            'maincategories' => $maincategories
        ]);
    }

    /**
     * Simpan subcategory baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'main_category_id' => 'required|exists:main_categories,main_category_id',
            'name' => 'required|string|max:100|unique:sub_categories,name',
        ]);

        SubCategory::create($request->only('main_category_id', 'name'));

        return redirect()->route('admin.subcategories.index')
            ->with('success', 'Subcategory berhasil ditambahkan!');
    }

    /**
     * Form edit
     */
    public function edit($id)
    {
        $subcategory = SubCategory::findOrFail($id);
        $maincategories = MainCategory::all();

        return view('admin.categories.sub.form', [
            'action' => 'update',
            'subcategory' => $subcategory,
            'maincategories' => $maincategories
        ]);
    }

    /**
     * Update subcategory
     */
    public function update(Request $request, $id)
    {
        $subcategory = SubCategory::findOrFail($id);

        $request->validate([
            'main_category_id' => 'required|exists:main_categories,main_category_id',
            'name' => 'required|string|max:100|unique:sub_categories,name,' 
                        . $subcategory->subcategory_id . ',subcategory_id', // sesuaikan nama pk
        ]);

        $subcategory->update($request->only('main_category_id', 'name'));

        return redirect()->route('admin.subcategories.index')
            ->with('success', 'Subcategory berhasil diperbarui!');
    }

    /**
     * Hapus subcategory
     */
    public function destroy($id)
    {
        $subcategory = SubCategory::findOrFail($id);

        try {
            $subcategory->delete();

            if (request()->expectsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Subcategory berhasil dihapus!'
                ]);
            }

            return redirect()->route('admin.subcategories.index')
                ->with('success', 'Subcategory berhasil dihapus!');
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Subcategory gagal dihapus!'
                ]);
            }

            return redirect()->route('admin.subcategories.index')
                ->with('error', 'Subcategory gagal dihapus!');
        }
    }
}
