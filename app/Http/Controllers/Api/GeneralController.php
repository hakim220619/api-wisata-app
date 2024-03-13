<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GeneralController extends Controller
{
    function getWisata()
    {
        $user = DB::table('wisata')->get();
        return response()->json([
            'success' => true,
            'message' => 'Data Showw',
            'data' => $user,
        ]);
    }
}
