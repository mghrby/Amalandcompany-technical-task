<?php

namespace App\Repositories;

interface IBusinessRepository
{
    public function getAllByQueryParameters(string $queryParameters): array;
    public function update(array $data);
}
