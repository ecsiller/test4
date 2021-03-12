## Installation

1. Clone this repo.

2. Run `docker-compose up -d`

3. Run `docker exec -it test4_php_1 bash -l` for PHP container

4. Run `composer install` in PHP container

5. Create 'muz' database in docker container using preferred mysql client default credentials (user:root, pass:hello, host: 127.0.0.1) 

6. Run `php vendor/bin/doctrine orm:schema-tool:update --force` in PHP container

6. *Optional Run* `composer test` in PHP container

## Usage
1. Create user ->  POST http://localhost/user/create 

2. View profiles ->  POST http://localhost/profiles requires Api-Token header for authorisation can be found in users table api_token column, accepts optional age/gender parameters in body for filtering, also returns photos urls for view(see step 6)

3. Swipe profile -> POST http://localhost/swipe requires Api-Token header, requires referral_id key (can be found in users table id column) as swiped targed by user authenticated by token, requires like key with allowed values 'YES' or 'NO'

4. Login -> POST http://localhost/login reqires email key and password key (can be found in users table)

5. Add Photos -> POST http://localhost/user/gallery requires Api-Token header, accepts any images and converts them to jpeg 100x100

6. View Photos -> GET http://localhost/assets/{userId}/{image}, requires Api-Token header, used to serve profile images
