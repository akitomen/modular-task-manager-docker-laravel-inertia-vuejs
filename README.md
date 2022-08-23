<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Getting started

## Installation

This project is developed on following technologies: Laravel 9.*, Vuejs 3.*, InertiaJS, Tailwindcss, Docker
Also demonstrated and configured swagger
link documentation: http://localhost:801/api/documentation
route lint: /API/V1/routes/api.php
I also registered and connected swagger to the routes in the TaskManager module along the path 
Modules/TaskManager/app/API/V1/routes/api.php

Clone the repository

    git clone git@github.com:akitomen/modular-task-manager-docker-laravel-inertia-vuejs.git

Switch to the repo folder

    cd modular-task-manager-docker-laravel-inertia-vuejs

Run your containers

    docker-compose build
    
    docker-compose up
        
Switch to the repo folder

    cd backend
    
Install all the dependencies using composer

    docker-compose exec app composer install
    
Swagger:generate

    docker-compose exec app php artisan l5-swagger:generate
    
Run the database migrations (Set the database connection in .env before migrating)

    docker-compose exec app php artisan migrate

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env
    
    DB_DATABASE=taskmanager
    DB_USERNAME=root
    DB_PASSWORD=root

start npm 

    npm i
    
    npm run dev
    
    cd Modules
    
    cd TaskManager
    
    npm i
    
    npm run dev
    
    
Project links : 

register
    http://localhost:801/register

taskmanager
    http://localhost:801/taskmanager

swagger
    http://localhost:801/api/documentation

