<?php
namespace App\Repositories;

interface AuthorRepository extends BaseRepository
{
    public function getAuthor();
    public  function updateData($id, $data);
}
