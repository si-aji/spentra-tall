<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationSubscribeController extends Controller
{
    /**
     * 
     */
    public function store(Request $request)
    {
        $request->validate([
            'endpoint' => ['required'],
            'keys.auth' => ['required'],
            'keys.p256dh' => 'required'
        ]);

        $endpoint = $request->endpoint;
        $token = $request->keys['auth'];
        $key = $request->keys['p256dh'];
        $user = \Auth::user();
        $user->updatePushSubscription($endpoint, $key, $token);

        return response()->json([
            'success' => true,
            'message' => 'Data Stored',
            'result' => []
        ]);
    }
}
