<?php

namespace App\Http\Controllers;

use App\Issue;
use App\Meeting;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param  \App\Issue  $issue
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Issue $issue)
    {
        $meetings = Meeting::where('issue_id', $issue->id)
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
    public function store(Request $request, Issue $issue)
    {
        //
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Meeting $meeting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Meeting $meeting)
    {
        //
    }
}
