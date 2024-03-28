# Laravel Technical Task

This repository contains the implementation of a Laravel application for a technical task involving the retrieval and updating of business names from an external API (specifically Airtable).

## Requirements
- PHP version >= 8.1
- Composer

## Project Structure

The project directory structure is as follows:

- **app/Console/Commands/RetrieveAndUpdateBusinessesNamesCommand.php**: This file contains the implementation of the console command responsible for retrieving and updating business names.

- **app/Exceptions/AirtableException.php**: Custom exception class for handling Airtable-related errors.

- **app/Exceptions/BusinessException.php**: Custom exception class for handling business-related errors.

- **app/Repositories/BusinessRepositoryInterface.php**: Interface defining the contract for business repository classes.

- **app/Repositories/AirtableBusinessRepository.php**: Implementation of the business repository interface for fetching data from Airtable.

- **app/Services/BusinessService.php**: Implementation of the business service interface for interacting with business data.

- **app/Services/IBusinessServiceInterface.php**: Interface defining the contract for business repository classes.

- **config/services.php**: Configuration file containing third-party service credentials, including Airtable configuration.

- **.env**: Environment configuration file containing application-specific settings such as database connection details, API keys, and service URLs.

- **.env.example**: Example environment configuration file containing placeholders for sensitive information.

## Usage

To use this application, follow these steps:

1. Clone the repository to your local machine.
2. Navigate to the project directory.
3. Run `composer install` to install the project dependencies.
4. Rename the `.env.example` file to `.env` and fill in the required environment variables, such as database connection details and Airtable API key.
5. Run `php artisan key:generate` to generate an application key.

## Commands

The main command provided by this application is:

- `php artisan businesses:update`: This command retrieves data from the Business Database table and updates business names accordingly.

## Testing

Unit tests for the application can be found in the `tests` directory. To run the tests, execute `php artisan test`.

## Credits

This Laravel application was created by Abdelrahman Elmaghraby. Feel free to contact ab.mghrby@gmail.com for any inquiries or support.
