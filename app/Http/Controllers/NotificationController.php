<?php

namespace App\Http\Controllers;

use App\Models\ExpoPushToken;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'deviceId' => 'required',
        ]);
        $device = ExpoPushToken::where('device_id',request('deviceId'))->first();
        if ($device){
            if ($request->phoneNumber)
            {
                $device->phone_number = request('phoneNumber');
                $device->save();
            }
                return response()->json([
                'message' => 'You are already subscribed'
            ]);
        }
        $expoPushToken = new ExpoPushToken();
        $expoPushToken->push_token = request('pushToken') ?? null;
        $expoPushToken->device_id = request('deviceId');
        $expoPushToken->phone_number = request('phoneNumber') ?? null;
        $expoPushToken->save();
        return response()->json([
            'message' => 'You are subscribed'
        ]);
    }
}
