<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendEmail($data){

        Mail::raw($data['content'], function($message) use ($data) {
            $message->to($data['email'])
            ->subject($data['subject']);
          });
    }
}
