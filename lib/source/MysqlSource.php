<?php

namespace Lib\Source;

class MysqlSource implements InterfaceSource {

	protected $db = null;

	public function __construct($dbConfig){
		$dsn = sprintf('mysql:dbname=%s;host=%s', $dbConfig['dbname'], $dbConfig['host']);
		$username = $dbConfig['username'];
		$password = $dbConfig['password'];
		$options = [ \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8' ];
		try {
			$this->db = new \Pdo($dsn, $username, $password, $options);
		} catch (\PDOException $e) {
		  	echo 'ERROR: ' . $e->getMessage();
		  	exit;
		}
	}

	public function getData($sql, $fmt = \PDO::FETCH_ASSOC){
		$stmt = $this->db->query($sql);
		$rawRt = $stmt->fetchAll($fmt);
		return $rawRt;
	}
}
