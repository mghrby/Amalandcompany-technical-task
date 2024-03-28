<?php

namespace App\Repositories;

interface IBusinessRepositoryInterface
{
    public function getAll();
    public function update(array $data);
}
