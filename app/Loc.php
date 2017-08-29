<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loc extends Model
{
    protected $table = 'loc';

    protected $fillable = [
        'value', 'label', 'parent_id'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
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
