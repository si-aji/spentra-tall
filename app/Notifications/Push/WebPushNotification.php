<?php

namespace App\Notifications\Push;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

class WebPushNotification extends Notification
{
    use Queueable;
    public $title = null,
        $message = null,
        $actions = [],
        $data = null;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data = null)
    {
        if(!empty($data) && is_array($data)){
            if(isset($data['title'])){
                $this->title = $data['title'];
            } else {
                $this->title = env('APP_NAME');
            }

            if(isset($data['message'])){
                $this->message = $data['message'];
            }

            if(isset($data['actions']) && is_array($data['actions'])){
                foreach($data['actions'] as $actions){
                    if(isset($actions['title']) && isset($actions['route'])){
                        $this->actions[] = $actions;
                    }
                }
            }

            if(isset($data['data'])){
                $this->data = $data['data'];
            }
        } else {
            $this->title = env('APP_NAME');
        }
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [WebPushChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toWebPush($notifiable)
    {
        $notification = (new WebPushMessage);
        if(!empty($this->title)){
            $notification->title($this->title);
        }
        if(!empty($this->message)){
            $notification->body($this->message);
        }
        if(is_array($this->actions) && count($this->actions) > 0){
            foreach($this->actions as $action){
                $notification->action($action['title'], $action['route']);
            }
        }
        if(!empty($this->data)){
            $notification->data($this->data);
        }

        return $notification;
    }
}
