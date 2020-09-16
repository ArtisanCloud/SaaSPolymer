<?php
declare(strict_types=1);

namespace ArtisanCloud\SaaSPolymer\Services\ArtisanService\src\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class Artisan extends Authenticatable
{
    use Notifiable, HasFactory;

    const STATUS_INIT = 0;          // init
    const STATUS_NORMAL = 1;        // normal
    const STATUS_INVALID = 4;       // deleted

    const TEST_MOBILE = '18616325540';

    const TABLE_NAME = 'artisans';

    protected $connection = 'pgsql';
    
    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    public $incrementing = false;

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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string)Str::uuid();
        });
    }



    /**--------------------------------------------------------------- relation functions  -------------------------------------------------------------*/

    /**
     * Get the artisan's users.
     *
     * @return HasMany
     *
     */
    public function users()
    {
        return $this->hasMany(User::class, 'artisan_uuid');
    }


}
