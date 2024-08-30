<?php

namespace Arandu\LaravelSiteOptions\Support;

class Serialize
{

    private static function isUnserializable(mixed $data)
    {
        $data = is_string($data) ? trim($data) : null;

        if (!$data || (strlen($data) === 2 && $data !== 'N;') || strlen($data) < 4) {
            return false;
        }

        foreach (['N;', ';', ':'] as $partial) {
            if (
                (
                    str_contains($data[1] ?? '', $partial)
                    || str_contains($data, $partial)
                ) && (
                    str_ends_with($data, ';')
                    || str_ends_with($data, '}')
                )
            ) {
                return true;
            }
        }

        return false;
    }

    /**
     * Encode the given value.
     *
     * @param mixed $value
     * @return string
     */
    public static function encode($value)
    {
        return serialize($value);
    }

    /**
     * Decode the given value.
     * @param mixed $value
     * @return mixed
     */
    public static function decode(string $data, ?\Closure $catcher = null)
    {
        try {
            $data = trim($data);

            if (!static::isUnserializable($data)) {
                return null;
            }

            return unserialize($data);
        } catch (\Throwable $th) {
            if ($catcher) {
                $catcher($th);
            }

            return null;
        }
    }

    /**
     * Check if the given value is serialized.
     * @param mixed $data
     * @param bool $strict
     * @return bool
     */
    public static function isEncoded($data, $strict = true) {
        // If it isn't a string, it isn't serialized.
        if (!is_string($data)) {
            return false;
        }
        $data = trim($data);
        if ('N;' === $data) {
            return true;
        }
        if (strlen($data) < 4) {
            return false;
        }
        if (':' !== $data[1]) {
            return false;
        }
        if ($strict) {
            $lastc = substr($data, -1);
            if (';' !== $lastc && '}' !== $lastc) {
                return false;
            }
        } else {
            $semicolon = strpos($data, ';');
            $brace     = strpos($data, '}');
            // Either ; or } must exist.
            if (false === $semicolon && false === $brace) {
                return false;
            }
            // But neither must be in the first X characters.
            if (false !== $semicolon && $semicolon < 3) {
                return false;
            }
            if (false !== $brace && $brace < 4) {
                return false;
            }
        }
        $token = $data[0];
        switch ($token) {
            case 's':
                if ($strict) {
                    if ('"' !== substr($data, -2, 1)) {
                        return false;
                    }
                } elseif (false === strpos($data, '"')) {
                    return false;
                }
                // Or else fall through.
            case 'a':
            case 'O':
                return (bool) preg_match("/^{$token}:[0-9]+:/s", $data);
            case 'b':
            case 'i':
            case 'd':
                $end = $strict ? '$' : '';
                return (bool) preg_match("/^{$token}:[0-9.E+-]+;$end/", $data);
        }
        return false;
    }

    /**
     * Maybe decode the given value. If it's not serialized, return it as-is.
     * @param mixed $data
     * @return mixed
     */
    public static function maybeDecode($data)
    {
        if (static::isEncoded($data)) {
            // don't attempt to unserialize data that wasn't serialized going in
            return static::decode($data);
        }

        return $data;
    }

    /**
     * Maybe encode the given value. If it's a string, return it as-is.
     */
    public static function maybeEncode($data)
    {
        if (is_string($data)) {
            return $data;
        }
        return static::encode($data);
    }
}
