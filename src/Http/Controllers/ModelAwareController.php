<?php

namespace Latus\BasePlugin\Http\Controllers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Latus\BasePlugin\Services\IndexService;
use Latus\BasePlugin\UI\Widgets\AdminNav;
use Latus\UI\Services\ComponentService;
use Latus\BasePlugin\Exceptions\ModelHasHardRelationshipsException;
use Latus\BasePlugin\Services\RelationAwareService as Service;

abstract class ModelAwareController extends AdminController
{
    public function __construct()
    {
        parent::__construct(app(ComponentService::class), app(AdminNav::class));
        $this->authorizeResource($this->modelClass, $this->routeParameterName);
    }

    protected array $viewDefinitions = [];

    protected string $modelName = '';

    protected string $routeParameterName = '';

    protected string $modelClass = '';

    protected string $modelForRelationsName = '';

    abstract protected function getService(): Service;

    abstract protected function getIndexService(): IndexService;

    protected function findViewDefinitionOrFail(string $action): array
    {
        if (!(isset($this->viewDefinitions[$action]) && isset($this->viewDefinitions[$action]['view']))) {
            abort(404);
        }

        return $this->viewDefinitions[$action];
    }

    public function _index(int $perPage, \Closure $authorize = null, \Closure $each = null, Collection $items = null, array $with = []): View|JsonResponse
    {
        $viewDefinition = $this->findViewDefinitionOrFail('index');

        $paginator = $this->getIndexService()->paginate($perPage, $authorize, $each, $items);

        if (request()->wantsJson()) {
            return response()->latusSuccess(data: [
                    'items' => $paginator->items(),
                    'current_page' => $paginator->currentPage(),
                    'last_page' => $paginator->lastPage(),
                    'total_count' => $paginator->total(),
                    'per_page' => $paginator->perPage(),
                    'page_count' => count($paginator->items())
                ] + $with);
        }

        return $this->returnView(view($viewDefinition['view'])->with(['paginator' => $paginator] + $with), $viewDefinition['reference'] ?? '');
    }

    public function _create(array $with = []): View
    {
        $viewDefinition = $this->findViewDefinitionOrFail('create');

        return $this->returnView(view($viewDefinition['view'])->with($with), $viewDefinition['reference'] ?? '');
    }

    public function _edit(mixed $model, array $with = []): View
    {
        $viewDefinition = $this->findViewDefinitionOrFail('edit');

        return $this->returnView(view($viewDefinition['view'])->with([$this->modelName => $model] + $with), $viewDefinition['reference'] ?? '');
    }

    public function _show(mixed $model, array $with = []): View
    {
        $viewDefinition = $this->findViewDefinitionOrFail('show');

        return $this->returnView(view($viewDefinition['view'])->with([$this->modelName => $model] + $with), $viewDefinition['reference'] ?? '');
    }

    public function _showJson(mixed $model, array $withJson = []): JsonResponse
    {
        $this->authorize('view', $model);

        $data = $this->getService()->toArray($model);

        if (($with = request()->input('with'))) {
            $data['relationships'] = $this->getService()->getRelationships($model, $with)->toArray();
        }

        return response()->latusSuccess(data: $data + $withJson);
    }

    public function _paginate(int $perPage, \Closure $authorize = null, \Closure $each = null, Collection $items = null, array $with = []): JsonResponse
    {
        $this->authorize('viewAny', $this->modelClass);

        $paginator = $this->getIndexService()->paginate($perPage, $authorize, $each, $items);

        $paginatorData = [
            'items' => $paginator->items(),
            'current_page' => $paginator->currentPage(),
            'last_page' => $paginator->lastPage(),
            'total_count' => $paginator->total(),
            'per_page' => $paginator->perPage(),
            'page_count' => count($paginator->items())
        ];

        $data = ['paginator' => $paginatorData] + $with;

        return \response()->latusSuccess(data: $data);
    }

    public function _store(FormRequest $request): JsonResponse
    {
        $validatedInput = $request->validated();

        try {
            $model = $this->getService()->create($validatedInput);
        } catch (\InvalidArgumentException $e) {
            return response()->latusFailed(status: 422, message: 'The given data was invalid.', data: ['errors' => json_decode($e->getMessage(), true)]);
        }

        return response()->latusSuccess(message: $this->modelName . ' created', data: $this->getService()->toArray($model));
    }

    public function _update(mixed $model, FormRequest $request): JsonResponse
    {
        $validatedInput = $request->validated();

        try {
            $this->getService()->update($model, $validatedInput);
        } catch (\InvalidArgumentException) {
            return response()->latusFailed(status: 400, message: $this->modelName . '-service attribute validation failed');
        }

        return response()->latusSuccess(message: $this->modelName . ' updated', data: $this->getService()->toArray($model));
    }

    public function _destroy(mixed $model): JsonResponse
    {
        try {
            $this->getService()->delete($model);
        } catch (ModelHasHardRelationshipsException $e) {
            $relations = [];
            $searchQuery = [
                'w' => [
                    $this->modelForRelationsName => [
                        'where' => [
                            'id' => [
                                'value' => $model->id
                            ]
                        ]
                    ]
                ]
            ];

            foreach ($e->relationships->keys()->toArray() as $relationName) {
                $relations[] = [
                    'label' => __('lh::models.' . $relationName),
                    'search_url' => route($relationName . '.index') . '/?search=' . json_encode($searchQuery),
                ];
            }

            return response()->latusFailed(status: 423, data: ['gated_by' =>
                [
                    'type' => 'relations',
                    'relations' => $relations
                ]
            ]);
        }

        return response()->latusSuccess(message: $this->modelName . ' deleted');
    }
}