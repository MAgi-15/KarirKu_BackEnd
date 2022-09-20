<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\Notifikasi;
use App\Models\Postingan;
use App\Models\User;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function getLikebyId($id_like)
    {
        $like = Like::where('id_postingan', $id_like)->get();
        if ($like) {
            return response()->json([
                'message' => 'success like',
                'data' => $like,
            ]);
        } else {
            return response()->json([
                'message' => 'field',
            ]);
        }
    }
    public function createLike(Request $request)
    {
        //1. cek ke database datanya ada atau ngga di table like
        $like = Like::where('id_postingan', $request->id_postingan)->where('username', $request->username)->first();

        //2. jika datanya ada/data listnya tidak 0, maka melakukan proses delete
        if ($like) {
            $deleted = Like::where('id_postingan', $request->id_postingan)->where('username', $request->username)->delete();
            return response()->json([
                'message' => 'success unlike',
                'data' => $deleted
            ]);
        }
        //3. jika data yang datanya tidak tersedia maka dia melanjutkan proses create/post like
        else {
            $validated = $request->validate([
                'id_postingan' => ['required'],
                'username' => ['string', 'required', 'max:255'],
            ]);
            $datapost = Postingan::where('id_postingan', $request->id_postingan)->first();
            $like = Like::create([
                'id_postingan' => $validated['id_postingan'],
                'username' => $validated['username'],
            ]);
            if ($like) {
                //untuk notif like postingan
                $alluser = User::where('username', $datapost->username)->first();
                // 2. variable user tersebut looping menggunakan forech
                $notif = new Notifikasi;
                $notif->id_postingan = $request->id_postingan;
                $notif->id_comment = 0;
                //user yang membuat notif
                $notif->username_notifikasi = $request->username;
                $notif->id_user = $alluser->id_user;
                //user yg dpt notif (to user)
                $notif->username = $datapost->username;
                $notif->notifikasi = $request->username . ', menyukai postingan anda';
                $notif->save();

                $post_data = [
                    "token" => $alluser->token,
                    "message" => $request->username . ', menyukai postingan anda'
                ];
                $Notif = new NotificationController;
                $Notif->sendNotification($post_data);
                return response()->json([
                    'message' => 'success like',
                    'data' => $like,
                ]);
            } else {
                return response()->json([
                    'message' => 'field',
                ]);
            }
        }
    }
    public function getLikebyUsername($user)
    {
        $like = Like::join('users as u', 'like_postingan.username', 'u.username')
            ->where('u.username', $user)
            ->distinct()
            ->select(
                'like_postingan.id_postingan'
            )
            ->get();
        return response()->json([
            'message' => 'success like',
            'data' => $like,
        ]);
    }
}
