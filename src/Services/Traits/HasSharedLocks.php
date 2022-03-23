<?php

namespace Latus\BasePlugin\Services\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Latus\Permissions\Models\User;

trait HasSharedLocks
{
    protected string $latusModelLocksCacheKey = 'latus::model-locks';

    protected function getModelCacheKey(Model $model): string
    {
        return $this->latusModelLocksCacheKey . '::' . get_class($model) . '::' . $model->id;
    }

    public function attemptLock(Model $model, int $seconds = 90, User $user = null): bool
    {
        if ($this->hasLock($model)) {
            return false;
        }

        $this->lock($model, $seconds, $user);

        return true;
    }

    public function lock(Model $model, int $seconds = 90, User $user = null)
    {
        $user = $user ?? auth()->user() ?? null;

        Cache::put($this->getModelCacheKey($model), ['user_id' => $user?->id]);
    }

    public function hasLock(Model $model): bool
    {
        return Cache::has($this->getModelCacheKey($model));
    }

    public function unlock(Model $model)
    {
        if ($this->hasLock($model)) {
            Cache::delete($this->getModelCacheKey($model));
        }
    }

    public function getBlockingUser(Model $model): int|false
    {
        return $this->hasLock($model) ? (int)(Cache::get($this->getModelCacheKey($model))['user_id']) : false;
    }
}