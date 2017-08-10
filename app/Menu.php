<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use jeremykenedy\LaravelRoles\Models\Role;

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

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id');
    }

    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }
}
