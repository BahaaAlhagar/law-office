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
    	return $this->belongsToMany(Person::class)
                    ->withPivot('person_type')
                    ->orderBy('is_client', 'desc');
    }

    public function accusedOpenents()
    {
        return $this->belongsToMany(Person::class)
                    ->withPivot('person_type')
                    ->wherePivot('person_type', 1)
                    ->orderBy('is_client', 'desc');
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function meetings()
    {
        return $this->hasMany(Meeting::class);
    }

    public function judgements()
    {
        return $this->hasMany(Judgement::class);
    }

}
