<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Projects\Projects;
use App\Models\Projects\SubProjects;
use App\Models\Projects\SubprojectEmployees;
use App\Models\Auth\User\User;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Route;
use Carbon\Carbon;
use Redirect;

class SubProjectController extends Controller
{
    const DEFAULT_OFFSET = 0;
    const DEFAULT_LIMIT = 10; 

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
        $user = $this->getAuthenticatedUser($request);
        $params = $request->all();
        $subprojects = [];

        // $filters = [
        //     'id'            => $request->get('id'),
        //     'subproject_no' => $request->get('subproject_no'),
        //     'name'          => $request->get('name'),
        //     'project_id'    => $request->get('project_id'),
        //     'offset'        => $request->get('offset') ?? self::DEFAULT_OFFSET,
        //     'offset'        => $request->get('limit') ?? self::DEFAULT_LIMIT
        // ];

        $projects = Projects::all();
        $subprojects = SubProjects::all();

        if($request->get('project_id')) {
            $subprojects = SubProjects::where('project_id', $request->get('project_id'))->get();
        }

        $users = User::with('roles')->sortable(['email' => 'asc'])->get();

        return view('sub_projects.index', compact(['subprojects', 'projects', 'users']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = $this->getAuthenticatedUser($request);

        try {
            $request->validate([
                "project_id" => 'required',
                "subproject_no" => 'required',
                "subproject_name" => 'required',
                "description" => 'required'
            ]);
            $params = $request->all();

            $new_subproject = new SubProjects;
            $new_subproject->project_id = (int)$params['project_id'];
            $new_subproject->subproject_no = $params['subproject_no'];
            $new_subproject->subproject_name = $params['subproject_name'];
            $new_subproject->user_id = 0;
            $new_subproject->description = $params['description'];

            $new_subproject->save();

            return Redirect::action('Admin\SubProjectController@index',['project_id' => $params['project_id']]);

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
        
    }


    public function assign(Request $request, $id)
    {
        try {

            $user = $this->getAuthenticatedUser($request);

            $params = $request->all();

            $subproject = SubProjects::find($id);

            if (!isset($subproject)) {
                throw new \Exception("Subproject not existing", 404);
            }
            $subproject->user_id = $params['user_id'];
            $subproject->save();

            $subprojectEmployee = SubprojectEmployees::where("subproject_id", $id);
            $subprojectEmployee->delete();

            foreach( $params['employees'] as $employee ){

                $subprojectEmployee = new SubprojectEmployees;
                $subprojectEmployee->emp_user_id = (int) $employee;
                $subprojectEmployee->subproject_id = (int) $id;
                $subprojectEmployee->assigned_date = Carbon::now();
                $subprojectEmployee->created_at = Carbon::now();
                $subprojectEmployee->updated_at = Carbon::now();
                $subprojectEmployee->save();
            }

            return Redirect::action('Admin\SubProjectController@index',['project_id' => $params['project_id']]);
        } catch(\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SubProject  $subProject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = $this->getAuthenticatedUser($request);

        $params = [
            'name'          => $request->get('name'),
            'description'   => $request->get('description')
        ];

        $subproject = SubProjects::find($id);

        if (!isset($subproject)) {
            throw new \Exception("Subproject not existing", 404);
        }

        $subproject->update($params);
        $subproject->save();

        return Redirect::action('Admin\SubProjectController@index',['project_id' => $request->get('project_id')]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SubProject  $subProject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $user = $this->getAuthenticatedUser($request);

        $subproject = SubProjects::find($id);

        if (!isset($subproject)) {
            throw new \Exception("Subproject not existing", 404);
        }
        $subproject->delete();

    }

    public function getNextSubProjectNo(Request $request) {
        $params = $request->all();

        $subproject = SubProjects::where('project_id', $params['project_id'])->orderBy('subproject_no','desc')->first();
        
        $project = Projects::where('id',$params['project_id'])->first();
        $next_subproject_no = $project->project_no . '-1';
        if ($subproject) {
            $last_subproject_no = intval(str_replace($project->project_no . '-','',$subproject->subproject_no));
            $next_subproject_no = $project->project_no .'-' . ($last_subproject_no + 1);
        }

        return $next_subproject_no;
    }

    public function getAssignedEmployees(Request $request) {

        $subprojectEmployee = SubprojectEmployees::where("subproject_id", $request->get('subproject_id'));

        return $subprojectEmployee->get()->toArray();
    }
}
