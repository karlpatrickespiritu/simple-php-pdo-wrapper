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
...

Maintainers
--------
 - [@karlpartrickespiritu](https://github.com/karlpatrickespiritu)
 - and [contributors](https://github.com/karlpatrickespiritu/simple-php-pdo-wrapper/graphs/contributors)
 
License
--------
(C) [Karl Patrick Espiritu](http://github.com/karlpatrickespiritu) 2015, released under the MIT license
