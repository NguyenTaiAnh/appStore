<?php
namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class PaginatorService {
    public function getPaginator($items, $currentPage = false, $perPage = false){
        $total = count($items);
        $paginate = new Paginator($items, $total, $perPage, $currentPage);
        return $paginate;
    }

    public function getCustomPaginator($total, $currentPage = false, $perPage = false){
        return [
            'total_count'  => $total ?? 0,
            'total_pages' => $perPage != 0 ? ceil($total / $perPage) : 0,
            'current_page' => $currentPage ?? 1,
            'limit' => $perPage,
        ];
    }
}
