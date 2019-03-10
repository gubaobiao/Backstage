<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
	public $timestamps = false;
    public function c()
    {
        return $this->belongsTo('App\VideoCate', 'video_cate_id', 'id');
    }

}
