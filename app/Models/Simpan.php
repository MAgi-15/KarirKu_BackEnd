<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Simpan extends Model
{
    protected $table = "simpan_postingan";

    protected $fillable = ['id_simpan', 'id_postingan', 'username', 'created_at', 'updated_at'];
}