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
require_once "dumper.php";
$a_file = file("defender.var");
$count_f = count($a_file);
$def_txt_file = file("Defender.txt");
$count_def_txt = count($def_txt_file);
$u_file = file("unit.var");
$count_u = count($u_file);
$b_file = file("inner_build.var");
$count_b = count($b_file);
$race_file = file("race.var");
$count_race = count($race_file);
$def_event_file = file("def_event.exp");
$def_enc_file = file("def_enc.exp");

$def_no1=array(29,30,31,32,34,35,36,37,38,42,43,44,45,66,67,68,77,78,89,92,97);//где местность=""
$def_no2=array(30,31,32,34,35,36,37,38,42,43,44,45,66,67,68,77,78,89,105);//где стража="Перенимается из охраны провинции"

$res_name=array(1=>"Железо", "Красное дерево", "Кони", "Мандрагора", "Арканит", "Мрамор", "Мифрил", "Дионий", "Чёрный лотос");
$max=0;$max1=0;$max_u=0;$max_e=0;$t[0]=0;$j=0;
$u1=-1;$u2=0;$u3=0;	//№ строки юнита в xls
$g1=0; //кол-во стражей в одном сайте
$a1=0; //№ абилки
$a2=0; //№ эффекта ritual
$e1=0; //№ эффекта
$up1=0; //число upg_type в unit_upg
$u_a=0; //абилки in unit.var
$p=""; //для печати без последней ";"

//разбор def_event.exp
for($i = 0; $i < count($def_event_file); $i++)
{
	$str = trim($def_event_file[$i]);
	if(!eregi("^#",$str))//не комментарий
	{
		if(eregi("^\\\$",$str))//переменная
		{
			$var = $str;//текущее имя переменной берём из файла
		}
		else
		{
			$s = explode("|",$str);
			eval($var."[$s[0]][] = $s[1];");
			$EventGroupName[$s[1]] = $s[2];//имя группы событий для получения стражи
			$def_event_cnt[$s[0]] = $s[3];//к-во договоров со стражей
		}
	}
}

foreach($export_def_event as $def => $ev)
{
	foreach($ev as $i)
	{
			//доп. способы получения стражи
			$def_add[$def][] = "Можно поставить стражу в провинции от <B>группы событий (group_event) <font color=\"blue\">$i (".$EventGroupName[$i].")</font></B>";
	}
}

foreach($export_def_event_scroll as $def => $ev)
{
	foreach($ev as $i)
	{
			$p = "";
			$cnt = $def_event_cnt[$def];
			$p .= "Можно получить <B><font color=\"blue\">".$cnt." </font></B>";
			if($cnt==1)
				$p .= "договор";
			else
			if($cnt>1 && $cnt<5)
				$p .= "договора";
			else
				$p .= "договоров";
			$p .= " со стражей от <B>группы событий (group_event) <font color=\"blue\">$i (".$EventGroupName[$i].")</font></B>";
			$def_add[$def][] = $p;//доп. способы получения стражи
	}
}

//разбор def_enc.exp
for($i = 0; $i < count($def_enc_file); $i++)
{
	$str = trim($def_enc_file[$i]);
	if(!eregi("^#",$str))//не комментарий
	{
		if(eregi("^\\\$",$str))//переменная
		{
			$var = $str;//текущее имя переменной берём из файла
		}
		else
		{
			$s = explode("|",$str);
			eval($var."[$s[0]][] = $s[1];");
			$EncGroupName[$s[1]] = $s[2];//имя группы приключений для получения стражи
			$def_enc_cnt[$s[0]] = $s[3];//к-во договоров со стражей
		}
	}
}

