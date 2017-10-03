<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model
{
    use SoftDeletes;

    // protected $hidden = ['pivot'];

    protected $dates = ['deleted_at'];

    protected $guarded = ['id'];

    public function contracts()
    {
    	return $this->belongsToMany(Contract::class);
    }
}
