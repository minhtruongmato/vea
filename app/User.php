<?php

namespace App;

use App\Notifications\ActiveAccount;
use App\Notifications\ResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    const SUBPER_ADMIN = 99;
    const ADMIN = 98;
    const ACTIVE = 1;
    const DEACTIVE = 0;

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'level', 'verified_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'verify_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendResetPasswordEmail(){
        $this->notify(new ResetPassword($this));
    }

    public function sendActiveAccount(){
        $this->notify(new ActiveAccount($this));
    }
}
