# AmalAndCompany-technical-task

## Configuration

Update the `.env` file with your configuration settings:

- Set `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` for your database connection.
- Set `AIRTABLE_API_KEY`, `AIRTABLE_BASE_ID`, and `AIRTABLE_TABLE` for Airtable integration.

## Usage

To use the application, follow these steps:

1. Start the development server:
    ```bash
    php artisan serve
    ```
   
## Command Usage

Alternatively, you can use the command line to retrieve and update business data:

```bash
php artisan businesses:update
```

## Dependencies

- PHP >= 8.1
- composer

## Directory Structure

- technical-task/
    - app/
        - Console/
            - Commands/
                - RetrieveAndUpdateBusinessesNamesCommand.php
        - Exceptions/
            - BusinessException.php
        - Repositories/
            - AirtableBusinessRepository.php
            - BusinessRepositoryInterface.php
        - Services/
            - BusinessService.php
            - BusinessServiceInterface.php
    - config/
        - services.php
    - .env

## Environment Variables
Update the .env file with your environment variables, including Airtable API credentials, etc.
