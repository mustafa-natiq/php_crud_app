# php_crud_app

[![codecov](https://codecov.io/gh/olorondu-emeka/php_crud_app/branch/main/graph/badge.svg)](https://codecov.io/gh/olorondu-emeka/php_crud_app)
![Github Actions](https://github.com/olorondu-emeka/php_crud_app/actions/workflows/test.yml/badge.svg)
a simple CRUD app written in vanilla php

# Start server

Run `php -S 127.0.0.1:5000 -t public`

## Project Structure

```
php_crud_app
├─ api
│  ├─ DbConnection.php
│  ├─ UserController.php
│  └─ UserRepository.php
├─ public
│  ├─ form.html
│  ├─ index.php
│  └─ processor.php
├─ README.md
└─ setup.sql

```

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development purposes.

### Prerequisites

System requirements for this project to work includes:

- Git
- PHP(v7.0 or higher)
- XDebug (for code coverage)
- Composer
- MySQL
- Any IDE of your choice (VS Code is recommended)

### Running the project

To run the project on your local machine, follow the steps below:

- Clone this repo and navigate to the project folder
- Change the `PROJECT_ENV` variable in the **.env** file to `development`
- Update the config variables in the `DbConnection.php` file contained in the `api` folder to suit your MySQL credentials

- Install all dependencies by running the following command:

```bash
composer install
```

- To start the server, run the following command:

```bash
composer start
```

- To run the unit tests, hange the `PROJECT_ENV` variable in the **.env** file to `test` and run the following command:

```bash
composer test
```
