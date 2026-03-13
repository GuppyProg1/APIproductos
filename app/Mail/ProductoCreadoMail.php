<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;

class ProductoCreadoMail extends Mailable{
    use Queueable, SerializesModels;

    public $producto;

    public function __construct($producto){
        $this->producto = $producto;
    }

    public function build(){
        return $this->subject('Nuevo producto creado')
                    ->view('email\producto_creado');
    }
}