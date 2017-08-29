<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mdd extends Model
{
    protected $table = 'mdd';

    protected $fillable = [
        'loc_id', 'title', 'thumb', 'description', 'sort', 'is_show', 'cascader'
    ];

    protected $casts = [
        'cascader' => 'array'
    ];

    public function getIsShowAttribute()
    {
        return $this->attributes['is_show'] == 'T';
    }

    public function setIsShowAttribute($value)
    {
        $this->attributes['is_show'] = $value ? 'T' : 'F';
    }

}
