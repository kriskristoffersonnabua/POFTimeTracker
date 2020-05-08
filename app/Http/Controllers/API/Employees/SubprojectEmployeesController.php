<?php

namespace App\Http\Controllers\API\Employees;

use App\Traits\DataConverterHelper;
use App\Models\Employees\SubprojectEmployees;
use App\Http\Controllers\Controller;
use App\Traits\ApiHelper;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use lluminate\Routing\ResponseFactory;

class SubprojectEmployeesController extends Controller
{
    use ApiHelper, DataConverterHelper;
    const DEFAULT_OFFSET = 0;
    const DEFAULT_LIMIT = 10; 

    public function index(Request $request) {
        try {
            $filters = [
                'emp_user_id'      => $this->convertCommaSeparated($request->get('emp_user_id')),
                'subproject_id'    => $this->convertCommaSeparated($request->get('subproject_id')),
                'assigned_date'    => $this->convertDateRange($request->get('assigned_date'))
            ];
            $offset = $request->get('offset') ?? self::DEFAULT_OFFSET;
            $limit = $request->get('limit') ?? self::DEFAULT_LIMIT;

            $filters = array_remove_null($filters);
            $query = $this->buildQuery($filters);

            $count = $query->count();

            $query = $query->offset($offset);
            $query = $query->limit($limit);
            return $this->sendResponse(['subproject_employees' => $query->get()->toArray(), 'count' => $count], "Subproject employee/s fetched.");
        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            return $this->sendError(
                'Subproject employee/s could not be fetched',
                ['error'=> $e->getMessage()],
                $errorCode && $errorCode <= 500 ?
                    $errorCode: 500
            );
        }
    }

    public function count(Request $request) {
        $filters = [
            'emp_user_id'      => $this->convertCommaSeparated($request->get('emp_user_id')),
            'subproject_id'    => $this->convertCommaSeparated($request->get('subproject_id')),
            'assigned_date'    => $this->convertDateRange($request->get('assigned_date'))
        ];

        $filters = array_remove_null($filters);
        $query = $this->buildQuery($filters);

        return $this->responseInJson(['count' => $query->count()]);
    }

    public function show(Request $request, $id) {
        try {
            $subprojectEmployee = app(SubprojectEmployees::class)->findOrFail($id);

            return $this->sendResponse($subprojectEmployee->toArray(), "SubprojectEmployee found.") ;
        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            return $this->sendError(
                'SubprojectEmployee could not be fetched',
                ['error'=> $e->getMessage()],
                $errorCode && $errorCode <= 500 ?
                    $errorCode: 500
            );
        }
    }

    public function assignBatchEmployees(Request $request) {
        $assignedEmployees = [];
        $emp_user_ids = [];
        try {
            $request->validate([
                'emp_user_ids' => 'required',
                'subproject_id' => 'required'
            ]);
            $emp_user_ids = $this->convertCommaSeparated($request->get('emp_user_id'));
            $subproject_id = $request->get('subproject_id');

            foreach ($emp_user_ids as $emp_user_id) {
                $subprojectEmployee = new SubprojectEmployees;
                $subprojectEmployee->emp_user_id = $emp_user_id;
                $subprojectEmployee->subproject_id = $subproject_id;
                $subprojectEmployee->assigned_date = Carbon::now();
                $subprojectEmployee->created_at = Carbon::now();
                $subprojectEmployee->updated_at = Carbon::now();
                if ($subprojectEmployee->save()) {
                    $assignedEmployees[] = $subprojectEmployee->toArray();
                }
                throw new Exception();
            }

            return $this->sendResponse(['assignedEmployees' => $assignedEmployees], "Employees assigned.");
        } catch (\Exception $e) {
            $errorCode = $e->getCode();
            $unassignedEmployees = array_diff($emp_user_ids, Arr::pluck($assignedEmployees, 'emp_user_id')).join(",");

            return $this->sendError(
                "Employees [${unassignedEmployees}] could not be created",
                ['error'=> $e->getMessage()],
                $errorCode && $errorCode <= 500 ?
                    $errorCode: 500
            );
        }
    }
    public function unassignSubprojectEmployee(Request $request) {
        try {
            $request->validate([
                'id' => 'required'
            ]);
            $id = $request->get('id');

            $subprojectEmployee = app(SubprojectEmployees::class)->firstOrFail($id);
            $subprojectEmployee->subproject_id = 0;

            return $this->sendResponse(['is_unassigned' => true], "Employee unassigned.");
        } catch (\Exception $e) {
            $errorCode = $e->getCode();
            
            return $this->sendError(
                "Employee could not be unassigned",
                ['error'=> $e->getMessage()],
                $errorCode && $errorCode <= 500 ?
                    $errorCode: 500
            );
        }
    }

    public function store(Request $request) {
        try {
            $request->validate([
                'emp_user_id' => 'required',
                'subproject_id' => 'required'
            ]);
            
            $emp_user_id = $request->get('emp_user_id');
            $subproject_id = $request->get('subproject_id');

            $subprojectEmployee = new SubprojectEmployees;
            $subprojectEmployee->emp_user_id = $emp_user_id;
            $subprojectEmployee->subproject_id = $subproject_id;
            $subprojectEmployee->assigned_date = Carbon::now();
            $subprojectEmployee->created_at = Carbon::now();
            $subprojectEmployee->updated_at = Carbon::now();
            $subprojectEmployee->save();

            return $this->sendResponse($subprojectEmployee->toArray(), "Subproject Employee created.") ;
        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            return $this->sendError(
                'Subproject Employee could not be created',
                ['error'=> $e->getMessage()],
                $errorCode && $errorCode <= 500 ?
                    $errorCode: 500
            );
        }
    }

    public function update(Request $request, $id) {
        try {
            $request->validate([
                'subproject_id' => 'required'
            ]);

            $data = [
                'subproject_id'    => $request->get('subproject_id'),
                'assigned_date'    => Carbon::now()
            ];

            $subprojectEmployee = app(SubprojectEmployees::class)->findOrFail($id);
            $subprojectEmployee->fill($data);
            $subprojectEmployee->save();
            
            return $this->sendResponse($subprojectEmployee->toArray(), "Subproject Employee updated.") ;
        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            return $this->sendError(
                'Subproject Employee could not be updated',
                ['error'=> $e->getMessage()],
                $errorCode && $errorCode <= 500 ?
                    $errorCode: 500
            );
        }
    }

    public function destroy(Request $request, $id) {
        try{
            $subprojectEmployee = app(SubprojectEmployees::class)->findOrFail($id);

            if ($project->delete()) {
                return $this->sendResponse(['is_deleted' => true], "Subproject Employee deleted");
            }
        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            return $this->sendError(
                'Subproject Employee could not be deleted',
                ['error'=> $e->getMessage()],
                $errorCode && $errorCode <= 500 ?
                    $errorCode: 500
            );
        }
    }

    protected function buildQuery($filters) {        
        $dateFields = ['created_at', 'updated_at'];

        $query = app(SubprojectEmployees::class);
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

