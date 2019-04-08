<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bankadmin extends Model
{
    protected $table = 'ok_bankadmin';
    protected $fillable = ['admin_id','account_name','account_number','bank_name','department'];
    public function admin()
    {
        return $this->belongsTo('App\User', 'admin_id', 'id');
    }

    public function bankadmin_trans()
    {
        return $this->hasMany('App\Bankadmin_Trans', 'bankadmin_id', 'id');
    }
}
