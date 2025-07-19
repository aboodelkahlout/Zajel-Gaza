<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommentReply extends Model
{
    //
    protected $fillable = ['comment_id', 'reply_text','replied_by','replied_by_id'];

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }
}
