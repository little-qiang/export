<?php
require "./vendor/autoload.php";

$config = parse_ini_file('./config/config.ini', true);

$source = new \Lib\Source\MysqlSource($config['db']);
$sql = 'select username, created_at from user limit 1;';
$data = $source->getData($sql);
$target = new \Lib\Target\XlsxTarget();
$targetOpts = [ 
	'title' => '注册记录',
	'filename' => 'taobao.com.xlsx',
];
$target->writeData($data, $targetOpts);




