<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loc extends Model
{
    protected $table = 'loc';

    protected $fillable = [
        'code', 'name', 'parent_id'
    ];
    
}
