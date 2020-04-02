<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BlockList;

class Block extends Model
{
    public $table = 'blocks';
    public $timestamps = false;

    public function blockList() {
        return $this->hasMany('App\Models\BlockList', 'block_id');
    }
}
