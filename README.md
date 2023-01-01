## Steps to use the application

This micro service enables users to get onboarded to the system and create loan applications and make repayments againts the approved loans.

## To run the application on local

Clone the project using command.
-   git clone https://github.com/Nasrumink/aspire-mini.git
-   composer install
Setup ENV file
-   Create .ENV file and configure database credentials
Run the migrations to create tables in the database. 
-   php artisan migrate:fresh
Test cases to run
-   php artisan test --env=testing
