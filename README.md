# Tests

DEMO: https://tadas-tests.herokuapp.com/

![Alt Text](https://i.imgur.com/zGqBrIC.gif)

## Description

Do you want to create fun simple knowledge tests? 
If answer is yes then this is perfect tool for you. 


- [x] User authentication
- [x] Custom request middleware
- [x] VueJs components for reusable parts
- [x] In English and lithuanian languages 


Build in Laravel, VueJs, Scss, Axios, MySql and some Bootstrap

# Getting started

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/5.4/installation#installation)


Clone the repository

    git clone git@github.com:1995tadas/tests.git
    
Switch to the repo folder

    cd tests

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000


Install dependencies using Node

    npm install
    
For laravel-mix (sass, vue) compilation use 

    npm run dev
    
Command for tracking changes

    npm run watch

    
