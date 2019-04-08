<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bankadmin_Trans extends Model
{
    protected $table = 'ok_bankadmin_trans';

    public function bankadmin()
    {
        return $this->belongsTo('App\Bankadmin', 'bankadmin_id', 'id');
    }

    public function bankmember()
    {
        return $this->belongsTo('App\Bankmember', 'bankmember_id', 'id');
    }

    public function member()
    {
        return $this->belongsTo('App\Members', 'member_id', 'id');
    }
}
