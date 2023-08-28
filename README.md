# Food Seller API

[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

A personal project for practicing technical skills.

## Table of Contents

- [Goals](#goals)
- [Installation](#installation)

## Goals

- Laravel and backend skills demostration.
- RESTful API understanding
- Database design
- Controller-Service-Repository pattern for a simple and readable project design 
- SwaggerDocs for a clean RESTful API documentation 
- and more...

## Installation

clone the project

```bash

git clone <repository link>
```

Inside your project folder 

```bash

cp .env.example .env
```

make sure to add all your env vard according to you database information 

Install dependiencies

```bash
composer install

```

Also you can install npm dependiencies to use things like conventional commit and husky for pre-commits hook, this hooks can be configured to execute task before pushing changes like run test, check lint, avoid exposing secrets (db creds, apikeys), etc

```bash
npm install

```

Run this command to generet a JWT_SECRET var in your .env file
```bash
php artisan jwt:secret

```

Finally run the migration and start the server

```bash
php artisan migrate
php artisan serve

```
