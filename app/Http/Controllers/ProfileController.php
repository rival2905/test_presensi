<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Tampilkan form edit profile
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Update profile user
     */
    public function update(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        // Validasi
        $rules = [
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email,' . $user->id,
            'phone_number'  => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'address'       => 'nullable|string|max:500',
            'profile_pic'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        // Hanya validasi password kalau diisi
        if ($request->filled('password')) {
            $rules['password'] = 'confirmed|min:6';
        }

        $validated = $request->validate($rules);

        // Ambil field dasar
        $data = $request->only(['name', 'email', 'phone_number', 'date_of_birth', 'address']);

        // Update password jika ada input
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Update foto profil
        if ($request->hasFile('profile_pic')) {
            // hapus lama jika ada
            if ($user->profile_pic && Storage::disk('public')->exists($user->profile_pic)) {
                Storage::disk('public')->delete($user->profile_pic);
            }

            $path = $request->file('profile_pic')->store('profile_pics', 'public');
            $data['profile_pic'] = $path;
        }

        // Update user
        $user->update($data);

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Profil berhasil diperbarui!');
    }
}
