<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
	protected $guard = ['id'];
	
    public function fileable()
    {
        return $this->morphTo();
    }
}
