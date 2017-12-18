<?php
namespace Lib\Target;

require_once __DIR__ . "/../../vendor/autoload.php";

class MongoTarget {

	protected $mongo = null;

	public function __construct($config){
		$dsn = sprintf('mongodb://%s:%s', $config['host'], $config['port']);
		$this->mongo = new \MongoDB\Driver\Manager($dsn);
		$this->dbname = $config['dbname'];
	}

	public function writeData($data, $table) {
		$bulk            = new \MongoDB\Driver\BulkWrite;
		$writeConcern    = new \MongoDB\Driver\WriteConcern(\MongoDB\Driver\WriteConcern::MAJORITY, 1000);
		$collect         = sprintf('%s.%s', $this->dbname, $table);
		foreach($data as $row){
			$row['_id'] = new \MongoDB\BSON\ObjectID;
			$bulk->insert($row);
		}
		$result = $this->mongo->executeBulkWrite($collect, $bulk, $writeConcern);
	}
}
