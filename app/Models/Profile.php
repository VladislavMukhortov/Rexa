<?php

namespace App\Models;

use Icekristal\LaravelInteriorMultiWallet\InteractsWithMultiWallet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Profile extends BaseModel
{
    use HasFactory, InteractsWithMultiWallet;

    protected $table = 'profiles';
    protected $fillable = [
        'client_id',
        'email',
        'nickname',
        'avatar',
        'first_name',
        'lang',
        'main_avatar_id',
    ];

    /**
     * Связь с таблицей
     * table = clients
     *
     * @return BelongsTo
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Связь друзей по таблице friends
     *
     * @return BelongsToMany
     */
    public function friends(): BelongsToMany
    {
        return $this->belongsToMany(Profile::class, 'friends', 'accept_client_id', 'apply_client_id', 'client_id', 'client_id');
    }

    /**
     * Связь статистики по таблице fight_statistics
     *
     * @return HasMany
     */
    public function fightStatistics(): HasMany
    {
        return $this->hasMany(FightStatistic::class, 'client_id', 'client_id');
    }

    public function readyToFight(): HasOne
    {
        return $this->hasOne(ReadyToFight::class, 'player_one_id', 'client_id');
    }
}
