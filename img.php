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

/*$f=fopen($fname,"rt") or die("Ошибка открытия файла $fname");
$num=fgetcsv($f,1000);
foreach($num as $v)
*/

//filenum*.txt:
//Формат файла:	<число> - файлы пронумерованны по-порядку (1.bmp-<число>.bmp)
//				# - файлы пронумерованны не по-порядку, ниже расположен список номеров через запятую
$dir = glob(dirname(__FILE__) . "/images/filenum*.txt");
dumper($dir,"DIR");
foreach($dir as $idx => $fname)
{
	// Создаем объект класса PHPExcel
	$objPHPExcel = new PHPExcel();
	// Устанавливаем индекс активного листа
	$objPHPExcel->setActiveSheetIndex(0);
	// Получаем активный лист
	$objWorksheet = $objPHPExcel->getActiveSheet();
	$objWorksheet->getColumnDimension("B")->setWidth(9.9);
	$str = file($fname);
	dumper($str,"STR");
	if(eregi("^#",$str[0]))//файлы пронумерованны не по-порядку
	{
		$i=1;//#строки
		foreach(explode(",",$str[1]) as $num)
		{
			$objWorksheet->setCellValue("A$i",$num);
			$objWorksheet->getRowDimension($i)->setRowHeight(51);
			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setWorksheet($objWorksheet);
			$objDrawing->setName("i$num");
//			$objDrawing->setDescription('Logo');
			$objDrawing->setPath("./images/$num.bmp");
			$objDrawing->setWidth(69);
//			$objDrawing->setHeight(69);
			$objDrawing->setCoordinates("B$i");
//			$objDrawing->setOffsetX(100);
			$i++;
		}
	}
	else //файлы пронумерованны по-порядку (1.bmp-$num.bmp)
	{
		for($num=1;$num<=$str[0];$num++)
		{
			$objWorksheet->setCellValue("A$num",$num);
			$objWorksheet->getRowDimension($num)->setRowHeight(51);
			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setWorksheet($objWorksheet);
			$objDrawing->setName("i$num");
//			$objDrawing->setDescription('Logo');
			$objDrawing->setPath("./images/$num.bmp");
			$objDrawing->setWidth(69);
//			$objDrawing->setHeight(69);
			$objDrawing->setCoordinates("B$num");
//			$objDrawing->setOffsetX(100);
		}
	}
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save("img$idx.xls");
}
?>
<br><a href='index.html'>вернуться к списку файлов</a>
</html>