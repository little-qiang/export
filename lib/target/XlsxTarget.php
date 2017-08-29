<?php
namespace Lib\Target;

require_once __DIR__ . "/../../vendor/autoload.php";

class XlsxTarget {

	public function writeData($rawData, $options) {
		$objPHPExcel = new \PHPExcel();
		$objSheet = $objPHPExcel->getActiveSheet(); 
		$objSheet->setTitle($options['title']); 
		array_unshift($rawData, ["邮箱", "注册时间"]);
		$objSheet->fromArray($rawData); 
		$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007'); 
		$objWriter->save($options['filename']);
	}
}