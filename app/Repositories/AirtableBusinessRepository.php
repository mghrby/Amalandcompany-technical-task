<?php

namespace App\Repositories;

use App\Exceptions\AirtableException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use JsonException;

class AirtableBusinessRepository implements BusinessRepositoryInterface
{
    protected string $apiKey;
    protected string $baseUrl;
    protected string $baseId;
    protected string $table;

    /**
     * Constructor for initializing AirtableService with base URL, API key, base ID, and table name.
     */
    public function __construct()
    {
        // Get base URL from configuration
        $this->baseUrl = config('services.airtable.base_url');

        // Get API key from configuration
        $this->apiKey = config('services.airtable.api_key');

        // Get base ID from configuration
        $this->baseId = config('services.airtable.base_id');

        // Get table name from configuration
        $this->table = config('services.airtable.table');
    }

    /**
     * Retrieves all records from the API.
     *
     * @return array The array of records
     * @throws AirtableException
     * @throws RequestException|JsonException if the request fails
     */
    public function getAll()
    {
        // Send a GET request to the API with the necessary headers
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->get(
            $this->baseUrl . "{$this->baseId}/{$this->table}?fields%5B%5D=Business+Name&filterByFormula=SEARCH(%22Test%22%2C%7BBusiness+Name%7D)"
        );

        // Throw an exception if the request failed
        $response->throw();

        // Check if the request was successful
        if ($response->successful()) {
            // Return the array of records from the response
            // Make sure 'records' exists in the response
            if (isset($response->json()['records'])) {
                return $response->json()['records'];
            }
            // Throw an exception if 'records' does not exist
            throw new AirtableException(
                'Airtable API response does not contain records. ' . json_encode($response->json(), JSON_THROW_ON_ERROR)
            );
        }

        // Throw an exception if the request was not successful
        throw new AirtableException(
            'Failed to retrieve records from Airtable API.' . json_encode($response->json(), JSON_THROW_ON_ERROR)
        );
    }

    /**
     * Update records in the database table.
     *
     * @param array $data The data to update
     * @return bool True if update was successful, false otherwise
     * @throws RequestException
     * @throws AirtableException|JsonException
     */
    public function update(array $data)
    {
        // Send a PATCH request to update records
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->patch($this->baseUrl . "{$this->baseId}/{$this->table}", ['records' => $data]);

        // Throw an exception if the request failed
        $response->throw();

        // Check if the request was successful
        if ($response->successful()) {
            // Return the array of records from the response
            // Make sure 'records' exists in the response
            if (isset($response->json()['records'])) {
                Log::info(json_encode($response->json()['records'], JSON_THROW_ON_ERROR));
                return true;
            }

            // Throw an exception if 'records' does not exist
            throw new AirtableException(
                'Airtable API response does not contain records. ' . json_encode($response->json(), JSON_THROW_ON_ERROR)
            );
        }

        // Throw an exception if the request was not successful
        throw new AirtableException(
            'Failed to update records in Airtable API.' . json_encode($response->json(), JSON_THROW_ON_ERROR)
        );

    }
}
