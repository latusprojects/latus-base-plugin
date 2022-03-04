<?php

namespace Latus\BasePlugin\Paginators;

use Illuminate\Pagination\LengthAwarePaginator;

class FilterablePaginator extends LengthAwarePaginator
{
    public function filterItems(callable $callback = null): self
    {
        $this->items = $this->filter($callback);

        return $this;
    }
}