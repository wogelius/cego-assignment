# Cego assignment

## Table of contents
* [General info](#general-info)
* [Important directories and files](#important-directories-and-files)
* [Technologies](#technologies)
* [Setup](#setup)
* [Testing](#testing)

## General info
This project generates a text file based on a sql-script

It consists of two parts:
* Laravel cli app
* MySQL database

These two parts are dockerized using Docker and Docker Compose.
When running the app using docker-compose, it launches a mysql-container that autoruns the sql-script located in the 'sqldump'-directory.
It then launces the app-container, which waits for the MySQL-container to be ready to accept connections, before it launches the Laravel-app.
The Laravel-app queries the database for all the users and writes each of them as a line in a CSV-file, which is 

## Important directories and files
* /.env - Contains environment variables that are injected to docker-compose.yml
* /docker-compose.yml - Contains all the configuration for docker-compose
* /sqldump - All sql dumps located here will be run by the MySQL-container on startup
* /output - The resulting csv-file will be located here
* /app - The directory containing the Laravel-app
* /app/Dockerfile - From this file, the Docker image of the Laravel app is generated

## Technologies
Project is created with:
* Docker version 19.03.8
* docker-compose version 1.25.5
* php:7.4-cli-alpine (Docker base image)
* mysql:8 (Docker base image)
* Laravel v7.18.0

## Setup
To run this project, do the following:

```
$ git clone https://github.com/wogelius/cego-assignment.git
$ cd cego-assignment
$ docker-compose run app
$ docker-compose down
```

## Testing
The project can be tested by doing the following:

```
$ git clone https://github.com/wogelius/cego-assignment.git
$ cd cego-assignment/app
$ composer install
$ php vendor\phpunit\phpunit\phpunit
```

