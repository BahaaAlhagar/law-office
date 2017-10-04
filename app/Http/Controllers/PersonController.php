<?php

namespace App\Http\Controllers;

use App\Person;
use Illuminate\Http\Request;
use App\Http\Requests\createPersonRequest;
use App\Http\Requests\updatePersonRequest;

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
}
