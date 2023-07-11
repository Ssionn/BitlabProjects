<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class SyncController extends Controller
{
    public function status()
    {
        $user = Auth::user();

        return response()->json(['is_synced' => $user->is_synced], 200);
    }
}
