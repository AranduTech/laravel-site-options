<?php

if (!function_exists('is_unserializable')) {
    /**
     * function is_unserializable
     *
     * @param mixed $data
     *
     * @return bool
     */
    function is_unserializable(mixed $data): bool
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
}

if (!function_exists('try_unserialize')) {
    /**
     * function try_unserialize
     *
     * @param mixed $data
     * @param mixed $defaultOnFail
     * @param null|\Closure $catcher
     *
     * @return mixed
     */
    function try_unserialize(
        mixed $data,
        mixed $defaultOnFail = null,
        ?\Closure $catcher = null
    ): mixed {
        try {
            if (!is_unserializable($data)) {
                return $defaultOnFail;
            }

            return unserialize($data);
        } catch (\Throwable $th) {
            if ($catcher) {
                $catcher($th);
            }

            return $defaultOnFail;
        }
    }
}
