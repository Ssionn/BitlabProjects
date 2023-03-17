<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\NewCommitNotification;
use App\Notifications\NewIssueNotification;
use App\Notifications\NewRepositoryNotification;

class WebhookController extends Controller
{
    public function __invoke(Request $request)
    {
        $data = $request->all();
        $user = User::where('api_token', $data['api_token'])->first();
        if ($user) {
            switch ($data['type']) {
                case 'new_issue':
                    $user->notify(new NewIssueNotification($data['issue']));
                    break;
                case 'new_commit':
                    $user->notify(new NewCommitNotification($data['commit']));
                    break;
                case 'new_repository':
                    $user->notify(new NewRepositoryNotification($data['repository']));
                    break;
            }
        }
    }
}
