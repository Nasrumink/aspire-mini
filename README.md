## Aspire Mini

This micro service enables users to get onboarded to the system and create loan applications and make repayments againts the approved loans.

## To run the application on local

Steps to run the project.
-   git clone https://github.com/Nasrumink/aspire-mini.git
-   composer install
-   Create .ENV file and configure database credentials
-   php artisan migrate:fresh
-   php artisan test
-   Create below two ENV variables in postman to run the APIs
-   BASE_URL = http://127.0.0.1/aspire-mini/public
-   token = ''
