<?php

namespace Latus\BasePlugin\Services\Traits;

use Illuminate\Support\Collection;

trait ExposesRelationships
{
    protected abstract function relationshipAccessorCallables(): array;

    public function getRelationships(mixed $model, array $relationships, bool $authorize = true): Collection
    {
        $accessors = $this->relationshipAccessorCallables();

        $gatheredRelationships = [];

        foreach ($relationships as $relationship) {
            if (!isset($accessors[$relationship])) {
                continue;
            }

            $accessorCallable = $accessors[$relationship];

            $gatheredRelationship = $accessorCallable($model, $relationship, $authorize);

            if ($gatheredRelationship) {
                $gatheredRelationships[$relationship] = $gatheredRelationship;
            }
        }

        return collect($gatheredRelationships);
    }
}