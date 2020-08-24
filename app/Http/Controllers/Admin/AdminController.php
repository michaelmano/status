<?php

namespace App\Http\Controllers\Admin;

use Redirect;
use App\Group;
use App\Marker;
use App\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::all();
        $groups = Group::all();
        $signedOut = Marker::all()->count();

        return view('admin.index')
            ->withGroups($groups)
            ->withEmployees($employees)
            ->withSignedOut($signedOut);
    }
}
