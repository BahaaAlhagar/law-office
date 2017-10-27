<?php

namespace App\Http\Controllers;

use App\Judgement;
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
}
