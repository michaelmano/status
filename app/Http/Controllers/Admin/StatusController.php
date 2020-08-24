<?php

namespace App\Http\Controllers\Admin;

use Redirect;
use App\Group;
use App\Marker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StatusController extends Controller
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
    
    public function destroy(Request $request)
    {
        $method = 'remove'.ucfirst(
            $request->has('bulk')
            ? $request->get('bulk')
            : 'Single'
        );
        
        $this->{$method}($request);

        return redirect()->route('admin.index');
    }

    protected function removeAll()
    {
        Marker::all()->each(function ($marker) {
            Group::deleteMarker($marker);
        });
    }

    protected function removeOverdue()
    {
        Group::all()
        ->filter(function ($group) {
            return $group->overdue;
        })
        ->each(function ($group) {
            $group->delete();
        });
    }

    protected function removeSingle($request)
    {
        $name = $request->get('single');
        $marker = Marker::whereName($name)->first();
        Group::deleteMarker($marker);
    }
}
