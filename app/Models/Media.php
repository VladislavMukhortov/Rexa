<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Media extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'path',
        'type',
    ];

    public const TYPES = [
        'avatar',
    ];

    /**
     * Связь с таблицей из базы данных auth
     * table = clients
     *
     * @return BelongsTo
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
