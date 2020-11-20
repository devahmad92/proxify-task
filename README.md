### How to run the project (Laravel way - legacy)

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

### How to run the project using Docker:
- clone this repository.
- update the environment variables in .env file.
- (optional) if you don't found the .env file please run the below command:
```sh
$ php -r "file_exists('.env') || copy('.env.example', '.env');"
```
- create a Docker image from this project using this command:
```sh
$ docker image build -t proxify .
```
- create a Docker container from the image using the below command:
```sh
$ docker container run -d proxify
```
Note:
with each container there are 5 workers working and listing to the Queue.
you can run as much as you want.
- run the below command to take the container ID:
```sh
$ docker container ls
```
- run the below command to enter inside the container:
```sh
$ docker container exec -it (CONTAINER_ID) sh
```
- run the below command to create the project migrations and add the seed data (dummy data):
```sh
$ php artisan migrate --seed
```
- run the below command to exit from the container:
```sh
$ exit
```
- run the below command to check the container logs:
```sh
$ docker container logs --follow (CONTAINER_ID)
```
