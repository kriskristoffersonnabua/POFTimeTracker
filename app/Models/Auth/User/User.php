<?php

namespace App\Models\Auth\User;

use App\Models\Auth\User\Traits\Ables\Protectable;
use App\Models\Auth\User\Traits\Attributes\UserAttributes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Auth\User\Traits\Ables\Rolable;
use App\Models\Auth\User\Traits\Scopes\UserScopes;
use App\Models\Auth\User\Traits\Relations\UserRelations;
use Kyslik\ColumnSortable\Sortable;
use Laravel\Passport\HasApiTokens;

use Carbon\Carbon;

/**
 * App\Models\Auth\User\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property bool $active
 * @property string $confirmation_code
 * @property bool $confirmed
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property \Carbon\Carbon $last_login
 * @property-read mixed $avatar
 * @property-read mixed $licensee_name
 * @property-read mixed $licensee_number
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Protection\ProtectionShopToken[] $protectionShopTokens
 * @property-read \App\Models\Protection\ProtectionValidation $protectionValidation
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Auth\User\SocialAccount[] $providers
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Auth\Role\Role[] $roles
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Auth\User\User sortable($defaultSortParameters = null)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Auth\User\User whereActive($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Auth\User\User whereConfirmationCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Auth\User\User whereConfirmed($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Auth\User\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Auth\User\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Auth\User\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Auth\User\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Auth\User\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Auth\User\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Auth\User\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Auth\User\User whereRole($role)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Auth\User\User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Rolable,
        UserAttributes,
        UserScopes,
        UserRelations,
        Notifiable,
        SoftDeletes,
        Sortable,
        Protectable,
        HasApiTokens;

    public $sortable = ['name', 'email', 'created_at', 'updated_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['first_name', 'last_name', 'email', 'password', 'active', 'confirmation_code', 'confirmed', 'email_verified_at', 'employee_no'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'last_login'];

    /**
     * Parse the created at field which can optionally have a millisecond data.
     *
     * @param  string  $created_at
     * @return Carbon::Object
     */
    public function getCreatedAtAttribute($created_at)
    {
            // Try to remove substring after last dot(.), removes milliseconds
            $temp = explode('.', $created_at);

            // If created_at had milliseconds the array count would be 2
            if(count($temp) == 2) {
                unset($temp[count($temp) - 1]); // remove the millisecond part
            } else {
                $temp = [$created_at]; // created_at didnt have milliseconds set it back to original
            }

            return Carbon::parse(implode('.', $temp))->format('Y-m-d H:i:s');
    }

    /**
     * Parse the created at field which can optionally have a millisecond data.
     *
     * @param  string  $created_at
     * @return Carbon::Object
     */
    public function getUpdatedAtAttribute($created_at)
    {
            // Try to remove substring after last dot(.), removes milliseconds
            $temp = explode('.', $created_at);

            // If created_at had milliseconds the array count would be 2
            if(count($temp) == 2) {
                unset($temp[count($temp) - 1]); // remove the millisecond part
            } else {
                $temp = [$created_at]; // created_at didnt have milliseconds set it back to original
            }

            return Carbon::parse(implode('.', $temp))->format('Y-m-d H:i:s');
    }
}
