<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegisterMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $url)
    {
        $this->email = $email;
        $this->sub = "【xylitol事務局】本登録のご案内";
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->email)  // 送信先アドレス
        ->subject($this->sub) // 件名
        ->view('registers.register_mail') // 本文
        ->with(['url' => $this->url]);
    }
}
