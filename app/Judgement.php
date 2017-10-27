<?php

namespace App;

use App\Scopes\ActiveIssueScope;
use Illuminate\Database\Eloquent\Model;

class Judgement extends Model
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

    public function parentMeeting()
    {
    	return $this->belongsTo(Meeting::class);
    }

    public function childMeeting()
    {
    	return $this->hasOne(Meeting::class);
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopePresent($query)
    {
        return $query->where('present', 1);
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

    public function scopeNoChild($query)
    {
        return $query->doesntHave('childMeeting');
    }

}
