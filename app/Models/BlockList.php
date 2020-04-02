<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlockList extends Model
{
    public $table = 'blockslist';
    public $timestamps = false;
    protected $fillable = ['longread_id', 'block_id', 'content', 'styles'];
}
