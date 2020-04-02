<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BlockList;

class Longread extends Model
{
    public $table = 'longreads';
    public $timestamps = false;

    public function user() {
    	return $this->belongsTo('App\Models\User');
    }

    public function blockList() {
        return $this->hasMany('App\Models\BlockList', 'longread_id');
    }
}
