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
$a_file = file("province_type.var");
$count_f = count($a_file);
$d_file = file("dialog.var");
$count_d = count($d_file);
$e_file = file("encounter.var");
$count_e = count($e_file);
$event_file = file("event.var");
$count_event = count($event_file);
$g_file = file("guard_type.var");
$count_g = count($g_file);
$race_file = file("race.var");
$count_race = count($race_file);

$res_name=array(1=>"Железо", "Красное дерево", "Кони", "Мандрагора", "Арканит", "Мрамор", "Мифрил", "Дионий", "Чёрный лотос");
$terrain_name=array("Равнины","Леса","Холмы","Болота","Пустыни","Тундра");
$max=0;$max1=0;$max_u=0;$max_e=0;$t[0]=0;$j=0;
$u1=-1;$u2=0;$u3=0;	//№ строки юнита в xls
$g1=0; //кол-во стражей в одном сайте
$a1=0; //№ абилки
$a2=0; //№ эффекта ritual
$e1=0; //№ эффекта
$up1=0; //число upg_type в unit_upg
$u_a=0; //абилки in unit.var
$p=""; //для печати без последней ";"

//Разбор dialog.var
for($i = 0,$n=0; $i < $count_d; $i++)
{  
	if(eregi("^/([0-9]{1,})",$d_file[$i],$k))
    {
		$n=$k[1];
		$s=substr($d_file[$i],log10($n)+3);
//echo $n."-".$s."<br>";
		$dialog_table[$n]=trim($s);
// echo $d_file[$i]."<br>".$k[0]."-".$k[1]."--".$dialog_table[$n]."<br>";
    }
	else
	if(eregi("^Text:",$d_file[$i]))
	{
		$s=explode('Text:',$d_file[$i]);
		$s1=trim($s[1]);
		$dialog_text_idx[$n] = $i;//в какую строку добавлять спойлеры о карме/коррупции
		(substr($s1,-1,1)=="#") ? $dialog_text[$n]=$dialog_text[$n].substr($s1,1,-1) : $dialog_text[$n]=$dialog_text[$n].substr($s1,1);
//		if((!eregi("^Число ",$d_file[$i+1])) || (!eregi("^Количество ",$d_file[$i+1])))
//			$dialog_text[$n]=$dialog_text[$n]."<br>";
		for($j=0;!eregi("^Answer",$d_file[$i+1]) && ($j<8);$j++)
		{
			$i++;
			$s1=trim($d_file[$i]);
			if((eregi("^Число ",$s1)) || (eregi("^Количество ",$s1))) 
				break; //не надо "Число врагов" и ниже
//			(substr($s1,-1,1)=="#") ? $dialog_text[$n]=$dialog_text[$n].substr($s1,0,-1) : $dialog_text[$n]=$dialog_text[$n].$s1."<br>";
			(substr($s1,-1,1)=="#") ? $dialog_text[$n]=$dialog_text[$n].substr($s1,0,-1) : $dialog_text[$n]=$dialog_text[$n].$s1." ";
		}
//echo $n."-".$dialog_text[$n]."<br>";	
	}
	else
	if(eregi("^Answer",$d_file[$i]))
	{
		$ans_idx[$n][] = $i;//в какую строку добавлять спойлеры о карме/коррупции
	}
}
$dialog_text[0]="";

//Разбор encounter.var
for($i = 0,$n=0; $i < $count_e; $i++)
{  
   if(eregi("^/([0-9]{1,})",$e_file[$i],$k))
    {
		$n=$k[1];
		$s=substr($e_file[$i],log10($n)+3);
//echo $n."-".$s."<br>";
		$enc_table[$n]=trim($s);
// echo $e_file[$i]."<br>".$k[0]."-".$k[1]."--".$dialog_table[$n]."<br>";
    }
}

