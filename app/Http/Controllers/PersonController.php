<?php

namespace App\Http\Controllers;

use App\File;
use App\Person;
use Illuminate\Http\Request;
use App\Http\Requests\createPersonRequest;
use App\Http\Requests\updatePersonRequest;
use App\Http\Requests\uploadFileRequest;

class PersonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($filter = null)
    {
        $people = Person::orderBy('name')->paginate(14);

        if($filter == 'clients')
        {
        $people = Person::where('is_client', 1)
            ->orderBy('name')->paginate(14);
        }

        if($filter == 'notclients')
        {
        $people = Person::where('is_client', 0)
            ->orderBy('name')->paginate(14);
        }

        if($filter == 'trashed')
        {
        $people = Person::onlyTrashed()
            ->orderBy('name')->paginate(14);
        }

        return $this->makeResponse('people/managePeople', compact('people'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(createPersonRequest $request)
    {
        $person = Person::create($request->all());

        return $this->respondWithMessage('تم اضافة الشخص بنجاح!', $person);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function show(Person $person)
    {
        $person->load('contracts');
        
        return $this->makeResponse('people/personProfile', compact('person'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function update(updatePersonRequest $request, Person $person)
    {
        $person->update($request->all());
        return $this->respondWithMessage('تم تحديث الشخص بنجاح!', $person);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function destroy(Person $person)
    {
        $person->delete();
        return ['message' => 'تم حذف الشخص بنجاح'];
    }

    /**
     * restore soft deleted user.
     *
     * @param  $person
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $person = Person::onlyTrashed()
        ->where('id', $id)->restore();
        return ['message' => 'تم استرجاع الشخص بنجاح'];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filesIndex(Person $person)
    {
        $files = File::latest()
                        ->where('fileable_id', $person->id)
                        ->where('fileable_type', 'person')
                        ->paginate(15);

        return $this->makeResponse('people/managePersonFiles', compact('person', 'files'));
    }

    public function storeFile(uploadFileRequest $request, Person $person)
    {
        if ($request->hasFile('file')) 
        {
            $relatedFile = $this->handleUploadFile($request, $person, 'people_files');
            $person->files()->create($relatedFile);

            return ['message' => 'file Uploaded Successfully!'];
        }

        return ['message' => 'something went Wrong'];
    }

    public function issues(Person $person)
    {
        $cevilIssues = $person->issues()->where('type', '>', 4)
                              ->with('openents')
                              ->latest()
                              ->get();

        $criminalIssues = $person->issues()->where('type', '<', 4)
                              ->with('openents')
                              ->latest()
                              ->get();

        $excutiveIssues = $person->issues()->where('type', 4)
                              ->with('openents')
                              ->latest()
                              ->get();

        $records = $person->judgements()
                          ->noChild()
                          ->with('issue')
                          ->get();


        return $this->makeResponse('people/personIssues', compact('person', 'criminalIssues', 'cevilIssues', 'excutiveIssues', 'records'));
    }

}
