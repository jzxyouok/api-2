<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    protected $table = 'article';

    protected $fillable = [
        'category_id', 'user_id', 'title', 'keywords', 'description'
    ];

    public function articleData()
    {
        return $this->hasOne(ArticleData::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
