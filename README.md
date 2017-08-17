# Parker Smith CS3620 Final Project

## Installation

Clone the project into a directory, then run

    composer install
    
Rename `.env.example` to `.env` and fill in the required environment variables.

## Running
Run the application by typing `docker-compose up -d` in the project directory. The project will then be viewable on
the local machine, usually at `172.18.0.1`

## Tests
Run unit tests by typing `vendor/bin/codecept run unit` in the project directory. 
Code coverage results can be viewed by running `vendor/bin/codecept run unit --coverage`

## Endpoints


Replace `[my-app-name]` with the desired directory name for your new application. You'll want to:

* Point your virtual host document root to your new application's `public/` directory.
* Ensure `logs/` is web writeable.

To run the application in development, you can also run this command. 

	php composer.phar start

Run this command to run the test suite

	php composer.phar test

That's it! Now go build something cool.
