<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bankmember_Trans extends Model
{
    protected $table = 'ok_bankmember_trans';

    public function bankmember()
    {
        return $this->belongsTo('App\Bankmember', 'bankmember_id', 'id');
    }

    public function sender()
    {
        return $this->belongsTo('App\Members', 'sender_id', 'id');
    }

    public function receiver()
    {
        return $this->belongsTo('App\Members', 'receiver_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo('App\Orders', 'order_id', 'id');
    }
}
