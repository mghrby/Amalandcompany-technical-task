<?php

namespace App\Services;

interface IBusinessServiceInterface
{
    public function getAllBusinesses(): array;
    public function batchUpdateBusinessName(
        array $records,
        array $fields = ['Business Name' => 'Airotax']
    ): bool;
}
