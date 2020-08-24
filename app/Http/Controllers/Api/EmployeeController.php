<?php

namespace App\Http\Controllers\Api;

use App\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        return $request->ip();
        return Employee::all()->pluck('name');
    }
}
