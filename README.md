# Sample Shopping Basket Service

## Overview

I have created a sample RESTful API to manage the shopping basket.

It uses a variety of tools, etc, and hopefully the structure is clear enough.

The is the PHP version, intended to be uses as the basis of writing in Ruby.

I have included the setup instructions, API routes, and test run instructions.

## Known Limitations

 - There is no validation on add to basket quantity, or total amount, which can cause overflows.
 - There were some architectural shortcuts to get this implemented in a hurry.
 - The add/remove basket logic could use refactoring.
 - The test suit is sparse.

## Server Running Instructions - Vagrant

Requires Vagrant and a Virtualisation Engine

https://www.vagrantup.com/downloads.html
https://www.virtualbox.org/wiki/Downloads

Once installed, you can navigate to the root directory of this project (with the VagrantFile), and run
```
vagrant up
```
This will provision a vagrant server with ubuntu, php, postgres, apache and the slim framework. It will also create and seed the database, and bring in the composer dependencies.

There will be a lot of commands executed, with information shown in red or green. There shouldn't be anything to worry about, but the check is whether you reach the 'Vagrant Up' message, and there are no exit codes reported.

If anything untoward occurs, please let me know.

All being well, it will allow you to curl to the api and start making requests. Further instructions can be found below.

## Server Running Instructions - Other

To set this up without vagrant requires a few hoops to create the expected environment - a postgres db with the required roles and db, composer run to pull down the dependencies, and so on. If necessary these steps can be determined from the VagrantFile.

## Server Running Instructions

To SSH onto the running server, from the directory root use:

```
vagrant ssh
```

The URL is 192.168.50.52/

Internal to vagrant server:

To access postgres, you can use the postgres peer user:

```
psql -U postgres
```

To run the unit and functional tests:

```
cd /vagrant && vendor/bin/phpunit -c phpunit.xml --testsuite all
```

## API Running Instructions

Baskets

_GET all_

```
curl "http://192.168.50.52/baskets" \
    --request GET
```

_GET by ID_

```
curl "http://192.168.50.52/baskets/fdde64c5-bd47-4657-9a57-103f61cbff47" \
    --request GET
```

_POST New_

```
curl "http://192.168.50.52/baskets" \
     --request POST \
     --insecure \
```


Items

_GET all_

```
curl "http://192.168.50.52/items" \
    --request GET
```

_GET by ID_

```
curl "http://192.168.50.52/items/903cd4e9-1d44-47b9-8b50-abdbe57016c0" \
    --request GET
```

Basket Lines

_Add one Item to a Basket_
```
curl "http://192.168.50.52/baskets/f37f72fe-40b9-4452-a7e4-0144cda1d7fb/items/903cd4e9-1d44-47b9-8b50-abdbe57016c0" \
     --request PUT
```

_Add a quantity of Items to a Basket _
```
curl "http://192.168.50.52/baskets/f37f72fe-40b9-4452-a7e4-0144cda1d7fb/items/903cd4e9-1d44-47b9-8b50-abdbe57016c0?quantity=3" \
     --request PUT
```

_Delete one Item from the Basket_
```
curl "http://192.168.50.52/baskets/f37f72fe-40b9-4452-a7e4-0144cda1d7fb/items/903cd4e9-1d44-47b9-8b50-abdbe57016c0" \
     --request DELETE
```

_Delete a quantity of Items from the Basket_
```
curl "http://192.168.50.52/baskets/f37f72fe-40b9-4452-a7e4-0144cda1d7fb/items/903cd4e9-1d44-47b9-8b50-abdbe57016c0?quantity=3" \
     --request DELETE
```
