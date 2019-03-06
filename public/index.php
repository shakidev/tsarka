<?php
/**
 * Created by PhpStorm.
 * User: shakidevcom
 * Date: 3/6/19
 * Time: 1:03 PM
 */

date_default_timezone_set('Asia/Almaty');
define('DIR_TEMPLATE',__DIR__.'/../template/');
require __DIR__.'/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create(__DIR__. '/..');
$dotenv->load();
(new \App\App())->run();