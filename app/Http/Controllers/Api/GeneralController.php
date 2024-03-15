<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GeneralController extends Controller
{
    function getWisata()
    {
        $data = DB::select("SELECT w.*, (SELECT (sum(r.rate) / COUNT(r.id)) from rate r WHERE r.id_wisata=w.id) as rate FROM wisata w ORDER BY rate DESC");
        return response()->json([
            'success' => true,
            'message' => 'Data Showw',
            'data' => $data,
        ]);
    }
    function getDetailWisata(Request $request)
    {
        $data = DB::select("SELECT w.*, (SELECT (sum(r.rate) / COUNT(r.id)) from rate r WHERE r.id_wisata=w.id) as rate FROM wisata w WHERE w.id = '$request->id_wisata'");
        return response()->json([
            'success' => true,
            'message' => 'Data Showw',
            'data' => $data,
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
    function addCommentById(Request $request)
    {
        $data = [
            'uid' => rand(000, 999),
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
    function rate(Request $request)
    {
        $cekRate = DB::table('rate')->where('id_user', $request->id_user)->where('id_wisata', $request->id_wisata)->first();
        if ($cekRate == null) {
            $data = [
                'id_user' => $request->id_user,
                'id_wisata' => $request->id_wisata,
                'rate' => $request->rate,
                'created_at' => now(),
            ];
            DB::table('rate')->insert($data);
            return response()->json([
                'success' => true,
                'message' => 'Insert Data',
                'data' => $data,
            ]);
        } else {
            $data = [
                'id_user' => $request->id_user,
                'id_wisata' => $request->id_wisata,
                'rate' => $request->rate,
                'created_at' => now(),
            ];
            DB::table('rate')->where('id_user', $request->id_user)->where('id_wisata', $request->id_wisata)->update($data);
            return response()->json([
                'success' => true,
                'message' => 'Update Data',
                'data' => $data,
            ]);
        }
    }
}
