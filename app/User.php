<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $guard = 'users';
    protected $table = "ok_users";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function bankadmin()
    {
        return $this->hasMany('App\BankAdmin', 'admin_id', 'id');
    }

    public function bankadmin_trans()
    {
        return $this->hasManyThrough('App\Bankadmin_Trans', 'App\Bankadmin', 'admin_id', 'bankadmin_id', 'id','id');
    }
}
