<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function makeResponse($template, $objects = [])
    {
        if (\Request::ajax())
        {
            return response()->json($objects);
        }

        return view($template, $objects);
    }


    protected function respondWithMessage(string $message='', $objects = [])
    {

    	$data = array_merge(['item' => $objects], ['message' => $message]);

    	return response()->json($data);
    }
}
