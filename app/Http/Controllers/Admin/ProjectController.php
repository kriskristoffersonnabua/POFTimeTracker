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
        $accessToken = $user->createToken('poftt-token')->accessToken;

        $filters = [
            'id'            => $request->get('id'),
            'project_no'    => $request->get('project_no'),
            'name'          => $request->get('name'),
            'offset'        => $request->get('offset') ?? self::DEFAULT_OFFSET,
            'offset'        => $request->get('limit') ?? self::DEFAULT_LIMIT
        ];
        
        $request = Request::create('/api/projects', 'GET', array_merge([
            'headers' => [
                'Accept'        => 'application/json'
            ],
        ], $filters));

        $response = json_decode(Route::dispatch($request)->getContent());

        $projects = [];
        if ($response->success) {
            $projects = $response->data->projects;
            $count = $response->data->count;
            $next = str_pad($count + 1,4,"0",STR_PAD_LEFT);
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

        $request = Request::create('/api/projects', 'POST', array_merge([
            'headers' => [
                'Accept'        => 'application/json'
            ],
        ], $params));

        Route::dispatch($request);
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

        $request = Request::create("/api/projects/${id}", 'PATCH', array_merge([
            'headers' => [
                'Accept'        => 'application/json'
            ],
        ], $params));

        Route::dispatch($request);
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

        $request = Request::create("/api/projects/${id}", 'DELETE', [
            'headers' => [
                'Accept'        => 'application/json'
            ],
        ]);

        $response = Route::dispatch($request);

        return $response;
    }
}
