<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\FetchCommit;

class SyncController extends Controller
{
    public function sync(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|exists:users,id',
        ]);
        
        dispatch(new FetchCommit(auth()->user()->id));
        return redirect()->back()->with('status', 'Sync started!');
    }
}
