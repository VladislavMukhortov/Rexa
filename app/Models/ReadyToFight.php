<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ReadyToFight extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'player_one_id',
        'player_two_id',
        'player_one_cards',
        'player_two_cards',
        'coin',
        'balance_type',
        'bet',
        'status',
    ];
    /**
     * Связь с таблицей profiles
     *
     * @return BelongsTo
     */
    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class, 'client_id', 'client_id');
    }
}
