<?php
namespace App\Repositories;

interface CategoryRepository extends BaseRepository
{
    public function getCategories();
    public function updateData($id, $data);
}
