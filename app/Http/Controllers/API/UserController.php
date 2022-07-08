<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json([
                $validator->errors()
            ], 400);
        }

        $encrypted = Hash::make($request->password);
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => $encrypted,
        ]);

        if ($user) {
            return response()->json([
                'message' => 'success',
                'data' => $user,
            ]);
        } else {
            return response()->json([
                'message' => 'field',
            ]);
        }
    }
    
    public function login(Request $request)
    {
        try {
            $user = DB::table('users')->where('email', $request->email)->first();
            if (Hash::check($request->password, $user->password)) {
                return response()->json([
                    'message' => 'data falid',
                    'data' => $user,
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Password salah'
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'username atau password salah'
            ], 200);
        }
    }
}
