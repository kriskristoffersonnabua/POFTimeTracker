<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\SubProject;
use App\Models\Auth\User\User;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Route;
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

        $params = [
            'user_id'         => $user->id,
            'project_id'      => $request->get('project_id'),
            'subproject_no'   => $request->get('subproject_no'),
            'subproject_name' => $request->get('subproject_name'),
            'description'     => $request->get('description'),
        ];

        $response = $this->requestAPI('/api/subprojects', 'POST', $params);

        return Redirect::action('Admin\SubProjectController@index',['project_id' => $request->get('project_id')]);
    }


    public function assign(Request $request, $id)
    {
        $user = $this->getAuthenticatedUser($request);

        $update_response = $this->requestAPI("/api/subprojects/${id}", 'PATCH', ['user_id', $request->get('user->id')]);

        $unassign_response = $this->requestAPI("/api/subprojects/unassign-employee", 'POST', ['subproject_id', $id]);

        $employees = $request->get('employees');

        foreach( $employees as $employee ){

            $params = [
                'emp_user_id'         => $employee,
                'subproject_id'      => $request->get('subproject_id')
            ];

            $response = $this->requestAPI('/api/subprojects/assign-employee', 'POST', $params);
        }

        dd( $request->all(), $update_response, $unassign_response, $response, 'exit');

        return Redirect::action('Admin\SubProjectController@index',['project_id' => $request->get('project_id')]);
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

    public function getAssignedEmployees(Request $request, $id) {

        $assigned_emp_response = $this->requestAPI('/api/subprojects/employees', 'GET', ['subproject_id', $id]);

        $employees = [];
        if ($assigned_emp_response->success) {
            $employees = $assigned_emp_response->data->subproject_employees;
        }

        return $employees;
    }
}
