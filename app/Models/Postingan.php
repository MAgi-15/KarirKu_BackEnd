<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Postingan extends Model
{
    protected $table = "data_postingan";

    protected $fillable = ['Id_postingan', 'username', 'kategori', 'gambar', 'judul', 'deskripsi', 'nama_pekerjaan', 'kualifikasi', 'kelengkapan_berkas', 'cara_daftar', 'jumlah_comment', 'jumlah_like'];
}