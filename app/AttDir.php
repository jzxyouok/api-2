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

    /**
     * 子目录
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(AttDir::class, 'parent_id');
    }

    /**
     * 所有子目录
     * @return *
     */
    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }
}
