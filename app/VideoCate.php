<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VideoCate extends Model
{
    public function v()
    {
        return $this->hasMany('App\Video', 'video_cate_id', 'id');
    }
     public function a()
    {
        return $this->hasMany('App\Article', 'video_cate_id', 'id');
    }
}
