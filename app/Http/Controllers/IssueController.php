<?php

namespace App\Http\Controllers;

use App\File;
use App\Issue;
use App\Person;
use App\Http\Requests\storeIssueRequest;
use App\Http\Requests\updateIssueRequest;
use App\Http\Requests\attachOpenentRequest;
use App\Http\Requests\uploadFileRequest;
use Illuminate\Http\Request;

class IssueController extends Controller
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

        $issues = Issue::latest()->with('openents')->paginate(10);

        if($type)
        {
            $issues = Issue::latest()
                        ->where('type', $type)
                        ->with('openents')->paginate(10);
        }

        if($type == 'trashed')
        {
            $issues = Issue::latest()
                        ->onlyTrashed()
                        ->with('openents')->paginate(10);
        }

        return $this->makeResponse('issues/manageIssues', compact('issues', 'people'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(storeIssueRequest $request)
    {
        $issue = Issue::create($request->all());



        return $this->respondWithMessage('تم اضافة القضية بنجاح!', $issue);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function show(Issue $issue)
    {
        $issue->load('openents.contracts');
        
        $people = Person::orderBy('name')
            ->select('id', 'name', 'location')->get();
        
        return $this->makeResponse('issues/issueProfile', compact('issue', 'people'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function update(updateIssueRequest $request, Issue $issue)
    {
        $issue->update($request->all());

        return ['message' => 'تم تحديث بيانات القضية بنجاح!'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Issue $issue)
    {
        $issue->delete();

        return ['message' => 'تم حذف القضية.'];
    }

    /**
     * restore the specified resource from storage.
     *
     * @param  \App\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $issue = Issue::onlyTrashed()
                ->where('id', $id)->restore();

        return ['message' => 'تم استعادة القضية بنجاح.'];
    }

    /**
     * attach openent to issue.
     *
     * @param  \App\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function attachOpenent(attachOpenentRequest $request, Issue $issue)
    {
        $openent = $request->openent['id'];

        if(!is_null($issue->openents()->where('id', $openent)->first()))
        {
            $errors = [
                'errors' => [
                'openent' => ['هذا الخصم مضاف من قبل.']
                ]
            ];

            return response()->json($errors, 422);
        }

        $issue->openents()
                ->attach($openent, ['person_type' => $request->person_type]);

        return ['message' => 'تم اضافة الخصم بنجاح!'];
    }

    /**
     * update attached openent to issue.
     *
     * @param  \App\Issue  $issue
     * @return \Illuminate\Http\Response
     */

    public function updateOpenent(attachOpenentRequest $request, Issue $issue)
    {
        // temporary - we add checks later
        $openent = $request->openent['id'];

        $issue->openents()->detach($request->old_id);

        $issue->openents()
                ->attach($openent, ['person_type' => $request->person_type]);

        return ['message' => 'تم تحديث بيانات الموكل'];
    }

    /**
     * delete attached openent to issue.
     *
     * @param  \App\Issue  $issue
     * @param  id  $openent
     * @return \Illuminate\Http\Response
     */

    public function deleteOpenent(Request $request, Issue $issue, $openent)
    {
        // temporary - we add checks later
        $issue->openents()->detach($openent);

        return ['message' => 'تم حذف الخصم بنجاح'];
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filesIndex(Issue $issue)
    {
        $files = File::latest()
                        ->where('fileable_id', $issue->id)
                        ->where('fileable_type', 'issue')
                        ->get();

        return $this->makeResponse('issues/issueProfile', compact('issue', 'files'));
    }

    public function storeFile(uploadFileRequest $request, Issue $issue)
    {
        if ($request->hasFile('file')) 
        {
            $relatedFile = $this->handleUploadFile($request, $issue, 'issues_files');
            $issue->files()->create($relatedFile);

            return ['message' => 'file Uploaded Successfully!'];
        }

        return ['message' => 'something went Wrong'];
    }
}
