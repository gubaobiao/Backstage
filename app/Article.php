<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
	public $timestamps = false;
    public function d()
    {
        return $this->belongsTo('App\VideoCate', 'video_cate_id', 'id');
    }

}
