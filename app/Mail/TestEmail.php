<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class TestEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public string $appName;
    public string $sentAt;

    public function __construct()
    {
        $this->appName = config('app.name');
        $this->sentAt = now()->toDateTimeString();
        $this->onQueue('emails');
    }

    public function build(): self
    {
        return $this
            ->subject('Test Email from ' . $this->appName)
            ->view('emails.test');
    }
}

