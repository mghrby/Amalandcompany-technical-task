<?php

namespace App\Repositories;

interface BusinessRepositoryInterface
{
    public function getAll();
    public function update(array $data);
}
