<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReplyComment extends Model
{
    protected $table = "reply_comment";

    protected $fillable = ['id_comment', 'username', 'comment'];
}
