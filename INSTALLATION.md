# BBD NSDS Implementation Support Project
This application is intend for enumerator/ applicant registration process assistance.

## Installation 
This application is based on [Laravel@8.54](https://laravel.com). with boilerplate of [Adminlte 3](https://adminlte.io/themes/v3/) as UI Template.
Please follow this steps properly to install this application.
* Clone/Download as zip this from project/repo from [Github](https://github.com/hafijul233/bbs-nsds)
* Your PC Must have minimal PHP 7.4 installed to operate this application
* For Windows please Download [XAMPP](https://www.apachefriends.org/download.html) for Development Environment.
* Install [Composer](https://getcomposer.org/download/) package manager for application dependence.
* Install [Node/NPM](https://nodejs.org/en/) for Asset Compilations
* Mysql Database Server configuration **XAMPP** comes with prebuild mysql db server setup

If you have All this pre-required tools installed then follow this process to step by step .
* Go To Project Directory using File Explorer then rename the .env.example file to .env
* Open your DBMS Tool like **PHPmyAdmin**/ any other tools create a new Database there  
* Open .env File using any text editor then change the DB Configuration values and save
* Open Command Prompt/Git Bash Window on Project directory and run the command to install package
```bash
composer install
```
* Run the migration command to load database with application database schema
```bash
php artisan migrate:refresh --seed
```
* After package installation complete.then configure application encryption key using this command
```bash
php artisan key:generate
```
* Now, to install npm packages run this command
```bash
npm install
```
* Finally, Run thwe asset compilation command
```bash
npm run dev
```
Installation process is complete.

Run this command to start application
```bash
php artisan serve --port=8000
```
Application start on **[127.0.0.1:8000](http://127.0.0.1:8000)** address

Administrator Login URL:**[Admin Login](http://127.0.0.1:8000/backend/login/)**

Admin Email: **hafijul233@gmail.com**

Admin Password: **password**

You can change it after first login.

Default Password for all user will be **password**

