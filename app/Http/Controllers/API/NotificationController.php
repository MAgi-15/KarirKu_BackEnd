<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DataSimpan;
use App\Models\Simpan;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

public function sendNotification($request)
    {
        // $firebaseToken = "ehGvNXbRSqut7wV4USo5i2:APA91bHKEx7sk_hlLrodQEop18_IqAYFkmbg2zJZCGn96qNbKfAKO-4mI-NvKwHO4UNiARuWpMTFm8mN_LwdCkiSweaF1in9He-nV68OkZiwalOz64Qp3GeCcyFCpofFHLYgN9VDNAhs";
          
        $firebaseToken = $request["token"];
        $SERVER_API_KEY = 'AAAAeulphnk:APA91bFnA39S5gW2oaON4hco9hA0yL7bPyJanW-Qf0kh_CHcymCiFDJBh_IYmYfbzMVZy2cFiQ7KLZz6SCqfM6v0hOQWfK6CMcV4UJ81OrQvOVp4rCPVYKuWIiHlfrPPbKw-AJQHnO5D';
  
        $data = [
            "to" => $firebaseToken,
            "notification" => [
                "title" => "KarirKu",
                "body" => $request["message"]
            ]
        ];
        $dataString = json_encode($data);
    
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
               
        $response = curl_exec($ch);
        $res=json_decode($response, true);

        // return response()->json([
        //     'message' => 'notifikasi masuk',
        //     'data' => $res
        // ]);
    }
}