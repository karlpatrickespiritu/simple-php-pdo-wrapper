<?php

/**
 * resources:
 * http://code.tutsplus.com/tutorials/php-database-access-are-you-doing-it-correctly--net-25338
 *
 * tests
 * http://www.sitepoint.com/bulletproofing-database-interactions/
 * http://edmondscommerce.github.io/php/setting-up-database-testing-in-phpunit.html
 * http://someguyjeremy.com/2013/01/database-testing-with-phpunit.html
 */


/**
 * TODO:
 *
 * singleton for class,
 * different drivers support
 */
DB::i()->fetch();
DB::i()->fetchAll();
DB::i()->exec();
DB::i()->lastQuery();
DB::i()->getLastId();
DB::i()->getNumRows();

DB::i()->getVar();
DB::i()->generateQuery();
DB::i()->displayQ();