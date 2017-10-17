<?php

namespace App\Http\Controllers;

use App\Meeting;
use App\Judgement;
use Illuminate\Http\Request;

class JudgementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Meeting $meeting, Request $request)
    {
        $meeting->judgements()->create($request->all());

        return ['message' => 'تم اضافة الحكم'];
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Judgement  $judgement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Judgement $judgement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Judgement  $judgement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Judgement $judgement)
    {
        //
    }
}
