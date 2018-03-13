<?php

require "./vendor/autoload.php";

$config = parse_ini_file('./config/config.ini', true);

$table = 'ad';
// $table = 'ad_custom';
// $table = 'ad_position';
$table = 'shop_config';
$sql  = "SELECT * FROM {$table};";

$source = new \Lib\Source\MysqlSource($config['db1']);
$data = $source->getData($sql);


foreach($data as &$row){
	foreach ($row as $key => &$value) {
		if($key == 'value') continue;
		if(is_numeric($value)){
			$value = (int)$value;
		}
	}
	unset($value);
}
unset($row);

$target = new \Lib\Target\MongoTarget($config['mongo1']);
$target->writeData($data, $table);


