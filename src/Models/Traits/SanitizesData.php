<?php

namespace Latus\BasePlugin\Models\Traits;

trait SanitizesData
{
    protected function sanitize(string|array|null $value): string|array|null
    {
        if (!$value === null) {
            return null;
        }

        if (is_array($value)) {
            return $this->sanitizeArray($value);
        }

        if (is_numeric($value) || is_null($value)) {
            return $value;
        }

        $sanitizedValue = htmlspecialchars(string: $value, flags: ENT_HTML5 | ENT_QUOTES, double_encode: false);
        $sanitizedValue = str_replace(["\r", "\n", "\r\n"], ['\\r', '\\n', '\\r\\n'], $sanitizedValue);

        return $sanitizedValue;
    }

    protected function sanitizeArray(array $array): array
    {
        $sanitizedArray = [];

        foreach ($array as $key => $value) {
            $sanitizedArray[$key] = $this->sanitize($value);
        }

        return $sanitizedArray;
    }
}