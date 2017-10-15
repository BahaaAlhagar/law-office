<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Judgement extends Model
{
    protected $guarded = ['id'];

    public function issue()
    {
    	return $this->belongsTo(Issue::class);
    }

    public function person()
    {
    	return $this->belongsTo(Person::class);
    }

    public function parentMeeting()
    {
    	return $this->belongsTo(Meeting::class);
    }

    public function childMeeting()
    {
    	return $this->hasOne(Meeting::class);
    }
}
