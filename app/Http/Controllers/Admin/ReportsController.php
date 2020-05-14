<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Reports;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    const DEFAULT_OFFSET = 0;
    const DEFAULT_LIMIT = 10; 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = $this->getAuthenticatedUser($request);

        $filters = [
            'id'            => $request->get('id'),
            'project_id'    => $request->get('project_id'),
            'user_id'       => $request->get('user_id'),
            'subproject_id' => $request->get('subproject_id'),
            'time_start'    => $request->get('time_start'),
            'time_end'      => $request->get('time_end'),
            'offset'        => $request->get('offset') ?? self::DEFAULT_OFFSET,
            'limit'         => $request->get('limit') ?? self::DEFAULT_LIMIT
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
        return view('reports.index', compact(['projects', 'count', 'next']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reports  $reports
     * @return \Illuminate\Http\Response
     */
    public function show(Reports $reports)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reports  $reports
     * @return \Illuminate\Http\Response
     */
    public function edit(Reports $reports)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reports  $reports
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reports $reports)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reports  $reports
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reports $reports)
    {
        //
    }
}
