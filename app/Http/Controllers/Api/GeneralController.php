<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

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
    function addWisata(Request $request)
    {

        $file_path = public_path() . '/storage/images/wisata/' . $request->image;
        File::delete($file_path);
        $image = $request->file('image');
        $filename = $image->getClientOriginalName();
        $image->move(public_path('storage/images/wisata/'), $filename);
        $data = [
            'nama_wisata' => $request->nama_wisata,
            'keterangan' => $request->keterangan,
            'description' => $request->description,
            'image' => $request->file('image')->getClientOriginalName(),
            'tag' => $request->tag,
            'tag1' => $request->tag1,
            'wilayah' => $request->wilayah,
            'created_at' => now(),
        ];

        DB::table('wisata')->insert($data);
        return response()->json([
            'success' => true,
            'message' => 'Add Data',
            'data' => $data,
        ]);
    }
    function updateWisata(Request $request)
    {
        if ($request->hasFile('image4')) {
            $file_path = public_path() . '/storage/images/wisata/' . $request->image1;
            File::delete($file_path);
            $image = $request->file('image1');
            $filename1 = $image->getClientOriginalName();
            $image->move(public_path('storage/images/wisata/'), $filename1);

            $file_path = public_path() . '/storage/images/wisata/' . $request->image2;
            File::delete($file_path);
            $image = $request->file('image2');
            $filename2 = $image->getClientOriginalName();
            $image->move(public_path('storage/images/wisata/'), $filename2);

            $file_path = public_path() . '/storage/images/wisata/' . $request->image3;
            File::delete($file_path);
            $image = $request->file('image3');
            $filename3 = $image->getClientOriginalName();
            $image->move(public_path('storage/images/wisata/'), $filename3);

            $file_path = public_path() . '/storage/images/wisata/' . $request->image4;
            File::delete($file_path);
            $image = $request->file('image4');
            $filename4 = $image->getClientOriginalName();
            $image->move(public_path('storage/images/wisata/'), $filename4);
            $data = [
                'nama_wisata' => $request->nama_wisata,
                'keterangan' => $request->keterangan,
                'description' => $request->description,
                'image1' => $filename1,
                'image2' => $filename2,
                'image3' => $filename3,
                'image4' => $filename4,
                'tag' => $request->tag,
                'tag1' => $request->tag1,
                'wilayah' => $request->wilayah,
                'updated_at' => now(),
            ];
        } else {
            $data = [
                'nama_wisata' => $request->nama_wisata,
                'keterangan' => $request->keterangan,
                'description' => $request->description,
                'tag' => $request->tag,
                'tag1' => $request->tag1,
                'wilayah' => $request->wilayah,
                'updated_at' => now(),
            ];
        }
        DB::table('wisata')->where('id', $request->id)->update($data);
        return response()->json([
            'success' => true,
            'message' => 'Update Data',
            'data' => $data,
        ]);
    }
    function deleteWisata(Request $request)
    {
        $getImage = DB::table('wisata')->where('id', $request->id)->first();
        $file_path1 = public_path() . '/storage/images/wisata/' . $getImage->image1;
        $file_path2 = public_path() . '/storage/images/wisata/' . $getImage->image2;
        $file_path3 = public_path() . '/storage/images/wisata/' . $getImage->image3;
        $file_path4 = public_path() . '/storage/images/wisata/' . $getImage->image4;
        File::delete($file_path1);
        File::delete($file_path2);
        File::delete($file_path3);
        File::delete($file_path4);

        DB::table('wisata')->where('id', $request->id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Delete Data'
        ]);
    }
    function deleteComment(Request $request)
    {
        DB::table('comment')->where('id', $request->id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Delete Data'
        ]);
    }
}
