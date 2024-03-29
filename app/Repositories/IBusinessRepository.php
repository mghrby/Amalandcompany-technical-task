<?php

namespace App\Repositories;

interface IBusinessRepository
{
    public function getAllByQueryParameters(array $queryParameters): array;
    public function update(array $data);
}
