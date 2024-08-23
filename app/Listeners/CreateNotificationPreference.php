<?php

namespace App\Listeners;

use App\Events\UserSignedUp;
use App\Models\NotificationPreference;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateNotificationPreference
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
     * @param  \App\Events\UserSignedUp  $event
     * @return void
     */
    public function handle(UserSignedUp $event)
    {
        // Create a new notification preference entry for the user
        NotificationPreference::firstOrCreate(
            ['user_id' => $event->user->id],
            [
                'new_matches'      => 'push,emails',
                'expiring_matches' => 'push,emails',
                'new_messages'     => 'push,emails',
                'tips'             => 'push,emails',
                'survey_feedback'  => 'push,emails'
            ]
        );
    }
}
