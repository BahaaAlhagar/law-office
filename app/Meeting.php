<?php

namespace App;

use App\Scopes\ActiveIssueScope;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new ActiveIssueScope);
    }
    
    protected $guarded = ['id'];

    public $timestamps = false;

    protected $appends = ['accused_count', 'childs_count'];


    public function getChildsCountAttribute()
    {   

        return $this->judgements()->count() + $this->childMeetings()->count();

    }

    public function getAccusedCountAttribute()
    {   
            return $this->issue->accusedOpenents()->count();
    }


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
    	return $this->belongsTo(Judgement::class);
    }

    public function judgements()
    {
    	return $this->hasMany(Judgement::class);
    }

    public function childMeetings()
    {
    	return $this->hasMany(Meeting::class, 'parent_id');
    }

    public function parentMeeting()
    {
    	return $this->belongsTo(Meeting::class, 'parent_id');
    }

    public function scopeCevil($query)
    {
        return $query->whereHas('issue', function($query)
            {
                $query->where('type', '>', 4);
            });
    }

    public function scopeCriminal($query)
    {
        return $query->whereHas('issue', function($query)
            {
                $query->where('type', '<', 4);
            });
    }

    public function scopeMeetingOrder($query)
    {
        return $query->orderBy('date', 'asc')
                     ->orderBy('level', 'asc')
                     ->orderBy('role', 'asc');
    }


    public function scopeNoFullDelay($query)
    {
        return $query->whereDoesntHave('childMeetings', function($query)
        {
            $query->whereNull('person_id');
        });
    }
}
