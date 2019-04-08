<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = 'ok_orders';

    public function members()
    {
        return $this->belongsTo('App\Members', 'member_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo('App\Category', 'cate_id', 'id');
    }

    public function bankmember_trans()
    {
        return $this->hasMany('App\Bankmember_Trans', 'order_id', 'id');
    }
}
