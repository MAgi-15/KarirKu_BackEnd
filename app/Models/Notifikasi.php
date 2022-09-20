<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = "notifikasi";

    protected $fillable = ['id_user', 'id_notifikasi', 'id_postingan', 'username', 'username_notifikasi', 'notifikasi', 'created_at', 'updated_at', 'deleted_at'];
}
