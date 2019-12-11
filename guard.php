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
$a_file = file("guard.var");
$count_f = count($a_file);
$u_file = file("unit.var");
$count_u = count($u_file);
$g_file = file("guard_type.var");
$count_g = count($g_file);
$prov_file = file("province_type.var");
$site_file = file("site.var");
$guard_event_file = file("guard_event.exp");
$guard_enc_file = file("guard_enc.exp");

require_once "dumper.php";

$max=0;$max1=0;$max_u=0;$max_e=0;$t[0]=0;$j=0;
$u1=-1;$u2=0;$u3=0;	//№ строки юнита в xls
$g1=0; //кол-во стражей в одном сайте
$a1=0; //№ абилки
$a2=0; //№ эффекта ritual
$e1=0; //№ эффекта
$up1=0; //число upg_type в unit_upg
$u_a=0; //абилки in unit.var
$p=""; //для печати без последней ";"
$error_param=array("Item");//проверка на ошибки в var

//разбор guard_event.exp
for($i = 0; $i < count($guard_event_file); $i++)
{
	$str = trim($guard_event_file[$i]);
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
			$EventGroupName[$s[1]] = $s[2];//имя группы событий с атакующим отрядом
		}
	}
}

foreach($export_guard_event as $guard => $ev)
{
	foreach($ev as $i)
	{
		$guard_event[$guard][] = "<font color=\"red\"><B>Атакующий отряд</B></font> в <B>группе событий (group_event) <font color=\"blue\">$i (".$EventGroupName[$i].")</font></B>";
	}
}

//разбор guard_enc.exp
for($i = 0; $i < count($guard_enc_file); $i++)
{
	$str = trim($guard_enc_file[$i]);
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
			$EncGroupName[$s[1]] = $s[2];//имя группы приключений с атакующим отрядом
		}
	}
}

