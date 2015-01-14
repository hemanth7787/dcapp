## DC app API

[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/laravel/framework)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)

DC mobile app API using Laravel PHP framework.

## Setup on local


1. Clone this repo

2. Install composer [Composer website](https://getcomposer.org/).

3. run "composer install"

4. Edit bootstrap/start.php update $env['local'] and add your hostname

5. Test by "php artisan env" you shud get local

6. Edit app/config/local/database.php change it according to you mysql settings

7. Create tables in database using "php artisan migrate"

8. Run "php artisan migrate --package=tappleby/laravel-auth-token"

9. Run test server using "php artisan serve"

### Contributing To Dcapp api

**Please avoid tracking unnecessary files under git.**

### License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
