<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $user = User::where('email', $request->email)->first();

        // if ($user == null) {
        //     $user = User::where('nisn', $request->email)->first();
        // }
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'The provided credentials are incorrect.',
            ]);
        }
        $token = $user->createToken('authToken')->plainTextToken;
        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'token' => $token,
            'userData' => $user,
        ]);
    }
    
    function getUsers()
    {
        $user = User::where('email', request()->user()->email)->get();
        return response()->json([
            'success' => true,
            'message' => 'Data Users',
            'data' => $user,
        ]);
    }
    function register(Request $request)
    {
        // dd($request->all());
        $data = [
            'name' => Str::upper($request->name),
            'nik' => $request->nik,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 2,
            'address' => $request->address,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'nama_ortu' => $request->nama_ortu,
            'created_at' => now(),
        ];
        // dd($data);
        DB::table('users')->insert($data);
        return response()->json([
            'success' => true,
            'message' => 'register Success',
            'data' => $data,
        ]);
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Logout berhasil'
        ]);
    }
}
