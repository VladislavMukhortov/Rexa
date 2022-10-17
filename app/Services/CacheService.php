<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class CacheService
{

    public mixed $name = null;


    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getValue()
    {
        if (Cache::has($this->name)) {
            return Cache::get($this->name);
        }
        return null;
    }

    public function setValue($value, $time = null)
    {
        try {
            Cache::put($this->name, $value, $time);
        } catch (\Exception $exception) {
            info($exception);
        }

        return $value;
    }


    public function rememberValue($value, $time = null)
    {

        try {
            $tt =  Cache::remember($this->name, $time, function () use ($value) {
                return $value;
            });
        } catch (\Exception $exception) {
            info($exception);
            $tt = $value;
        }

        return $tt;
    }

    public function deleteValue()
    {
        try {
            if (Cache::has($this->name)) {
                Cache::forget($this->name);
            }
        } catch (\Exception $exception) {
            info($exception);
        }
    }
}
