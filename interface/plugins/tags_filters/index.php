<?php
/**
 * Created by PhpStorm.
 * User: kchapple
 * Date: 3/3/16
 * Time: 1:17 PM
 */

require_once __DIR__.'/../globals.php';
require_once __DIR__.'/vendor/autoload.php';

$app = new Library\Framework\App();
$app->run();