//Разбор event.var
for($i = 0,$n=0; $i < $count_event; $i++)
{  
	if(eregi("^/([0-9]{1,})",$event_file[$i],$k))
	{
		$n=$k[1];
		if($n>$max_e)$max_e=$n;
		$s=substr($event_file[$i],log10($n)+3);
//echo $n."-".$s."<br>";
		$event_table[$n]=trim($s);
		if($event_table[$n][0]=='(')
			$event_table2[$n]=substr($event_table[$n],1,-1);
		else
			$event_table2[$n]=$event_table[$n];
// echo $e_file[$i]."<br>".$k[0]."-".$k[1]."--".$dialog_table[$n]."<br>";
	}
	else
	if(eregi("^Dialog:",$event_file[$i]))
	{
		$s=explode(':',$event_file[$i]);
		$event_dialog[$n]=$s[1]+1-1;
	}	
	else
	if(eregi("^Karma:",$event_file[$i]))
	{
		$s=explode(':',$event_file[$i]);
		if(($s[1]+1-1) != 0)
		{
			$event_karma_all_min[$n] += $s[1];//общая карма события для спойлера (min/max)
			$event_karma_all_max[$n] += $s[1];
		}
	}	
	else
	if(eregi("^\*Answers\*:",$event_file[$i]))
	{
		while(1)
			if(trim($event_file[$i+1]) == "") //пустая строка
				$i++;
			else
				break;
		for($j=0;(eregi("^Answer",$event_file[$i+1])) && ($j<8);$j++)
		{
			$i++;
			$s=explode(':',$event_file[$i]);
			$event_answer[$n][$j]=$s[1]+1-1;
		}
	}	
	else
	if(eregi("^\*Effects\*:",$event_file[$i]))
	{
		for($j=0;$j<16;$j++) //четвёрки эффектов
		{
			while(1)
				if(trim($event_file[$i+1]) == "") //пустая строка
					$i++;
				else
					break;
			$i++;
			$s=explode(':',$event_file[$i]);
			$event_effects[$n][$j]['num']=$s[1];
			$num = $s[1]+1-1;
			while(1)
				if(trim($event_file[$i+1]) == "") //пустая строка
					$i++;
				else
					break;
			$i++;
			$s=explode(':',$event_file[$i]);
			$power = $event_effects[$n][$j]['power']=$s[1]+1-1;
			//echo "-".$s[1];
			while(1)
				if(trim($event_file[$i+1]) == "") //пустая строка
					$i++;
				else
					break;
			$i++;
			$s=explode(':',$event_file[$i]);
			$param1 = $event_effects[$n][$j]['param1']=$s[1]+1-1;
			while(1)
				if(trim($event_file[$i+1]) == "") //пустая строка
					$i++;
				else
					break;
			$i++;
			$s=explode(':',$event_file[$i]);
			$param2 = $event_effects[$n][$j]['param2']=$s[1]+1-1;
			if($num==2)// Изменение отношения на Power
			{
				$event_unrest_all[$n] += $power;//общее отношение населения в событии для спойлера
			}
			else
			if($num==3)//Изменение количества населения на Power+Random(Param1)%
			{
				if($param1 == 0)
					$event_qua_all_min[$n] = $event_corr_all_max[$n] = $power;//общее количество населения в событии для спойлера (min/max)
				else
				{
					$event_qua_all_min[$n] = $power;
					$event_qua_all_max[$n] = $param1+$power;
				}
			}
			else
			if($num==7)//Карма = Power+Random(Param1)
			{
				if($param1 == 0)
				{
					$event_karma_all_min[$n] += $power;//общая карма события для спойлера (min/max)
					$event_karma_all_max[$n] += $power;
				}
				else
				{
					$event_karma_all_min[$n] += $power;
					$event_karma_all_max[$n] += $param1+$power-1;
				}
			}
			else
			if($num==22)//Изменить коррупцию на Power+Random(Param1)
			{
				if($param1 == 0)
					$event_corr_all_min[$n] = $event_corr_all_max[$n] = $power;//общая коррупция события для спойлера (min/max)
				else
				{
					$event_corr_all_min[$n] = $power;
//					$event_corr_all_max[$n] = $param1+$power-1;
					$event_corr_all_max[$n] = $param1+$power;
				}
			}
			$i++; //пустая строка
			if(substr(trim($event_file[$i-1]),-1,1)==";") 
			{
				break; //for $j
			}
		}
	}
}
/*
dumper($event_karma_all_min,"event_karma_all_min");
dumper($event_karma_all_max,"event_karma_all_max");
dumper($event_corr_all_min,"event_corr_all_min");
dumper($event_corr_all_max,"event_corr_all_max");
*/

