<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Issue extends Model
{
    use SoftDeletes;
    
    protected $dates = ['deleted_at'];

    protected $guarded = ['id'];

    protected $appends = ['last_meeting_date', 'last_judgement_date'];

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

    public function getLastMeetingDateAttribute()
    {
        if($this->meetings()->count())
        {
            return $this->meetings()->orderBy('date', 'desc')->first()->date;
        } else {
            return null;
        }
    }

    public function getLastJudgementDateAttribute()
    {   
        if($this->judgements()->count())
        {
            return $this->judgements()->orderBy('date', 'desc')->first()->date;
        } else {
            return null;
        }

    }

}
