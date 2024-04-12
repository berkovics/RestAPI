<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\AllertMail;

class AllertController extends Controller
{
    public function sendMail($user, $time){
        $content = [
            "title" => "Figyelmeztető levél",
            "user" => $user,
            "time" => $time
        ];

        Mail::to("laravelfejlesztes@gmail.com")->send(new AllertMail($content));
    }
}
