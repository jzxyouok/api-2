<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = [
        'dir_id', 'user_id', 'title', 'md5_file', 'file_size', 'path', 'is_image', 'disk'
    ];

    public function getIsImageAttribute()
    {
        return $this->attributes['is_image'] == 'T';
    }

    public function getFileSizeAttribute()
    {
        return $this->format_bytes($this->attributes['file_size']);
    }

    public function attDir()
    {
        return $this->belongsTo(AttDir::class, 'dir_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    private function format_bytes($size, $delimiter = '')
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
        for ($i = 0; $size >= 1024 && $i < 5; $i++) $size /= 1024;
        return round($size, 2) . $delimiter . $units[$i];
    }
}
