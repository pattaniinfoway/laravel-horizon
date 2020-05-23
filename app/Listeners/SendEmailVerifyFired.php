<?php

namespace App\Listeners;

use App\Events\SendEmail;
use App\Mail\UserRegistered; 
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
class SendEmailVerifyFired
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SendEmailVerify  $event
     * @return void
     */
    public function handle(SendEmail $event)
    {
        $user = User::where('id',$event->userId)->first();
        Mail::to($user->email)->send(new UserRegistered());
    }
}
