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
/*
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
*/
set_time_limit(0);

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

date_default_timezone_set('Asia/Novosibirsk');

require_once "dumper.php";
/** Include PHPExcel */
require_once 'PHPExcel/Classes/PHPExcel.php';
require_once 'PHPExcel/Classes/PHPExcel/IOFactory.php';

//$fname1 = 'xls/' . $_FILES['userfile1']['name'];
//$fname2 = 'xls/' . $_FILES['userfile2']['name'];
dumper($_FILES,"_FILES");dumper($_GET,"_GET");dumper($_POST,"_POST");
$fname1 = dirname(__FILE__) . "\\xls\\" . $_GET['userfile1'];
$fname2 = dirname(__FILE__) . "\\xls\\" . $_GET['userfile2'];
//$fname1 = $_GET['userfile1'];
//$fname2 = $_GET['userfile2'];
if($_GET['userlist'] != "")
	$numList = $_GET['userlist']-1;
else
	$numList=0;

//$objPHPExcel1 = PHPExcel_IOFactory::load($fname1);
//$objPHPExcel2 = PHPExcel_IOFactory::load($fname2);
$objReader1 = PHPExcel_IOFactory::createReader('Excel5');
$objReader2 = PHPExcel_IOFactory::createReader('Excel5');
$objReader_temp = PHPExcel_IOFactory::createReader('Excel5');//для определения наличия шапки листа (через объединённые ячейки)
$objReader1->setReadDataOnly(true);//текст без стилей и форматов
$objReader2->setReadDataOnly(true);
$worksheetNames = $objReader1->listWorksheetNames($fname1); //имена листов в таблице
$wsName = $worksheetNames[$numList];
//echo "numList=".$numList." wsName=".$wsName."<br>";
//foreach ($worksheetNames as $wsName)
//{
	$merge_flag=1;//если нет объединённых ячеек в первой строке
//	$countID=1;//номера строк
	$objReader1->setLoadSheetsOnly($wsName);//читаем по 1 листу, для скорости и экономии памяти
	$objReader2->setLoadSheetsOnly($wsName);
	$objReader_temp->setLoadSheetsOnly($wsName);
	$objPHPExcel1 = $objReader1->load($fname1);
	$objPHPExcel2 = $objReader2->load($fname2);
	$objPHPExcel_temp = $objReader_temp->load($fname2);
//	$objPHPExcel1->setActiveSheetIndexByName($wsName);
//	$objPHPExcel2->setActiveSheetIndexByName($wsName);
//	$objPHPExcel_temp->setActiveSheetIndexByName($wsName);
	$objWorksheet1 = $objPHPExcel1->getSheetByName($wsName);
	$objWorksheet2 = $objPHPExcel2->getSheetByName($wsName);
	$objWorksheet_temp = $objPHPExcel_temp->getSheetByName($wsName);
	$highestRow1 = $objWorksheet1->getHighestRow();
	$highestRow2 = $objWorksheet2->getHighestRow();
	if($highestRow1 > $highestRow2)
		$highestRow = $highestRow1;
	else
		$highestRow = $highestRow2;
	$highestColumn = $objWorksheet1->getHighestColumn(); // например, 'F'
	$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // 'F' => 6
	$qq=$objWorksheet_temp->getMergeCells();
	if(isset($qq["A1:$highestColumn"."1"])) //если есть объединённые ячейки в первой строке
	{
//		dumper($qq,"Список объединённых ячеек");
		$merge_flag=3;
	}
//    $nrColumns = ord($highestColumn) - 64;
//	echo "<br>Лист " . iconv('utf-8','windows-1251',$wsName);
//    echo $nrColumns . ' колонок (A-' . $highestColumn . ') ';
//    echo ' и ' . $highestRow . ' строк.';
//	echo '<br>Несовпадающие данные: ';

//	echo '<table border="1">';
	for ($row = 1; $row <= $highestRow; ++ $row)
	{
//		echo '<tr><td>';
		if($row>$merge_flag)//номера строк(ID)
		{
			if($highestRow1 > $highestRow2)
			{
//				echo iconv('utf-8','cp1251',$objWorksheet1->getCellByColumnAndRow(0, $row)->getValue());
			}
			else
			{
//				echo iconv('utf-8','cp1251',$objWorksheet2->getCellByColumnAndRow(0, $row)->getValue());
			}
//			echo $countID++;
		}
//		echo '</td>';
		for ($col = 0; $col < $highestColumnIndex; ++ $col) 
		{
//			echo '<td align=center>';
			$cell1 = $objWorksheet1->getCellByColumnAndRow($col, $row);
			$cell2 = $objWorksheet2->getCellByColumnAndRow($col, $row);
			$val1 = $cell1->getValue();
			$val2 = $cell2->getValue();
//			$val = iconv('utf-8','windows-1251',$cell->getValue());
//			$dataType = PHPExcel_Cell_DataType::dataTypeForValue($val);
			if($row==$merge_flag)//названия столбцов
			{
				$cmp_caption[$col] = iconv('utf-8','windows-1251',$val1);
//				echo $cmp_caption[$col];
				if(($cmp_caption[$col]=="Название") || ($cmp_caption[$col]=="Имя") || ($cmp_caption[$col]=="Название артефакта"))
					if(!isset($name_col))
						$name_col=$col; //№ столбца с названием/именем
			}
			else
			if($val1!=$val2)
			{
				$cmp[$row-$merge_flag] .= $col.","; //для списка различий
//				echo "<B><font color=\"red\">";
//				echo iconv('utf-8','windows-1251',$val1);
//				echo '<br>---<br>';
//				echo iconv('utf-8','windows-1251',$val2);
//				echo '</font></B></td>';
			}
			else
			{
//				echo '</td>';
			}
			$cellValue1[$row-$merge_flag][$col] = iconv('utf-8','windows-1251',$val1);
			$cellValue2[$row-$merge_flag][$col] = iconv('utf-8','windows-1251',$val2);
		}
//		echo '</tr>';
	}
//	echo '</table><br>';

	echo "Список различий:<br>";
	if(isset($cmp))
	{
		foreach($cmp as $r => $c)
		{
			foreach(explode(',',$c) as $val)
				if($val!="")
				{
					echo "<B><font color=\"blue\">".$r." (".$cellValue1[$r][$name_col].") - ";
					echo "</font><font color=\"green\">".$cmp_caption[$val]."</font></B><br>";
					echo "<table border=1><tr><td>";
					echo $cellValue1[$r][$val]."</td><td>";
					echo $cellValue2[$r][$val]."</td></tr></table>";
				}
		}
	}
//}
?>
<br><a href='index.html'>вернуться к списку файлов</a>
</html>