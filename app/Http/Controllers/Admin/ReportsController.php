<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Reports;
use App\Models\Auth\Role\Role;
use App\Models\Auth\User\User;
use Illuminate\Http\Request;
use App\Models\Projects\Projects;
use App\Models\Projects\SubProjects;
use App\Models\Reports\TimeHistory;

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
        $projects = app(Projects::class)->select('id', 'project_no')->get()->toArray();
        $subprojects = app(SubProjects::class)->select('id', 'subproject_no')->get()->toArray();
        $employees = User::with('roles')->sortable(['email' => 'asc'])->get()->toArray();

        $project_id = $request->get('project_id');
        $subproject_id = $request->get('subproject_id');
        $user_id = $request->get('user_id');

        $filters = [
            'id'            => $request->get('id'),
            'project_id'    => $project_id,
            'user_id'       => $user_id,
            'subproject_id' => $subproject_id,
            'time_start'    => $request->get('time_start'),
            'time_end'      => $request->get('time_end')
        ];
    
        $filters = array_remove_null($filters);
        $query = $this->buildQuery($filters);

        $query = $query->offset($request->get('offset') ?? self::DEFAULT_OFFSET);
        $query = $query->limit( $request->get('limit') ?? self::DEFAULT_LIMIT);
        $query = $query->orderBy('time_history.id','desc');

        $count = $query->count();
        $reports = $query->get();

        return view('reports.index', compact(['reports', 'count', 'projects', 'subprojects', 'employees', 'user_id', 'project_id', 'subproject_id']));
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

    protected function buildQuery($filters) {        
        $dateFields = ['date', 'time_start', 'time_end'];
        $query = app(TimeHistory::class);
        if (in_array('project_id', array_keys($filters)) || in_array('subproject_id', array_keys($filters))) {
            $query = $query->joinProjectAndSubproject($query);
        }
        foreach ($filters as $key => $value) {
            if ($key == 'project_id') {
                $query = $query->where('projects.id', $value);
            } elseif ($key == 'subproject_id') {
                $query = $query->where('subprojects.id', $value);
            } elseif (in_array($key, $dateFields)) {
                if (count($value) == 1) {
                    extract($this->convertDateFormat($value)[0]);
                    $query = $query->whereRaw(DB::raw("$key $comparison ?"));
                    $bindings[] = $date;
                } elseif (count($value) == 2) {
                    $query = $query->whereRaw(DB::raw("($key BETWEEN ? AND ?)"));
                    $bindings[] = $value[0];
                    $bindings[] = $value[1];
                }
                $query = $query->addBinding($bindings, 'where');
            } elseif (is_array($value)) {
                $query = $query->whereIn($key, $value);
            } elseif (is_int($value)) {
                $query = $query->where($key, $value);
            } else {
                $query = $query->whereRaw(DB::raw("$key LIKE ?"));
                $query = $query->addBinding("%$value%", 'where');
            }
        }
        return $query;
    }
}
