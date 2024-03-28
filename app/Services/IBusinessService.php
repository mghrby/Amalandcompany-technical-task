<?php

namespace App\Services;

interface IBusinessService
{
    public function businessesLookup(): array;
    public function batchUpdateBusinessName(
        array $records,
        array $fields = ['Business Name' => 'Airotax']
    ): bool;
}
