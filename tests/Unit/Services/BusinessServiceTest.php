<?php

namespace Tests\Unit\Services;

use App\Repositories\IBusinessRepositoryInterface;
use App\Services\BusinessService;
use PHPUnit\Framework\TestCase;
use Mockery;

class BusinessServiceTest extends TestCase
{
    protected IBusinessRepositoryInterface $businessRepositoryMock;
    protected BusinessService $businessService;

    /**
     * Set up the test environment before each test case.
     */
    protected function setUp(): void
    {
        // Call the parent setUp method
        parent::setUp();

        // Create a mock for the IBusinessRepositoryInterface
        $this->businessRepositoryMock = Mockery::mock(IBusinessRepositoryInterface::class);

        // Instantiate the BusinessService class with the mock repository
        $this->businessService = new BusinessService($this->businessRepositoryMock);
    }

    /**
     * Tear down the test case.
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        // Close Mockery
        Mockery::close();
    }

    /**
     * Test case to verify that the getAllBusinesses method returns an empty array when the repository returns an empty array.
     */
    public function testGetAllBusinessesReturnsEmptyArrayWhenRepositoryReturnsEmptyArray(): void
    {
        // Arrange
        // Mock the businessRepository getAll method to return an empty array
        $this->businessRepositoryMock
            ->expects('getAll')
            ->andReturns([]);

        // Act
        $result = $this->businessService->getAllBusinesses();

        // Assert
        // Verify that the result is an array
        $this->assertIsArray($result);
        // Verify that the result array has a count of 0
        $this->assertCount(0, $result);
    }

    /**
     * Test the getAllBusinesses method of the BusinessService class.
     *
     * This test ensures that the getAllBusinesses method returns the correct businesses
     * by mocking the BusinessRepository and asserting that the returned result matches
     * the expected businesses.
     */
    public function testGetAllBusinessesReturnsBusinessesFromRepository(): void
    {
        // Arrange
        $businesses = [
            [
                'id' => 'recBVL2h8rMfTAjCW',
                'createdTime' => '2024-01-08T15:58:50.000Z',
                'fields' => [
                    'Business Name' => 'Test',
                ]
            ],
            [
                'id' => 'recSXXIJNJix8s2dY',
                'createdTime' => '2024-01-08T15:58:50.000Z',
                'fields' => [
                    'Business Name' => 'Test',
                ]
            ]
        ];

        // Mock the BusinessRepository's getAll method to return the businesses
        $this->businessRepositoryMock
            ->expects('getAll')
            ->andReturns($businesses);

        // Act
        $result = $this->businessService->getAllBusinesses();

        // Assert
        // Check if the returned result matches the expected businesses
        $this->assertEquals($businesses, $result);
    }

    /**
     * Test for batch updating business names and returning true on successful update.
     */
    public function testBatchUpdateBusinessNameReturnsTrueOnSuccessfulUpdate(): void
    {
        // Arrange
        // Sample records with id, createdTime, and Business Name field
        $records = [
            [
                'id' => 'recBVL2h8rMfTAjCW',
                'createdTime' => '2024-01-08T15:58:50.000Z',
                'fields' => [
                    'Business Name' => 'Test',
                ]
            ],
            [
                'id' => 'recSXXIJNJix8s2dY',
                'createdTime' => '2024-01-08T15:58:50.000Z',
                'fields' => [
                    'Business Name' => 'Test',
                ]
            ]
        ];

        // Mocking the business repository update method to expect specific data and return true
        $this->businessRepositoryMock
            ->expects('update')
            ->with([
                ['id' => 'recBVL2h8rMfTAjCW', 'fields' => ['Business Name' => 'Airotax']],
                ['id' => 'recSXXIJNJix8s2dY', 'fields' => ['Business Name' => 'Airotax']],
            ])
            ->andReturns(true);

        // Act
        $result = $this->businessService->batchUpdateBusinessName($records);

        // Assert
        $this->assertTrue($result);
    }

    /**
     * Test case to verify that batch updating business names returns false on failed update.
     */
    public function testBatchUpdateBusinessNameReturnsFalseOnFailedUpdate(): void
    {
        // Data setup
        $records = [
            [
                'id' => 'recBVL2h8rMfTAjCW',
                'createdTime' => '2024-01-08T15:58:50.000Z',
                'fields' => [
                    'Business Name' => 'Test',
                ]
            ],
            [
                'id' => 'recSXXIJNJix8s2dY',
                'createdTime' => '2024-01-08T15:58:50.000Z',
                'fields' => [
                    'Business Name' => 'Test',
                ]
            ]
        ];

        // Mock the businessRepository's update method to return false for the specified records
        $this->businessRepositoryMock
            ->expects('update')
            ->with([
                ['id' => 'recBVL2h8rMfTAjCW', 'fields' => ['Business Name' => 'Airotax']],
                ['id' => 'recSXXIJNJix8s2dY', 'fields' => ['Business Name' => 'Airotax']],
            ])
            ->andReturns(false);

        // Call the batchUpdateBusinessName method and store the result
        $result = $this->businessService->batchUpdateBusinessName($records);

        // Check that the result is false
        $this->assertFalse($result);
    }
}
