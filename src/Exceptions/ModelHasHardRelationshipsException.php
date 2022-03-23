<?php

namespace Latus\BasePlugin\Exceptions;


use Illuminate\Support\Collection;

class ModelHasHardRelationshipsException extends \RuntimeException
{
    /**
     * The name of the affected Eloquent model.
     *
     * @var string $modelClass
     */
    public string $modelClass;

    /**
     * The affected Eloquent model.
     *
     * @var mixed $model
     */
    public mixed $model;

    /**
     * The name of the relation.
     *
     * @var Collection $relationships
     */
    public Collection $relationships;

    /**
     * Create a new exception instance.
     *
     * @param object $model
     * @param Collection $relationships
     * @return static
     */
    public static function make(mixed $model, Collection $relationships, string $action): static
    {
        $class = get_class($model);

        $instance = new static("Call to action [{$action}] on gated model [{$class}:{$model->id}] failed, because of existing hard-relations to other models.");

        $instance->modelClass = $class;
        $instance->model = $model;
        $instance->relationships = $relationships;

        return $instance;
    }
}