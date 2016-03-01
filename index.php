<?php

define('APP_PATH', './');
$domain = $_SERVER['HTTP_HOST'];
switch($domain) {
case 'www.qt.hk':
include './qtblog/index.php';
break;
case 'garden.qt.hk':
include './pc/index.php';
break;
case 'api.qt.hk':
include './api/index.php';
break;
default:
include './qtblog/index.php';
break;
}
