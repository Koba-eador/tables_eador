<html><head>
<meta http-equiv="Content-Type" content="text/html charset=windows-1251">
<title>Эадор - Приключения</title></head><body>
<style>
.txt		{color:white; line-height:100%}
</style>
<?php
require_once "dumper.php";
$enc_file = file("encounter.var");
$count_enc = count($enc_file);
$d_file = file("dialog.var");
$count_d = count($d_file);
$b_file = file("inner_build.var");
$count_b = count($b_file);
$g_file = file("guard_type.var");
$count_g = count($g_file);
$prov_file = file("province_type.var");
$count_prov = count($prov_file);
$event_file = file("event.var");
$count_event = count($event_file);
$site_file = file("site.var");
$count_site = count($site_file);
$out_build_file = file("outer_build.var");
$count_out_build = count($out_build_file);
$spell_file = file("spell.var");
$count_spell = count($spell_file);
$item_file = file("item.var");
$count_item = count($item_file);
$def_file = file("defender.var");
$count_def = count($def_file);
$unit_file = file("unit.var");
$count_unit = count($unit_file);
$ritual_file = file("ritual.var");
$count_ritual = count($ritual_file);
$q_file = file("quest.var");
$count_q = count($q_file);
$ruler_file = file("ruler_nick.var");
$count_ruler = count($ruler_file);

$group_noscan = array(3,4);//не обрабатывать для групп приключений
$group_begin[0] = 0;//массив начальных номеров приключений - чтоб добавлялись с [1]

//"тонкие" подстройки, умело скрывающие недостатки алгоритмов группировки!
//$enc_yes_begin = array(1411);//дополнительные начальные события в группе
$enc_not_begin = range(729,999);//ошибочные начальные приключения в группе
$enc_not_begin[] = 1039;//1039 Казино (играем на 1000 монет - не используется)
$enc_not_begin[] = 1050;//1050 Казино (играем на 100 кристаллов - не используется)
$enc_not_begin[] = 1055;//1055 Казино (проигрыш 100 кристаллов - не используется)
$enc_not_begin[] = 1056;//1056 Казино (выигрыш от 100 кристаллов - не используется)

$no_export = array(205,209,237);//группы, к-е не надо передавать для "Получение" в unit.xls
//№205 (Алтарь Смерти, вход)
//№209 (Врата Бездны, после победы - не используется)
//№237 (Квест гноллов (награда - свиток осадного орудия) - не используется)

//$enc_flag_not_out = array(94,101,349,367,385,402,465,471);//устранение дублирующих групп:
//$enc_hardcode = array(80);
//$q_no = range(26,38);//Квесты Кампании

$camp_file_name="camp_Eador_NH_18.0601.htm";
//$camp_file_name="eador_camp.htm";
$event_file_name="event_Eador_NH_18.0601.htm";
//$event_file_name="eador_event.htm";
$q_file_name="quest_Eador_NH_18.0601.htm";
//$q_file_name="eador_quest.htm";
$group_file_name="encounter_group_Eador_NH_18.0601.htm";

$nastr = array(-5=>"Полны ненависти",-4=>"В ярости",-3=>"Возмущены",-2=>"Очень недовольны",-1=>"Недовольны","Спокойны","Довольны","Очень довольны","Счастливы");
$dialog_param = array (1=>"имя героя","величина из первого эффекта","название провинции квестодателя текущего квеста (или квеста расы текущей провинции, если квест не выбран)","название требуемого в сайте свитка","название и количество монстров для активного квеста типа 8 (Задание Кристалла)");
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


//Разбор quest.var
for($i = 0,$n=0; $i < $count_q; $i++)
{

	if(eregi("^/([0-9]{1,})",$q_file[$i],$k))
	{
		$n=$k[1];
	}
	else
	if(eregi("^name",$q_file[$i]))
	{
		$s=explode(':',$q_file[$i]);
		$q_name[$n]=substr(trim($s[1]),0,-1);
	}
	else
	if(eregi("^EncInit:",$q_file[$i]))
	{
	if($n<26 || $n>38) //26-38 - квесты кампании
	{
		$s=explode(':',$q_file[$i]);
		$q_init[$n]=$s[1]+1-1;
		foreach(explode(',',$enc_in_q[$s[1]+1-1]) as $val) //поиск дублей ссылок
			if($val==$n) $in_flag=1;
		if($in_flag!=1)
//			$enc_in_q[$s[1]+1-1]=$enc_in_q[$s[1]+1-1].$n.",";
			if(!in_array($n,$enc_in_q[$s[1]+1-1]))
				$enc_in_q[$s[1]+1-1][] = $n;//флаг где изменяется
		$in_flag=0;
	}
	}
	else
	if(eregi("^EncWait:",$q_file[$i]))
	{
	if($n<26 || $n>38) //26-38 - квесты кампании
	{
		$s=explode(':',$q_file[$i]);
		$q_wait[$n]=$s[1]+1-1;
		foreach(explode(',',$enc_in_q[$s[1]+1-1]) as $val) //поиск дублей ссылок
			if($val==$n) $in_flag=1;
		if($in_flag!=1)
//			$enc_in_q[$s[1]+1-1]=$enc_in_q[$s[1]+1-1].$n.",";
			if(!in_array($n,$enc_in_q[$s[1]+1-1]))
				$enc_in_q[$s[1]+1-1][] = $n;//флаг где изменяется
		$in_flag=0;
	}
	}
	else
	if(eregi("^EncFound:",$q_file[$i]))
	{
	if($n<26 || $n>38) //26-38 - квесты кампании
	{
		$s=explode(':',$q_file[$i]);
		$q_found[$n]=$s[1]+1-1;
		foreach(explode(',',$enc_in_q[$s[1]+1-1]) as $val) //поиск дублей ссылок
			if($val==$n) $in_flag=1;
		if($in_flag!=1)
//			$enc_in_q[$s[1]+1-1]=$enc_in_q[$s[1]+1-1].$n.",";
			if(!in_array($n,$enc_in_q[$s[1]+1-1]))
				$enc_in_q[$s[1]+1-1][] = $n;//флаг где изменяется
		$in_flag=0;
	}
	}
	else
	if(eregi("^EncNotFound:",$q_file[$i]))
	{
	if($n<26 || $n>38) //26-38 - квесты кампании
	{
		$s=explode(':',$q_file[$i]);
		$q_not_found[$n]=$s[1]+1-1;
		foreach(explode(',',$enc_in_q[$s[1]+1-1]) as $val) //поиск дублей ссылок
			if($val==$n) $in_flag=1;
		if($in_flag!=1)
//			$enc_in_q[$s[1]+1-1]=$enc_in_q[$s[1]+1-1].$n.",";
			if(!in_array($n,$enc_in_q[$s[1]+1-1]))
				$enc_in_q[$s[1]+1-1][] = $n;//флаг где изменяется
		$in_flag=0;
	}
	}
	else
	if(eregi("^EncDone:",$q_file[$i]))
	{
	if($n<26 || $n>38) //26-38 - квесты кампании
	{
		$s=explode(':',$q_file[$i]);
		$q_done[$n]=$s[1]+1-1;
		foreach(explode(',',$enc_in_q[$s[1]+1-1]) as $val) //поиск дублей ссылок
			if($val==$n) $in_flag=1;
		if($in_flag!=1)
//			$enc_in_q[$s[1]+1-1]=$enc_in_q[$s[1]+1-1].$n.",";
			if(!in_array($n,$enc_in_q[$s[1]+1-1]))
				$enc_in_q[$s[1]+1-1][] = $n;//флаг где изменяется
		$in_flag=0;
	}
	}
	else
	if(eregi("^EncSuccess:",$q_file[$i]))
	{
	if($n<26 || $n>38) //26-38 - квесты кампании
	{
		$s=explode(':',$q_file[$i]);
		$q_success[$n]=$s[1]+1-1;
		foreach(explode(',',$enc_in_q[$s[1]+1-1]) as $val) //поиск дублей ссылок
			if($val==$n) $in_flag=1;
		if($in_flag!=1)
//			$enc_in_q[$s[1]+1-1]=$enc_in_q[$s[1]+1-1].$n.",";
			if(!in_array($n,$enc_in_q[$s[1]+1-1]))
				$enc_in_q[$s[1]+1-1][] = $n;//флаг где изменяется
		$in_flag=0;
	}
	}
	else
	if(eregi("^EncFailGiver:",$q_file[$i]))
	{
	if($n<26 || $n>38) //26-38 - квесты кампании
	{
		$s=explode(':',$q_file[$i]);
		$q_fail_giver[$n]=$s[1]+1-1;
		foreach(explode(',',$enc_in_q[$s[1]+1-1]) as $val) //поиск дублей ссылок
			if($val==$n) $in_flag=1;
		if($in_flag!=1)
//			$enc_in_q[$s[1]+1-1]=$enc_in_q[$s[1]+1-1].$n.",";
			if(!in_array($n,$enc_in_q[$s[1]+1-1]))
				$enc_in_q[$s[1]+1-1][] = $n;//флаг где изменяется
		$in_flag=0;
	}
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
    if(eregi("^Effect:",$ritual_file[$i])) //effect  в ritual.var
    {
		$s=explode(':',$ritual_file[$i]);
		$ritual_num=$s[1]+1-1;	//массив № абилок
		$i++;
		$s=explode(':',$ritual_file[$i]);
		$ritual_param1=$s[1]+1-1;	//массив param1 абилок
		if($ritual_num==5) //ссылки на данное событие из др.событий, обработка кодов переходов
		{
//			$enc_in_ritual[$ritual_param1]=$enc_in_ritual[$ritual_param1].$n.",";//флаг где изменяется
			if(!in_array($n,$enc_in_ritual[$ritual_param1]))
				$enc_in_ritual[$ritual_param1][] = $n;//флаг где изменяется
			$ritual_enc[$n]=$ritual_param1;
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
//		$def_name[$n]=substr(trim($s[1]),0,-1);
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
    if(eregi("^Power:",$item_file[$i]))//разбор effects: item.var,spell.var
    {
		$s=explode(':',$item_file[$i-1]);
//		$effects[$n][$e1]['num']=$s[1]+1-1;	//массив № эффектов
		$s1=explode(':',$item_file[$i]);
//		$effects[$n][$e1]['power']=$s[1]+1-1;	//массив power, FlagEffect
		if(($s[1]+1-1) == 84) //summon
		{
//			$build_unit[$s1[1]+1-1]=$build_unit[$s1[1]+1-1].
			$item_summon[$n]=$s1[1]+1-1;
		}
//echo $n."-e1=".$e1." NUM=".$effects[$n][$e1]['num']." POWER=".$effects[$n][$e1]['power']." AREA=".$effects[$n][$e1]['area']."<br>";
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
			if(($s[1]+1-1)==8) //Существует чертёж постройки, для сквозной нумерации предметов
			{
				$all_out_build_num++;
				$all_out_build[$all_out_build_num]=$out_build_name[$n];
//echo $n."-".$all_out_build_num." ".$all_out_build[$all_out_build_num]."<br>";
			}
		}
    }
}

//Разбор site.var
for($i = 0,$n=0; $i < $count_site; $i++)
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
    if(eregi("^Encounter",$site_file[$i]))
    {
		$s=explode(':',$site_file[$i]);
		$site_enc[$n][]=$s[1]+1-1;
//		$enc_in_site[$s[1]+1-1]=$enc_in_site[$s[1]+1-1].$n.",";//флаг где изменяется
		if(!in_array($n,$enc_in_site[$s[1]+1-1]))
			$enc_in_site[$s[1]+1-1][] = $n;//флаг где изменяется
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
			if($abil_num==17) //ссылки на данное событие из др.событий, обработка кодов переходов
			{
				$site_enc[$n][]=$abil_param1;
				if(!in_array($n,$enc_in_site[$abil_param1]))
					$enc_in_site[$abil_param1][] = $n;//флаг где изменяется
			}
		}
    }
}

