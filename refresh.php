<?php

$dbsConf = [
    ['host' => '10.100.1.207', 'username' => 'root', 'password' => 'aukeys@2016.com', 'dbname' => 'aecmp-web'],
    [ 'host' => '10.100.1.208', 'username' => 'root', 'password' => 'aukeys@2016.com', 'dbname' => 'aecmp-web', ],
    // [ 'host' => '10.100.1.209', 'username' => 'root', 'password' => 'aukeys@2016.com', 'dbname' => 'aecmp-web', ],
    [ 'host' => '10.100.1.210', 'username' => 'root', 'password' => 'aukeys@2016.com', 'dbname' => 'aecmp-web', ],
    [ 'host' => '10.100.1.213', 'username' => 'root', 'password' => 'aukeys@2016.com', 'dbname' => 'aecmp-web', ],
    [ 'host' => '10.100.1.214', 'username' => 'root', 'password' => 'aukeys@2016.com', 'dbname' => 'aecmp-web', ],
];

$mongosConf = [
    ['host' => '10.100.1.207', 'port' => 27017, 'dbname' => 'aecmp-cache'],
    [ 'host' => '10.100.1.208', 'port' => 27017, 'dbname' => 'aecmp-cache', ],
    // [ 'host' => '10.100.1.209', 'port' => 27017, 'dbname' => 'aecmp-cache', ],
    [ 'host' => '10.100.1.210', 'port' => 27017, 'dbname' => 'aecmp-cache', ],
    [ 'host' => '10.100.1.213', 'port' => 27017, 'dbname' => 'aecmp-cache', ],
    [ 'host' => '10.100.1.214', 'port' => 27017, 'dbname' => 'aecmp-cache', ],
];

$tables = [
    'operation_coupon',
    'operation_coupon_goods_list',
    'operation_coupon_list',
    'operation_coupon_user_list',
];


echo '开始清空mysql...' .PHP_EOL;
foreach ($dbsConf as $dbConf) {
    $dbDsn = sprintf('mysql:dbname=%s;host=%s', $dbConf['dbname'], $dbConf['host']);
    $db = new \Pdo($dbDsn, $dbConf['username'], $dbConf['password'], [\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8']);
    foreach ($tables as $table) {
        $db->exec('truncate ' . $table . ';');
        printf('ip: %s, db: %s, table: %s...'.PHP_EOL, $dbConf['host'], $dbConf['dbname'], $table);
    }
}
echo '完成清空mysql...' .PHP_EOL;
echo '开始清空mongo...' .PHP_EOL;

foreach ($mongosConf as $mongoConf) {
    $mongoDsn = sprintf('mongodb://%s:%s', $mongoConf['host'], $mongoConf['port']);
    $manager = new \MongoDB\Driver\Manager($mongoDsn);
    foreach ($tables as $table) {
	    $bulk = new \MongoDB\Driver\BulkWrite;
	    $bulk->delete([], ['limit' => 0]);
        $rt = $manager->executeBulkWrite($mongoConf['dbname'] . '.' . $table, $bulk);
        printf('ip: %s, db: %s, table: %s...'.PHP_EOL, $mongoConf['host'], $mongoConf['dbname'], $table);
    }
}
echo '完成清空mongo...' .PHP_EOL;
