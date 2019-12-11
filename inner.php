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
$b_file = file("inner_build.var");
$count_b = count($b_file);
$b_g_file = file("build_group.var");
$count_b_g = count($b_g_file);
$b_txt_file = file("Inner_Build.txt");
$count_b_txt = count($b_txt_file);
$u_file = file("unit.var");
$count_u = count($u_file);
$out_build_file = file("outer_build.var");
$count_out_build = count($out_build_file);
$item_file = file("item.var");
$count_item = count($item_file);
$spell_file = file("spell.var");
$count_spell = count($spell_file);
$ritual_file = file("ritual.var");
$count_ritual = count($ritual_file);
$def_file = file("defender.var");
$count_def = count($def_file);
$event_file = file("event.var");
$count_event = count($event_file);
$race_file = file("race.var");
$count_race = count($race_file);
$site_file = file("site.var");
$count_site = count($site_file);

$max=0;$max1=0;$max_u=0;$max_e=0;$t[0]=0;$j=0;
$u1=-1;$u2=0;$u3=0;	//№ строки юнита в xls
$g1=0; //кол-во стражей в одном сайте
$a1=0; //№ абилки
$a2=0; //№ эффекта ritual
$e1=0; //№ эффекта
$up1=0; //число upg_type в unit_upg
$u_a=0; //абилки in unit.var

$res_name=array(1=>"Железо", "Красное дерево", "Кони", "Мандрагора", "Арканит", "Мрамор", "Мифрил", "Дионий", "Чёрный лотос");
$terrain = array(1=>"Равнина","Лес","Холмы","Болото","Пустыня","Тундра");
/*
$abil_name[901]="Дополнительный слот для заклинания I круга";
$abil_name[902]="Дополнительный слот для заклинания II круга";
$abil_name[903]="Дополнительный слот для заклинания III круга";
$abil_name[904]="Дополнительный слот для заклинания IV круга";

//вшитые неописанные эффекты
$abil_add[996][1]="Можно проводить разведку, ";
$abil_add[996][2]="Можно поднять ложную тревогу, ";
$abil_add[996][3]="Можно отравить запасы воды, ";
$abil_add[996][4]="Можно устроить панику, ";
$abil_add[996][5]="Разведка и диверсии дешевле на <font color=\"green\"><B>50%</B></font>, ";
$abil_add[985][1]="Цены ниже на <font color=\"green\"><B>10%</B></font>, ";
$abil_add[985][2]="Цены ниже на <font color=\"green\"><B>10%</B></font>, ";
$abil_add[985][3]="Цены ниже на <font color=\"green\"><B>10%</B></font>, ";
$abil_add[985][4]="Цены ниже на <font color=\"green\"><B>10%</B></font>, ";
$abil_add[985][5]="Цены ниже на <font color=\"green\"><B>10%</B></font>, ";
$abil_add[907][1]="Максимальный радиус призыва <font color=\"green\"><B>+1</B></font>, ";
$abil_add[907][2]="Максимальный радиус призыва <font color=\"green\"><B>+1</B></font>, ";
$abil_add[907][3]="Максимальный радиус призыва <font color=\"green\"><B>+1</B></font>, ";
$abil_add[907][4]="Максимальный радиус призыва <font color=\"green\"><B>+1</B></font>, ";
$abil_add[907][5]="Максимальный радиус призыва <font color=\"green\"><B>+1</B></font>, ";
$abil_add[909][1]="Позволяет оставить скелета, <font color=\"green\"><B>+10%</B></font> жизни за ход, ";
$abil_add[909][2]="Позволяет оставить нежить первого ранга, <font color=\"green\"><B>+10%</B></font> жизни за ход, ";
$abil_add[909][3]="Позволяет оставить нежить второго ранга, <font color=\"green\"><B>+10%</B></font> жизни за ход, ";
$abil_add[909][4]="Позволяет оставить нежить третьего ранга, <font color=\"green\"><B>+10%</B></font> жизни за ход, ";
$abil_add[909][5]="Позволяет оставить вампира, <font color=\"green\"><B>+10%</B></font> жизни за ход, ";
*/
/*
//массив - полистовой вывод:
Военный:
1 - group=1
2 - abil=1(магазин), item_effect=84, unit_level=1
	abil=8 unit_level[abil]=1
3 - group=3
4 - abil=1(магазин), item_effect=84, unit_level=2
	abil=8 unit_level[abil]=2
5 - group=7
6 - abil=1(магазин), item_effect=84, unit_level=3
	abil=8 unit_level[abil]=3
7 - group=11
8 - abil=1(магазин), item_effect=84, unit_level=4
	abil=8 unit_level[abil]=4
9 - get_slot=2
10 - get_slot=3
*/

/*
function get_slot(&$start,$num)//принадлежность/квартал
{
//echo "START: NUM=$num<br>";
	global $build_upgrade,$build_slot,$build_place;
	if($build_upgrade[$num]==0)
	{
//echo "RET: ".$build_slot[$num]."<br>";
		$build_place[$start]=$build_slot[$num];
		return;
	}
//echo "IN: UP=".$build_upgrade[$num]."<br>";
	get_slot($start,$build_upgrade[$num]);
}
*/

function get_slot($num)//принадлежность/квартал
{
//echo "START: NUM=$num<br>";
	global $build_upgrade;
	if($build_upgrade[$num]==0)
	{
//echo "RET: ".$num."<br>";
		return $num;
	}
//echo "IN: UP=".$build_upgrade[$num]."<br>";
	return get_slot($build_upgrade[$num]);
}

