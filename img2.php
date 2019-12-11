<html>
<meta http-equiv="Content-Type" content="text/html charset=windows-1251">
<style>
br		{mso-data-placement:same-cell;}
td		{vertical-align:middle;}
.top	{border-top:1.0pt solid black;}
.bottom	{border-bottom:1.0pt solid black;}
.left	{border-left:1.0pt solid black;}
.right	{border-right:1.0pt solid black;}
</style>
<?php
/** Error reporting */

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

date_default_timezone_set('Asia/Novosibirsk');

require_once "dumper.php";
/** Include PHPExcel */
require_once 'PHPExcel/Classes/PHPExcel.php';
require_once 'PHPExcel/Classes/PHPExcel/IOFactory.php';

//$fname = dirname(__FILE__) . "\\images\\" . $_GET['userfile1'];

// Создаем объект класса PHPExcel
$objPHPExcel = new PHPExcel();
// Устанавливаем индекс активного листа
$objPHPExcel->setActiveSheetIndex(0);
// Получаем активный лист
$objWorksheet = $objPHPExcel->getActiveSheet();
$objWorksheet->getColumnDimension("B")->setWidth(9.9);
//$objDrawing = new PHPExcel_Worksheet_Drawing();
//$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
for($i=1;$i<=2;$i++)
{
	$objWorksheet->getRowDimension($i)->setRowHeight(51);
	$objDrawing = new PHPExcel_Worksheet_Drawing();
	$objDrawing->setWorksheet($objWorksheet);
	$objDrawing->setName("i$i");
//	$objDrawing->setDescription('Logo');
	$objDrawing->setPath("./images/$i.bmp");
	$objDrawing->setWidth(69);
//	$objDrawing->setHeight(69);
	$objDrawing->setCoordinates("B$i");
//	$objDrawing->setOffsetX(100);
}

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save("img.xls");

?>
<br><a href='index.html'>вернуться к списку файлов</a>
</html>