<?php

require "./vendor/autoload.php";

$config = parse_ini_file('./config/config.ini', true);

$date = '2017-07-20';
$time = strtotime($date);
$raw_sql = "select email, sex, FROM_UNIXTIME(reg_time) from users where site_id = %s and reg_time > %s and email not like '%%aukeys.com%%'  and  email not like '%%163.com%%' and email not like '%%126.com%%' and  email not like '%%qq.com%%' and  email not like '%%sina.com%%' ORDER BY reg_time ASC";
$jobs = [
	[ 'website' => 'efox-shop.com', 'site_id' => '109'],
	[ 'website' => 'myefox.it', 'site_id' => '107'],
	[ 'website' => 'myefox.fr', 'site_id' => '108'],
	[ 'website' => 'tabouf.com', 'site_id' => '102'],
	[ 'website' => 'myefox.es', 'site_id' => '118'],
	[ 'website' => 'efox.com.pt', 'site_id' => '100'],
	[ 'website' => 'coolicool.com', 'site_id' => '104'],
];

$source = new \Lib\Source\MysqlSource($config['db']);
$target = new \Lib\Target\XlsxTarget();

foreach($jobs as $job){
	$sql = sprintf($raw_sql, $job['site_id'], $time);
	$data = $source->getData($sql);
	array_unshift($data, ["email", "sex", "reg_time"]);
	$targetOpts = [ 'title' => $job['website'], 'filename' => sprintf('./output/%s_%s.xlsx', $job['website'], $date, $time) ];
	$target->writeData($data, $targetOpts);
}





