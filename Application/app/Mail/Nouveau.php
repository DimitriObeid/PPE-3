<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class nouveau extends Mailable
{
    use Queueable, SerializesModels;

    public $suiveur;

    public function __construct($suiveur)
    {
      $this->suiveur = $suiveur;
    }


    @return $this

    public function build()
    {
        return $this->subject ('Vous avez un nouveau suiveur !')
        ->view('mails.Nouveau');
        ->text('mails.Nouveau_text');

    }
}
