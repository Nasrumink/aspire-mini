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

## Postman Collection Details

API sequence for USER MODEL
-   Create two users, One with role customer and another with role admin. POST {{BASE_URL}}/api/v1/user
-   Login with user credentials. {{BASE_URL}}/api/v1/user/login
-   Logged in user may update his/her details or Admin can update details of any user. PATCH {{BASE_URL}}/api/v1/user/{{user_id}}
-   Admin can delete any user. DELETE {{BASE_URL}}/api/v1/user/{{user_id}}
-   Logged in user can view his record or Admin can view any user record. GET {{BASE_URL}}/api/v1/user

API sequence for LOANS MODEL
-   Customer can create loans. POST {{BASE_URL}}/api/v1/loan
-   Admin can approve loan. {{BASE_URL}}/api/v1/loan/{{loan_id}}
-   Logged in user or admin can view loans. GET {{BASE_URL}}/api/v1/loan

API sequence for LOANS MODEL 
-   Customer can make repayments againts the loans. POST {{BASE_URL}}/api/v1/repayment
-   Customer can view his repayments and admin can view any repayment. GET {{BASE_URL}}/api/v1/repayment