<?php
declare(strict_types=1);

namespace ArtisanCloud\SaaSPolymer\Services\ArtisanService\src\Models;

use App\Models\User;
use ArtisanCloud\SaaSFramework\Exceptions\BaseException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;
use League\OAuth2\Server\Exception\OAuthServerException;

class Artisan extends Authenticatable
{
    use HasApiTokens, Notifiable, HasFactory;

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
        'name',
        'short_name',
        'mobile',
        'email',
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


    /**--------------------------------------------------------------- passport functions  -------------------------------------------------------------*/

    /**
     * Find the user instance for the given username.
     *
     * @param string $username
     *
     * @return \App\Models\User
     */
    public function findForPassport($username)
    {
//        $artisan = Artisan::whereMobile($username)->first();
        $artisan = Artisan::where('mobile', $username)->first();
//        dd($artisan);
        if (!$artisan) {
            throw new BaseException(API_ERR_CODE_USER_UNREGISTER);
        }
        return $artisan;
    }

    /**
     * Validate the password of the user for the Passport password grant.
     *
     * @param string $password
     *
     * @return bool
     */
    public function validateForPassportPasswordGrant($password)
    {
//        dd($this);
        $strLoginPassword = $password;
//        dd($this->password, $strLoginPassword);

        $bResult = \Hash::check($strLoginPassword, $this->password);

        if (!$bResult) {
            throw new BaseException(API_ERR_CODE_ACCOUNT_PASSWORD_INCORRECT);
        }

        return $bResult;
    }


}
