<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notification;

class AjaxController extends Controller
{
    public function store(Request $request)
    {

        $notifications = $request->input('notification');
        foreach($notifications as $notif)
        {
            $not = Notification::find($notif);
            $not->seen = "yes";
            $not->update();
        }
        return response()->json(['success'=>$notifications]);
    }

}
