<?php

namespace Arandu\LaravelSiteOptions\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Option extends Model
{
    protected $fillable = [
        'key',
        'value',
    ];

    public function getTable()
    {
        return config('site-options.table', 'site_options');
    }

    /**
     * Função `mutator` para retornar o valor da opção.
     *
     * @param string $value
     *
     * @return mixed
     */
    public function getValueAttribute($value)
    {
        return maybe_unserialize($value);
    }

    /**
     * Função `mutator` para setar o valor da opção.
     *
     * @param mixed $value
     */
    public function setValueAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['value'] = serialize($value);

            return;
        }
        $this->attributes['value'] = $value;
    }

    /**
     * Obtém uma opção no banco de dados
     *
     * @param mixed $key     O nome da opção
     * @param bool  $default O valor que será retornado, caso a opção não exista
     *
     * @return mixed O valor da opção
     */
    public static function get($key, $default = false)
    {
        $getOption = function () use ($key, $default) {
            $option = self::where('key', $key)->first();

            if (!$option) {
                return $default;
            }

            return $option->value;
        };

        if (config('site-options.cache.enabled', true)) {
            return Cache::remember(
                config('site-options.cache.key', 'site_options').':'.$key,
                config('site-options.cache.ttl', 60 * 24 * 7),
                $getOption
            );
        }

        return $getOption();
    }

    /**
     * Verifica se uma opção existe
     *
     * @param mixed $key O nome da opção
     *
     * @return bool
     */
    public static function has($key)
    {
        if (config('site-options.cache.enabled', true)) {
            return Cache::has(config('site-options.cache.key', 'site_options').':'.$key);
        }
        return (bool) self::where('key', $key)->first();
    }

    /**
     * Escreve o valor de uma opção
     *
     * @param mixed $key   O nome da opção
     * @param mixed $value O valor da opção
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
     * Remove uma opção do banco, se existir
     *
     * @param mixed $key O nome da opção
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