<?php

namespace Latus\BasePlugin\Models\Contracts;

interface SanitizedModel
{
    public function getUnsafeAttribute(string $key);

    public function getSafeAttributes(): array;

    public function getAttribute($key);

    public function toArray(): array;
}