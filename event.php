<html><head>
<meta http-equiv="Content-Type" content="text/html charset=windows-1251">
<title>Эадор - События</title></head><body>
<style>
.txt		{color:white; line-height:100%}
</style>
<?php
require_once "dumper.php";
$d_file = file("dialog.var");
$count_d = count($d_file);
$event_file = file("event.var");
$count_event = count($event_file);
$g_file = file("guard_type.var");
$count_g = count($g_file);
$prov_file = file("province_type.var");
$count_prov = count($prov_file);
$prov_level_file = file("province_level.var");
$count_prov_level = count($prov_level_file);
$def_file = file("defender.var");
$count_def = count($def_file);
$out_build_file = file("outer_build.var");
$count_out_build = count($out_build_file);
$inner_build_file = file("inner_build.var");
$count_inner_build = count($inner_build_file);
$site_file = file("site.var");
$count_site = count($site_file);
$item_file = file("item.var");
$count_item = count($item_file);
$spell_file = file("spell.var");
$count_spell = count($spell_file);
$unit_file = file("unit.var");
$count_unit = count($unit_file);
$race_file = file("race.var");
$count_race = count($race_file);
$ritual_file = file("ritual.var");
$count_ritual = count($ritual_file);
$enc_file = file("encounter.var");
$count_enc = count($enc_file);
$ruler_file = file("ruler_nick.var");
$count_ruler = count($ruler_file);

$res_name=array(1=>"Железо", "Красное дерево", "Кони", "Мандрагора", "Арканит", "Мрамор", "Мифрил", "Дионий", "Чёрный лотос");
//$unit_race=array(1=>"Люди","Эльфы","Гномы","Гоблины","Орки","Половинчики","Кентавры","Людоящеры","Тёмные эльфы","Гноллы","Алкари","Крысолюды");
$terrain = array(1=>"Равнина","Лес","Холмы","Болото","Пустыня","Тундра");
$nastr = array(-5=>"Полны ненависти",-4=>"В ярости",-3=>"Возмущены",-2=>"Очень недовольны",-1=>"Недовольны","Спокойны","Довольны","Очень довольны","Счастливы");
$dialog_param = array (1=>"название провинции","величина из первого эффекта");

$group_noscan = array(12,13);//не обрабатывать для групп событий
$group_begin[0] = 0;//массив начальных номеров событий - чтоб добавлялись с [1]

//"тонкие" подстройки, умело скрывающие недостатки алгоритмов группировки!
//$event_yes_begin = array(1411);//дополнительные начальные события в группе
//1411 Прилёт алкари, не используется

$event_not_begin = array(1106,1459);//ошибочные начальные события в группе
//1106 Инквизиция, начало (по таймеру)
//1220 Шаман-демонолог, сами разберутся - не используется
//1459 Оборотень переселился

$event_flag_not_out = array(94,101,349,367,385,402,465,471);//устранение дублирующих групп: джин, легенда, заброшенный храм
//94 (Джин - главное условие)
//101 (Добрый джин - главное условие)
//349 (Легенда - главное)
//367 (Доспех Василиска - главное)
//385 (Доспех Ветерана - главное)
//402 (Доспех Палладина - главное)
//465 (Заброшенный храм - главное 1)
//471 (Заброшенный храм - главное 1)

//$camp_file_name="eador_camp.htm";
$camp_file_name="camp_Eador_NH_18.0601.htm";
//$enc_file_name="eador_encounter.htm";
$enc_file_name="encounter_Eador_NH_18.0601.htm";
$group_file_name="event_group_Eador_NH_18.0601.htm";

//названия сортировочных групп (все, не попавшие под критерии сортировки, суются в "Обычное Оружие")
$tab_name=array("Обычное Оружие","Холодное Оружие (левая рука)","Холодное Оружие","Тяжёлое Оружие","Лук","Стрелы","Жезл","Сфера","Знамя",
"Щит","Обычный головной убор","Лёгкий Шлем","Средний Шлем","Тяжёлый Шлем","Ожерелье","Обычная Броня",
"Лёгкая Броня","Средняя Броня","Тяжёлая Броня","Плащ","Обычные Перчатки","Лёгкие Перчатки",
"Средние Перчатки","Тяжёлые Перчатки","Обычный Браслет","Лёгкий Наруч","Средний Наруч","Тяжёлый Наруч",
"Кольцо","Пояс","Обычная Обувь","Лёгкая Обувь","Средняя Обувь","Тяжёлая Обувь","Предметы вызова","Свитки заклинаний");

//по сколько сортировочных групп находится в каждом листе таблицы по типам
$tab_num=array(1,1,1,1,2,2,3,3,4,5,6,6,6,6,7,8,8,8,8,9,10,10,10,10,11,11,11,11,12,13,14,14,14,14,15,15,16,17);

//пары "slot,class", по которым итемсы разбиваются по группам
// -1 - любой слот (смотрим только класс)
$item_sort=array(
"1,0","2,1","1,1","1,2",//оружие
"1,3","2,3",//лук-стрелы
"1,4","2,4",//жезл-сфера
//"1,5",//знамя
//"2,9",//щит
"-1,5",//знамя
"-1,9",//щит
"4,0","4,6","4,7","4,8",//шлем
"9,0",//ожерелье
"3,0","3,6","3,7","3,8",//броня
"6,0",//плащ
"8,0","8,6","8,7","8,8",//перчатки
"10,0","10,6","10,7","10,8",//запястье
"11,0",//кольцо
"5,0",//пояс
"7,0","7,6","7,7","7,8",//обувь
"0,0","0,10");//инвентарь
//echo count($tab_num),count($item_sort);
$item_cloth=array(1=>"4,0","3,0","6,0","8,0","10,0","5,0","7,0");//одежда
//$item_jewel=array(9,10,11);//украшения

//функция проверки кол-ва артефактов, соответствующих условию №40 - Получить случайный предмет типа Power уровня Param1, c редкостью не ниже Param2
function check_art_count($type, $level, $rarity)
{
	global $tab_item, $item_dur, $item_shop, $item_rarity;
	global $item_type1,$item_type2,$item_type3,$item_type4,$item_type5,$item_type6,$item_type7,$item_type8,$item_type9,$item_type10,$item_type11,$item_type12,$item_type13;
	$c = 0;//к-во подходящих артов
	if(($type==1) || ($type==2) ||($type==9))//Оружие и щиты
	{
		foreach($item_type1 as $v)
		{
			if($level == $item_shop[$v])
				if($item_rarity[$v] >= $rarity) $c++;
		}
	}
	else
	if($type==3)//Луки и стрелы
	{
		foreach($item_type2 as $v)
		{
			if($level == $item_shop[$v])
				if($item_rarity[$v] >= $rarity) $c++;
		}
	}
	else
	if($type==4)//Жезлы и сферы
	{
		foreach($item_type3 as $v)
		{
			if($level == $item_shop[$v])
				if($item_rarity[$v] >= $rarity) $c++;
		}
	}
	else
	if($type==5)//Знамёна
	{
		foreach($item_type4 as $v)
		{
			if($level == $item_shop[$v])
				if($item_rarity[$v] >= $rarity) $c++;
		}
	}
	else
	if($type==6)//Кожа и пояса
	{
		foreach($item_type5 as $v)
		{
			if($level == $item_shop[$v])
				if($item_rarity[$v] >= $rarity) $c++;
		}
	}
	else
	if($type==7)//Кольчуги
	{
		foreach($item_type6 as $v)
		{
			if($level == $item_shop[$v])
				if($item_rarity[$v] >= $rarity) $c++;
		}
	}
	else
	if($type==8)//Латы
	{
		foreach($item_type7 as $v)
		{
			if($level == $item_shop[$v])
				if($item_rarity[$v] >= $rarity) $c++;
		}
	}
	else
	if($type>10 && $type<14)//Свитки, Договор со стражем, Чертёж постройки, Ритуал
	{
		$c = 999;//заглушка
	}
	else
	if($type==-1)//Одежда !!!ADD: item_dur
	{
		foreach($item_type12 as $v)
		{
			if($level == $item_shop[$v])
				if($item_rarity[$v] >= $rarity) $c++;
		}
	}
	else
	if($type==-2)//Украшения !!!ADD: item_dur
	{
		foreach($item_type13 as $v)
		{
			if($level == $item_shop[$v])
				if($item_rarity[$v] >= $rarity) $c++;
		}
	}
	return $c;
}
/*
//вывод одежды
for($i=1;$i<=count($item_cloth);$i++)
{
	foreach($tab_cloth[$i] as $v)
	{
		$file_str[16] .= $pic_table[$v].",";
		if(($i!=5) || ($dur_table[$v]>1))
//вывод украшений
for($i=0;$i<3;$i++)
{
	foreach($tab_jewel[$i] as $v)
	{
		$file_str[17] .= $pic_table[$v].",";
		if(($i!=1) || ($dur_table[$v]==1))
*/
$max=0;$max1=0;$max_u=0;$max_e=0;$t[0]=0;$j=0;$in_flag=0;
$u1=-1;$u2=0;$u3=0;	//№ строки юнита в xls
$g1=0; //кол-во стражей в одном сайте
$a1=0; //№ абилки
$a2=0; //№ эффекта ritual
$e1=0; //№ эффекта
$up1=0; //число upg_type в unit_upg
$u_a=0; //абилки in unit.var
//сквозная нумерация: кол-во предметов+кол-во заклинаний+кол-во договоров+кол-во чертежей+кол-во ритуалов
$all_def_num=0;
$all_out_build_num=0;
$s=explode(':',$item_file[0]);
$all_item_num=$s[1]+1-1;
$s=explode(':',$spell_file[0]);
$all_spell_num=$s[1]+1-1;


