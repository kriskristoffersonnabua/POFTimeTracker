<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// use App\Activities;
use Illuminate\Http\Request;
use App\Models\Projects\Projects;
use App\Models\Projects\SubProjects;
use App\Models\Activity\Activity;
use App\Models\Activity\ActivityTBAS;
use App\Models\Activity\ActivityFile;
use App\Models\Activity\ActivityComments;
use App\Models\Auth\User\User;
use \Illuminate\Support\Facades\Route;
use App\Traits\ApiHelper;

use App\Utilities\FileStorageUtility;
use Redirect;

use Carbon\Carbon;

class ActivitiesController extends Controller
{
    use ApiHelper;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $project = Projects::all();
        $subproject = SubProjects::all();
        $activity = Activity::all();

        if($request->get('subproject_id')) {
            $activity = Activity::where('subproject_id', $request->get('subproject_id'))->get();
        }
        $users = User::with('roles')->sortable(['email' => 'asc'])->get();

        return view('activities.index' , 
            [
                "activities"  => $activity, 
                "subprojects" => $subproject,
                "projects"    => $project,
                "users"       => $users
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            $fileStorageUtility = app(FileStorageUtility::class);
            $request->validate([
                'subproject_id' => 'required',
                'activity_no' => 'required',
                'title' => 'required',
                'description' => 'required',
                'acceptance_criteria' => 'required'
            ]);
        
            $params = $request->all();

            $new_activity = new Activity;
            $new_activity->subproject_id = $params['subproject_id'];
            $new_activity->activity_no = $params['activity_no'];
            $new_activity->employee_user_id = 0;
            $new_activity->title = $params['title'];
            $new_activity->description = $params['description'];
            $new_activity->acceptance_criteria = $params['acceptance_criteria'];
            $new_activity->estimated_hours = 0;
            $new_activity->created_at = Carbon::now();
            $new_activity->updated_at = Carbon::now();
            $new_activity->save();

            if(!empty($params['tba'])) {
                foreach( $params['tba'] as $tba ){
                    if($tba) {
                        $new_tba = new ActivityTBAS;
                        $new_tba->activity_id = $new_activity->id;
                        $new_tba->tba = $tba;
                        $new_tba->save();
                    }
                }
            }

            if(!empty($request->file('file'))) {
                foreach( $request->file('file') as $file ){
                    if($file){
                        $filePath = $file->getClientOriginalName();
                        $fileStorageUtility->uploadOrGetFileFromS3($filePath, file_get_contents($file));

                        $new_file = new ActivityFile;
                        $new_file->activity_id = $new_activity->id;
                        $new_file->file = null;
                        $new_file->file_link = $filePath;
                        $new_file->date_added = Carbon::now();
                        $new_file->created_at = Carbon::now();
                        $new_file->updated_at = Carbon::now();
                        $new_file->save();
                    }
                }
            }

            return Redirect::action('Admin\ActivitiesController@index',['project_id' => $params['project_id'], 'subproject_id' => $params['subproject_id']]);

        } catch(\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Activities  $activities
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $fileStorageUtility = app(FileStorageUtility::class);
            $request->validate([
                'subproject_id' => 'required',
                'activity_no' => 'required',
                'title' => 'required',
                'description' => 'required',
                'acceptance_criteria' => 'required'
            ]);
        
            $params = $request->all();

            $new_activity = Activity::find($id);
            $new_activity->subproject_id = $params['subproject_id'];
            $new_activity->activity_no = $params['activity_no'];
            $new_activity->employee_user_id = 0;
            $new_activity->title = $params['title'];
            $new_activity->description = $params['description'];
            $new_activity->acceptance_criteria = $params['acceptance_criteria'];
            $new_activity->estimated_hours = 0;
            $new_activity->save();

            if(!empty($params['tba'])) {
                ActivityTBAS::where('activity_id', $id)->delete();
                foreach( $params['tba'] as $tba ){
                    if($tba) {
                        $new_tba = new ActivityTBAS;
                        $new_tba->activity_id = $new_activity->id;
                        $new_tba->tba = $tba;
                        $new_tba->save();
                    }
                }
            }
            if(!empty($request->file('file'))) {
                ActivityFile::where('activity_id', $id)->delete();
                foreach( $request->file('file') as $file ){
                    if($file){
                        $filePath = $file->getClientOriginalName();
                        $fileStorageUtility->uploadOrGetFileFromS3($filePath, file_get_contents($file));

                        $new_file = new ActivityFile;
                        $new_file->activity_id = $new_activity->id;
                        $new_file->file = null;
                        $new_file->file_link = $filePath;
                        $new_file->date_added = Carbon::now();
                        $new_file->created_at = Carbon::now();
                        $new_file->updated_at = Carbon::now();
                        $new_file->save();
                    }
                }
            }

            return Redirect::action('Admin\ActivitiesController@index',['project_id' => $params['project_id'], 'subproject_id' => $params['subproject_id']]);

        } catch(\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }
    
    public function done(Request $request, $id)
    {
        try {
        
            $params = $request->all();

            $new_activity = Activity::find($id);
            $new_activity->status = 'ready_for_testing';
            $new_activity->save();

        } catch(\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Activities  $activities
     * @return \Illuminate\Http\Response
     */
    public function assign(Request $request, $id)
    {
        try {
            $request->validate([
                'employee_user_id' => 'required',
                'estimated_hours' => 'required'
            ]);
        
            $params = $request->all();

            $new_activity = Activity::find($id);
            $new_activity->employee_user_id = $params['employee_user_id'];
            $new_activity->estimated_hours = $params['estimated_hours'];
            $new_activity->save();

            return Redirect::action('Admin\ActivitiesController@index',['project_id' => $params['project_id'], 'subproject_id' => $params['subproject_id']]);

        } catch(\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Activities  $activities
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $activity = Activity::find($id);
        $activity->delete();
    }

    public function show(Request $request, $id)
    {
        try {
            
            $activity = Activity::find($id);
            $files = ActivityFile::select('file_link')->where('activity_id', $id)->get();
            $subproject = SubProjects::find($activity->subproject_id);
            $activity_comments = ActivityComments::orderBy('id', 'DESC')->where('activity_id',$id)->get();
            $user = \Auth::user();
            
            return $this->sendResponse(['details' => $activity->toArray(), 'subproject' => $subproject->toArray(),'tba' => $activity->tbas->toArray(), 'files' => $files->toArray(), 'comments' => $activity_comments->toArray(), 'user' => $user], "Activity fetched.");
        } catch(\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    public function addComment(Request $request) {
        try {
            $request->validate([
                'user_id' => 'required',
                'comment' => 'required',
            ]);

            $params = $request->all();
            $activity = Activity::where('activity_no', $params['activity_no'])->get()->toArray();
            
            $new_activity_comment = new ActivityComments;
            $new_activity_comment->activity_id = $activity[0]['id'];
            $new_activity_comment->user_id = $params['user_id'];
            $new_activity_comment->comment = $params['comment'];
            $new_activity_comment->date_added = date("Y-m-d H:i:s");
            $new_activity_comment->save();

            return $this->sendResponse($new_activity_comment->toArray(), 'Activity comment Created.');

        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            return $this->sendError(
                'Activity comment could not be created',
                ['error'=>$e->getMessage()],
                $errorCode && $errorCode <= 500 ?
                    $errorCode: 500
            );
        }
    }

    public function getNextActivityNo(Request $request) {
        try {
            $params = $request->all();

            $activities = Activity::where('subproject_id', $params['subproject_id'])->orderBy('activity_no','desc')->first();
           
            $subproject = SubProjects::where('id',$params['subproject_id'])->first();
            $activity_no = $subproject->subproject_no . '-001';
            if ($activities) {
                $last_activity_no = intval(str_replace($subproject->subproject_no . '-','',$activities->activity_no));
                $activity_no = $subproject->subproject_no .'-' . str_pad(($last_activity_no + 1),3,"0",STR_PAD_LEFT);;
            }

            return $activity_no;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }
}
