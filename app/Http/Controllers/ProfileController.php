<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Services\SuperAdminService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request, SuperAdminService $super_admin_service): View
    {
        $user = $request->user();
        $is_current_super_admin = $super_admin_service->current_user_id() === $user->id;

        return view('profile.edit', [
            'user' => $user,
            'can_delete_account' => ! $is_current_super_admin,
            'is_current_super_admin' => $is_current_super_admin,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        /** @var \App\Models\User $user */
        $user = $request->user();
        $user->fill(collect($validated)->except('avatar')->all());

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->storePublicly('avatars', 'public');
            if ($user->avatar_path) {
                Storage::disk('public')->delete($user->avatar_path);
            }
            $user->avatar_path = $path;
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request, SuperAdminService $super_admin_service): RedirectResponse
    {
        if ($super_admin_service->current_user_id() === $request->user()->id) {
            return Redirect::route('profile.edit')->withErrors(
                ['password' => 'Transfer ownership to another user before deleting this protected account.'],
                'userDeletion'
            );
        }

        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
