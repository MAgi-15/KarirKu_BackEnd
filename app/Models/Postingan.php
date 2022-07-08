<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Postingan extends Model
{
    protected $table = "postingan";

    protected $fillable = ['Id', 'username', 'kategori', 'gambar', 'judul', 'deskripsi', 'nama_pekerjaan', 'kualifikasi', 'kelengkapan_berkas', 'cara_daftar'];
}