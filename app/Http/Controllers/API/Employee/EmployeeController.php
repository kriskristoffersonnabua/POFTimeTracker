<?php

namespace App\Http\Controllers\API\Employee;

use App\Http\Controllers\Controller;
use App\Models\Auth\User\User;
use App\Traits\ApiHelper;
use App\Traits\DataConverterHelper;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use lluminate\Routing\ResponseFactory;

class EmployeeController extends Controller
{
    use ApiHelper, DataConverterHelper;
    const DEFAULT_OFFSET = 0;
    const DEFAULT_LIMIT = 10;

    public function index(Request $request) {
        try {
            $filters = [
                'id'                    => $this->convertCommaSeparated($request->get('id')),
                'first_name'            => $request->get('first_name'),
                'last_name'             => $request->get('last_name'),
                'email'                 => $request->get('email'),
                'employee_no'           => $request->get('employee_no'),
                'active'                => $request->get('active'),
                'confirmed'             => $request->get('confirmed'),
                'email_verified_at'     => $this->convertDateRange($request->get('email_verified_at'))
            ];
            $offset = $request->get('offset') ?? self::DEFAULT_OFFSET;
            $limit = $request->get('limit') ?? self::DEFAULT_LIMIT;

            $filters = array_remove_null($filters);
            $query = $this->buildQuery($filters);

            $count = $query->count();

            $query = $query->offset($offset);
            $query = $query->limit($limit);

            return $this->sendResponse(['employees' => $query->get()->toArray(), 'count' => $count], "Employees fetched.");
        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            return $this->sendError(
                'Employees could not be fetched',
                ['error'=> $e->getMessage()],
                $errorCode && $errorCode <= 500 ?
                    $errorCode: 500
            );
        }
    }

    public function count(Request $request) {
        try {
            $filters = [
                'id'                    => $this->convertCommaSeparated($request->get('id')),
                'first_name'            => $request->get('first_name'),
                'last_name'             => $request->get('last_name'),
                'email'                 => $request->get('email'),
                'employee_no'           => $request->get('employee_no'),
                'active'                => $request->get('active'),
                'confirmed'             => $request->get('confirmed'),
                'email_verified_at'     => $this->convertDateRange($request->get('email_verified_at')),
            ];
    
            $filters = array_remove_null($filters);
            $query = $this->buildQuery($filters);

            return $this->sendResponse(['count' => $query->count()], "Employees count fetched.");
        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            return $this->sendError(
                'Employees count could not be fetched',
                ['error'=> $e->getMessage()],
                $errorCode && $errorCode <= 500 ?
                    $errorCode: 500
            );
        }
    }

    public function show(Request $request, $id) {
        try {
            $employee = app(User::class)->with('roles')->findOrFail($id);

            return $this->sendResponse($employee->toArray(), "Employee found.") ;
        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            return $this->sendError(
                'Employee could not be fetched',
                ['error'=> $e->getMessage()],
                $errorCode && $errorCode <= 500 ?
                    $errorCode: 500
            );
        }
    }

    public function store(Request $request) {
        try {
            $request->validate([
                'email' => 'required',
                'employee_no' => 'required',
                'first_name' => 'required',
                'last_name' => 'required'
            ]);
            
            $first_name = $request->get('first_name');
            $last_name = $request->get('last_name');
            $email = $request->get('email');
            $employee_no = $request->get('employee_no');

            $employee = new User;
            $employee->first_name = $first_name;
            $employee->last_name = $last_name;
            $employee->email = $email;
            $employee->employee_no = $employee_no;
            $employee->password = bcrypt('password');
            $employee->created_at = Carbon::now();
            $employee->updated_at = Carbon::now();
            $employee->save();

            return $this->sendResponse($employee->toArray(), "Employee created.");
        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            return $this->sendError(
                'Employee could not be created',
                ['error'=> $e->getMessage()],
                $errorCode && $errorCode <= 500 ?
                    $errorCode: 500
            );  
        }
    }

    public function destroy(Request $request, $id) {
        try{
            $timeHistory = app(User::class)->findOrFail($id);
            if ($timeHistory->delete()) {
                return $this->sendResponse(['is_deleted' => true], "Employee deleted");
            }
            throw new \Exception("Internal server error");

        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            return $this->sendError(
                'Employee could not be deleted',
                ['error'=> $e->getMessage()],
                $errorCode && $errorCode <= 500 ?
                    $errorCode: 500
            );
        }
    }
    
    public function update(Request $request, $id) {
        try {
            $data = [
                'first_name'            => $request->get('first_name'),
                'last_name'             => $request->get('last_name'),
                'email'                 => $request->get('email'),
                'employee_no'           => $request->get('employee_no'),
                'active'                => $request->get('active'),
                'confirmed'             => $request->get('confirmed'),
                'email_verified_at'     => $this->convertDateRange($request->get('email_verified_at'))
            ];

            $employee = app(User::class)->findOrFail($id);
            $employee->fill(array_remove_null($data));
            $employee->save();

            return $this->sendResponse($employee->toArray(), "Employee updated.") ;
        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            return $this->sendError(
                'Employee could not be updated',
                ['error'=> $e->getMessage()],
                $errorCode && $errorCode <= 500 ?
                    $errorCode: 500
            );
        }
    }

    protected function buildQuery($filters) {        
        $dateFields = ['email_verified_at'];
        $query =  User::with('roles');

        foreach ($filters as $key => $value) {
            If (in_array($key, $dateFields)) {
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