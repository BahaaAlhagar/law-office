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
}
