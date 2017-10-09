<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $guarded = ['id'];

    public function contracts()
    {
    	return $this->belongsToMany(Contract::class);
    }

    public function issues()
    {
    	return $this->belongsToMany(Issue::class);
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }
}
