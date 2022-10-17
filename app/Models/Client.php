<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\Pure;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property integer $id
 * @property integer $client_decks_count
 * @property string $uuid
 * @property string $email
 * @property string $phone
 * @property string $telegram_name
 * @property string $telegram
 * @property integer $telegram_chat_id
 * @property string $fa2
 * @property string $first_name
 * @property string $last_name
 * @property string $middle_name
 * @property string $group
 * @property string $locale
 * @property string $gender
 * @property string $about
 * @property boolean $is_banned
 * @property string $birthday
 * @property string $verified_at
 * @property string $receipt_at
 * @property string $password
 * @property string $remember_token
 * @property string $google2fa_secret
 * @property string $created_at
 * @property string $updated_at
 * @property string $nickname
 * @property string $the_code
 * @property string $is_in_play_game
 * @property string $secret_code
 * @property string $invitation_code
 * @property string $where_come_from
 * @property boolean $is_visible_data
 * @property boolean $is_terms_confirm
 * @property boolean $is_craft_start_cards
 * @property boolean $is_online
 * @property Profile $profile
 */
class Client extends Authenticatable
{
    use HasApiTokens, Notifiable, HasFactory;

    protected $connection = 'mysql_auth';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    protected $hidden = ['password'];

    /**
     * @var array
     */
    protected $fillable = ['uuid', 'email', 'phone', 'telegram_name', 'telegram',
        'telegram_chat_id', 'fa2', 'first_name', 'last_name', 'middle_name',
        'group', 'locale', 'gender', 'about', 'is_banned', 'birthday',
        'verified_at', 'receipt_at', 'password', 'remember_token',
        'is_terms_confirm', 'is_visible_data', 'nickname', 'google2fa_secret',
        'the_code', 'invitation_code', 'secret_code'];


    /**
     * Связь с таблицей
     * table = profiles
     *
     * @return HasOne
     */
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * Связь с таблицей
     * table = media
     *
     * @return HasMany
     */
    public function media(): hasMany
    {
        return $this->hasMany(Media::class, 'client_id', 'id');
    }


    /**
     * Канал для оповещения клиенту
     * @return string
     */
    public function receivesBroadcastNotificationsOn(): string
    {
        return 'client.' . $this->id;
    }

}
