<?php

require "./vendor/autoload.php";

$config = parse_ini_file('./config/config.ini', true);

$date = '2017-07-20';
$time = strtotime($date);
$table = 'topic';
$sql  = "SELECT * FROM {$table};";

$source = new \Lib\Source\MysqlSource($config['db1']);
$data = $source->getData($sql);


foreach($data as &$row){
	foreach ($row as $key => &$value) {
		if(is_numeric($value)){
			$value = (int)$value;
		}
	}
	unset($value);
}
unset($row);

$target = new \Lib\Target\MongoTarget($config['mongo1']);
$target->writeData($data, $table);


