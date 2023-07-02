## Example for simple filter with scopes and API resource

You need docker installed because it is based on sail.

Please clone the repository with git clone git@github.com:majomadrid001/pandago.git

Switch to the folder

Rename .env.testing to .env

Run in console:

    docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs

Run

        ./vendor/bin/sail up

to start the containers.

Run

        ./vendor/bin/sail artisan migrate --seed

to create the tables and seed with random data (it creates random 300 vehicles. you can adjust the amount in the seeder.)

When testing with postman just make a GET request to http://localhost/api/vehicles

You can use the following parameters:

    type (for testing I created 1-3)
    usecase (for testing I created 1-3)
    pricefrom (int)
    priceto (int)
    range (max range (int))
    motorway (boolean)
    driversLicense (boolean)
    topBox (boolean)
    orderBy (1 is prices asc, 2 is prices desc, default is by id)

