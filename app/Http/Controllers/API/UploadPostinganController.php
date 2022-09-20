<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Postingan;
use App\Models\User;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UploadPostinganController extends Controller
{
    public function readPostingan()
    {
        return response()->json([
            'message' => 'success',
            'data' => Postingan::orderBy('id_postingan', 'desc')->get()
        ], 200);
    }
    public function newPostingan(Request $request)
    {
        // $alluser = User::get();
        // return $alluser;

        //mengubah image dalam bentuk base64
        $base64_image = $request->gambar;
        $image = base64_decode(preg_replace('#^data:image/jpeg;base64,#i', '', $base64_image));

        $image_name = "postingan-post-" . date('Y-m-d-') . md5(uniqid(rand(), true)); // image name generating with random number with 32 characters
        $filename = $image_name . '.' . 'jpg';
        //rename file name with random number
        $path = public_path('data_file/');

        //image uploading folder path
        file_put_contents($path . $filename, $image);
        $post_image = 'data_file/' . $filename;

        // $thread = Thread::create([
        //     'User' => $request->User,
        //     'Thread' => $request->Thread,
        //     'Gambar' => $post_image,
        //     'Judul' => $request->Judul,
        //     'Komunitas' => $request->Komunitas
        // ]);
        $tanggal = date('Y-m-d G:i:s');
        $postingan = DB::table('postingan')
            ->insert([
                'username' => $request->username,
                'kategori' => $request->kategori,
                'gambar' => $post_image,
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'nama_pekerjaan' => $request->nama_pekerjaan,
                'kualifikasi' => $request->kualifikasi,
                'kelengkapan_berkas' => $request->kelengkapan_berkas,
                'cara_daftar' => $request->cara_daftar,
                'created_at' => $tanggal,
                'updated_at' => $tanggal,
                'deleted_at' => $tanggal
            ]);

        if ($postingan) {
            //untuk notifikasi
            // 1. ambil data users ditaruh dalam satu variable
            $alluser = User::get();
            // 2. variable user tersebut looping menggunakan forech

            foreach ($alluser as $key => $value) {
                if ($value->id_user != $request->id_user) {
                    // 3. tiap loopingan dia insert parameter id_user  dan username
                    $notif = new Notifikasi;
                    $notif->username_notifikasi = $request->username;
                    $notif->id_user = $value->id_user;
                    $notif->username = $value->username;
                    $notif->notifikasi = $request->username . ', Baru saja membagikan postingan';
                    $notif->save();

                    $post_data = [
                        "token" => $value->token,
                        "message" => $request->username . ', Baru saja membagikan postingan'
                    ];
                    $Notif = new NotificationController;
                    $Notif->sendNotification($post_data);
                }
            }

            return response()->json([
                'message' => 'success',
                'data' => $postingan,
            ]);
        } else {
            return response()->json([
                'message' => 'field',
            ]);
        }
    }

    public function getPostinganbyUsername($Username)
    {
        $postingan = Postingan::where('username', $Username)->get();
        if ($postingan) {
            return response()->json([
                'message' => 'success',
                'data' => $postingan,
            ]);
        } else {
            return response()->json([
                'message' => 'field',
            ]);
        }
    }

    public function getPostinganbyId($id_postingan)
    {
        $postingan = Postingan::where('id_postingan', $id_postingan)->get();
        if ($postingan) {
            return response()->json([
                'message' => 'success',
                'data' => $postingan,
            ]);
        } else {
            return response()->json([
                'message' => 'field',
            ]);
        }
    }
    public function deletePostinganbyId($id_postingan)
    {
        $deletPost = Postingan::where('id_postingan', $id_postingan);
        $deletPost->delete();
        return response()->json([
            'message' => 'success',
            'data' => $deletPost,
        ], 200);
    }

    public function editPostinganbyId(Request $request, $id_postingan)
    {
        $edit_post = Postingan::where('id_postingan', $id_postingan)
        ->first();
        $post_image = $edit_post->gambar;
        if ($request->gambar != '') {
            //mengubah image dalam bentuk base64
            $base64_image = $request->gambar;
            $image = base64_decode(preg_replace('#^data:image/jpeg;base64,#i', '', $base64_image));
    
            $image_name = "postingan-post-" . date('Y-m-d-') . md5(uniqid(rand(), true)); // image name generating with random number with 32 characters
            $filename = $image_name . '.' . 'jpg';
            //rename file name with random number
            $path = public_path('data_file/');
    
            //image uploading folder path
            file_put_contents($path . $filename, $image);
            $post_image = 'data_file/' . $filename;
        } else {
            # code...
        }


        $tanggal = date('Y-m-d G:i:s');
        $editPost = Postingan::where('id_postingan', $id_postingan);
        $editPost->update([
            'kategori' => $request->kategori,
            'gambar' => $post_image,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'nama_pekerjaan' => $request->nama_pekerjaan,
            'kualifikasi' => $request->kualifikasi,
            'kelengkapan_berkas' => $request->kelengkapan_berkas,
            'cara_daftar' => $request->cara_daftar,
            'created_at' => $tanggal,
            'updated_at' => $tanggal
        ]);
        return response()->json([
            'message' => 'success',
            'data' => $editPost,
        ], 200);
    }

    public function searchPostingan($nama_pekerjaan)
    {
        return response()->json([
            'message' => 'success',
            'data' => Postingan::orderBy('id_postingan', 'desc')
                ->where('nama_pekerjaan', 'LIKE', '%' . $nama_pekerjaan . '%')
                ->get()
        ], 200);
    }
}
