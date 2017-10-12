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

    public function handleUploadFile($request, $owner, string $folder)
    {
        $file = $request->file('file');

        if ($file->isValid()) {
            $extention = $file->extension();
            $size = $file->getClientSize() / 1024;
            $name =  $file->getClientOriginalName();
            $storeName = random_int(1, 99999).'_'.str_slug($name).'.'.$extention;
            $file->storeAs('/public/'.$folder.'/'.$owner->id, $storeName);
            $link = $folder.'/'.$owner->id.'/'.$storeName;

            $storedFile = [
                'name' => $name,
                'link' => $link,
                'size' => $size,
                'type' => $extention,
            ];

            return $storedFile;
        }
    }

}
