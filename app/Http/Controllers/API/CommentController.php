<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Notifikasi;
use App\Models\Postingan;
use App\Models\User;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function getCommentbyId($id_comment)
    {
        $comment = Comment::where('id_postingan', $id_comment)->get();
        if ($comment) {
            return response()->json([
                'message' => 'success',
                'data' => $comment,
            ]);
        } else {
            return response()->json([
                'message' => 'field',
            ]);
        }
    }
    public function getCommentbyIdComment($id_comment)
    {
        $comment = Comment::where('id_comment', $id_comment)->get();
        if ($comment) {
            return response()->json([
                'message' => 'success',
                'data' => $comment,
            ]);
        } else {
            return response()->json([
                'message' => 'field',
            ]);
        }
    }
    public function createComment(Request $request)
    {
        $validated = $request->validate([
            'id_postingan' => ['required'],
            'username' => ['string', 'required', 'max:255'],
            'comment' => ['string', 'required', 'max:255'],
        ]);

        $comment = Comment::create([
            'id_postingan' => $validated['id_postingan'],
            'username' => $validated['username'],
            'comment' => $validated['comment'],
        ]);

        if ($comment) {
            //untuk notifikasi comment
            // 1. ambil data users ditaruh dalam satu variable
            $alluser = User::get();
            // 2. variable user tersebut looping menggunakan forech

            foreach ($alluser as $key => $value) {
                if ($value->username == $request->username_postingan) {
                    // 3. tiap loopingan dia insert parameter id_user  dan username
                    $notif = new Notifikasi;
                    $notif->username_notifikasi = $request->username;
                    $notif->id_comment = 0;
                    $notif->id_postingan = $request->id_postingan;
                    $notif->id_user = $value->id_user;
                    $notif->username = $value->username;
                    $notif->notifikasi = $request->username . ', mengomentari postingan anda';
                    $notif->save();

                    $post_data = [
                        "token"=> $value->token,
                        "message"=> $request->username . ', mengomentari postingan anda'
                    ];
                    $Notif = new NotificationController;
                    $Notif->sendNotification($post_data);
                }
            }

            // foreach ($alluser as $key => $value) {
            //     if ($value->username == $request->username_postingan) {
            //         // 3. tiap loopingan dia insert parameter id_user  dan username
            //         $notif = new Notifikasi;
            //         $notif->username_notifikasi = $request->username;
            //         $notif->id_comment = 0;
            //         $notif->id_postingan = $request->id_postingan;
            //         $notif->id_user = $value->id_user;
            //         $notif->username = $value->username;
            //         $notif->notifikasi = $request->username . ', Baru saja mengomentari postingan anda';
            //         $notif->save();

            //         $post_data = [
            //             "token"=> $value->token,
            //             "message"=> $request->username . ', Baru saja mengomentari postingan anda'
            //         ];
            //         $Notif = new NotificationController;
            //         $Notif->sendNotification($post_data);
            //     }
            // }
            
            return response()->json([
                'message' => 'success',
                'data' => $comment,
            ]);
        } else {
            return response()->json([
                'message' => 'field',
            ]);
        }
    }
    public function deletCommentbyId($id_comment)
    {
        $deletComment = Comment::where('id_comment', $id_comment);
        $deletComment->delete();
        return response()->json([
            'message' => 'success delete',
            'data' => $deletComment,
        ], 200);
    }
}
