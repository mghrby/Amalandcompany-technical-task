<?php

namespace App\Services;

use App\Repositories\BusinessRepositoryInterface;

class BusinessService implements BusinessServiceInterface
{

    /**
     * Constructor for initializing the BusinessService class.
     *
     * @param BusinessRepositoryInterface $businessRepository The repository for business data.
     */
    public function __construct(protected BusinessRepositoryInterface $businessRepository)
    {
    }

    /**
     * Retrieve all businesses from the repository.
     *
     * @return array
     */
    public function getAllBusinesses(): array
    {
        // Retrieve all businesses from the repository
        return $this->businessRepository->getAll();
    }

    /**
     * Batch update business names.
     *
     * @param array $records The records to update.
     * @param array $fields The fields to be updated with their default values.
     * @return array Returns true if the update was successful, false otherwise.
     */
    public function batchUpdateBusinessName(array $records, array $fields = ['Business Name' => 'Airotax']): bool
    {
        // Transform the records using the specified fields
        $transformedRecords = $this->transformRecords($records, $fields);

        // Update the business records in the repository
        return $this->businessRepository->update($transformedRecords);
    }

    /**
     * Transform records by adding specified fields to each record.
     *
     * @param array $records The array of records to transform.
     * @param array $fields The array of fields to add to each record.
     *
     * @return array The transformed records with added fields.
     */
    protected function transformRecords(array $records, array $fields): array
    {
        // Transform each record by adding the specified fields
        return collect($records)->transform(function ($record) use ($fields) {
            return [
                'id' => $record['id'],
                'fields' => $fields,
            ];
        })->toArray();
    }
}
