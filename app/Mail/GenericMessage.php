<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GenericMessage extends Mailable
{
    use Queueable, SerializesModels;

    public $contents;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contents)
    {
        $this->contents = $contents;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $contents = $this->contents;
        return $this
            ->subject($contents['subject'])
            ->markdown('emails.generic');
    }
}
