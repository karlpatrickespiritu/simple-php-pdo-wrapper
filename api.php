<?php

/**
 * resources:
 * http://code.tutsplus.com/tutorials/php-database-access-are-you-doing-it-correctly--net-25338
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
DB::i()->generateQuery();
DB::i()->displayQ();
DB::i()->getLastId();
DB::i()->getNumRows();
DB::i()->getVar();