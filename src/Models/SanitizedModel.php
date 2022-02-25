<?php

namespace Latus\BasePlugin\Models;

use Illuminate\Database\Eloquent\Model;
use Latus\BasePlugin\Models\Traits\SanitizesData;

abstract class SanitizedModel extends Model implements Contracts\SanitizedModel
{
    use SanitizesData;

    public function getUnsafeAttribute(string $key)
    {
        return parent::getAttribute($key);
    }

    public function getAttribute($key)
    {
        if (in_array($key, $this->getSafeAttributes())) {
            return $this->getUnsafeAttribute($key);
        }

        return $this->sanitize($this->getUnsafeAttribute($key));
    }

    public function toArray(): array
    {
        $unsafeArray = parent::toArray();

        $safeArray = [];

        foreach ($unsafeArray as $key => $value) {
            if (in_array($key, $this->getSafeAttributes())) {
                $safeArray[$key] = $value;
                continue;
            }

            $safeArray[$key] = $this->sanitize($value);
        }

        return $safeArray;
    }

    public function getSafeAttributes(): array
    {
        return ['id'];
    }
}