foreach($export_def_enc_scroll as $def => $ev)
{
	foreach($ev as $i)
	{
			$p = "";
			$cnt = $def_enc_cnt[$def];
			$p .= "Можно получить <B><font color=\"blue\">".$cnt." </font></B>";
			if($cnt==1)
				$p .= "договор";
			else
			if($cnt>1 && $cnt<5)
				$p .= "договора";
			else
				$p .= "договоров";
			$p .= " со стражей от <B>группы приключений (group_enc) <font color=\"blue\">$i (".$EncGroupName[$i].")</font></B>";
			$def_add[$def][] = $p;//доп. способы получения стражи
	}
}

//Разбор Defender.txt
for($i = 0; $i < $count_def_txt; $i++)
{  
    if(eregi("^([0-9]{1,})",$def_txt_file[$i],$k))
    {
		$n=$k[1];
		if($n>$max1)$max1=$n;
    }
    else
	{
		if(substr($def_txt_file[$i],0,1)=="#")
		{
			$def_txt[$n]=$def_txt[$n].((substr(trim($def_txt_file[$i]),-1,1)=="#") ? substr(trim($def_txt_file[$i]),1,-1) : substr($def_txt_file[$i],1)."<br>");
			$def_txt_idx[$n] = $i;//в какую строку добавлять спойлеры о карме/коррупции
			$def_txt_idx2[$i] = $n;//этой строке соответствуют юниты этого номера охраны
		}
		else
		if(trim($def_txt_file[$i])!="")
		{
			if(substr(trim($def_txt_file[$i]),-1,1)=="#")
			{
				$def_txt[$n]=$def_txt[$n].substr(trim($def_txt_file[$i]),0,-1);
				$i++;
			}
			else
				$def_txt[$n]=$def_txt[$n].$def_txt_file[$i]."<br>";
		}
//echo $n."-".$unit_txt[$n]."<br>";
	}

}

//Разбор race.var
for($i = 0,$n=0; $i < $count_race; $i++)
{  
   if(eregi("^/([0-9]{1,})",$race_file[$i],$k))
    {
		$n=$k[1];
    }
    else
    if(eregi("^name",$race_file[$i]))
    {
		$s=explode(':',$race_file[$i]);
		$unit_race[$n]=substr(trim($s[1]),0,-1);
    }
}

//Разбор inner_build.var
for($i = 0,$n=0; $i < $count_b; $i++)
{  
   if(eregi("^/([0-9]{1,})",$b_file[$i],$k))
    {
		$n=$k[1];
    }
    else
    if(eregi("^Name",$b_file[$i]))
    {
		$s=explode(':',$b_file[$i]);
		$build_name[$n]=trim(substr($s[1],0,-3));
// echo $n."-".$build_name[$n]."<br>";
    }
    else
    if(eregi("^Ability",$b_file[$i])) //Ability в site.var или defender.var
    {
		if(trim($b_file[$i])!="Ability:")
		{
			$s=explode(':',$b_file[$i]);
			$build_abil=$s[1];
			$i++;
			$s1=explode(':',$b_file[$i]);//param1
			$build_param1=$s1[1]+1-1;
			$i++;
			$s1=explode(':',$b_file[$i]);//param2
			$build_param2=$s1[1]+1-1;
			if($build_abil==15)
				if($build_param2<=0)
					$def_build[$build_param1] .= $build_name[$n]."; ";
				else
				{
					$def_build[$build_param1] .= $build_name[$n]." (<B><font color=\"blue\">$build_param2</font></B> ";
					if($build_param2==1)
						$def_build[$build_param1] .= "договор";
					else
					if($build_param2<5)
						$def_build[$build_param1] .= "договора";
					else
						$def_build[$build_param1] .= "договоров";
					$def_build[$build_param1] .= "); ";
				}
		}
	}
}

