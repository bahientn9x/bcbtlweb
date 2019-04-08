<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'ok_category';

    public function orders()
    {
        return $this->hasMany('App\Orders', 'cate_id', 'id');
    }

}
