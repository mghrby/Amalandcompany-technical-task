<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use App\Services\IBusinessService;
use App\Exceptions\BusinessException;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Output\ConsoleOutput;

class RetrieveAndUpdateBusinessesNamesCommand extends Command
{
    protected $signature = 'businesses:update';
    protected $description = 'Retrieve data from the Business Database table and update business names';

    protected $output;

    /**
     * Class constructor.
     *
     * @param IBusinessService $businessService The business service dependency.
     * @param ConsoleOutput $output The console output
     */
    public function __construct(
        protected IBusinessService $businessService,
        ConsoleOutput              $output
    )
    {
        parent::__construct();
        $this->output = $output;
    }

    /**
     * Handle method to retrieve businesses, update business names, and handle exceptions.
     */
    public function handle(): int
    {
        try {
            // Retrieve businesses
            $businesses = $this->businessesLookup();

            Log::info(json_encode($businesses, JSON_THROW_ON_ERROR));

            // Log the number of businesses retrieved
            $this->info(
                'Businesses retrieved successfully. Found '
                . count($businesses)
                . ' businesses. '
                . json_encode($businesses, JSON_THROW_ON_ERROR)
            );

            // Update business names
            $this->updateBusinessNames($businesses);

            return 0;
        } catch (BusinessException $e) {
            $this->logBusinessError($e);
            return 1;
        } catch (Exception $e) {
            $this->logUnexpectedError($e);
            return 2;
        }
    }

    /**
     * @throws BusinessException
     */
    private function businessesLookup(): array
    {
        $this->info('Retrieving businesses...');
        // Retrieve all businesses
        $businesses = $this->businessService->businessesLookup();

        if (empty($businesses)) {
            throw new BusinessException('No businesses found.');
        }

        return $businesses;
    }

    /**
     * Update business names.
     *
     * @param array $businesses
     */
    private function updateBusinessNames(array $businesses): void
    {
        $this->info('Updating business names...');
        $this->businessService->batchUpdateBusinessName($businesses);
        $this->info('Business names updated successfully.');
    }

    /**
     * Log business exception.
     *
     * @param BusinessException $e
     */
    private function logBusinessError(BusinessException $e): void
    {
        $this->error('Business error: ' . $e->getMessage());
    }

    /**
     * Log unexpected error.
     *
     * @param Exception $e
     */
    private function logUnexpectedError(Exception $e): void
    {
        $this->error('An unexpected error occurred: ' . $e->getMessage() . ' (' . $e->getFile() . ':' . $e->getLine() . ')');
    }
}
