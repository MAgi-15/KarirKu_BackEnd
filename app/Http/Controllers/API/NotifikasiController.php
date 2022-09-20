<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;

class NotifikasiController extends Controller
{
    public function readNotifikasi($id_user)
    {

        $notif = Notifikasi::where('id_user', $id_user)->get();
        if ($notif) {
            return response()->json([
                'message' => 'notifikasi masuk',
                'data' => $notif
            ]);
        }
    }
}