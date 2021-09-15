# todolist
Simple CRUD app with auth

# Installation

1. Clone the repository to your computer
2. Go to the project directory
3. Run `composer install`
4. Run `php bin/console doctrine:database:create` to create database
5. Run `php bin/console doctrine:migrations:diff` to create migration file
6. Run `php bin/console doctrine:migrations:migrate` to execute migration

Start your local server: `symfony serve` <br>
or <br>
If you're using apache you can create a virtual host