//Разбор encounter.var
for($i = 0,$n=0,$count=0; $i < $count_enc; $i++)
{  
   if(eregi("^/([0-9]{1,})",$enc_file[$i],$k))
    {
		$n=$k[1];
		$s=substr($enc_file[$i],log10($n)+3);
//echo $n."-".$s."<br>";
		$enc_table[$n]=trim($s);
// echo $e_file[$i]."<br>".$k[0]."-".$k[1]."--".$dialog_table[$n]."<br>";
    }
	else
	if(eregi("^\*Effects\*:",$enc_file[$i]))
	{
		for($j=0;$j<16;$j++) //четвёрки эффектов
		{
			while(1)
				if(trim($enc_file[$i+1]) == "") //пустая строка
					$i++;
				else
					break;
			$i++;
			$s=explode(':',$enc_file[$i]);
			$num=$s[1]+1-1;
			while(1)
				if(trim($enc_file[$i+1]) == "") //пустая строка
					$i++;
				else
					break;
			$i++;
			$s=explode(':',$enc_file[$i]);
			$power=$s[1]+1-1;
			while(1)
				if(trim($enc_file[$i+1]) == "") //пустая строка
					$i++;
				else
					break;
			$i++;
			$s=explode(':',$enc_file[$i]);
			$param1=$s[1]+1-1;
			while(1)
				if(trim($enc_file[$i+1]) == "") //пустая строка
					$i++;
				else
					break;
			$i++;
			$s=explode(':',$enc_file[$i]);
			$param2=$s[1]+1-1;
			if($num==8) //ссылки на данное событие из др.событий, обработка кодов переходов
			{
				if(!in_array($n,$event_in_enc[$power]))
					$event_in_enc[$power][] = $n;//флаг где изменяется
			}
			else
			if($num==15) //ссылки на данное событие из др.событий, обработка кодов переходов
			{
				if($power==14)
					if(!in_array($n,$event_in_enc[$param1]))
						$event_in_enc[$param1][] = $n;//флаг где изменяется
			}
			$i++; //пустая строка
			if(substr(trim($enc_file[$i-1]),-1,1)==";") 
			{
				break; //for $j
			}
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

//Разбор ruler_nick.var
for($i = 0,$n=0; $i < $count_ruler; $i++)
{
	if(eregi("^/([0-9]{1,})",$ruler_file[$i],$k))
	{
		$n=$k[1];
	}
	else
	if(eregi("^Min",$ruler_file[$i]))
	{
		$s=explode(':',$ruler_file[$i]);
		$ruler[$n][0] = $s[1]+1-1;//Min
		$i++;
		$s=explode(':',$ruler_file[$i]);
		$ruler[$n][1] = $s[1]+1-1;//Max
		$i++;
		$s=explode(':',$ruler_file[$i]);
		$ruler[$n][2] = substr(trim($s[1]),0,-1);//Text
		if($ruler[$n][2] == "")
			$ruler[$n][2] = "Нейтральный";
		$i++;
	}
}
//echo count($ruler);
//dumper($ruler,"ruler");

//Разбор ritual.var
for($i = 0,$n=0; $i < $count_ritual; $i++)
{  
   if(eregi("^/([0-9]{1,})",$ritual_file[$i],$k))
    {
		$n=$k[1];
		if($n>$max_ritual)$max_ritual=$n;
    }
    else
    if(eregi("^name",$ritual_file[$i]))
    {
		$s=explode(':',$ritual_file[$i]);
		$ritual_name[$n]=substr(trim($s[1]),0,-1);
    }
    else
    if(eregi("^Event",$ritual_file[$i]))
    {
		$s=explode(':',$ritual_file[$i]);
		if(!in_array($n,$event_in_ritual[$s[1]+1-1]))
			$event_in_ritual[$s[1]+1-1][] = $n;//флаг где изменяется
		if(($s[1]+1-1)!=0)
			$ritual_event[$n][]=$s[1]+1-1;
     }
    else
    if(eregi("^Effect:",$ritual_file[$i])) //effect  в ritual.var
    {
		$s=explode(':',$ritual_file[$i]);
		$ritual_num=$s[1]+1-1;	//массив № абилок
		$i++;
		$s=explode(':',$ritual_file[$i]);
		$ritual_param1=$s[1]+1-1;	//массив param1 абилок
		if($ritual_num==3) //ссылки на данное событие из др.событий, обработка кодов переходов
		{
			if(!in_array($n,$event_in_ritual[$ritual_param1]))
				$event_in_ritual[$ritual_param1][] = $n;//флаг где изменяется
			$ritual_event[$n][]=$ritual_param1;
		}
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
//				echo $n."- Дубль SITE=".$s;
				$s = $s."<font color=\"fuchsia\">*</font>";
//				echo " <B>Замена на</B> ".$s."<br>";
			}
			$site_name[$n]=$s;
		}
    }
    else
    if(eregi("^Ability",$site_file[$i])) //Ability в site.var или defender.var
    {
//echo $n."-".$a_file[$i]."<br>";
		if(trim($site_file[$i])!="Ability:")
		{
			$s=explode(':',$site_file[$i]);
			$abil_num=$s[1]+1-1;	//массив № абилок
//echo $n."-".$abil[$n][$a1]['num']."<br>";
			$i++;
			$s=explode(':',$site_file[$i]);
			$abil_param1=$s[1]+1-1;	//массив param1 абилок
			if($abil_num==4) //ссылки на данное событие из др.событий, обработка кодов переходов
			{
				if(!in_array($n,$event_in_site[$abil_param1]))
					$event_in_site[$abil_param1][] = $n;//флаг где изменяется
			}
		}
    }
}

//Разбор unit.var
for($i = 0,$n=0; $i < $count_unit; $i++)
{  
   if(eregi("^/([0-9]{1,})",$unit_file[$i],$k))
    {
		$n=$k[1];
    }
    else
    if(eregi("^name",$unit_file[$i]))
    {
		$s=explode(':',$unit_file[$i]);
		$s=trim(substr(trim($s[1]),0,-1));
		if(in_array($n,array_merge(range(40,43),range(238,253),range(263,278))))//апы героя
		{
			$u_name[$n]=$s."<font color=\"fuchsia\">@</font>";
		}
		else
		{
			while(in_array($s,$u_name))
			{
//				echo $n."- Дубль UNIT=".$s;
				$s = $s."<font color=\"fuchsia\">*</font>";
//				echo " <B>Замена на</B> ".$s."<br>";
			}
			$u_name[$n]=$s;
		}
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
//			echo $n."- Дубль SPELL=".$s;
			$s = $s."<font color=\"fuchsia\">*</font>";
//			echo " <B>Замена на</B> ".$s."<br>";
		}
		$spell_name[$n]=$s;
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
//			echo $n."- Дубль ITEM=".$s;
			$s .= "<font color=\"fuchsia\">*</font>";
//			echo " <B>Замена на</B> ".$s."<br>";
		}
		$item_name[$n]=$s;
    }
	else
    if(eregi("^Slot:",$item_file[$i]))
    {
		$s=explode(':',$item_file[$i]);
		if($s[1]==100)$s[1]="12";//двуручный
		$slot_table[$n]=$s[1]+1-1;
		if($slot_table[$n]==9)//Ожерелье
			$tab_jewel[0][]=$n;
		else
		if($slot_table[$n]==10)//Запястье
			$tab_jewel[1][]=$n;
		else
		if($slot_table[$n]==11)//Кольцо
			$tab_jewel[2][]=$n;
//echo $n."-".$slot_table[$n]."<br>";
    }
    else
    if(eregi("^Class:",$item_file[$i]))
    {
		$s=explode(':',$item_file[$i]);
		$class_table[$n]=$s[1]+1-1;
		if($class_table[$n] == 5)//Знамя
			$str = "-1,5";
		else
		if($class_table[$n] == 9)//Щит
			$str = "-1,9";
		else
			$str=($slot_table[$n]==12 ? 1 : $slot_table[$n]).",".$class_table[$n];
		$sort=array_keys($item_sort,$str);
		if($sort[0] == 1) $sort[0] = 2;//переместить "Холодное Оружие (левая рука)" в "Холодное Оружие"
//		echo $n;dumper($sort);
		if(($n+1-1)!=0)$tab_item[$sort[0]+1-1][]=$n;//в какой лист вставлять данный артефакт
		$sort=array_keys($item_cloth,$str);
		if(($sort[0]) != "")
		{
			$tab_cloth[$sort[0]+1-1][]=$n;//одежда
//			echo $n."(".$name_table[$n].") - одёжа=".$str."<br>";
		}
//echo $n." - SORT=".$str."<br>";
//echo $n."-".$class_table[$n]."<br>";
    }
    else
    if(eregi("^Durability:",$item_file[$i]))
    {
		$s=explode(':',$item_file[$i]);
		$item_dur[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^ShopLevel:",$item_file[$i]))
    {
		$s=explode(':',$item_file[$i]);
		$item_shop[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^Rarity:",$item_file[$i]))
    {
		$s=explode(':',$item_file[$i]);
		$item_rarity[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^Power:",$item_file[$i]))//разбор effects: item.var,spell.var
    {
		$s=explode(':',$item_file[$i-1]);
//		$effects[$n][$e1]['num']=$s[1]+1-1;	//массив № эффектов
		$s1=explode(':',$item_file[$i]);
//		$effects[$n][$e1]['power']=$s[1]+1-1;	//массив power, FlagEffect
		if(($s[1]+1-1) == 83) //spell scroll
		{
//			$item_spell[$n]=$s1[1]+1-1;
		}
		else
		if(($s[1]+1-1) == 84) //summon
		{
//			$build_unit[$s1[1]+1-1]=$build_unit[$s1[1]+1-1].
			$item_summon[$n]=$s1[1]+1-1;
		}
//echo $n."-e1=".$e1." NUM=".$effects[$n][$e1]['num']." POWER=".$effects[$n][$e1]['power']." AREA=".$effects[$n][$e1]['area']."<br>";
    }
}
//Типы случайных предметов для index #40 (Получить случайный предмет типа Power уровня Param1, c редкостью не ниже Param2 Power уровня Param1, c редкостью не ниже Param2)
$item_type1 = array_merge($tab_item[0], $tab_item[2], $tab_item[3], $tab_item[9]);//Оружие и щиты
$item_type2 = array_merge($tab_item[4], $tab_item[5]);//Луки и стрелы
$item_type3 = array_merge($tab_item[6], $tab_item[7]);//Жезлы и сферы
$item_type4 = array_merge($tab_item[8]);//Знамёна
$item_type5 = array_merge($tab_item[11], $tab_item[16], $tab_item[21], $tab_item[25], $tab_item[29], $tab_item[31]);//кожа и пояса
$item_type6 = array_merge($tab_item[12], $tab_item[17], $tab_item[22], $tab_item[26], $tab_item[32]);//Кольчуги
$item_type7 = array_merge($tab_item[13], $tab_item[18], $tab_item[23], $tab_item[27], $tab_item[33]);//Латы
$item_type8 = "";//Свитки
$item_type9 = "";//Страж
$item_type10 = "";//Чертёж
$item_type11 = "";//Ритуал
$item_type12 = array_merge($tab_item[10], $tab_item[15], $tab_item[19], $tab_item[20], $tab_item[24], $tab_item[29], $tab_item[30]);//Одежда
$item_type13 = array_merge($tab_item[14], $tab_item[24], $tab_item[28]);//Украшения
//dumper($tab_item,"tab_item");

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
    else
    if(eregi("^Ability",$out_build_file[$i]))
    {
		if(trim($out_build_file[$i])!="Ability:")
		{
			$s=explode(':',$out_build_file[$i]);
			$abil_num=$s[1]+1-1;	//массив № абилок
//echo $n."-".$abil[$n][$a1]['num']."<br>";
			$i++;
			$s=explode(':',$out_build_file[$i]);
			$abil_param1=$s[1]+1-1;	//массив param1 абилок
			if($abil_num==8) //Существует чертёж постройки, для сквозной нумерации предметов
			{
				$all_out_build_num++;
				$all_out_build[$all_out_build_num]=$out_build_name[$n];
//echo $n."-".$all_out_build_num." ".$all_out_build[$all_out_build_num]."<br>";
			}
			if($abil_num==7) //ссылки на данное событие из др.событий, обработка кодов переходов
			{
				if(!in_array($n,$event_in_out_build[$abil_param1]))
					$event_in_out_build[$abil_param1][] = $n;//флаг где изменяется
			}
		}
    }
}

//Разбор inner_build.var
for($i = 0,$n=0; $i < $count_inner_build; $i++)
{  
   if(eregi("^/([0-9]{1,})",$inner_build_file[$i],$k))
    {
		$n=$k[1];
    }
    else
    if(eregi("^name",$inner_build_file[$i]))
    {
		$s=explode(':',$inner_build_file[$i]);
		$inner_build_name[$n]=substr(trim($s[1]),0,-1);
    }
    else
    if(eregi("^Ability",$inner_build_file[$i]))
    {
		if(trim($inner_build_file[$i])!="Ability:")
		{
			$s=explode(':',$inner_build_file[$i]);
			$abil_num=$s[1]+1-1;	//массив № абилок
//echo $n."-".$abil[$n][$a1]['num']."<br>";
			$i++;
			$s=explode(':',$inner_build_file[$i]);
			$abil_param1=$s[1]+1-1;	//массив param1 абилок
			if(($abil_num==45) || ($abil_num==48)) //ссылки на данное событие из др.событий, обработка кодов переходов
			{
				if(!in_array($n,$event_in_inner_build[$abil_param1]))
					$event_in_inner_build[$abil_param1][] = $n;//флаг где изменяется
			}
		}
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
//			echo $n."- Дубль DEFENDER=".$s;
			$s = $s."<font color=\"fuchsia\">*</font>";
//			echo " <B>Замена на</B> ".$s."<br>";
		}
		$def_name[$n]=$s;
    }
    else
    if(eregi("^Ability",$def_file[$i]))
    {
		if(trim($def_file[$i])!="Ability:")
		{
			$s=explode(':',$def_file[$i]);
			if(($s[1]+1-1)==10) //Существует свиток найма стражи, для сквозной нумерации предметов
			{
				$all_def_num++;
				$all_def[$all_def_num]=$def_name[$n];
//echo $n."-".$all_def_num." ".$all_def[$all_def_num]."<br>";
			}
		}
    }
}

//Разбор guard_type.var
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
//			echo $n."- Дубль guard_type=".$s;
			$s = $s."<font color=\"fuchsia\">*</font>";
//			echo " <B>Замена на</B> ".$s."<br>";
		}
		$g_name[$n]=$s; //$g_name[] - guard_type
    }
}