//Разбор event.var
for($i = 0,$n=0; $i < $count_event; $i++)
{  
   if(eregi("^/([0-9]{1,})",$event_file[$i],$k))
    {
		$n=$k[1];
		$s=substr($event_file[$i],log10($n)+3);
//echo $n."-".$s."<br>";
		$event_table[$n]=trim($s);
		if($event_table[$n][0]=='(')
			$event_table2[$n]=substr($event_table[$n],1,-1); //имя без скобок
		else
			$event_table2[$n]=$event_table[$n];
// echo $e_file[$i]."<br>".$k[0]."-".$k[1]."--".$dialog_table[$n]."<br>";
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
/*
    else
    if(eregi("^Guard:",$prov_file[$i]))//можно проще - см. event ;)
    {
		for($j=0;$j<16;$j++)
		{
			$i+=3;//encounter
			$s=explode(':',$prov_file[$i]);
			$enc_in_prov[$s[1]+1-1]=$enc_in_prov[$s[1]+1-1].$n.",";//флаг где изменяется
//echo $n."- J=".$j." [".($s[1]+1-1)."]=".$enc_in_prov[$s[1]+1-1]."<br>";
			$i++; //пустая строка
//echo "LAST=".substr(trim($event_file[$i-1]),-1,1)."<br>";
			if(substr(trim($prov_file[$i-1]),-1,1)==";") 
			{
//echo "BREAK<br>";			
				break; //for $j
			}
			$i++; //пустая строка
		}
    }
*/
    else
    if(eregi("^Encounter:",$prov_file[$i]))
    {
		$s=explode(':',$prov_file[$i]);
//		$enc_in_prov[$s[1]+1-1]=$enc_in_prov[$s[1]+1-1].$n.",";//флаг где изменяется
		if(!in_array($n,$enc_in_prov[$s[1]+1-1]))
			$enc_in_prov[$s[1]+1-1][] = $n;//флаг где изменяется
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
}

//Разбор encounter.var
for($i = 0,$n=0,$count=0; $i < $count_enc; $i++)
{  
	if(eregi("^/([0-9]{1,})",$enc_file[$i],$k))
    {
		$n=$k[1];
		if($count != $n) //неправильная нумерация событий
		{
			echo "!!!Сбитая нумерация №".$n."!!!<br>";
			$count=$n;
		}
		$count++;
		if($n>$max_e)$max_e=$n;
		$s=substr($enc_file[$i],log10($n)+3);
//echo $n."-".$s."<br>";
		$enc_table[$n]=trim($s);
// echo $e_file[$i]."<br>".$k[0]."-".$k[1]."--".$dialog_table[$n]."<br>";
    }
	else
	if(eregi("^Type:",$enc_file[$i]))
	{
		$s=explode(':',$enc_file[$i]);
		$enc_type[$n]=$s[1]+1-1;
	}	
	else
	if(eregi("^Dialog:",$enc_file[$i]))
	{
		$s=explode(':',$enc_file[$i]);
		$enc_dialog[$n]=$s[1]+1-1;
		$dialog_enc[$s[1]+1-1]=$n;
	}	
	else
	if(eregi("^DlgParam1:",$enc_file[$i]))
	{
		$s=explode(':',$enc_file[$i]);
		$enc_dialog_param1[$n]=$s[1]+1-1;
		if($enc_dialog_param1[$n]!=0) $enc_dialog_param_count[$n]++;
		if($enc_dialog_param1[$n]==5) $enc_dialog_param_count[$n]++;
	}	
	else
	if(eregi("^DlgParam2:",$enc_file[$i]))
	{
		$s=explode(':',$enc_file[$i]);
		$enc_dialog_param2[$n]=$s[1]+1-1;
		if($enc_dialog_param2[$n]!=0) $enc_dialog_param_count[$n]++;
		if($enc_dialog_param2[$n]==5) $enc_dialog_param_count[$n]++;
	}	
	else
	if(eregi("^Attacker:",$enc_file[$i]))
	{
		$s=explode(':',$enc_file[$i]);
		$enc_attacker[$n]=$s[1]+1-1;
	}	
	else
	if(eregi("^EncWin:",$enc_file[$i]))
	{
		$s=explode(':',$enc_file[$i]);
		$q=$enc_win[$n]=$s[1]+1-1;
		foreach(explode(',',$enc_in[$q]) as $val) //поиск дублей ссылок
			if($val==$n) $in_flag=1;
		if($in_flag!=1)
			$enc_in[$q] = $enc_in[$q].$n.",";
		$in_flag=0;
		if(!in_array($q,$enc_out[$n]))
			if($q!=0 && $q!=$n)
				$enc_out[$n][]=$q;
//		$enc_in[$enc_win[$n]]=$enc_in[$enc_win[$n]].$n.",";
//		$enc_cnt[$enc_win[$n]]++;
//		$enc_in[$enc_win[$n]][$enc_cnt[$enc_win[$n]]]=$n; //ссылки на данное событие из др.событий
	}	
	else
	if(eregi("^EncLose:",$enc_file[$i]))
	{
		$s=explode(':',$enc_file[$i]);
		$q=$enc_lose[$n]=$s[1]+1-1;
		foreach(explode(',',$enc_in[$q]) as $val) //поиск дублей ссылок
			if($val==$n) $in_flag=1;
		if($in_flag!=1)
			$enc_in[$q] = $enc_in[$q].$n.",";
		$in_flag=0;
		if(!in_array($q,$enc_out[$n]))
			if($q!=0 && $q!=$n)
				$enc_out[$n][]=$q;
//		$enc_in[$enc_lose[$n]]=$enc_in[$enc_lose[$n]].$n.",";
//		$enc_cnt[$enc_lose[$n]]++;
//		$enc_in[$enc_lose[$n]][$enc_cnt[$enc_lose[$n]]]=$n; //ссылки на данное событие из др.событий
	}	
	else
	if(eregi("^EncDraw:",$enc_file[$i]))
	{
		$s=explode(':',$enc_file[$i]);
		$enc_draw[$n]=$s[1]+1-1;
//		$enc_in[$enc_draw[$n]]=$enc_in[$enc_draw[$n]].$n.",";
//		$enc_cnt[$enc_draw[$n]]++;
//		$enc_in[$enc_draw[$n]][$enc_cnt[$enc_draw[$n]]]=$n; //ссылки на данное событие из др.событий
	}	
	else
	if(eregi("^Karma:",$enc_file[$i]))
	{
		$s=explode(':',$enc_file[$i]);
		$enc_karma[$n]=$s[1]+1-1;
	}
	else
	if(eregi("^\*Answers\*:",$enc_file[$i]))
	{
		while(1)
			if(trim($enc_file[$i+1]) == "") //пустая строка
				$i++;
			else
				break;
		for($j=1;(eregi("^Answer",$enc_file[$i+1])) && ($j<8);$j++)
		{
			$i++;
			$s=explode(':',$enc_file[$i]);
			$enc_answer[$n][$j]=$s[1];
			$q=$s[1]+1-1;
			foreach(explode(',',$enc_in[$q]) as $val) //поиск дублей ссылок
				if($val==$n) $in_flag=1;
			if($in_flag!=1)
				$enc_in[$q] = $enc_in[$q].$n.",";
			$in_flag=0;
			if(!in_array($q,$enc_out[$n]))
				if($q!=0 && $q!=$n)
					$enc_out[$n][]=$q;
//			$enc_cnt[$s[1]+1-1]++;
//			$enc_in[$s[1]+1-1][$enc_cnt[$s[1]+1-1]]=$n; //ссылки на данное событие из др.событий
//echo $n."(".$j.")".$enc_answer[$n][$j]."LEN=".$answer_len[$n]."<br>";
		}
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
			$enc_effects[$n][$j]['num']=$s[1];
			$num = $s[1]+1-1;
//echo $n."-".$enc_effects[$n][$j]['num']."<br>";;
			while(1)
				if(trim($enc_file[$i+1]) == "") //пустая строка
					$i++;
				else
					break;
			$i++;
			$s=explode(':',$enc_file[$i]);
			$power = $enc_effects[$n][$j]['power']=$s[1]+1-1;
			//echo "-".$s[1];
			while(1)
				if(trim($enc_file[$i+1]) == "") //пустая строка
					$i++;
				else
					break;
			$i++;
			$s=explode(':',$enc_file[$i]);
			$param1 = $enc_effects[$n][$j]['param1']=$s[1]+1-1;
//echo "-".$s[1];
			while(1)
				if(trim($enc_file[$i+1]) == "") //пустая строка
					$i++;
				else
					break;
			$i++;
			$s=explode(':',$enc_file[$i]);
			$param2 = $enc_effects[$n][$j]['param2']=$s[1]+1-1;
//echo "-".$s[1]."<br>";
//Вызвать приключение Power (если Param1>0 - Вызвать приключение Param1, если Random(100)>Param2) 
			if($num==11) //ссылки на данное событие из др.событий, обработка кодов переходов
			{
				foreach(explode(',',$enc_in[$power]) as $val) //поиск дублей ссылок
					if($val==$n) $in_flag=1;
				if($in_flag!=1)
					$enc_in[$power] .= $n.",";
				$in_flag=0;
				if(!in_array($power,$enc_out[$n]))
					if($power!=0 && $power!=$n)
						$enc_out[$n][]=$power;
				if($param1>0)
				{
					foreach(explode(',',$enc_in[$param1]) as $val) //поиск дублей ссылок
						if($val==$n) $in_flag=1;
					if($in_flag!=1)
						$enc_in[$param1] .= $n.",";
					$in_flag=0;
					if(!in_array($param1,$enc_out[$n]))
						if($param1!=$n)
							$enc_out[$n][]=$param1;
					if(!in_array($power,$enc_out[$n]))
						if($power!=0 && $power!=$n)
							$enc_out[$n][]=$power;
				}
			}
			else
			if($num==9)
			//В провинции появляется новый сайт Power. Если Param1>0 - сайт скрытый
			{
				$enc_site[$n][$param1] = "$power|";//список событий, где потенциально может появиться новый сайт
			}
			else
			if($num==12)//Получить Param1 чертежей постройки Power
			{
				$enc_outer_scroll[$n][$param1] = "$power|";//список приключений, где потенциально могут выпасть чертежи внешних построек
			}
			else
			if($num==13)//Получить Param1 свитков заклинания Power
			{
				$enc_spell_scroll[$n][$param1] = "$power|";//список приключений, где потенциально могут выпасть свитки заклинания
			}
			else
			if($num==14)//Получить случайный предмет уровня Power, c редкостью не ниже Param1
			{
				$enc_unit_egg_rand[$n][] = "$power|$param1|";//список приключений, где потенциально могут выпасть яйца
			}
			else
//Если условие с индексом Power НЕ выполняется, перейти к указанному в Param2 приключению
			if($num==15) //ссылки на данное событие из др.событий, обработка кодов переходов
			{
				foreach(explode(',',$enc_in[$param2]) as $val) //поиск дублей ссылок
					if($val==$n) $in_flag=1;
				if($in_flag!=1)
					$enc_in[$param2] .= $n.",";
				$in_flag=0;
				if(!in_array($param2,$enc_out[$n]))
					if($param2!=0 && $param2!=$n)
						$enc_out[$n][]=$param2;
			}
			else
//Если провинция охраняется стражем, то при разгроме их героем запустится ПРИКЛЮЧЕНИЕ Power
			if($num==99) //ссылки на данное событие из др.событий, обработка кодов переходов
			{
				foreach(explode(',',$enc_in[$power]) as $val) //поиск дублей ссылок
					if($val==$n) $in_flag=1;
				if($in_flag!=1)
					$enc_in[$power] .= $n.",";
				$in_flag=0;
				if(!in_array($power,$enc_out[$n]))
					if($power!=0 && $power!=$n)
						$enc_out[$n][]=$power;
			}
			else
//для проверки, прописана ли проверка на наличие зол/кр. для ответов			
			if($num==4) //Ответ №Power появляется при условии с индексом Param1
			{
				$d=$enc_dialog[$n];
				if($param1==1)
					$check_gold[$d][$power] = $param2;
				else
				if($param1==2)
					$check_cryst[$d][$power] = $param2;
//						echo "!!! $n: ".$dialog_answer[$d][$power]." - $param2<br>";
			}
			else
			if($num==21)//Получить предмет Power
			{
				if($item_summon[$power])//если предмет - яйцо
				{
					if(!in_array($power,$enc_unit_egg[$n]))
						$enc_unit_egg[$n][] = $power;//"юнит из яйца"
//echo "ENC=".$n." Получить через яйцо монстра ".$item_summon[$power]."<br>";
				$enc_item[$n][] = "$power|";//список приключений, где можно получить предмет
				}
				
			}
			else
			if($num==22)//Получить Param1 договоров со стражем Power
			{
				$enc_def_scroll[$n][$param1] = "$power|";//список приключений, где потенциально могут выпасть договоры со стражем
			}
			else
			if($num==29)//Добавить в список найма юнита Power
			{
				if(!in_array($power,$enc_unit_naim[$n]))
					$enc_unit_naim[$n][] = $power;
//echo "ENC=".$n." Добавить в список найма юнита ".$power."<br>";
//				$enc_site_unit[$n][] = $power;
			}
			else
			if($num==31)//Присоединить к отряду героя юнита типа Power 
			{
				if(!in_array($power,$enc_unit_join[$n]))
					$enc_unit_join[$n][] = $power;
//echo "ENC=".$n." Присоединить к отряду героя юнита ".$power."<br>";
				
			}
			else
			if($num==32)//В текущей провинции появляется постройка Power
			{
				$enc_outer[$n][] = "$power|";//список приключений, где потенциально можно возвести внешнюю постройку
			}
			else
			if($num==36)//Получить Param1 свитков ритуала Power
			{
				$enc_ritual_scroll[$n][$param1] = "$power|";//список приключений, где потенциально могут выпасть свитки ритуала
			}
			$i++; //пустая строка
//echo "LAST=".substr(trim($enc_file[$i-1]),-1,1)."<br>";
			if(substr(trim($enc_file[$i-1]),-1,1)==";") 
			{
//echo "BREAK<br>";			
				break; //for $j
			}
		}
	}
}

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
		$s=explode(':',$d_file[$i]);
		$s1=trim($s[1]);
		(substr($s1,-1,1)=="#") ? $dialog_answer[$n][1]=substr($s1,0,-6) : $dialog_answer[$n][1]=substr($s1,0,-1);
//echo $n."(1)".$dialog_answer[$n][1]."<br>";		
		for($j=2;(eregi("^Answer",$d_file[$i+1])) && ($j<8);$j++)
		{
			$i++;
			$s=explode(':',$d_file[$i]);
//echo $s[0]."-".$s[1]."<br>";
			$s1=trim($s[1]);
			(substr($s1,-1,1)=="#") ? $dialog_answer[$n][$j]=substr($s1,0,-6) : $dialog_answer[$n][$j]=substr($s1,0,-1);
//echo $n."(".$j.")".$dialog_answer[$n][$j]."<br>";
//РАСКОММЕНТИТЬ для проверки на правильность диалогов с изменением золота/кр.
/*
			if(isset($dialog_enc[$n]))//не обрабатываем event
			{
				preg_match('/ (\d+) \s* [\$|золот|Золот|монет] /xs',$dialog_answer[$n][$j],$match_gold);
				preg_match('/ (\d+) \s* [\&|крист|Крист] /xs',$dialog_answer[$n][$j],$match_cryst);
				$g=($match_gold[1]+1-1)!=0 ? $match_gold[1]+1-1 : "";
				$c=($match_cryst[1]+1-1)!=0 ? $match_cryst[1]+1-1 : "";
				if($check_gold[$n][$j]!=$g)
					echo "!!! Диалог $n($j) Зол - Enc $dialog_enc[$n] (".$enc_table[$dialog_enc[$n]]."): ".$dialog_answer[$n][$j]." - ".$check_gold[$n][$j]."<br>";
				if($check_cryst[$n][$j]!=$c)
					echo "!!! Диалог $n($j) Кр - Enc $dialog_enc[$n] (".$enc_table[$dialog_enc[$n]]."): ".$dialog_answer[$n][$j]." - ".$check_cryst[$n][$j]."<br>";
			}
*/
		}
	}
}

