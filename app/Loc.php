<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loc extends Model
{
    protected $table = 'loc';

    protected $fillable = [
        'code', 'name', 'parent_id'
    ];

    public function children()
    {
        return $this->hasMany(Loc::class, 'parent_id');
    }

    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }

}
