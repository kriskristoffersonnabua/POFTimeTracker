<?php

namespace App\Http\Controllers\API\Projects;

use App\Traits\DataConverterHelper;
use App\Models\Projects\Projects;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use lluminate\Routing\ResponseFactory;

class ProjectsController extends Controller
{
    use DataConverterHelper;
    const DEFAULT_OFFSET = 0;
    const DEFAULT_LIMIT = 10; 

    public function index(Request $request) {
        $dateFields = ['created_at', 'updated_at'];

        $filters = [
            'id'            => $this->convertCommaSeparated($request->get('id')),
            'created_at'    => $this->convertDateRange($request->get('created_at')),
            'updated_at'    => $this->convertDateRange($request->get('updated_at')),
            'project_no'    => $request->get('project_no')
        ];
        $offset = $request->get('offset') ?? self::DEFAULT_OFFSET;
        $limit = $request->get('limit') ?? self::DEFAULT_LIMIT;

        $filters = array_remove_null($filters);
        $query = $this->buildQuery($filters);

        $count = $query->count();

        $query = $query->offset($offset);
        $query = $query->limit($limit);

        return $this->responseInJson(['projects' => $query->get()->toArray(), 'count' => $count]);
    }

    public function count(Request $request) {
        $dateFields = ['created_at', 'updated_at'];

        $filters = [
            'id'            => $this->convertCommaSeparated($request->get('id')),
            'created_at'    => $this->convertDateRange($request->get('created_at')),
            'updated_at'    => $this->convertDateRange($request->get('updated_at')),
            'project_no'    => $request->get('project_no')
        ];

        $filters = array_remove_null($filters);
        $query = $this->buildQuery($filters);

        return $this->responseInJson(['count' => $query->count()]);
    }

    public function show(Request $request, $projects_id) {
        $project = app(Projects::class)->findOrFail($projects_id);

        return $this->responseInJson($project);
    }

    public function store(Request $request) {
        $project_no = $request->get('project_no');
        $name = $request->get('name');
        $description = $request->get('description');

        $project = new Projects;
        $project->project_no = $project_no;
        $project->name = $name;
        $project->description = $description;
        $project->created_at = Carbon::now();
        $project->updated_at = Carbon::now();
        $project->save();

        return $this->responseInJson($project);
    }

    public function update(Request $request, $projects_id) {
        $data = [
            'project_no'    => $request->get('project_no'),
            'name'          => $request->get('name'),
            'description'   => $request->get('description')
        ];

        $project = app(Projects::class)->findOrFail($projects_id);
        $project->fill($data);
        $project->save();
        
        return $this->responseInJson($project);
    }

    public function destroy(Request $request, $projects_id) {
        $project = app(Projects::class)->findOrFail($projects_id);

        if (!$project->subprojects()->exists()) {
            $project = $project->delete();
            if ($project) {
                return $this->responseInJson(['is_deleted' => true]);
            }
        }
        return $this->responseInJson(['is_deleted' => false]);
    }

    protected function buildQuery($filters) {
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

