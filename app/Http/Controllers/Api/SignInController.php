<?php

namespace App\Http\Controllers\Api;

use App\Marker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SignInController extends Controller
{
    public function destroy(Request $request)
    {
        $marker = Marker::find($request->input('marker'));
        $group = $marker->group;
        $marker->delete();

        if ($group->markers->count() < 1) {
            $group->delete();
        }

        return 'ok';
    }
}
