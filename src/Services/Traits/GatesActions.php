<?php

namespace Latus\BasePlugin\Services\Traits;

use Illuminate\Support\Collection;
use Latus\Baseplugin\Exceptions\ModelHasHardRelationshipsException;

trait GatesActions
{
    use ExposesRelationships;

    protected Collection $fetchedHardRelationships;

    public abstract function getHardRelationshipsNames(): array;

    public function getHardRelationships(mixed $model): Collection
    {
        if (!isset($this->{'fetchedHardRelationships'})) {
            $relationships = $this->getRelationships($model, $this->getHardRelationshipsNames(), false);

            $hardRelationships = collect();
            foreach ($relationships as $name => $relationship) {
                if (!$relationship || ((is_array($relationship) || $relationship instanceof \ArrayAccess) && sizeof($relationship) === 0)) {
                    continue;
                }
                $hardRelationships->put($name, $relationship);
            }
            $this->fetchedHardRelationships = $hardRelationships;
        }

        return $this->fetchedHardRelationships;
    }

    protected function failIfHardRelationsExist(mixed $model, string $action)
    {
        $relations = $this->getHardRelationships($model);
        if ($relations->isNotEmpty()) {
            throw ModelHasHardRelationshipsException::make($model, $relations, $action);
        }
    }
}