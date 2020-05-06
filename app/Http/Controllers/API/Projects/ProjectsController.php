<?php

namespace App\Http\Controllers\API\Projects;

use App\Traits\DataConverterHelper;
use App\Models\Projects\Projects;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use lluminate\Routing\ResponseFactory;
use App\Traits\ApiHelper;

class ProjectsController extends Controller
{
    use ApiHelper, DataConverterHelper;

    const DEFAULT_OFFSET = 0;
    const DEFAULT_LIMIT = 10; 

    public function index(Request $request) {
        try {
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

            return $this->sendResponse(['projects' => $query->get()->toArray(), 'count' => $count], "Project/s fetched.");
        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            return $this->sendError(
                'Project/s could not be fetched',
                ['error'=> $e->getMessage()],
                $errorCode && $errorCode <= 500 ?
                    $errorCode: 500
            );
        }
    }

    public function count(Request $request) {
        try {
            $filters = [
                'id'            => $this->convertCommaSeparated($request->get('id')),
                'created_at'    => $this->convertDateRange($request->get('created_at')),
                'updated_at'    => $this->convertDateRange($request->get('updated_at')),
                'project_no'    => $request->get('project_no')
            ];

            $filters = array_remove_null($filters);
            $query = $this->buildQuery($filters);

            return $this->sendResponse(['count' => $query->count()], "Count of project/s fetched.");
        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            return $this->sendError(
                'Projects count could not be fetched',
                ['error'=> $e->getMessage()],
                $errorCode && $errorCode <= 500 ?
                    $errorCode: 500
            );
        }
    }

    public function show(Request $request, $id) {
        try {
            $project = app(Projects::class)->findOrFail($id);

            return $this->sendResponse($project->toArray(), "Project found.") ;
        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            return $this->sendError(
                'Project could not be fetched',
                ['error'=> $e->getMessage()],
                $errorCode && $errorCode <= 500 ?
                    $errorCode: 500
            );
        }
    }

    public function store(Request $request) {
        try {
            $request->validate([
                'project_no' => 'required',
                'name' => 'required',
                'description' => 'required'
            ]);
            
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

            return $this->sendResponse($project->toArray(), "Project created.") ;
        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            return $this->sendError(
                'Project could not be created',
                ['error'=> $e->getMessage()],
                $errorCode && $errorCode <= 500 ?
                    $errorCode: 500
            );
        }
    }

    public function update(Request $request, $id) {
        try {
            $data = [
                'project_no'    => $request->get('project_no'),
                'name'          => $request->get('name'),
                'description'   => $request->get('description')
            ];

            $project = app(Projects::class)->findOrFail($id);
            $project->fill($data);
            $project->save();
            
            return $this->sendResponse($project->toArray(), "Project updated.") ;
        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            return $this->sendError(
                'Project could not be updated',
                ['error'=> $e->getMessage()],
                $errorCode && $errorCode <= 500 ?
                    $errorCode: 500
            );
        }
    }

    public function destroy(Request $request, $id) {
        try{
            $project = app(Projects::class)->findOrFail($id);

            if (!$project->subprojects()->exists()) {
                $project = $project->delete();
                if ($project) {
                    return $this->sendResponse(['is_deleted' => true], "Project deleted");
                }
            }
        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            return $this->sendError(
                'Project could not be deleted',
                ['error'=> $e->getMessage()],
                $errorCode && $errorCode <= 500 ?
                    $errorCode: 500
            );
        }
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

