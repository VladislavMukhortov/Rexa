<?php

namespace App\Traits;

use App\Models\InfoLocale;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait InfoLocaleTrait
{
    /**
     *
     * Relation с таблицей
     *
     * @return MorphOne
     *
     */
    public function locale(): MorphOne
    {
        return $this->morphOne(InfoLocale::class, 'owner')->where('lang', app()->getLocale());
    }

    /**
     * Информация про объект
     *
     * @return MorphMany
     */
    public function locales(): MorphMany
    {
        return $this->morphMany(InfoLocale::class, 'owner');
    }


    public function getActiveTextAttribute(): string
    {
        return $this->is_active ? 'Активна' : 'Заблокирован';
    }
}
