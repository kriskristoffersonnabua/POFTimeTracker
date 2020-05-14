<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\SubProject;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Route;

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
        $accessToken = $user->createToken('poftt-token')->accessToken;

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

        return view('sub_projects.index', compact(['subprojects', 'projects']));
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
            'project_id'    => $request->get('project_id'),
            'subproject_no' => $request->get('project_no'),
            'name'          => $request->get('name'),
            'description'   => $request->get('description')
        ];

        $request = Request::create('/api/subprojects', 'POST', array_merge([
            'headers' => [
                'Accept'        => 'application/json'
            ],
        ], $params));

        Route::dispatch($request);
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

        $request = Request::create("/api/subprojects/${id}", 'PATCH', array_merge([
            'headers' => [
                'Accept'        => 'application/json'
            ],
        ], $params));

        Route::dispatch($request);
        return Redirect::action('Admin\SubProjectController@index');
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
}
