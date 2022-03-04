<?php

namespace Latus\BasePlugin\Services;

use Latus\BasePlugin\Paginators\FilterablePaginator;
use Latus\Permissions\Services\UserService as BaseUserService;

class UserService extends BaseUserService
{
    public function paginate(int $amount, \Closure $authorize = null, \Closure $each = null): FilterablePaginator
    {
        $items = $this->userRepository->all();

        if ($authorize) {
            $items = $items->filter($authorize);
        }

        if (!$each) {
            return new FilterablePaginator($items, $items->count(), $amount);
        }

        $finalItems = collect();

        foreach ($items as $item) {
            $finalItems[] = $each($item);
        }

        return new FilterablePaginator($finalItems, $items->count(), $amount);
    }
}