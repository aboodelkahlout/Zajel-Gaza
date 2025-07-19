<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminSetting extends Model
{
    //
    protected $fillable = [
        'site_name',
        'site_description',
        'site_language',
        'site_timezone',
        'admin_username',
        'admin_email',
        'contact_email',
        'contact_phone',
        'contact_address',
        'contact_facebook',
        'contact_twitter',
        'contact_instagram',
    ];

}
