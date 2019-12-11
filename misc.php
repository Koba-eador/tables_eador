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
$a_file = file("stat_progress.var");
$count_f = count($a_file);
$stat_file = file("stat.var");
$count_stat = count($stat_file);
$class_file = file("hero_class.var");
$count_class = count($class_file);
$abil_file = file("ability_num.var");
$count_abil = count($abil_file);
$class_d_file_txt = file("Hero_class_d.txt");
$count_class_d_txt = count($class_d_file_txt);
$class_file_txt = file("Hero_class.txt");
$count_class_txt = count($class_file_txt);
$u_file = file("unit.var");
$count_u = count($u_file);
$up_file = file("unit_upg2.var");
$count_up = count($up_file);
$item_set_file = file("item_set.var");
$count_item_set = count($item_set_file);
$item_file = file("item.var");
$count_item = count($item_file);

$max=0;$max1=0;$max_u=0;$max_e=0;$t[0]=0;$j=0;
$u1=-1;$u2=0;$u3=0;	//№ строки юнита в xls
$g1=0; //кол-во стражей в одном сайте
$a1=1; //№ абилки
$a2=1; //№ эффекта ritual
$p=""; //для печати без последней ";"

$hero_up = array_merge(range(40,43),range(238,253),range(263,278));//апы героя
$hero_up_class[1] = array(40,238,239,240,241,263,264,265,266);//номера юнитов разных мультиклассов Воин
$hero_up_class[2] = array(41,242,243,244,245,267,268,269,270);//номера юнитов разных мультиклассов Разведчик
$hero_up_class[3] = array(42,246,247,248,249,271,272,273,274);//номера юнитов разных мультиклассов Командир
$hero_up_class[4] = array(43,250,251,252,253,275,276,277,278);//номера юнитов разных мультиклассов Волшебник

//$MM="";//распределение числа и уровней заклятий по уровням магии
$magic_add="";//Дополнительные слоты для заклинаний из абилок 901-904

//сопоставление имён классов с реальным порядком
$ref=array(1=>1,2,3,4,5,21,6,22,7,23,8,24,9,25,10,26,11,27,12,28,13,29,14,30,15,31,16,32,17,33,18,34,19,35,20,36);

$abil_name[901]="Дополнительный слот для заклинания I круга";
$abil_name[902]="Дополнительный слот для заклинания II круга";
$abil_name[903]="Дополнительный слот для заклинания III круга";
$abil_name[904]="Дополнительный слот для заклинания IV круга";
$abil_name[951]="Дополнительный слот для воина I круга";
$abil_name[952]="Дополнительный слот для воина II круга";
$abil_name[953]="Дополнительный слот для воина III круга";
$abil_name[954]="Дополнительный слот для воина IV круга";

$item_class[1]=array(0,1,2,6,7,8,9); //типы предметов, которые может носить Воин
$item_class[2]=array(0,1,3,6); //типы предметов, которые может носить Разведчик
$item_class[3]=array(0,1,5,6,7,9); //типы предметов, которые может носить Командир
$item_class[4]=array(0,4); //типы предметов, которые может носить Волшебник


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
    if(eregi("^Class:",$item_file[$i]))
    {
		$s=explode(':',$item_file[$i]);
		$class_table[$n]=$s[1]+1-1;
//echo $n."-".$class_table[$n]."<br>";
    }
}

//Разбор item_set.var
for($i = 0,$n=0; $i < $count_item_set; $i++)
{
	if(eregi("^/([0-9]{1,})",$item_set_file[$i],$k))
	{
		$n=$k[1];
 		if($n>$max1)$max1=$n;
	}
	else
	if(eregi("^name",$item_set_file[$i]))
	{
		$s=explode(':',$item_set_file[$i]);
		$item_set_name[$n]=substr(trim($s[1]),0,-1);
		$i++;
		$s=explode(':',$item_set_file[$i]);
		$item_set_num[$n]=$s[1]+1-1;
		$i++;
		$s=explode(':',$item_set_file[$i]);
		$s1=explode(',',$s[1]);
		for($j=0;$j<$item_set_num[$n];$j++)
		{
			$item_set_items[$n][$j]=$class_table[$s1[$j]+1-1];
//echo 	$item_set_items[$n][$j].", ";
		}
//echo "<br>";
//		if($n!=0)//к-во пропускаемых ячеек - для учёта объединённых ячеек
//			$item_set_num_merge[$n] = $item_set_num_merge[$n-1]+$s[1]+1-1;
	}
}

//Разбор ability_num.var
for($i = 0,$n=0; $i < $count_abil; $i++)
{ 
   if(eregi("^/([0-9]{1,})",$abil_file[$i],$k))
    {
		$n=$k[1];
    }
    else
    if(eregi("^Name",$abil_file[$i]))
    {
		$s=explode(':',$abil_file[$i]); //name
		$i++;
		$s1=explode(':',$abil_file[$i]); //number
		$i++;
		$s2=explode(':',$abil_file[$i]); //numeric
		$i++;
		$s3=explode(':',$abil_file[$i]); //Effect
		$i++;
		$s4=explode(':',$abil_file[$i]); //Percent
		if($abil_name[$s1[1]+1-1]!="")
			echo "<B><font color=\"red\">!!! num=".$n."-ABIL_NUM =".$s1[1]."-- (".$abil_name[$s1[1]+1-1].") УЖЕ ЕСТЬ</font></B><br>";
		$abil_name[$s1[1]+1-1]=substr(trim($s[1]),0,-1);
		$abil_numeric[$s1[1]+1-1]=$s2[1]+1-1;
		$abil_percent[$s1[1]+1-1]=$s4[1]+1-1;
    }
}
$abil_numeric[23] = 1;//Сбор снарядов
$abil_numeric[67] = 1;//Корни
$abil_numeric[158] = 1;//Оплетающий выстрел
$abil_numeric[984] = 1;//Быстрое колдовство

