<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';

    protected $fillable = [
        'parent_id', 'title', 'seo_title', 'seo_keywords', 'seo_description', 'is_show'
    ];

    public function getIsShowAttribute()
    {
        return $this->attributes['is_show'] == 'T';
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }
}
