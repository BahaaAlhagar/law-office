<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
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

    public function parentJudgement()
    {
    	return $this->belongsTo(judgement::class);
    }

    public function judgements()
    {
    	return $this->hasMany(judgements::class);
    }

    public function childMeetings()
    {
    	return $this->hasMany(Meeting::class, 'parent_id');
    }

    public function parentMeeting()
    {
    	return $this->belongsTo(Meeting::class, 'parent_id');
    }
}
