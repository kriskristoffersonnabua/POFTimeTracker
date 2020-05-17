<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\SubProject;
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $this->getAuthenticatedUser($request);

        $params = $request->all();
        $subprojects = [];

        $filters = [
            'id'            => $request->get('id'),
            'subproject_no' => $request->get('subproject_no'),
            'name'          => $request->get('name'),
            'project_id'    => $request->get('project_id'),
            'offset'        => $request->get('offset') ?? self::DEFAULT_OFFSET,
            'offset'        => $request->get('limit') ?? self::DEFAULT_LIMIT
        ];
        
        $subproject_response = $this->requestAPI('/api/subprojects', 'GET', $filters);
        
        if ($subproject_response->success) {
            $subprojects = $subproject_response->data;
        }

        $project_response = $this->requestAPI('/api/projects', 'GET');

        $projects = [];
        if ($project_response->success) {
            $projects = $project_response->data->projects;
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

        $response = $this->requestAPI("/api/subprojects/${id}", 'PATCH', $params);

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

        $request = Request::create("/api/subprojects/${id}", 'DELETE', [
            'headers' => [
                'Accept'        => 'application/json'
            ],
        ]);

        $response = Route::dispatch($request);

        return $response;
    }

    public function getNextSubProjectNo(Request $request) {
        $next = "";

        $subproject_no_response = $this->requestAPI('/api/subprojects/subproject_no', 'GET', ['project_id' => $request->get('project_id')]);
        
        if ($subproject_no_response->success) {
            $next = $subproject_no_response->data->subproject_no;
        }

        return $next;
    }

    public function getAssignedEmployees(Request $request) {

        $subprojectEmployee = SubprojectEmployees::where("subproject_id", $request->get('subproject_id'));

        return $subprojectEmployee->get()->toArray();
    }
}
