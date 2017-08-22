<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttDir extends Model
{
    protected $table = 'attdirs';

    protected $fillable = [
        'title', 'parent_id'
    ];

    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'dir_id');
    }

}
