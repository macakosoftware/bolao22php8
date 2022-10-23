<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailBoasVindas extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $senha;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $senha)
    {
        $this->user = $user;
        $this->senha = $senha;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        view()->share('ds_nome',$this->user->name);
        view()->share('ds_email',$this->user->email);
        view()->share('ds_senha',$this->senha);
        
        return $this->view('email.bemvindo');
    }
}
