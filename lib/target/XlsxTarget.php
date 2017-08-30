<?php
namespace Lib\Target;

require_once __DIR__ . "/../../vendor/autoload.php";

class XlsxTarget {

	public function writeData($data, $options) {
		$objPHPExcel = new \PHPExcel();
		$objSheet = $objPHPExcel->getActiveSheet(); 
		$objSheet->setTitle($options['title']); 
		$objSheet->fromArray($data); 
		$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007'); 
		$objWriter->save($options['filename']);
	}
}
