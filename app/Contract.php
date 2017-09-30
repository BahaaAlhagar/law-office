<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{

	use SoftDeletes;

    protected $dates = ['deleted_at'];


    protected $guarded = ['id'];

    public function people()
    {
    	return $this->belongsToMany(Person::class)
    				->select(['id', 'name', 'location']);
    }
}