//Разбор province_type.var
for($i = 0,$n=0; $i < $count_prov; $i++)
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
	if(eregi("^Event:",$prov_file[$i]))
	{
		$s=explode(':',$prov_file[$i]);
		if(!in_array($n,$event_in_prov[$s[1]+1-1]))
			$event_in_prov[$s[1]+1-1][] = $n;//флаг где изменяется
	}
}

//Разбор province_level.var
for($i = 0,$n=0; $i < $count_prov_level; $i++)
{
	if(eregi("^/([0-9]{1,})",$prov_level_file[$i],$k))
	{
		$n=$k[1];
	}
	else
	if(eregi("^name",$prov_level_file[$i]))
	{
		$s=explode(':',$prov_level_file[$i]);
		$prov_level_name[$n]=substr(trim($s[1]),0,-1);
	}
}

//Разбор event.var
for($i = 0,$n=0,$count=0; $i < $count_event; $i++)
{
	if(eregi("^/([0-9]{1,})",$event_file[$i],$k))
	{
		$n=$k[1];
		if($count != $n) //неправильная нумерация событий
		{
			echo "!!!Сбитая нумерация №".$n."<br>";
			$count=$n;
		}
		$count++;
		if($n>$max_e)$max_e=$n;
		$s=substr($event_file[$i],log10($n)+3);
//echo $n."-".$s."<br>";
		$event_table[$n]=trim($s);
		if($event_table[$n][0]=='(')
			$event_table2[$n]=substr($event_table[$n],1,-1); //имя без скобок
		else
			$event_table2[$n]=$event_table[$n];
// echo $e_file[$i]."<br>".$k[0]."-".$k[1]."--".$dialog_table[$n]."<br>";
	}
	else
	if(eregi("^Type:",$event_file[$i]))
	{
		$s=explode(':',$event_file[$i]);
		$event_type[$n]=$s[1]+1-1;
	}	
	else
	if(eregi("^Possibility:",$event_file[$i]))
	{
		$s=explode(':',$event_file[$i]);
		$event_poss[$n]=$s[1]+1-1;
	}	
	else
	if(eregi("^Dialog:",$event_file[$i]))
	{
		$s=explode(':',$event_file[$i]);
		$event_dialog[$n]=$s[1]+1-1;
		if($event_dialog[$n]!=0)
			$dialog_event[$s[1]+1-1][]=$n;//массив одинаковых диалогов у разных событий
	}	
	else
	if(eregi("^DlgParam1:",$event_file[$i]))
	{
		$s=explode(':',$event_file[$i]);
		$event_dialog_param1[$n]=$s[1]+1-1;
		if($event_dialog_param1[$n]!=0) $event_dialog_param_count[$n]++;
	}	
	else
	if(eregi("^DlgParam2:",$event_file[$i]))
	{
		$s=explode(':',$event_file[$i]);
		$event_dialog_param2[$n]=$s[1]+1-1;
		if($event_dialog_param2[$n]!=0) $event_dialog_param_count[$n]++;
	}	
	else
	if(eregi("^Attacker:",$event_file[$i]))
	{
		$s=explode(':',$event_file[$i]);
		$event_attacker[$n]=$s[1]+1-1;
	}	
	else
	if(eregi("^EventWin:",$event_file[$i]))
	{
		$s=explode(':',$event_file[$i]);
		$q=$event_win[$n]=$s[1]+1-1;
		foreach(explode(',',$event_in[$q]) as $val) //поиск дублей ссылок
			if($val==$n) $in_flag=1;
		if($in_flag!=1)
			$event_in[$q] = $event_in[$q].$n.",";
		$in_flag=0;
		if(!in_array($q,$event_out[$n]))
			if($q!=0 && $q!=$n)
				$event_out[$n][]=$q;
//		$event_in[$event_win[$n]]=$event_in[$event_win[$n]].$n.",";
//		$event_cnt[$event_win[$n]]++;
//		$event_in[$event_win[$n]][$event_cnt[$event_win[$n]]]=$n; //ссылки на данное событие из др.событий
	}	
	else
	if(eregi("^EventLose:",$event_file[$i]))
	{
		$s=explode(':',$event_file[$i]);
		$q=$event_lose[$n]=$s[1]+1-1;
		foreach(explode(',',$event_in[$q]) as $val) //поиск дублей ссылок
			if($val==$n) $in_flag=1;
		if($in_flag!=1)
			$event_in[$q] = $event_in[$q].$n.",";
		$in_flag=0;
		if(!in_array($q,$event_out[$n]))
			if($q!=0 && $q!=$n)
				$event_out[$n][]=$q;
//		$event_in[$event_lose[$n]]=$event_in[$event_lose[$n]].$n.",";
//		$event_cnt[$event_lose[$n]]++;
//		$event_in[$event_lose[$n]][$event_cnt[$event_lose[$n]]]=$n; //ссылки на данное событие из др.событий
	}	
	else
	if(eregi("^EventDraw:",$event_file[$i]))
	{
		$s=explode(':',$event_file[$i]);
		$event_draw[$n]=$s[1]+1-1;
//		$event_in[$event_draw[$n]]=$event_in[$event_draw[$n]].$n.",";
//		$event_cnt[$event_draw[$n]]++;
//		$event_in[$event_draw[$n]][$event_cnt[$event_draw[$n]]]=$n; //ссылки на данное событие из др.событий
	}	
	else
	if(eregi("^ProvType:",$event_file[$i]))
	{
		$s=explode(':',$event_file[$i]);
		$event_prov[$n]=$s[1]+1-1;
	}	
	else
	if(eregi("^Karma:",$event_file[$i]))
	{
		$s=explode(':',$event_file[$i]);
		$event_karma[$n]=$s[1]+1-1;
		if($event_karma[$n] != 0)
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
		for($j=1;(eregi("^Answer",$event_file[$i+1])) && ($j<8);$j++)
		{
			$i++;
			$s=explode(':',$event_file[$i]);
			$event_answer[$n][$j]=$s[1];
			$q=$s[1]+1-1;
			foreach(explode(',',$event_in[$q]) as $val) //поиск дублей ссылок
				if($val==$n) $in_flag=1;
			if($in_flag!=1)
				$event_in[$q] = $event_in[$q].$n.",";
			$in_flag=0;
			if(!in_array($q,$event_out[$n]))
				if($q!=0 && $q!=$n)
					$event_out[$n][]=$q;
//			$event_in[$s[1]+1-1]=$event_in[$s[1]+1-1].$n.",";
//			$event_cnt[$s[1]+1-1]++;
//			$event_in[$s[1]+1-1][$event_cnt[$s[1]+1-1]]=$n; //ссылки на данное событие из др.событий
//echo $n."(".$j.")".$event_answer[$n][$j]."LEN=".$answer_len[$n]."<br>";
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
//echo $n."-".$event_effects[$n][$j]['num']."<br>";;
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
//echo "-".$s[1];
			while(1)
				if(trim($event_file[$i+1]) == "") //пустая строка
					$i++;
				else
					break;
			$i++;
			$s=explode(':',$event_file[$i]);
			$param2 = $event_effects[$n][$j]['param2']=$s[1]+1-1;
//echo "-".$s[1]."<br>";
//Вызвать событие Power (если Param1!=0 - Вызвать событие Param1, если Random(100)>Param2 (Param1<0 - не вызывать события))
			if($num==11)//ссылки на данное событие из др.событий, обработка кодов переходов
			{
				foreach(explode(',',$event_in[$power]) as $val) //поиск дублей ссылок
					if($val==$n) $in_flag=1;
				if($in_flag!=1)
				{
					$event_in[$power] .= $n.",";
				}
				$in_flag=0;
				if(!in_array($power,$event_out[$n]))
					if($power!=0 && $power!=$n)
						$event_out[$n][]=$power;
				if($param1>0)
				{
					foreach(explode(',',$event_in[$param1]) as $val) //поиск дублей ссылок
						if($val==$n) $in_flag=1;
					if($in_flag!=1)
						$event_in[$param1] .= $n.",";
					$in_flag=0;
					if(!in_array($param1,$event_out[$n]))
						if($param1!=$n)
							$event_out[$n][]=$param1;
					if(!in_array($power,$event_out[$n]))
						if($power!=0 && $power!=$n)
							$event_out[$n][]=$power;
				}
			}
			else
			if($num==9)
			//В провинции появляется новый сайт Power. Если Param1>0 - сайт скрытый, если Param1<0 - открытый. 
			//Если Param2=-1 не ставить стражу, 0-по умолчанию, 1-ставить
			{
				$event_site[$n][] = "$power|";//список событий, где потенциально может появиться новый сайт
			}
			else
//Привязать флаг события Power к Param1=0 случайной провинции(по умолчанию), 1 текущей провинции, 2 родовой провинции
			if($num==17 || $num==18)//ссылки на данное событие из др.событий, обработка кодов переходов
			{
				foreach(explode(',',$event_in[$power]) as $val) //поиск дублей ссылок
					if($val==$n) $in_flag=1;
				if($in_flag!=1)
					$event_in[$power] .= $n.",";
				$in_flag=0;
				if(!in_array($power,$event_out[$n]))
					if($power!=0 && $power!=$n && !in_array($power,$event_flag_not_out))
						$event_out[$n][]=$power;
//				$event_in[$event_effects[$n][$j]['power']]=$event_in[$event_effects[$n][$j]['power']].$n.",";
			}
			else
//для проверки, прописана ли проверка на наличие зол/кр. для ответов			
			if($num==4) //Ответ №Power появляется при условии с индексом Param1
			{
				$d=$event_dialog[$n];
				if($param1==1)
					$check_gold[$d][$power] = $param2;
				else
				if($param1==2)
					$check_cryst[$d][$power] = $param2;
//						echo "!!! $n: ".$dialog_answer[$d][$power]." - $param2<br>";
			}
			
/*			else
			if($num==8)//для проверки, прописана ли проверка на наличие зол/кр. для ответов
			{
				if($power==3)
					$check_gold_all[$d][$power] = $param2;
			}
*/
			else
			if($num==12)//Получить Param1 чертежей постройки Power
			{
//				$event_outer_scroll[$n][] = "$power|$param1|";//список событий, где потенциально могут выпасть чертежи внешних построек
				$event_outer_scroll[$n][$param1] = "$power|";//список событий, где потенциально могут выпасть чертежи внешних построек
			}
			else
			if($num==13)//Получить Param1 свитков заклинания Power
			{
				$event_spell_scroll[$n][$param1] = "$power|";//список событий, где потенциально могут выпасть свитки заклинания
			}
			else
			if($num==14)//Получить случайный предмет уровня Power, c редкостью не ниже Param1
			{
				$event_unit_egg_rand[$n][] = "$power|$param1|";//список событий, где потенциально могут выпасть яйца
			}
			else
			if($num==16)//Получить Param1 предметов Power
			{
				if($item_summon[$power])//если предмет - яйцо
				{
					if(!in_array($power,$event_unit_egg[$n]))
						$event_unit_egg[$n][] = $power;//"юнит из яйца"
//echo "EVENT=".$n." Получить через яйцо монстра ".$item_summon[$power]."<br>";
				}
				$event_item[$n][] = "$power|";//список событий, где можно получить предмет
			}
			else
			if($num==19)//Установить в провинции охранника Power, если Power=0 - уволить охранника
			{
				if($power > 0)
					$event_def[$n][] = "$power|";//список событий, где потенциально можно поставить стражу в провинции
			}
			else
			if($num==21)//Возвести постройку Power
			{
				$event_outer[$n][] = "$power|";//список событий, где потенциально можно возвести внешнюю постройку
			}
			else
			if($num==36)//Добавить в гарнизон Param1 юнитов Power 
			{
				if(!in_array($power,$event_unit_garn[$n]))
					$event_unit_garn[$n][] = $power;//"юнит"
//echo "EVENT=".$n." Добавить в гарнизон юнитов ".$power."<br>";
			}
			else
			if($num==42)//Получить Param1 договоров со стражем Power
			{
				$event_def_scroll[$n][$param1] = "$power|";//список событий, где потенциально могут выпасть договоры со стражем
			}
			else
			if($num==47)//Получить Param1 свитков ритуала Power
			{
				$event_ritual_scroll[$n][$param1] = "$power|";//список событий, где потенциально могут выпасть свитки ритуала
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
					$event_corr_all_max[$n] = $param1+$power-1;
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
//dumper($event_unit_egg_rand);
//dumper($dialog_event);
//dumper($event_karma_all,"event_karma_all");
//dumper($event_corr_all,"event_corr_all");
/*
$s=explode(':',$d_file[0]);
echo "Одинаковый диалог - события<br>";
for($i = 0; $i < $s[1]; $i++)
	if(count($dialog_event[$i])>1)
		{
			echo "$i - ";
			foreach ($dialog_event[$i] as $val)
				echo $val." ";
			echo "<br>";
		}
*/

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
	if(eregi("^Bitmap:",$d_file[$i]))
	{
		$s=explode(':',$d_file[$i]);
		$dialog_bitmap[$n]=$s[1]+1-1;
		if($dialog_bitmap[$n] > 2000)
			$dialog_bitmap[$n]=$s[1]-2000;
	}
	else
	if(eregi("^Text:",$d_file[$i]))
	{
		$s=explode('Text:',$d_file[$i]);
		$s1=trim($s[1]);
		(substr($s1,-1,1)=="#") ? $dialog_text[$n]=$dialog_text[$n].substr($s1,1,-1) : $dialog_text[$n]=$dialog_text[$n].substr($s1,1)."<br>";
//		(substr($s1,-1,1)=="#") ? $dialog_text[$n]=$dialog_text[$n].substr($s1,1,-1) : $dialog_text[$n]=$dialog_text[$n].substr($s1,1);
		for($j=0;!eregi("^Answer",$d_file[$i+1]) && ($j<8);$j++)
		{
			$i++;
			$s1=trim($d_file[$i]);
			(substr($s1,-1,1)=="#") ? $dialog_text[$n]=$dialog_text[$n].substr($s1,0,-1) : $dialog_text[$n]=$dialog_text[$n].$s1."<br>";
//			(substr($s1,-1,1)=="#") ? $dialog_text[$n]=$dialog_text[$n].substr($s1,0,-1) : $dialog_text[$n]=$dialog_text[$n].$s1;
		}
//echo $n."-".$dialog_text[$n]."<br>";			
	}
	else
	if(eregi("^Answer",$d_file[$i]))
	{
		$ans_idx[$n][] = $i;//в какую строку добавлять спойлеры о карме/коррупции
		$s=explode(':',$d_file[$i]);
		$s1=trim($s[1]);
		(substr($s1,-1,1)=="#") ? $dialog_answer[$n][1]=substr($s1,0,-6) : $dialog_answer[$n][1]=substr($s1,0,-1);
//		preg_match('/ (-? \s* \d+) \s* \$ /xs',$dialog_answer[$n][1],$match_gold);
//		preg_match('/ (-? \s* \d+) \s* \& /xs',$dialog_answer[$n][1],$match_cryst);
//СТАРАЯ проверка на правильность диалогов с изменением золота/кр.
/*
		if(isset($dialog_event[$n]))//не обрабатываем encounter
		{
			preg_match('/ (\d+) \s* [\$|золот|Золот] /xs',$dialog_answer[$n][1],$match_gold);
			preg_match('/ (\d+) \s* [\&|крист|Крист] /xs',$dialog_answer[$n][1],$match_cryst);
			$g=($match_gold[1]+1-1)!=0 ? $match_gold[1]+1-1 : "";
			$c=($match_cryst[1]+1-1)!=0 ? $match_cryst[1]+1-1 : "";
			if($check_gold[$n][1]!=$g)
				echo "!!! Диалог $n(1) Зол - Event $dialog_event[$n] (".$event_table2[$dialog_event[$n]]."): ".$dialog_answer[$n][1]." - ".$check_gold[$n][1]."<br>";
			if($check_cryst[$n][1]!=$c)
				echo "!!! Диалог $n(1) Кр - Event $dialog_event[$n] (".$event_table2[$dialog_event[$n]]."): ".$dialog_answer[$n][1]." - ".$check_cryst[$n][1]."<br>";
		}
*/
//echo $n."(1)".$dialog_answer[$n][1]."<br>";		
		for($j=2;(eregi("^Answer",$d_file[$i+1])) && ($j<8);$j++)
		{
			$i++;
			$ans_idx[$n][] = $i;//в какую строку добавлять спойлеры о карме/коррупции
			$s=explode(':',$d_file[$i]);
			$s1=trim($s[1]);
			(substr($s1,-1,1)=="#") ? $dialog_answer[$n][$j]=substr($s1,0,-6) : $dialog_answer[$n][$j]=substr($s1,0,-1);
//echo $n."(".$j.")".$dialog_answer[$n][$j]."<br>";
//РАСКОММЕНТИТЬ для проверки на правильность диалогов с изменением золота/кр.
/*
			if(isset($dialog_event[$n]))//не обрабатываем encounter
			{
				preg_match('/ (\d+) \s* [\$|золот|Золот] /xs',$dialog_answer[$n][$j],$match_gold);
				preg_match('/ (\d+) \s* [\&|крист|Крист] /xs',$dialog_answer[$n][$j],$match_cryst);
				$g=($match_gold[1]+1-1)!=0 ? $match_gold[1]+1-1 : "";
				$c=($match_cryst[1]+1-1)!=0 ? $match_cryst[1]+1-1 : "";
				if($check_gold[$n][$j]!=$g)
				{
					foreach($dialog_event[$n] as $e)
						echo "!!! Диалог $n($j) Зол - Event $e (".$event_table2[$e]."): ".$dialog_answer[$n][$j]." - ".$check_gold[$n][$j]."<br>";
				}
				if($check_cryst[$n][$j]!=$c)
				{
					foreach($dialog_event[$n] as $e)
						echo "!!! Диалог $n($j) Кр - Event $e (".$event_table2[$e]."): ".$dialog_answer[$n][$j]." - ".$check_cryst[$n][$j]."<br>";
				}
			}
*/
		}
	}
}
//dumper($check_gold,"check_gold");
//dumper($g,"GOLD");
//dumper($c,"CRYST");


//Разбор answer event.var для длины строки
for($i = 0,$n=0; $i < $count_event; $i++)
{  
   if(eregi("^/([0-9]{1,})",$event_file[$i],$k))
    {
		$n=$k[1];
		if($n>$max_e)$max_e=$n;
    }
	else
	if(eregi("^\*Answers\*:",$event_file[$i]))
	{
		for($j=1;(eregi("^Answer",$event_file[$i+1])) && ($j<8);$j++)
		{
			$i++;
			$s=explode(':',$event_file[$i]);
			if($s[1]+1-1==0) 
				$len=2;
			else
//				$len=strlen($event_table[$s[1]+1-1])+floor(log10($s[1]+1-1))-1;
				$len=strlen($event_table[$s[1]+1-1]);
//echo $n."-".$len."<br>";			
			if($len>$answer_len[$n]+1-1) $answer_len[$n]=$len;
//echo $n."(".$j.")".$event_answer[$n][$j]."LEN=".$answer_len[$n]."<br>";
		}
	}	
}


$event_table[0]="";

//echo "-------------------------------------------------------------<br>";

function event_prepare($i,$g="")//подготовка к печати i-того события, или i-того события из группы g
{
	global $event_table,$event_table2,$event_in,$event_out,$group_noscan,$event_in_enc,$enc_file_name,$enc_table;
	global $event_in_ritual,$ritual_name,$event_in_site,$site_name,$event_in_out_build,$out_build_name;
	global $event_in_inner_build,$inner_build_name,$event_in_prov,$prov_name,$event_karma,$event_type;
	global $event_poss,$event_dialog_param1,$event_dialog_param2,$event_dialog,$dialog_param,$event_attacker,$g_name;
	global $event_win,$event_lose,$event_draw,$event_prov,$dialog_bitmap,$dialog_text,$event_answer,$answer_len,$dialog_answer;
	global $event_effects,$prov_level_name,$terrain,$nastr,$unit_race,$def_name,$res_name,$item_name,$spell_name;
	global $all_item_num,$all_def_num,$all_def,$all_out_build_num,$all_out_build,$all_spell_num,$camp_file_name,$u_name,$event_print;
	global $group_count,$group_event,$group_begin,$group_file_name,$treasure_free_space,$treasure_item_cnt,$link_check,$group_check,$ruler;
	$p .= "<HR>";
	$p .= "<span style='color:fuchsia'><a name=\"".$g."e".$i."\"></a><B>/".$i." ".$event_table[$i]."</B></span><br>";
	if($i!=0)
	{
/*
		$p .= "<B>event_out:</B> ";
		foreach($event_out[$i] as $val)
			if(!in_array($i,$group_noscan))
				$p .= "<a href=\"#".$g."e".$val."\">".$val." (".$event_table2[$val].")</a> ";
		$p .= "<br>";
*/
		if($g=="")
		{
			$p .= "<B>Группа:</B> ";
			if(in_array($i,$group_noscan))
				$p .= "<span style='color:blue'>Много</span>";
			else
				for($j=1;$j<=$group_count;$j++)
					if(in_array($i,$group_event[$j]))
						$p .= "<a href=\"$group_file_name#".$j."e0\">".$j." (".$event_table2[$group_begin[$j]].")</a> ";
			$p .= "<br>";
			if(preg_match("@<B>Группа:</B> <br>@s",$p) && !in_array($i,range(942,1005)))
				$group_check[] = $i;//для проверки на пустые группы
		}
		$p .= "<B>Ссылки из:</B> ";
		foreach(explode(',',$event_in[$i]) as $val)
//echo $val." - ";
//dumper($group_event[$g+1-1],"G=$g");
			if(($val!="") && (in_array($val,$group_event[$g]) || $g==""))//группа или нет
				if(!in_array($i,$group_noscan))
					$p .= "<a href=\"#".$g."e".$val."\">".$val." (".$event_table2[$val].")</a> ";
				else
					$p .= "<a href=\"#".$g."e".$val."\">".$val." (".$event_table2[$val].")</a> ";
//					$p .= "<a href=\"#".$g."e".$val."\">".$val."</a> ";
		foreach($event_in_enc[$i] as $val)
				$p .= "<a href=\"".$enc_file_name."#e".$val."\">ENCOUNTER ".$val." (".$enc_table[$val].")</a> ";
		foreach($event_in_ritual[$i] as $val)
				$p .= "<span style='color:blue'>RITUAL_".$val."_(".$ritual_name[$val].")</span> ";
		foreach($event_in_site[$i] as $val)
				$p .= "<span style='color:blue'>SITE_".$val."_(".$site_name[$val].")</span> ";
		foreach($event_in_out_build[$i] as $val)
				$p .= "<span style='color:blue'>OUTER_BUILD_".$val."_(".$out_build_name[$val].")</span> ";
		foreach($event_in_inner_build[$i] as $val)
				$p .= "<span style='color:blue'>INNER_BUILD_".$val."_(".$inner_build_name[$val].")</span> ";
		foreach($event_in_prov[$i] as $val)
				$p .= "<span style='color:blue'>PROVINCE_TYPE_".$val."_(".$prov_name[$val].")</span> ";
	}
	$p .= "<br>\n";
	if(preg_match("@<B>Ссылки из:</B> <br>@s",$p) && $event_poss[$i]==0 && !in_array($i,range(942,1005)))
		$link_check[] = $i;//для проверки на пустые события
//		$p .= (($event_in[$i]=="") ? "" :"<B>Ссылки из:</B> ".substr($event_in[$i],0,-2)."<br>");
	$p .= "<span style='color:brown'>Карма:</span> <B>";
	if($event_karma[$i]>0)
		$p .= "<span style='color:green'>+";
	else
	if($event_karma[$i]<0)
		$p .= "<span style='color:red'>";
	$p .= $event_karma[$i]."</span></B>";
//	$p .= (($event_type[$i]==0) ? "" : ", <span style='color:brown'>Тип:</span> <B>".$event_type[$i])."</B>";
	$p .= (($event_type[$i]==0) ? "" : ", <span style='color:brown'>Тип:</span> <B>".(($event_type[$i]>0) ? "<span style='color:green'>".$event_type[$i] : "<span style='color:red'>".$event_type[$i]))."</B>";
	$p .= "</span>";
	$p .= (($event_poss[$i]==0) ? "" : ", <span style='color:brown'>Вероятность (вес):</span> <B>".$event_poss[$i])."</B>";
	if($event_dialog_param1[$i]!=0)
		$p .= "<br><span style='color:brown'>DlgParam1: </span> <B>".$dialog_param[$event_dialog_param1[$i]]."</B>";
	if($event_dialog_param2[$i]!=0)
		$p .= "<br><span style='color:brown'>DlgParam2: </span> <B>".$dialog_param[$event_dialog_param2[$i]]."</B>";
	$p .= "<br>";
	if($event_attacker[$i]!=0)
	{
		$p .= "<span style='color:brown'>Атакующий отряд:</span> <B>".$g_name[$event_attacker[$i]]."</B>";
//		$p .= ", EventWin: ".(($event_win[$i]==0) ? "0" : $event_win[$i]." (".$event_table[$event_win[$i]].")");
		$p .= ", <span style='color:brown'>победа:</span> <B><a href=\"#".$g."e".$event_win[$i]."\">".$event_win[$i]."</a></B>";
		$p .= ", <span style='color:brown'>поражение:</span> <B><a href=\"#".$g."e".$event_lose[$i]."\">".$event_lose[$i]."</a></B>";
		$p .= ", <span style='color:brown'>ничья:</span> <B><a href=\"#".$g."e".$event_draw[$i]."\">".$event_draw[$i]."</a><br></B>";
		$p .= "<span style='color:brown'>Тип провинции:</span> <B>".(($event_prov[$i]==0) ? "Любая" : $prov_name[$event_prov[$i]])."</B>";
		$p .= "<br>";
	}
	else
	if(($event_win[$i]!=0)||($event_lose[$i]!=0)||($event_draw[$i]!=0)||($event_prov[$i]!=0))
	{
		$p .= "<span style='color:brown'>Диалог с охраной (атака):</span> ";
		$p .= "<span style='color:brown'>победа:</span> <B><a href=\"#".$g."e".$event_win[$i]."\">".$event_win[$i]."</a></B>";
		$p .= ", <span style='color:brown'>поражение:</span> <B><a href=\"#".$g."e".$event_lose[$i]."\">".$event_lose[$i]."</a></B>";
		$p .= ", <span style='color:brown'>ничья:</span> <B><a href=\"#".$g."e".$event_draw[$i]."\">".$event_draw[$i]."</a></B>";
		$p .= "<br><span style='color:brown'>Тип провинции:</span> <B>".(($event_prov[$i]==0) ? "Любая" : $prov_name[$event_prov[$i]])."</B>";
		$p .= "<br>";
	}
	$p .= "<br>";
	if($event_dialog[$i]!=0)
	{
		$p .= "<B><span style='color:brown'>Диалог:</span></B><br>";
		$p .= "<table cellpadding=10 background=bg.gif><tr><td align=right width=162 height=296>";
		$p .= "<img src=i/".$dialog_bitmap[$event_dialog[$i]].".gif></td>";
		$p .= "<td valign=top width=293><B><span class=txt><br>".$dialog_text[$event_dialog[$i]]."</span></B></td>";
		$p .= "</tr></table>";
		$p .= "<B><span style='color:brown'>Ответы:</span></B>";
		$p .= "<pre>";
		for($j=1;($event_answer[$i][$j]!="") && ($j<8);$j++)
		{
			$ans=$event_answer[$i][$j]+1-1;
			if($ans==0)	$l=1; else	$l=floor(log10($ans))+1;
			if($l==1) $ll="    ";
			else if($l==2) $ll="   ";
			else if($l==3) $ll="  ";
			else if($l==4) $ll=" ";
			$p .= "<B>".$j.":[=><a href=\"#".$g."e".$ans."\">".$ans."</a>";
			$p .= sprintf ("$ll%-$answer_len[$i]s",$event_table[$ans]);
			$p .= "]</B> ";
			$p .= str_replace("$","зол.",str_replace("&","кр.",$dialog_answer[$event_dialog[$i]][$j]))."\n";
		}
		$p .= "</pre>";
	}
	$p .= "<B><span style='color:brown'>Эффекты:</span></B>";
//	$p .= "<B><span style='color:red'>Эффекты:</span></B> ".count($event_effects[$i]);
	$p .= "<ul>";
//	if(($event_effects[$i][1]['num']=="") && ($event_effects[$i][0]['num']+1-1==0)) //если только нулевой эффект
//		$p .= "Нет";
	$treasure_item_cnt[$i] = 0;//для проверки свободных мест в сокровищнице
	for($j=0;($event_effects[$i][$j]['num']!="")&&($j<16);$j++)
	{
		$p .= "<li>";
		$num=$event_effects[$i][$j]['num']+1-1;
		$power=$event_effects[$i][$j]['power'];
		$param1=$event_effects[$i][$j]['param1'];
		$param2=$event_effects[$i][$j]['param2'];
//$p .= $i."-".$num."<br>";		
		if($num==0)
		{
			$p .= "Нет";
		}
		else
		if($num==1)
		{
/*
			$p .= "Изменить золото игрока на ".(($power>0) ? "+" : "-");
			if($param1==0)
				$p .= abs($power);
			else
				$p .= "(".abs($power)."-".(abs($param1)+abs($power)).")";
*/
			if($power>0)
			{
				$p .= "Изменить золото игрока на <B><span style='color:green'>+";
				if($param1==0)
					$p .= $power;
				else
					$p .= "(".$power."-".($param1+$power).")";
			}
			else
			{
				$p .= "Изменить золото игрока на <B><span style='color:red'>-";
				if($param1==0)
					$p .= abs($power);
				else
				if(abs($param1) > abs($power))
					$p .= abs($power)."</span> - <span style='color:green'>+".abs($param1+$power);
				else
					$p .= "(".abs($param1+$power)."-".abs($power).")";
			}
			if($param2==1)
				$p .= "*Уровень_провинции";
			else
			if($param2==2)
				$p .= "%";
			$p .= "</span>";
		}
		else
		if($num==2)
		{
			$p .= "Изменить отношение провинции на <B>";
			$p .= (($power>0) ? "<span style='color:green'>+" : "<span style='color:red'>");
			$p .= $power."</span>";
		}
		else
		if($num==3)
		{
			if($power>0)
			{
				$p .= "Изменить количество населения провинции на <B><span style='color:green'>+";
				if($param1==0)
					$p .= $power;
				else
					$p .= "(".$power."-".($param1+$power).")";
			}
			else
			{
				$p .= "Изменить количество населения провинции на <B><span style='color:red'>-";
				if($param1==0)
					$p .= abs($power);
				else
					$p .= "(".abs($param1+$power)."-".abs($power).")";
			}
			$p .= "%</span>";
		}
		else
		if($num==4)
		{
			$p .= "Ответ <B>".$power."</B> появляется, если ";
			if($param1==1)
				$p .= "золото игрока >= <B>".$param2;
			else
			if($param1==2)
				$p .= "кристаллы игрока >= <B>".$param2;
			else
			if($param1==3)
				$p .= "в провинции есть охрана или герой";
		}
		else
		if($num==5)
		{
			if($power>0)
			{
				$p .= "Доход с провинции изменяется на <B><span style='color:green'>+";
				if($param1==0)
					$p .= $power;
				else
					$p .= "(".$power."-".($param1+$power).")";
			}
			else
			{
				$p .= "Доход с провинции изменяется на <B><span style='color:red'>-";
				if($param1==0)
					$p .= abs($power);
				else
					$p .= "(".abs($param1+$power)."-".abs($power).")";
			}
			$p .= "</span>";
		}
		else
		if($num==6)
		{
			if($power>0)
			{
				$p .= "Изменить кристаллы игрока на <B><span style='color:green'>+";
				if($param1==0)
					$p .= $power;
				else
					$p .= "(".$power."-".($param1+$power).")";
			}
			else
			{
				$p .= "Изменить кристаллы игрока на <B><span style='color:red'>-";
				if($param1==0)
					$p .= abs($power);
				else
				if(abs($param1) > abs($power))
					$p .= abs($power)."</span> - <span style='color:green'>+".abs($param1+$power);
				else
					$p .= "(".abs($param1+$power)."-".abs($power).")";
			}
			if($param2==1)
				$p .= "*Уровень_провинции";
			else
			if($param2==2)
				$p .= "%";
			$p .= "</span>";
		}
		else
		if($num==7)
		{
			if($power>=0)
			{
				$p .= "Карма игрока изменяется на <B><span style='color:green'>+";
				if($param1==0)
					$p .= $power;
				else
					$p .= "(".$power."-".($param1+$power-1).")";
			}
			else
			{
				$p .= "Карма игрока изменяется на <B><span style='color:red'>-";
				if($param1==0)
					$p .= abs($power);
				else
					$p .= "(".abs($param1+$power-1)."-".abs($power).")";
			}
			$p .= "</span>";
		}
		else
		if($num==8)
		{
			$p .= "Условие появления в провинции: ";
			if($power==1)
				$p .= "если уровень провинции >= <B>".$prov_level_name[$param1];
			else
			if($power==2)
				$p .= ($param1==0) ? "<B><span style='color:red'>!!!$i - территория провинции =0!!!</B></span>" :"если территория провинции = <B>".$terrain[$param1];
			else
			if($power==3)
				$p .= "если у игрока золота >= <B>".$param1;
			else
			if($power==4)
				$p .= "если есть свободное место для скрытого сайта";
			else
			if($power==5)
				$p .= "если настроение жителей провинции <= <B>".$nastr[$param1];
			else
			if($power==6)
				$p .= "если настроение жителей провинции >= <B>".$nastr[$param1];
			else
			if($power==7)
				$p .= "если уровень провинции <= <B>".$prov_level_name[$param1];
			else
			if($power==8)
			{
				$p .= "если в сокровищнице есть <B>".$param1."</B> или больше свободных мест";
				$treasure_free_space[$i] = $param1;//для проверки свободных мест в сокровищнице
			}
			else
			if(($power==9) || ($power==10))
			{
				$kar=$param1;
				$p .= (($power==9) ? "если карма игрока <= <B>" : "если карма игрока >= <B>");
				$p .= (($kar>0) ? "+" : "");
				$p .= $kar." (";
/*				if(($kar>=-30000) && ($kar<=-200))
					$p .= "Тёмный";
				else
				if(($kar>=-199) && ($kar<=-150))
					$p .= "Безжалостный";
				else
				if(($kar>=-149) && ($kar<=-100))
					$p .= "Грозный";
				else
				if(($kar>=-99) && ($kar<=-75))
					$p .= "Кровожадный";
				else
				if(($kar>=-74) && ($kar<=-50))
					$p .= "Свирепый";
				else
				if(($kar>=-49) && ($kar<=-30))
					$p .= "Злой";
				else
				if(($kar>=-29) && ($kar<=-20))
					$p .= "Коварный";
				else
				if(($kar>=-19) && ($kar<=-10))
					$p .= "Бесчестный";
				else
				if(($kar>=-9) && ($kar<=9))
					$p .= "Нейтральный";
				else
				if(($kar>=10) && ($kar<=19))
					$p .= "Честный";
				else
				if(($kar>=20) && ($kar<=29))
					$p .= "Справедливый";
				else
				if(($kar>=30) && ($kar<=49))
					$p .= "Милосердный";
				else
				if(($kar>=50) && ($kar<=74))
					$p .= "Добрый";
				else
				if(($kar>=75) && ($kar<=99))
					$p .= "Мудрый";
				else
				if(($kar>=100) && ($kar<=149))
					$p .= "Великомудрый";
				else
				if(($kar>=150) && ($kar<=199))
					$p .= "Великий";
				else
				if(($kar>=200) && ($kar<=30000))
					$p .= "Светлый";
*/
				for($r=0;$r<count($ruler);$r++)
				{
					if(($kar >= $ruler[$r][0]) && ($kar <= $ruler[$r][1]))
					{
						$p .= $ruler[$r][2];
						break;//for
					}
				}
				$p .= ")";
			}
			else
			if($power==11)
				$p .= "только не в родовой провинции";
			else
			if($power==12)
				$p .= "только в прибрежной провинции";
			else
			if($power==13)
				$p .= "только в провинции, населённой расой <B>".$unit_race[$param1];
			else
			if($power==14)
				$p .= (($param1>0) ? "в провинции есть герой или стража" : "в провинции есть герой");
			else
			if($power==15)
				$p .= "только в родовой провинции";
			else
			if($power==16)
				$p .= "если в провинции нет ресурса";
			else
			if($power==17)
			{
				$p .= "если в провинции есть место для ";
				$p .= (($param1==-1) ? "открытого сайта" : "скрытого сайта");
			}
			else
			if($power==18)
			{
				$p .= "если в провинции ";
				$p .= (($param1==0) ? "нет охраны" : "есть стража <B>".$def_name[$param1]);
			}
			else
			if($power==19)
				$p .= "если в провинции есть постройка <B>".$out_build_name[$param1];
			else
			if($power==20)
				$p .= "если в провинции есть место для постройки (только не в родовой провинции)";
			else
			if($power==21)
				$p .= "если в провинции нет постройки <B>".$out_build_name[$param1];
			else
			if($power==22)
				$p .= "если коррупция >= <B>".$param1."%";
			else
			if($power==23)
				$p .= "если у игрока кристаллов >= <B>".$param1;
			else
			if($power==24)
				$p .= "если у игрока есть доступ к ресурсу <B>".$res_name[$param1];
			else
			if($power==25)
				$p .= "если у игрока нет доступа к ресурсу <B>".$res_name[$param1];
			else
			if($power==26)
			{
				$p .= "<span style='color:aqua'>(только кампания) если значение флага</span> <B><a href=\"".$camp_file_name."#f".$param1."\">".$param1."</a>";
				$p .= "</B><span style='color:aqua'> из кампании истинно, и текущий ход</span> >= <B>".$param2;
			}	
			else
			if($power==27)
				$p .= "если в провинции нет героя";
			else
			if($power==28)
				$p .= "если в провинции нет сайта <B>".$site_name[$param1];
			else
			if($power==29)
				$p .= "если в сокровищнице есть предмет <B>".$item_name[$param1];
			else
			if($power==30)
				$p .= "если в провинции нет стражника";
			else
			if($power==31)
				$p .= "если в провинции есть сайт <B>".$site_name[$param1];
			else
			if($power==32)
				$p .= "если в отряде героя, находящегося в провинции, есть демоны";
			else
				echo "$i <B>!!!ERROR!!! NUM=".$num."COND=".$power;
		}
		else
		if($num==9)
		{
			$p .= "В провинции появляется новый сайт <B>".$site_name[$power]."</B>";
			$p .= (($param1>0) ? " (скрытый" : " (открытый");
			if($param2==-1)
				$p .= ", без стражи)";
			else
			if($param2==0)
				$p .= ", стража по умолчанию)";
			else
				$p .= ", со стражей)";
		}
		else
		if($num==10)
		{
			if($power>=0)
			{
				$p .= "Изменить накопленное недовольство в провинции на <B><span style='color:green'>+";
				if($param1==0)
					$p .= $power;
				else
					$p .= "(".$power."-".($param1+$power).")";
			}
			else
			{
				$p .= "Изменить накопленное недовольство в провинции на <B><span style='color:red'>-";
				if($param1==0)
					$p .= abs($power);
				else
					$p .= "(".abs($param1+$power)."-".abs($power).")";
			}
			$p .= "</span>";
		}
		else
		if($num==11)
		{
			if($param1>0)
			{
				$p .= "С вероятностью <B>".$param2."%</B> вызвать событие <B><a href=\"#".$g."e";
				$p .= $power."\">".$power." (".$event_table2[$power].")</a></B>";
				$p .= ", иначе вызвать событие <B><a href=\"#".$g."e".$param1."\">".$param1;
				$p .= " (".$event_table2[$param1].")</a>";
			}
			else
			{
				if($g=="")//без групп
					$fl="";
				else
				{
					$fl=0;
					foreach($group_begin as $k=>$val)
					{
						if($val==$power)//переход в соответствующую группу
						{
							$fl=$k;//№ группы
							break;
						}
					}
					if($fl==0)//наверно, остались в той же группе..
					{
						if(in_array($power,$group_event[$g]))//.да?..
							$fl=$g;
						else
							$p .= "!!! Переход в левую какую-то группу - слишком сложная конструкция для скрипта...<br>";//.нет :(
					}
				}
				if($param1<0)
				{
					$p .= "С вероятностью <B>".$param2."%</B> вызвать событие <B><a href=\"#".$fl."e";
					$p .= $power."\">".$power." (".$event_table2[$power].")</a></B>";
				}
				else
					$p .= "Вызвать событие <B><a href=\"#".$fl."e".$power."\">".$power." (".$event_table2[$power].")</a>";
			}
		}
		else
		if($num==12)
		{
			$p .= "Получить <B>$param1</B> черт".get_plural($param1,"ёж","ежа","ежей")." постройки <B>";
/*			if($param1==1)
				$p .= "1</B> чертёж постройки <B>";
			else
			if(($param1>1) && ($param1<5))
				$p .= $param1."</B> чертежа постройки <B>";
			else
				$p .= $param1."</B> чертежей постройки <B>";
*/
			$p .= $out_build_name[$power];
		}
		else
/*		if($num==13)
		{
			$p .= "Получить <B>";
			if($param1==1)
				$p .= "1</B> свиток заклинания <B>";
			else
			if(($param1>1) && ($param1<5))
				$p .= $param1."</B> свитка заклинания <B>";
			else
				$p .= $param1."</B> свитков заклинания <B>";
			$p .= $spell_name[$power];
			$treasure_item_cnt[$i] += $param1;//для проверки свободных мест в сокровищнице
		}
*/		if($num==13)
		{
			$p .= "Получить <B>$param1</B> свит".get_plural($param1,"ок","ка","ков")." заклинания <B>";
			$p .= $spell_name[$power];
			$treasure_item_cnt[$i] += $param1;//для проверки свободных мест в сокровищнице
		}
		else
		if($num==14)
		{
			$p .= "Получить случайный предмет уровня <B>".$power;
			$p .= "</B>, c редкостью не ниже <B>".$param1;
			$treasure_item_cnt[$i] ++;//для проверки свободных мест в сокровищнице
		}
		else
		if($num==15)
		{
			$p .= "Установить уровень атакующего отряда в <B>".$power;
		}
		else
		if($num==16)
		{
			$p .= "Получить <B>$param1</B> предмет".get_plural($param1,"","а","ов")." <B>";
			if($power<=$all_item_num)
			{
				$p .= $item_name[$power];
			}
			else
			if($power<=$all_item_num+$all_spell_num)
			{
				$p .= "\"свиток заклинания ".$spell_name[$power-$all_item_num]."\"";
			}
			else
			if($power<=$all_item_num+$all_spell_num+$all_def_num)
			{
				$p .= "\"договор со стражей ".$all_def[$power-$all_item_num-$all_spell_num]."\"";
			}
			else
			if($power<=$all_item_num+$all_spell_num+$all_def_num+$all_out_build_num)
			{
				$p .= "\"чертёж постройки ".$all_out_build[$power-$all_item_num-$all_spell_num-$all_def_num]."\"";
			}
			else
				$p .= "\"свиток с ритуалом ".$ritual_name[$power-$all_item_num-$all_spell_num-$all_def_num-$all_out_build_num]."\"";
			$p .= "</B> с прочностью <B>".$param2."%";
			$treasure_item_cnt[$i] += $param1;//для проверки свободных мест в сокровищнице
		}
		else
		if($num==17)
		{
			$pp = $param1+$param2;
			$p .= "Установить флаг события <B><a href=\"#".$g."e".$power;
			$p .= "\">".$power." (".$event_table2[$power].")</a></B> в значение <B>";
			if($pp == -1)
				$p .= "\"Включено\"";
			else
			if($pp == 0)
				$p .= "\"Отключено\"";
			else
			if($pp >0)
			{
				$p .= "\"Произойдёт через ";
				if($param2==0)
					$p .= $param1;
				else
					$p .= "(".$param1."-".$pp.")";
				$p .= " ход".get_plural($pp,"","а","ов")." и отключится\"";
			}
			else
				$p .= "!!! ошибка в параметрах";
		}
		else
		if($num==18)
		{
			$p .= "Привязать флаг события <B><a href=\"#".$g."e".$power;
			$p .= "\">".$power." (".$event_table2[$power].")</a></B>";
			if($param1==0)
				$p .= " к случайной провинции";
			else
			if($param1==1)
				$p .= " к текущей провинции";
			else
			if($param1==2)
				$p .= " к родовой провинции";
		}
		else
		if($num==19)
		{
			if($power==0)
				$p .= "Уволить стражу провинции";
			else
				$p .= "Установить в провинции стражу <B>".$def_name[$power];
		}
		else
		if($num==20)
		{
			$p .= "Уничтожить в провинции постройку <B>".$out_build_name[$power];
		}
		else
		if($num==21)
		{
			$p .= "Возвести в провинции постройку <B>".$out_build_name[$power];
		}
		else
		if($num==22)
		{
			if($power>=0)
			{
				$p .= "Изменить коррупцию на <B><span style='color:green'>+";
				if($param1==0)
					$p .= $power;
				else
//					$p .= "(".$power."-".($param1+$power-1).")";
					$p .= "(".$power."-".($param1+$power).")";
			}
			else
			{
				$p .= "Изменить коррупцию на <B><span style='color:red'>-";
				if($param1==0)
					$p .= abs($power);
				else
//					$p .= "(".abs($param1+$power-1)."-".abs($power).")";
					$p .= "(".abs($param1+$power)."-".abs($power).")";
			}
			$p .= "%</span>";
		}
		else
		if($num==23)
		{
			if($power>0)
			{
				$p .= "Доход кристаллов с провинции изменяется на <B><span style='color:green'>+";
				if($param1==0)
					$p .= $power;
				else
					$p .= "(".$power."-".($param1+$power).")";
			}
			else
			{
				$p .= "Доход кристаллов с провинции изменяется на <B><span style='color:red'>-";
				if($param1==0)
					$p .= abs($power);
				else
					$p .= "(".abs($param1+$power)."-".abs($power).")";
			}
			$p .= "</span>";
		}
		else
		if($num==24)
		{
			$p .= "Уничтожить в провинции сайт <B>".$site_name[$power];
		}
		else
		if($num==25)
		{
			$p .= "Разрушить <B>";
			if($power==1)
				$p .= "1</B> постройку в провинции";
			else
				$p .= $power."</B> постройки в провинции";
		}
		else
		if($num==26)
		{
			$p .= "Изменить отношение к игроку во всех провинциях расы <B>".$unit_race[$power];
			$p .= "</B> на <B>".(($param1>0) ? "<span style='color:green'>+" : "<span style='color:red'>").$param1."</span>";
		}
		else
		if($num==27)
		{
			$p .= "Изменить цену на ресурс <B>".$res_name[$power]."</B>";
			if($param1>0)
			{
				$p .= " на <B><span style='color:green'>+";
				if($param2==0)
					$p .= $param1;
				else
					$p .= "(".$param1."-".($param2+$param1).")";
			}
			else
			{
				$p .= " на <B><span style='color:red'>-";
				if($param2==0)
					$p .= abs($param1);
				else
					$p .= "(".abs($param2+$param1)."-".abs($param1).")";
			}
			$p .= "%</span>";
		}
		else
		if($num==28)
		{
			$p .= "Флаг глобального события, сообщение о котором выдаётся сразу всем игрокам (пока не работает)";
		}
		else
		if($num==29)
		{
			if($power>=0)
				$p .= "Охранник и все отряды, находящиеся в провинции, излечиваются на <span style='color:green'>";
			else
				$p .= "Здоровье всех отрядов и охранника в провинции уменьшается на <span style='color:red'>";
			$p .= "<B>".abs($power);
			$p .= (($param1==0) ? "" : "%");
			$p .= "</span>";
			$p .= (($power>0) ? "" : "</B> (с учётом Сопротивления)");
			$p .= (($param2==1) ? "</B>. Действует только на живых" : "");
		}
		else
		if($num==30)
		{
			if($power>0)
			{
				$p .= "Изменить боевой дух отрядов героев и охраны в провинции на <B><span style='color:green'>+";
				if($param1==0)
					$p .= $power;
				else
					$p .= "(".$power."-".($param1+$power).")";
			}
			else
			{
				$p .= "Изменить боевой дух отрядов героев и охраны в провинции на <B><span style='color:red'>-";
				if($param1==0)
					$p .= abs($power);
				else
					$p .= "(".abs($param1+$power)."-".abs($power).")";
			}
			$p .= "</B></span>";
			if($param2>0)
				$p .= " (прибавляется добрым воинам, у злых отнимается, на нейтралов не подействует)";
			else
			if($param2<0)
				$p .= " (прибавляется злым воинам, у добрых отнимается, на нейтралов не подействует)";
		}
		else
		if($num==31)
		{
			$p .= "Инициировать восстание в провинции";
		}
		else
		if($num==32)
		{
			if($power>0)
			{
				$p .= "Починить укрепления в провинции на <B><span style='color:green'>";
				if($param1==0)
					$p .= $power;
				else
					$p .= "(".$power."-".($param1+$power).")";
			}
			else
			{
				$p .= "Повредить укрепления в провинции на <B><span style='color:red'>";
				if($param1==0)
					$p .= abs($power);
				else
					$p .= "(".abs($param1+$power)."-".abs($power).")";
			}
			$p .= "</span>";
		}
		else
		if($num==33)
		{
			$p .= "<span style='color:aqua'>Установить значение флага кампании</span> <B><a href=\"".$camp_file_name."#f".$power."\">".$power."</a>";
			$p .= "</B><span style='color:aqua'> равным</span>  <B>".$param1;
		}
		else
		if($num==34)
		{
			$p .= "<span style='color:aqua'>Добавить игроку в кампании </span><B>";
			if($param1==0)
				$p .= $power;
			else
				$p .= "(".$power."-".($param1+$power).")";
			$p .= "</B><span style='color:aqua'> энергии</span>";
		}
		else
		if($num==35)
		{
			$p .= "<span style='color:aqua'>Открыть доступ к постройке в кампании</span>";
		}
		else
		if($num==36)
		{
			$p .= "Добавить в гарнизон <B>";
			if($param1==1)
				$p .= "1</B> юнита <B>";
			else
				$p .= $param1."</B> юнитов <B>";
			$p .= $u_name[$power];
			$p .= "</B> с опытом <B>(0-".$param2.")";
		}
		else
		if($num==37)
		{
			$p .= "<span style='color:aqua'>Перейти к событию кампании</span> <B><a href=\"".$camp_file_name."#e".$power."\">".$power."</a>";
			$p .= "</B><span style='color:aqua'> (в момент обнаружения команды)</span>";
		}
		else
		if($num==38)
		{
			$p .= "При потере золота в этом событии будет учтена Сокровищница";
		}
		else
		if($num==39)
		{
			$p .= "Сделать провинцию нейтральной";
		}
		else
		if($num==40)
		{
			$type=$power;
			$p .= "Получить случайный предмет типа<B> ";
			if(($type==1) || ($type==2) ||($type==9))
			{
				$p .= "\"Оружие и щиты\"";
				$q = check_art_count($type,$param1,$param2);
				if($q < 2)
					$p .= "!!!check_art_count = $q";
			}
			else
			if($type==3)
			{
				$p .= "\"Луки и стрелы\"";
				$q = check_art_count($type,$param1,$param2);
				if($q < 2)
					$p .= "!!!check_art_count = $q";
			}
			else
			if($type==4)
			{
				$p .= "\"Жезлы и сферы\"";
				$q = check_art_count($type,$param1,$param2);
				if($q < 2)
					$p .= "!!!check_art_count = $q";
			}
			else
			if($type==5)
			{
				$p .= "\"Знамёна\"";
				$q = check_art_count($type,$param1,$param2);
				if($q < 2)
					$p .= "!!!check_art_count = $q";
			}
			else
			if($type==6)
			{
				$p .= "\"Кожа и пояса\"";
				$q = check_art_count($type,$param1,$param2);
				if($q < 2)
					$p .= "!!!check_art_count = $q";
			}
			else
			if($type==7)
			{
				$p .= "\"Кольчуги\"";
				$q = check_art_count($type,$param1,$param2);
				if($q < 2)
					$p .= "!!!check_art_count = $q";
			}
			else
			if($type==8)
			{
				$p .= "\"Латы\"";
				$q = check_art_count($type,$param1,$param2);
				if($q < 2)
					$p .= "!!!check_art_count = $q";
			}
			else
			if($type==10)
			{
				$p .= "\"Свитки\"";
			}
			else
			if($type==11)
				$p .= "\"Договор со стражем\"";
			else
			if($type==12)
				$p .= "\"Чертёж постройки\"";
			else
			if($type==13)
				$p .= "\"Ритуал\"";
			else
			if($type==-1)
			{
				$p .= "\"Одежда\"";
				$q = check_art_count($type,$param1,$param2);
				if($q < 2)
					$p .= "!!!check_art_count = $q";
			}
			else
			if($type==-2)
			{
				$p .= "\"Украшения\"";
				$q = check_art_count($type,$param1,$param2);
				if($q < 2)
					$p .= "!!!check_art_count = $q";
			}
			else
				$p .= "<B>$i !!!ERROR!!! NUM=".$num."Получить случайный предмет: неизвестный тип $type</B>";
			$p .= "</B>, уровня <B>".$param1;
			$p .= "</B>, c редкостью не ниже <B>".$param2;
			$treasure_item_cnt[$i] ++;//для проверки свободных мест в сокровищнице
		}
		else
		if($num==41)
		{
			$p .= "Удалить из сокровищницы предмет <B>".$item_name[$power];
			$treasure_item_cnt[$i] --;//для проверки свободных мест в сокровищнице
		}
		else
		if($num==42)
		{
			$p .= "Получить <B>$param1</B> договор".get_plural($param1,"","а","ов");
			$p .= " со стражем <B>".$def_name[$power];
		}
		else
		if($num==47)
		{
			$p .= "Получить <B>$param1</B> свит".get_plural($param1,"ок","ка","ков");
			$p .= " ритуала <B>".$ritual_name[$power];
		}
		else
		if($num==48)
			$p .= "Изменить расу, живущую в провинции, на <B>".$unit_race[$power]."</B>, а тип провинции - на <B>".$prov_name[$param1];
		else
		if($num==49)
			$p .= "Ухудшить настроение в провинции на <B>$power</B>, если оно было положительным или нейтральным, или же улучшить - если отрицательным";
		else
		if($num==50)
			$p .= "Занято под внутренние потребности игры";
		else
			echo "<B>$i !!!ERROR!!! NUM=".$num;
		$p .= "</B></li>";
	}
	$p .= "</ul>\n";
//	$p .= "-------------------------------------------------------------<br>";
	$event_print[$i]=$p;
	$p="";
}

/*
for($i=0;$i<$max_e+1;$i++)
{
//	if($i!=0) $p .= "<B>Ссылки из:</B> ";
//	if(!(($event_in[$i]||$event_in_enc[$i]||$event_in_ritual[$i]||$event_in_site[$i]||$event_in_out_build[$i]||$event_in_inner_build[$i]||$event_in_prov[$i]) || $event_poss[$i])) echo "!!!пустое поле";
//	if($i!=0) echo (($event_in[$i]=="") ? "" :"<B>Ссылки из:</B> ");
//	print_r(array_count_values (explode(',',$event_in_print[$i])));
}
*/
function scan_group($g_num,$begin)
{
	global $group_event,$group_event2,$event_out,$group_event_num;
//	echo "SCAN: NUM=$g_num BEGIN=$begin <br>";
	$group_event_num[$begin] = 1;//флаг попадания события в какую-либо группу (для выявления "пропавших")
	if(!in_array($begin,$group_event[$g_num]))
	{
		$group_event[$g_num][] = $begin;//массив всех событий в группе
		$group_event2[$begin][] = $g_num;//в каких группах находится данное событие
	}
	foreach($event_out[$begin] as $val)
	{
//		echo "SCAN: NUM=$g_num BEGIN=$val <br>";
//		if(!in_array($val,$group_noscan))
		if(!in_array($val,$group_event[$g_num]))
			scan_group($g_num,$val);
	}
}

/*
		foreach($event_in_ritual[$i] as $val)
				$p .= "<span style='color:blue'>RITUAL_".$val."_(".$ritual_name[$val].")</span> ";
		foreach($event_in_site[$i] as $val)
				$p .= "<span style='color:blue'>SITE_".$val."_(".$site_name[$val].")</span> ";
		foreach($event_in_out_build[$i] as $val)
				$p .= "<span style='color:blue'>OUTER_BUILD_".$val."_(".$out_build_name[$val].")</span> ";
		foreach($event_in_inner_build[$i] as $val)
				$p .= "<span style='color:blue'>INNER_BUILD_".$val."_(".$inner_build_name[$val].")</span> ";
		foreach($event_in_prov[$i] as $val)
*/
//dumper($group_event);
for($i=1;$i<$max_e+1;$i++)
{
//попытка найти "начальные" события в группе
	if(!in_array($i,$event_not_begin) && (in_array($i,$event_yes_begin) || $event_in[$i]=="" || $event_poss[$i]!=0 || isset($event_in_enc[$i][0]) || isset($event_in_ritual[$i][0]) || isset($event_in_site[$i][0]) || isset($event_in_out_build[$i][0]) || isset($event_in_inner_build[$i][0]) || isset($event_in_prov[$i][0])))
	{
//		$event_print[$i] .= "<br><span style='color:red'><B>(((Начало)))</B></span><br>";
		$group_count++;//число групп
		$group_begin[] = $i;//массив начальных номеров событий
		scan_group($group_count,$i);
	}
}
//unset($group_event[143]);//убрать неиспользуемые события
//unset($group_event[213]);

//------------------------------------------------------------------------------
$G=1;//Флаг переключения: Группы (G==1)/нет
//------------------------------------------------------------------------------

if($G==1)
{
	echo "<h2 align=\"center\">Группы событий<br></h2>";
	$s=explode(':',$event_file[0]);
	echo "Всего попаданий событий в какую-либо группу: ".count($group_event_num)."<br>";
	echo "Не попавшие: ";
	for($i=1;$i<$s[1];$i++)
	{
		if(!isset($group_event_num[$i])) echo "$i ";
	}
	echo "<br>";
	echo "Event quantity: <B>".$s[1]."</B><br>";
	echo "Group quantity: <B>$group_count</B><br>";
	echo "<HR SIZE=3 COLOR=grey>";
	echo "<span style='color:green'><B>Оглавление:</B></span><br><HR>";
	for($i=1;$i<=$group_count;$i++)
	{
		$type = $event_type[$group_begin[$i]];
		$p = "<B>[Тип: ".($type>0 ? "+" : "")."$type, Вес: ".$event_poss[$group_begin[$i]]."]</B>";
		echo "<a href=\"#".$i."e0\">№$i ( /$group_begin[$i] ".$event_table2[$group_begin[$i]].")</a> ";
		if($type > 0)
			echo "<span style='color:green'>$p</span><br>";
		else
		if($type < 0)
			echo "<span style='color:red'>$p</span><br>";
		else
			echo "$p<br>";
	}
	$p = "";
	for($i=1;$i<=$group_count;$i++)
//for($i=1;$i<=2;$i++)
	{
		echo "<HR SIZE=5 COLOR=red>";
		echo "<a name=\"".$i."e0\"></a><h3 align=center>Группа <span style='color:red'>№$i</span> (".$event_table2[$group_begin[$i]].")</h3>";
//	echo "<a name=\"".$i."e0\"></a><h3 align=center><span style='color:#CC99FF'>Группа №$i (".$event_table2[$group_begin[$i]].")</span></h3>";
		$cnt=0;//для проверки свободных мест в сокровищнице
		foreach($group_event[$i] as $val)
		{
			if($event_unit_egg[$val])
			{
				foreach($event_unit_egg[$val] as $u)//группа, где даются яйца
				{
					if(!in_array($u,$group_unit_egg[$i]))
					{
						$group_unit_egg[$i][] = $u;
						$event_unit_egg_file[$u][] = $i."|".$event_table2[$group_begin[$i]];
					}
				}
			}
			if($event_unit_garn[$val])
			{
				foreach($event_unit_garn[$val] as $u)//группа, где юниты добавляются в гарнизон
				{
					if(!in_array($u,$group_unit_garn[$i]))
					{
						$group_unit_garn[$i][] = $u;
						$event_unit_garn_file[$u][] = $i."|".$event_table2[$group_begin[$i]];
					}
				}
			}
			if($event_unit_egg_rand[$val])
			{
				foreach($event_unit_egg_rand[$val] as $u)//группа, где даются потенциальные яйца
				{
//echo "event_unit_egg_rand - $u";
						$s = $u.$i."|".$event_table2[$group_begin[$i]];
						if(!in_array($s,$event_unit_egg_rand_file))
						{
							$event_unit_egg_rand_file[] = $s;
						}
				}
			}
			if($event_site[$val])
			{
				foreach($event_site[$val] as $u)//группа, где потенциально может появиться новый сайт
				{
					$s = $u.$i."|".$event_table2[$group_begin[$i]];
					if(!in_array($s,$event_site_file))
						$event_site_file[] = $s;
				}
			}
			if($event_outer[$val])
			{
				foreach($event_outer[$val] as $u)//группа, где потенциально можно возвести внешнюю постройку
				{
					$s = $u.$i."|".$event_table2[$group_begin[$i]];
					if(!in_array($s,$event_outer_file))
						$event_outer_file[] = $s;
				}
			}
			if($event_outer_scroll[$val])
			{
				foreach($event_outer_scroll[$val] as $cnt => $u)//группа, где можно получить чертежи постройки
				{
					$s = $u.$i."|".$event_table2[$group_begin[$i]]."|".$cnt;
					if(!in_array($s,$event_outer_scroll_file))
						$event_outer_scroll_file[] = $s;
				}
			}
			if($event_spell_scroll[$val])
			{
				foreach($event_spell_scroll[$val] as $cnt => $u)//группа, где можно получить свитки закла
				{
					$s = $u.$i."|".$event_table2[$group_begin[$i]]."|".$cnt;
					if(!in_array($s,$event_spell_scroll_file))
						$event_spell_scroll_file[] = $s;
				}
			}
			if($event_ritual_scroll[$val])
			{
				foreach($event_ritual_scroll[$val] as $cnt => $u)//группа, где можно получить свитки ритуала
				{
					$s = $u.$i."|".$event_table2[$group_begin[$i]]."|".$cnt;
					if(!in_array($s,$event_ritual_scroll_file))
						$event_ritual_scroll_file[] = $s;
				}
			}
			if($event_def_scroll[$val])
			{
				foreach($event_def_scroll[$val] as $cnt => $u)//группа, где можно получить договоры со стражей
				{
					$s = $u.$i."|".$event_table2[$group_begin[$i]]."|".$cnt;
					if(!in_array($s,$event_def_scroll_file))
						$event_def_scroll_file[] = $s;
				}
			}
			if($event_def[$val])
			{
				foreach($event_def[$val] as $u)//группа, где потенциально можно возвести внешнюю постройку
				{
					$s = $u.$i."|".$event_table2[$group_begin[$i]];
					if(!in_array($s,$event_def_file))
						$event_def_file[] = $s;
				}
			}
			if($event_item[$val])
			{
				foreach($event_item[$val] as $u)//группа, где потенциально можно получить предмет
				{
					$s = $u.$i."|".$event_table2[$group_begin[$i]];
					if(!in_array($s,$event_item_file))
						$event_item_file[] = $s;
				}
			}
			if($event_attacker[$val])
			{
				$s = $event_attacker[$val]."|".$i."|".$event_table2[$group_begin[$i]];
				if(!in_array($s,$event_attacker_file))
					$event_attacker_file[] = $s;
			}
/*			if($event_outer[$val])
			{
				foreach($event_outer[$val] as $outer)//группа, где можно получить чертежи постройки
				{
					$event_outer_file[] = $outer.$i."|".$event_table2[$group_begin[$i]];
				}
			}
*/
			event_prepare($val,$i);
			echo $event_print[$val];
			$e_list[$val]++;//сколько раз данное событие встречается во всех группах
			if($cnt < $treasure_item_cnt[$val])
				$cnt = $treasure_item_cnt[$val];
		}

//РАЗКОММЕНТИТЬ для проверки на Число свободных мест в сокровищнице
//		if($cnt != $treasure_free_space[$group_begin[$i]])
//			echo "!!! Число свободных мест в сокровищнице:".($treasure_free_space[$group_begin[$i]]+1-1).", а должно $cnt, начало: $group_begin[$i]";

		echo "<div style=\"text-align:right\"><a href=\"#".$i."e0\">К началу группы</a></div>";
	}
/*
	for($i=0;$i<$max_e+1;$i++)
	{
		if(isset($e_list[$i]))
			echo "$i - $e_list[$i] <br>";
		else
			echo "!!! $i - не попал в группы :( <br>";
	}
*/
//dumper($event_unit_egg_rand_file);
}
else//if($G!=1)
{
	echo "<h2 align=\"center\">События<br></h2>";
	$s=explode(':',$event_file[0]);
	echo "Event quantity: <B>".$s[1]."</B><br><br>";
	for($i=0;$i<$max_e+1;$i++)
	{
		if((count(split("%",$dialog_text[$event_dialog[$i]]))-1) > $event_dialog_param_count[$i]) //не совпадает к-во % с DlgParam
			echo "<B>$i !!!Ошибка в количестве DlgParam!!!</B><br>";
		event_prepare($i);
		echo $event_print[$i];
	}
	if(isset($link_check[0]))
	{
		echo "<HR><span style='color:red'><B>!!! Пустые (неиспользуемые) события, к которым нет обращений:</B> ";
		foreach($link_check as $val)
			echo "<a href=\"#e".$val."\">".$val." (".$event_table2[$val].")</a> ";
		echo "</span><br>";
	}
	if(isset($group_check[0]))
	{
		echo "<HR><span style='color:red'><B>!!! События без группы:</B> ";
		foreach($group_check as $val)
			echo "<a href=\"#e".$val."\">".$val." (".$event_table2[$val].")</a> ";
		echo "</span><br>";
	}
}

//получение юнитов через события
if($G==1)
{

for($j=1;$j<=$max_ritual;$j++) //пройдёмся по ритуалам
{
	if($ritual_event[$j][0]!="")
	{
		foreach ($ritual_event[$j] as $ev)
		{
			foreach ($group_event2[$ev] as $v)
			{
				if($group_unit_egg[$v]!="")
				{
					foreach ($group_unit_egg[$v] as $vv)
					{
						$ritual_event_egg[$vv][] = $j;//Получение предмета найма: ритуал
					}
					unset($group_unit_egg[$v]);//удаляем те группы событий, которые пересекаются с ритуалом
				}
				if($group_unit_garn[$v]!="")
				{
					foreach ($group_unit_garn[$v] as $vv)
					{
						$ritual_event_garn[$vv][] = $j;//Добавить в гарнизон: ритуал
					}
					unset($group_unit_garn[$v]);//удаляем те группы событий, которые пересекаются с ритуалом
				}
			}
		}
	}
}
/*
dumper($event_unit_egg,"event_unit_egg");
dumper($event_unit_egg_file,"event_unit_egg_file");
dumper($group_unit_egg,"group_unit_egg");
dumper($event_unit_garn,"event_unit_garn");
dumper($event_unit_garn_file,"event_unit_garn_file");
dumper($group_unit_garn,"group_unit_garn");
dumper($ritual_event_egg,"ritual_event_egg");
dumper($ritual_event_garn,"ritual_event_garn");
dumper($ritual_event,"ritual_event");
dumper($group_event2,"group_event2");
*/
$f=fopen("event_unit.exp","w") or die("Ошибка при создании файла event_unit.exp");
fwrite($f,"#Format:\n#\$var_name\n#Unit|EventGroup|EventGroupName\n");
fwrite($f,"\$export_event_egg\n");
foreach($group_unit_egg as $key => $val)
{
	foreach($val as $vv)
		fwrite($f,$vv."|".$key."|".$event_table2[$group_begin[$key]]."\n");
}
fwrite($f,"\$export_event_garn\n");
foreach($group_unit_garn as $key => $val)
{
	foreach($val as $vv)
		fwrite($f,$vv."|".$key."|".$event_table2[$group_begin[$key]]."\n");
}
fclose($f);

$f=fopen("ritual_event.exp","w") or die("Ошибка при создании файла ritual_event.exp");
fwrite($f,"#Format:\n#\$var_name\n#Unit|ritual\n");
fwrite($f,"\$export_ritual_event_egg\n");
foreach($ritual_event_egg as $key => $val)
{
	foreach($val as $vv)
		fwrite($f,$key."|".$vv."\n");
}
fwrite($f,"\$export_ritual_event_garn\n");
foreach($ritual_event_garn as $key => $val)
{
	foreach($val as $vv)
		fwrite($f,$key."|".$vv."\n");
}
fwrite($f,"#Format:\n#ritual|EventGroup|EventGroupName|scroll_num\n");
fwrite($f,"\$export_ritual_event_scroll\n");
foreach($event_ritual_scroll_file as $val)
{
	fwrite($f,$val."\n");
}
fclose($f);

$f=fopen("event_unit_rand.exp","w") or die("Ошибка при создании файла event_unit_rand.exp");
fwrite($f,"#Format:\n#ShopLevel|Rarity|EventGroup|EventGroupName\n");
//fwrite($f,"\$export_event_egg_rand\n");
foreach($event_unit_egg_rand_file as $val)
{
	fwrite($f,$val."\n");
}
fclose($f);

//dumper($event_outer_file,"event_outer_file");

$f=fopen("site_event.exp","w") or die("Ошибка при создании файла site_event.exp");
fwrite($f,"#Format:\n#site|EventGroup|EventGroupName\n");
fwrite($f,"\$export_site_event\n");
foreach($event_site_file as $val)
{
	fwrite($f,$val."\n");
}
fclose($f);

$f=fopen("outer_event.exp","w") or die("Ошибка при создании файла outer_event.exp");
fwrite($f,"#Format:\n#outer_build|EventGroup|EventGroupName\n");
fwrite($f,"\$export_outer_event\n");
foreach($event_outer_file as $val)
{
	fwrite($f,$val."\n");
}
fwrite($f,"#Format:\n#outer_build|EventGroup|EventGroupName|scroll_num\n");
fwrite($f,"\$export_outer_event_scroll\n");
foreach($event_outer_scroll_file as $val)
{
	fwrite($f,$val."\n");
}
fclose($f);

$f=fopen("spell_event.exp","w") or die("Ошибка при создании файла spell_event.exp");
fwrite($f,"#Format:\n#spell|EventGroup|EventGroupName|scroll_num\n");
fwrite($f,"\$export_spell_event_scroll\n");
foreach($event_spell_scroll_file as $val)
{
	fwrite($f,$val."\n");
}
fclose($f);

$f=fopen("def_event.exp","w") or die("Ошибка при создании файла def_event.exp");
fwrite($f,"#Format:\n#defender|EventGroup|EventGroupName\n");
fwrite($f,"\$export_def_event\n");
foreach($event_def_file as $val)
{
	fwrite($f,$val."\n");
}
fwrite($f,"#Format:\n#defender|EventGroup|EventGroupName|scroll_num\n");
fwrite($f,"\$export_def_event_scroll\n");
foreach($event_def_scroll_file as $val)
{
	fwrite($f,$val."\n");
}
fclose($f);

$f=fopen("item_event.exp","w") or die("Ошибка при создании файла item_event.exp");
fwrite($f,"#Format:\n#item|EventGroup|EventGroupName\n");
fwrite($f,"\$export_item_event\n");
foreach($event_item_file as $val)
{
	fwrite($f,$val."\n");
}
fclose($f);

$f=fopen("guard_event.exp","w") or die("Ошибка при создании файла guard_event.exp");
fwrite($f,"#Format:\n#guard_type|EventGroup|EventGroupName\n");
fwrite($f,"\$export_guard_event\n");
foreach($event_attacker_file as $val)
{
	fwrite($f,$val."\n");
}
fclose($f);

}//if($G==1)

/*
$f=fopen("event_unit_garn.exp","w") or die("Ошибка открытия файла event_unit_garn.exp");
//fwrite($f,"#Format: Unit|EventGroup|EventGroupName\n");
fwrite($f,"#Format:\n#\$var_name\n#UnitFromEgg|EventGroup|EventGroupName\n");
foreach($event_unit_garn_file as $key => $val)
{
	foreach($val as $vv)
		fwrite($f,$key."|".$vv."\n");
}
fclose($f);
*/
//dumper($treasure_item_cnt);

?>
</body></html>