//Разбор unit_upg.var
for($i = 0,$n=0; $i < $count_up; $i++)
{
	if(eregi("^/([0-9]{1,})",$up_file[$i],$k))
    {
		$n=$k[1];
    }
    else
    if(eregi("^name",$up_file[$i]))
    {
		$s=explode(':',$up_file[$i]);
		$s=substr(trim($s[1]),0,-1);
		$up_name[$n]=$s;
    }
    else
    if(eregi("^Upg",$up_file[$i]))
    {
		for($j=0;$j<16;$j++)
		{
			$s=explode(':',$up_file[$i]);
			$up_type[$n][$j] = $s[1]+1-1;
			$i++;
			$s1=explode(':',$up_file[$i]);
			$up_quantity[$n][$j] = $s1[1]+1-1;
			if(substr(trim($up_file[$i]),-1,1)==";") break; //for
			$i++;
			while(1)
				if(trim($up_file[$i]) == "") //пустая строка
					$i++;
				else
					break;
		}
	}
}
$up_name[0]="";

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
		if(in_array($n,$hero_up))//апы героя
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
    if(eregi("^Life:",$u_file[$i]))
    {
		$s=explode(':',$u_file[$i]);
		$unit_life[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^Attack:",$u_file[$i]))
    {
		$s=explode(':',$u_file[$i]);
		$attack_table[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^CounterAttack:",$u_file[$i]))
    {
		$s=explode(':',$u_file[$i]);
		$c_attack_table[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^Defence:",$u_file[$i]))
    {
		$s=explode(':',$u_file[$i]);
		$defence_table[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^RangedDefence:",$u_file[$i]))
    {
		$s=explode(':',$u_file[$i]);
		$r_defence_table[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^Resist:",$u_file[$i]))
    {
		$s=explode(':',$u_file[$i]);
		$resist_table[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^Speed:",$u_file[$i]))
    {
		$s=explode(':',$u_file[$i]);
		$speed_table[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^RangedAttack:",$u_file[$i]))
    {
		$s=explode(':',$u_file[$i]);
		if(($s[1]+1-1) != 0)
			$r_attack_table[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^ShootingRange:",$u_file[$i]))
    {
		$s=explode(':',$u_file[$i]);
		if(($s[1]+1-1) != 0)
			$s_range_table[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^Morale:",$u_file[$i]))
    {
		$s=explode(':',$u_file[$i]);
		$unit_morale[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^Stamina:",$u_file[$i]))
    {
		$s=explode(':',$u_file[$i]);
		$unit_stamina[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^Abilityes:",$u_file[$i]) && in_array($n,$hero_up))//добавочные абилки при изменении базового юнита героя на другой юнит
    {
		$i++;
		for($j=0;$j<20;$j++)
		{
			$s=explode(':',$u_file[$i]);
			$s1 = $s[1]+1-1;
			if($s1 != 0)
			{
				$u_abil[$n] .= $up_name[$s1];
				if(count($up_type[$s1]) > 1)
				{
					$u_abil[$n] .= " [";
					foreach($up_type[$s1] as $idx => $up)
					{
						$qua = $up_quantity[$s1][$idx];
//						$u_abil[$n] .= $abil_name[$up];
						if($abil_numeric[$up]==0)
						{
							$u_abil[$n] .= $abil_name[$up];
//							if($qua<0)
//								$up_abil[$n] .= "</font></B>";
							$up_abil[$n] .= "; ";
						}
						else
							$u_abil[$n] .= $abil_name[$up].($qua<0 ? " <B><font color=\"red\">$qua" : " <B><font color=\"green\">+$qua").($abil_percent[$up]==1 ? "%" : "")."</font></B>; ";
					}
					$u_abil[$n] = substr($u_abil[$n],0,-2)."]";
				}
				$u_abil[$n] .= "; ";
			}
			if(substr(trim($u_file[$i]),-1,1)==";") break; //for
			$i++;
		}
    }
}

/*			if($unit_life[$u] != $unit_life[$units[0]])
				$add_life[$u] = "Жизнь +".($unit_life[$u] - $unit_life[$units[0]]);
			if($unit_morale[$u] != $unit_morale[$units[0]])
				$add_morale[$u] = "Мораль +".($unit_morale[$u] - $unit_morale[$units[0]]);
			if($unit_stamina[$u] != $unit_stamina[$units[0]])
				$add_stamina[$u] = "Выносливость +".($unit_stamina[$u] - $unit_stamina[$units[0]]);
			if($attack_table[$u] != $attack_table[$units[0]])
				$add_attack[$u] = "Атака +".($attack_table[$u] - $attack_table[$units[0]]);
			if($c_attack_table[$u] != $c_attack_table[$units[0]])
				$add_c_attack[$u] = "Контратака +".($c_attack_table[$u] - $c_attack_table[$units[0]]);
			if($defence_table[$u] != $defence_table[$units[0]])
				$add_defence[$u] = "Защита +".($defence_table[$u] - $defence_table[$units[0]]);
			if($r_defence_table[$u] != $r_defence_table[$units[0]])
				$add_r_defence[$u] = "Защита от выстрела +".($r_defence_table[$u] - $r_defence_table[$units[0]]);
			if($resist_table[$u] != $resist_table[$units[0]])
				$add_resist[$u] = "Сопротивление +".($resist_table[$u] - $resist_table[$units[0]]);
			if($speed_table[$u] != $speed_table[$units[0]])
				$add_speed[$u] = "Скорость +".($speed_table[$u] - $speed_table[$units[0]]);
*/
foreach($hero_up_class as $cl => $units)//добавочные параметры при изменении базового юнита героя на другой юнит
{
	foreach($units as $idx => $u)
	{
		if($idx != 0)
		{
			if($unit_life[$u] != $unit_life[$units[0]])
			{
				$add_life[$u] = $unit_life[$u] - $unit_life[$units[0]];
				$add_param[$u] .= "Жизнь +".$add_life[$u]."; ";
			}
			if($unit_morale[$u] != $unit_morale[$units[0]])
			{
				$add_morale[$u] = $unit_morale[$u] - $unit_morale[$units[0]];
				$add_param[$u] .= "Мораль +".$add_morale[$u]."; ";
			}
			if($unit_stamina[$u] != $unit_stamina[$units[0]])
			{
				$add_stamina[$u] = $unit_stamina[$u] - $unit_stamina[$units[0]];
				$add_param[$u] .= "Выносливость +".$add_stamina[$u]."; ";
			}
			if($attack_table[$u] != $attack_table[$units[0]])
			{
				$add_attack[$u] = $attack_table[$u] - $attack_table[$units[0]];
				$add_param[$u] .= "Атака +".$add_attack[$u]."; ";
			}
			if($c_attack_table[$u] != $c_attack_table[$units[0]])
			{
				$add_c_attack[$u] = $c_attack_table[$u] - $c_attack_table[$units[0]];
				$add_param[$u] .= "Контратака +".$add_c_attack[$u]."; ";
			}
			if($defence_table[$u] != $defence_table[$units[0]])
			{
				$add_defence[$u] = $defence_table[$u] - $defence_table[$units[0]];
				$add_param[$u] .= "Защита +".$add_defence[$u]."; ";
			}
			if($r_defence_table[$u] != $r_defence_table[$units[0]])
			{
				$add_r_defence[$u] = $r_defence_table[$u] - $r_defence_table[$units[0]];
				$add_param[$u] .= "Защита от выстрела +".$add_r_defence[$u]."; ";
			}
			if($resist_table[$u] != $resist_table[$units[0]])
			{
				$add_resist[$u] = $resist_table[$u] - $resist_table[$units[0]];
				$add_param[$u] .= "Сопротивление +".$add_resist[$u]."; ";
			}
			if($speed_table[$u] != $speed_table[$units[0]])
			{
				$add_speed[$u] = $speed_table[$u] - $speed_table[$units[0]];
				$add_param[$u] .= "Скорость +".$add_speed[$u]."; ";
			}
		}
	}
}
/*
dumper($add_life,"add_life");
dumper($add_morale,"add_morale");
dumper($add_stamina,"add_stamina");
dumper($add_attack,"add_attack");
dumper($add_c_attack,"add_c_attack");
dumper($add_defence,"add_defence");
dumper($add_r_defence,"add_r_defence");
dumper($add_resist,"add_resist");
dumper($add_speed,"add_speed");
dumper($add_param,"add_param");
*/
//Разбор stat.var
for($i = 0; $i < $count_stat; $i++)
{  
	if(eregi("^Lvl",$stat_file[$i]))
	{
		for($j=1;$j<=10;$j++)
		{
			$s=explode(':',$stat_file[$i]);//Lvl4: 4, 2, 1
			$s1=explode(',',$s[1]);//4, 2, 1
			$stat_table[$a1][$j][0]=$s1[0]+1-1;//4
			$stat_dif[$a1][$j][0]=$stat_dif[$a1][$j-1][0]+$s1[0];//накопительная сумма
			$stat_table[$a1][$j][1]=$s1[1]+1-1;//2
			$stat_dif[$a1][$j][1]=$stat_dif[$a1][$j-1][1]+$s1[1];
			$stat_table[$a1][$j][2]=$s1[2]+1-1;//1
			$stat_dif[$a1][$j][2]=$stat_dif[$a1][$j-1][2]+$s1[2];
//echo $j."-a1=".$a1." ".$stat_table[$a1][$j][0]." ".$stat_table[$a1][$j][1]." ".$stat_table[$a1][$j][2]."<br>";
			$i++;
		}
//echo $stat_dif[$a1][$j-1][0]." ".$stat_dif[$a1][$j-1][1]." ".$stat_dif[$a1][$j-1][2]."<br>";
		$a1++;
//$a1==1 - Health (Life, Stamina, Morale)
//$a1==2 - Magic (Slot1, Slot2)
//$a1==3 - Leader (Slot1, Slot2)
	}
}

//Разбор hero_class.var
for($i = 0,$n=0; $i < $count_class; $i++)
{  
   if(eregi("^/([0-9]{1,})",$class_file[$i],$k))
    {
		$n=$k[1];
    }
    else
    if(eregi("^name",$class_file[$i]))
    {
		$s=explode(':',$class_file[$i]);
		$class_name[$n]=substr(trim($s[1]),0,-1);
    }
    else
    if(eregi("^Talent",$class_file[$i]))
    {
		for($j=1;$j<=5;$j++)
		{
			$s=explode(':',$class_file[$i]);
			$s1=explode(',',$s[1]);
			$class_talent[$n][$j][0]=$s1[0]+1-1;//имя
			$class_talent[$n][$j][1]=$s1[1]+1-1;//значение
			$i++;
		}
    }
}

//-------------------------------------------------------------
//Разбор основного файла
/*
$H[1]=22;$H[2]=17;$H[3]=15;$H[4]=14;//начальные значения Жизнь
$S[1]=10;$S[2]=10;$S[3]=10;$S[4]=10;//начальные значения Выносливость
$M[1]=10;$M[2]=10;$M[3]=10;$M[4]=10;//начальные значения Боевой дух
*/
$H[1]=$unit_life[40];$H[2]=$unit_life[41];$H[3]=$unit_life[42];$H[4]=$unit_life[43];//начальные значения Жизнь
$S[1]=$unit_stamina[40];$S[2]=$unit_stamina[41];$S[3]=$unit_stamina[42];$S[4]=$unit_stamina[43];//начальные значения Выносливость
$M[1]=$unit_morale[40];$M[2]=$unit_morale[41];$M[3]=$unit_morale[42];$M[4]=$unit_morale[43];//начальные значения Боевой дух

for($i = 0,$n=0; $i < $count_f; $i++)
{  //echo "<br>".$a_file[$i];
	if(eregi("^/([0-9]{1,})",$a_file[$i],$k))
	{
		$n=$k[1];
		if($n>$max)$max=$n;
    }
    else
    if(eregi("^Health",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$progress_health[$n]=$s[1]+1-1;
	}
    else
    if(eregi("^Magic",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$progress_magic[$n]=$s[1]+1-1;
	}
    else
    if(eregi("^Leader",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$progress_leader[$n]=$s[1]+1-1;
	}
}

//------------------------------------------------------------

/*
//вывод Максов
for($i=1;$i<$max+1;$i++)
{
//вывод name
//echo $n."-".$s[1]." REF=".$ref[$n]." CLASS=".$class_name[$ref[$n]]."<br>";
//	echo $i."-".$class_name[$ref[$i]]." ";
	for($j=1;$j<=$progress_health[$i];$i++)
	{
		
	}
}
*/

echo "<font color=\"fuchsia\"><B>Здоровье:</B></font><br>";
for($i=1;$i<=9;$i++)
{
	echo "<font color=\"red\"><B>0".$i."</B></font> - Жизнь: <font color=\"blue\"><B>+".$stat_dif[1][$i][0];
	echo "</B></font> Выносливость: <font color=\"blue\"><B>+".$stat_dif[1][$i][1];
	echo "</B></font> Мораль: <font color=\"blue\"><B>+".$stat_dif[1][$i][2]."</B></font><br>";
}
echo "<font color=\"red\"><B>10</B></font> - Жизнь: <font color=\"blue\"><B>+".$stat_dif[1][10][0];
echo "</B></font> Выносливость: <font color=\"blue\"><B>+".$stat_dif[1][10][1];
echo "</B></font> Мораль: <font color=\"blue\"><B>+".$stat_dif[1][10][2]."</B></font><br><br>";

echo "<font color=\"fuchsia\"><B>Магия:</B></font><br>";
for($i=1;$i<=10;$i++)
{
//stat.var: Magic (Slot1, Slot2) Lvl5: 2, 1, 0
	$MM[$stat_table[2][$i][0]]++;//Lvl [$i]: [2]++
	$MM[$stat_table[2][$i][1]]++;//Lvl [$i]: [1]++
	$MM[$stat_table[2][$i][2]]++;//Lvl [$i]: [0]++
	$magic[$i]="Ур1:<font color=\"blue\"><B>".($MM[1]+3)."</B></font> Ур2:<font color=\"blue\"><B>".($MM[2]+1-1)."</B></font> Ур3:<font color=\"blue\"><B>".($MM[3]+1-1)."</B></font> Ур4:<font color=\"blue\"><B>".($MM[4]+1-1)."</B></font>";
}
for($i=1;$i<=9;$i++)
{
	echo "<font color=\"red\"><B>0".$i."</B></font> - ".$magic[$i]."<br>";
}
echo "<font color=\"red\"><B>10</B></font> - ".$magic[10]."<br><br>";

echo "<font color=\"fuchsia\"><B>Командование:</B></font><br>";
for($i=1;$i<=10;$i++)
{
//stat.var: Leader (Slot1, Slot2) Lvl5: 2, 1, 0
	$LL[$stat_table[3][$i][0]]++;//Lvl [$i]: [2]++
	$LL[$stat_table[3][$i][1]]++;//Lvl [$i]: [1]++
	$LL[$stat_table[3][$i][2]]++;//Lvl [$i]: [0]++
	$leader[$i]="Ур1:<font color=\"blue\"><B>".($LL[1]+3)."</B></font> Ур2:<font color=\"blue\"><B>".($LL[2]+1-1)."</B></font> Ур3:<font color=\"blue\"><B>".($LL[3]+1-1)."</B></font> Ур4:<font color=\"blue\"><B>".($LL[4]+1-1)."</B></font>";
}
for($i=1;$i<=9;$i++)
{
	echo "<font color=\"red\"><B>0".$i."</B></font> - ".$leader[$i]."<br>";
}
echo "<font color=\"red\"><B>10</B></font> - ".$leader[10]."<br><br>";

echo "<table width=100% border=1><tr><td>№</td><td>Abil</td><td>Health</td><td>Magic</td><td>Leader</td></tr>";

for($j=1;$j<=4;$j++)
{
	$class_name_sort[$a2]=$class_name[$j];//название класса в правильном порядке
	$hero_class[$j]=$class_name[$j];//Воин Разведчик Командир Волшебник
	$H1[$j]=$H[$j]+$stat_dif[1][$progress_health[$j]][0];
	$S1[$j]=$S[$j]+$stat_dif[1][$progress_health[$j]][1];
	$M1[$j]=$M[$j]+$stat_dif[1][$progress_health[$j]][2];
	echo "<tr><td align=center><font color=\"blue\">".$class_name[$j]."</font></td><td></td>";
	echo "<td align=center><font color=\"red\"><B>( ".$progress_health[$j]." )</B></font><br>";
	echo "Жизнь:<font color=\"blue\"><B>".$H1[$j]."</B></font><br>";
	echo "Выносливость:<font color=\"blue\"><B>".$S1[$j]."</B></font><br>";
	echo "Боевой дух:<font color=\"blue\"><B>".$M1[$j]."</B></font><br></td><td align=center>";
	echo "<font color=\"red\"><B>( ".$progress_magic[$j]." )</B></font><br>";
	echo $magic[$progress_magic[$j]]."</td><td align=center>";
	echo "<font color=\"red\"><B>( ".$progress_leader[$j]." )</B></font><br>";
	echo $leader[$progress_leader[$j]]."</td></tr>";
	$a2++; //сквозной номер класса hero_class.var (1-36)
}
$a3=5; //сквозной номер класса stat_progress.var (1-20)
for($j=1;$j<=4;$j++)
{
	for($k=1;$k<=4;$k++)
	{
		$LIFE = 0;//добавки параметров от смены героев для столбца "Макс Здоровье"
		$MORALE = 0;
		$STAMINA = 0;
		$class_name_sort[$a2]=$class_name[$ref[$a2]];
		$item_class[$a2]=array_merge($item_class[$j],$item_class[$k]);
		echo "<tr><td align=center><font color=\"blue\">".$hero_class[$j]."-".$hero_class[$k];
		echo "</font><br>10-19 уровень<br><font color=\"fuchsia\">(".$class_name_sort[$a2].")</font></td><td>";
		for($t=1;$t<=5;$t++)
		{
/*			if($class_talent[$ref[$a2]][$t][0]==0) break;
			$p=$p.$t.") ";
			if($class_talent[$ref[$a2]][$t][0]==960) //смена героя на др. юнит
			{
				$p=$p."Изменение базового юнита героя на юнит <font color=\"brown\"><B>".$u_name[$class_talent[$ref[$a2]][$t][1]]."</B></font>;<br>";
			}
			else
			if($class_talent[$ref[$a2]][$t][0]>1000) //командирские умения
				if(($abil_numeric[$class_talent[$ref[$a2]][$t][0]-1000]) == 0)//одноразодаваемые абилки
					$p=$p.$abil_name[$class_talent[$ref[$a2]][$t][0]-1000]." <font color=\"aqua\">(Отряд)</font>;<br>";
				else
					$p=$p.$abil_name[$class_talent[$ref[$a2]][$t][0]-1000]." <font color=\"green\"><B>+".$class_talent[$ref[$a2]][$t][1]."</B></font> <font color=\"aqua\">(Отряд)</font>;<br>";
			else
				if(($abil_numeric[$class_talent[$ref[$a2]][$t][0]]) == 0)//одноразодаваемые абилки
					$p=$p.$abil_name[$class_talent[$ref[$a2]][$t][0]].";<br>";
				else
					$p=$p.$abil_name[$class_talent[$ref[$a2]][$t][0]]." <font color=\"green\"><B>+".$class_talent[$ref[$a2]][$t][1]."</B></font>;<br>";
*/
			$num0=$class_talent[$ref[$a2]][$t][0];
			$num1=$class_talent[$ref[$a2]][$t][1];
			if($num0==0) break;
			$p .= $t.") ";
			if($num0==901) //Дополнительный слот для заклинания I круга
				$magic_add[1] += $num1;
			if($num0==902) //Дополнительный слот для заклинания II круга
				$magic_add[2] += $num1;
			if($num0==903) //Дополнительный слот для заклинания III круга
				$magic_add[3] += $num1;
			if($num0==904) //Дополнительный слот для заклинания IV круга
				$magic_add[4] += $num1;
			if($num0==951) //Дополнительный слот для воина I круга
				$leader_add[1] += $num1;
			if($num0==952) //Дополнительный слот для воина II круга
				$leader_add[2] += $num1;
			if($num0==953) //Дополнительный слот для воина III круга
				$leader_add[3] += $num1;
			if($num0==954) //Дополнительный слот для воина IV круга
				$leader_add[4] += $num1;
			if($num0==960) //смена героя на др. юнит
			{
				$p .= "Изменение базового юнита героя на юнит <font color=\"brown\"><B>".$u_name[$num1]."</B></font>";
				if(isset($u_abil[$num1]) || isset($add_param[$num1]))
				{
					$p .= ":<br><font color=\"fuchsia\">Переносимые умения от нового юнита:</font><B> ";
					if(isset($u_abil[$num1]))
						$p .= substr($u_abil[$num1],0,-2);
					if(isset($add_param[$num1]))
					{
						if(isset($u_abil[$num1]))
							$p .= "; ";
						$p .= substr($add_param[$num1],0,-2);
					}
				}
				$p .= "</B>;<br>";
				$LIFE += $add_life[$num1];
				$MORALE += $add_morale[$num1];
				$STAMINA += $add_stamina[$num1];
			}
			else
			if($abil_name[$num0]=="" && $num0<1000)
				$p .= "!!!Неизвестная абилка $num0<br>";
			else
			if($num0>1000) //командирские умения
			{
				if(($abil_numeric[$num0-1000]) == 0)//одноразодаваемые абилки
					$p .= $abil_name[$num0-1000]." <font color=\"aqua\">(Отряд)</font>;<br>";
				else
					$p .= $abil_name[$num0-1000]." <font color=\"green\"><B>+".$num1.($abil_percent[$num0]==1 ? "%" : "")."</B></font> <font color=\"aqua\">(Отряд)</font>;<br>";
			}
			else
			{
				if(($abil_numeric[$num0]) == 0)//одноразодаваемые абилки
					$p .= $abil_name[$num0].";<br>";
				else
				if($num0==983)//Снижение цены заклятий
					$p .= $abil_name[$num0]." <font color=\"green\"><B>на ".$num1."%</B></font>;<br>";
				else
				if($num0==984)//два заклинания за один ход
				{
					$quick += $num1;
					$p .= $abil_name[$num0]." (суммарный уровень <= <font color=\"blue\"><B>".$quick."</B></font>);<br>";
				}
				else
				if($num0==20)//Дополнительный выстрел
					$p .= $abil_name[$num0]." (<font color=\"green\"><B>расход энергии ".($num1>=0 ? "</font><font color=\"blue\">$num1" : "уменьшен на </font><font color=\"blue\">".abs($num1))."</B></font>);<br>";
				else
					$p .= $abil_name[$num0]." <font color=\"green\"><B>+".$num1.($abil_percent[$num0]==1 ? "%" : "")."</B></font>;<br>";
			}
		}
		echo substr($p,0,-5);
		$p="";
		echo "</td><td align=center>";
		$H1[$j]=$H[$j]+$stat_dif[1][$progress_health[$j]+$progress_health[$a3]][0]+$LIFE;
		$S1[$j]=$S[$j]+$stat_dif[1][$progress_health[$j]+$progress_health[$a3]][1]+$STAMINA;
		$M1[$j]=$M[$j]+$stat_dif[1][$progress_health[$j]+$progress_health[$a3]][2]+$MORALE;
//echo "($j)<br>";
		echo "<font color=\"red\"><B>( ".($progress_health[$j]+$progress_health[$a3])." )</B></font><br>";
		echo "Жизнь:<font color=\"blue\"><B>".$H1[$j]."</B></font><br>";
		echo "Выносливость:<font color=\"blue\"><B>".$S1[$j]."</B></font><br>";
		echo "Боевой дух:<font color=\"blue\"><B>".$M1[$j]."</B></font><br></td><td align=center>";
		$M_idx = $progress_magic[$j]+$progress_magic[$a3];
		$M_print = $magic[$M_idx];
		echo "<font color=\"red\"><B>( $M_idx )</B></font><br>";
//$magic[$i]="Ур1:<font color=\"blue\"><B>".($MM[1]+3)."</B></font> Ур2:<font color=\"blue\"><B>".($MM[2]+1-1)."</B></font> Ур3:<font color=\"blue\"><B>".($MM[3]+1-1)."</B></font> Ур4:<font color=\"blue\"><B>".($MM[4]+1-1)."</B></font>";
//		substr_replace($magic[$M_idx],($MM[$M_idx][1]+3+$magic_add[1]),4,1);
//		substr_replace($magic[$M_idx],($MM[$M_idx][2]+$magic_add[2]),10,1);
//		substr_replace($magic[$M_idx],($MM[$M_idx][3]+$magic_add[3]),16,1);
//		substr_replace($magic[$M_idx],($MM[$M_idx][4]+$magic_add[4]),22,1);
//		echo "1=".$MM[$M_idx][1]." 2=".$MM[$M_idx][2]." 3=".$MM[$M_idx][3]." 4=".$MM[$M_idx][4];
//		echo $magic[$M_idx]{143}."|";
		$M_print{26} = $M_print{26} + $magic_add[1];
		$M_print{65} = $M_print{65} + $magic_add[2];
		$M_print{104} = $M_print{104} + $magic_add[3];
		$M_print{143} = $M_print{143} + $magic_add[4];
		echo $M_print."</td><td align=center>";
		$L_idx = $progress_leader[$j]+$progress_leader[$a3];
		$L_print = $leader[$L_idx];
		echo "<font color=\"red\"><B>( $L_idx )</B></font><br>";
//		echo "<font color=\"red\"><B>( ".($progress_leader[$j]+$progress_leader[$a3])." )</B></font><br>";
//		echo $leader[$progress_leader[$j]+$progress_leader[$a3]]."</td></tr>";
		$L_print{26} = $L_print{26} + $leader_add[1];
		$L_print{65} = $L_print{65} + $leader_add[2];
		$L_print{104} = $L_print{104} + $leader_add[3];
		$L_print{143} = $L_print{143} + $leader_add[4];
		echo $L_print."</td></tr>";
		$a3++;
//		$magic_add = "";
//		$leader_add = "";
//		echo "</td></tr>";
		$a2++;
		$LIFE = 0;//добавки параметров от смены героев для столбца "Макс Здоровье"
		$MORALE = 0;
		$STAMINA = 0;
		$class_name_sort[$a2]=$class_name[$ref[$a2]];
		$item_class[$a2]=array_merge($item_class[$j],$item_class[$k]);
		echo "<tr><td align=center><font color=\"blue\">".$hero_class[$j]."-".$hero_class[$k];
		echo "</font><br>20-30 уровень<br><font color=\"fuchsia\">(".$class_name_sort[$a2].")</font></td><td>";
		for($t=1;$t<=5;$t++)
		{
/*			if($class_talent[$ref[$a2]][$t][0]==0) break;
			$p=$p.$t.") ";
			if($class_talent[$ref[$a2]][$t][0]==960) //смена героя на др. юнит
			{
				$p=$p."Изменение базового юнита героя на юнит <font color=\"brown\"><B>".$u_name[$class_talent[$ref[$a2]][$t][1]]."</B></font>;<br>";
			}
			else
			if($class_talent[$ref[$a2]][$t][0]>1000) //командирские умения
				if(($abil_numeric[$class_talent[$ref[$a2]][$t][0]-1000]) == 0)//одноразодаваемые абилки
					$p=$p.$abil_name[$class_talent[$ref[$a2]][$t][0]-1000]." <font color=\"aqua\">(Отряд)</font>;<br>";
				else
					$p=$p.$abil_name[$class_talent[$ref[$a2]][$t][0]-1000]." <font color=\"green\"><B>+".$class_talent[$ref[$a2]][$t][1]."</B></font> <font color=\"aqua\">(Отряд)</font>;<br>";
			else
				if(($abil_numeric[$class_talent[$ref[$a2]][$t][0]]) == 0)//одноразодаваемые абилки
					$p=$p.$abil_name[$class_talent[$ref[$a2]][$t][0]].";<br>";
				else
					$p=$p.$abil_name[$class_talent[$ref[$a2]][$t][0]]." <font color=\"green\"><B>+".$class_talent[$ref[$a2]][$t][1]."</B></font>;<br>";
*/
			$num0=$class_talent[$ref[$a2]][$t][0];
			$num1=$class_talent[$ref[$a2]][$t][1];
			if($num0==0) break;
			$p .= $t.") ";
			if($num0==901) //Дополнительный слот для заклинания I круга
				$magic_add[1] += $num1;
			if($num0==902) //Дополнительный слот для заклинания II круга
				$magic_add[2] += $num1;
			if($num0==903) //Дополнительный слот для заклинания III круга
				$magic_add[3] += $num1;
			if($num0==904) //Дополнительный слот для заклинания IV круга
				$magic_add[4] += $num1;
			if($num0==951) //Дополнительный слот для воина I круга
				$leader_add[1] += $num1;
			if($num0==952) //Дополнительный слот для воина II круга
				$leader_add[2] += $num1;
			if($num0==953) //Дополнительный слот для воина III круга
				$leader_add[3] += $num1;
			if($num0==954) //Дополнительный слот для воина IV круга
				$leader_add[4] += $num1;
			if($num0==960) //смена героя на др. юнит
			{
				$p .= "Изменение базового юнита героя на юнит <font color=\"brown\"><B>".$u_name[$num1]."</B></font>";
				if(isset($u_abil[$num1]) || isset($add_param[$num1]))
				{
					$p .= ":<br><font color=\"fuchsia\">Переносимые умения от нового юнита:</font><B> ";
					if(isset($u_abil[$num1]))
						$p .= substr($u_abil[$num1],0,-2);
					if(isset($add_param[$num1]))
					{
						if(isset($u_abil[$num1]))
							$p .= "; ";
						$p .= substr($add_param[$num1],0,-2);
					}
				}
				$p .= "</B>;<br>";
				$LIFE += $add_life[$num1];
				$MORALE += $add_morale[$num1];
				$STAMINA += $add_stamina[$num1];
			}
			else
			if($abil_name[$num0]=="" && $num0<1000)
				$p .= "!!!Неизвестная абилка $num0<br>";
			else
			if($num0>1000) //командирские умения
			{
				if(($abil_numeric[$num0-1000]) == 0)//одноразодаваемые абилки
					$p .= $abil_name[$num0-1000]." <font color=\"aqua\">(Отряд)</font>;<br>";
				else
					$p .= $abil_name[$num0-1000]." <font color=\"green\"><B>+".$num1.($abil_percent[$num0]==1 ? "%" : "")."</B></font> <font color=\"aqua\">(Отряд)</font>;<br>";
			}
			else
			{
				if(($abil_numeric[$num0]) == 0)//одноразодаваемые абилки
					$p .= $abil_name[$num0].";<br>";
				else
				if($num0==983)//Снижение цены заклятий
					$p .= $abil_name[$num0]." <font color=\"green\"><B>на ".$num1."%</B></font>;<br>";
				else
				if($num0==984)//два заклинания за один ход
				{
					$quick += $num1;
					$p .= $abil_name[$num0]." (суммарный уровень <= <font color=\"blue\"><B>".$quick."</B></font>);<br>";
				}
				else
				if($num0==20)//Дополнительный выстрел
					$p .= $abil_name[$num0]." (<font color=\"green\"><B>расход энергии ".($num1>=0 ? "</font><font color=\"blue\">$num1" : "уменьшен на </font><font color=\"blue\">".abs($num1))."</B></font>);<br>";
				else
					$p .= $abil_name[$num0]." <font color=\"green\"><B>+".$num1.($abil_percent[$num0]==1 ? "%" : "")."</B></font>;<br>";
			}
		}
		echo substr($p,0,-5);
		$p="";
		echo "</td><td align=center>";
		$H1[$j]=$H[$j]+$stat_dif[1][$progress_health[$j]+$progress_health[$a3-1]][0]+$LIFE;
		$S1[$j]=$S[$j]+$stat_dif[1][$progress_health[$j]+$progress_health[$a3-1]][1]+$STAMINA;
		$M1[$j]=$M[$j]+$stat_dif[1][$progress_health[$j]+$progress_health[$a3-1]][2]+$MORALE;
//echo "($j)<br>";
		echo "<font color=\"red\"><B>( ".($progress_health[$j]+$progress_health[$a3-1])." )</B></font><br>";
		echo "Жизнь:<font color=\"blue\"><B>".($H1[$j]+10)."</B></font><br>";
		echo "Выносливость:<font color=\"blue\"><B>".$S1[$j]."</B></font><br>";
		echo "Боевой дух:<font color=\"blue\"><B>".$M1[$j]."</B></font><br></td><td align=center>";
		$M_idx = $progress_magic[$j]+$progress_magic[$a3-1];
		$M_print = $magic[$M_idx];
		echo "<font color=\"red\"><B>( $M_idx )</B></font><br>";
		$M_print{26} = $M_print{26} + $magic_add[1];
		$M_print{65} = $M_print{65} + $magic_add[2];
		$M_print{104} = $M_print{104} + $magic_add[3];
		$M_print{143} = $M_print{143} + $magic_add[4];
		echo $M_print."</td><td align=center>";
//		echo "<font color=\"red\"><B>( ".($progress_magic[$j]+$progress_magic[$a3-1])." )</B></font><br>";
//		echo $magic[$progress_magic[$j]+$progress_magic[$a3-1]]."</td><td align=center>";
////		echo "<font color=\"red\"><B>( ".($progress_leader[$j]+$progress_leader[$a3-1])." )</B></font><br>";
////		echo $leader[$progress_leader[$j]+$progress_leader[$a3-1]]."</td></tr>";
//		echo "</td></tr>";

		$L_idx = $progress_leader[$j]+$progress_leader[$a3-1];
		$L_print = $leader[$L_idx];
		echo "<font color=\"red\"><B>( $L_idx )</B></font><br>";
//		echo "<font color=\"red\"><B>( ".($progress_leader[$j]+$progress_leader[$a3])." )</B></font><br>";
//		echo $leader[$progress_leader[$j]+$progress_leader[$a3]]."</td></tr>";
		$L_print{26} = $L_print{26} + $leader_add[1];
		$L_print{65} = $L_print{65} + $leader_add[2];
		$L_print{104} = $L_print{104} + $leader_add[3];
		$L_print{143} = $L_print{143} + $leader_add[4];
		echo $L_print."</td></tr>";

		$magic_add = "";
		$leader_add = "";
		$a2++;
	}
}
echo "</table><br><br><table border=1>";
//Вывод классов героев, к-е могут носить item_set
for($i = 1; $i <= $max1; $i++)
{
	echo "<tr><td rowspan=$item_set_num[$i] class=bottom>$i<br><font color=\"green\"><B>($item_set_name[$i])</font></td>";
	echo "<td rowspan=$item_set_num[$i] class=bottom>";
	for($j=1;$j<=4;$j++)
	{
		for($k=0;$k<$item_set_num[$i];$k++)
		{
			if(!in_array($item_set_items[$i][$k],$item_class[$j]))
				$flag=1;//не может носить
		}
		if($flag!=1)
			$p=$p."<font color=\"blue\"><B>".$class_name_sort[$j]."</B></font>, ";
		$flag=0;
	}
	echo substr($p,0,strlen($p)-2).($p=="" ? "" :"<br>");
	$p="";
	echo "(";
	for($j=5;$j<=36;$j++)
	{
		for($k=0;$k<$item_set_num[$i];$k++)
		{
			if(!in_array($item_set_items[$i][$k],$item_class[$j]))
				$flag=1;//не может носить
		}
		if($flag!=1)
			$p=$p.$class_name_sort[$j].", ";
		$flag=0;
	}
	echo substr($p,0,strlen($p)-2);
	$p="";
	echo ")</td></tr>";
	for($j=1;$j<$item_set_num[$i];$j++)
	{
		echo "<tr></tr>";
	}

//	echo "</td></tr>";
}
echo "</table><br><br><table border=1>";

//разбор Hero_class.txt
$max1=0;

for($i = 0,$n=0; $i < $count_class_txt; $i++)
{  
    if(eregi("^/([0-9]{1,})",$class_file_txt[$i],$k))
    {
		$n=$k[1];
		if($n>$max1)$max1=$n;
    }
    else
	{
    if(substr(trim($class_file_txt[$i]),-1,1)=="#")
	    $class_txt[$n]=substr(trim($class_file_txt[$i]),1,-1);
//echo $n."-".$class_txt[$n];
	}
}
for($i=1;$i<$max1+1;$i++)
{
	echo "<tr><td>$i</td><td>";
	echo $class_txt[$ref[$i]]."</td></tr>";
}

echo "</table><br><br><table border=1>";

$max1=0;
//разбор Hero_class_d.txt
for($i = 0,$n=0; $i < $count_class_d_txt; $i++)
{  
    if(eregi("^/([0-9]{1,})",$class_d_file_txt[$i],$k))
    {
		$n=$k[1];
		if($n>$max2)$max1=$n;
    }
    else
	if(substr($class_d_file_txt[$i],0,1)=="#")
	    $class_d_txt[$n]=$class_d_txt[$n].substr($class_d_file_txt[$i],1)."<br>";
	else
	    if(substr(trim($class_d_file_txt[$i]),-1,1)=="#")
	    {
			$class_d_txt[$n]=$class_d_txt[$n].substr(trim($class_d_file_txt[$i]),0,-1);
			$i++;
	    }
	    else
			$class_d_txt[$n]=$class_d_txt[$n].$class_d_file_txt[$i]."<br>";
}
for($i=1;$i<$max1+1;$i++)
{
	echo "<tr><td>$i</td><td>";
	echo str_replace("~","%",str_replace("%s","\"Знание болот/Знание лесов/Знание холмов\"",$class_d_txt[$ref[$i]]))."</td></tr>";
}

?>
</html>

