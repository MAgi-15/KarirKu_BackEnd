<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataSimpan extends Model
{
    protected $table = "data_simpan";

    protected $fillable = ['id_simpan', 'id_postingan', 'username', 'kategori', 'gambar', 'judul', 'deskripsi', 'nama_pekerjaan', 'kualifikasi', 'kelengkapan_berkas', 'cara_daftar', 'jumlah_like', 'jumlah_comment'];
}