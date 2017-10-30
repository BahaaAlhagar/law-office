<?php

namespace App\Http\Controllers;

use App\Issue;
use App\Person;
use App\Meeting;
use App\Contract;
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
                        ->active()
                        ->where('level', '<', 3)
    					->noChild()
    					->openent()
    					->with('person', 'issue')
    					->get();


    	$advancedRecords = Judgement::openJudgement()
                            ->active()
                            ->whereBetween('level', [3, 4])
    						->noChild()
    			   			->openent()
    			   			->with('person', 'issue')
    			   			->get();
    			   			
    	
    	return $this->makeResponse('office/listRecords', compact('records', 'advancedRecords'));
    }

    public function lateMeetings()
    {
        $cevilMeetings = Meeting::where('date', '<', Carbon::parse('today'))
                                ->cevil()
                                ->doesntHave('childMeetings')
                                ->doesntHave('judgements')
                                ->with('issue.openents')
                                ->orderBy('date')
                                ->get();

        $criminalPartOne = Meeting::where('date', '<', Carbon::parse('today'))
                                ->whereNotNull('person_id')
                                ->criminal()
                                ->doesntHave('childMeetings')
                                ->doesntHave('judgements')
                                ->with('issue.openents', 'person')
                                ->orderBy('date')
                                ->get();

        $criminalPartTwo = Meeting::where('date', '<', Carbon::parse('today'))
                                ->whereNull('person_id')
                                ->criminal()
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

        $records = Judgement::where('type', '<', 3)
                                ->whereNull('record')
                                ->noChild()
                                ->criminal()
                                ->with('issue', 'person')
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

    public function expiration()
    {
        $yasterDay = Carbon::yesterday();
        $firstPeriod = Carbon::today()->subDays(50);
        $latePeriod = Carbon::today()->subDays(70);

        $notPresetJudgements = Judgement::where('level', 1)
                                ->where('present', 0)
                                ->where('date', '<', Carbon::parse('today'))
                                ->noChild()
                                ->cevil()
                                ->orderBy('date')
                                ->with('issue')
                                ->get();

        $firstJudgements = Judgement::where('level', 1)
                                ->present()
                                ->whereBetween('date', [$firstPeriod, $yasterDay])
                                ->noChild()
                                ->cevil()
                                ->with('issue')
                                ->orderBy('date')
                                ->get();

       $lateJudgements = Judgement::where('level', 3)
                                ->present()
                                ->whereBetween('date', [$latePeriod, $yasterDay])
                                ->noChild()
                                ->cevil()
                                ->with('issue')
                                ->orderBy('date')
                                ->get();

        $clientRecords = Judgement::active()
                                ->openJudgement()
                                ->client()
                                ->noChild()
                                ->with('person', 'issue')
                                ->get();

        $openentRecords = Judgement::active()
                                ->openJudgement()
                                ->openent()
                                ->noChild()
                                ->with('person', 'issue')
                                ->get();

        return $this->makeResponse('office/expirationPage', compact('notPresetJudgements', 'firstJudgements', 'lateJudgements', 'clientRecords', 'openentRecords'));
    }

    public function search(Request $request)
    {
        if($request->q)
        {
            $q = $request->q;

            $people = Person::where('name', 'LIKE', '%'.$q.'%')
                    ->orWhere('location', 'LIKE', '%'.$q.'%')
                    ->get();

            $issues = Issue::where('number', 'LIKE', '%'.$q.'%')
                    ->orWhere('adv_number', 'LIKE', '%'.$q.'%')
                    ->orWhere('subject', 'LIKE', '%'.$q.'%')
                    ->with('openents')
                    ->get();

            $contracts = Contract::where('number', 'LIKE', '%'.$q.'%')
                    ->with('people')
                    ->get();

            $judgements = Judgement::where('record', 'LIKE', '%'.$q.'%')
                    ->with('person', 'issue')
                    ->get();

            return view('office/searchResults', compact('people', 'issues', 'contracts', 'judgements'));
        }

        return back();
    }

    public function main()
    {
        $todayMeetings = Meeting::where('date', Carbon::today())
                    ->with('issue.openents')
                    ->meetingOrder()
                    ->get();

        $tomorrowMeetings = Meeting::where('date', Carbon::tomorrow())
                    ->with('issue.openents')
                    ->meetingOrder()
                    ->get();


        $yasterDay = Carbon::yesterday();
        $firstPeriod = Carbon::today()->subDays(50);
        $latePeriod = Carbon::today()->subDays(70);

        $notPresetJudgements = Judgement::where('level', 1)
                                ->where('present', 0)
                                ->where('date', '<', Carbon::parse('today'))
                                ->noChild()
                                ->cevil()
                                ->orderBy('date')
                                ->with('issue')
                                ->get();

        $firstJudgements = Judgement::where('level', 1)
                                ->present()
                                ->whereBetween('date', [$firstPeriod, $yasterDay])
                                ->noChild()
                                ->cevil()
                                ->with('issue')
                                ->orderBy('date')
                                ->get();

       $lateJudgements = Judgement::where('level', 3)
                                ->present()
                                ->whereBetween('date', [$latePeriod, $yasterDay])
                                ->noChild()
                                ->cevil()
                                ->with('issue')
                                ->orderBy('date')
                                ->get();

      return $this->makeResponse('office/mainPage', compact('todayMeetings', 'tomorrowMeetings', 'notPresetJudgements', 'firstJudgements', 'lateJudgements'));
    }

    public function DatabaseBackup()
    {
        return view('office/databaseBackup');
    }
}