foreach($export_guard_enc as $guard => $ev)
{
	foreach($ev as $i)
	{
		$guard_enc[$guard][] = "<font color=\"red\"><B>Атакующий отряд</B></font> в <B>группе приключений (group_enc) <font color=\"blue\">$i (".$EncGroupName[$i].")</font></B>";
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

//Разбор province_type.var
for($i = 0,$n=0; $i < count($prov_file); $i++)
{  
	if(eregi("^/([0-9]{1,})",$prov_file[$i],$k))
	{
		$n=$k[1];
	}
	else
	if(eregi("^name",$prov_file[$i]))
	{
		$s=explode(':',$prov_file[$i]);
		$prov_name[$n]=substr(trim($s[1]),0,-1);
	}
	else
	if(eregi("^Guard:",$prov_file[$i]))
	{
		$s=explode(':',$prov_file[$i]);
		$guard_prov[$s[1]+1-1][] = $n;//типы провинций и их охранники
		while(1)
			if(trim($prov_file[$i+1]) == "") //пустая строка
				$i++;
			else
				break;
		$i++;
		$s1=explode(':',$prov_file[$i]);
		$guard_prov_poss[$s[1]+1-1][] = $s1[1]+1-1;//вероятность появления
		$i++;
	}
}
//dumper($guard_prov,"guard_prov");

//Разбор site.var
for($i = 0,$n=0; $i < count($site_file); $i++)
{  
   if(eregi("^/([0-9]{1,})",$site_file[$i],$k))
    {
		$n=$k[1];
		if($n>$max_site)$max_site=$n;
    }
    else
    if(eregi("^name",$site_file[$i]))
    {
		$s=explode(':',$site_file[$i]);
		if($n==51)
			$site_name[$n]="Гильдия воров <font color=\"fuchsia\">(в законе)</font>";
		else
		if($n==53)
			$site_name[$n]="Команда авантюристов";
		else
		if($n==56)
			$site_name[$n]="Тролли";
		else
		if($n==57)
			$site_name[$n]="Хутор половинчиков <font color=\"fuchsia\">(+3)</font>";
		else
		if($n==58)
			$site_name[$n]="Хутор половинчиков <font color=\"fuchsia\">(+1)</font>";
		else
		if($n==60)
			$site_name[$n]="Торговец редкостями";
/*
		else
		if($n==79)
			$name_table[$n]="Цитадель дроу <font color=\"fuchsia\">(Ку'Ксорларин)</font>";
		else
		if($n==80)
			$name_table[$n]="Цитадель дроу <font color=\"fuchsia\">(Х'Тисет)</font>";
*/
		else
		{
			$s=substr(trim($s[1]),0,-1);
			while(in_array($s,$site_name))
			{
//				echo $n."- Дубль SITE=".$s;
				$s = $s."<font color=\"fuchsia\">*</font>";
//				echo " <B>Замена на</B> ".$s."<br>";
			}
			$site_name[$n]=$s;
		}
    }
	else
	if(eregi("^Guard:",$site_file[$i]))
	{
		$s=explode(':',$site_file[$i]);
		$guard_site[$s[1]+1-1][] = $n;//сайты и их охранники
		while(1)
			if(trim($site_file[$i+1]) == "") //пустая строка
				$i++;
			else
				break;
		$i++;
		$s1=explode(':',$site_file[$i]);
		$guard_site_poss[$s[1]+1-1][] = $s1[1]+1-1;//вероятность появления
		$i++;
	}
}
//dumper($guard_site,"guard_site");

//Разбор guard_type.var
for($i = 0,$n=0; $i < $count_g; $i++)
{  
	if(eregi("^/([0-9]{1,})",$g_file[$i],$k))
    {
		$n=$k[1];
		if($n>$max1)$max1=$n;
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
    }
    else
    if(eregi("^Power",$g_file[$i]))
    {
		$s=explode(':',$g_file[$i]);
		$g_power[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^Karma",$g_file[$i]))
    {
		$s=explode(':',$g_file[$i]);
		$g_karma[$n]=$s[1]+1-1;
		while(1)
			if(trim($g_file[$i+1]) == "") //пустая строка
				$i++;
			else
				break;
		$i++;
		for($j=0;$j<4;$j++)//Guard0-Guard3
		{
			$s=explode(':',$g_file[$i]);
			
			if($j==1)//для определения состоит охрана из 1 или 4 защитников
			{
				if(($s[1]+1-1)==$s1)
				{
//					$g_14[$s1]=1;//guard.var (1-400)
					$g_type_14[$n]=1;//guard_type.var (1-100)
				}
				else
				{
//					$g_14[$s1]=4;
					$g_type_14[$n]=4;
				}
			}

			$s1 = $s[1]+1-1;

			if($n!=0)
			{
				if(isset($g_14[$s1]))//для определения состоит охрана из 1 или 4 защитников
					$g_14[$s1]=1;//guard.var (1-400)
				else
					$g_14[$s1]=4;
			}

			$g_guard[$s1]=$g_name[$n];
			$g_power2[$s1]=$g_power[$n];//сила соответствующей охраны
			$g_karma2[$s1]=$g_karma[$n];//карма соответствующей охраны
			if(isset($guard_prov[$n]))//"Где можно встретить" - провинции
			{
				$p = "<B><font color=\"green\">Провинции типа</font></B> ";
				foreach($guard_prov[$n] as $idx => $prov)
				{
//					$p .= $prov_name[$prov]."(".$guard_prov_poss[$n][$idx]."); ";
					$p .= $prov_name[$prov]."; ";
				}
				$guard_prov_prn[$s1] = substr($p,0,-2);
			}
			if(isset($guard_site[$n]))//"Где можно встретить" - сайты
			{
				$p = "<B><font color=\"blue\">Сайты:</font></B> ";
				foreach($guard_site[$n] as $idx => $site)
				{
//					$p .= $site_name[$site]."(".$guard_site_poss[$n][$idx]."); ";
					$p .= $site_name[$site]."; ";
				}
				$guard_site_prn[$s1] = substr($p,0,-2);
			}
			if(isset($guard_event[$n]))//"Где можно встретить" - аттакеры в событиях
			{
//				$p = "<B><font color=\"blue\">Сайты:</font></B> ";
				$p = "";
				foreach($guard_event[$n] as $guard)
				{
					$p .= $guard."<br>";
				}
				$guard_event_prn[$s1] = substr($p,0,-4);
			}
			if(isset($guard_enc[$n]))//"Где можно встретить" - аттакеры в приключениях
			{
				$p = "";
				foreach($guard_enc[$n] as $guard)
				{
					$p .= $guard."<br>";
				}
				$guard_enc_prn[$s1] = substr($p,0,-4);
			}
			$i++;
		}
    }
	else
    if(trim($g_file[$i])!="")
    {
		echo $n."-UNKNOWN PARAM ".$g_file[$i]."<br>";
	}
}
//dumper($guard_prov_prn,"guard_prov_prn");

//-------------------------------------------------------------
//Разбор основного файла
for($i = 0,$n=0; $i < $count_f; $i++)
{  //echo "<br>".$a_file[$i];
/*
    if(eregi("^[a-z]",$a_file[$i]))
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
		$s=trim(substr($a_file[$i],log10($n)+3));
//echo $n."-".$s."<br>";
		while(in_array($s,$name1_table))
		{
			echo $n."- Дубль NAME=".$s;
			if(eregi("([0-3]$)",$s,$k))//если оканчивается на цифру
				$s = trim(substr($s,0,-1))."<font color=\"fuchsia\">*</font> ".$k[1];
			else
				$s = $s."<font color=\"fuchsia\">*</font>";
			echo " <B>Замена на</B> ".$s."<br>";
		}
		$name1_table[$n]=$s; //имя в формате "/0 Пусто "

//echo "<br>".$k[1]."! $n  ! $max !!"; 
		$u1++;	//№ строки
    }
    else
    if(eregi("^Quantity:",$a_file[$i])) //Quantity в guard.var
    {
		$s=explode(':',$a_file[$i]);
		$s1=explode('/',$s[1]);
		$guard_u_min[$n]=$s1[0]+1-1;
		$guard_u_max[$n]=$s1[1]+$guard_u_min[$n];
		$guard_u_minmax[$n]=$s1[1]+1-1;
//echo $n."-".$guard_u_min[$n]."--".$guard_u_max[$n]."<br>";
	}
    else
    if(eregi("^Initiative:",$a_file[$i])) //Initiative в guard.var
    {
		$s=explode(':',$a_file[$i]);
		$s1=explode('/',$s[1]);
		$guard_ini_min[$n]=$s1[0]+1-1;
		$guard_ini_max[$n]=$s1[1]+$guard_ini_min[$n];
//echo $n."-".$guard_ini_min[$n]."--".$guard_ini_max[$n]."<br>";
	}
    else
    if((eregi("^Unit",$a_file[$i]))&&(!eregi("^UnitKind",$a_file[$i])))
    {
		$s=explode(':',$a_file[$i]);
/*
		//     echo "<br>".$s[0]."-".$s[1]; 
		$re[$n][$u2]=explode(',',$s[1]);
//     echo $re[$n][$s[0]][0];
echo $n."-".($re[$n][$u2][3]+1-1)."<br>";
		if ($re[$n][$u2][2]!="0") //количество обязательных юнитов 
		{
			$u_table1[$u1][$u2]=$u_name[$re[$n][$u2][0]+1-1]; //обязательные юниты 
			$u_lvl1[$u1][$u2]=$re[$n][$u2][1];
			$u_cnt1[$u1][$u2]=$re[$n][$u2][2]+1-1;
			$u_qua[$n]+=$u_cnt1[$u1][$u2];
//echo $n."-".$u_qua[$n]."<br>";
//     echo "u1=".$u1." u2=".$u2." ".$u_table1[$u1][$u2]."<br>";
// echo "u1=".$u1." u2=".$u2." u_lvl1=".$u_lvl1[$u1][$u2]." u_cnt1=".$u_cnt1[$u1][$u2]." ".$u_table1[$u1][$u2]."<br>";
 //     $str_num[$u1]=count($u_table1[$u1]);
			$u2++;	
		}
//		if (substr(trim($re[$n][$u2][3]),0,1)!="0") //количество добавленных юнитов 
		if (($re[$n][$u2][3]+1-1)!=0) //количество добавленных юнитов 
		{
			$u_table2[$u1][$u3]=$u_name[$re[$n][$u2][0]+1-1]; //добавленные юниты 
			$u_lvl2[$u1][$u3]=$re[$n][$u2][1];
//     $u_cnt2[$u1][$u3]=$re[$n][$s[0]][3]+1-1;
// echo substr(trim($re[$n][$s[0]][3]),0,1)." u1=".$u1." u3=".$u3." u_lvl2=".$u_lvl2[$u1][$u3]." u_cnt2=".$u_cnt2[$u1][$u3]." ".$u_table2[$u1][$u3]."<br>";
			$u3++;	
		}
*/
		$s1=explode(',',$s[1]);
		if ($s1[2]!="0") //количество обязательных юнитов 
		{
			$u_table1[$u1][$u2]=$u_name[$s1[0]+1-1]; //обязательные юниты 
			$u_lvl1[$u1][$u2]=$s1[1];
			$u_cnt1[$u1][$u2]=$s1[2]+1-1;
			$u_qua[$n]+=$u_cnt1[$u1][$u2];
//echo $n."-".$u_qua[$n]."<br>";
//     echo "u1=".$u1." u2=".$u2." ".$u_table1[$u1][$u2]."<br>";
// echo "u1=".$u1." u2=".$u2." u_lvl1=".$u_lvl1[$u1][$u2]." u_cnt1=".$u_cnt1[$u1][$u2]." ".$u_table1[$u1][$u2]."<br>";
 //     $str_num[$u1]=count($u_table1[$u1]);
			$u2++;	
		}
//		if (substr(trim($re[$n][$u2][3]),0,1)!="0") //количество добавленных юнитов 
		if (($s1[3]+1-1)!=0) //количество добавленных юнитов 
		{
			$u_table2[$u1][$u3]=$u_name[$s1[0]+1-1]; //добавленные юниты 
			$u_lvl2[$u1][$u3]=$s1[1];
			$u_cnt2[$u1][$u3]=$s1[3]+1-1;
//     $u_cnt2[$u1][$u3]=$re[$n][$s[0]][3]+1-1;
// echo substr(trim($re[$n][$s[0]][3]),0,1)." u1=".$u1." u3=".$u3." u_lvl2=".$u_lvl2[$u1][$u3]." u_cnt2=".$u_cnt2[$u1][$u3]." ".$u_table2[$u1][$u3]."<br>";
			$u3++;	
		}
		$re[$n][$u2]['n']=count($re[$n][$u2]);
    }
    else
    if(eregi("^LootPoss:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$guard_poss[$n]=$s[1]+1-1;
	}
    else
    if(eregi("^MaxLoot:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$guard_maxloot[$n]=$s[1]+1-1;
	}
    else
    if(eregi("^Power:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$guard_power[$n]=$s[1]+1-1;
	}
	else
    if((trim($a_file[$i])!="") && (!in_array(substr($a_file[$i],0,4),$error_param)))
    {
		echo $n."-UNKNOWN PARAM ".$a_file[$i]."<br>";
	}
}

//dumper($g_type_14);
//dumper($g_14);
//dumper($g_type_guard);
//dumper($g_guard);

//------------------------------------------------------------
//конец работы с файлом
//echo "u1=".$u1." u2=".$u2." u3=".$u3."<br>";
//for($i=1;$i<$u1;$i++)echo $str_num[$i]."-".$u_table1[$i]." ";

//шапка
/*
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
/*
//имя guard.var
echo "<tr><td>NAME</td></tr>";
for($i=0;$i<$max+1;$i++)
{ 
	echo "<tr><td>$i</td><td>".$name1_table[$i]."</td></tr>";
}
*/
//обязательные юниты guard.var
for($i=0,$j=0;$i<$max+1;$i++)
{ 
//	echo "<tr><td>$i</td><td>";
	for(;($u_table1[$i][$j]!="")&&($j<10000);$j++)
	{
//		echo $u_table1[$i][$j].":".$u_cnt1[$i][$j]." (ур. ".$u_lvl1[$i][$j]."); ";
		$p .= $u_table1[$i][$j].":<B><font color=\"red\">".$u_cnt1[$i][$j];
		$p .= "</font></B> (<font color=\"green\">ур. <B>".$u_lvl1[$i][$j]."</B></font>); ";
	}
//	echo substr($p,0,strlen($p)-2);
	$u_must[$i]=substr($p,0,-2);
	$p="";
//	echo "</td></tr>";
}
//дополнительные юниты guard.var
for($i=0,$j=0;$i<$max+1;$i++)
{ 
//	echo "<tr><td>$i</td><td>";
	for(;($u_table2[$i][$j]!="")&&($j<10000);$j++)
	{
//		echo $u_table2[$i][$j]." (ур. ".$u_lvl2[$i][$j]."); ";
		if($guard_u_minmax[$i]!=0)
		{
			$p .= $u_table2[$i][$j].":<B><font color=\"blue\">".$u_cnt2[$i][$j];
			$p .= "</font></B> (<font color=\"green\">ур. <B>".$u_lvl2[$i][$j]."</B></font>); ";
		}
	}
//	echo substr($p,0,strlen($p)-2);
	$u_may[$i]=substr($p,0,-2);
	$p="";
//	echo "</td></tr>";
}
//инициатива guard.var
/*
echo "<tr><td>INI(нач с 1)</td></tr>";
for($i=1;$i<$max+1;$i++)
{ 
	echo "<tr><td>".$guard_ini_min[$i].($guard_ini_min[$i] == $guard_ini_max[$i] ? "" : "-".$guard_ini_max[$i])."</td></tr>";
}
//кол-во guard.var
echo "<tr><td>QUA(нач с 1)</td></tr><tr><td></td></tr>";
for($i=1;$i<$max+1;$i++)
{ 
	echo "<tr><td><B>".(($u_qua[$i]==$guard_u_min[$i]) ? $guard_u_min[$i].(($guard_u_min[$i]==$guard_u_max[$i]) ? "" : "-".$guard_u_max[$i]) : "!!!");
	echo "</B></td></tr>";
}
*/

echo "<table width=100% border=1>";

/*
for($i=1;$i<$max+1;$i++)
{ 
	echo "<tr><td>$i</td><td>$name1_table[$i]</td><td>";
	echo (($u_qua[$i]==$guard_u_min[$i]) ? $guard_u_min[$i].(($guard_u_min[$i]==$guard_u_max[$i]) ? "" : "-".$guard_u_max[$i]) : "!!!");
	echo "</td><td>$u_must[$i]</td><td>$u_may[$i]</td><td>$guard_power[$i]</td><td>";
	echo $guard_ini_min[$i].($guard_ini_min[$i] == $guard_ini_max[$i] ? "" : "-".$guard_ini_max[$i]);
	echo "</td><td>$guard_poss[$i]</td><td>$guard_maxloot[$i]</td><td>$g_guard[$i]</td><td>$g_power2[$i]</td><td>";
	if($g_karma2[$i]>0) echo "<font color=\"green\">+";
	else if($g_karma2[$i]<0) echo "<font color=\"red\">";
	echo ($g_karma2[$i] ? $g_karma2[$i] : "")."</font></td></tr>";
}
*/

for($i=1;$i<$max+1;$i++)//не комментить! - нужно для "Состава стражи"
{ 
	$num=$g_14[$i];
	for($j=0;$j<$num;$j++,$i++)
	{
		echo "<tr>";
		if($j==$num-1)
		{
			echo "<td align=center class=bottom>$i</td><td class=bottom>$name1_table[$i]</td><td class=bottom></td>";
			echo "<td class=bottom>$u_must[$i]</td><td class=bottom>$u_may[$i]</td align=center>";
			echo "<td align=center class=bottom>$guard_power[$i]</td><td align=center class=bottom></td><td align=center class=bottom>$guard_poss[$i]";
			echo "</td><td align=center class=bottom style='border-right:1.0pt solid black;'>$guard_maxloot[$i]</td><td>x</td>";
		}
		else
		{
			echo "<td align=center>$i</td><td>$name1_table[$i]</td><td></td>";
			echo "</td><td>$u_must[$i]</td><td>$u_may[$i]</td><td align=center>$guard_power[$i]</td><td></td>";
			echo "<td align=center>$guard_poss[$i]</td><td align=center style='border-right:1.0pt solid black;'>";
			echo "$guard_maxloot[$i]</td><td>x</td>";
		}
		echo "</tr>";
	}
	$i--;
}

echo "</table><br>";

//Тип охраны (guard_type) - сила (чтобы не было ошибки number-format
echo "<font color=\"red\"><B>!! КОПИРОВАТЬ ЦЕНТРАЛЬНЫЙ СТОЛБЕЦ В САМОМ КОНЦЕ !!</font></B><br><br>";
echo "<table width=100% border=1>";
echo "<tr><td></td><td align=center><font color=\"red\"><B>Сила guard_type</font></B></td><td></td></tr>";
for($i=1,$n=1;$i<$max1+1;$i++)
{
	for($j=0;$j<$g_type_14[$i];$j++,$n++)
	{
		echo "<tr>";
		if($j==0)
		{
			echo "<td rowspan=$g_type_14[$i] class=bottom>x</td>";
			echo "<td align=center rowspan=$g_type_14[$i] class=bottom>".$g_power2[$n]."</td>";
			echo "<td align=center rowspan=$g_type_14[$i] class=bottom>x</td>";
		}
		echo "</tr>";
	}
}
echo "</table><br>";

?>
<style>
td
{mso-number-format:"\@";}
</style>
<?php
echo "вывод Количество и Инициатива в текстовом формате<br>";
echo "<font color=\"red\"><B>!! КОПИРОВАТЬ С ОПЦИЕЙ \"Пропускать пустые ячейки\" !!</font></B><br><br>";
echo "<table width=100% border=1>";
/*
for($i=1;$i<$max+1;$i++)
{ 
	$num=$g_14[$i];
	for($j=0;$j<$num;$j++,$i++)
	{
		echo "<tr>";
		if($j==$num-1)
		{
			echo "<td class=bottom>$i</td><td class=bottom>$name1_table[$i]</td><td class=bottom>";
			echo (($u_qua[$i]==$guard_u_min[$i]) ? $guard_u_min[$i].(($guard_u_min[$i]==$guard_u_max[$i]) ? "" : "-".$guard_u_max[$i]) : "!!!");
			echo "</td><td class=bottom>$u_must[$i]</td><td class=bottom>$u_may[$i]</td>";
			echo "<td class=bottom>$guard_power[$i]</td><td class=bottom>";
			echo $guard_ini_min[$i].($guard_ini_min[$i] == $guard_ini_max[$i] ? "" : "-".$guard_ini_max[$i]);
			echo "</td><td class=bottom>$guard_poss[$i]</td><td class=bottom>$guard_maxloot[$i]</td>";
		}
		else
		{
			echo "<td>$i</td><td>$name1_table[$i]</td><td>";
			echo (($u_qua[$i]==$guard_u_min[$i]) ? $guard_u_min[$i].(($guard_u_min[$i]==$guard_u_max[$i]) ? "" : "-".$guard_u_max[$i]) : "!!!");
			echo "</td><td>$u_must[$i]</td><td>$u_may[$i]</td><td>$guard_power[$i]</td><td>";
			echo $guard_ini_min[$i].($guard_ini_min[$i] == $guard_ini_max[$i] ? "" : "-".$guard_ini_max[$i]);
			echo "</td><td>$guard_poss[$i]</td><td>$guard_maxloot[$i]</td>";
		}
		echo "</tr>";
	}
	$i--;
}
*/

for($i=1;$i<$max+1;$i++)
{ 
	$num=$g_14[$i];
	for($j=0;$j<$num;$j++,$i++)
	{
		echo "<tr>";
		if($j==$num-1)
		{
			echo "<td class=bottom></td><td class=bottom></td><td align=center class=bottom>";
			echo (($u_qua[$i]==$guard_u_min[$i]) ? $guard_u_min[$i].(($guard_u_min[$i]==$guard_u_max[$i]) ? "" : "-".$guard_u_max[$i]) : "!!!");
			echo "</td><td class=bottom></td><td class=bottom></td>";
			echo "<td class=bottom></td><td align=center class=bottom>";
			echo $guard_ini_min[$i].($guard_ini_min[$i] == $guard_ini_max[$i] ? "" : "-".$guard_ini_max[$i]);
			echo "</td><td class=bottom></td><td class=bottom></td>";
		}
		else
		{
			echo "<td></td><td></td><td align=center>";
			echo (($u_qua[$i]==$guard_u_min[$i]) ? $guard_u_min[$i].(($guard_u_min[$i]==$guard_u_max[$i]) ? "" : "-".$guard_u_max[$i]) : "!!!");
			echo "</td><td></td><td></td><td></td><td align=center>";
			echo $guard_ini_min[$i].($guard_ini_min[$i] == $guard_ini_max[$i] ? "" : "-".$guard_ini_max[$i]);
			echo "</td><td></td><td></td>";
		}
		echo "</tr>";
	}
	$i--;
}

echo "</table><br>";

//Тип охраны (guard_type) - кроме силы
echo "<font color=\"red\"><B>!! \"Где можно встретить\" потом формат ячейки - Общий; выравнивание по левому краю !!</font></B><br>";
echo "<table width=100% border=1>";
echo "<tr><td align=center><font color=\"red\"><B>Имя guard_type</font></B></td><td></td><td align=center><font color=\"red\"><B>Карма guard_type</font></B></td><td align=center><font color=\"red\"><B>Где можно встретить</font></B></td></tr>";
for($i=1,$n=1;$i<$max1+1;$i++)
{
	for($j=0;$j<$g_type_14[$i];$j++,$n++)
	{
		echo "<tr>";
		if($j==0)
		{
			echo "<td rowspan=$g_type_14[$i] class=bottom>".$g_guard[$n]."</td>";
			echo "<td align=center rowspan=$g_type_14[$i] class=bottom></td>";
			echo "<td align=center rowspan=$g_type_14[$i] class=bottom>";
			if($g_karma2[$n]>0) echo "<font color=\"green\">+";
			else if($g_karma2[$n]<0) echo "<font color=\"red\">";
			echo ($g_karma2[$n] ? $g_karma2[$n] : "")."</font></td>";
			echo "<td align=center rowspan=$g_type_14[$i] class=bottom>";
			$s = "";
			if(isset($guard_prov_prn[$n])) $s .= $guard_prov_prn[$n]."<br>";
			if(isset($guard_site_prn[$n])) $s .= $guard_site_prn[$n]."<br>";
			if(isset($guard_event_prn[$n])) $s .= $guard_event_prn[$n]."<br>";
			if(isset($guard_enc_prn[$n])) $s .= $guard_enc_prn[$n]."<br>";
			echo isset($s) ? substr($s,0,-4) : "";
			echo "</td>";
		}
		echo "</tr>";
	}
}

?>

<br><a href='index.html'>вернуться к списку файлов</a>
</html>