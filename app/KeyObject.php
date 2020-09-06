<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KeyObject extends Model
{
    //
    public $table = 'keyobject';

    protected $fillable = [
        'key_id', 'value',
    ];
}
