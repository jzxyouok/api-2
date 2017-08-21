<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleData extends Model
{
    protected $table = 'article_data';

    protected $fillable = [
        'article_id', 'content'
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
