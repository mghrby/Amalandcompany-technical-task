<?php

namespace App\Repositories;

use App\Exceptions\AirtableException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use JsonException;

class AirtableBusinessRepository implements IBusinessRepository
{
    protected string $apiKey;
    protected string $baseUrl;
    protected string $baseId;
    protected string $table;
    protected string $airTableBusinessUrl;

    /**
     * Constructor for initializing AirtableService with base URL, API key, base ID, and table name.
     */
    public function __construct()
    {
        $this->init();
    }

    private function init(): void
    {
        // Get base URL from configuration
        $this->baseUrl = config('services.airtable.base_url');

        // Get API key from configuration
        $this->apiKey = config('services.airtable.api_key');

        // Get base ID from configuration
        $this->baseId = config('services.airtable.base_id');

        // Get table name from configuration
        $this->table = config('services.airtable.table');

        $this->airTableBusinessUrl = $this->baseUrl . "{$this->baseId}/{$this->table}";
    }

    private function httpClient(): \Illuminate\Http\Client\PendingRequest
    {
        return Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ]);
    }

    /**
     * Retrieves all records from the API.
     *
     * @return array The array of records
     * @throws AirtableException
     * @throws RequestException|JsonException if the request fails
     */
    public function getAllByQueryParameters(array $queryParameters): array
    {
        // Send a GET request to the API with the necessary headers
        $response =$this->httpClient()
            ->withQueryParameters($queryParameters)
            ->get($this->airTableBusinessUrl);

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
        $response =$this->httpClient()
            ->patch($this->airTableBusinessUrl, ['records' => $data]);

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
