<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'parent_id', 'icon', 'title', 'path', 'component', 'sort', 'is_show'
    ];

    public function getIsShowAttribute($value)
    {
        return $value === 'T';
    }

}