//Разбор unit.var
for($i = 0,$n=0; $i < $count_u; $i++)
{  
   if(eregi("^/([0-9]{1,})",$u_file[$i],$k))
    {
		$n=$k[1];
		if($n>$max_u)$max_u=$n;
    }
    else
    if(eregi("^name",$u_file[$i]))
    {
		$s=explode(':',$u_file[$i]);
		$s=trim(substr(trim($s[1]),0,-1));
		if(in_array($n,array_merge(range(40,43),range(238,253),range(263,278))))//апы героя
		{
			$u_name[$n]=$s."<font color=\"fuchsia\">@</font>";
		}
		else
		{
			while(in_array($s,$u_name))
			{
				echo $n."- Дубль UNIT=".$s;
				$s = $s."<font color=\"fuchsia\">*</font>";
				echo " <B>Замена на</B> ".$s."<br>";
			}
			$u_name[$n]=$s;
		}
    }
}

//-------------------------------------------------------------
//Разбор основного файла
for($i = 0,$n=0; $i < $count_f; $i++)
{
	if(eregi("^/([0-9]{1,})",$a_file[$i],$k))
	{
		$n=$k[1];
		if($n>$max)$max=$n;
		$rep[$n]['yes']='Ok';
		$s=substr($a_file[$i],log10($n)+3);
//echo $n."-".$s."<br>";
		$name1_table[$n]=trim($s); //имя в формате "/0 Пусто "

//echo "<br>".$k[1]."! $n  ! $max !!"; 
		$u1++;	//№ строки
    }
	else
    if(eregi("^Name:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$s=substr(trim($s[1]),0,-1);
		while(in_array($s,$name_table))
		{
			echo $n."- Дубль NAME=".$s;
			$s = $s."<font color=\"fuchsia\">*</font>";
			echo " <B>Замена на</B> ".$s."<br>";
		}
		$name_table[$n]=$s;
//		$name_table[$n]=substr(trim($s[1]),0,-1);
    }
    else
    if(eregi("^Plain",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		if(($s[1]+1-1)!=0) $terrain[$n] .= "Равнины; ";
//echo $n."-".$terrain[$n][0]."<br>";
//echo $n."-".substr($terrain[$n][0],9);
    }
    else
    if(eregi("^Forest",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		if(($s[1]+1-1)!=0) $terrain[$n] .= "Леса; ";
    }
    else
    if(eregi("^Hill",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		if(($s[1]+1-1)!=0) $terrain[$n] .= "Холмы; ";
    }
    else
    if(eregi("^Swamp",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		if(($s[1]+1-1)!=0) $terrain[$n] .= "Болота; ";
    }
/*    if(eregi("^Plain",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$terrain[$n][0]="Равнины:".$s[1];
//echo $n."-".$terrain[$n][0]."<br>";
//echo $n."-".substr($terrain[$n][0],9);
    }
    else
    if(eregi("^Forest",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$terrain[$n][1]="   Леса:".$s[1];
    }
    else
    if(eregi("^Hill",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$terrain[$n][2]="  Холмы:".$s[1];
    }
    else
    if(eregi("^Swamp",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$terrain[$n][3]=" Болота:".$s[1];
    }
    else
    if(eregi("^Desert",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$terrain[$n][4]="Пустыня:".$s[1];
    }
    if(eregi("^Tundra",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$terrain[$n][5]="  Тундра:".$s[1];
    }
*/
    else
    if(eregi("^Power:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$Power[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^GoldCost:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$GoldCost[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^GemGost:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$GemGost[$n]=$s[1]+1-1;
	}
    else
    if(eregi("^GoldPayment:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$GoldPayment[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^GemPayment:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$GemPayment[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^Initiative:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$Initiative[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^LootPoss:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$LootPoss[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^LootNum:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$LootNum[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^NoDismiss:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		if(($s[1]+1-1)!=0) $NoDismiss[$n]="Да";
    }
    else
    if(eregi("^Karma:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$Karma[$n]=$s[1]+1-1;
		if($Karma[$n] != 0)
			$karma_flag[$def_txt_idx[$n]] = $s[1]+1-1;//№ строки в Ritual.txt, куда надо вставить спойлер о карме
    }
    else
    if(eregi("^Building:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		if(($s[1]+1-1)!=0) $build_table[$n]=$build_name[$s[1]+1-1];
//echo $n."-".$build_table[$n]."<br>";
    }
    else
    if((eregi("^Resourse:",$a_file[$i])) || (eregi("^Resource:",$a_file[$i])))
    {
		$s=explode(':',$a_file[$i]);
		$s1=substr(trim($s[1]),1,-1);
		$s2=explode(',',$s1);
//echo $n."-".$s1."<br>";	
		for($j=0;($s2[$j]!="")&&($j<10);$j++)
		{
			$res_table[$n][$j]=$res_name[$s2[$j]+1-1];
//echo $n."-".$res_table[$n][$j]."<br>";
		}
    }
	else
    if((eregi("^Unit",$a_file[$i])) && (!eregi("^Units",$a_file[$i])))
    {
		$s=explode(':',$a_file[$i]);
		$re[$n][$u2]=explode(',',$s[1]);
		if (($re[$n][$u2][2]+1-1)!=0) //количество юнитов 
		{
			$u_table[$n][$u2]=$u_name[$re[$n][$u2][0]+1-1];
			$u_lvl[$n][$u2]=$re[$n][$u2][1]+1-1;
			$u_cnt[$n][$u2]=$re[$n][$u2][2]+1-1;
//echo $n."-".$u_qua[$n]."<br>";
//     echo "u1=".$u1." u2=".$u2." ".$u_table1[$u1][$u2]."<br>";
// echo "u1=".$u1." u2=".$u2." u_lvl1=".$u_lvl1[$u1][$u2]." u_cnt1=".$u_cnt1[$u1][$u2]." ".$u_table1[$u1][$u2]."<br>";
 //     $str_num[$u1]=count($u_table1[$u1]);
			$u2++;	
		}
	}
    else
    if(eregi("^Ability",$a_file[$i])) //Ability в site.var или defender.var
    {
//echo $n."-".$a_file[$i]."<br>";
		if(trim($a_file[$i])!="Ability:")
		{
			$s=explode(':',$a_file[$i]);
			$abil[$n][$a1]['num']=$s[1];	//массив № абилок
//echo $n."-".$abil[$n][$a1]['num']."<br>";
			$i++;
			$s=explode(':',$a_file[$i]);
			$abil[$n][$a1]['param1']=$s[1]+1-1;	//массив param1 абилок
			$i++;
			$s=explode(':',$a_file[$i]);
			$abil[$n][$a1]['param2']=$s[1]+1-1;	//массив param2 абилок
			$a1++;
		}
    }
}

//------------------------------------------------------------
//конец работы с файлом
//echo "u1=".$u1." u2=".$u2." u3=".$u3."<br>";
//for($i=1;$i<$u1;$i++)echo $str_num[$i]."-".$u_table1[$i]." ";
/*
//шапка

echo "<table width=100% border=1><tr><td>№</td>";
for($i=1;$i<$t[0];$i++)echo "<td>$t[$i]</td>";
echo "</tr><tr>";
//все остальные поля
for($i=0;$i<$max+1;$i++)
{
	if($rep[$i]['yes']=='Ok')
	{
		echo "<tr><td>".$i."</td> ";
		for($j=1;$j<$t[0];$j++)echo "<td>".$res[$i][$t[$j]]."</td>";
//  foreach ($p as $key => $value) echo $key."->".$value." ";
		echo "</tr>";
	}
}
*/

//echo "<table width=100% border=1><tr><td>№</td><td colspan=20>Units</td></tr>";

//вывод юнитов
for($i=0,$j=0;$i<$max+1;$i++)
{ 
//	echo "<tr><td>$i</td><td>";
	for(;($u_table[$i][$j]!="")&&($j<10000);$j++)
	{
		$p = $p.$u_table[$i][$j].":<B><font color=\"red\">".$u_cnt[$i][$j];
		$p = $p."</font></B> (<font color=\"green\">ур. <B>".$u_lvl[$i][$j]."</B></font>); ";
		$def_unit2[$i] .= $u_table[$i][$j].":".$u_cnt[$i][$j]." (ур. ".$u_lvl[$i][$j]."); ";
	}
	if(in_array($i,$def_no2))
	{
		$def_unit[$i]="<B><font color=\"fuchsia\">Перенимается из охраны провинции</font></B>";
		$def_unit2[$i]="Охрана перенимается из охраны провинции";
	}
	else
	{
		$def_unit[$i]=substr($p,0,strlen($p)-2);
		$def_unit2[$i]=substr($def_unit2[$i],0,strlen($def_unit2[$i])-2);
	}
	$p="";
//	echo "</td></tr>";
}
//dumper($def_unit2);

//вывод ресурсов
for($i=0;$i<$max+1;$i++)
{ 
//	echo "<tr><td>$i</td><td>";
	for($j=0;($res_table[$i][$j]!="")&&($j<10);$j++)
		$def_res[$i] .= $res_table[$i][$j].(($res_table[$i][$j+1]=="") ? "" : "; ");
//	echo "</td></tr>";
}

//местность
for($i=0;$i<$max+1;$i++)
{
//	echo "<tr><td>$i</td><td>";
	if(!in_array($i,$def_no1))
	{
		if(count(explode(";",$terrain[$i]))==5)
			$def_terrain[$i]="Везде";
		else
			$def_terrain[$i]=substr($terrain[$i],0,-2);
	}
//	echo "</td></tr>";
}

//Абилки 
for($i=0,$j=0;$i<$max+1;$i++)
{ 
//	echo "<tr><td>$i</td><td>";
	for($n=1;($abil[$i][$j]['num']!="")&&($j<10000);$j++,$n++)
	{
		$num=$abil[$i][$j]['num']+1-1;
		$param1=$abil[$i][$j]['param1'];
		$param2=$abil[$i][$j]['param2'];
		if($num==0)
//			$p .= "Нет";
			$n--;
		else
//		if($num!=0)
			$p .= $n.") ";
		if($num==1)
		{
		    if($param1!=0)
			{
				$p .= "Доход золота с провинции <B>".(($param1>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param1."%</font>";
			}
		    if($param2!=0)
				$p .= (($param1!=0) ? "</B>; д" : "Д")."оход кристаллов с провинции <B>".(($param2>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param2."%";
		}
		else
		if($num==2)
		{
			if($param2==0)
				$p .= "Настроение жителей <B>".(($param1>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param1;
			else
			if($param2<0)
			{
				$p .= "Настроение жителей <B>".(($param1>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param1;
				$p .= "</font></B>. Не снижает настроение в провинциях расы <B><font color=\"teal\">".$unit_race[abs($param2)];
			}
			else
				$p .= "Увеличивает настроение в землях расы <B><font color=\"teal\">".$unit_race[$param2]."</font></B> на <B><font color=\"green\">$param1";
		}
		else
		if($num==3)
		{
			$p .= "Снижение скорости накопления недовольства на <B><font color=\"green\">".$param1;
		}
		else
		if($num==4)
		{
			$p .= "Снижение платы войскам гарнизона на <B><font color=\"green\">".$param1."%";
		}
		else
		if($num==5)
		{
			$p .= "Увеличение обзора территории вокруг провинции";
		}
		else
		if($num==6)
		{
			$p .= "Ускорение восстановления жизни войск на <B><font color=\"green\">".$param1."%";
		}
		else
		if($num==7)
		{
			$p .= "Доход золота <B>".(($param2>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param2."</font></B>";
			$p .= ", если в провинции есть <B><font color=\"blue\">".$res_name[$param1];
		}
		else
		if($num==8)
		{
			$p .= "Ускорение восстановления укреплений в провинции на <B><font color=\"green\">".$param1."%";
		}
		else
		if($num==9)
		{
			$p .= "Прирост населения <B>".(($param1>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param1;
		}
		else
		if($num==10)
		{
			$p .= "Существует предмет для найма стража, уровень <B><font color=\"blue\">".$param1."</font></B>, редкость <B><font color=\"blue\">".$param2;
		}
		else
		if($num==11)
		{
			if($param1>0)
				$p .= "Неустрашимые";
			else
				$p .= "<B>!!!ERROR NUM=11 - Param1 должен быть больше 0";
		}
		else
		if($num==12)
		{
			if($param1>0)
				$p .= "Неподкупные";
			else
				$p .= "<B>!!!ERROR NUM=12 - Param1 должен быть больше 0";
		}
		else
		if($num==13)
		{
			if($param1>0)
				$p .= "Найм местного населения провинции";
			else
				$p .= "<B>!!!ERROR NUM=13 - Param1 должен быть больше 0";
		}
		else
		if($num==14)
		{
			$p .= "Не может быть установлен в родовой провинции";
		}
		else
			$p .= ($num==0 ? "" : "<B>!!!ERROR!!! NUM=".$num);
		$p .= "</font></B>";
		$p .= (($abil[$i][$j+1]['num']!="") ? "<br>" : "");
	}
	if(isset($def_add[$i]))
	{
		if($p != "</font></B>")
			$p .= "<br>";
		for($k=0;$k<count($def_add[$i]);$k++)
		{
			$p .= $n++.") ".$def_add[$i][$k]."</font></B><br>";
		}
		$p = substr($p,0,-4);
	}
	$def_abil[$i]=substr($p,0,-11);
	$p="";
}

//вывод полной таблицы
echo "<table border=1>";
$def_build[64] = "Башня Воскрешения; "; //для Небесной стражи :(
for($i=1;$i<$max+1;$i++)
{
	echo "<tr><td align=center>$i</td><td></td><td>$name_table[$i]</td><td align=center>$Power[$i]";
	echo "</td><td align=center>$GoldCost[$i]</td><td align=center>$GemGost[$i]</td><td align=center>$GoldPayment[$i]";
	echo "</td><td align=center>$GemPayment[$i]</td><td align=center>$Initiative[$i]</td><td></td>";
	echo "<td align=center>$NoDismiss[$i]</td><td>$def_terrain[$i]</td><td>$def_res[$i]</td><td>";
	echo substr($def_build[$i],0,-2)."</td>".(in_array($i,$def_no2) ? "<td align=center>" : "<td>");
	echo "$def_unit[$i]</td><td>$def_abil[$i]</td><td>";
	echo str_replace("~","%",$def_txt[$i])."</td></tr>";
}

echo "</table><br>";

//вывод спойлера о карме и расширенное описание
$f=fopen("Defender_spoil.txt","w") or die("Ошибка при создании файла Defender_spoil.txt");
for($i = 0; $i < $count_def_txt; $i++)
{
//	if($karma_flag[$i] != 0)
	if(isset($def_txt_idx2[$i]))
	{
		$idx = $def_txt_idx2[$i];
		fwrite($f,"#");
		fwrite($f,"[Инициатива: ".$Initiative[$idx]."]\n");
		if($karma_flag[$i] != 0)
			fwrite($f,"[Карма: ".($karma_flag[$i] > 0 ? "+" : "").$karma_flag[$i]."]\n");
		fwrite($f,"[".$def_unit2[$idx]."]\n\n".substr($def_txt_file[$i],1));
	}
	else
		fwrite($f,$def_txt_file[$i]);
}
fclose($f);

?>
<style>
td
{mso-number-format:"\@";}
</style>
<?php
//вывод разноцветной кармы
echo "<table width=100% border=1>";
for($i=1;$i<$max+1;$i++)
{
	echo "<tr><td>$i ($name_table[$i])</td><td align=center>";
	if($Karma[$i]>0)
		echo "<font color=\"green\">+".$Karma[$i]."</font>";
	else
	if($Karma[$i]<0)
		echo "<font color=\"red\">".$Karma[$i]."</font></td></tr>";
	echo "</td></tr>";
}

?>
<br><a href='index.html'>вернуться к списку файлов</a>
</html>