//Разбор build_group.var
for($i = 0,$n=0; $i < $count_b_g; $i++)
{  
	if(eregi("^/([0-9]{1,})",$b_g_file[$i],$k))
    {
		$n=$k[1];
    }
    else
    if(eregi("^max",$b_g_file[$i]))
    {
		$s=explode(':',$b_g_file[$i]);
		$b_g_max[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^name",$b_g_file[$i]))
    {
		$s=explode(':',$b_g_file[$i]);
		$b_g_name[$n]=str_replace("Преобразователи", "Преобразова-тели",substr(trim($s[1]),0,-1));
    }
}

//Разбор site.var
for($i = 0,$n=0; $i < $count_site; $i++)
{  
   if(eregi("^/([0-9]{1,})",$site_file[$i],$k))
    {
		$n=$k[1];
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
				echo $n."- Дубль SITE=".$s;
				$s = $s."<font color=\"fuchsia\">*</font>";
				echo " <B>Замена на</B> ".$s."<br>";
			}
			$site_name[$n]=$s;
		}
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

//Разбор event.var
for($i = 0,$n=0; $i < $count_event; $i++)
{  
   if(eregi("^/([0-9]{1,})",$event_file[$i],$k))
    {
		$n=$k[1];
		if($n>$max_e)$max_e=$n;
		$s=substr($event_file[$i],log10($n)+3);
		$event_table[$n]=trim($s);
		if($event_table[$n][0]=='(')
			$event_table2[$n]=substr($event_table[$n],1,-1);
		else
			$event_table2[$n]=$event_table[$n];
    }
}

//Разбор ritual.var
for($i = 0,$n=0; $i < $count_ritual; $i++)
{  
   if(eregi("^/([0-9]{1,})",$ritual_file[$i],$k))
    {
		$n=$k[1];
    }
    else
    if(eregi("^name",$ritual_file[$i]))
    {
		$s=explode(':',$ritual_file[$i]);
		$ritual_name[$n]=substr(trim($s[1]),0,-1);
    }
}

//Разбор defender.var
for($i = 0,$n=0; $i < $count_def; $i++)
{  
   if(eregi("^/([0-9]{1,})",$def_file[$i],$k))
    {
		$n=$k[1];
    }
    else
    if(eregi("^name",$def_file[$i]))
    {
		$s=explode(':',$def_file[$i]);
		$s=substr(trim($s[1]),0,-1);
		while(in_array($s,$def_name))
		{
			echo $n."- Дубль DEFENDER=".$s;
			$s = $s."<font color=\"fuchsia\">*</font>";
			echo " <B>Замена на</B> ".$s."<br>";
		}
		$def_name[$n]=$s;
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
    else
    if(eregi("^Level",$u_file[$i]))
    {
		$s=explode(':',$u_file[$i]);
		$u_level[$n]=$s[1]+1-1;
    }
}

//Разбор item.var
for($i = 0,$n=0; $i < $count_item; $i++)
{  
   if(eregi("^/([0-9]{1,})",$item_file[$i],$k))
    {
		$n=$k[1];
    }
    else
    if(eregi("^name",$item_file[$i]))
    {
		$s=explode(':',$item_file[$i]);
		$s=substr(trim($s[1]),0,-1);
		while(in_array($s,$item_name))
		{
			echo $n."- Дубль ITEM=".$s;
			$s .= "<font color=\"fuchsia\">*</font>";
			echo " <B>Замена на</B> ".$s."<br>";
		}
		$item_name[$n]=$s;
    }
    else
    if(eregi("^Building",$item_file[$i]))
    {
		$s=explode(':',$item_file[$i]);
		if(($s[1]+1-1)!=0)
			$build_item[$s[1]+1-1] .= $item_name[$n].", ";
    }
}

//Разбор spell.var
for($i = 0,$n=0; $i < $count_spell; $i++)
{  
   if(eregi("^/([0-9]{1,})",$spell_file[$i],$k))
    {
		$n=$k[1];
    }
    else
    if(eregi("^name",$spell_file[$i]))
    {
		$s=explode(':',$spell_file[$i]);
		$s=substr(trim($s[1]),0,-1);
		if($n == 194)
			$s .= " <font color=\"fuchsia\">мотылька</font>";
		else
		if($n == 336)
			$s .= " <font color=\"fuchsia\">жрицы</font>";
		else
		if($n == 342)
			$s .= " <font color=\"fuchsia\">охотника</font>";
		else
		if($n == 344)
			$s .= " <font color=\"fuchsia\">Стража</font>";
		else
		if($n == 345)
			$s .= " <font color=\"fuchsia\">Алчущего</font>";
		else
		if($n == 347)
			$s .= " <font color=\"fuchsia\">Избранной</font>";
		while(in_array($s,$spell_name))
		{
			echo $n."- Дубль SPELL=".$s;
			$s = $s."<font color=\"fuchsia\">*</font>";
			echo " <B>Замена на</B> ".$s."<br>";
		}
		$spell_name[$n]=$s;
    }
    else
    if(eregi("^Building",$spell_file[$i]))
    {
		$s=explode(':',$spell_file[$i]);
		$s1 = $s[1]+1-1;
		if($s1 > 0)//изучение заклов
			$build_spell[$s1] .= $spell_name[$n].", ";
		else
		if($s1 < 0)//свитки
			$build_spell_scroll[-$s1] .= $spell_name[$n].", ";
    }
}

//Разбор outer_build.var
for($i = 0,$n=0; $i < $count_out_build; $i++)
{  
   if(eregi("^/([0-9]{1,})",$out_build_file[$i],$k))
    {
		$n=$k[1];
    }
    else
    if(eregi("^name",$out_build_file[$i]))
    {
		$s=explode(':',$out_build_file[$i]);
		$out_build_name[$n]=substr(trim($s[1]),0,-1);
    }
}

//Разбор Inner_Build.txt
for($i = 0; $i < $count_b_txt; $i++)
{  
    if(eregi("^([0-9]{1,})",$b_txt_file[$i],$k))
    {
		$n=$k[1];
		if($n!=0)$build_txt[$n-1]=substr($build_txt[$n-1],0,-4);//удаление пустой строки
    }
    else
	{
		if(trim($b_txt_file[$i])!="")
			$build_txt[$n] .= str_replace("#","",str_replace("~","%",$b_txt_file[$i]))."<br>";
	}
	if(substr(trim($b_txt_file[$i]),0,1)=="#")
		$b_txt_idx[$n] = $i;//в какую строку добавлять спойлеры о карме/коррупции
}

//Разбор inner_build.var (для build_name)
for($i = 0,$n=0; $i < $count_b; $i++)
{  
	if(eregi("^/([0-9]{1,})",$b_file[$i],$k))
    {
		$n=$k[1];
		if($n>$max)$max=$n;
    }
    else
    if(eregi("^Name",$b_file[$i]))
    {
		$s=explode(':',$b_file[$i]);
		$s=substr(trim($s[1]),0,-1);
		if(in_array($s,$build_name))
		{
			echo $n."- Дубль NAME=".$s."<br>";
		}
		$build_name[$n]=$s;
// echo $n."-".$build_name[$n]."<br>";
    }
}
//-------------------------------------------------------------
//Разбор основного файла
//Разбор inner_build.var
for($i = 0,$n=0; $i < $count_b; $i++)
{  
	if(eregi("^/([0-9]{1,})",$b_file[$i],$k))
    {
		$n=$k[1];
		if($n>$max)$max=$n;
    }
    else
    if(eregi("^GoldCost",$b_file[$i]))
    {
		$s=explode(':',$b_file[$i]);
		$build_gold[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^GemCost",$b_file[$i]))
    {
		$s=explode(':',$b_file[$i]);
		$build_gem[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^Group",$b_file[$i]))
    {
		$s=explode(':',$b_file[$i]);
		$build_group[$n]=$s[1]+1-1;
/*
		if($build_group[$n]==1)
			$build_tab[1][]=$n;
		else
		if($build_group[$n]==3)
			$build_tab[2][]=$n;
		else
		if($build_group[$n]==7)
			$build_tab[3][]=$n;
		else
		if($build_group[$n]==11)
			$build_tab[4][]=$n;
		else
		if($build_group[$n]==2)
			$build_tab[31][]=$n;
		else
		if($build_group[$n]==4)
			$build_tab[32][]=$n;
		else
		if($build_group[$n]==8)
			$build_tab[33][]=$n;
		else
		if($build_group[$n]==12)
			$build_tab[34][]=$n;
*/
    }
    else
    if(eregi("^Slot",$b_file[$i]))
    {
		$s=explode(':',$b_file[$i]);
		$build_slot[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^Upgrade",$b_file[$i]))
    {
		$s=explode(':',$b_file[$i]);
		$build_upgrade[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^Hidden",$b_file[$i]))
    {
		$s=explode(':',$b_file[$i]);
		$build_hidden[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^Level",$b_file[$i]))
    {
		$s=explode(':',$b_file[$i]);
		$build_level[$n]=$s[1]+1-1;
    }
    else
	if(eregi("^Building",$b_file[$i]))
    {
		$s=explode(':',$b_file[$i]);
		$s1=substr(trim($s[1]),1,-1);
		$s2=explode(',',$s1);
		for($j=0;($s2[$j]!="")&&($j<20);$j++)
		{
			if($s2[$j]!=0)
			{
				if($s2[$j]<1000)
				{
					$build_build[$n] .= $build_name[$s2[$j]+1-1]."(<B><font color=\"fuchsia\">".($s2[$j]+1-1)."</font></B>), ";//Необходимые постройки
					$build_in[$s2[$j]+1-1][]=$n;//Открывает доступ к постройкам
				}
				else
				{
					$q=$b_g_max[$s2[$j]-1000];
					$build_build[$n] .= "<B><font color=\"blue\">";
					if($q==1)
						$build_build[$n] .= "1</font></B> постройка";
					else
						$build_build[$n] .= "$q</font></B> постройки";
					$build_build[$n] .= " типа <B><font color=\"blue\">".$b_g_name[$s2[$j]-1000]."</font></B>, ";
				}
			}
		}
//echo $n." - B=";
//dumper($build_build[$n]);
		}
    else
	if((eregi("^Resourse:",$b_file[$i])) || (eregi("^Resource:",$b_file[$i])))
    {
		$s=explode(':',$b_file[$i]);
		$s1=substr(trim($s[1]),1,-1);
		$s2=explode(',',$s1);
		for($j=0;($s2[$j]!="")&&($j<20);$j++)
		{
			$build_res[$n] .= $res_name[$s2[$j]+1-1]."; ";
		}
		$build_res[$n]=substr($build_res[$n],0,-2);
    }
    else
    if(eregi("^Ability",$b_file[$i])) //Ability в site.var или defender.var
    {
		if(trim($b_file[$i])!="Ability:")
		{
			$s=explode(':',$b_file[$i]);
			$build_abil[$n][]=$s[1];
			$i++;
			$s1=explode(':',$b_file[$i]);//param1
			$build_param1[$n][]=$s1[1]+1-1;
			$i++;
			$s2=explode(':',$b_file[$i]);//param2
			$build_param2[$n][]=$s2[1]+1-1;
/*			if(($s[1]+1-1) == 1) //магазин
			{
//				foreach($build_summon[$n][1] as $v)
					
			}
			if(($s[1]+1-1) == 8) //найм юнитов
				$build_unit[$s1[1]+1-1][1][] = "<B><font color=\"red\">Найм:</font></B> здание <B><font color=\"green\">".$build_name[$n]."</font></B>;<br>";
			else
			if(($s[1]+1-1) == 31) //позволяет нанимать из яиц
			{
				$q=$item_summon[$s1[1]+1-1];
				$build_unit[$q][2][] = "<B><font color=\"red\">Разрешение найма:</font></B> здание <B><font color=\"green\">".$build_name[$n]."</font></B> (из предмета <B><font color=\"brown\">".$item_name[$s1[1]+1-1]."</font></B>);<br>";
			}
			else
			if(($s[1]+1-1) == 1) //магазин яиц
			{
				$build_egg[$n]=1;
			}
//echo $n." UNIT=".($s1[1]+1-1)."(".$build_unit[$s1[1]+1-1].") EGG=".$build_egg[$n]."<br>";
*/
		}
    }
}
//------------------------------------------------------------
//конец работы с файлом

//Абилки 
for($i=1;$i<$max+1;$i++)
{ 
	for($j=0,$n=1;($build_abil[$i][$j]!="")&&($j<20);$j++,$n++)
	{
		$num=$build_abil[$i][$j]+1-1;
		$param1=$build_param1[$i][$j];
		$param2=$build_param2[$i][$j];
		if($num==0)
			$p .= "Нет";
/*		else
		if($num == 60 && count(explode(",",$build_spell_scroll[$i])) < 2)//пустой магазин артефактов
		{
		}
*/		else
			$p .= $n.") ";
		if($num==1)
		{
			$c=count(explode(",",$build_item[$i]));
			$p .= "<B>Магазин:</B> продажа ";
			if($param1==2)
			{
				$p .= "<font color=\"blue\"><B>".(7-$param2)."</B></font> ";
				if((7-$param2)==1)
					$p .= "случайного предмета уровня <B><font color=\"blue\">$param2</font></B>";
				else
					$p .= "случайных предметов уровня <B><font color=\"blue\">$param2</font></B> (по одному)";
			}
/*
			else
			{
				$c=count(explode(",",$build_item[$i]));
				if($c==2)
					$p .= "предмета";
				else
					$p .= "предметов";
				$p .= " <font color=\"blue\"><B>".substr($build_item[$i],0,-2)."</B></font> ";
				if($param1==0)
					$p .= "(неограниченное количество)";
				else
				if($param1==1)
				{
					if($c==2)
						$p .= "(одна штука)";
					else
						$p .= "(по одному)";
				}
			}
*/
			else
			if($param1==1)
			{
				if($c==2)
					$p .= "предмета";
				else
					$p .= "предметов";
				$p .= " <font color=\"blue\"><B>".substr($build_item[$i],0,-2)."</B></font> ";
				if($param2==1)
				{
					if($c!=2)
					{
						$p .= "(по одному)";
					}
				}
				else
					$p .= "(<font color=\"blue\"><B>$param2</B></font> шт.)";
			}
			else
			if($param1==0)
			{
				if($c==2)
					$p .= "предмета";
				else
					$p .= "предметов";
				$p .= " <font color=\"blue\"><B>".substr($build_item[$i],0,-2)."</B></font> (неограниченное количество)";
			}
			else
				$p .= "<B>!!!ERROR Магазин: param1=".$param1;
		}
		else
		if($num==2)
		{
			$p .= "<B>Библиотека:</B> изучение ";
				if(count(explode(",",$build_spell[$i]))==2)
					$p .= "заклинания";
				else
					$p .= "заклинаний";
				$p .= " <font color=\"blue\"><B>".substr($build_spell[$i],0,-2)."</B></font> ";
		}
		else
		if($num==3)
		{
			if($param1!=0)
			{
				$p .= "Изменение прироста населения в родовой провинции на <B>";
				$p .= (($param1>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param1."</font>";
				if($param2!=0)
					$p .= "</B>, ";
			}
			if($param2!=0)
			{
				$p .= "Изменение прироста населения во всех провинциях на <B>";
				$p .= (($param2>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param2."</font>";
			}
		}
		else
		if($num==4)
		{
			$p .= "Добавление в гарнизон места для <font color=\"blue\"><B>$param2</B></font> воинов ранга <font color=\"blue\"><B>$param1</B></font>";
		}
		else
		if($num==5)
		{
			if($param1!=0)
			{
				$p .= "Доход золота <B>".(($param1>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param1."</font>";
				if($param2!=0)
					$p .= "</B>, ";
			}
			if($param2!=0)
				$p .= "Доход кристаллов <B>".(($param2>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param2."</font>";
		}
		else
		if($num==6)
		{
			$p .= "Доступ к наёмникам уровня качества<B><font color=\"blue\"> 1";
			if($merc != 0)
				$p .= "-".($merc+$param1);
			$p .= "</font>";
			$merc++;
		}
		else
		if($num==7)
		{
			$p .= "Снижение платы за воскрешение героя и проведение ритуалов на <B><font color=\"green\">$param1%</font>";
		}
		else
		if($num==8)
		{
			$p .= "Найм юнита <B><font color=\"blue\">".$u_name[$param1]."</font>";
			if($param2>0)
				$p .= "</B> (поместить юнита в конец списка в гарнизоне)";
		}
		else
		if($num==9)
		{
			$p .= "Изменение дохода с ресурса <B><font color=\"blue\">".$res_name[$param1]."</font></B>";
			$p .= " на <B>".(($param2>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param2."</font>";
		}
		else
		if($num==10)
		{
			$p .= "Ускорение движения героя из родовой провинции на <B><font color=\"green\">$param1</font>";
		}
		else
		if($num==11)
		{
			if($param2>0)
			{
				$p .= "Получение <B><font color=\"blue\">$param2</font></B> ";
				if($param2==1)
					$p .= "чертежа";
				else
					$p .= "чертежей";
				$p .= " внешней постройки";
			}
			else
				$p .= "Открытие доступа к внешней постройке";
			$p .= " <B><font color=\"blue\">".$out_build_name[$param1]."</font>";
		}
		else
		if($num==12)
		{
			if($param1!=0)
			{
				$p .= "Изменение настроения жителей в родовой провинции на <B>";
				$p .= (($param1>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param1."</font>";
				if($param2!=0)
					$p .= "</B>, ";
			}
			if($param2!=0)
			{
				$p .= "Изменение настроения жителей во всех провинциях на <B>";
				$p .= (($param2>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param2."</font>";
			}
		}
		else
		if($num==13)
		{
			$p .= "Снижение стоимости найма героя на <B><font color=\"green\">$param1%</font>";
		}
		else
		if($num==14)
		{
			$p .= "Изменение дохода с ";
			if($param1==0)
				$p .= "каждой провинции";
			else
			if($param1==8)
				$p .= "прибрежных провинций";
			else
				$p .= "провинций территории типа <B><font color=\"blue\">".$terrain[$param1]."</font></B>";
			$p .= " на <B>".(($param2>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param2."</font>";
		}
		else
		if($num==15)
		{
			if($param2>0)
			{
				$p .= "Получение <B><font color=\"blue\">$param2</font></B> ";
				if($param2==1)
					$p .= "договора";
				else
					$p .= "договоров";
				$p .= " со стражей";
			}
			else
				$p .= "Разрешение найма стражи";
			$p .= " <B><font color=\"blue\">".$def_name[$param1]."</font>";
		}
		else
		if($num==16)
		{
			$p .= "Снижение стоимости построек в замке на <B><font color=\"green\">$param1%</font>";
		}
		else
		if($num==17)
		{
			$p .= "Снижение платы за ресурсы на <B><font color=\"green\">$param1%</font>";
		}
		else
		if($num==18)
		{
			$p .= "Снижение стоимости набора войска на <B><font color=\"green\">$param1%</font>";
		}
		else
		if($num==19)
		{
			$p .= "Изменение боевого духа защитников родовой провинции";
			$p .= " на <B>".(($param1>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param1."</font>";
		}
		else
		if($num==20)
		{
			$p .= "Изменение опыта новобранцев";
			$p .= " на <B>".(($param1>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param1."</font>";
		}
		else
		if($num==21)
		{
			$p .= "Ускорение восстановления здоровья воинов в родовой провинции на <B><font color=\"green\">$param1%</font></B> в ход";
		}
		else
		if($num==22)
		{
			$p .= "Изменение общего дохода золота ";
			$p .= "на <B>".(($param1>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param1."%</font>";
		}
		else
		if($num==23)
		{
			if($param1!=0)
			{
				$p .= "Замедление накопления недовольства в родовой провинции на <B>";
				$p .= (($param1>0) ? "<font color=\"green\">" : "<font color=\"red\">").$param1."</font>";
				if($param2!=0)
					$p .= "</B>, ";
			}
			if($param2!=0)
			{
				$p .= "Замедление накопления недовольства во всех провинциях на <B>";
				$p .= (($param2>0) ? "<font color=\"green\">" : "<font color=\"red\">").$param2."</font>";
			}
		}
		else
		if($num==24)
		{
			$p .= "Плата золота за увольнение воинов (только в гарнизонах). Ускорение появления новых наёмников.";
		}
		else
		if($num==25)
		{
			$p .= "Ускорение исследования провинций на <B><font color=\"green\">$param1%</font>";
		}
		else
		if($num==26)
		{
			$p .= "Открывает скрытые месторождения в провинциях с территорией типа <B><font color=\"blue\">".$terrain[$param1]."</font>";
		}
		else
		if($num==27)
		{
			$p .= "Разрешение проведения ритуала <B><font color=\"blue\">".$ritual_name[$param1]."</font>";
		}
		else
		if($num==28)
		{
			$p .= "Снижение платы золота войскам гарнизонов на <B><font color=\"green\">$param1%</font>";
		}
		else
		if($num==29)
		{
			$p .= "Изменение дохода оппонентов на <B>";
			$p .= (($param1>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param1."</font>";
		}
		else
		if($num==30)
		{
			$p .= "Увеличение силы выстрела башен в родовом замке на <B><font color=\"green\">$param1</font></B>";
			$p .= (($param2>0) ? " и их прочности на <B><font color=\"green\">$param2</font>" : "");
		}
		else
		if($num==31)
		{
			$p .= "Разрешение использовать предмет вызова <B><font color=\"blue\">".$item_name[$param1]."</font>";
			if($param2<=0)$p .= "<br>!!! Param2 должен быть >0";
		}
		else
		if($num==32)
		{
			$p .= "Доход от накопленного золота <B><font color=\"green\">+$param1%</font>";
		}
		else
		if($num==33)
		{
			$p .= "Уменьшение потерь золота при набегах грабителей на <B><font color=\"green\">".($param1*10)."%</font>";
		}
		else
		if($num==34)
		{
			$p .= "Разрешение трансмутации золота и кристаллов";
		}
		else
		if($num==35)
		{
			$p .= "Усиление прочности стен укреплений на <B><font color=\"green\">$param1</font>";
		}
		else
		if($num==36)
		{
			$p .= "Добавление к укреплениям <B><font color=\"blue\">$param1</font></B> ";
			if($param1==1)
				$p .= "башни";
			else
				$p .= "башен";
		}
		else
		if($num==37)
		{
			$p .= "Увеличение общей скорости героев на <B><font color=\"green\">$param1</font>";
		}
		else
		if($num==38)
		{
			$p .= "На <B><font color=\"green\">$param1%</font></B> больше вероятность хороших событий, меньше плохих";
		}
		else
		if($num==39)
		{
			$p .= "Разрешение нанимать <B><font color=\"blue\">$param1</font></B> ";
			if($param1==1)
				$p .= "дополнительного стража";
			else
				$p .= "дополнительных стражей";
			$p .= " за ход";
		}
		else
		if($num==40)
		{
			$p .= "Разрешение строить <B><font color=\"blue\">$param1</font></B> ";
			if($param1==1)
				$p .= "дополнительную внешнюю постройку";
			else
				$p .= "дополнительных внешних построек";
			$p .= " за ход";
		}
		else
		if($num==41)
		{
			$p .= "Изменение дохода от трофеев и грабежа провинций на <B> ";
			$p .= (($param1>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param1."%</font>";
		}
		else
		if($num==42)
		{
			$p .= "Увеличение параметра осады героев на <B><font color=\"green\">$param1</font>";
		}
		else
		if($num==43)
		{
			$p .= "Улучшение дипломатических отношений на <B><font color=\"green\">$param1</font>";
		}
		else
		if($num==44)
		{
			$p .= "<B>Порт:</B> разрешение героям путешествовать через <B><font color=\"green\">";
			$p .= ++$port."</font></B> ";
			if($port==1)
				$p .= "морскую провинцию";
			else
				$p .= "морские провинции";
		}
		else
		if($num==45)
		{
			$p .= "Изменение вероятности появления <B>события (event) <font color=\"blue\">$param1 (".$event_table2[$param1].")</font></B>";
			$p .= " на <B>".(($param2>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param2."%</font>";
		}
		else
		if($num==46)
		{
			$p .= "Изменение кармы на <B>";
			$p .= (($param1>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param1."</font>";
			$karma_flag[$b_txt_idx[$i]] = $param1;//№ строки в Inner_Build.txt, куда надо вставить спойлер о карме
		}
		else
		if($num==47)
		{
			$p .= "Для постройки нужен союз с расой <B><font color=\"blue\">".$unit_race[$param1]."</font>";
		}
		else
		if($num==48)
		{
			$p .= "Активирует <B>событие (event) <font color=\"blue\">$param1 (".$event_table2[$param1].")</font></B>";
			$p .= " через <B><font color=\"green\">$param2</font></B> ";
			if($param2==1)
				$p .= "ход";
			else
			if(($param2>1) && ($param2<5))
				$p .= "хода";
			else
				$p .= "ходов";
		}
		else
		if($num==49)
		{
			$p .= "Изменение дохода золота с провинций, населённых расой <B><font color=\"blue\">".$unit_race[$param1]."</font></B>";
			$p .= " на <B>".(($param2>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param2."</font>";
		}
		else
		if($num==50)
		{
			$p .= "Добавление в родовую провинцию сайта <B><font color=\"blue\">".$site_name[$param1]."</font></B>";
			$p .= (($param2>0) ? " уровня <B><font color=\"green\">$param2</font>" : "");
		}
		else
		if($num==51)
		{
			$p .= "Изменение коррупции на <B>";
			$p .= (($param1>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param1."%</font>";
		}
		else
		if($num==52)
		{
			$p .= "Магическая башня типа <B><font color=\"blue\">".$param1."</font></B>";
			$p .= ", с силой выстрела <B><font color=\"green\">$param2</font>";
		}
		else
		if($num==53)
		{
			$p .= "Уменьшение времени подготовки ритуалов на <B><font color=\"green\">$param1</font>";
		}
		else
		if($num==54)
		{
			$p .= "Разрешение проводить <B><font color=\"blue\">$param1</font></B> ";
			if($param1==1)
				$p .= "дополнительный ритуал";
			else
				$p .= "дополнительных ритуалов";
			$p .= " за ход";
		}
		else
		if($num==55)
		{
			$p .= "Изменение дохода кристаллов с провинций, населённых расой <B><font color=\"blue\">".$unit_race[$param1]."</font></B>";
			$p .= " на <B>".(($param2>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param2."</font>";
		}
		else
		if($num==56)
		{
			$p .= "Повышает дипломатию героев на <B><font color=\"green\">$param1</font>";
		}
		else
		if($num==57)
		{
			$p .= "Меньше плата кристаллов гарнизонам крепостей на <B><font color=\"green\">".$param1."%</font>";
		}
		else
		if($num==58)
		{
			$p .= "Позволяет переписывать из книги героев на свитки заклинания <B><font color=\"green\">";
			$p .= ++$spell_lvl."</font></B> круга";
		}
		else
		if($num==59)
		{
			$p .= "Найм (через кнопку) союзного юнита <B><font color=\"blue\">".$u_name[$param1]."</font>";
//			if($param2>0)
//				$p .= "</B> (поместить юнита в конец списка в гарнизоне)";
		}
		else
		if($num==60)
		{
			$c=count(explode(",",$build_spell_scroll[$i]));
			if($c>1)
			{
				$p .= "<B>Магазин:</B> продажа ";
				if($c==2)
					$p .= "свитка заклинания";
				else
					$p .= "свитков заклинаний";
				$p .= " <font color=\"blue\"><B>".substr($build_spell_scroll[$i],0,-2)."</B></font>";
			}
			else
				$p .= "Атавизм: пустой магазин по продаже свитков заклинаний";
		}
		else
		if($num==61)
		{
			$p .= "Расширяет сокровищницу на один дополнительный экран";
		}
		else
		if($num==62)
		{
			$p .= "Позволяет использовать ритуал <B><font color=\"blue\">".$ritual_name[$param1]."</B></font> (только в родовой провинции)";
		}
		else
		if($num==63)
		{
			$p .= "Увеличивает доход золота с провинций, населённых расой <B><font color=\"blue\">".$unit_race[$param1]."</font></B>, при хорошем настроении";
			$p .= " (<B>Довольны: <font color=\"green\">+1</font>; Очень довольны: <font color=\"green\">+2</font>; Счастливы: <font color=\"green\">+3</font></B>)";
		}
		else
		if($num==64)
		{
			$p .= "Увеличивает доход кристаллов с провинций, населённых расой <B><font color=\"blue\">".$unit_race[$param1]."</font></B>, при хорошем настроении";
			$p .= " (<B>Довольны: <font color=\"green\">+1</font>; Очень довольны: <font color=\"green\">+2</font>; Счастливы: <font color=\"green\">+3</font></B>)";
		}
		else
			$p .= "<B>!!!ERROR NUM=".$num;
		$p .= "</B><br>";
	}
	if($build_group[$i]!=0)
	{
		$b=$b_g_max[$build_group[$i]];
		$p .= $n.") В замке может быть не более <B><font color=\"blue\">";
		if($b==1)
			$p .= "одной </B></font> постройки данного типа";
		else
			$p .= $b."-х</B></font> построек данного типа";
		$p .= "</B><br>";
	}
	$build_abil_prn[$i] = substr($p,0,-8);
	$p="";
}
//dumper($karma_flag,"Карма");

//вывод принадлежность/квартал
for($i=1;$i<$max+1;$i++)
{
	$slot=$build_slot[get_slot($i)];
	if($slot==1)
	{
		$build_slot_prn[$i]="План застройки";
	}
	else
	if(in_array($slot,range(2,16)))
	{
		$build_slot_prn[$i]="Военный квартал";
	}
	else
	if(in_array($slot,range(17,27)))
	{
		$build_slot_prn[$i]="Торговый квартал";
	}
	else
	if(in_array($slot,range(28,35)))
	{
		$build_slot_prn[$i]="Магический квартал";
	}
	else
	if(in_array($slot,range(36,41)))
	{
		$build_slot_prn[$i]="Ремесленники";
	}
	else
	if(in_array($slot,range(42,46)))
	{
		$build_slot_prn[$i]="Храмовый квартал";
	}
	else
	if(in_array($slot,range(47,51)))
	{
		$build_slot_prn[$i]="Центральный квартал";
	}
	else
	if(in_array($slot,range(52,54)))
	{
		$build_slot_prn[$i]="Квартал зрелищ";
	}
	else
	if(in_array($slot,range(55,59)))
	{
		$build_slot_prn[$i]="Лесной квартал";
	}
	else
	if(in_array($slot,range(60,62)))
	{
		$build_slot_prn[$i]="Квартал союзников";
	}
	else
		echo "!!!$i - Неизвестный квартал";
//Открывает доступ к постройкам
	foreach($build_in[$i] as $v)
		$build_in_prn[$i] .= $build_name[$v]."(<B><font color=\"fuchsia\">$v</font></B>), ";

}

//вывод по слотам замка
for($i=1;$i<71;$i++)
{
	$slot=$build_slot[get_slot($i)];
	$build_tab[$slot][]=$i;//сортировка по слоту
	if($i==5) $build_tab[$slot][]=241;//для "Игральня" :(
	$build_tab_naim[1][$slot][]=$i;//нанималки
/*
	if($slot==2)
		$build_tab[5][]=$i;
	else
	if($slot==3)
		$build_tab[6][]=$i;
	else
	if($slot==4)
	{
		if(!in_array($i,$build_tab[1])) $build_tab[7][]=$i;
	}
	else
	if($slot==5)
	{
		if(!in_array($i,$build_tab[1])) $build_tab[8][]=$i;
	}
	else
	if($slot==6)
	{
		if(!in_array($i,$build_tab[1])) $build_tab[9][]=$i;
	}
	else
	if($slot==7)
	{
		if(!in_array($i,$build_tab[1])) $build_tab[10][]=$i;
	}
	else
	if($slot==8)
	{
		if(!in_array($i,$build_tab[1])) $build_tab[11][]=$i;
	}
	else
	if($slot==9)
	{
		if(!in_array($i,$build_tab[1])) $build_tab[12][]=$i;
	}
	else
	if($slot==10)
	{
		if(!in_array($i,$build_tab[1])) $build_tab[13][]=$i;
	}
	else
	if($slot==11)
	{
		if(!in_array($i,$build_tab[1])) $build_tab[14][]=$i;
	}
	else
	if($slot==12)
	{
		if(!in_array($i,$build_tab[1])) $build_tab[15][]=$i;
	}
	else
	if($slot==13)
	{
		if(!in_array($i,$build_tab[1])) $build_tab[16][]=$i;
	}
	else
	if($slot==14)
	{
		if(!in_array($i,$build_tab[1])) $build_tab[17][]=$i;
	}
	else
	if($slot==15)
	{
		if(!in_array($i,$build_tab[1])) $build_tab[18][]=$i;
	}
	else
	if($slot==16)
	{
		if(!in_array($i,$build_tab[1])) $build_tab[19][]=$i;
	}
	else
	if($slot==20)
		$build_tab[20][]=$i;
	else
	if($slot==21)
		$build_tab[21][]=$i;
	else
	if($slot==22)
		$build_tab[22][]=$i;
	else
	if($slot==23)
		$build_tab[23][]=$i;
	else
	if($slot==24)
		$build_tab[24][]=$i;
	else
	if($slot==25)
		$build_tab[25][]=$i;
	else
	if($slot==26)
		$build_tab[26][]=$i;
	else
	if($slot==27)
		$build_tab[27][]=$i;
	else
	if($slot==17)
		$build_tab[28][]=$i;
	else
	if($slot==18)
		$build_tab[29][]=$i;
	else
	if($slot==19)
		$build_tab[30][]=$i;
*/
}

for($i=71;$i<126;$i++)
{
	$slot=$build_slot[get_slot($i)];
	$build_tab[$slot][]=$i;//сортировка по слоту
	if($i==97)
	{
		$build_tab[$slot][]=240;//для "Гильдия трапперов" :(
		$build_tab[$slot][]=263;//для "Гильдия дрессировщиков" :(
	}
	$build_tab_naim[2][$slot][]=$i;//нанималки
}

for($i=126;$i<170;$i++)
{
	$slot=$build_slot[get_slot($i)];
	$build_tab[$slot][]=$i;//сортировка по слоту
	if($i==137) $build_tab[$slot][]=262;//для "Алтарь Смерти" :(
	$build_tab_naim[3][$slot][]=$i;//нанималки
}

for($i=170;$i<=$max;$i++)
{
	if(($i!=240) && ($i!=241) && ($i!=262) && ($i!=263)) //всякие исключения
	{
		$slot=$build_slot[get_slot($i)];
		$build_tab[$slot][]=$i;//сортировка по слоту
		$build_tab_naim[4][$slot][]=$i;//нанималки
	}
}

echo "<table border=1>";

//вывод общей таблицы
for($i=1;$i<$max+1;$i++)
//foreach($skill_sort as $i)
{
	echo "<tr><td align=center>$i</td><td>$build_name[$i]</td><td></td><td>$build_txt[$i]</td><td>";//<img src=\"inner/".$i.".bmp\">
	echo $build_abil_prn[$i]."</td><td align=center>".$build_gold[$i]."</td><td align=center>".$build_gem[$i]."</td><td>";
	echo $build_res[$i]."</td><td align=center>".$build_slot_prn[$i];
	echo "<br><B><font color=\"blue\">(".$build_slot[get_slot($i)].")</B></font></td><td>";
	echo ($build_upgrade[$i]==0 ? "" : $build_name[$build_upgrade[$i]]."(<B><font color=\"fuchsia\">".$build_upgrade[$i]."</B></font>)")."</td><td>";
	echo substr($build_build[$i],0,-2)."</td><td>".substr($build_in_prn[$i],0,-2)."</td><td align=center>";
	echo (($build_group[$i]==0) ? "" : "<B><font color=\"blue\">$build_group[$i]</B></font><br> (".$b_g_name[$build_group[$i]].")")."</td><td align=center>";
	echo $build_level[$i]."</td><td align=center>".(($build_hidden[$i]==0) ? "" : "Да");
	echo "</td></tr>";
}
/*
for($i=1;$i<$max1+1;$i++)
{
	echo "<tr><td>$i</td><td>";
	echo $abil_txt[$i]."</td></tr>";
}
*/
echo "</table><br>";

//вывод по слотам замка
echo "<table border=1>";

//военный квартал
echo "<tr><td></td><td><B><font color=\"red\">военный квартал</B></font></td></tr>";
//союзники
/*
for($i=191;$i<210;$i+=3)
	$build_tab_naim[1][16][]=$i;
$build_tab_naim[1][16][]=251;$build_tab_naim[1][16][]=254;$build_tab_naim[1][16][]=264;
$build_tab_naim[1][16][]=272;$build_tab_naim[1][16][]=278;$build_tab_naim[1][16][]=279;
*/
//нанималки
for($j=1;$j<=4;$j++)
{
	for($k=4;$k<=16;$k++)
	{
		foreach($build_tab_naim[$j][$k] as $i)
		{
			echo "<tr><td align=center>$i</td><td>$build_name[$i]</td><td></td><td>$build_txt[$i]</td><td>";
			echo $build_abil_prn[$i]."</td><td align=center>".$build_gold[$i]."</td><td align=center>".$build_gem[$i]."</td><td>";
			echo $build_res[$i]."</td><td align=center>".$build_slot_prn[$i];
			echo "<br><B><font color=\"blue\">(".$build_slot[get_slot($i)].")</B></font></td><td>";
			echo ($build_upgrade[$i]==0 ? "" : $build_name[$build_upgrade[$i]]."(<B><font color=\"fuchsia\">".$build_upgrade[$i]."</B></font>)")."</td><td>";
			echo substr($build_build[$i],0,-2)."</td><td>".substr($build_in_prn[$i],0,-2)."</td><td align=center>";
			echo (($build_group[$i]==0) ? "" : "<B><font color=\"blue\">$build_group[$i]</B></font><br> (".$b_g_name[$build_group[$i]].")")."</td><td align=center>";
			echo $build_level[$i]."</td><td align=center>".(($build_hidden[$i]==0) ? "" : "Да");
			echo "</td></tr>";
		}
	}
}
echo "</table><br><br>";
echo "<table border=1>";

//форт и оружейная
echo "<tr><td></td><td><B><font color=\"red\">форт и оружейная</B></font></td></tr>";
for($j=2;$j<=3;$j++)
{
	foreach($build_tab[$j] as $i)
	{
		echo "<tr><td align=center>$i</td><td>$build_name[$i]</td><td></td><td>$build_txt[$i]</td><td>";
		echo $build_abil_prn[$i]."</td><td align=center>".$build_gold[$i]."</td><td align=center>".$build_gem[$i]."</td><td>";
		echo $build_res[$i]."</td><td align=center>".$build_slot_prn[$i];
		echo "<br><B><font color=\"blue\">(".$build_slot[get_slot($i)].")</B></font></td><td>";
		echo ($build_upgrade[$i]==0 ? "" : $build_name[$build_upgrade[$i]]."(<B><font color=\"fuchsia\">".$build_upgrade[$i]."</B></font>)")."</td><td>";
		echo substr($build_build[$i],0,-2)."</td><td>".substr($build_in_prn[$i],0,-2)."</td><td align=center>";
		echo (($build_group[$i]==0) ? "" : "<B><font color=\"blue\">$build_group[$i]</B></font><br> (".$b_g_name[$build_group[$i]].")")."</td><td align=center>";
		echo $build_level[$i]."</td><td align=center>".(($build_hidden[$i]==0) ? "" : "Да");
		echo "</td></tr>";
	}
}
echo "</table><br><br>";
echo "<table border=1>";

//торговый квартал
echo "<tr><td></td><td><B><font color=\"red\">торговый квартал</B></font></td></tr>";
//лавки
for($j=20;$j<=27;$j++)
{
	foreach($build_tab[$j] as $i)
	{
		echo "<tr><td align=center>$i</td><td>$build_name[$i]</td><td></td><td>$build_txt[$i]</td><td>";
		echo $build_abil_prn[$i]."</td><td align=center>".$build_gold[$i]."</td><td align=center>".$build_gem[$i]."</td><td>";
		echo $build_res[$i]."</td><td align=center>".$build_slot_prn[$i];
		echo "<br><B><font color=\"blue\">(".$build_slot[get_slot($i)].")</B></font></td><td>";
		echo ($build_upgrade[$i]==0 ? "" : $build_name[$build_upgrade[$i]]."(<B><font color=\"fuchsia\">".$build_upgrade[$i]."</B></font>)")."</td><td>";
		echo substr($build_build[$i],0,-2)."</td><td>".substr($build_in_prn[$i],0,-2)."</td><td align=center>";
		echo (($build_group[$i]==0) ? "" : "<B><font color=\"blue\">$build_group[$i]</B></font><br> (".$b_g_name[$build_group[$i]].")")."</td><td align=center>";
		echo $build_level[$i]."</td><td align=center>".(($build_hidden[$i]==0) ? "" : "Да");
		echo "</td></tr>";
	}
}
echo "</table><br><br>";
echo "<table border=1>";

//амбар...
echo "<tr><td></td><td><B><font color=\"red\">амбар...</B></font></td></tr>";
for($j=17;$j<=19;$j++)
{
	foreach($build_tab[$j] as $i)
	{
		echo "<tr><td align=center>$i</td><td>$build_name[$i]</td><td></td><td>$build_txt[$i]</td><td>";
		echo $build_abil_prn[$i]."</td><td align=center>".$build_gold[$i]."</td><td align=center>".$build_gem[$i]."</td><td>";
		echo $build_res[$i]."</td><td align=center>".$build_slot_prn[$i];
		echo "<br><B><font color=\"blue\">(".$build_slot[get_slot($i)].")</B></font></td><td>";
		echo ($build_upgrade[$i]==0 ? "" : $build_name[$build_upgrade[$i]]."(<B><font color=\"fuchsia\">".$build_upgrade[$i]."</B></font>)")."</td><td>";
		echo substr($build_build[$i],0,-2)."</td><td>".substr($build_in_prn[$i],0,-2)."</td><td align=center>";
		echo (($build_group[$i]==0) ? "" : "<B><font color=\"blue\">$build_group[$i]</B></font><br> (".$b_g_name[$build_group[$i]].")")."</td><td align=center>";
		echo $build_level[$i]."</td><td align=center>".(($build_hidden[$i]==0) ? "" : "Да");
		echo "</td></tr>";
	}
}
echo "</table><br><br>";
echo "<table border=1>";

//магический квартал
echo "<tr><td></td><td><B><font color=\"red\">магический квартал</B></font></td></tr>";
//школы магии
for($j=29;$j<=35;$j++)
{
	foreach($build_tab[$j] as $i)
	{
		echo "<tr><td align=center>$i</td><td>$build_name[$i]</td><td></td><td>$build_txt[$i]</td><td>";
		echo $build_abil_prn[$i]."</td><td align=center>".$build_gold[$i]."</td><td align=center>".$build_gem[$i]."</td><td>";
		echo $build_res[$i]."</td><td align=center>".$build_slot_prn[$i];
		echo "<br><B><font color=\"blue\">(".$build_slot[get_slot($i)].")</B></font></td><td>";
		echo ($build_upgrade[$i]==0 ? "" : $build_name[$build_upgrade[$i]]."(<B><font color=\"fuchsia\">".$build_upgrade[$i]."</B></font>)")."</td><td>";
		echo substr($build_build[$i],0,-2)."</td><td>".substr($build_in_prn[$i],0,-2)."</td><td align=center>";
		echo (($build_group[$i]==0) ? "" : "<B><font color=\"blue\">$build_group[$i]</B></font><br> (".$b_g_name[$build_group[$i]].")")."</td><td align=center>";
		echo $build_level[$i]."</td><td align=center>".(($build_hidden[$i]==0) ? "" : "Да");
		echo "</td></tr>";
	}
}
echo "</table><br><br>";
echo "<table border=1>";

//библиотека...
echo "<tr><td></td><td><B><font color=\"red\">библиотека...</B></font></td></tr>";
for($j=28;$j<=28;$j++)
{
	foreach($build_tab[$j] as $i)
	{
		echo "<tr><td align=center>$i</td><td>$build_name[$i]</td><td></td><td>$build_txt[$i]</td><td>";
		echo $build_abil_prn[$i]."</td><td align=center>".$build_gold[$i]."</td><td align=center>".$build_gem[$i]."</td><td>";
		echo $build_res[$i]."</td><td align=center>".$build_slot_prn[$i];
		echo "<br><B><font color=\"blue\">(".$build_slot[get_slot($i)].")</B></font></td><td>";
		echo ($build_upgrade[$i]==0 ? "" : $build_name[$build_upgrade[$i]]."(<B><font color=\"fuchsia\">".$build_upgrade[$i]."</B></font>)")."</td><td>";
		echo substr($build_build[$i],0,-2)."</td><td>".substr($build_in_prn[$i],0,-2)."</td><td align=center>";
		echo (($build_group[$i]==0) ? "" : "<B><font color=\"blue\">$build_group[$i]</B></font><br> (".$b_g_name[$build_group[$i]].")")."</td><td align=center>";
		echo $build_level[$i]."</td><td align=center>".(($build_hidden[$i]==0) ? "" : "Да");
		echo "</td></tr>";
	}
}
echo "</table><br><br>";
echo "<table border=1>";

//ремесленники, храмы, центр, зрелища, лесной кварталы
echo "<tr><td></td><td><B><font color=\"red\">MISC (копировать частями)</B></font></td></tr>";
for($j=36;$j<=59;$j++)
{
	foreach($build_tab[$j] as $i)
	{
		echo "<tr><td align=center>$i</td><td>$build_name[$i]</td><td></td><td>$build_txt[$i]</td><td>";
		echo $build_abil_prn[$i]."</td><td align=center>".$build_gold[$i]."</td><td align=center>".$build_gem[$i]."</td><td>";
		echo $build_res[$i]."</td><td align=center>".$build_slot_prn[$i];
		echo "<br><B><font color=\"blue\">(".$build_slot[get_slot($i)].")</B></font></td><td>";
		echo ($build_upgrade[$i]==0 ? "" : $build_name[$build_upgrade[$i]]."(<B><font color=\"fuchsia\">".$build_upgrade[$i]."</B></font>)")."</td><td>";
		echo substr($build_build[$i],0,-2)."</td><td>".substr($build_in_prn[$i],0,-2)."</td><td align=center>";
		echo (($build_group[$i]==0) ? "" : "<B><font color=\"blue\">$build_group[$i]</B></font><br> (".$b_g_name[$build_group[$i]].")")."</td><td align=center>";
		echo $build_level[$i]."</td><td align=center>".(($build_hidden[$i]==0) ? "" : "Да");
		echo "</td></tr>";
	}
}
echo "</table><br><br>";

echo "<table border=1>";

//союзники
echo "<tr><td></td><td><B><font color=\"red\">союзники (в принципе, можно и заскриптить, если время будет)</B></font></td></tr>";

$build_tab_ally=array(
191, //(60) Эльфийский квартал
194, //(60) Гномий квартал
197, //(60) Гоблинский квартал
200, //(60) Орочий квартал
203, //(60) Квартал полуросликов
206, //(60) Шатры кентавров
209, //(60) Квартал людоящеров
213, //(60) Эльфийский гарнизон
215, //(60) Великое Дерево
216, //(60) Мастерская рун
218, //(60) Великий чертог
219, //(60) Лачуги гоблинов
221, //(60) Палаты гоблинов
222, //(60) Казармы орков
224, //(60) Военный лагерь
225, //(60) Пригород полуросликов
228, //(60) Лагерь кентавров
230, //(60) Стойбище кентавров
231, //(60) Вечный Источник
233, //(60) Храм Силы
251, //(60) Клетки кобольдов
252, //(60) Гильдия рабовладельцев
253, //(60) Военная школа альваров
260, //(60) Академия Тьмы
264, //(60) Квартал гноллов
265, //(60) Пирамида гноллов
268, //(60) Великая пирамида
272, //(60) Квартал алкари
273, //(60) Белая башня
277, //(60) Сияющий шпиль
278, //(60) Логово крысолюдов
279, //(60) Бараки крысолюдов
280, //(60) Палатка отравителей
192, //(61) Эльфийская пуща
195, //(61) Гильдия горняков
198, //(61) Грязь
201, //(61) Каменный идол
204, //(61) Рынок полуросликов
207, //(61) Священный огонь
210, //(61) Костяной тотем
214, //(61) Эльфийская роща
217, //(61) Залы мастеров
220, //(61) Топь
223, //(61) Каменный истукан
226, //(61) Торжок полуросликов
229, //(61) Священное пламя
232, //(61) Костяной идол
254, //(61) Лагерь разведчиков
255, //(61) Тёмный путь
256, //(61) Крепость охотников
261, //(61) Сердце Ночи
266, //(61) Палатка шамана
274, //(61) Небесное око
276, //(61) Менторий
281, //(61) Храм Чумы
283, //(61) Палатка колдуна
284, //(61) Палатка чародея
193, //(62) Эльфийский театр
196, //(62) Гномья Кузня
199, //(62) Загоны тварей
202, //(62) Знамя Орды
205, //(62) Ярмарка полуросликов
208, //(62) Шатер Клана
211, //(62) Омут
227, //(62) Великая Кузня
257, //(62) Храм Тени
258, //(62) Башня Тени
259, //(62) Цитадель Тени
267, //(62) Шатёр вожака
275, //(62) Кристальные столпы
282 //(62) Великий алтарь
);
$build_tab_ally=array(191,213,215,192,214,193,194,216,218,195,217,196,227,197,219,221,198,220,199,200,222,224,201,223,202,203,225,204,226,
205,206,228,230,207,229,208,209,231,233,210,232,211,251,252,253,260,254,255,256,261,257,258,259,264,265,268,266,283,284,267,272,273,277,274,276,275,278,279,280,281,282);
//в принципе, можно и заскриптить, если время будет...
foreach($build_tab_ally as $i)
{
	echo "<tr><td align=center>$i</td><td>$build_name[$i]</td><td></td><td>$build_txt[$i]</td><td>";
	echo $build_abil_prn[$i]."</td><td align=center>".$build_gold[$i]."</td><td align=center>".$build_gem[$i]."</td><td>";
	echo $build_res[$i]."</td><td align=center>".$build_slot_prn[$i];
	echo "<br><B><font color=\"blue\">(".$build_slot[get_slot($i)].")</B></font></td><td>";
	echo ($build_upgrade[$i]==0 ? "" : $build_name[$build_upgrade[$i]]."(<B><font color=\"fuchsia\">".$build_upgrade[$i]."</B></font>)")."</td><td>";
	echo substr($build_build[$i],0,-2)."</td><td>".substr($build_in_prn[$i],0,-2)."</td><td align=center>";
	echo (($build_group[$i]==0) ? "" : "<B><font color=\"blue\">$build_group[$i]</B></font><br> (".$b_g_name[$build_group[$i]].")")."</td><td align=center>";
	echo $build_level[$i]."</td><td align=center>".(($build_hidden[$i]==0) ? "" : "Да");
	echo "</td></tr>";
}
echo "</table><br><br>";

echo "\$build_tab_ally=array(<br>";
for($j=60;$j<=62;$j++)
{
	foreach($build_tab[$j] as $i)
	{
		echo $i.", //($j) $build_name[$i]<br>";
	}
}
echo ");";

//echo "<table width=100% border=1>";
//dumper($build_tab);

//вывод спойлера о карме
$f=fopen("Inner_Build_spoil.txt","w") or die("Ошибка при создании файла Inner_Build_spoil.txt");
for($i = 0; $i < $count_b_txt; $i++)
{
	if($karma_flag[$i] != 0)
		fwrite($f,"#[Карма: ".($karma_flag[$i] > 0 ? "+" : "").$karma_flag[$i]."]\n".substr(trim($b_txt_file[$i]),1));
	else
		fwrite($f,$b_txt_file[$i]);
}
fclose($f);

?>
<br><a href='index.html'>вернуться к списку файлов</a>
</html>