<?php

namespace ArtisanCloud\SaaSPolymer\Services\ArtisanService\src\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Artisan extends Authenticatable
{
    use Notifiable;

    const TABLE_NAME = 'artisans';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // Disable Laravel's mass assignment protection
    protected $guarded = [];



}
