<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Postingan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UploadPostinganController extends Controller
{
    public function readPostingan()
    {
        return response()->json([
            'message' => 'success',
            'data' => Postingan::all()
        ], 200);
    }
    public function newPostingan(Request $request)
    {
        //mengubah image dalam bentuk base64
        $base64_image = $request->Gambar;
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
            'kategori'=> $request->kategori,
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
    public function getPostinganbyUser($username)
    {
        $postingan = Postingan::where('username', $username)->get();
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
}
