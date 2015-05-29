# Simple-PHP-PDO-Wrapper-Class
A simple database wrapper class in **PHP** using **PDO/MYSQL** extension.
### How to Get Started
- - - -
Set up database connection on **db_settings.ini.php** file, like so.
```
[DB]
host     = localhost
dbname   = my_database_name
username = my_username
password = my_password
```
Require the class.
```php
require_once 'DB.php';
```
Create an instance of the DB class.
```php
$db = new DB();
```

### Basic CRUD Examples
- - - -
Below are examples on how to use the very most basic and easy chaining **CRUD** operations offered by the **DB** Class. 
#### FETCH ROWS
_Returns an array containing all of the result set._
```php
$users = $db->fetchRows('SELECT * FROM users');
```
#### FETCH SIGLE ROW
_This always returns only a single row from the result set._
```php
$users = $db->fetchRows('SELECT * FROM users ORDER BY id DESC');
```

#### INSERT
```php
$insertValues = [
    'name'      => 'Karl Patrick Espiritu',
    'address'   => 'Cebu City, Philippines',
    'email'     => 'wiwa.espiritu@gmail.com'
];

$affectedRows = $db->insert('users')->values($insertValues);

if($affectedRows > 0) {
    // Get the last inserted ID
    $lastInsertID = $db->getLastInsertID();
}
```

#### UPDATE
```php
$updateValues = [
    'name'      => 'Espiritu, Karl',
    'address'   => 'Davao City, Philippines',
    'email'     => 'karlespiritu@gmail.com'
];

$affectedRows = $db->update('users')->set($updateValues)->where('id = :id', [':id' => 1]);
```

#### DELETE
```php
$affectedRows = $db->delete('users')->where('id = :id', [':id' => 1]);
```