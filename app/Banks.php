<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banks extends Model
{
    protected $table = 'ok_banks';

    protected $fillable = ['bank_name', 'bank_fullname'];
}
