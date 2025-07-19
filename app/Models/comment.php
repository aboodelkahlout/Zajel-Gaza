<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class comment extends Model
{
    //
    protected $fillable = [
        'user_id',
        'hotel_id',
        'comment',
    ];


    public function user()
{
    return $this->belongsTo(User::class);
}

public function hotel()
{
    return $this->belongsTo(Hotel::class);
}

public function reply()
{
    return $this->hasMany(CommentReply::class);
}


}
