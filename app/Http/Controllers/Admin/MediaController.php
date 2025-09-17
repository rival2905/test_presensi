<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class MediaController extends Controller
{
    /**
     * Tampilkan semua media (dengan filter type jika ada)
     */
    public function index(Request $request)
    {
        $q = $request->q;
        $type = $request->get('type'); // filter tipe lewat query string

        $medias = Media::when($q, fn($query) =>
                        $query->where('description', 'like', "%$q%"))
                    ->when($type, fn($query) =>
                        $query->where('type', $type))
                    ->orderBy('uploaded_at', 'desc')
                    ->paginate(10);

        return view('admin.medias.index', [
            'medias' => $medias,
            'type'   => $type,
        ]);
    }

    /**
     * Form upload media baru
     */
    public function create(Request $request)
    {
        $type = $request->get('type', 'image'); // default ke image

        return view('admin.medias.form', [
            'action' => 'store',
            'media'  => null,
            'type'   => $type, // dikirim ke form
        ]);
    }

    /**
     * Simpan media baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'type'        => 'required|in:image,video,document',
            'file'        => 'required|file|max:10240', // max 10MB
            'description' => 'nullable|string|max:255',
        ]);

        // Validasi mime sesuai type
        $mimeRules = match($request->type) {
            'image'    => 'mimes:jpeg,jpg,png,gif',
            'video'    => 'mimes:mp4,mov,avi',
            'document' => 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx',
            default    => '',
        };

        if ($mimeRules) {
            $request->validate(['file' => $mimeRules]);
        }

        try {
            $file = $request->file('file');
            $path = $file->store('uploads/medias', 'public');
            $mime = $file->getClientMimeType() ?: 'application/octet-stream';

            $media = Media::create([
                'user_id'     => Auth::id(),
                'group_id'    => null,
                'file_url'    => $path,
                'mime_type'   => $mime,
                'type'        => $request->type,
                'description' => $request->description,
                'uploaded_at' => now(),
            ]);

            return redirect()->route('admin.medias.index', ['type' => $media->type])
                             ->with('success', 'Media berhasil diupload!');
        } catch (\Exception $e) {
            return back()->withInput()
                         ->withErrors(['file' => 'Gagal upload media: '.$e->getMessage()]);
        }
    }

    /**
     * Form edit deskripsi / optional ganti file
     */
    public function edit($media_id)
    {
        $media = Media::findOrFail($media_id);

        return view('admin.medias.form', [
            'action' => 'update',
            'media'  => $media,
            'type'   => $media->type,
        ]);
    }

    /**
     * Update deskripsi media / optional ganti file
     */
    public function update(Request $request, $media_id)
    {
        $media = Media::findOrFail($media_id);

        $request->validate([
            'description' => 'nullable|string|max:255',
            'file'        => 'nullable|file|max:10240', // opsional ganti file
        ]);

        // Jika ada file baru, validasi mime sesuai type
        if ($request->hasFile('file')) {
            $mimeRules = match($media->type) {
                'image'    => 'mimes:jpeg,jpg,png,gif',
                'video'    => 'mimes:mp4,mov,avi',
                'document' => 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx',
                default    => '',
            };

            if ($mimeRules) {
                $request->validate(['file' => $mimeRules]);
            }

            // Hapus file lama
            if ($media->file_url && Storage::disk('public')->exists($media->file_url)) {
                Storage::disk('public')->delete($media->file_url);
            }

            $file = $request->file('file');
            $path = $file->store('uploads/medias', 'public');
            $mime = $file->getClientMimeType() ?: 'application/octet-stream';

            $media->update([
                'file_url'  => $path,
                'mime_type' => $mime,
            ]);
        }

        // Update deskripsi
        $media->update([
            'description' => $request->description,
        ]);

        return redirect()->route('admin.medias.index', ['type' => $media->type])
                         ->with('success', 'Media berhasil diperbarui!');
    }

    /**
     * Hapus media
     */
    public function destroy($media_id)
    {
        $media = Media::findOrFail($media_id);

        try {
            if ($media->file_url && Storage::disk('public')->exists($media->file_url)) {
                Storage::disk('public')->delete($media->file_url);
            }

            $media->delete();

            return response()->json([
                'status'  => 'success',
                'message' => 'Media berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Media gagal dihapus!'
            ]);
        }
    }
}
