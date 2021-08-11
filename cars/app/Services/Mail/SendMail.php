<?php

namespace App\Services\Mail;

use App\Domain\Mail\SendMailInterface;
use Illuminate\Support\Facades\Mail;

class SendMail implements SendMailInterface
{
    public function sendMail(array $params): void
    {
        $message = $params['message'];

        Mail::raw($message, function ($message) use ($params) {
            $message
                ->to($params['email'])
                ->subject($params['subject'])
            ;
        });
    }
}