//Разбор answer encounter.var для длины строки
for($i = 0,$n=0; $i < $count_enc; $i++)
{  
   if(eregi("^/([0-9]{1,})",$enc_file[$i],$k))
    {
		$n=$k[1];
    }
	else
	if(eregi("^\*Answers\*:",$enc_file[$i]))
	{
		for($j=1;(eregi("^Answer",$enc_file[$i+1])) && ($j<8);$j++)
		{
			$i++;
			$s=explode(':',$enc_file[$i]);
			if($s[1]+1-1==0) 
				$len=2;
			else
//				$len=strlen($enc_table[$s[1]+1-1])+floor(log10($s[1]+1-1))-1;
				$len=strlen($enc_table[$s[1]+1-1]);
//echo $n."-".$len."<br>";			
			if($len>($answer_len[$n]+1-1)) $answer_len[$n]=$len;
//echo $n."(".$j.")".$enc_answer[$n][$j]."LEN=".$answer_len[$n]."<br>";
		}
	}	
}

$enc_table[0]="";
/*
echo "<h3 align=\"center\"> Приключения<br></h3>";
$s=explode(':',$enc_file[0]);
echo "Quantity: <B>".$s[1]."</B><br><br>";
//echo "-------------------------------------------------------------<br>";
*/

function enc_prepare($i,$g="")//подготовка к печати i-того приключения, или i-того приключения из группы g
{
	global $enc_table,$event_table2,$enc_in,$enc_out,$group_noscan,$event_file_name,$enc_dialog_param_count;
	global $enc_in_ritual,$ritual_name,$enc_in_site,$site_name,$out_build_name,$q_name,$build_name;
	global $enc_in_prov,$prov_name,$enc_in_q,$q_file_name,$enc_karma,$enc_type,$u_name,$enc_print;
	global $enc_poss,$enc_dialog_param1,$enc_dialog_param2,$enc_dialog,$dialog_param,$enc_attacker,$g_name;
	global $enc_win,$enc_lose,$enc_draw,$enc_prov,$dialog_bitmap,$dialog_text,$enc_answer,$answer_len,$dialog_answer;
	global $enc_effects,$prov_level_name,$terrain,$nastr,$unit_race,$def_name,$res_name,$item_name,$spell_name;
	global $all_item_num,$all_def_num,$all_def,$all_out_build_num,$all_out_build,$all_spell_num,$camp_file_name;
	global $group_count,$group_enc,$group_begin,$group_file_name,$link_check,$group_check,$enc_not_begin,$ruler;
	$p .= "<HR>";
	$p .= "<span style='color:fuchsia'><a name=\"".$g."e".$i."\"></a><B>/".$i." ".$enc_table[$i]."</B></span><br>";
	if($i!=0)
	{
/*
		$p .= "<B>enc_out:</B> ";
		foreach($enc_out[$i] as $val)
			if(!in_array($i,$group_noscan))
				$p .= "<a href=\"#".$g."e".$val."\">".$val." (".$enc_table[$val].")</a> ";
		$p .= "<br>";
*/
		if($g=="")
		{
			$p .= "<B>Группа:</B> ";
			if(in_array($i,$group_noscan))
				$p .= "<span style='color:blue'>Много</span>";
			else
				for($j=1;$j<=$group_count;$j++)
					if(in_array($i,$group_enc[$j]))
						$p .= "<a href=\"$group_file_name#".$j."e0\">".$j." (".$enc_table[$group_begin[$j]].")</a> ";
			$p .= "<br>";
			if(preg_match("@<B>Группа:</B> <br>@s",$p) && !in_array($i,$enc_not_begin))
				$group_check[] = $i;//для проверки на пустые группы
		}
		if((count(split("%",$dialog_text[$enc_dialog[$i]]))-1) > $enc_dialog_param_count[$i]) //не совпадает к-во % с DlgParam
			$p .= "<B>!!!Ошибка в количестве DlgParam</B><br>";
		$p .= "<B>Ссылки из:</B> ";
//	if(!($enc_in[$i]||$enc_in_q[$i]||$enc_in_ritual[$i]||$enc_in_site[$i]||$enc_in_prov[$i])) $p .= "!!!пустое поле";
//	if($i!=0) $p .= (($enc_in[$i]=="") ? "" :"<B>Ссылки из:</B> ");
//	print_r(array_count_values (explode(',',$enc_in_print[$i])));
		foreach(explode(',',$enc_in[$i]) as $val)
			if(($val!="") && (in_array($val,$group_enc[$g]) || $g==""))//группа или нет
				if(!in_array($i,$group_noscan))
					$p .= "<a href=\"#".$g."e".$val."\">".$val." (".$enc_table[$val].")</B></a> ";
				else
					$p .= "<a href=\"#".$g."e".$val."\">".$val." (".$enc_table[$val].")</B></a> ";
		foreach($enc_in_q[$i] as $val)
//			if($val<26 || $val>38) //26-38 - квесты кампании
				$p .= "<a href=\"".$q_file_name."#e".$val."\">QUEST ".$val." (".$q_name[$val].")</a> ";
		foreach($enc_in_ritual[$i] as $val)
			$p .= "<span style='color:blue'>RITUAL_".$val."_(".$ritual_name[$val].")</span> ";
		foreach($enc_in_site[$i] as $val)
			$p .= "<span style='color:blue'>SITE_".$val."_(".$site_name[$val].")</span> ";
		foreach($enc_in_prov[$i] as $val)
			$p .= "<span style='color:blue'>PROVINCE_TYPE_".$val."_(".$prov_name[$val].")</span> ";
	}
	$p .= "<br>\n";
	if(preg_match("@<B>Ссылки из:</B> <br>@s",$p) && !in_array($i,range(729,999)))
		$link_check[] = $i;//для проверки на пустые события
	$p .= "<span style='color:brown'>Карма:</span> <B>";
	if($enc_karma[$i]>0)
		$p .= "<span style='color:green'>+";
	else
	if($enc_karma[$i]<0)
		$p .= "<span style='color:red'>";
	$p .= $enc_karma[$i]."</span></B>";
	$p .= (($enc_type[$i]==0) ? "" : ", <span style='color:brown'>Тип:</span> <B>".(($enc_type[$i]>0) ? "<span style='color:green'>".$enc_type[$i] : "<span style='color:red'>".$enc_type[$i]))."</B>";
	$p .= "</span>";
	if($enc_dialog_param1[$i]!=0)
	//	$p .= "<br><span style='color:red'>DlgParam1: </span> <B>".$enc_dialog_param1[$i]." (".$dialog_param[$enc_dialog_param1[$i]].")</B>";
		$p .= "<br><span style='color:brown'>DlgParam1: </span> <B>".$dialog_param[$enc_dialog_param1[$i]]."</B>";
	if($enc_dialog_param2[$i]!=0)
//		$p .= "<br><span style='color:red'>DlgParam2: </span> <B>".$enc_dialog_param2[$i]." (".$dialog_param[$enc_dialog_param2[$i]].")</B>";
		$p .= "<br><span style='color:brown'>DlgParam2: </span> <B>".$dialog_param[$enc_dialog_param2[$i]]."</B>";
	$p .= "<br>";
	if($enc_attacker[$i]!=0)
	{
		$p .= "<span style='color:brown'>Атакующий отряд:</span> <B>".$g_name[$enc_attacker[$i]]."</B>";
		$p .= ", <span style='color:brown'>победа:</span> <B><a href=\"#".$g."e".$enc_win[$i]."\">".$enc_win[$i]."</a></B>";
		$p .= ", <span style='color:brown'>поражение:</span> <B><a href=\"#".$g."e".$enc_lose[$i]."\">".$enc_lose[$i]."</a></B>";
		$p .= ", <span style='color:brown'>ничья:</span> <B><a href=\"#".$g."e".$enc_draw[$i]."\">".$enc_draw[$i]."</a></B>";
		$p .= "<br>";
	}
	else
	if(($enc_win[$i]!=0)||($enc_lose[$i]!=0)||($enc_draw[$i]!=0))
	{
		$p .= "<span style='color:brown'>Диалог с охраной (атака):</span> ";
		$p .= "<span style='color:brown'>победа:</span> <B><a href=\"#".$g."e".$enc_win[$i]."\">".$enc_win[$i]."</a></B>";
		$p .= ", <span style='color:brown'>поражение:</span> <B><a href=\"#".$g."e".$enc_lose[$i]."\">".$enc_lose[$i]."</a></B>";
		$p .= ", <span style='color:brown'>ничья:</span> <B><a href=\"#".$g."e".$enc_draw[$i]."\">".$enc_draw[$i]."</a></B>";
		$p .= "<br>";
	}
	$p .= "<br>";
	if($enc_dialog[$i]!=0)
	{
		$p .= "<B><span style='color:brown'>Диалог:</span></B><br>";
//		$p .= $dialog_text[$enc_dialog[$i]];
		$p .= "<table cellpadding=10 background=bg.gif><tr><td align=right width=162 height=296>";
		$p .= "<img src=i/".$dialog_bitmap[$enc_dialog[$i]].".gif></td>";
		$p .= "<td valign=top width=293><B><span class=txt><br>".$dialog_text[$enc_dialog[$i]]."</span></B></td>";
		$p .= "</tr></table>";
		$p .= "<br><br><B><span style='color:brown'>Ответы:</span></B><br>";
		$p .= "<pre>";
		for($j=1;($enc_answer[$i][$j]!="") && ($j<8);$j++)
		{
			$ans=$enc_answer[$i][$j]+1-1;
			if($ans==0)	$l=1; else	$l=floor(log10($ans))+1;
			if($l==1) $ll="    ";
			else if($l==2) $ll="   ";
			else if($l==3) $ll="  ";
			else if($l==4) $ll=" ";
			$p .= "<B>".$j.":[=><a href=\"#".$g."e".$ans."\">".$ans."</a>";
//			printf ("$ll%-90s",$enc_table[$ans]);
			$p .= sprintf ("$ll%-".$answer_len[$i]."s",$enc_table[$ans]);
			$p .= "]</B> ";
			$p .= str_replace("$","зол.",str_replace("&","кр.",$dialog_answer[$enc_dialog[$i]][$j]))."\n";
		}
		$p .= "</pre>";
	}
	$p .= "<B><span style='color:brown'>Эффекты:</span></B>";
//	$p .= "<B><span style='color:red'>Эффекты:</span></B> ".count($enc_effects[$i]);
	$p .= "<ul>";
//	if(($enc_effects[$i][1]['num']=="") && ($enc_effects[$i][0]['num']+1-1==0)) //если только нулевой эффект
//		$p .= "Нет";
	for($j=0;($enc_effects[$i][$j]['num']!="")&&($j<16);$j++)
	{
		$p .= "<li>";
		$num=$enc_effects[$i][$j]['num']+1-1;
		$power=$enc_effects[$i][$j]['power'];
		$param1=$enc_effects[$i][$j]['param1'];
		$param2=$enc_effects[$i][$j]['param2'];
//$p .= $i."-".$num."<br>";		
		if($num==0)
		{
			$p .= "Нет";
		}
		else
		if($num==1)
		{
			$p .= "Изменить золото игрока на <B>";
			if(($power>0) && ($param2!=5))
			{
				$p .= "<span style='color:green'>+";
				if($param1==0)
					$p .= $power;
				else
					$p .= "(".$power."-".($param1+$power).")";
			}
			else
			if($power<0)
			{
				$p .= "<span style='color:red'>-";
				if($param1==0)
					$p .= abs($power);
				else
				if(abs($param1) > abs($power))
					$p .= abs($power)."</span> - <span style='color:green'>+".abs($param1+$power);
				else
					$p .= "(".abs($param1+$power)."-".abs($power).")";
			}
			if($param2==1)
				$p .= "*Сложность_приключения";
			else
			if($param2==2)
				$p .= "</B>значение <B>Параметра_1</B>, вычисленного в предыдущем приключении";
			else
			if($param2==3)
				$p .= "</B>значение <B>Параметра_2</B>, вычисленного в предыдущем приключении";
			else
			if($param2==4)
				$p .= "<span style='color:green'>+</span>(Эффект_дипломатии%)";
			else
			if($param2==5)
				$p .= "(Параметр_1, вычисленный в предыдущем приключении)*$power";
			else
			if($param2==6)
				$p .= "<span style='color:red'>-</B>(значение <B>Параметра_1</B>, вычисленного в предыдущем приключении)</span>";
			else
			if($param2==7)
				$p .= "<span style='color:red'>-(</B>значение <B>Параметра_2</B>, вычисленного в предыдущем приключении)</span>";
			$p .= "</span>";
		}
		else
		if($num==2)
		{
			$p .= "<B>Параметр_1 = ";
			if(($power>0) && ($param2!=5))
			{
				$p .= "<span style='color:green'>";
				if($param1==0)
					$p .= $power;
				else
					$p .= "(".$power."-".($param1+$power).")";
			}
			else
			if($power<0)
			{
				$p .= "<span style='color:red'>-";
				if($param1==0)
					$p .= abs($power);
				else
					$p .= "(".abs($param1+$power)."-".abs($power).")";
			}
			if($param2==1)
				$p .= "*Сложность_приключения";
			else
			if($param2==2)
				$p .= "</B>значение <B>Параметра_1</B>, вычисленного в предыдущем приключении";
			else
			if($param2==3)
				$p .= "</B>значение <B>Параметра_2</B>, вычисленного в предыдущем приключении";
			else
			if($param2==4)
				$p .= "+(Эффект_дипломатии%)";
			else
			if($param2==5)
				$p .= "(Параметр_1, вычисленный в предыдущем приключении)*$power";
			else
			if($param2==6)
				$p .= "-(</B>значение <B>Параметра_1</B>, вычисленного в предыдущем приключении)";
			else
			if($param2==7)
				$p .= "-(</B>значение <B>Параметра_2</B>, вычисленного в предыдущем приключении)";
			$p .= "</span>";
			$p .= "</B> (для передачи в следующее приключение)";
		}
		else
		if($num==3)
		{
			$p .= "Установить внутреннюю сложность приключения = <B>";
			if($power==1)
				$p .= "Уровень_провинции";
			else
			if($power==2)
				$p .= "Уровень_сайта";
			else
			if($power==3)
				$p .= "Уровень_квеста";
			else
			if($power==4)
				$p .= $param1;
			if($power!=4)
				if($param1>0)
					$p .= " (не усиливать атакующий отряд даже после 50 пройденных ходов)";
		}
		else
		if($num==4)
		{
			$p .= "Ответ <B>".$power."</B> появляется при условии: ";
			if($param1==1)
				$p .= "золото игрока >= <B>".$param2;
			else
			if($param1==2)
				$p .= "кристаллы игрока >= <B>".$param2;
			else
			if($param1==3)
				$p .= "золото игрока >= полученного <B>Параметра_1";
			else
			if($param1==4)
				$p .= "кристаллы игрока >= полученного <B>Параметра_1";
			else
			if($param1==5)
				$p .= "золото игрока >= полученного <B>Параметра_2";
			else
			if($param1==6)
				$p .= "кристаллы игрока >= полученного <B>Параметра_2";
			else
			if($param1==7)
				$p .= "дипломатия героя >= <B>".$param2;
			else
			if($param1==8)
				$p .= "в родовом замке построено здание <B>".$build_name[$param2];
			else
			if($param1==9)
				$p .= "герой может брать в отряд юнита ранга <B>".$param2;
			else
			if($param1==10)
				$p .= "Задание кристалла, param2 = <B>".$param2;
			else
			if($param1==11)
			{
				$p .= "<span style='color:aqua'>событие (event)</span> <B>";
				$p .= "<a href=\"".$event_file_name."#e".$param2."\">".$param2." (".$event_table2[$param2].")</a></B> уже произошло";
			}
			else
			if($param1==12)
				$p .= "если место действия - не родовая провинция";
			else
				$p .= "<B>!!!ERROR IN INDEX 4: \"появляется при условии:\": Неизвестное условие ".$param1;
		}
		else
		if($num==5)
		{
			$p .= "<B>Параметр_2 = ";
			if(($power>0) && ($param2!=5))
			{
				$p .= "<span style='color:green'>";
				if($param1==0)
					$p .= $power;
				else
					$p .= "(".$power."-".($param1+$power).")";
			}
			else
			if($power<0)
			{
				$p .= "<span style='color:red'>-";
				if($param1==0)
					$p .= abs($power);
				else
					$p .= "(".abs($param1+$power)."-".abs($power).")";
			}
			if($param2==1)
				$p .= "*Сложность_приключения";
			else
			if($param2==2)
				$p .= "</B>значение <B>Параметра_1</B>, вычисленного в предыдущем приключении";
			else
			if($param2==3)
				$p .= "</B>значение <B>Параметра_2</B>, вычисленного в предыдущем приключении";
			else
			if($param2==4)
				$p .= "*(Эффект_дипломатии%)";
			else
			if($param2==5)
				$p .= "(Параметр_1, вычисленный в предыдущем приключении)*$power";
			else
			if($param2==6)
				$p .= "-(</B>значение <B>Параметра_1</B>, вычисленного в предыдущем приключении)";
			else
			if($param2==7)
				$p .= "-(</B>значение <B>Параметра_2</B>, вычисленного в предыдущем приключении)";
			$p .= "</span>";
			$p .= "</B> (для передачи в следующее приключение)";
		}
		else
		if($num==6)
		{
			$p .= "Изменить кристаллы игрока на <B>";
			if(($power>0) && ($param2!=5))
			{
				$p .= "<span style='color:green'>+";
				if($param1==0)
					$p .= $power;
				else
					$p .= "(".$power."-".($param1+$power).")";
			}
			else
			if($power<0)
			{
				$p .= "<span style='color:red'>-";
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
				$p .= "</B>значение <B>Параметра_1</B>, вычисленного в предыдущем приключении";
			else
			if($param2==3)
				$p .= "</B>значение <B>Параметра_2</B>, вычисленного в предыдущем приключении";
			else
			if($param2==4)
				$p .= "*(Эффект_дипломатии%)";
			else
			if($param2==5)
				$p .= "(Параметр_1, вычисленный в предыдущем приключении)*$power";
			else
			if($param2==6)
				$p .= "-(</B>значение <B>Параметра_1</B>, вычисленного в предыдущем приключении)";
			else
			if($param2==7)
				$p .= "-(</B>значение <B>Параметра_2</B>, вычисленного в предыдущем приключении)";
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
			$p .= "<span style='color:aqua'>Передать управление событию (event)</span> <B>";
			$p .= "<a href=\"".$event_file_name."#e".$power."\">".$power." (".$event_table2[$power].")</a>";
		}
		else
		if($num==9)
		{
			$p .= "В провинции появляется новый сайт <B>".$site_name[$power]."</B> ";
			$p .= (($param1>0) ? "(скрытый)" : "(открытый)");
		}
		else
		if($num==10)
		{
			$p .= "Установить флаг переговоров в значение <B>";
			$p .= (($power>0) ? "<span style='color:green'>" : (($power<0) ? "<span style='color:red'>" : ""));
			$p .= $power."</span>";
		}
		else
		if($num==11)
		{
			if($param1>0)
			{
				$p .= "С вероятностью <B>".$param2."%</B> вызвать приключение <B><a href=\"#".$g."e";
				$p .= $power."\">".$power." (".$enc_table[$power].")</a></B>";
				$p .= ", иначе вызвать приключение <B><a href=\"#".$g."e".$param1."\">".$param1;
				$p .= " (".$enc_table[$param1].")</a>";
			}
			else
//				$p .= "Вызвать приключение <B><a href=\"#".$g."e".$power."\">".$power." (".$enc_table[$power].")</a>";
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
						if(in_array($power,$group_enc[$g]))//.да?..
							$fl=$g;
						else
							$p .= "!!! Переход в левую какую-то группу - слишком сложная конструкция для скрипта...<br>";//.нет :(
					}
				}
				if($param1<0)
				{
					$p .= "С вероятностью <B>".$param2."%</B> вызвать приключение <B><a href=\"#".$fl."e";
					$p .= $power."\">".$power." (".$enc_table[$power].")</a></B>";
				}
				else
					$p .= "Вызвать приключение <B><a href=\"#".$fl."e".$power."\">".$power." (".$enc_table[$power].")</a>";
			}
		}
		else
		if($num==12)
		{
			$p .= "Получить <B>";
			if($param1==1)
				$p .= "1</B> чертёж постройки <B>";
			else
			if(($param1>1) && ($param1<5))
				$p .= $param1."</B> чертежа постройки <B>";
			else
				$p .= $param1."</B> чертежей постройки <B>";
			$p .= $out_build_name[$power];
		}
		else
		if($num==13)
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
		}
		else
		if($num==14)
		{
			$p .= "Получить случайный предмет уровня <B>".$power;
			$p .= "</B>, c редкостью не ниже <B>".$param1;
		}
		else
		if($num==15)
		{
			$p .= "Перейти к приключению <B><a href=\"#".$g."e".$param2."\">".$param2." (".$enc_table[$param2].")</B></a> ";
			if($power==1)
				$p .= ", если Сила отряда героя <= Силы NPC";
			else
			if($power==2)
				$p .= ", если Дипломатия героя < <B>".$param1;
			else
			if(($power==3) || ($power==4))
			{
				$kar=$param1;
				$p .= (($power==3) ? ", если карма игрока < <B>" : ", если карма игрока > <B>");
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
			if($power==5)
				$p .= "с вероятностью <B>".(100-$param1)."%";
			else
			if($power==6)
				$p .= "если настроение жителей провинции <= <B>".$nastr[$param1-1];
			else
			if($power==7)
			{
				if($param1==0)
					$p .= ", если квест данной расы уже получен этим героем";
				else
				if($param1==1)
					$p .= ", если квест данной расы уже получен другим героем";
				else
				if($param1==2)
					$p .= ", если квест данной расы уже получен в другой провинции той же расы";
				else
				if($param1==4)
					$p .= ", если текущий квест ещё не выполнен этим героем";
				else
				if($param1==5)
					$p .= ", если квест данного сайта уже получен этим героем";
				else
				if($param1==6)
					$p .= ", если квест данного сайта уже получен любым героем";
			}
			else
			if($power==8)
			{
				if($param1==0)
					$p .= ", если заключён союз с этой расой";
				else
				if($param1==1)
					$p .= ", если заключён союз с другой расой";
			}
			else
			if($power==9)
				$p .= ", если Сложность квеста(8) из текущего сайта = <B>".$param1;
			else
			if($power==10)
				$p .= ", если <B>Random(100-Дипломатия*10) < ".(100-$param1);
			else
			if($power==11)
				$p .= ", если в провинции есть постройка <B>".$out_build_name[$param1];
			else
			if($power==12)
				$p .= ", если в провинции нет места для постройки";
			else
			if($power==13)
				$p .= ", <span style='color:aqua'>если флаг кампании</span> <B><a href=\"".$camp_file_name."#f".$param1."\">".$param1."</a> = 0";
			else
			if($power==14)
			{
				$p .= ", <span style='color:aqua'>если не происходило событие (event)</span> <B>";
				$p .= "<a href=\"".$event_file_name."#e".$param1."\">".$param1." (".$event_table2[$param1].")</a>";
			}
			else
			if($power==15)
				$p .= ", если в замке не построено здание <B>".$build_name[$param1];
			else
			if($power==16)
				$p .= ", если сумка героя полна";
			else
				$p .= "<B>!!!ERROR IN \"Перейти к приключению\": Неизвестное условие ".$power;
		}
		else
		if($num==16)
		{
			$p .= "Ранить героя на <B><span style='color:red'>";
			if($param1==0)
				$p .= $power;
			else
				$p .= "(".$power."-".($param1+$power).")";
			$p .= "%</span></B> жизни (не может убить)";
		}
		else
		if($num==17)
		{
			$p .= "Если происходит ";
			if($param1==0)
				$p .= "получение квеста";
			else
			if($param1==1)
				$p .= "ожидание квеста";
			else
			if($param1==2)
				$p .= "выполнение квеста";
			$p .= ", то передать управление ";
			if($power==0)
				$p .= "текущему квесту";
			else
			if($power==1)
				$p .= "расовому квесту";
			else
			if($power==2)
				$p .= "квесту сайта";
		}
		else
		if($num==18)
		{
			$p .= "Изменить состояние текущего квеста на <B>";
			if($power==0)
				$p .= "\"взят\"";
			else
			if($power==1)
				$p .= "\"выполнен\"";
			else
			if($power==2)
				$p .= "\"отказ\"";
		}
		else
		if($num==19)
		{
			$p .= "Заключить союз с нацией текущей провинции";
		}
		else
		if($num==20)
		{
			$p .= "Изменить отношение жителей в провинции на <B>";
			$p .= (($power>0) ? "<span style='color:green'>+".$power : "<span style='color:red'>".$power);
			$p .= "</span>";
		}
		else
		if($num==21)
		{
			$p .= "Получить предмет <B>";
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
		}
		else
		if($num==22)
		{
			$p .= "Получить <B>";
			if($param1==1)
				$p .= "1</B> договор ";
			else
			if(($param1>1) && ($param1<5))
				$p .= $param1."</B> договора ";
			else
				$p .= $param1."</B> договоров ";
			$p .= "</B>со стражем <B>".$def_name[$power];
		}
		else
		if($num==23)
		{
			$p .= "Излечить героя и его отряд";
		}
		else
		if($num==24)
		{
			$p .= "Войти в магазин сайта";
		}
		else
		if($num==25)
		{
			$p .= "Дать герою ";
			if($param2>0)
				$p .= "и его воинам ";
			$p .= "<span style='color:green'><B>";
			if($param1==0)
				$p .= $power;
			else
				$p .= "(".$power."-".($param1+$power).")";
			$p .= "</B></span> опыта";
		}
		else
		if($num==26)
		{
			$p .= "Изменить боевой дух отряда героя на <B>";
			if($power>=0)
			{
				$p .= "<span style='color:green'>+";
				if($param1==0)
					$p .= $power;
				else
					$p .= "(".$power."-".($param1+$power).")";
			}
			else
			{
				$p .= "<span style='color:red'>-";
				if($param1==0)
					$p .= abs($power);
				else
					$p .= "(".abs($param1+$power)."-".abs($power).")";
			}
			$p .= "</span>";
			if($param2>0)
				$p .= "</B> (значение вычтется у злых воинов, а добрым прибавится; на нейтралов не подействует)";
			else
			if($param2<0)
				$p .= "</B> (значение вычтется у добрых воинов, а злым прибавится; на нейтралов не подействует)";
		}
		else
		if($num==27)
		{
			$p .= "Установить уровень атакующего отряда в <B>".$power;
		}
		else
		if($num==28)
		{
			if($power>0)
				$p .= "Заменить текущий сайт сайтом <B>".$site_name[$power];
			else
				$p .= "Уничтожить текущий сайт";
		}
		else
		if($num==29)
		{
			$p .= "Добавить в список найма юнита <B>".$u_name[$power];
			if($param1>0)
				$p .= "</B> и вызвать окно найма";
		}
		else
		if($num==30)
		{
			$p .= "Установить значение ";
			if($enc_dialog_param1[$i]==3)
				$p .= "<B>DlgParam1</B> в название текущей провинции";
			else
			if($enc_dialog_param2[$i]==3)
				$p .= "<B>DlgParam2</B> в название текущей провинции";
//			$p .= "Установить значение того DlgParam, который равен 3, в название текущей провинции";
		}
		else
		if($num==31)
		{
			$p .= "Присоединить к отряду героя юнита <B>".$u_name[$power]."</B> уровня <B>";
			if($param2==0)
				$p .= $param1;
			else
				$p .= "(".$param1."-".($param1+$param2).")";
		}
		else
		if($num==32)
		{
			$p .= "В текущей провинции появляется постройка <B>".$out_build_name[$power];
		}
		else
		if($num==33)
		{
			if($power>=0)
				$p .= "Герой и его отряд излечиваются на <span style='color:green'>";
			else
				$p .= "Здоровье героя и его отряда уменьшается на <span style='color:red'>";
//			$p .= "Здоровье героя и его отряда ";
//			$p .= (($power>0) ? "увеличивается на <span style='color:green'>" : "уменьшается на <span style='color:red'>");
			$p .= "<B>".abs($power);
			$p .= (($param1==0) ? "" : "%");
			$p .= "</span>";
			$p .= (($power>0) ? "" : "</B> (с учётом Сопротивления)");
			$p .= (($param2==1) ? "</B>. Действует только на живых" : "");
		}
		else
		if($num==34)
		{
			$p .= "Увеличить запас хода героя на <span style='color:green'><B>".$power."</span>";
		}
		else
		if($num==35)
		{
			$p .= "Перенести героя в родовую провинцию (или в соседнюю, если родовая осаждена)";
		}
		else
		if($num==36)
		{
			$p .= "Получить <B>";
			if($param1==1)
				$p .= "1</B> свиток";
			else
			if(($param1>1) && ($param1<5))
				$p .= $param1."</B> свитка";
			else
				$p .= $param1."</B> свитков";
			$p .= " ритуала <B>".$ritual_name[$power];
		}
		else
		if($num==37)
		{
			$p .= "Занято под внутренние потребности игры (index=37)";
		}
		else
		if($num==38)
		{
			$p .= "Занято под внутренние потребности игры; предположительно, для зачёта убитых существ для задания кристалла и квестов на убийство монстров (index=38)";
		}
		else
		if($num==99)
		{
			$p .= "Если провинция охраняется стражей, то при её разгроме героем запустится приключение ";
			$p .= "<B><a href=\"#".$g."e".$power."\">".$power." (".$enc_table[$power].")</B></a>";
		}
		else
			$p .= "<B>$i !!!ERROR!!! NUM=".$num;
		$p .= "</B></li>";
	}
	$p .= "</ul>\n";
	$enc_print[$i]=$p;
	$p="";
}

