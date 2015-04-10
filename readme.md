## Laravel PHP Framework

[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/laravel/framework)
[![Total Downloads](https://poser.pugx.org/laravel/framework/downloads.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/framework/v/stable.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/framework/v/unstable.svg)](https://packagist.org/packages/laravel/framework)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as authentication, routing, sessions, queueing, and caching.

Laravel is accessible, yet powerful, providing powerful tools needed for large, robust applications. A superb inversion of control container, expressive migration system, and tightly integrated unit testing support give you the tools you need to build any application with which you are tasked.

## Official Documentation

Documentation for the framework can be found on the [Laravel website](http://laravel.com/docs).

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](http://laravel.com/docs/contributions).

### License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

### Server Requirements

The Laravel framework has a few system requirements:

	* PHP >= 5.4
    * Mcrypt PHP Extension
    * OpenSSL PHP Extension
    * Mbstring PHP Extension
    * Tokenizer PHP Extension

#### Installation tips for Ubuntu

1. Install composer:

	`curl -s https://getcomposer.org/installer | php` 
	
	or
	
	`php -r "readfile('https://getcomposer.org/installer');" | php`

	Run *compoposer*:

	`php composer.phar`

	Optionally you can install composer globally and call with the composer command:

	`sudo mv composer.phar /usr/local/bin/composer`

2. Clone the project on your home dir.

    `git clone https://github.com/Zorbel/ServiceRest`

3. Set global permissions for the *storage* folder:

    `chmod -R 777 ServiceRest/storage/`
    
    And create a symbolic link on your apache location:
    ```
    cd /var/www/html/
    sudo ln -s /home/user/workspache/ServiceRest ServiceRest
    ```
4. Configure your apache installation. To make it work, at first, enable the rewrite module by executing following command in the terminal:
    
    `sudo a2enmod rewrite`

    Second, find "apache2.conf" file in your system, mine is located in:
    
    `/etc/apache2/apache2.conf`
    
    In this file, find the following snippets of code:
    
    ```
    <Directory /var/www/>
    Options Indexes FollowSymLinks
    AllowOverride None
    Require all granted
    </Directory>
    ```
    Change *AllowOverride None* to ***AllowOverride All***. Save the file and restart the apache server by executing following command:
    
    `sudo service apache2 restart`
    
5. Execute composer on your project folder location for download dependencies:
    
    `sudo composer update`

6. Configure the file *.env.example.* for a MySQL database.

7. Check the installation of service on: [http://localhost/ServiceRest/public/](http://localhost/ServiceRest/public/). This should display the welcome page Laravel.