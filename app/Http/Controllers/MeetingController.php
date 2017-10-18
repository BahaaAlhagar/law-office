<?php

namespace App\Http\Controllers;

use App\Issue;
use App\Meeting;
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
     * @param  \App\Issue  $issue
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Issue $issue)
    {
        $meetings = Meeting::where('issue_id', $issue->id)
                        ->with('judgements.childMeeting', 'childMeetings')
                        ->orderBy('level', 'asc')
                        ->orderBy('date', 'asc')
                        ->get();

        return $meetings;
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