function scan_group($g_num,$begin)
{
	global $group_enc,$group_enc2,$enc_out,$group_enc_num;
//	echo "SCAN: NUM=$g_num BEGIN=$begin <br>";
	$group_enc_num[$begin] = 1;//флаг попадания приключения в какую-либо группу (для выявления "пропавших")
	if(!in_array($begin,$group_enc[$g_num]))
	{
		$group_enc[$g_num][] = $begin;//массив всех приключений в группе
		$group_enc2[$begin][] = $g_num;//в каких группах находится данное приключение
	}
	if($begin == 1038) $enc_out[$begin][] = 1039;//блин, не придумал, куда лучше вставить неиспользуемое "казино - игра на 1000" :(
	foreach($enc_out[$begin] as $val)
	{
//		echo "SCAN: NUM=$g_num BEGIN=$val <br>";
//		if(!in_array($val,$group_noscan))
		if(!in_array($val,$group_enc[$g_num]))
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
				$p .= "<span style='color:blue'>INNER_BUILD_".$val."_(".$build_name[$val].")</span> ";
		foreach($event_in_prov[$i] as $val)
*/
for($i=1;$i<$max_e+1;$i++)
{
//попытка найти "начальные" приключения в группе
	if(!in_array($i,$enc_not_begin) && (in_array($i,$enc_yes_begin) || $enc_in[$i]=="" || isset($enc_in_q[$i][0]) || isset($enc_in_ritual[$i][0]) || isset($enc_in_site[$i][0]) || isset($enc_in_prov[$i][0])))
	{
//		$enc_print[$i] .= "<br><span style='color:red'><B>(((Начало)))</B></span><br>";
		$group_count++;//число групп
		$group_begin[] = $i;//массив начальных номеров приключений
		scan_group($group_count,$i);
	}
}
//unset($group_event[143]);//убрать неиспользуемые приключения
//unset($group_event[213]);

//------------------------------------------------------------------------------
$G=1;//Флаг переключения: Группы (G==1)/нет
//------------------------------------------------------------------------------

if($G==1)
{
	echo "<h2 align=\"center\">Группы приключений<br></h2>";
	$s=explode(':',$enc_file[0]);
echo "Всего попаданий приключений в какую-либо группу: ".(count($group_enc_num)-729+1000)."<br>";
echo "Не попавшие: ";
for($i=1;$i<$s[1];$i++)
{
if(($i<729) || ($i>999))
if(!isset($group_enc_num[$i])) echo "$i ";
}
echo "<br>";
	echo "Encounter quantity: <B>".$s[1]."</B><br>";
	echo "Group quantity: <B>$group_count</B><br>";
	echo "<HR SIZE=3 COLOR=grey>";
	echo "<span style='color:green'><B>Оглавление:</B></span><br><HR>";
	for($i=1;$i<=$group_count;$i++)
	{
		echo "<a href=\"#".$i."e0\">№$i ( /$group_begin[$i] ".$enc_table[$group_begin[$i]].")</a><br>";
	}
	for($i=1;$i<=$group_count;$i++)
//for($i=1;$i<=2;$i++)
	{
		echo "<HR SIZE=5 COLOR=red>";
		echo "<a name=\"".$i."e0\"></a><h3 align=center>Группа <span style='color:red'>№$i</span> (".$enc_table[$group_begin[$i]].")</h3>";
//	echo "<a name=\"".$i."e0\"></a><h3 align=center><span style='color:#CC99FF'>Группа №$i (".$enc_table[$group_begin[$i]].")</span></h3>";
		foreach($group_enc[$i] as $val)
		{
			if($enc_unit_egg[$val])
			{
				foreach($enc_unit_egg[$val] as $u)//группа, где даются яйца
				{//$item_summon[
					if(!in_array($u,$group_unit_egg[$i]))
					{
						$group_unit_egg[$i][] = $u;
						$enc_unit_egg_file[$u][] = $i."|".$enc_table[$group_begin[$i]];
					}
				}
			}
			if($enc_unit_naim[$val])
			{
				foreach($enc_unit_naim[$val] as $u)//группа, где нанимаются юниты
				{
					if(!in_array($u,$group_unit_naim[$i]))
					{
						$group_unit_naim[$i][] = $u;
						$enc_unit_naim_file[$u][] = $i."|".$enc_table[$group_begin[$i]];
					}
				}
			}
			if($enc_unit_join[$val])
			{
				foreach($enc_unit_join[$val] as $u)//группа, где присоединяются юниты
				{
					if(!in_array($u,$group_unit_join[$i]))
					{
						$group_unit_join[$i][] = $u;
						$enc_unit_join_file[$u][] = $i."|".$enc_table[$group_begin[$i]];
					}
				}
			}
			if($enc_unit_egg_rand[$val])
			{
				foreach($enc_unit_egg_rand[$val] as $u)//группа, где даются потенциальные яйца
				{
						$s = $u.$i."|".$enc_table[$group_begin[$i]];
						if(!in_array($s,$enc_unit_egg_rand_file))
						{
							$enc_unit_egg_rand_file[] = $s;
						}
				}
			}
			if($enc_site[$val])
			{
				foreach($enc_site[$val] as $hide => $u)//группа, где потенциально может появиться новый сайт
				{
					$s = $u.$i."|".$enc_table[$group_begin[$i]]."|".$hide;
					if(!in_array($s,$enc_site_file))
						$enc_site_file[] = $s;
				}
			}
			if($enc_outer[$val])
			{
				foreach($enc_outer[$val] as $u)//группа, где потенциально можно возвести внешнюю постройку
				{
					$s = $u.$i."|".$enc_table[$group_begin[$i]];
					if(!in_array($s,$enc_outer_file))
						$enc_outer_file[] = $s;
				}
			}
			if($enc_outer_scroll[$val])
			{
				foreach($enc_outer_scroll[$val] as $cnt => $u)//группа, где можно получить чертежи постройки
				{
					$s = $u.$i."|".$enc_table[$group_begin[$i]]."|".$cnt;
					if(!in_array($s,$enc_outer_scroll_file))
						$enc_outer_scroll_file[] = $s;
				}
			}
			if($enc_spell_scroll[$val])
			{
				foreach($enc_spell_scroll[$val] as $cnt => $u)//группа, где можно получить свитки закла
				{
					$s = $u.$i."|".$enc_table[$group_begin[$i]]."|".$cnt;
					if(!in_array($s,$enc_spell_scroll_file))
						$enc_spell_scroll_file[] = $s;
				}
			}
			if($enc_ritual_scroll[$val])
			{
				foreach($enc_ritual_scroll[$val] as $cnt => $u)//группа, где можно получить свитки ритуала
				{
					$s = $u.$i."|".$enc_table[$group_begin[$i]]."|".$cnt;
					if(!in_array($s,$enc_ritual_scroll_file))
						$enc_ritual_scroll_file[] = $s;
				}
			}
			if($enc_def_scroll[$val])
			{
				foreach($enc_def_scroll[$val] as $cnt => $u)//группа, где можно получить договоры со стражей
				{
					$s = $u.$i."|".$enc_table[$group_begin[$i]]."|".$cnt;
					if(!in_array($s,$enc_def_scroll_file))
						$enc_def_scroll_file[] = $s;
				}
			}
			if($enc_item[$val])
			{
				foreach($enc_item[$val] as $u)//группа, где можно получить предмет
				{
					$s = $u.$i."|".$enc_table[$group_begin[$i]];
					if(!in_array($s,$enc_item_file))
						$enc_item_file[] = $s;
				}
			}
			if($enc_attacker[$val])
			{
				$s = $enc_attacker[$val]."|".$i."|".$enc_table[$group_begin[$i]];
				if(!in_array($s,$enc_attacker_file))
					$enc_attacker_file[] = $s;
			}
/*
			if(in_array($val,$ritual_enc))
			{
				$r = array_search($val,$ritual_enc);
				
			}
*/
			enc_prepare($val,$i);
			echo $enc_print[$val];
			$e_list[$val]++;//сколько раз данное событие встречается во всех группах
		}
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
/*
dumper($enc_unit_egg,"enc_unit_egg");
dumper($enc_unit_egg_file,"enc_unit_egg_file");
dumper($group_unit_egg,"group_unit_egg");
dumper($enc_unit_naim,"enc_unit_naim");
dumper($enc_unit_naim_file,"enc_unit_naim_file");
dumper($group_unit_naim,"group_unit_naim");
dumper($enc_unit_join,"enc_unit_join");
dumper($enc_unit_join_file,"enc_unit_join_file");
dumper($group_unit_join,"group_unit_join");
//dumper($group_enc2,"group_enc2[504] - (неупокоенный)");
dumper($ritual_enc_egg,"ritual_enc_egg");
dumper($ritual_enc_naim,"ritual_enc_naim");
dumper($ritual_enc_join,"ritual_enc_join");
dumper($site_enc_egg,"site_enc_egg");
dumper($site_enc_naim,"site_enc_naim");
dumper($site_enc_join,"site_enc_join");
//dumper($e_list,"e_list");
dumper($group_enc2[504]);
dumper($enc_unit_egg_rand_file);
dumper($enc_attacker_file,"enc_attacker_file");
*/

}
else//if($G!=1)
{
	echo "<h2 align=\"center\">Приключения<br></h2>";
	$s=explode(':',$enc_file[0]);
	echo "Encounter quantity: <B>".$s[1]."</B><br><br>";
	for($i=0;$i<$max_e+1;$i++)
	{
		enc_prepare($i);
		echo $enc_print[$i];
	}
	if(isset($link_check[0]))
	{
		echo "<HR><span style='color:red'><B>!!! Пустые (неиспользуемые) приключения, к которым нет обращений (или есть обращения из глубин кода):</B><br>";
		foreach($link_check as $val)
			echo "<a href=\"#e".$val."\">".$val." (".$enc_table[$val].")</a> ";
		echo "</span><br>";
	}
	if(isset($group_check[0]))
	{
		echo "<HR><span style='color:red'><B>!!! Приключения без группы:</B> ";
		foreach($group_check as $val)
			echo "<a href=\"#e".$val."\">".$val." (".$enc_table[$val].")</a> ";
		echo "</span><br>";
	}
}

//получение юнитов через события
if($G==1)
{

for($j=1;$j<=$max_ritual;$j++) //пройдёмся по ритуалам
{
	$enc = $ritual_enc[$j];
	if($enc!="")
	{
		foreach ($group_enc2[$enc] as $v)
		{
			if($group_unit_egg[$v]!="")
			{
				foreach ($group_unit_egg[$v] as $vv)
				{
					if(!in_array($j,$ritual_enc_egg[$vv]))
						$ritual_enc_egg[$vv][] = $j;//Получение предмета найма: ритуал
				}
				unset($group_unit_egg[$v]);//удаляем те группы приключений, которые пересекаются с ритуалом
			}
			if($group_unit_naim[$v]!="")
			{
				foreach ($group_unit_naim[$v] as $vv)
				{
					if(!in_array($j,$ritual_enc_naim[$vv]))
						$ritual_enc_naim[$vv][] = $j;//Найм: ритуал
				}
				unset($group_unit_naim[$v]);//удаляем те группы приключений, которые пересекаются с ритуалом
			}
			if($group_unit_join[$v]!="")
			{
				foreach ($group_unit_join[$v] as $vv)
				{
					if(!in_array($j,$ritual_enc_join[$vv]))
						$ritual_enc_join[$vv][] = $j;//Присоединение к отряду: ритуал
				}
				unset($group_unit_join[$v]);//удаляем те группы приключений, которые пересекаются с ритуалом
			}
		}
	}
}
for($j=1;$j<=$max_site;$j++) //пройдёмся по сайтам
{
	foreach($site_enc[$j] as $enc)
	{
		foreach ($group_enc2[$enc] as $v)
		{
			if($group_unit_egg[$v]!="")
			{
				foreach ($group_unit_egg[$v] as $vv)
				{
					if(!in_array($j,$site_enc_egg[$vv]))
						$site_enc_egg[$vv][] = $j;//Получение предмета найма: сайт
				}
				unset($group_unit_egg[$v]);//удаляем те группы приключений, которые пересекаются с сайтом
			}
			if($group_unit_naim[$v]!="")
			{
				foreach ($group_unit_naim[$v] as $vv)
				{
					if(!in_array($j,$site_enc_naim[$vv]))
						$site_enc_naim[$vv][] = $j;//Найм: сайт
				}
				unset($group_unit_naim[$v]);//удаляем те группы приключений, которые пересекаются с сайтом
			}
			if($group_unit_join[$v]!="")
			{
				foreach ($group_unit_join[$v] as $vv)
				{
					if(!in_array($j,$site_enc_join[$vv]))
						$site_enc_join[$vv][] = $j;//Присоединение к отряду: сайт
				}
				unset($group_unit_join[$v]);//удаляем те группы приключений, которые пересекаются с сайтом
			}
		}
	}
}
/*
dumper($enc_unit_egg,"enc_unit_egg");
dumper($enc_unit_egg_file,"enc_unit_egg_file");
dumper($group_unit_egg,"group_unit_egg");
dumper($enc_unit_naim,"enc_unit_naim");
dumper($enc_unit_naim_file,"enc_unit_naim_file");
dumper($group_unit_naim,"group_unit_naim");
dumper($enc_unit_join,"enc_unit_join");
dumper($enc_unit_join_file,"enc_unit_join_file");
dumper($group_unit_join,"group_unit_join");
//dumper($group_enc2,"group_enc2[504] - (неупокоенный)");
dumper($ritual_enc_egg,"ritual_enc_egg");
dumper($ritual_enc_naim,"ritual_enc_naim");
dumper($ritual_enc_join,"ritual_enc_join");
dumper($site_enc_egg,"site_enc_egg");
dumper($site_enc_naim,"site_enc_naim");
dumper($site_enc_join,"site_enc_join");
//dumper($e_list,"e_list");
*/

$f=fopen("enc_unit.exp","w") or die("Ошибка при создании файла enc_unit.exp");
fwrite($f,"#Format:\n#\$var_name\n#Unit|EncGroup|EncGroupName\n");
fwrite($f,"\$export_enc_egg\n");
foreach($group_unit_egg as $key => $val)
{
	if(!in_array($key,$no_export))
		foreach($val as $vv)
			fwrite($f,$vv."|".$key."|".$enc_table[$group_begin[$key]]."\n");
}
fwrite($f,"\$export_enc_naim\n");
foreach($group_unit_naim as $key => $val)
{
	if(!in_array($key,$no_export))
		foreach($val as $vv)
			fwrite($f,$vv."|".$key."|".$enc_table[$group_begin[$key]]."\n");
}
fwrite($f,"\$export_enc_join\n");
foreach($group_unit_join as $key => $val)
{
	if(!in_array($key,$no_export))
		foreach($val as $vv)
			fwrite($f,$vv."|".$key."|".$enc_table[$group_begin[$key]]."\n");
}
fclose($f);

$f=fopen("ritual_enc.exp","w") or die("Ошибка при создании файла ritual_enc.exp");
fwrite($f,"#Format:\n#\$var_name\n#Unit|ritual\n");
fwrite($f,"\$export_ritual_enc_egg\n");
foreach($ritual_enc_egg as $key => $val)
{
	foreach($val as $vv)
		fwrite($f,$key."|".$vv."\n");
}
fwrite($f,"\$export_ritual_enc_naim\n");
foreach($ritual_enc_naim as $key => $val)
{
	foreach($val as $vv)
		fwrite($f,$key."|".$vv."\n");
}
fwrite($f,"\$export_ritual_enc_join\n");
foreach($ritual_enc_join as $key => $val)
{
	foreach($val as $vv)
		fwrite($f,$key."|".$vv."\n");
}
fwrite($f,"#Format:\n#ritual|EncGroup|EncGroupName|scroll_num\n");
fwrite($f,"\$export_ritual_enc_scroll\n");
foreach($enc_ritual_scroll_file as $val)
{
	fwrite($f,$val."\n");
}
fclose($f);

$f=fopen("site_enc.exp","w") or die("Ошибка при создании файла site_enc.exp");
fwrite($f,"#Format:\n#\$var_name\n#Unit|site\n");
fwrite($f,"\$export_site_enc_egg\n");
foreach($site_enc_egg as $key => $val)
{
	foreach($val as $vv)
		fwrite($f,$key."|".$vv."\n");
}
fwrite($f,"\$export_site_enc_naim\n");
foreach($site_enc_naim as $key => $val)
{
	foreach($val as $vv)
		fwrite($f,$key."|".$vv."\n");
}
fwrite($f,"\$export_site_enc_join\n");
foreach($site_enc_join as $key => $val)
{
	foreach($val as $vv)
		fwrite($f,$key."|".$vv."\n");
}
fwrite($f,"#Format:\n#site|EncGroup|EncGroupName|hide_flag\n");
fwrite($f,"\$export_site_enc\n");
foreach($enc_site_file as $val)
{
	fwrite($f,$val."\n");
}
fclose($f);

$f=fopen("enc_unit_rand.exp","w") or die("Ошибка при создании файла enc_unit_rand.exp");
fwrite($f,"#Format:\n#ShopLevel|Rarity|EncGroup|EncGroupName\n");
//fwrite($f,"\$export_event_egg_rand\n");
foreach($enc_unit_egg_rand_file as $val)
{
	fwrite($f,$val."\n");
}
fclose($f);

$f=fopen("outer_enc.exp","w") or die("Ошибка при создании файла outer_enc.exp");
fwrite($f,"#Format:\n#outer_build|EncGroup|EncGroupName\n");
fwrite($f,"\$export_outer_enc\n");
foreach($enc_outer_file as $val)
{
	fwrite($f,$val."\n");
}
fwrite($f,"#Format:\n#outer_build|EncGroup|EncGroupName|scroll_num\n");
fwrite($f,"\$export_outer_enc_scroll\n");
foreach($enc_outer_scroll_file as $val)
{
	fwrite($f,$val."\n");
}
fclose($f);

$f=fopen("spell_enc.exp","w") or die("Ошибка при создании файла spell_enc.exp");
fwrite($f,"#Format:\n#spell|EncGroup|EncGroupName|scroll_num\n");
fwrite($f,"\$export_spell_enc_scroll\n");
foreach($enc_spell_scroll_file as $val)
{
	fwrite($f,$val."\n");
}
fclose($f);


$f=fopen("def_enc.exp","w") or die("Ошибка при создании файла def_enc.exp");
/*fwrite($f,"#Format:\n#defender|EventGroup|EventGroupName\n");
fwrite($f,"\$export_def_event\n");
foreach($event_def_file as $val)
{
	fwrite($f,$val."\n");
}*/
fwrite($f,"#Format:\n#defender|EncGroup|EncGroupName|scroll_num\n");
fwrite($f,"\$export_def_enc_scroll\n");
foreach($enc_def_scroll_file as $val)
{
	fwrite($f,$val."\n");
}
fclose($f);

$f=fopen("item_enc.exp","w") or die("Ошибка при создании файла item_enc.exp");
fwrite($f,"#Format:\n#item|EncGroup|EncGroupName\n");
fwrite($f,"\$export_item_enc\n");
foreach($enc_item_file as $val)
{
	fwrite($f,$val."\n");
}
fclose($f);

$f=fopen("guard_enc.exp","w") or die("Ошибка при создании файла guard_enc.exp");
fwrite($f,"#Format:\n#guard_type|EncGroup|EncGroupName\n");
fwrite($f,"\$export_guard_enc\n");
foreach($enc_attacker_file as $val)
{
	fwrite($f,$val."\n");
}
fclose($f);

}//if($G==1)

/*
//OLD
fwrite($f,"#Format: UnitEgg|EncGroup|EncGroupName\n");
foreach($enc_unit_egg_file as $key => $val)
{
	foreach($val as $vv)
		fwrite($f,$key."|".$vv."\n");
}
fclose($f);

$f=fopen("enc_unit_naim.exp","w") or die("Ошибка при создании файла enc_unit_naim.exp");
fwrite($f,"#Format: Unit|EncGroup|EncGroupName\n");
foreach($enc_unit_naim_file as $key => $val)
{
	foreach($val as $vv)
		fwrite($f,$key."|".$vv."\n");
}
fclose($f);

$f=fopen("enc_unit_join.exp","w") or die("Ошибка при создании файла enc_unit_join.exp");
fwrite($f,"#Format: Unit|EncGroup|EncGroupName\n");
foreach($enc_unit_join_file as $key => $val)
{
	foreach($val as $vv)
		fwrite($f,$key."|".$vv."\n");
}
fclose($f);
*/
//dumper($treasure_item_cnt);

?>
</body></html>
