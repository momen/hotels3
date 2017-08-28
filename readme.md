This is laravel 5.4 framework.

Below steps for the run/test Project

1. Unzip the file

2. Need to update Or install composer. 
	For install composer command :: composer install -g
	For update composer command :: composer update

3.  Run command :: php artisan config:cache

4. API call :: http://localhost/hotel/public/hotel-search
   
   Method name : hotel-search
   Method : GET
   Params : city, name, price_min, price_max, date_from, date_to, sort_type, sort_by
   So final request URL : http://localhost/hotel/public/hotel-search
   Response : JSON data

POSTMAN CODE SNIPPETS : Use File "Hotel.postman_collection"

Sample Demo ::
API Request :: http://localhost/hotel/public/hotel-search?city=a&name=Hotel&price_min=50&price_max=120&date_from=10-10-2020&date_to=15-10-2020&sort_type=price&sort_by=asc
API Response :: {"data":[{"name":"Concorde Hotel","price":79.4,"city":"Manila","availability":[{"from":"10-10-2020","to":"19-10-2020"},{"from":"22-10-2020","to":"22-11-2020"},{"from":"03-12-2020","to":"20-12-2020"}]},{"name":"Rotana Hotel","price":80.6,"city":"cairo","availability":[{"from":"10-10-2020","to":"12-10-2020"},{"from":"25-10-2020","to":"10-11-2020"},{"from":"05-12-2020","to":"18-12-2020"}]},{"name":"Media One Hotel","price":102.2,"city":"dubai","availability":[{"from":"10-10-2020","to":"15-10-2020"},{"from":"25-10-2020","to":"15-11-2020"},{"from":"10-12-2020","to":"15-12-2020"}]},{"name":"Novotel Hotel","price":111,"city":"Vienna","availability":[{"from":"20-10-2020","to":"28-10-2020"},{"from":"04-11-2020","to":"20-11-2020"},{"from":"08-12-2020","to":"24-12-2020"}]}],"status":"ok"}

5. Running Test Cases

Run below commands

php artisan config:cache
composer dump-autoload
composer dump-autoload -o
vendor\bin\phpunit tests\ApiTest.php


