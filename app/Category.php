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

    public function setIsShowAttribute($value)
    {
        $this->attributes['is_show'] = $value ? 'T' : 'F';
    }

    public function article()
    {
        return $this->hasMany(Article::class);
    }

}
