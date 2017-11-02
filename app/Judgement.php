<?php

namespace App;

use Carbon\Carbon;
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

    protected $appends = ['expire_at', 'valid_at'];

    public function getExpireAtAttribute()
    {
            return Carbon::parse($this->date)->addYears(3)->format('Y-m-d');
    }

    public function getValidAtAttribute()
    {
        if($this->level == 1)
        {
            return Carbon::parse($this->date)->addDays(39)->format('Y-m-d');
        } elseif ($this->level == 3) {
            return Carbon::parse($this->date)->addDays(59)->format('Y-m-d');
        } else {
            return null;
        }
    }

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

    public function scopeOpenent($query)
    {
        return $query->whereHas('person', function($query)
        {
            $query->where('is_client', 0);
        });
    }

    public function scopeClient($query)
    {
        return $query->whereHas('person', function($query)
        {
            $query->where('is_client', 1);
        });
    }

    public function scopeOpenJudgement($query)
    {
        return $query->whereNotNull('record')
                    ->where('type', 1)
                    ->orderBy('date', 'asc');
    }
}
