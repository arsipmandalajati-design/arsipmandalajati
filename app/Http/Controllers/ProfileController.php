<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
{
    return view('profile.edit');
}

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
$user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
        
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
        
            'password' => 'nullable|confirmed|min:8',
        
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

    // Update data dasar
    $user->name = $request->name;
    $user->email = $request->email;

    // Upload foto jika ada
if ($request->hasFile('photo')) {

    // Hapus foto lama
    if ($user->photo && Storage::disk('public')->exists($user->photo)) {
        Storage::disk('public')->delete($user->photo);
    }

    $extension = $request->file('photo')->getClientOriginalExtension();

    $filename = 'user_' . $user->id . '.' . $extension;

    $request->file('photo')->storeAs(
        'profile',
        $filename,
        'public'
    );

    $user->photo = 'profile/' . $filename;
}

    // Password hanya diubah jika diisi
    if ($request->filled('password')) {

        $request->validate([
            'password' => 'confirmed|min:8'
        ]);
    
        $user->password = Hash::make($request->password);
    }

    $user->save();

    return back()->with('success', 'Profil berhasil diperbarui.');
}
}