//Разбор guard_type
for($i = 0,$n=0; $i < $count_g; $i++)
{  
	if(eregi("^/([0-9]{1,})",$g_file[$i],$k))
    {
		$n=$k[1];
//     if($n>$max1)$max1=$n;
    }
    else
    if(eregi("^name",$g_file[$i]))
    {
		$s=explode(':',$g_file[$i]);
		$s=substr(trim($s[1]),0,-1);
		while(in_array($s,$g_name))
		{
			echo $n."- Дубль guard_type=".$s;
			$s = $s."<font color=\"fuchsia\">*</font>";
			echo " <B>Замена на</B> ".$s."<br>";
		}
		$g_name[$n]=$s; //$g_name[] - guard_type
		if($n==0) $g_name[$n]="-";
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
		$race_table[$n]=substr(trim($s[1]),0,-1);
		if($n==0) $race_table[$n]="-";
    }
}

//-------------------------------------------------------------
//Разбор основного файла
for($i = 0,$n=0; $i < $count_f; $i++)
{  //echo "<br>".$a_file[$i];
/*    if(eregi("^[a-z]",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		for($j=1;($j<=$t[0])&&($t[$j]!=$s[0]);$j++);
			if($j>$t[0])
			{
				$t[$j]=$s[0];
				$t[0]+=1;
			}
//echo $j,$t[0];
		$res[$n][$s[0]]=$s[1];
    }
*/
	if(eregi("^/([0-9]{1,})",$a_file[$i],$k))
    {
		$n=$k[1];
		if($n>$max)$max=$n;
		$rep[$n]['yes']='Ok';
		$s=substr($a_file[$i],log10($n)+3);
//echo $n."-".$s."<br>";
//echo "<br>".$k[1]."! $n  ! $max !!"; 
		$u1++;	//№ строки
    }
    else
    if(eregi("^name",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$s1=substr(trim($s[1]),0,-1);
		if(in_array($s1,$name_table))
			echo $n."- Дубль NAME=".$s1."<br>";
		$name_table[$n]=$s1;
    }
    else
    if(eregi("^Plain",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$terrain[$n][0]=$s[1]+1-1;
//echo $n."-".$terrain[$n][0]."<br>";
//echo $n."-".substr($terrain[$n][0],9);
    }
    else
    if(eregi("^Forest",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$terrain[$n][1]=$s[1]+1-1;
    }
    else
    if(eregi("^Hill",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$terrain[$n][2]=$s[1]+1-1;
    }
    else
    if(eregi("^Swamp",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$terrain[$n][3]=$s[1]+1-1;
    }
    else
    if(eregi("^Desert",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$terrain[$n][4]=$s[1]+1-1;
    }
	else
    if(eregi("^Tundra",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$terrain[$n][5]=$s[1]+1-1;
    }
    else
    if(eregi("^Race:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$Race[$n]=$race_table[$s[1]+1-1];
    }
    else
    if(eregi("^Sites:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$Sites[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^Gold:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$Gold[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^Gem:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$Gem[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^Difficult:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$Difficult[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^Population:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$Population[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^LevelPop:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$LevelPop[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^DiplUnrest:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$DiplUnrest[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^ConqUnrest:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$ConqUnrest[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^DiplKarma:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$DiplKarma[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^ConqKarma:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$ConqKarma[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^Explored:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$Explored[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^LevelExplored:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$LevelExplored[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^Guard:",$a_file[$i]))
    {
		while(1)
			if(trim($a_file[$i+1]) == "") //пустая строка
				$i++;
			else
				break;
		$s=explode(':',$a_file[$i]);
		$g_table[$n][$g1]=$g_name[$s[1]+1-1];
		while(1)
			if(trim($a_file[$i+1]) == "") //пустая строка
				$i++;
			else
				break;
		$i++;
		$s=explode(':',$a_file[$i]);
		$g_poss[$n][$g1]=$s[1]+1-1;
		while(1)
			if(trim($a_file[$i+1]) == "") //пустая строка
				$i++;
			else
				break;
		$i++;
		$s=explode(':',$a_file[$i]);
		$g_dialog[$n][$g1]=$s[1]+1-1;
		if($DiplKarma[$n] != 0)
			$karma_dipl_flag[$dialog_text_idx[$s[1]+1-1]] = $DiplKarma[$n];//№ строки в dialog.var, куда надо вставить спойлер о карме
		if($ConqKarma[$n] != 0)
			$karma_conq_flag[$dialog_text_idx[$s[1]+1-1]] = $ConqKarma[$n];//№ строки в dialog.var, куда надо вставить спойлер о карме
		if($DiplUnrest[$n] != 0)
			$unrest_dipl_flag[$dialog_text_idx[$s[1]+1-1]] = $DiplUnrest[$n];//№ строки в dialog.var, куда надо вставить спойлер о настроении
		if($ConqUnrest[$n] != 0)
			$unrest_conq_flag[$dialog_text_idx[$s[1]+1-1]] = $ConqUnrest[$n];//№ строки в dialog.var, куда надо вставить спойлер о настроении
		while(1)
			if(trim($a_file[$i+1]) == "") //пустая строка
				$i++;
			else
				break;
		$i++;
		$s=explode(':',$a_file[$i]);
		$g_enc[$n][$g1]=$s[1]+1-1;
		$i++;
// echo $n."-".$g_table[$n][$g1]."<br>";
		$g1++;
    }
    else
    if(eregi("^Event:",$a_file[$i]))
    {
		while(1)
			if(trim($a_file[$i+1]) == "") //пустая строка
				$i++;
			else
				break;
		$s=explode(':',$a_file[$i]);
		$e_table[$n][$e1]=$s[1];
		while(1)
			if(trim($a_file[$i+1]) == "") //пустая строка
				$i++;
			else
				break;
		$i++;
		$s=explode(':',$a_file[$i]);
		$e_poss[$n][$e1]=$s[1]+1-1;
		$i++;
//echo $n."-EVENT=".$e_table[$n][$e1]." POSS=".$e_poss[$n][$e1]." e1=".$e1."<br>";
		$e1++;
    }
}
//dumper($karma_dipl_flag,"karma_dipl_flag");
//dumper($karma_conq_flag,"karma_conq_flag");

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


echo "<table width=100% border=1><tr><td>№</td><td colspan=20>Units</td></tr>";

*/

//охрана провинций
for($i=0,$j=0;$i<$max+1;$i++)
{ 
//	echo "<tr><td>$i</td><td>";
	for($n=1;($g_table[$i][$j]!="")&&($j<10000);$j++,$n++)
	{
//		echo ($g_table[$i][$j+1]!="") ? $g_table[$i][$j]."; " : $g_table[$i][$j];
/*
		echo (($g_table[$i][$j+1]!="") ? $n.") " : "");
		echo $g_table[$i][$j];
		echo "</td><td>";
		echo (($g_table[$i][$j+1]!="") ? $n.") " : "");
		echo $g_poss[$i][$j];
		echo "</td><td>";
		echo (($g_table[$i][$j+1]!="") ? $n.") " : "");
		echo $dialog_text[$g_dialog[$i][$j]];
		echo "</td><td>";
		echo (($g_table[$i][$j+1]!="") ? $n.") " : "");
		echo $g_enc[$i][$j]." (".$enc_table[$g_enc[$i][$j]].")";
		echo "</td><td>";

		if($g_table[$i][$j+1]!="")
			$num=$n.") ";
		else
			$num="";
*/
		if($g_table[$i][$j+1]!="") $fl=1; //флаг нескольких стражей
		if($fl==1)
			$num=$n.") ";
		else
			$num="";
		$p[1]=$p[1].$num.$g_table[$i][$j]."<br>";
		$p[2]=$p[2].$num.(($g_poss[$i][$j]==0) ? "" : "<B><font color=\"blue\">".$g_poss[$i][$j]."</font></B>")."<br>";
		$p[3]=$p[3].(($num=="") ? "" : "<B><font color=\"blue\">$n</font></B>) ").$dialog_text[$g_dialog[$i][$j]]."<br>";
		$p[4]=$p[4].$num."<B>".(($g_enc[$i][$j]!=0) ? $g_enc[$i][$j]."</B> (".$enc_table[$g_enc[$i][$j]].")" : "-</B>")."<br>";
//    echo $g_name[$i][$j]." (ур. ".$u_lvl2[$i][$j].");";
	}
	$fl=0;
	for($k=1;$k<=4;$k++)
	{
		$prov_guard[$i] .= substr($p[$k],0,strlen($p[$k])-4)."</td><td>";
//		echo "</td><td>";
		$p[$k]="";
	}
	$prov_guard[$i] = substr($prov_guard[$i],0,-4);
//	echo "</td></tr>";
}

//echo "</table>";
//echo "<table width=100% border=1>";
//события в провинции
for($i=0,$j=0;$i<$max+1;$i++)
{ 
//	echo "<tr><td>$i</td><td>";
	for($n=1;($e_table[$i][$j]!="")&&($j<10000);$j++,$n++)
	{
		if($e_table[$i][$j+1]!="") $fl=1; //флаг нескольких стражей
		if($fl==1)
			$num=$n.") ";
		else
			$num="";
		$p[1]=$p[1].$num.((($e_table[$i][$j]+1-1)!=0) ? "<B>".($e_table[$i][$j]+1-1)."</B> (".$event_table2[$e_table[$i][$j]+1-1].")" : "")."<br>";
		$p[2]=$p[2].$num.(($e_poss[$i][$j]==0) ? "" : "<B><font color=\"blue\">".$e_poss[$i][$j]."</font></B>")."<br>";
	}
	$fl=0;
	for($k=1;$k<=2;$k++)
	{
		$prov_event[$i] .=  substr($p[$k],0,strlen($p[$k])-4)."</td><td>";
//		echo "</td><td>";
		$p[$k]="";
	}
	$prov_event[$i] = substr($prov_event[$i],0,-4);
//	echo "</td></tr>";
}

//местность сайтов
for($i=0;$i<$max+1;$i++)
{
//	echo "<tr><td>$i</td><td>";
	for($j=0;$j<4;$j++)
	{ 
		if($terrain[$i][$j]!=0)
//			echo "<a href=\"www\">".rtrim($terrain[$i][$j])."</a>;";
			$p=$p.$terrain_name[$j].": <B><font color=\"blue\">".$terrain[$i][$j]."</font></B>;<br>";
	}
	$prov_terrain[$i] .=  substr($p,0,strlen($p)-5);
	$p="";
//	echo "</td></tr>";
}

//вывод полной таблицы
echo "<table border=1>";

for($i=1;$i<$max+1;$i++)
{
	echo "<tr><td align=center>$i</td><td>$name_table[$i]</td><td>$Race[$i]</td><td></td><td></td><td align=center>";
	echo "$Sites[$i]</td><td align=center>$Difficult[$i]</td><td align=center>$Population[$i]</td><td align=center>$LevelPop[$i]</td><td>";
	echo "</td><td></td><td></td><td></td><td align=center>$Explored[$i]</td><td align=center>$LevelExplored[$i]</td>";
	echo "<td class=right>$prov_terrain[$i]</td><td>$prov_guard[$i]</td><td class=left>$prov_event[$i]</td></tr>";
}

echo "</table><br>";
?>
<style>
td
{mso-number-format:"\@";}
</style>
<?php
//вывод разноцветной фигни
echo "<table border=1>";
echo "<tr><td></td><td>Золото</td><td>Кристаллы</td><td>DiplUnrest</td><td>ConqUnrest</td><td>DiplKarma</td><td>ConqKarma</td></tr>";

for($i=1;$i<$max+1;$i++)
{
	if($Gold[$i]!=0)
	{
		if($Gold[$i]>0)
			$prov_gold[$i] .= "<font color=\"green\">+";
		else
		if($Gold[$i]<0)
			$prov_gold[$i] .= "<font color=\"red\">";
		$prov_gold[$i] .= $Gold[$i]."</font>";
	}
	if($Gem[$i]!=0)
	{
		if($Gem[$i]>0)
			$prov_gem[$i] .= "<font color=\"green\">+";
		else
		if($Gem[$i]<0)
			$prov_gem[$i] .= "<font color=\"red\">";
		$prov_gem[$i] .= $Gem[$i]."</font>";
	}
	if($DiplUnrest[$i]!=0)
	{
		if($DiplUnrest[$i]>0)
			$prov_DiplUnrest[$i] .= "<font color=\"green\">+";
		else
		if($DiplUnrest[$i]<0)
			$prov_DiplUnrest[$i] .= "<font color=\"red\">";
		$prov_DiplUnrest[$i] .= $DiplUnrest[$i]."</font>";
	}
	if($ConqUnrest[$i]!=0)
	{
		if($ConqUnrest[$i]>0)
			$prov_ConqUnrest[$i] .= "<font color=\"green\">+";
		else
		if($ConqUnrest[$i]<0)
			$prov_ConqUnrest[$i] .= "<font color=\"red\">";
		$prov_ConqUnrest[$i] .= $ConqUnrest[$i]."</font>";
	}
	if($DiplKarma[$i]!=0)
	{
		if($DiplKarma[$i]>0)
			$prov_DiplKarma[$i] .= "<font color=\"green\">+";
		else
		if($DiplKarma[$i]<0)
			$prov_DiplKarma[$i] .= "<font color=\"red\">";
		$prov_DiplKarma[$i] .= $DiplKarma[$i]."</font>";
	}
	if($ConqKarma[$i]!=0)
	{
		if($ConqKarma[$i]>0)
			$prov_ConqKarma[$i] .= "<font color=\"green\">+";
		else
		if($ConqKarma[$i]<0)
			$prov_ConqKarma[$i] .= "<font color=\"red\">";
		$prov_ConqKarma[$i] .= $ConqKarma[$i]."</font>";
	}
	echo "<tr><td>$i ($name_table[$i])</td><td align=center>$prov_gold[$i]</td><td align=center>$prov_gem[$i]</td>";
	echo "<td align=center>$prov_DiplUnrest[$i]</td><td align=center>$prov_ConqUnrest[$i]</td>";
	echo "<td align=center>$prov_DiplKarma[$i]</td><td align=center>$prov_ConqUnrest[$i]</td></tr>";
}

//вставка спойлеров о карме и коррупции в ответы событий
for($i = 1; $i < $max_e; $i++)
{
	for($j=0; $j<count($event_answer[$i]); $j++)
	{
		$ans = $event_answer[$i][$j];//event от текущего ответа
		$dlg = $event_dialog[$ans];//диалог от event от текущего ответа
		$idx = $ans_idx[$event_dialog[$i]][$j];//строка ответа диалога текущего event
		if($event_unrest_all[$ans] > 0)//ненулевое отношение провинции
			$ins_unrest[$idx] = "+".$event_unrest_all[$ans];
		else
		if($event_unrest_all[$ans] < 0)
			$ins_unrest[$idx] = $event_unrest_all[$ans];//строка в ответах для спойлера
		$k_min = $event_karma_all_min[$ans];
		$k_max = $event_karma_all_max[$ans];
		$c_min = $event_corr_all_min[$ans];
		$c_max = $event_corr_all_max[$ans];
		$q_min = $event_qua_all_min[$ans];
		$q_max = $event_qua_all_max[$ans];
		if($k_min != 0 || $k_max != 0)//ненулевая карма
		{
			if($dlg != 0)
			{
				if((isset($dialog_test_min[$dlg])) || (isset($dialog_test_max[$dlg])))
				{
					if(($dialog_test_min[$dlg] != $k_min) || ($dialog_test_max[$dlg] != $k_max))
						echo "!!! разная карма у одного диалога: $event_dialog[$ans]<br>";
				}
				else
				{
					$dialog_test_min[$dlg] = $k_min;
					$dialog_test_max[$dlg] = $k_max;
				}
			}
//			if(isset($ins_karma[$idx])) echo "Event: $i Dlg: $event_dialog[$i] Karma: $k_min $k_max<br>";
			if($k_min == $k_max)
				$ins_karma[$idx] = ($k_min >= 0) ? "+".$k_max : $k_max;//строка в ответах для спойлера
			else
				$ins_karma[$idx] = ($k_min >= 0) ? "+(".$k_min."-".$k_max.")" : "-(".abs($k_max)."-".abs($k_min).")";
		}
		if($c_min != 0 || $c_max != 0)//ненулевая коррупция
		{
			if($c_min == $c_max)
				$ins_corr[$idx] = ($c_min >= 0) ? "+".$c_max : $c_max;//строка в ответах для спойлера
			else
				$ins_corr[$idx] = ($c_min >= 0) ? "+(".$c_min."-".$c_max.")" : "-(".abs($c_max)."-".abs($c_min).")";
		}
		if($q_min != 0 || $q_max != 0)//ненулевое кол-во население
		{
			if($q_min == $q_max)
				$ins_qua[$idx] = ($q_min >= 0) ? "+".$q_max : $q_max;//строка в ответах для спойлера
			else
				$ins_qua[$idx] = ($q_min >= 0) ? "+(".$q_min."-".$q_max.")" : "-(".abs($q_max)."-".abs($q_min).")";
		}
	}
}
//dumper($ins_karma,"ins_karma");
//dumper($ins_corr,"ins_corr");
//ринять закон. Наказание за воровство - казнь.[-4]<-(3-5)
//
//вывод спойлеров о карме и коррупции
$f=fopen("dialog_spoil.var","w") or die("Ошибка при создании файла dialog_spoil.var");
for($i = 0; $i < $count_d; $i++)
{
	$p = "";
	if(isset($ins_karma[$i]) || isset($ins_corr[$i]) || isset($ins_unrest[$i]) || isset($ins_qua[$i]))
	{
		if(substr(trim($d_file[$i]),-1) == "#")
			$p = substr(trim($d_file[$i]),0,-6);
		else
			$p = substr(trim($d_file[$i]),0,-1);
		$p .= "{";
		if(isset($ins_karma[$i]))
		{
			$p .= $ins_karma[$i]."K|";
		}
		if(isset($ins_corr[$i]))
		{
			$p .= $ins_corr[$i]."C|";
		}
		if(isset($ins_unrest[$i]))
		{
			$p .= $ins_unrest[$i]."U|";
		}
		if(isset($ins_qua[$i]))
		{
			$p .= $ins_qua[$i]."%Q|";
		}
		$p = substr($p,0,-1)."};";
		if(substr(trim($d_file[$i]),-1) == "#")
			$p .= "#####";
		$p .= "\n";
	}
	if($p != "")
	{
		if(substr(trim($p),-1) == "#")
		{
			if(strlen(trim($p)) > 71)
				echo "!!! Слишком длинный answer: $i(".strlen(trim($p)).") - $p<br>";
		}
		else
		{
			if(strlen(trim($p)) > 66)
				echo "!!! Слишком длинный answer: $i(".strlen(trim($p)).") - $p<br>";
		}
	}
/*	
	if($karma_dipl_flag[$i] != 0 && $karma_conq_flag[$i] != 0)
	{
		$p .= "Text: #{Карма при дипломатии: ";
		$p .= ($karma_dipl_flag[$i] > 0 ? "+" : "").$karma_dipl_flag[$i]."}\n";
		$p .= "{Карма при атаке: ";
		$p .= ($karma_conq_flag[$i] > 0 ? "+" : "").$karma_conq_flag[$i]."}\n";
		$p .= substr($d_file[$i],7);
	}
	else
*/	
	$p1 = "";
	$text_flag = 0;//флаг, что в поле "Text:" добавлены спойлеры

/*	
	if($karma_dipl_flag[$i] != 0 || $karma_conq_flag[$i] != 0)
	{
		$p = "Text: #";
		$text_flag = 1;//флаг, что в поле "Text:" добавлены спойлеры
	}
*/	
	if($karma_dipl_flag[$i] != 0)
	{
		$text_flag = 1;//флаг, что в поле "Text:" добавлены спойлеры
		$p1 .= "{Карма при дипломатии: ".($karma_dipl_flag[$i] > 0 ? "+" : "").$karma_dipl_flag[$i]."}\n";
	}
	if($karma_conq_flag[$i] != 0)
	{
		$text_flag = 1;//флаг, что в поле "Text:" добавлены спойлеры
		$p1 .= "{Карма при атаке: ".($karma_conq_flag[$i] > 0 ? "+" : "").$karma_conq_flag[$i]."}\n";
	}
	if($text_flag == 1)
		$p = "Text: #".$p1.substr($d_file[$i],7);
	if($p == "")
		fwrite($f,$d_file[$i]);
	else
		fwrite($f,$p);
}
fclose($f);


?>
<br><a href='index.html'>вернуться к списку файлов</a>
</html>