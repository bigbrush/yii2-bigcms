<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

echo "<?php\n";
?>
/**
 * This file is generated automatically with the install console command.
 * 
 * It returns a configuration array for a mysql database.
 * The configration is used to setup a [[<?= $class ?>]] object.
 * 
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

return [
    'class' => '<?= $class ?>',
    'dsn' => 'mysql:host=<?= $host ?>;dbname=<?= $name ?>',
    'username' => '<?= $username ?>',
    'password' => '<?= $password ?>',
    'charset' => '<?= $charset ?>',
];
