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
    function getDetailWisata(Request $request)
    {
        $user = DB::table('wisata')->where('id', $request->id_wisata)->get();
        return response()->json([
            'success' => true,
            'message' => 'Data Showw',
            'data' => $user,
        ]);
    }
    function listCommentById(Request $request)
    {
        $data = DB::select("select c.*, u.name from comment c, users u where c.id_user=u.id and c.id_wisata = '$request->id_wisata'");
        return response()->json([
            'success' => true,
            'message' => 'Data Showw',
            'data' => $data,
        ]);
    }
    function addCommentById(Request $request) {
        $data = [
            'uid' => rand(000,999),
            'id_wisata' => $request->id_wisata,
            'comment' => $request->comment,
            'id_user' => $request->id_user,
            'created_at' => now(),
        ];
        DB::table('comment')->insert($data);
        return response()->json([
            'success' => true,
            'message' => 'Insert Data',
            'data' => $data,
        ]);
    }
}
