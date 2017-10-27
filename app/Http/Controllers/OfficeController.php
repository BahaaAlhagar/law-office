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
    	$records = Judgement::whereNotNull('record')
    						->noChild()
    			   			->active()
    			   			->where('type', '<', 3)
    			   			->where('level', '=<', 2)
    			   			->openent()
    			   			->with('person', 'issue')
    			   			->orderBy('date')
    			   			->get();

    	$advancedRecords = Judgement::whereNotNull('record')
    						->noChild()
    			   			->active()
							->where('type', '<', 3)
    			   			->whereBetween('level', [3, 4])
    			   			->openent()
    			   			->with('person', 'issue')
    			   			->orderBy('date')
    			   			->get();
    	
    	return $this->makeResponse('office/listRecords', compact('records', 'advancedRecords'));
    }
}
