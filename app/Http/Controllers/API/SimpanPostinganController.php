<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DataSimpan;
use App\Models\Simpan;
use Illuminate\Http\Request;

class SimpanPostinganController extends Controller
{
    public function getSimpanbyId($username)
    {
        $simpan = DataSimpan::where('username', $username)->get();
        return $simpan;
        if ($simpan) {
            return response()->json([
                'message' => 'success save',
                'data' => $simpan,
            ]);
        } else {
            return response()->json([
                'message' => 'field',
            ]);
        }
    }
    
    public function createSimpan(Request $request)
    {
        //1. cek ke database datanya ada atau ngga di table simpan
        $simpan = Simpan::where('id_postingan', $request->id_postingan)->where('username', $request->username)->first();

        //2. jika datanya ada/data listnya tidak 0, maka melakukan proses delete
        if ($simpan) {
            $deleted = Simpan::where('id_postingan', $request->id_postingan)->where('username', $request->username)->delete();
            return response()->json([
                'message' => 'success unsave',
                'data' => $deleted
            ]);
        }
        //3. jika data yang datanya tidak tersedia maka dia melanjutkan proses create/post simpan
        else {
            $validated = $request->validate([
                'id_postingan' => ['required'],
                'username' => ['string', 'required', 'max:255'],
            ]);

            $simpan = Simpan::create([
                'id_postingan' => $validated['id_postingan'],
                'username' => $validated['username'],
            ]);
            if ($simpan) {
                return response()->json([
                    'message' => 'success save',
                    'data' => $simpan,
                ]);
            } else {
                return response()->json([
                    'message' => 'error',
                ]);
            }
        }
    }
    // public function getSimpanbyUsername($user)
    // {
    //     $simpan = DataSimpan::join('users as u', 'simpan_postingan.username', 'u.username')
    //     ->where('u.username', $user)
    //     ->distinct()
    //     ->select(
    //         'simpan_postingan.id_postingan'
    //     )
    //     ->get();
    //     return response()->json([
    //         'message' => 'success save',
    //         'data' => $simpan,
    //     ]);
    // }
}
