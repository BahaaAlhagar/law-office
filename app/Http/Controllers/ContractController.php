<?php

namespace App\Http\Controllers;

use App\Contract;
use App\Person;
use App\Http\Requests\storeContractRequest;
use Illuminate\Http\Request;


class ContractController extends Controller
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
    public function index($type = null)
    {
        $people = Person::orderBy('name')
            ->select('id', 'name', 'location')->get();

        
        $contracts = Contract::latest()
                ->with('people')->paginate(10);


        if($type >= 1 && $type <= 3)
        {
            $contracts = Contract::with('people')
                ->where('type', $type)->paginate(10);
        }


        if($type == 'trashed')
        {
            $contracts = Contract::onlyTrashed()
                ->with('people')
                ->latest()->paginate(10);
        }


        return $this->makeResponse('contracts/manageContracts', compact('contracts', 'people'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(storeContractRequest $request)
    {
        $people = array_column(request('people'), 'id');

        $contract = Contract::create(request()->except('people'))
                    ->people()->attach($people);

        $contract = Contract::latest()->with('people')->first();

        return $this->respondWithMessage('تم اضافة التوكيل بنجاح!', $contract);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function show(Contract $contract)
    {
        //
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function update(storeContractRequest $request, Contract $contract)
    {
        $people = array_column(request('people'), 'id');

        $contract->update(request()->except('people'));

        $contract->people()->sync($people);

        return ['message' => 'تم تحديث بيانات التوكيل بنجاح'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contract $contract)
    {
        $contract->delete();

        return ['message' => 'تم حذف التوكيل بنجاح!'];
    }

    /**
     * restore the specified resource to storage.
     *
     * @param    $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        
        $contract = Contract::onlyTrashed()
                            ->where('id', $id)
                            ->restore();

        return ['message' => 'تم استرجاع التوكيل بنجاح!'];
    }
}
