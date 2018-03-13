<?php

require "./vendor/autoload.php";

$config = parse_ini_file('./config/config.ini', true);

$date = '2017-07-20';
$time = strtotime($date);
$sql  = "SELECT * FROM shop_config;";

$source = new \Lib\Source\MysqlSource($config['db1']);

$data = $source->getData($sql);

$target = new \Lib\Target\MongoTarget($config['mongo1']);
$target->writeData($data);


