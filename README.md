# Contact Directory

## Endpoints

### List contacts

-   GET [/api/contacts](http://localhost:8000/api/contacts)
-   GET [/api/contacts?search=<your search>](http://localhost:8000/api/contacts?search=)

### Create a contact

-   POST [/api/contacts](http://localhost:8000/api/contacts)

## Installation steps

In order to this project to work it is needed to do some configuration.
Follow the installation steps to get the project working properly.

-   ### Installing dependencies
    First step is to install all required depencies by typing `composer install` in your terminal

```bash
$ composer install
```

-   ### Create a mysql database

    You need to create a mysql database with the name you want. I used `contact-directory` for the project.

-   ### Configure the project
    Now, you have to create a `.env` file, you can do this by simply copying the `.env.example`
    and change its name to `.env`.

With the `.env` file created, set the `DB_DATABASE` varible to the database name you used.

-   ### Migrate the database
    Go to your terminal and type `php artisan migrate` this command will create all tables needed for the project

```bash
$ php artisan migrate
```

-   ### Start the server
    To start the project go to your terminal and run `php artisan serve`.
    Now you can access at `http://localhost:8000`

```bash
$ php artisan serve
```
