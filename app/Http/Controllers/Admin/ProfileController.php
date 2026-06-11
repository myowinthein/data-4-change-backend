<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.profile.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Laravel 5.8.17's validateEmail() always uses egulias/email-validator (no :filter support).
        // egulias 2.1.7 crashes on PHP 7.4. Use filter_var via a closure instead.
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => [
                'required',
                'max:255',
                function ($attribute, $value, $fail) {
                    if (! filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $fail('The email must be a valid email address.');
                    }
                },
                Rule::unique('users', 'email')->ignore($id),
            ],
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user->name  = $request->input('name');
        $user->email = $request->input('email');

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->save();

        return redirect()->route('admin.profiles.edit', $id)
                         ->with('status', 'Profile updated successfully.');
    }
}
