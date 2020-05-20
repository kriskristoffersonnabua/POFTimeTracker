<?php

namespace App\Http\Controllers\Admin;

use App\Models\Auth\Role\Role;
use App\Models\Auth\User\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Traits\ApiHelper;
use Redirect;
use Carbon\Carbon;
use App\Traits\DataConverterHelper;
use Ramsey\Uuid\Uuid;

class EmployeesController extends Controller
{
    use ApiHelper, DataConverterHelper;
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
    public function index()
    {
        $employee = app(User::class)->orderBy('employee_no','desc')->first();

        $next_employee_no = '000001';
        if ($employee) {
            $last_employee_no = intval($employee->employee_no);
            $next_employee_no = str_pad($last_employee_no + 1,6,"0",STR_PAD_LEFT);
        }

        $next = $next_employee_no;

        return view('employees.index', ['users' => User::with('roles')->sortable(['email' => 'asc'])->paginate(), 'next' => $next]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
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
            
            $user = User::create([
                'first_name' => $first_name,
                'last_name' =>$last_name,
                'email' => $email,
                'employee_no' => $employee_no,
                'password' => bcrypt('password'),
                'confirmation_code' => Uuid::uuid4(),
            ]);
            
            return Redirect::action('Admin\EmployeesController@index');
        } catch(\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
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
     * @param  \App\Employees  $employees
     * @return \Illuminate\Http\Response
     */
    public function show(Employees $employees)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employees  $employees
     * @return \Illuminate\Http\Response
     */
    public function edit(Employees $employees)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employees  $employees
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employees $employees)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employees  $employees
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employees $employees)
    {
        //
    }
}
