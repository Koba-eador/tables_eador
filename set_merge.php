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
/** Error reporting 
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
*/
define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
date_default_timezone_set('Asia/Novosibirsk');

$item_set_file = file("item_set.var");
$count_item_set = count($item_set_file);
require_once "dumper.php";
/** Include PHPExcel */
require_once 'PHPExcel/Classes/PHPExcel.php';
require_once 'PHPExcel/Classes/PHPExcel/IOFactory.php';

dumper($_FILES,"_FILES");dumper($_GET,"_GET");dumper($_POST,"_POST");
//$fname = 'xls/' . $_FILES['merge_file']['name'];
$fname = dirname(__FILE__) . "\\xls\\" . $_GET['merge_file'];
//$fname = $_GET['merge_file'];

//Разбор item_set.var
for($i = 0,$n=0; $i < $count_item_set; $i++)
{
	if(eregi("^/([0-9]{1,})",$item_set_file[$i],$k))
	{
		$n=$k[1];
 		if($n>$max)$max=$n;
	}
    else
    if(eregi("^ItemsNum",$item_set_file[$i]))
    {
		$s=explode(':',$item_set_file[$i]);
		if($n!=0)//к-во пропускаемых ячеек - для учёта объединённых ячеек
			$item_set_num_merge[$n] = $item_set_num_merge[$n-1]+$s[1]+1-1;
	}
}
dumper($item_set_num_merge,"item_set_num_merge");
echo $max;
$objPHPExcel = PHPExcel_IOFactory::load($fname);
// Устанавливаем индекс активного листа
$objPHPExcel->setActiveSheetIndex(0);
// Получаем активный лист
$objWorksheet = $objPHPExcel->getActiveSheet();
$highestRow = $objWorksheet->getHighestRow();
$highestColumn = $objWorksheet->getHighestColumn(); // например, 'F'
$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // 'F' => 6

for($i=1;$i<$max+1;$i++)
{
//	echo "<tr><td>$i</td><td>$item_set_name[$i]</td>";
$objWorksheet->mergeCells("A".($item_set_num_merge[$i-1]+1).":A".$item_set_num_merge[$i]);
$objWorksheet->mergeCells("B".($item_set_num_merge[$i-1]+1).":B".$item_set_num_merge[$i]);
$objWorksheet->mergeCells("H".($item_set_num_merge[$i-1]+1).":H".$item_set_num_merge[$i]);
$objWorksheet->mergeCells("I".($item_set_num_merge[$i-1]+1).":I".$item_set_num_merge[$i]);
//$objWorksheet->mergeCells("G".($item_set_num_merge[$i-1]+1).":G".$item_set_num_merge[$i]);
//public function mergeCellsByColumnAndRow($pColumn1 = 0, $pRow1 = 1, $pColumn2 = 0, $pRow2 = 1) 
}

for ($row = 1; $row <= $highestRow; ++ $row)
{
	for ($col = 0; $col < $highestColumnIndex; ++ $col) 
	{
		$cell = $objWorksheet->getCellByColumnAndRow($col, $row);
//		$val = $cell->getValue();
		$val = iconv('utf-8','windows-1251',$cell->getValue());
//			$dataType = PHPExcel_Cell_DataType::dataTypeForValue($val);
//		$objWorksheet->getStyleByColumnAndRow($col,$row)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
//		$objWorksheet->getStyleByColumnAndRow($col,$row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	}
}
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save($fname.".merged.xls");
/*
$objPHPExcel = PHPExcel_IOFactory::load("XMLTest.xml");
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('covertedXml2Xlsx.xlsx');
*/
?>
<br><a href='index.html'>вернуться к списку файлов</a>
</html>