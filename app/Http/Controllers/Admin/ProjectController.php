<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\DataConverterHelper;
use App\Project;
use App\Models\Projects\Projects;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Route;
use App\Traits\ApiHelper;
use Redirect;

class ProjectController extends Controller
{
    use ApiHelper, DataConverterHelper;

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
        $filters = [
            'id'            => $this->convertCommaSeparated($request->get('id')),
            'created_at'    => $this->convertDateRange($request->get('created_at')),
            'updated_at'    => $this->convertDateRange($request->get('updated_at')),
            'project_no'    => $request->get('project_no'),
            'name'          => $request->get('name'),
        ];

        $offset = $request->get('offset') ?? self::DEFAULT_OFFSET;
        $limit = $request->get('limit') ?? self::DEFAULT_LIMIT;

        $filters = array_remove_null($filters);
        $query = $this->buildQuery($filters);

        $count = $query->count();

        $query = $query->offset($offset);
        $query = $query->limit($limit);

        $projects = $query->get();

        $next = "";

        $project = app(Projects::class)->orderBy('project_no','desc')->first();

        $next_project_no = '000001';
        if ($project) {
            $last_project_no = intval($project->project_no);
            $next_project_no = str_pad($last_project_no + 1,6,"0",STR_PAD_LEFT);
        }

        $next = $next_project_no;

        return view('projects.index', compact(['projects', 'next']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->validate([
            'project_no'    =>  'required',
            'name'          =>  'required',
            'description'   =>  'required'
        ]);

        $project_no     =   $request->get('project_no');
        $name           =   $request->get('name');
        $description    =   $request->get('description');

        $project = new Projects;
        $project->project_no = $project_no;
        $project->name = $name;
        $project->description = $description;
        $project->created_at = Carbon::now();
        $project->updated_at = Carbon::now();
        $project->save();

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
        $data = [
            'project_no'    => $request->get('project_no'),
            'name'          => $request->get('name'),
            'description'   => $request->get('description')
        ];
        
        $project = app(Projects::class)->findOrFail($id);
        $project->update($data);
        $project->save();

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
        $project = app(Projects::class)->findOrFail($id);

        if (!$project->subprojects()->exists()) {
            $project = $project->delete();
        }
        
        return Redirect::action('Admin\ProjectController@index');
    }

    protected function buildQuery($filters) {        
        $dateFields = ['created_at', 'updated_at'];

        $query = app(Projects::class);
        foreach ($filters as $key => $value) {
            if (in_array($key, $dateFields)) {
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
