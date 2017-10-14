<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Issue extends Model
{
    use SoftDeletes;
    
    protected $dates = ['deleted_at'];

    protected $guarded = ['id'];

    public function openents()
    {
    	return $this->belongsToMany(Person::class);
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

}
