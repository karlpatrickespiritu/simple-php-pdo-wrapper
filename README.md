# simple-php-pdo-wrapper

a wrapper for php's pdo extension.


Installation
--------
via [composer](https://getcomposer.org/)

```sh
$ composer require karlpatrickespiritu/simple-php-pdo-wrapper
```

Getting Started
--------
Edit the `src/DB.config.php` file for your database configuration.

```JavaScript
<?php

return [
    /**
     * Your database configuration. Modify accordingly.
     *
     * @see http://php.net/manual/en/pdo.construct.php
     */
    'DB_CONFIG' => [
        'host' => 'localhost',
        'port' => '',
        'dbname' => '',
        'username' => 'root',
        'password' => ''
    ],

    /**
     * Default PDO attributes. Modify accordingly.
     *
     * @see http://php.net/manual/en/pdo.setattribute.php
     */
    'PDO_ATTRIBUTES' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]
];
```

And that's it, you're good to go!

Usage
--------

#### Namespace
Make sure that this namespace is declared every time using the singleton `DB` class.
```php
use PDO\DB;
```
#### Fetching

Fetch a single row in the result set
```php
$singleRow = DB::i()->fetch('SELECT * FROM `users` WHERE `name` = :name', ['name' => 'Justin Beiber']);
```

Fetch a multiple rows in the result set
```php
$multipleRows = DB::i()->fetchRows('SELECT * FROM `users`');
```

#### Insertion

```php
$params = [
    ':address' => 'Urgello St., Cebu City, 6000, Cebu',
    ':name' => 'Karl Espiritu',
    ':email' => 'wiwa.espiritu@gmail.com'
];

DB::i()->exec("INSERT INTO `users`(`name`, `address`, `email`) VALUES (:name, :address, :email)", $params);

var_dump(DB::i()->getLastId()); // dumps the last inserted id
```

#### Update

```php
$params = [
    ":name" => "John Mayer",
    ":email" => "mayer@somesite.com",
    ":id" => 3
];

$affectedRows = DB::i()->exec("UPDATE `users` SET name = :name, email = :email WHERE id = :id", $params);

var_dump($affectedRows); // dumps the number of affected rows
```

#### Deletion
```php
$affectedRows = DB::i()->exec("DELETE FROM `users` WHERE id = :id", [':id' => 1]);

var_dump($affectedRows); // dumps the number of affected rows
```

Maintainers
--------
 - [@karlpartrickespiritu](https://github.com/karlpatrickespiritu)
 - and [contributors](https://github.com/karlpatrickespiritu/simple-php-pdo-wrapper/graphs/contributors)
 
License
--------
(C) [Karl Patrick Espiritu](http://github.com/karlpatrickespiritu) 2015, released under the MIT license
