<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friend extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'accept_client_id',
        'apply_client_id',
    ];
}
