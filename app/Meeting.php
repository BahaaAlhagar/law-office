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
    
}
