<?php

namespace Latus\BasePlugin\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

abstract class IndexService
{
    abstract protected function getBaseService();

    public function paginate(int $amount, \Closure $authorize = null, \Closure $each = null, Collection $items = null): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        if (!$items) {
            $items = $this->getBaseService()->all();
        }

        if ($authorize) {
            $items = $items->filter($authorize);
        }

        if (!$each) {
            return new LengthAwarePaginator($items->values()->forPage(request()->query('page', 1), 15), $items->count(), $amount);
        }

        $finalItems = collect();

        foreach ($items as $item) {
            $finalItems[] = $each($item);
        }

        return new LengthAwarePaginator($finalItems->values()->forPage(request()->query('page', 1), 15), $items->count(), $amount);
    }
}