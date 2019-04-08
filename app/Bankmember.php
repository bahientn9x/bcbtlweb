<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bankmember extends Model
{
    protected $table = 'ok_bankmember';
    //protected $fillable = ['member_id','account_name','account_number','bank_name','department'];
    public function member()
    {
        return $this->belongsTo('App\Members', 'member_id', 'id');
    }

    public function bankmember_trans()
    {
        return $this->hasMany('App\Bankmember_Trans', 'bankmember_id', 'id');
    }

    public function bankadmin_trans()
    {
        return $this->hasMany('App\Bankadmin_Trans', 'bankmember_id', 'id');
    }
}
