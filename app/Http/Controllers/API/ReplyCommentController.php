<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Notifikasi;
use App\Models\ReplyComment;
use App\Models\User;
use Illuminate\Http\Request;

class ReplyCommentController extends Controller
{
    public function getReplyCommentbyId($id_comment)
    {
        $replycomment = ReplyComment::where('id_comment', $id_comment)->get();
        if ($replycomment) {
            return response()->json([
                'message' => 'success balas',
                'data' => $replycomment,
            ]);
        } else {
            return response()->json([
                'message' => 'field',
            ]);
        }
    }
    public function createReplyComment(Request $request)
    {
        $validated = $request->validate([
            'id_comment' => ['required'],
            'username' => ['string', 'required', 'max:255'],
            'comment' => ['string', 'required', 'max:255'],
        ]);

        $replycomment = ReplyComment::create([
            'id_comment' => $validated['id_comment'],
            'username' => $validated['username'],
            'comment' => $validated['comment'],
        ]);

        if ($replycomment) {
            //untuk notifikasi comment
            // 1. ambil data users ditaruh dalam satu variable
            $alluser = User::get();
            // 2. variable user tersebut looping menggunakan forech

            foreach ($alluser as $key => $value) {
                if ($value->username == $request->username_comment) {
                    // 3. tiap loopingan dia insert parameter id_user  dan username
                    $notif = new Notifikasi;
                    $notif->username_notifikasi = $request->username;
                    $notif->id_postingan = 0;
                    $notif->id_comment = $request->id_comment;
                    $notif->id_user = $value->id_user;
                    $notif->username = $value->username;
                    $notif->notifikasi = $request->username . ', membalas komentar anda';
                    $notif->save();

                    $post_data = [
                        "token"=> $value->token,
                        "message"=> $request->username . ', membalas komentar anda'
                    ];
                    $Notif = new NotificationController;
                    $Notif->sendNotification($post_data);
                }
            }
            
            return response()->json([
                'message' => 'success',
                'data' => $replycomment,
            ]);
        } else {
            return response()->json([
                'message' => 'field',
            ]);
        }
    }
    public function deletReplyCommentbyId($id_replycomment)
    {
        $deletReplyComment = ReplyComment::where('id_replycomment', $id_replycomment);
        $deletReplyComment->delete();
        return response()->json([
            'message' => 'success delete',
            'data' => $deletReplyComment,
        ], 200);
    }
}
