<?php

namespace App\Http\Controllers\Api;

use Redirect;
use App\Group;
use App\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\FacialRecognition;

class CameraController extends Controller
{
    public function store(Request $request)
    {
        return (new FacialRecognition($request->image))
            ->makePrediction();
    }

    public function destroy()
    {
        return FacialRecognition::cleanupTempDirectory();
    }
}
