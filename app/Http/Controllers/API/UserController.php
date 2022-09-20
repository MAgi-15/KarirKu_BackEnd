<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Postingan;
use App\Models\Simpan;
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
                $update = User::where('email', $request->email)
                    ->update([
                        "token" => $request->token
                    ]);
                // $update->token = $request->token;
                // $update->save();
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
                'message' => 'email atau password salah'
            ], 200);
        }
    }

    public function editUserbyId(Request $request, $id_user)
    {
        $editUser = User::where('id_user', $id_user)
            ->first();
        $edit_comment = Comment::where('username', $editUser->username)
            ->update([
                'username' => $request->username
            ]);
        $edit_postingan = Postingan::where('username', $editUser->username)
            ->update([
                'username' => $request->username
            ]);
        $edit_likePostingan = Like::where('username', $editUser->username)
            ->update([
                'username' => $request->username
            ]);
        $edit_simpanPostingan = Simpan::where('username', $editUser->username)
            ->update([
                'username' => $request->username
            ]);
        //untuk auto reload
        $updateUser = User::where('id_user', $id_user);
        $updateUser->update([
            'username' => $request->username,
            'email' => $request->email,
        ]);
        if ($updateUser) {
            $user = DB::table('users')->where('id_user', $id_user)->first();
            return response()->json([
                'message' => 'data falid',
                'data' => $user,
            ], 200);
        } else {
            # code...
        }

        return response()->json([
            'message' => 'success',
            'data' => $updateUser,
        ], 200);
    }
}
