<?php

namespace App\Http\Controllers\Home;

use Redirect;
use App\Group;
use App\Employee;
use App\Marker;
use Carbon\Carbon;
use App\FacialRecognition;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        $groups = Group::all();

        return view('home.index')
            ->withGroups($groups)
            ->withEmployees($employees);
    }

    public function store(Request $request)
    {
        if ($request->input('avatar')) {
            $predictions = collect($request->input('names'))
                ->zip($request->input('avatar'));

            FacialRecognition::find($request->input('facerec_id'))
                ->confirmPredictions($predictions);
        }

        $group = Group::create([
            'status' => $request->input('status'),
            'returning' => Carbon::now()->addMinutes($request->input('minutes')),
            'returning_next_day' => $request->input('rest-of-day') == 'true'
        ]);

        collect($request->input('names'))->each(function ($name) use ($group) {
            if (($marker = Marker::where('name', $name)->first()) !== null) {
                $marker->delete();
            }

            $marker = Marker::create([
                'name' => $name,
            ]);
            $group->markers()->save($marker);
        });

        return Redirect::back();
    }
}
