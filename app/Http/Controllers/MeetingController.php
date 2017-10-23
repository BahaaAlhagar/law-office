<?php

namespace App\Http\Controllers;

use App\Issue;
use App\Meeting;
use Carbon\Carbon;
use App\Http\Requests\storeMeetingRequest;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     * @param    $start
     * @param    $end
     *
     * @return \Illuminate\Http\Response
     */
    public function listMeetings($start = null, $end = null)
    {
        if(!$start && !$end){

            $thisWeekStart = Carbon::parse('this week -2 days')->startOfDay();
            $thisWeekEnd = Carbon::parse('this week +4 days')->endOfDay();

            $nextWeekStart = Carbon::parse('next week -2 days')->startOfDay();
            $nextWeekEnd = Carbon::parse('next week +4 days')->endOfDay();

            $thisWeekCevil = Meeting::whereBetween('date', [$thisWeekStart, $thisWeekEnd])
                    ->with('issue.openents')
                    ->cevil()
                    ->meetingOrder()
                    ->get();

            $thisWeekCriminal = Meeting::whereBetween('date', [$thisWeekStart, $thisWeekEnd])
                    ->with('issue.openents')
                    ->criminal()
                    ->meetingOrder()
                    ->get();

            $nextWeekCevil = Meeting::whereBetween('date', [$nextWeekStart, $nextWeekEnd])
                    ->with('issue.openents')
                    ->cevil()
                    ->meetingOrder()
                    ->get();

            $nextWeekCriminal = Meeting::whereBetween('date', [$nextWeekStart, $nextWeekEnd])
                    ->with('issue.openents')
                    ->criminal()
                    ->meetingOrder()
                    ->get();

            return $this->makeResponse('meetings/listMeetings', compact('thisWeekCevil', 'thisWeekCriminal', 'nextWeekCevil', 'nextWeekCriminal'));
        }


        $start = Carbon::parse($start)->startOfDay();
        $end = Carbon::parse($end)->endOfDay();

        $cevil = Meeting::whereBetween('date', [$start, $end])
                    ->with('issue.openents')
                    ->cevil()
                    ->meetingOrder()
                    ->get();

        $criminal = Meeting::whereBetween('date', [$start, $end])
                    ->with('issue.openents')
                    ->criminal()
                    ->meetingOrder()
                    ->get();

        return $this->makeResponse('meetings/listMeetings', compact('cevil', 'criminal'));
    }
    
    /**
     * Display a listing of the resource.
     * @param  \App\Issue  $issue
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Issue $issue)
    {
        $meetings = Meeting::where('issue_id', $issue->id)
                        ->with('judgements.childMeeting', 'childMeetings', 'person')
                        ->orderBy('level', 'asc')
                        ->orderBy('date', 'asc')
                        ->get();

        $accusedOpenents = $issue->accusedOpenents()
        ->with(['judgements' => function($query) use ($issue)
        {
            $query->where('issue_id', $issue->id);
        },
        'meetings' => function($query) use ($issue)
        {
         $query->where('issue_id', $issue->id);
        }, 'contracts'])->get();

        return $this->makeResponse('issues/issueProfile', compact('issue', 'meetings', 'accusedOpenents'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function store(storeMeetingRequest $request, Issue $issue)
    {
        $issue->meetings()->create($request->all());

        return ['message' => 'تم اضافة الجلسة!'];
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function update(storeMeetingRequest $request, Meeting $meeting)
    {
        $meeting->update($request->all());

        return ['message' => 'تم تحديث بيانات الجلسة'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Meeting $meeting)
    {
        if(!is_null($meeting->childMeetings()->first()) || !is_null($meeting->judgements()->first()))
        {
            return ['message' => 'لا يمكنم حذف هذه الجلسة لاحتوائها على تأجيلات او احكام'];
        }

        $meeting->delete();

        return ['message' => 'تم حذف الجلسة'];
    }
}
