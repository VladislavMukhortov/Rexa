<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FightStatistic extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'client_id',
        'enemy_id',
        'winner_id',
        'bet',
        'profit',
        'status',
        'duration',
    ];
}
