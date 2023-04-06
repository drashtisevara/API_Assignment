<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>


## About API Assignment Project

This is a Laravel API project that includes complete authentication using Sanctum, along with a user-role-permission-module. This project is meant to serve as a starting point for building secure and scalable APIs with Laravel.

## Authentication

This project uses Sanctum for API authentication. To authenticate a user, make a POST request to the /api/login endpoint with the user's email and password. The API will return a token that should be included in the Authorization header for all subsequent requests.

To log out, simply make a POST request to the /api/logout endpoint with the Authorization header containing the token.

* First of all create AuthController and then Create registration , login, change_password, reset password and logout functionalities
* after that create route on api.php 
and then call this api on postman
* In postman fill the registration details after that fill the login details with email and password.
if email or password is not matched then errors are display 
* When Login is successfull then one token is generated.. 
* If  you want to logout then using its token you are logout
* after that perform the change password function and routes and then call this api on postman and check.
after that create a blade file on reset file and in env file create some mail configuration 
after that create a controller and create a reset password related code
and then create a routes api on api.php 
after that call this api on postman and email was send on mailtrap and show mail on mailtrap and in mail one token was generated and this token was call on postman and then password will be reset.

## Permission Management 

### Administrators can create and manage permissions, which are individual actions that users can or cannot perform. The following endpoints are available:

#### In Permission , 
* Create a Model : php artisan make: model Permission
* Create a Controller : php artisan make:controller PermissionController
* perform Migration table 
* In Permission controller file  create a CRUD Operations like create, show, update, delete
* and create some validations 
* after that perform this routes 
- GET /permissions: Get all permissions
- POST /permissions: Create a new permission
- GET /permissions/{id}: Get a single permission by ID
- PUT /permissions/{id}: Update a permission
- DELETE /permissions/{id}: Delete a permission
* and call this api on postman 
* and create documentation this tested api.

## Role Management

### Administrators can create and manage roles, which are collections of permissions. The following endpoints are available:

- GET /roles: Get all roles
- POST /roles: Create a new role
- GET /roles/{id}: Get a single role by ID
- PUT /roles/{id}: Update a role
- DELETE /roles/{id}: Delete a role

## Module Management

### Administrators can create and manage modules, which are individual features or sections of the application. The following endpoints are available:

- GET /modules: Get all modules
- POST /modules: Create a new module
- GET /modules/{id}: Get a single module by ID
- PUT /modules/{id}: Update a module
- DELETE /modules/{id}: Delete a module

### Middlewre

* Perform Middleware on Job Module because this is protected purpose.. suppose I give permissions to whome to add_access, delete_access, view_access or edit_access..
* which only this user can access, other cannot do.


## Installation

##### Clone the repository
- git clone <repository-url>
##### Install composer dependencies
- composer install
##### Create a copy of the .env.example file and rename it to .env
- cp .env.example .env
##### Generate an application key
- php artisan key:generate
##### Update the .env file with your database credentials
* Run database migrations
- php artisan migrate
##### Seed the database with default data
- php artisan db:seed
##### Start the server
- php artisan serve

## Conclusion

That's it! You should now have a fully functional Laravel API project with authentication using Sanctum and a user-role-permission-module. Feel free to customize the project to fit your needs.
