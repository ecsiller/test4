## Installation

1. Clone this repo.

2. Run `docker-compose up -d`

3. Run `docker exec -it test4_php_1 bash -l`

4. Run `composer install`

5. Run `php vendor/bin/doctrine orm:schema-tool:update --force`

6. *Optional Run* `composer test`

## Usage
1. Create user ->  POST http://localhost/user/create 

2. View profiles ->  POST http://localhost/profiles requires Api-Token header for authorisation can be found in users table api_token column, accepts optional age/gender parameters in body for filtering, also returns photos urls for view(see step 6)

3. Swipe profile -> POST http://localhost/swipe requires Api-Token header, requires referral_id key (can be found in users table id column) as swiped targed by user authenticated by token, requires like key with allowed values 'YES' or 'NO'

4. Login -> POST http://localhost/login reqires email key and password key (can be found in users table)

5. Add Photos -> POST http://localhost/user/gallery requires Api-Token header, accepts any images and converts them to jpeg 100x100

6. View Photos -> GET http://localhost/assets/{userId}/{image}, requires Api-Token header, used to serve profile images
