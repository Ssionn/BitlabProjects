<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use App\Rules\ValidGitLabAccessToken;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Update the user's Access Token.
     */
    public function updateToken(Request $request): RedirectResponse
    {
        $request->validate([
            'api_token' => ['required', 'string', new ValidGitLabAccessToken],
        ]);

        $request->user()->update([
            'api_token' => $request->input('api_token'),
        ]);

        return Redirect::route('profile.edit')->with('status', 'Access-Token-Updated.');
    }

    /**
     * Update the user's gitlab name username.
     */
    public function updateGitLabName(Request $request): RedirectResponse
    {
        $request->validate([
            'gitlab' => ['required', 'string', 'max:255'],
        ]);

        $request->user()->update([
            'gitlab' => $request->input('gitlab'),
        ]);

        return Redirect::route('profile.edit')->with('status', 'GitLab-Name-Updated.');

    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();
        $userId = auth()->user()->id;

        Auth::logout();

        Cache::forget('events_'.$userId);

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
