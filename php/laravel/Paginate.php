<?php

namespace App\Services;

use Closure;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Controller:
 *
 * $models = Model::paginate(15);
 *
 * return $paginate->map($models, function (Model $model) {
 *   return [
 *    'id' => $model->id,
 *    'name' => $model->name,
 *   ];
 * });
 */
class Paginate
{
    public function map(LengthAwarePaginator $paginator, callable $mapCallback)
    {
        $map = function () use ($mapCallback) {
            return [
                'current_page' => $this->currentPage(),
                'data' => $this->items->map($mapCallback)->toArray(),
                'first_page_url' => $this->url(1),
                'from' => $this->firstItem(),
                'last_page' => $this->lastPage(),
                'last_page_url' => $this->url($this->lastPage()),
                'next_page_url' => $this->nextPageUrl(),
                'path' => $this->path,
                'per_page' => $this->perPage(),
                'prev_page_url' => $this->previousPageUrl(),
                'to' => $this->lastItem(),
                'total' => $this->total(),
            ];
        };

        return Closure::bind($map, $paginator, get_class($paginator))();
    }
}
