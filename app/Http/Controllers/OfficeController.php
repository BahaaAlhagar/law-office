<?php

namespace App\Http\Controllers;

use App\Issue;
use App\Meeting;
use App\Judgement;

use Carbon\Carbon;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    	$this->middleware('admin');
    }

    public function records()
    {
    	$records = Judgement::openJudgement()
    					->noChild()
    					->openent()
    					->active()
    					->where('level', '<', 3)
    					->with('person', 'issue')
    					->get();


    	$advancedRecords = Judgement::openJudgement()
    						->noChild()
    			   			->openent()
							->active()
    			   			->whereBetween('level', [3, 4])
    			   			->with('person', 'issue')
    			   			->get();
    			   			
    	
    	return $this->makeResponse('office/listRecords', compact('records', 'advancedRecords'));
    }

    public function lateMeetings()
    {
        $cevilMeetings = Meeting::cevil()
                                ->where('date', '<', Carbon::parse('today'))
                                ->doesntHave('childMeetings')
                                ->doesntHave('judgements')
                                ->with('issue.openents')
                                ->orderBy('date')
                                ->get();

        $criminalPartOne = Meeting::criminal()
                                ->where('date', '<', Carbon::parse('today'))
                                ->whereNotNull('person_id')
                                ->doesntHave('childMeetings')
                                ->doesntHave('judgements')
                                ->with('issue.openents', 'person')
                                ->orderBy('date')
                                ->get();

        $criminalPartTwo = Meeting::criminal()
                                ->where('date', '<', Carbon::parse('today'))
                                ->whereNull('person_id')
                                ->noFullDelay()
                                ->with('issue.openents')
                                ->orderBy('date')
                                ->get();


        $filteredCMeetings = $criminalPartTwo->filter(function($meeting){
            return $meeting->accused_count > $meeting->childs_count;
        });

        $criminalMeetings = array_merge($criminalPartOne->toArray(), $filteredCMeetings->toArray());
        
        return $this->makeResponse('office/lateMeetings', compact('criminalMeetings', 'cevilMeetings'));
    }

    public function missingData()
    {
        $issueNumbers = Issue::whereNull('number')
                                ->with('openents')
                                ->orderBy('type')
                                ->get();

        $issueAdvNumbers = Issue::whereNull('adv_number')
                                ->with('openents')
                                ->hasAdvancedMeeting()
                                ->orderBy('type')
                                ->get();

        $records = Judgement::criminal()
                                ->whereNull('record')
                                ->with('issue')
                                ->orderBy('date')
                                ->get();

        $dates = Issue::distinct()
                                ->has('openents', '=<', 1)
                                ->orDoesntHave('meetings')
                                ->with('openents')
                                ->orderBy('type')
                                ->get();

        
        return $this->makeResponse('office/missingData', compact('issueNumbers', 'issueAdvNumbers', 'records', 'dates'));
    }
}
