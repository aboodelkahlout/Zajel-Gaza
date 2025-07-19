<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class hotel extends Model
{
    //
    protected $fillable = [
        'hotel_owner_id', 'name', 'description', 'room_types',
        'phone_number', 'status','adress','room_count',
        'price_per_night', 'whatsapp', 'instagram', 'facebook','cover_image'
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'hotel_owner_id');
    }

    public function images()
    {
        return $this->hasMany(HotelImage::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function comments()
    {
    return $this->hasMany(Comment::class);
    }

}
