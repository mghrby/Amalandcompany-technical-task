<?php

namespace Tests\Unit\Console\Commands;

use App\Console\Commands\RetrieveAndUpdateBusinessesNamesCommand;
use App\Services\IBusinessService;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use Mockery;

class RetrieveAndUpdateBusinessesNamesCommandTest extends TestCase
{
    /**
     * Test to handle the successful retrieval and update of businesses.
     */
    public function testHandleSuccessfullyRetrievesAndUpdatesBusinesses(): void
    {
        // Mock IBusinessService
        $businessServiceMock = Mockery::mock(IBusinessService::class);

        // Mock retrieved businesses
        $businesses = [
            [
                "id" => "recBVL2h8rMfTAjCW",
                "createdTime" => "2024-01-08T15:58:50.000Z",
                "fields" => [
                    "Business Name" => "Test",
                ]
            ],
            [
                "id" => "recSXXIJNJix8s2dY",
                "createdTime" => "2024-01-08T15:58:50.000Z",
                "fields" => [
                    "Business Name" => "Test",
                ]
            ]
        ];

        $businessServiceMock
            ->expects('businessesLookup')
            ->andReturns($businesses);
        $businessServiceMock
            ->expects('batchUpdateBusinessName')
            ->with($businesses);

        // Mock Log facade
        Log::shouldReceive('info')->once()->with(json_encode($businesses, JSON_THROW_ON_ERROR));

        // Mock ConsoleOutput
        $outputMock = $this->getMockBuilder(\Symfony\Component\Console\Output\ConsoleOutput::class)
            ->disableOriginalConstructor()
            ->getMock();

        // Create command instance
        $command = new RetrieveAndUpdateBusinessesNamesCommand($businessServiceMock, $outputMock);

        // Execute the command
        $exitCode = $command->handle();

        // Assert exit code is 0 (success)
        $this->assertSame(0, $exitCode);
    }

    /**
     * Test that the handle method handles a BusinessException
     */
    public function testHandleHandlesBusinessException(): void
    {
        // Mock IBusinessService to throw a BusinessException
        $businessServiceMock = Mockery::mock(IBusinessService::class);
        $businessServiceMock
            ->expects('businessesLookup')
            ->andThrow(new \App\Exceptions\BusinessException('No businesses found.'));

        // Mock ConsoleOutput
        $outputMock = $this->getMockBuilder(\Symfony\Component\Console\Output\ConsoleOutput::class)
            ->disableOriginalConstructor()
            ->getMock();

        // Create command instance
        $command = new RetrieveAndUpdateBusinessesNamesCommand($businessServiceMock, $outputMock);

        // Execute the command and capture the exit code
        $exitCode = $command->handle();

        // Assert that the exit code is 1 (failure)
        $this->assertSame(1, $exitCode);
    }


    /**
     * Test handling unexpected exception in handle method.
     */
    public function testHandleHandlesUnexpectedException(): void
    {
        // Mock IBusinessService to throw an exception
        $businessServiceMock = Mockery::mock(IBusinessService::class);
        $businessServiceMock
            ->expects('businessesLookup')
            ->andThrow(new \Exception('Unexpected error occurred.'));

        // Mock ConsoleOutput
        $outputMock = $this->getMockBuilder(\Symfony\Component\Console\Output\ConsoleOutput::class)
            ->disableOriginalConstructor()
            ->getMock();

        // Create command instance
        $command = new RetrieveAndUpdateBusinessesNamesCommand($businessServiceMock, $outputMock);

        // Execute the command and get the exit code
        $exitCode = $command->handle();

        // Assert that the exit code is 2 (failure)
        $this->assertSame(2, $exitCode);
    }
}
