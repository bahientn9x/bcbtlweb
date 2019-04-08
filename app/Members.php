<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Members extends Authenticatable
{
    use Notifiable;

    protected $table = 'ok_members';
    protected $guard = 'members';

    protected $fillable = [
        'name', 'email', 'password', 'balance',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function orders()
    {
        return $this->hasMany('App\Orders', 'member_id', 'id');
    }

    public function bankmember()
    {
        return $this->hasMany('App\Bankmember', 'member_id', 'id');
    }

    public function bankmember_trans()
    {
        return $this->hasManyThrough('App\Bankmember_Trans', 'App\Bankmember', 'member_id', 'bankmember_id', 'id');
    }

    public function bankadmin_trans()
    {
        return $this->hasMany('App\Bankadmin_Trans', 'member_id', 'id');
    }
}
