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
use \Illuminate\Support\Facades\Route;
use App\Traits\ApiHelper;
use Redirect;

use Carbon\Carbon;

class ActivitiesController extends Controller
{
    use ApiHelper;
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

        return view('activities.index' , 
            [
                "activities"  => $activity, 
                "subprojects" => $subproject,
                "projects"    => $project
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
                        $new_file = new ActivityFile;
                        $new_file->activity_id = $new_activity->id;
                        $new_file->file = base64_encode(file_get_contents($file));
                        $new_file->file_link = $file->getClientOriginalName();
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
                        $new_file = new ActivityFile;
                        $new_file->activity_id = $new_activity->id;
                        $new_file->file = base64_encode(file_get_contents($file));
                        $new_file->file_link = $file->getClientOriginalName();
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
            $files = ActivityFile::select('id,activity_id,file_link,date_added')->where('activity_id', $id)->get();
            //dd($activity->files->toArray());
            //, 'files' => $activity->files->toArray()
            return $this->sendResponse(['details' => $activity->toArray(), 'tba' => $activity->tbas->toArray(), 'files' => $files->toArray()], "Activity fetched.");
        } catch(\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
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
