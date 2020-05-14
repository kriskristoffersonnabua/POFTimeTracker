<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Project;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Route;
use Redirect;

class ProjectController extends Controller
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

        $filters = [
            'id'            => $request->get('id'),
            'project_no'    => $request->get('project_no'),
            'name'          => $request->get('name'),
            'offset'        => $request->get('offset') ?? self::DEFAULT_OFFSET,
            'offset'        => $request->get('limit') ?? self::DEFAULT_LIMIT
        ];
        
        $project_response = $this->requestAPI('/api/projects', 'GET', $filters);

        $projects = [];
        if ($project_response->success) {
            $projects = $project_response->data->projects;
            $count = $project_response->data->count;
        }

        $next = "";
        $project_no_response = $this->requestAPI('/api/projects/project_no', 'GET');

        if ($project_no_response->success) {
            $next = $project_no_response->data->project_no;
        }
        return view('projects.index', compact(['projects', 'count', 'next']));
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
            'project_no'    => $request->get('project_no'),
            'name'          => $request->get('name'),
            'description'   => $request->get('description')
        ];

        $request = $this->requestAPI('/api/projects', 'POST', $params);

        return Redirect::action('Admin\ProjectController@index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = $this->getAuthenticatedUser($request);

        $params = [
            'name'          => $request->get('name'),
            'description'   => $request->get('description')
        ];

        $request = $this->requestAPI("/api/projects/${id}", 'PATCH', $params);

        return Redirect::action('Admin\ProjectController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $user = $this->getAuthenticatedUser($request);

        $response = $this->requestAPI("/api/projects/${id}", 'DELETE');

        return $response;
    }
}
