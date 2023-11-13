<?php

namespace Arandu\LaravelSiteOptions;

use Arandu\LaravelSiteOptions\Support\Serialize;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Option extends Model
{
    protected $fillable = ['key'];

    /**
     * Get the table associated with the model.
     * 
     * @return string 
     */
    public function getTable()
    {
        return config('site-options.table', 'site_options');
    }

    /**
     * Accessor function to get the value of the option.
     *
     * @param string $value
     *
     * @return mixed
     */
    public function getValueAttribute($value)
    {
        
        return Serialize::maybeDecode($value);
    }

    /**
     * Mutator function to set the value of the option.
     *
     * @param mixed $value
     */
    public function setValueAttribute($value)
    {
        $this->attributes['value'] = Serialize::maybeEncode($value);
    }

    /**
     * Get the value of an option
     *
     * @param mixed $key     Option name
     * @param bool  $default Default value if option is not found
     *
     * @return mixed Option value
     */
    public static function get($key, $default = null)
    {
        $exists = self::has($key);

        $getOption = function () use ($key, $default, $exists) {
            if (!$exists) {
                if (is_null($default) && config('site-options.hard_defaults.'.$key, false)) {
                    return config('site-options.hard_defaults.'.$key);
                }
                return $default;
            }

            $option = self::where('key', $key)->first();

            return $option->value;
        };

        $cacheKey = config('site-options.cache.key', 'site_options').':'.$key;

        if (config('site-options.cache.enabled', true) && $exists) {
            return Cache::remember(
                $cacheKey,
                config('site-options.cache.ttl', 60 * 24 * 7),
                $getOption
            );
        }

        return $getOption();
    }

    /**
     * Check if an option exists
     *
     * @param mixed $key   Option name
     *
     * @return bool
     */
    public static function has($key)
    {
        return self::query()->where('key', $key)->exists();
    }

    /**
     * Set the value of an option
     *
     * @param mixed $key   Option name
     * @param mixed $value Option value
     */
    public static function set($key, $value)
    {
        $findOption = self::where('key', $key)->first();
        $option = $findOption ?: new self([
            'key' => $key,
        ]);
        $option->value = $value;
        $option->save();

        if (config('site-options.cache.enabled', true)) {
            Cache::put(
                config('site-options.cache.key', 'site_options').':'.$key,
                $value,
                config('site-options.cache.ttl', 60 * 24 * 7)
            );
        }
    }

    /**
     * Remove an option
     *
     * @param mixed $key Option name
     */
    public static function rm($key)
    {
        $findOption = self::where('key', $key)->first();
        if (!$findOption) {
            return;
        }
        $findOption->delete();

        if (config('site-options.cache.enabled', true)) {
            Cache::forget(config('site-options.cache.key', 'site_options').':'.$key);
        }
    }
}