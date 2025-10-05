<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Setup Process
### 1. Downlaod and Install Xampp 

<a align="Left" href="https://www.apachefriends.org/">
<img src="https://cdn.write.corbpie.com/wp-content/uploads/2019/02/xampp-logo.png" 
       alt="Xampp" 
       width="50" 
       height="50">
</a>


### 1. Install Composer (In Your Project)
>>> composer install  <br/>

> ##### **_If facing any problem:_**
1. Open PHP configuration file:
    - Navigate to C:\xampp\php\php.ini
    - Open it with a text editor (like Notepad++ or VS Code)
2. Find and enable sodium extension:
    - Search for extension=sodium
    - If you find it with a semicolon ; at the beginning, remove the semicolon: <br/>
    ini <br/>
    // ; Remove the semicolon from this line:
    **extension=sodium** 
3. Save the file and restart Apache:
    - Open XAMPP Control Panel
    - Stop Apache
    - Start Apache again
    - Start MySQL <br/>

Then run the following command again:<br/>
>>>> composer install

## 2. .env Configuration
    1. Create .env file
    2. Copy all the data from .env.example 
    3. Paste into the .env file

## 3. Database Configuration
    1. Go to (http://localhost/phpmyadmin/)
    2. Create Database same as .env (DB_DATABASE)

## 4. Run Migrations (Table)
    Run (php artisan migrate) command in your project terminal

## 5. Run Application
    Command: 
    php artisan serve


    
## Run Xampp (Ubuntu)
 - sudo /opt/lampp/lampp start
## Quit Xampp (Ubuntu)
 - sudo /opt/lampp/lampp stop


<br/>
<br/>
<br/>
<br/>

>>>>> Developed By **_Faysal Sarder_**