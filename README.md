
# Store Management System

## Introduction

This project is a web-based solution designed to streamline inventory management, customer tracking, and sales control. It provides businesses with an efficient platform to monitor and optimize stock levels, maintain customer records, and oversee sales operations. The user-friendly interface empowers enterprises to make data-driven decisions, enhancing organization and facilitating sustainable growth and profitability.

## Content


* [Features](#Features)
* [API](#Api)
* [Tools and Technologies](#Technologies)
* [Deploy](#Deploy)
* [Author](#Author)
## API documentation
Define *api_token* in .env

#### Returns all items

```http
  GET /api/v1/products/
```

| Parameter   | Type       | Description                           |
| :---------- | :--------- | :---------------------------------- |
| `api_key` | `string` | **Required**. Bearer *api_token* |

#### Retorna um item

```http
  GET /api/v1/products/${id}
```

| Parameter   | Type       | Description     
| :---------- | :--------- | :------------------------------------------ |
| `api_key` | `string` | **Required**. Bearer *api_token* |
| `id`      | `string` | **Required**. The ID of the item you want |


## Features

- Inventory management
- Sales Management
- Finance Management
- Customer Management
- Dark / Light Mode
- Sales report and statistics

## Deploy locally

```bash 
git clone https://github.com/cobuci/Vanguard-LARAVEL
``` 


Before running migrate seed you can change the default user in

```bash 
Database -> seeders -> UserSeeder.php
``` 

The default login is

```bash 
 Email: test@test.com
 Password: test

``` 

If you DO NOT want the system to manage Customers, Products and Categories, remember to comment the respective lines in
```bash 
Database -> seeders -> DatabaseSeeder.php
``` 



To deploy this project, run

<details>
  <summary>Without Docker</summary>

Requirements
* PHP ^8.1
* Composer
* Node

```bash 
  cp .env.example .env

  npm install 

  composer install 

  php artisan key:generate 

  php artisan migrate --seed

  php artisan serve 

  npm run dev 
 
```

</details>


<details>
  <summary>With Docker</summary>

Requirements
* Docker
  However, instead of repeatedly typing vendor/bin/sail to execute Sail commands, you may wish to configure a shell alias that allows you to execute Sail's commands more easily:

```bash
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
```
```bash 
  cp .env.example .env

  sail up -d

  sail php artisan key:generate

  sail php artisan migrate --seed ()

  sail npm run dev
 
```

</details>


## Stack used

- PHP
- [Laravel](https://laravel.com/)
- [LiveWire](https://livewire.laravel.com/)
- [WireUI](https://livewire-wireui.com/)
- [Tailwind](https://tailwindcss.com/)
- [Chart.js](https://www.chartjs.org/)

## Demo

https://demo1.cobuci.com/


## Author

- [Victor Cobuci](https://www.dev.cobuci.com)

[![Linkedin Badge](https://img.shields.io/badge/-Cobuci-blue?style=flat-square&logo=Linkedin&logoColor=white&link=https://www.linkedin.com/in/cobuci/)](https://www.linkedin.com/in/cobuci/) 
