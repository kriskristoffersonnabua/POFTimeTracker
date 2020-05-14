<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Reports;
use App\Models\Auth\Role\Role;
use App\Models\Auth\User\User;
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
    public function index(Request $request)
    {
        $user = $this->getAuthenticatedUser($request);
        $projects = $this->requestAPI('/api/projects', 'GET', ['limit' => -1])->data->projects;
        $subprojects = $this->requestAPI('/api/subprojects', 'GET', ['limit' => -1])->data;
        $employees = User::with('roles')->sortable(['email' => 'asc'])->get()->toArray();

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
        
        $reports_response = $this->requestAPI('/api/time-history', 'GET', $filters);

        $reports = [];
        if ($reports_response->success) {
            $reports = $reports_response->data->time_history;
            $count = $reports_response->data->count;
        }

        return view('reports.index', compact(['reports', 'count', 'projects', 'subprojects', 'employees']));
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
