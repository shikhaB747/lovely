<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Mail;

class MailHelper
{

    public static function sendEmail($template, $data, $to, $subject)
    {
        Mail::send('mails.' . $template, $data, function ($message) use ($to, $subject) {
            $message->to($to)->subject($subject);
        });
    }
    
}