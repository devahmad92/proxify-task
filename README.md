### How to run the project 

- clone this repository.
- run the below command to install project dependencies:
```sh
$ composer install \
   --no-interaction \
   --no-scripts \
   --no-suggest \
   --no-dev \
   --optimize-autoloader
```
- run the below command to create the project migrations and add the seed data (dummy data):
```sh
$ php artisan migrate --seed
```
- update the environment variables in .env file.
- (optional) if you don't found the .env file please run the below command:
```sh
$ php -r "file_exists('.env') || copy('.env.example', '.env');"
```
- start Laravel server 
```sh
$ php artisan serve
```
- you can run as much as you want workers with this command:
```sh
$ php artisan queue:work --sleep=3 --tries=3 --delay=1 --timeout=300
```
