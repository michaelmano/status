<?php

namespace App\Http\Controllers\Admin;

use Redirect;
use App\Group;
use App\Marker;
use App\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        Employee::create($request->except('_token'));

        return redirect()->back();
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->back();
    }
}
