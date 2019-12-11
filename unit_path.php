<html>
<meta http-equiv="Content-Type" content="text/html charset=windows-1251">
<style>
br		{mso-data-placement:same-cell;}
td		{vertical-align:middle;}
.top	{border-top:1.0pt solid black;}
.bottom	{border-bottom:1.0pt solid black;}
.left	{border-left:1.0pt solid black;}
.right	{border-right:1.0pt solid black;}
.font9	{font-size:9.0pt;}
</style>
<?php
error_reporting(E_WARNING);
//error_reporting(E_PARSE);
//error_reporting(E_NOTICE);
require_once "dumper.php";
$a_file = file("unit.var");
$u_file = file("unit.var");
$abil_file = file("ability_num.var");
$up_file = file("unit_upg2.var");
$b_file = file("inner_build.var");
$item_file = file("item.var");
//$event_file = file("event.var");
//$enc_file = file("encounter.var");
$site_file = file("site.var");
$ritual_file = file("ritual.var");
$spell_file = file("spell.var");
$merc_file = file("mercenary.var");
$def_file = file("defender.var");
$guard_file = file("guard.var");
$g_file = file("guard_type.var");
$shard_file = file("shard_bonus.var");
$subtype_file = file("unit_subtype.var");
$count_subtype = count($subtype_file);
$count_shard = count($shard_file);
$count_g = count($g_file);
$count_guard = count($guard_file);
$count_def = count($def_file);
$count_merc = count($merc_file);
$count_spell = count($spell_file);
$count_ritual = count($ritual_file);
$count_site = count($site_file);
$count_enc = count($enc_file);
$count_event = count($event_file);
$count_item = count($item_file);
$count_b = count($b_file);
$count_up = count($up_file);
$count_abil = count($abil_file);
$count_f = count($a_file);
$count_u = count($u_file);
$unit_file = file("unit.txt");
$count_unit = count($unit_file);
$enc_unit_file = file("enc_unit.exp");
$event_unit_file = file("event_unit.exp");
$ritual_enc_file = file("ritual_enc.exp");
$ritual_event_file = file("ritual_event.exp");
$site_enc_file = file("site_enc.exp");
$event_unit_rand_file = file("event_unit_rand.exp");
$enc_unit_rand_file = file("enc_unit_rand.exp");
//$effects_file = file("effects.var");
//$effects_txt_file = file("Effects.txt");

$res_name=array(1=>"Железо", "Красное дерево", "Кони", "Мандрагора", "Арканит", "Мрамор", "Мифрил", "Дионий", "Чёрный лотос");
//$unit_type=array(1=>"Смертный","Нежить","Демон","Механический","Герой");
$unit_class=array(1=>"Пехота","Стрелок","Кавалерия","Заклинатель","Орудие","Гигант","Летающий");
//$unit_race=array(1=>"Люди","Эльфы","Гномы","Гоблины","Орки","Половинчики","Кентавры","Людоящеры","Тёмные эльфы","Гноллы");
$unit_bold1=array(19,23,24,26,27,28,29,137,139,140,157,158,160,162,163,192,198,199,213,226,228,256,257,274,277,278,279,282,289,291,293,299,300,301,303,304,324,356,358,359,360,364,373,375,386,387,410,413,414,420,423,474,475,476,491,493,513,515,521,523,538,579,581,598,601,602,603,605,606,607,609,673,748);
$unit_bold2=array_merge(range(44,114),range(127,134),range(145,152),range(166,184),range(344,352),range(425,432),range(440,469),range(485,488),range(500,509),range(526,529),range(533,536),range(544,552),range(569,576),range(587,596),range(621,661),range(678,733));
$unit_bold=array_merge($unit_bold1,$unit_bold2);//апгрейды, выделяемые жирным
$unit_bold_not_magic=array(313,317,327,328,391,438,519);//апгрейды, к-е ошибочно определяются как магические
$unit_aqua=array(61,124,135,156,161,164,165,226,227,228,287,288,292,302,305,309,313,317,321,327,328,339,342,343,361,363,367,368,391,411,412,421,424,430,438,439,484,489,492,516,519,520,522,524,525,530,531,537,539,540,541,556,557,558,577,604,608,610,619,620,635,662,668,670,672,674,675,677,689,690,697,715,716,724,729,730);
//$unit_brown=array(440,442,444,448);//всякие превращения одних существ в другие
$def_not=array(0,30,31,32,34,35,36,37,38,42,43,44,45,66,67,68,77,78,89,105);//стражи-заглушки
//$abil_not=array_merge(range(122,134),array(180));//составные абилки с дублирующимися названиями
$abil_not=array_merge(range(176,182));//составные абилки с дублирующимися названиями

//для need-абилок, отменяющих предыдущую абилку (в основном описательные/скрытые абилки)
$abil_need=array_merge(range(320,345),range(360,362),array(2272));
//$abil_need=array_merge(range(320,328),range(335,339),array(2272));

//$unit_abil_spell = array(139,189,206,207,216,217,218); //массив абилок, позволяющих юнитам пользоваться магией
$unit_abil_spell = array_merge(array(115),range(129,133),array(189),array(220),array(255)); //массив абилок, позволяющих юнитам пользоваться магией

//абилки с выбором пути развития юнита посредством кнопки
$abil_path_array = array_merge(range(288,289),range(309,310),range(357,359),range(363,374));
//перечисление апов, сидящих на кнопках с выбором пути развития
$up_path_array = "";

$hero_up = array_merge(range(40,43),range(238,253),range(263,278));//апы героя

//разбивка по листам
$unit_tab[1]=array(1,209,2,119,3,86,4,80,5,81,6,120,7,84,8,121,9,85,10,112,11,128,12,87,22,137,192,23,146,24,90,25,89,26,138,27,145,28,152,29,211,144,190,30,88,44,93,45,149,46,147,47,135,48,148,49,136,57,236,58,235,59,237);//Замковые
$unit_tab[2]=array(139,140,141,142,143,197,198,199,200,201,219,158,72,78,133,134,40,41,42,43,238,239,240,241,242,243,244,245,246,247,248,249,250,251,252,253,263,264,265,266,267,268,269,270,271,272,273,274,275,276,277,278);//Люди
$unit_tab[3]=array(17,83,31,32,33,35,39,68,82,151,210,166,167,168,101,102,50,51,52,53,54,67,71,150,217,60,61,62,63,66,70,76,220,157,161,162,164,165,79,218,159,163,118,153,154,155,196,224);//Нейтралы
$unit_tab[4]=array(19,91,170,20,92,36,171,193,207,55,172,194,74,173,64,75,208,216,174,189);//Нежить
$unit_tab[5]=array(21,205,99,37,191,38,94,95,56,257,97,65,98,160,254);//Демоны
$unit_tab[6]=array(15,126,105,106,107,127,108);//Эльфы
$unit_tab[7]=array(16,255,156,256,103,184,104,258);//Гномы
$unit_tab[8]=array(13,77,129,96,130,131,169,227,228);//Гоблины
$unit_tab[9]=array(14,100,109,73,110,195,111,229,230,231,234);//Орки
$unit_tab[10]=array(18,259,260,262,132,261);//Половинчики
$unit_tab[11]=array(122,34,123,124,125);//Кентавры
$unit_tab[12]=array(69,113,114,115,116,117);//Людоящеры
//$unit_tab[13]=array(187,188,175,179,176,180,183,177,181,184,178,182,185,186);
$unit_tab[13]=array(187,188,175,176,179,180,183,177,181,182,178,185,186);//Альвары
$unit_tab[14]=array(202,203,204,206);//Гноллы
$unit_tab[15]=array(212,213,214,215,279,280,281,282);//Алкари
$unit_tab[16]=array(221,222,226,223,225,232,233);//Крысолюди

$s=explode(':',$u_file[0]); echo "Всего юнитов: ".$s[1]."<br>";
for($i=1;$i<=16;$i++)
{
	$c+=count($unit_tab[$i]);
	array_push($unit_tab_array,$unit_tab[$i]);
}
echo "Всего, судя по разбивке на листы: ".$c."<br>";
if($c==($s[1]+1-1)) echo "<B><font color=\"lime\">Совпало :)"; else echo "<B><font color=\"red\"> Не совпало :(";
echo "</B></font><br>";
sort($unit_tab_array);
$c = 0;
foreach($unit_tab_array as $k)
{
	$c++;
	if($c != $k)
	{
		echo $c."<br>";
		$c++;
	}
}
dumper($unit_tab_array);
$p=""; //для печати без последней ";"

$max=0;$max1=0;$max_u=0;$max_e=0;$t[0]=0;$j=0;
$u1=-1;$u2=0;$u3=0;	//№ строки юнита в xls
$g1=0; //кол-во стражей в одном сайте
$a1=0; //№ абилки
$a2=0; //№ эффекта ritual
$e1=0; //№ эффекта
$up1=0; //число upg_type в unit_upg
$u_a=0; //абилки in unit.var
$var = "\$temp";//начальное имя переменной, взятой из файла

//$unit_event_naim[][]="";//массив событий, где можно получить юнитов

$BUILD_MAX = 4;//кол-во сортировок групп получения юнитов:
//$build_unit[unit][-1][]-Upgrade, Возрождение, [Кампания] - Бонус осколка
//$build_unit[unit][0][]-Присоединение к отряду,Получение предмета найма, Добавление в гарнизон, лут
//$build_unit[unit][1][]-Найм,Продажа предмета найма
//$build_unit[unit][2][]-Разрешение найма
//$build_unit[unit][3][]-Бой
//$build_unit[unit][4][]-(не суются в основные способы получения) - Рандомы: награда с сайта, event/enc, магазин в замке 

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
		if(in_array(substr(trim($s[1]),0,-1),$abil_name))
			echo "<B><font color=\"red\">!!! num=".$n."-ABIL_NUM =".$s1[1]."-- (".substr(trim($s[1]),0,-1).") ИМЯ УЖЕ ЕСТЬ</font></B><br>";
		$abil_name[$s1[1]+1-1]=substr(trim($s[1]),0,-1);
		$abil_numeric[$s1[1]+1-1]=$s2[1]+1-1;
		$abil_effect[$s1[1]+1-1]=$s3[1]+1-1;
		$abil_percent[$s1[1]+1-1]=$s4[1]+1-1;
    }
}

//$up_abil[909] = "Сила призыва нежити; ";
$abil_numeric[227]=1;
$abil_name[268] = "Переваривание";
$abil_numeric[268]=1;
//$abil_name[311] = "Колдун с ещё не определившимися ветками развития";
$abil_name[320] = "Всеобщая жажда крови (1)";
$abil_numeric[320]=0;
$abil_name[321] = "Всеобщая жажда крови (2)";
$abil_numeric[321]=0;
$abil_name[322] = "Всеобщая жажда крови (3)";
$abil_numeric[322]=0;
$abil_name[323] = "Всеобщее обжигание (1)";
$abil_numeric[323]=0;
$abil_name[324] = "Всеобщее обжигание (2)";
$abil_numeric[324]=0;
$abil_name[325] = "Всеобщее обжигание (3)";
$abil_numeric[325]=0;
$abil_name[326] = "Всеобщий вампиризм (1)";
$abil_numeric[326]=0;
$abil_name[327] = "Всеобщий вампиризм (2)";
$abil_numeric[327]=0;
$abil_name[328] = "Всеобщий вампиризм (3)";
$abil_numeric[328]=0;
$abil_name[335] = "Всеобщая жажда крови (4)";
$abil_numeric[335]=0;
$abil_name[336] = "Живительная сила (1)";
$abil_numeric[336]=0;
$abil_name[337] = "Живительная сила (2)";
$abil_numeric[337]=0;
$abil_name[338] = "Живительная сила (3)";
$abil_numeric[338]=0;
$abil_name[339] = "Живительная сила (4)";
$abil_numeric[339]=0;
$abil_name[329] = "Превращение во Владыку Бездны";
$abil_name[330] = "Метка Мстителя";
$abil_name[331] = "Метка дьявола";
$abil_name[332] = "Превращение в беса";
$abil_name[333] = "Превращение в чёрта";
$abil_name[334] = "Превращение в демона";
$abil_name[357] = "Меняющий Облик";
$abil_name[372] = "Путь Охотника (1)";
$abil_name[373] = "Путь Охотника (2)";
//$abil_numeric[311]=0;

//Предварительный разбор item.var
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
		$s = $s2 = substr(trim($s[1]),0,-1);
		while(in_array($s,$item_name))
		{
			echo $n."- Дубль ITEM=".$s;
			$s .= "<font color=\"fuchsia\">*</font>";
			$s2 .= "*";
			echo " <B>Замена на</B> ".$s."<br>";
		}
		$item_name[$n]=$s;
		$item_name2[$n]=$s2;//для спойлеров
    }
    else
    if(eregi("^Building:",$item_file[$i]))
    {
		$s=explode(':',$item_file[$i]);
		if(($s[1]+1-1)!=0)
			$item_build[$s[1]+1-1][]=$n;
//		echo $n." BUILD=".$s[1]." ITEM_BUILD[".$s[1]."]=";
//		print_r($item_build[$s[1]+1-1]);
//		echo "<br>";
    }
    else
    if(eregi("^ShopLevel:",$item_file[$i]))
    {
		$s=explode(':',$item_file[$i]);
		$item_level[$n]=$s[1]+1-1;
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
		$s1=explode(':',$item_file[$i]);
		if(($s[1]+1-1) == 84) //summon
		{
			$item_summon[$n]=$s1[1]+1-1;
		}
	}
}

//разбор site_enc.exp
for($i = 0; $i < count($site_enc_file); $i++)
{
//echo "I=$i site_ENC_BEGIN: ".$site_enc_file[$i]."<br>";
	$str = trim($site_enc_file[$i]);
	if(!eregi("^#",$str))//не комментарий
	{
		if(eregi("^\\\$",$str))//переменная
		{
			$var = $str;//текущее имя переменной берём из файла
		}
		else
		{
			$s = explode("|",$str);
//			$$var = array (array($s[0],$s[1]));//$export_site_enc_egg[19][] = 6;
//			echo($var."[$s[0]][] = $s[1];");
			eval($var."[$s[0]][] = $s[1];");//$export_site_enc_egg[19][] = 6;
		}
	}
}

//разбор ritual_enc.exp
for($i = 0; $i < count($ritual_enc_file); $i++)
{
	$str = trim($ritual_enc_file[$i]);
	if(!eregi("^#",$str))//не комментарий
	{
		if(eregi("^\\\$",$str))//переменная
		{
			$var = $str;//текущее имя переменной берём из файла
		}
		else
		{
			$s = explode("|",$str);
			eval($var."[$s[0]][] = $s[1];");//$export_ritual_enc_egg[19][] = 6;
		}
	}
}

//разбор ritual_event.exp
for($i = 0; $i < count($ritual_event_file); $i++)
{
	$str = trim($ritual_event_file[$i]);
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
		}
	}
}

//разбор enc_unit.exp
for($i = 0; $i < count($enc_unit_file); $i++)
{
	$str = trim($enc_unit_file[$i]);
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
			$EncGroupName[$s[1]] = $s[2];//имя группы приключений для получения юнита
		}
	}
}

//разбор event_unit.exp
for($i = 0; $i < count($event_unit_file); $i++)
{
	$str = trim($event_unit_file[$i]);
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
			$EventGroupName[$s[1]] = $s[2];//имя группы событий для получения юнита
		}
	}
}

//разбор event_unit_rand.exp
for($i = 0; $i < count($event_unit_rand_file); $i++)
{
	$str = trim($event_unit_rand_file[$i]);
	if(!eregi("^#",$str))//не комментарий
	{
		$s = explode("|",$str);
		$EventUnitRand[$s[0]][$s[1]][] = $s[2];//[ShopLevel][Rarity] возможных рандомных яиц = группе событий
		$EventGroupName[$s[2]] = $s[3];//имя группы событий для получения юнита
	}
}

//разбор event_unit_rand.exp
for($i = 0; $i < count($enc_unit_rand_file); $i++)
{
	$str = trim($enc_unit_rand_file[$i]);
	if(!eregi("^#",$str))//не комментарий
	{
		$s = explode("|",$str);
		$EncUnitRand[$s[0]][$s[1]][] = $s[2];//[ShopLevel][Rarity] возможных рандомных яиц = группе приключений
		$EncGroupName[$s[2]] = $s[3];//имя группы приключений для получения юнита
	}
}

//dumper($EventUnitRand,"EventUnitRand");
//dumper($EncUnitRand,"EncUnitRand");

/*
dumper($temp,"temp");
dumper($export_site_enc_egg,"export_site_enc_egg");
dumper($export_site_enc_naim,"export_site_enc_naim");
dumper($export_site_enc_join,"export_site_enc_join");
dumper($export_ritual_enc_egg,"export_ritual_enc_egg");
dumper($export_ritual_enc_naim,"export_ritual_enc_naim");
dumper($export_ritual_enc_join,"export_ritual_enc_join");
dumper($export_ritual_event_egg,"export_ritual_event_egg");
dumper($export_ritual_event_garn,"export_ritual_event_garn");
dumper($export_enc_egg,"export_enc_egg");
dumper($export_enc_naim,"export_enc_naim");
dumper($export_enc_join,"export_enc_join");
dumper($EncGroupName,"EncGroupName");
dumper($export_event_egg,"export_event_egg");
dumper($export_event_garn,"export_event_garn");
dumper($EventGroupName,"EventGroupName");
*/
//разбор unit.txt
for($i = 0; $i < $count_unit; $i++)
{  
    if(eregi("^([0-9]{1,})",$unit_file[$i],$k))
    {
		$n=$k[1];
    }
/*    else
    if(eregi("^[-]{3,}",$unit_file[$i],$k))
    {
		continue;
    }
*/    else
	{
		if(substr($unit_file[$i],0,1)=="#")
		{
			$unit_txt[$n] .= ((substr(trim($unit_file[$i]),-1,1)=="#") ? substr(trim($unit_file[$i]),1,-1) : substr($unit_file[$i],1)."<br>");
			$unit_txt_idx[$n] = $i;//в какую строку добавлять спойлеры о карме/коррупции
			$unit_txt_idx2[$i] = $n;//этой строке соответствуют номер юнита
		}
		else
		if(trim($unit_file[$i])!="")
		{
			if(substr(trim($unit_file[$i]),-1,1)=="#")
			{
				$unit_txt[$n] .= substr(trim($unit_file[$i]),0,-1);
				$i++;
			}
			else
				$unit_txt[$n] .= $unit_file[$i]."<br>";
		}
	}

}

//Разбор mercenary.var
for($j=0;$j<5;$j++)
	{
		$s=explode(':',$merc_file[$j]);	// Lvl1: 13, 14; 128, 9;...
//echo $n." ".$j." s=".$s[1];
		$s1=explode(';',$s[1]);		// 13, 14; 128, 9;...
//echo " s1=".$s1[0]." ".$s1[1]." ".$s1[2]." ".$s1[3]." ".$s1[4]." ".$s1[5]." ".$s1[6]." ".$s1[7]."<br>";
		for($jj=0;$jj<count($s1);$jj++)
		{
			$s2=explode(',',$s1[$jj]);	// (13, 14
			if(trim($s2[0])!="")
				if($merc_flag[$s2[0]+1-1]!=1)
				{
					$merc_table[$j][]=$s2[0]+1-1;
					$merc_table2[$j][$s2[0]+1-1]=$s2[1]+1-1;
					$merc_flag[$s2[0]+1-1]=1;
					$merc_table_all[]=$s2[0]+1-1;
				}
			
//echo "MERC=$j U=".$s2[0]."<br>";
		}
    }

//Разбор defender.var
for($i = 0; $i < $count_def; $i++)
{
	if(eregi("^/([0-9]{1,})",$def_file[$i],$k))
	{
		$n=$k[1];
    }
    else
    if(eregi("^Name",$def_file[$i]))
    {
		$s=explode(':',$def_file[$i]);
 		$s = $s2 = substr(trim($s[1]),0,-1);
		while(in_array($s,$def_name))
		{
			echo $n."- Дубль DEFENDER=".$s;
			$s = $s."<font color=\"fuchsia\">*</font>";
			$s2 .= "*";
			echo " <B>Замена на</B> ".$s."<br>";
		}
		$def_name[$n]=$s;
		$def_name2[$n]=$s2;//для спойлеров
   }
	else
    if((eregi("^Unit",$def_file[$i])) && (!eregi("^Units",$def_file[$i])))
    {
		$s=explode(':',$def_file[$i]);
		$s1=explode(',',$s[1]);
		if(!in_array($n,$def_not))
			if(!in_array($n,$def_unit[$s1[0]+1-1]))
				$def_unit[$s1[0]+1-1][]=$n;
//		if($n!=0)$def_unit[$s1[0]+1-1][]=$n;
	}
}

//Разбор guard.var
for($i = 0,$n=0; $i < $count_guard; $i++)
{
	if(eregi("^/([0-9]{1,})",$guard_file[$i],$k))
	{
		$n=$k[1];
    }
    else
    if(eregi("^Unit",$guard_file[$i]))
    {
		$s=explode(':',$guard_file[$i]);
		$s1=explode(',',$s[1]);
		if($n!=0)$guard_unit[$n][]=$s1[0]+1-1;
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
 		$s = $s2 = substr(trim($s[1]),0,-1);
		while(in_array($s,$g_name))
		{
			echo $n."- Дубль guard_type=".$s;
			$s = $s."<font color=\"fuchsia\">*</font>";
			$s2 .= "*";
			echo " <B>Замена на</B> ".$s."<br>";
		}
		$g_name[$n]=$s; //$g_name[] - guard_type
		$g_name2[$n]=$s2;//для спойлеров
	}
	else
	if(eregi("^Guard",$g_file[$i]))
	{
		$s=explode(':',$g_file[$i]);
		foreach($guard_unit[$s[1]+1-1] as $g)
		{
			if((!in_array($n,$unit_guard[$g])) && $n!=0)
				$unit_guard[$g][]=$n;
//echo "G_TYPE=$n G_UNIT=$g<br>";
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
		{
			$site_name[$n]="Гильдия воров <font color=\"fuchsia\">(в законе)</font>";
			$site_name2[$n]="Гильдия воров (в законе)";
		}
		else
		if($n==53)
		{
			$site_name[$n]="Команда авантюристов";
			$site_name2[$n]="Команда авантюристов";
		}
		else
		if($n==56)
		{
			$site_name[$n]="Тролли";
			$site_name2[$n]="Тролли";
		}
		else
		if($n==57)
		{
			$site_name[$n]="Хутор половинчиков <font color=\"fuchsia\">(+3)</font>";
			$site_name2[$n]="Хутор половинчиков (+3)";
		}
		else
		if($n==58)
		{
			$site_name[$n]="Хутор половинчиков <font color=\"fuchsia\">(+1)</font>";
			$site_name2[$n]="Хутор половинчиков (+1)";
		}
		else
		if($n==60)
		{
			$site_name[$n]="Торговец редкостями";
			$site_name2[$n]="Торговец редкостями";
		}
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
			$s = $s2 = substr(trim($s[1]),0,-1);
			while(in_array($s,$site_name))
			{
				echo $n."- Дубль SITE=".$s;
				$s = $s."<font color=\"fuchsia\">*</font>";
				$s2 .= "*";
				echo " <B>Замена на</B> ".$s."<br>";
			}
			$site_name[$n]=$s;
			$site_name2[$n]=$s2;//для спойлеров
		}
	}
	else
	if(eregi("^Encounter",$site_file[$i]))
	{
		$s=explode(':',$site_file[$i]);
		$site_enc[$n]=$s[1]+1-1;
	}
	else
	if(eregi("^Ability",$site_file[$i])) //Ability в site.var или defender.var
	{
		if(trim($site_file[$i])!="Ability:")
		{
			$s=explode(':',$site_file[$i]);
			if(($s[1]+1-1) == 22)//Магазин бродячего торговца
				$site_torg[] = $n;
			$i++;
		}
	}
}

//Разбор spell.var
for($i = 0,$n=0; $i < $count_spell; $i++)
{  
	if(eregi("^/([0-9]{1,})",$spell_file[$i],$k))
	{
		$n=$k[1];
		if($n>$max_spell)$max_spell=$n;
	}
	else
	if(eregi("^name",$spell_file[$i]))
	{
		$s=explode(':',$spell_file[$i]);
		$s = $s2 = substr(trim($s[1]),0,-1);
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
			$s2 .= "*";
			echo " <B>Замена на</B> ".$s."<br>";
		}
		$spell_name[$n]=$s;
		$spell_name2[$n]=$s2;//для спойлеров
//		$spell_name[$n]=substr(trim($s[1]),0,-1);
	}
	else
	if(eregi("^Target:",$spell_file[$i]))
	{
		$s=explode(':',$spell_file[$i]);
		$target_table[$n]=$s[1]+1-1;
	}
	else
	if(eregi("^Power:",$spell_file[$i]))//разбор effects: item.var,spell.var
	{
		$s=explode(':',$spell_file[$i-1]);
		$spell_effects[$n][$e1]['num']=$s[1]+1-1;	//массив № эффектов
		$s=explode(':',$spell_file[$i]);
		$spell_effects[$n][$e1]['power']=$s[1]+1-1;	//массив power, FlagEffect
		$s=explode(':',$spell_file[$i+1]);
		$spell_effects[$n][$e1]['area']=$s[1]+1-1;	//массив area, Duration, FlagEffect
//echo $n."-e1=".$e1." NUM=".$effects[$n][$e1]['num']." POWER=".$effects[$n][$e1]['power']." AREA=".$effects[$n][$e1]['area']."<br>";
		$e1++;
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
    if(eregi("^Event",$ritual_file[$i]))
    {
		$s=explode(':',$ritual_file[$i]);
		if(($s[1]+1-1)!=0)
			$ritual_event[$n][]=$s[1]+1-1;
    }
    else
    if(eregi("^Effect:",$ritual_file[$i])) //effect  в ritual.var
    {
		$s=explode(':',$ritual_file[$i]);
		$num=$s[1]+1-1;	//массив № абилок
		$i++;
		$s=explode(':',$ritual_file[$i]);
		$param1=$s[1]+1-1;	//массив param1 абилок
		if($num==3)
		{
			$ritual_event[$n][]=$param1;
		}
		else
		if($num==5)
		{
			$ritual_enc[$n]=$param1;
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

//Разбор unit_subtype.var
for($i = 0,$n=0; $i < $count_subtype; $i++)
{  
   if(eregi("^/([0-9]{1,})",$subtype_file[$i],$k))
    {
		$n=$k[1];
    }
    else
    if(eregi("^name",$subtype_file[$i]))
    {
		$s=explode(':',$subtype_file[$i]);
		$unit_subtype[$n]=substr(trim($s[1]),0,-1);
    }
}

//Разбор inner_build.var
for($i = 0,$n=0; $i < $count_b; $i++)
{  
   if(eregi("^/([0-9]{1,})",$b_file[$i],$k))
    {
		$n=$k[1];
		if($n>$max1)$max1=$n;
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
//echo $n."-".$a_file[$i]."<br>";
		if(trim($b_file[$i])!="Ability:")
		{
			$s=explode(':',$b_file[$i]);//№ абилки
			$i++;
			$s1=explode(':',$b_file[$i]);//param1
			$i++;
			$s2=explode(':',$b_file[$i]);//param2
			$i++;
			if(($s[1]+1-1) == 1)//магазин яиц
			{
				$build_egg[$n]=1;
				if(($s1[1]+1-1) == 2) //Магазин: param1 = 2 - ограниченное число случайных предметов уровня Param2 
					$build_rand_item[$n] = $s2[1]+1-1;
			}
			else
			if(($s[1]+1-1) == 6) //Доступ к наёмникам 
				$build_merc[]=$build_name[$n];
			else
			if(($s[1]+1-1) == 8 || ($s[1]+1-1) == 59) //найм юнитов
			{
				$build_unit[$s1[1]+1-1][1][] = "<B><font color=\"red\">Найм:</font></B> здание <B><font color=\"green\">".$build_name[$n]."</font></B>;<br>";
				$build_unit2[$s1[1]+1-1][1][] = "Найм: здание $build_name[$n]; ";
			}
			else
			if(($s[1]+1-1) == 31) //позволяет нанимать из яиц
			{
				$q=$item_summon[$s1[1]+1-1];
				$build_unit[$q][2][] = "<B><font color=\"red\">Разрешение найма:</font></B> здание <B><font color=\"green\">".$build_name[$n]."</font></B> (из предмета <B><font color=\"brown\">".$item_name[$s1[1]+1-1]."</font></B>);<br>";
				$build_unit2[$q][2][] = "Разрешение найма: здание $build_name[$n] (из предмета ".$item_name2[$s1[1]+1-1]."); ";
			}
//echo $n." UNIT=".($s1[1]+1-1)."(".$build_unit[$s1[1]+1-1].") EGG=".$build_egg[$n]."<br>";
		}
    }
}
//dumper($build_rand_item,"build_rand_item");

//Разбор item.var для вывода рандомных яиц
for($i = 0,$n=0; $i < $count_item; $i++)
{  
   if(eregi("^/([0-9]{1,})",$item_file[$i],$k))
    {
		$n=$k[1];
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
			if($item_rarity[$n]<=6)
			{
				$build_unit[$item_summon[$n]][4][] .= "<B><font color=\"red\">Рандом:</font> <font color=\"fuchsia\">[Награда с сайта]
				</font></B> - предмет <B><font color=\"brown\">".$item_name[$n]."</font></B>;<br>";
				$build_unit2[$item_summon[$n]][4][] .= "Рандом: [Награда с сайта] - предмет $item_name[$n]; ";
				foreach($site_torg as $torg)//Магазин бродячего торговца
				{
					$build_unit[$item_summon[$n]][4][] .= "<B><font color=\"red\">Рандом:</font></B> сайт <B><font color=\"fuchsia\">".$site_name[$torg]."</font></B>
					- предмет <B><font color=\"brown\">".$item_name[$n]."</font></B>;<br>";
					$build_unit2[$item_summon[$n]][4][] .= "Рандом: сайт $site_name[$torg] - предмет $item_name[$n]; ";
				}
				foreach($build_rand_item as $inner => $level)//магазины случайных артов в замке
				{
					if($level == $item_level[$n])
					{
						$build_unit[$item_summon[$n]][4][] .= "<B><font color=\"red\">Рандом:</font></B> здание <B><font color=\"green\">".$build_name[$inner]."</font></B>
						- предмет <B><font color=\"brown\">".$item_name[$n]."</font></B>;<br>";
						$build_unit2[$item_summon[$n]][4][] .= "Рандом: здание $build_name[$inner] - предмет $item_name[$n]; ";
					}
				}
				foreach($EventUnitRand[$item_level[$n]] as $rarity => $groups)
				{
					if($item_rarity[$n] >= $rarity)//Получить случайный предмет уровня Power, c редкостью не ниже Param1
					{
						foreach($groups as $g)
						{
							if(!in_array($g,$event_rand_flag[$n]))//для исключения одинаковых событий
							{
								$event_rand_flag[$n][] = $g;
								$build_unit[$item_summon[$n]][4][] .= "<B><font color=\"red\">Рандом:</font></B> группа событий <B><font color=\"teal\">
								№".$g." (".$EventGroupName[$g].")</font></B> - предмет <B><font color=\"brown\">".$item_name[$n]."</font></B>;<br>";
								$build_unit2[$item_summon[$n]][4][] .= "Рандом: группа событий ".$g." (".$EventGroupName[$g].") - предмет $item_name[$n]; ";
							}
						}
					}
				}
				foreach($EncUnitRand[$item_level[$n]] as $rarity => $groups)
				{
					if($item_rarity[$n] >= $rarity)//Получить случайный предмет уровня Power, c редкостью не ниже Param1
					{
						foreach($groups as $g)
						{
							if(!in_array($g,$enc_rand_flag[$n]))//для исключения одинаковых приключений
							{
								$enc_rand_flag[$n][] = $g;
								$build_unit[$item_summon[$n]][4][] .= "<B><font color=\"red\">Рандом:</font></B> группа приключений <B><font color=\"teal\">
								№".$g." (".$EncGroupName[$g].")</font></B> - предмет <B><font color=\"brown\">".$item_name[$n]."</font></B>;<br>";
								$build_unit2[$item_summon[$n]][4][] .= "Рандом: группа приключений ".$g." (".$EncGroupName[$g].") - предмет $item_name[$n]; ";
							}
						}
					}
				}
			}
//			$item_summon2[$s1[1]+1-1] = $n;
		}
//echo $n."-e1=".$e1." NUM=".$effects[$n][$e1]['num']." POWER=".$effects[$n][$e1]['power']." AREA=".$effects[$n][$e1]['area']."<br>";
    }
}

//предварительный разбор unit.var для unit_upg.var
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
		$s = $s2 = trim(substr(trim($s[1]),0,-1));
		if(in_array($n,$hero_up))//апы героя
		{
			$u_name[$n]=$s."<font color=\"fuchsia\">@</font>";
			$u_name2[$n]=$s."@";
		}
		else
		{
			while(in_array($s,$u_name))
			{
				echo $n."- Дубль UNIT=".$s;
				$s = $s."<font color=\"fuchsia\">*</font>";
				$s2 .= "*";
				echo " <B>Замена на</B> ".$s."<br>";
			}
			$u_name[$n]=$s;
			$u_name2[$n]=$s2;//для спойлеров
		}
    }
	else
	if(eregi("^Upgraded:",$u_file[$i]))
	{
		$s=explode(':',$u_file[$i]);//Upgraded: (122,30)
		$s1=substr(trim($s[1]),1,-1);//122,30
		$s2=explode(',',$s1);
		$up1=$s2[0]+1-1;
		$up2=$s2[1]+1-1;
		if($up1 < 0)//выбор пути развития через кнопку
		{
			$up_path[$n][0] = $up_path_array[] = -$up1;
			$up_path[$n][1] = $up_path_array[] = -$up2;
			$up_path_unit[-$up2] = $up_path_unit[-$up1] = $n;//юнит, ассоциированный с "развивающей" абилкой
		}
	}
}

//Предварительный разбор unit_upg.var для need-абилок, отменяющих предыдущую абилку
for($i = 0,$n=0; $i < $count_up; $i++)
{
	if(eregi("^/([0-9]{1,})",$up_file[$i],$k))
    {
		$n=$k[1];
		if($n>$max_up)$max_up=$n;
    }
    else
    if(eregi("^name",$up_file[$i]))
    {
		$s=explode(':',$up_file[$i]);
		$s=substr(trim($s[1]),0,-1);
		if(in_array($s,$up_name))
		{
			echo $n."- Дубль UNIT_UPG=".$s."<br>";
		}
		$up_name[$n]=$s;
    }
    else
    if(eregi("^need",$up_file[$i]))
    {
		$s=explode(':',$up_file[$i]);
		$s1=substr(trim($s[1]),1,-1);
		$up_need[$n]=$s1+1-1;
//		if($up_need[$n] != 0) echo "$n<br>";
    }
    else
    if(eregi("^Upg",$up_file[$i]))
    {
		for($j=0;$j<16;$j++)
		{
			$s=explode(':',$up_file[$i]);
			$up_type[$n][$j] = $up_type_prn[$n][$j] = $num = $s[1]+1-1;
			$i++;
			$s1=explode(':',$up_file[$i]);
			$up_quantity[$n][$j] = $up_quantity_prn[$n][$j] = $qua = $s1[1]+1-1;
//			$up_type2[$n][$num] = $qua;//для коррекции последующей абилки со значением в предыдущей
			if(in_array($num,$abil_need))//абгрейд с нужной абилкой
			{
				if($qua > 0)
					$need_flag[$num] = $n+1-1;//флаг того, что в данном апе есть абилка, замещающая другую абилку
			}
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
//dumper($need_flag);

dumper($up_path,"up_path");
dumper($up_path_array,"up_path_array");
dumper($up_path_unit,"up_path_unit");
//dumper($subtype_table);
//dumper($karma_flag,"Карма");

//скан абилок на выбор пути развития через кнопку у, например, эльфов
for($n = 1; $n <= $max_up; $n++)
{
	if(in_array($n,$up_path_array))
	{
		foreach($up_type_prn[$n] as $key => $num)
		{
			if(in_array($num,$abil_path_array) && $up_quantity_prn[$n][$key] == 1)
			{
				$unit_path_abil[$up_path_unit[$n]][] = $num;//need-абилка, ассоциированная с каждой кнопкой: [0] - левая, [1] - правая
//			if($up_need[$n]!=0 && $qua<0)
//				$up_abil[$n] .= "Отмена умения <B><font color=\"fuchsia\">";
//			if($num==62)//Смена типа (для столбца "получение юнита")
			}
		}
	}
}
dumper($unit_path_abil,"unit_path_abil");

/*
function need_parse($up,$need=0)//функция суммирования совпадающих абилок в цепочках замещающих друг друга апов
{
	global $need_flag,$up_need,$up_type,$up_quantity,$abil_need;
	if($need != 0)
		need_parse($up,$up_need[$need_flag[$need]]);
	$current = $need_flag[$need];//текущий ап
	foreach($up_type[$current] as $key => $num)
	{
		$pos = array_search($num,$up_type[$up]);
		if($pos !== false)
		{
			$up_quantity[$up][$pos] += $up_quantity[$current][$key];//прибавляем к уже существующему
		}
		else
		if(!in_array($num,$abil_need))
		{
			$up_type[$up][] = $num;//новый ап, не существующий у родителей
			$up_quantity[$up][] = $up_quantity[$current][$key];
		}
	}
}
*/
function need_parse($need=0)//цепочка need-зависимостей замещающих абилок
{
	global $need_parse_ret,$need_flag,$up_need;
	if($need != 0)
	{
		$need_parse_ret[] = $need_flag[$need];//цепочка апов от большего к меньшему
		need_parse($up_need[$need_flag[$need]]);
	}
}
/*
//OLD
for($i = 1; $i <= $max_up; $i++)
{
	if(in_array($i,$need_flag) && $up_need[$i]!=0)
	{
		$prev = $need_flag[$up_need[$i]];//предыдущий ап в цепочке
		foreach($up_type[$i] as $key => $num)
		{
			$up_quantity[$i][$key] += $up_type2[$prev][$num];
			$up_type2[$i][$num] = $up_quantity[$i][$key];
//		print_up($i,$need_flag[$up_need[$i]]);
//echo "$i - $key => $num need_flag[up_need[i]]=".$need_flag[$up_need[$i]]." => ".$up_type2[$need_flag[$up_need[$i]]][$num]." ИТОГ=".$up_quantity[$i][$key]."<br>";
		}
	}
//	else
//		print_up($i);
}
*/

for($i = 1; $i <= $max_up; $i++)
{
	if(in_array($up_need[$i],$abil_need))
	{
		unset($need_parse_ret);
		need_parse($up_need[$i]);
//		echo $i;
//		dumper(array_reverse($need_parse_ret));
//		$prev = $need_flag[$up_need[$i]];//предыдущий ап в цепочке
//		$prev = array_reverse(array_merge($i,$need_parse_ret));//предыдущий ап в цепочке
		foreach(array_reverse($need_parse_ret) as $prev)
		{
			foreach($up_type_prn[$prev] as $key => $num)
			{
//				if(!in_array($num,$up_type[$i]))
				$pos = array_search($num,$up_type_prn[$i]);
				if($pos !== false)
				{
//					$up_quantity[$i][$pos] += $up_quantity[$prev][$key];//прибавляем к уже существующему
					$up_quantity_prn[$i][$pos] += $up_quantity[$prev][$key];//прибавляем к уже существующему
				}
				else
				if(!in_array($num,$abil_need))
				{
//					$up_type[$i][] = $num;//новый ап, не существующий у родителей
//					$up_quantity[$i][] = $up_quantity[$prev][$key];
					$up_type_prn[$i][] = $num;//новый ап, не существующий у родителей
					$up_quantity_prn[$i][] = $up_quantity[$prev][$key];
				}
			}
		}
	}
}
//dumper($up_type_prn,"up_type_prn");
//dumper($up_quantity_prn,"up_quantity_prn");
/*
//вся эта херня для принудительного суммирования совпадающих абилок в цепочках замещающих друг друга апов
for($i = 1; $i <= $max_up; $i++)
{
	if(in_array($up_need[$i],$abil_need))
	{
//		unset($need_parse_ret);
		$prev = $need_flag[$up_need[$i]];//предыдущий ап в цепочке
		foreach($up_type[$prev] as $key => $num)
		{
//			if(!in_array($num,$up_type[$i]))
			$pos = array_search($num,$up_type[$i]);
			if($pos !== false)
			{
				$up_quantity[$i][$pos] += $up_quantity[$prev][$key];//прибавляем к уже существующему
			}
			else
			if(!in_array($num,$abil_need))
			{
				$up_type[$i][] = $num;//новый ап, не существующий у родителей
				$up_quantity[$i][] = $up_quantity[$prev][$key];
			}
		}
	}
}
dumper($up_type[180],"up_type[Насылает чахотку]");
dumper($up_quantity[180],"up_type[Насылает чахотку]");
dumper($up_type[449],"up_type[Метка дьявола]");
dumper($up_quantity[449],"up_type[Метка дьявола]");
*/
/*
//вся эта херня для принудительного суммирования совпадающих абилок в цепочках замещающих друг друга апов
for($i = 1; $i <= $max_up; $i++)
{
	if(in_array($up_need[$i],$abil_need))
	{
		need_parse($i,$up_need[$i]);
	}
}
*/
//печать unit_upg
for($n=1; $n <= $max_up; $n++)
//function print_up($n,$need=0)
{
//	global $up_type,$up_type2,$up_name,$up_quantity,$up_need,$abil_not,$up_new_unit,$up_new_unit2,$up_abil,$abil_name,$spell_name,$u_name,$abil_numeric,$abil_percent;
	$up_abil[$n] = "<B><font color=\"fuchsia\">".$up_name[$n]."</B></font> - ";
//dumper($up_type[$n],"up_type");
	$p = "";
	foreach($up_type_prn[$n] as $key => $num)
		{
//				$up_quantity[$n][$key] += $up_type2[$need][$num];
//echo			$qua = $up_quantity[$n][$key];echo ", num=$num <br>";
			$qua = $up_quantity_prn[$n][$key];
//			if($up_need[$n]!=0 && $qua<0)
//				$up_abil[$n] .= "Отмена умения <B><font color=\"fuchsia\">";
			if($num==62)//Смена типа (для столбца "получение юнита")
				$up_new_unit[]=$n;
			if($num==191)//Возрождение (для столбца "получение юнита")
			{
				$up_new_unit2[]=$n;
				$up_new_unit2_idx[]=$key;//ап скорее всего находится в середине
			}
			if(!in_array($num,$abil_not))
			{
				if($qua == 0)
					$up_abil[$n] .= "Отмена умения <B><font color=\"fuchsia\">$abil_name[$num]</font></B>; ";
				else
				if($num>3000)//аура
				{
					if($qua <= 0)
						$up_abil[$n] .= "Отмена умения <B><font color=\"fuchsia\">".$abil_name[$num-3000]."</font></B>; ";
					else
					{
						$up_abil[$n] .= "<B><font color=\"aqua\">Аура:</B> ".$abil_name[$num-3000];
						if($abil_numeric[$num-3000]==0)
							$up_abil[$n] .= "</font>; ";
						else
							$up_abil[$n] .= "</font><B> ".($qua<0 ? "<font color=\"red\">$qua" : "<font color=\"green\">+$qua").($abil_percent[$num]==1 ? "%" : "")."</font></B>; ";
					}
				}
				else
				if($num>2000)//заклы
				{
					if($qua < 0)
						$up_abil[$n] .= "Отмена умения <B><font color=\"fuchsia\">".$abil_name[$num]."</font></B>; ";
					else
						$up_abil[$n] .= "Заклятье <B><font color=\"blue\">".$spell_name[$num-2000]." $qua</font></B>; ";
				}
				else
				if($num==64)//Повелитель нежити
					$up_abil[$n] .= "Повелитель нежити (<B><font color=\"brown\">".$u_name[$qua]."</font></B>); ";
				else
				if($num==99)//99. Не влияет на моральный дух отряда. 
					$up_abil[$n] .= "Не влияет на моральный дух отряда; ";
				else
				if($num==115)//позволяющий заклинанию действовать на юнита, игнорируя все запреты
					$up_abil[$n] .= "Позволяет заклятью <B><font color=\"blue\">".$spell_name[$qua]."</font></B> действовать на юнита, игнорируя все запреты; ";
				else
				if($num==129)//навык, позволяющий воину ударом накладывать на врага заклинание
					$up_abil[$n] .= "Заклятье при ударе <B><font color=\"blue\">".$spell_name[$qua]."</font></B>; ";
				else
				if($num==130)//навык, позволяющий воину выстрелом накладывать на врага заклинание
				{
//					if($qua < 0)
//						$up_abil[$n] .= "Отмена умения <B><font color=\"fuchsia\">Заклятье при выстреле</font> <font color=\"blue\">".$spell_name[-$qua]."</font></B>; ";
//					else
//					if($qua > 0)//заглушка для "насылает чахотку" онли :((((
						$up_abil[$n] .= "Заклятье при выстреле <B><font color=\"blue\">".$spell_name[$qua]."</font></B>; ";
				}
				else
				if($num==131)//Смена оружия (активная способность, при ударе на цель будет наложено заклинание).
					$up_abil[$n] .= "Смена снарядов: заклятье при ударе <B><font color=\"blue\">".$spell_name[$qua]."</font></B>; ";
				else
				if($num==132)//Смена снарядов (активная способность, при выстреле на цель будет наложено заклинание). 
					$up_abil[$n] .= "Смена снарядов: заклятье при выстреле <B><font color=\"blue\">".$spell_name[$qua]."</font></B>; ";
				else
				if($num==133)//Защитная аура(на атакующего накладывается определённое заклинание)
				{
//					if($up_need[$n] == 0)
						$up_abil[$n] .= "На атакующего врукопашную накладывается заклятье <B><font color=\"blue\">".$spell_name[$qua]."</font></B>; ";
				}
				else
				if($num==153)//отвечает за кнопку
					$up_abil[$n] .= "Поместить абилку на панель юнита (в качестве кнопки); ";
				else
				if($num==160)//игнорирует ограничение на бронебой при даблшоте
//					$up_abil[$n] .= "Учитываются умения <B><font color=\"fuchsia\">Бронебойный выстрел</font></B> и <B><font color=\"fuchsia\">Точный выстрел</font></B> при даблшоте; ";
					$up_abil[$n] .= "Учитывается умение <B><font color=\"fuchsia\">Бронебойный выстрел</font></B> при даблшоте; ";
				else
				if($num==162)//Смена формы (активная способность). Для корректной работы использует абилку 163 (занимать её нельзя!)
					$up_abil[$n] .= "Смена формы: временно превратиться в <B><font color=\"brown\">".$u_name[$qua]."</font></B>; ";
				else
				if($num==170)//Осадный режим
					$up_abil[$n] .= "Осадный режим: ";
				else
				if($num==171)//Осадный режим
				{
					$up_abil[$n] .= "сила выстрела ";
					if($qua > 1000)
						$up_abil[$n] .= "= <B>".($qua-1000)."</B>; ";
					else
					if($qua >= 0)
						$up_abil[$n] .= "<B><font color=\"green\">+$qua</font></B>; ";
					else
						$up_abil[$n] .= "<B><font color=\"red\">$qua</font></B>; ";
				}
				else
				if($num==172)//Осадный режим
				{
					$up_abil[$n] .= "дальность выстрела ";
					if($qua > 1000)
						$up_abil[$n] .= "= <B>".($qua-1000)."</B>; ";
					else
					if($qua >= 0)
						$up_abil[$n] .= "<B><font color=\"green\">+$qua</font></B>; ";
					else
						$up_abil[$n] .= "<B><font color=\"red\">$qua</font></B>; ";
				}
				else
				if($num==173)//Осадный режим
					$up_abil[$n] .= "получение Взрывного оружия; ";
				else
				if($num==174)//Осадный режим
					$up_abil[$n] .= "получение Цепной молнии; ";
				else
				if($num==175)//Осадный режим
				{
					$q = $qua/10;
					$up_abil[$n] .= "сила выстрела увеличена в <B><font color=\"green\">$q</font></B> раз";
					if($q>1 && $q<5)
						$up_abil[$n] .= "а";
					$up_abil[$n] .= "; ";
				}
				else
				if($num>=305 && $num<=308)//Осадный режим
					{}
				else
				if($num==189)//способность накладывать на себя заклинание через кнопку на панели
					$up_abil[$n] .= "Накладывает на себя заклятье <B><font color=\"blue\">".$spell_name[$qua]."</font></B> через кнопку на панели; ";
				else
				if($num==191)//Возрождение
				{
//					if($up_need[$n] == 0)//базовое возрождение
						$up_abil[$n] .= "Возрождение (<B><font color=\"brown\">".$u_name[$qua]."</font></B>); ";
				}
				else
				if($num==192)//Используется для корректной работы способности Возрождение (для переноса медалей)
				{
					$up_abil[$n] .= "Возрождение: перенос медалей после возрождения; ";
				}
				else
				if($num==193)//Используется для корректной работы способности Возрождение (для снижения здоровья вызываемого существа)
				{
					$up_abil[$n] .= "Возрождение: коррекция здоровья существа после возрождения; ";
				}
				else
				if($num==194)//Используется для корректной работы способности Возрождение (очистка боевой статистики существа)
				{
					$up_abil[$n] .= "Возрождение: очистка боевой статистики существа после возрождения; ";
				}
				else
				if($num==207)//Воин требует меньшего содержания золота (значение умения - это коэффициент (в процентах), не может быть больше 100)
					$up_abil[$n] .= "Содержание воина <B>".($qua>0 ? -$qua : "+".abs($qua))."%</B> (золото); ";
				else
				if($num==208)//Воин требует меньшего содержания кристаллов (значение умения - это коэффициент (в процентах), не может быть больше 100)
					$up_abil[$n] .= "Содержание воина <B>".($qua>0 ? -$qua : "+".abs($qua))."%</B> (кристаллы); ";
				else
				if($num==220)//220. Заклинание по всем рядом стоящим существам при смерти (невидимая абилка).
				{
/*					$p = "Заклинание по всем рядом стоящим существам при смерти: <B><font color=\"blue\">";
					for($ii=1;$ii<16;$ii++)
					{
						if(isset($up_type[$n][$ii]))
							$p .= $spell_name[$up_type[$n][$ii]].", ";
					}
					$up_abil[$n] .= substr($p,0,-2)."</font></B>; ";
*/					
					$up_abil[$n] .= "Заклятье по всем рядом стоящим существам при смерти: <B><font color=\"blue\">".$spell_name[$qua]."</font></B>; ";
				}
				else
				if($num==229)//229. Игнорирование брони при ударе в спину.
					$up_abil[$n] .= "Игнорирование брони при ударе в спину; ";
				else
				if($num==254)//254. Смерть существа не влияет на боевой дух окружающих
					$up_abil[$n] .= "Смерть существа не влияет на боевой дух окружающих; ";
				else
				if($num==255)//255. Ловушка (наложение заклинания).
					$up_abil[$n] .= "Ловушка: наложение заклятья <B><font color=\"blue\">".$spell_name[$qua]."</font></B>; ";
				else
				if($num==256)//256. Ловушка (увеличение затрат скорости на прохождение через тайл).
				{
					$up_abil[$n] .= "Ловушка: увеличение затрат скорости на прохождение через тайл на <B>$qua</B>; ";
/*
					$up_abil[$n] .= "Ловушка: отъятие <B>$qua</B>";
					if($qua == 1)
						$up_abil[$n] .= "-го очка";
					else
						$up_abil[$n] .= "-х очков";
					$up_abil[$n] .= " действия; ";
*/	
				}
				else
				if($num==257)//257. Используется для травмирования существа, наступившего на ловушку. 
					$up_abil[$n] .= "Ловушка: урон наступившему <font color=\"red\"><B>$qua</font></B>; ";
				else
				if($num==258)//258. Используется для наложения способности "Не сражается" на существо, наступившее на ловушку
					$up_abil[$n] .= "Ловушка: наложение наступившему способности \"Не сражается\"; ";
				else
				if($num==309)//Колдун - выбор ветки некроманта
					$up_abil[$n] .= "Колдун - выбор ветки некроманта; ";
				else
				if($num==310)//Колдун - выбор ветки демонолога
					$up_abil[$n] .= "Колдун - выбор ветки демонолога; ";
				else
				if($num==311)//Колдун с ещё не определившимися ветками развития
					$up_abil[$n] .= "Колдун с ещё не определившимися ветками развития; ";
				else
				if($num==374)//Плата золота и кристаллов воину снижена на %d~
					$up_abil[$n] .= "\"Снижение платы воину на <B>$qua%</B>\"; ";
				else
				if($abil_name[$num]=="")
					$up_abil[$n] .= "!!!Неизвестная абилка $num; ";
				else
				if($abil_numeric[$num]==0)
				{
					if($qua<0)
						$up_abil[$n] .= "Отмена умения <B><font color=\"fuchsia\">";
					$up_abil[$n] .= $abil_name[$num];
					if($qua<0)
						$up_abil[$n] .= "</font></B>";
					$up_abil[$n] .= "; ";
				}
				else
					$up_abil[$n] .= $abil_name[$num].($qua<0 ? " <B><font color=\"red\">$qua" : " <B><font color=\"green\">+$qua").($abil_percent[$num]==1 ? "%" : "")."</font></B>; ";
			}
		}
		if(!isset($up_type_prn[$n][1])) //несоставной ап из одной абилки
		{
//"Восприимчивость (n=600)",Метка изверга,Голод 5,Голод 2,Сильный голод 10, Чёрный голод
			if(($n!=446) && ($n!=500) && ($n!=503) && ($n!=504) && ($n!=505))
				unset($up_abil[$n]);
		}
		else
			$up_abil[$n] = substr($up_abil[$n],0,-2);
}
//dumper($up_new_unit2,"up_new_unit2");
//unset($up_abil[430]);//Животное
//unset($up_abil[589]);//Леденящее касание
//Шторм Тьмы
//$up_abil[690].=" - (При атаке врукопашную накладывается заклятье <B><font color=\"blue\">".$spell_name[350]."</font></B>); ";
//$up_abil[690].="Отмена умения <B><font color=\"fuchsia\">".$abil_name[348]."</font></B>; Шторм Тьмы";
//$up_abil[]="<B><font color=\"fuchsia\">Голод 5</B></font> - Трупоед 5";
//$up_abil[]="<B><font color=\"fuchsia\">Голод 2</B></font> - Берсерк +2";
//$up_abil[600] = "<B><font color=\"fuchsia\">Всеобщая жажда крови (4)</B></font> - Отмена умения <B><font color=\"fuchsia\">".$abil_name[322]."</font></B>; Всеобщая жажда крови (4); <B><font color=\"aqua\">Аура:</B> Устрашающий выстрел</font> <B><font color=green>+2</font></B>; <B><font color=\"aqua\">Аура:</B> Жажда крови</font> <B><font color=green>+4</font></B>; <B><font color=\"aqua\">Аура:</B> Устрашение</font> <B><font color=green>+2</font></B>";
//dumper($up_abil[600],"up_abil[600]");
$up_abil[]="<B><font color=\"fuchsia\">Обездвиживание 2</B></font> - Корни <B>2</B>";
//$up_abil[]="<B><font color=\"fuchsia\">Освободить кобольда</B></font> - Стать кобольдом";
$up_abil[]="<B><font color=\"fuchsia\">Рейнджерский выстрел -2</B></font> - Дополнительный выстрел <B>-2</B> (<font color=green><B>расход энергии уменьшен на </font><font color=blue>2</B></font>)";
$up_abil[]="<B><font color=\"fuchsia\">Яростная атака 2</B></font> - Круговая атака <B>2</B>";
sort($up_abil);
//dumper($up_abil,"up_abil");
foreach($up_abil as $p) echo str_replace("~","%",$p)."<br>";
$p = "";
echo "<br>";

//Разбор unit.var
$s=explode(':',$up_file[0]);
$unit_upg_quantity = $s[1]+1-1;
for($i = 0,$n=0; $i < $count_u; $i++)
{  
	if(eregi("^/([0-9]{1,})",$u_file[$i],$k))
    {
		$n=$k[1];
//		if($n>$max_u)$max_u=$n;
    }
    else
    if(eregi("^Abilityes:",$u_file[$i]))
    {
//echo $n."-".$u_file[$i]."<br>";
		$i++;
		for($j=0;$j<20;$j++)
		{
			$s=explode(':',$u_file[$i]);
			$ss=$s[1]+1-1;
			$pos = array_search($ss,$up_new_unit2);
			if($pos !== false)
//			if(in_array($ss,$up_new_unit2))//Возрождение как другое существо (191).
			{
				$u = $up_quantity_prn[$ss][$up_new_unit2_idx[$pos]];
				$level_new_unit2[$u][] = $n;//какой = из какого
				$unit_up_prn[$n] .= "<B><font color=\"brown\">Возрождение:</font></B> <B><font color=\"lime\">".$u_name[$u]."</font></B><br>";
			}
			if($ss!=0)
			{
				$u_abil3[$n][0][]=$ss;//массив № абилок (new)
				$u_abil_c[$n][$ss]++; //к-во абилок (new)
			}
			for($jj=0;$jj<16;$jj++) //сканируем unit_upg.var для поиска маг.юнитов
			{
				if($up_type[$ss][$jj]>2000 && $up_type[$ss][$jj]<3000 && $up_quantity_prn[$ss][$jj]>=0) //для юнитов с маг.книгой
				{
					$sp=$up_type[$ss][$jj]-2000; //№ заклининия
					$spell_unit[$sp]=$spell_unit[$sp]."<B><font color=\"lime\">".$u_name[$n]."</font>(0)</B>; ";
					$spell_unit2[$sp] .= $u_name2[$n]."(0); ";
				}
				else
				if(in_array($up_type[$ss][$jj],$unit_abil_spell)) //массив абилок, позволяющих юнитам пользоваться магией
				{
					if($up_need[$ss] == 0)
					{
						$sp=$up_quantity_prn[$ss][$jj]; //№ заклининия
						$spell_unit2[$sp] .= $u_name2[$n]."(0); ";
					}
				}
			}
			if(substr(trim($u_file[$i]),-1,1)==";") break; //for
			$i++;

		}
    }

    else
    if(eregi("^Lvl ([0-9]{1,}) upgrades",$u_file[$i])) //Lvl 01 upgrades: (3, 4; 4, 4; 13, 4) ... Lvl 20
	{
/*
//		if(! preg_match("/  (\s* \d+ \s* , \s* \d+ \s* ; \s*)+  /ixs",$u_file[$i]))
		if( preg_match_all("/  ( \d+ \s* , \s* \d+ \s* ; )  /ixs",$u_file[$i],$match1))
			dumper($match1,"match1");
		if( preg_match_all("/  ( \s*? # жадность квантификатора(для включения возможного пробела)
			\d+ \s* , \s* \d+ \s* \) )  /ixs",$u_file[$i],$match))
//			echo $u_file[$i]."<br>";
			dumper($match,"match");
*/
		for($j=1;$j<=20;$j++)
		{
			$s=explode('upgrades:',$u_file[$i]);	// Lvl 01 upgrades: (3, 4; 4, 4; 13, 4)
//echo $n." ".$j." s=".$s[1];
			//проверка на ошибки 1
			preg_match_all("/\d+/s",$s[1],$match);
			preg_match_all("/   \d+ \s* , \s* -*\d+ \s* ;   /ixs",$s[1],$match1);
			preg_match_all("/   \s* \d+ \s* , \s* -*\d+ \s* \)   /ixs",$s[1],$match2);
//			preg_match_all("/   \d+ \s* , \s* \d+ \s* ;   /ixs",$s[1],$match1); //если нужны отрицательные
//			preg_match_all("/   \s* \d+ \s* , \s* \d+ \s* \)   /ixs",$s[1],$match2);//вероятности - раскомментить
			if((count($match1[0])+count($match2[0])) != count($match[0])/2)
				echo $n."-!!! M=".count($match[0])." M1=".count($match1[0])." M2=".count($match2[0])." <B>".$u_file[$i]."</B><br>";
			$s1=explode(';',$s[1]);		// (3, 4; 4, 4; 13, 4)
//			if(!eregi("[,;]",substr(trim($s1[1]),1,-1)))
//				echo $n."!! ! ".$u_file[$i]."<br>";
			//проверка на ошибки 2
			if(count($s1) != (count(explode(',',$s[1]))-1))
				echo $n."!!! ".$u_file[$i]."<br>";
//echo " s1=".$s1[0]." ".$s1[1]." ".$s1[2]." ".$s1[3]." ".$s1[4]." ".$s1[5]." ".$s1[6]." ".$s1[7]."<br>";
			//проверка на ошибки 3
			eregi("^Lvl ([0-9]{1,}) upgrades",$u_file[$i],$idx);
			if(($idx[1]+1-1) != $j)//Lvl не по порядку
				echo $n." !!! - Lvl не по порядку: ".$u_file[$i]."<br>";
			for($jj=0;$jj<count($s1);$jj++)
			{
				$s2=explode(',',$s1[$jj]);	// (3, 4
				$s2[0]=trim($s2[0]);
				if(substr($s2[0],0,1)=="(") 
				{
					$s2[0]=substr($s2[0],1);
//echo " s2=".$s2[0]."<br>";
				}
//echo "SUB=".substr(trim($s2[0]),0,1)." s2=".$s2[0]." ".$s2[1]."<br>";
				$uu=$s2[0]+1-1; // 3
				if($uu > $unit_upg_quantity)
					echo "!!!$n - $u_file[$i] - № апгрейда больше максимума<br>";

				for($jjj=0;$jjj<16;$jjj++) //сканируем unit_upg.var для поиска маг.юнитов
				{
					if($up_type[$uu][$jjj]>2000 && $up_type[$uu][$jjj]<3000 && $up_quantity_prn[$uu][$jjj]>=0) //для юнитов с маг.книгой
					{
						$sp=$up_type[$uu][$jjj]-2000; //№ заклининия
						$spell_unit[$sp]=$spell_unit[$sp]."<B><font color=\"lime\">".$u_name[$n]."</font>($j)</B>; ";
						$spell_unit2[$sp] .= $u_name2[$n]."($j); ";
					}
					else
					if(in_array($up_type[$uu][$jjj],$unit_abil_spell)) //массив абилок, позволяющих юнитам пользоваться магией
					{
						if($up_need[$uu] == 0)
						{
							$sp=$up_quantity_prn[$uu][$jjj]; //№ заклининия
							$spell_unit[$sp]=$spell_unit[$sp]."<B><font color=\"lime\">".$u_name[$n]."</font>($j)</B>; ";
							$spell_unit2[$sp] .= $u_name2[$n]."($j); ";
						}
					}
				}

				if(($s2[1]+1-1) > 0) //Положительный вес
				{
//					if(!array_search($up_need[$uu],$unit_path_abil[$n]))
					if(in_array($up_need[$uu],$unit_path_abil[$n]))//апы, ассоциированные с кнопками выбора пути апгрейда
					{
						$idx = array_search($up_need[$uu],$unit_path_abil[$n]);
						if($idx == 0)//левая кнопка
						{
							if($u_abil_c_path_0[$n][$uu]=="")$u_abil3_path_0[$n][$j][]=$uu;
							$u_abil_c_path_0[$n][$uu]++;
						}
						else//правая кнопка
						{
							if($u_abil_c_path_1[$n][$uu]=="")$u_abil3_path_1[$n][$j][]=$uu;
							$u_abil_c_path_1[$n][$uu]++;
						}
					}
					else
					{
						if($u_abil_c[$n][$uu]=="")$u_abil3[$n][$j][]=$uu;
						$u_abil_c[$n][$uu]++;
					}
//echo $n."-UP=".$uu." C=".$u_abil_c[$n][$uu]."<br>";
					if(in_array($uu,$up_new_unit))//смена типа юнита (62)
					{
						$u = $up_quantity_prn[$uu][0];
						$level_new_unit[$u][$n] .= "<B>".$j."</B>, ";//какой[из какого]=уровень (для "способ получения")
						$level_new_unit3[$n][$u] .= "<B>".$j."</B>, ";//из какого[какой]=уровень (для "Апгрейд")
						$level_new_unit_spoil[$u][$n] .= $j.", ";//какой[из какого]=уровень (для спойлеров)
//						$unit_up_prn[$n] .= "<B><font color=\"brown\">Уровневый:</font></B> <B><font color=\"lime\">".$u_name[$u]."</font></B> (на уровне <B>$j</B>)<br>";
//						$build_unit[$u][0][] .= "<B><font color=\"red\">Апгрейд:</font></B> из юнита <B><font color=\"lime\">".$u_name[$n]."</font></B> (на уровне ".$level_new_unit[$up_quantity[$uu][0]][$n].");<br>";
					}
					$pos = array_search($uu,$up_new_unit2);//Возрождение как другое существо (191).
					if($pos !== false)
					{
						$u = $up_quantity_prn[$uu][$up_new_unit2_idx[$pos]];
//						if(!in_array($n,$level_new_unit2[$up_quantity[$uu][0]]))
						$level_new_unit2[$u][] = $n;//какой = из какого (для Возрождение)
						$unit_up_prn[$n] .= "<B><font color=\"brown\">Возрождение:</font></B> <B><font color=\"lime\">".$u_name[$u]."</font></B><br>";
					}
//возможные изменения параметров юнитов при апгрейдах (с помощью абилок)
					if(!in_array($n,$hero_up))
					{
						if($uu==1) $life_table2[$n] += 1;
						if($uu==2) $life_table2[$n] += 2;
						if($uu==3) $life_table2[$n] += 3;
						if($uu==4) $attack_table2[$n] += 1;
						if($uu==5) $attack_table2[$n] += 2;
						if($uu==6) $attack_table2[$n] += 3;
						if($uu==7) $c_attack_table2[$n] += 1;
						if($uu==8) $c_attack_table2[$n] += 2;
						if($uu==9) $c_attack_table2[$n] += 3;
						if($uu==10) $defence_table2[$n] += 1;
						if($uu==11) $defence_table2[$n] += 2;
						if($uu==12) $defence_table2[$n] += 3;
						if($uu==13) $r_defence_table2[$n] += 1;
						if($uu==14) $r_defence_table2[$n] += 2;
						if($uu==15) $r_defence_table2[$n] += 3;
						if($uu==16) $resist_table2[$n] += 1;
						if($uu==17) $resist_table2[$n] += 2;
						if($uu==18) $resist_table2[$n] += 3;
						if($uu==19) $speed_table2[$n] += 1;
						if($uu==20) $r_attack_table2[$n] += 1;
						if($uu==21) $r_attack_table2[$n] += 2;
						if($uu==22) $r_attack_table2[$n] += 3;
						if($uu==23) $s_range_table2[$n] += 1;
						if($uu==24) $s_range_table2[$n] += 2;
						if($uu==25) $life_table2[$n] += 4;
						if($uu==27) $ammo_table2[$n] += 1;
						if($uu==28) $ammo_table2[$n] += 2;
						if($uu==29) $ammo_table2[$n] += 3;
						if($uu==30) $stamina_table2[$n] += 1;
						if($uu==31) $stamina_table2[$n] += 2;
						if($uu==32) $stamina_table2[$n] += 3;
						if($uu==33) $morale_table2[$n] += 1;
						if($uu==34) $morale_table2[$n] += 2;
						if($uu==35) $morale_table2[$n] += 3;
						if($uu==36) {$stamina_table2[$n] += 1; $life_table2[$n] += 1;}
						if($uu==37) {$stamina_table2[$n] += 2; $life_table2[$n] += 2;}
						if($uu==38) {$attack_table2[$n] += 1; $c_attack_table2[$n] += 1;}
						if($uu==39) {$attack_table2[$n] += 2; $c_attack_table2[$n] += 2;}
						if($uu==40) {$defence_table2[$n] += 1; $r_defence_table2[$n] += 1;}
						if($uu==41) {$defence_table2[$n] += 2; $r_defence_table2[$n] += 2;}
						if($uu==42) {$resist_table2[$n] += 1; $morale_table2[$n] += 1;}
						if($uu==43) {$resist_table2[$n] += 2; $morale_table2[$n] += 2;}
//						if($uu==90) $s_range_table2[$n] += 4; //Зачарованные стрелы
//						if($uu==91) $s_range_table2[$n] += 1; //Зачарованные стрелы
//						if($uu==157) {$attack_table2[$n] += 1; $c_attack_table2[$n] += 1;} //Безумие орков +1
						if($uu==293) $r_attack_table2[$n] += 1;
						if($uu==447) $speed_table2[$n] += 1;
						if($uu==452) $speed_table2[$n] += 1;
						if($uu==501) $attack_table2[$n] += 2;
//						if($uu==603) $s_range_table2[$n] += 2; //Зачарованные стрелы
//						if($uu==605) $s_range_table2[$n] += 6; //Зачарованные стрелы
//						if($uu==606) $s_range_table2[$n] += 2; //Зачарованные стрелы
//						if($uu==650) $attack_table2[$n] += 4; //Зачарованный клинок
//						if($uu==651) $attack_table2[$n] += 2; //Зачарованный клинок
						if($uu==672) $r_attack_table2[$n] += 2;
//						if($uu==715) {$r_attack_table2[$n] += 3; $s_range_table2[$n] += 1;}//Name: Осадный режим (Снайпер);
//						if($uu==716) {$r_attack_table2[$n] += 8; $s_range_table2[$n] += 2;}//Name: Осадный режим (Гномья пушка);
						if($uu==748) {$r_attack_table2[$n] += 1; $attack_table2[$n] += 1;}
					}
				}//Положительный вес
			}
			$i++;
		}
    }


    else
    if(eregi("^Lvl ([0-9]{1,}) loot",$u_file[$i])) //Lvl 01 loot: (3, 4; 4, 4; 13, 4) ... Lvl 20
    {
//echo $n."-".$u_file[$i]."<br>";
		$summon_flag = 0;//флаг повторного попадания в лут свитков призыва юнитов (для "Способы получения" через свиток в луте)
		for($j=1;$j<=20;$j++)
		{
			$s=explode('loot:',$u_file[$i]);	// Lvl 01 loot: (3, 4; 4, 4; 13, 4)
//echo $n." ".$j." s=".$s[1];
			$s1=explode(';',$s[1]);		// (3, 4; 4, 4; 13, 4)
			if(count($s1) != (count(explode(',',$s[1]))-1))//проверка на ошибки
				echo $n."!!! ".$u_file[$i]."<br>";
//echo " s1=".$s1[0]." ".$s1[1]." ".$s1[2]." ".$s1[3]." ".$s1[4]." ".$s1[5]." ".$s1[6]." ".$s1[7];
			//проверка на ошибки 3
			eregi("^Lvl ([0-9]{1,}) loot",$u_file[$i],$idx);
			if(($idx[1]+1-1) != $j)//Lvl не по порядку
				echo $n." !!! - Lvl не по порядку: ".$u_file[$i]."<br>";
			for($jj=0;$jj<9;$jj++)
			{
				$s2=explode(',',$s1[$jj]);	// (3, 4
//echo " s2=".$s2[0]." ".$s2[1]." ".$s2[2]." ".$s2[3]." ".$s2[4]." ".$s2[5]." ".$s2[6]." ".$s2[7]."<br>";
				$s2[0]=trim($s2[0]);
				$s2_1=$s2[1]+1-1;//4
				if(substr($s2[0],0,1)=="(") 
				{
					$s2[0]=substr($s2[0],1);
//echo $n."  ".$j."s2=".$s2[0]."<br>";
				}
				$s2_0=$s2[0]+1-1;//3
//echo "SUB=".substr(trim($s2[0]),0,1)." s2=".$s2[0]." ".$s2[1]."<br>";
				if(($s2_1) > 0) //Положительный вес (можно закомментить и проверить на ошибки)
				{
//					if((!in_array($s2_0,$u_loot_lvl[$n])) && ($s2_0 != 0))	// 3
					if($s2_0 != 0)	// 3
					{
	//					$u_loot_lvl[$n][]=$s2_0; //массив уже даденных артов
						$u_loot_prn[$n] .= $item_name[$s2_0]."(<B>".$j."</B>); "; 
					}
					if(isset($item_summon[$s2_0]))//"Способы получения" через свиток в луте
					{
						if($summon_flag == 0)
						{
							$build_unit[$item_summon[$s2_0]][0][] .= "<B><font color=\"red\">Получение предмета найма:</font> <font color=\"#FF6600\">[Трофеи]</font></B> - предмет <B><font color=\"brown\">".$item_name[$s2_0]."</font></B>
 (если в армии врага был юнит <B><font color=\"lime\">".$u_name[$n]."</font></B>);<br>";
							$build_unit2[$item_summon[$s2_0]][0][] .= "Получение предмета найма: [Трофеи] - предмет $item_name[$s2_0] (если в армии врага был юнит $u_name[$n]); ";
						}
						$summon_flag = 1;
					}
				}
//echo $n." ".$j." loot=".$u_loot_lvl[$n][$s2[0]+1-1]."<br>";
			}
			$i++;
		}
		$u_loot_prn[$n]=substr($u_loot_prn[$n],0,-2);
	}

}
dumper($u_abil3_path_0,"u_abil3_path_0");
dumper($u_abil_c_path_0,"u_abil_c_path_0");
dumper($u_abil3_path_1,"u_abil3_path_1");
dumper($u_abil_c_path_1,"u_abil_c_path_1");
//dumper($spell_unit,"spell_unit");

//Разбор shard_bonus.var
for($i = 0,$n=0; $i < $count_shard; $i++)
{  
	if(eregi("^/([0-9]{1,})",$shard_file[$i],$k))
	{
		$n=$k[1];
	}
	else
	if(eregi("^Level",$shard_file[$i]))
	{
		if($n==5)//Предмет в сокровищнице
		{
			for($j=1;$j<=8;$j++)
			{
				$s=explode(':',$shard_file[$i]);//Level1: (31, 10)(161, 10)(56, 10)(44, 10)(630, 10)(48, 10);
				for($k=0; $k < preg_match_all("/(\(\d+\s*,\s*\d*\))/",trim($s[1]),$shard); $k++)//(31, 10)...
				{
					$s1=substr($shard[0][$k],1,-1);//31, 10
					$s2=explode(',',$s1);
					$s2_0 = $s2[0]+1-1;//31
					if(isset($item_summon[$s2_0]))
					{
						$build_unit[$item_summon[$s2_0]][-1][] .= "<B><font color=\"red\">Получение предмета найма:</font> <font color=\"#FFCC00\">[Кампания]</font></B> - Бонус осколка (предмет <B><font color=\"brown\">".$item_name[$s2_0]."</font></B> в сокровищнице);<br>";
						$build_unit2[$item_summon[$s2_0]][-1][] .= "Получение предмета найма: [Кампания] - Бонус осколка (предмет $item_name[$s2_0] в сокровищнице); ";
					}
				}
				$i++;
			}
 		}
		if($n==6)//Воин в гарнизоне
		{
			for($j=1;$j<=8;$j++)
			{
				$s=explode(':',$shard_file[$i]);//Level1: (31, 10)(161, 10)(56, 10)(44, 10)(630, 10)(48, 10);
				for($k=0; $k < preg_match_all("/(\(\d+\s*,\s*\d*\))/",trim($s[1]),$shard); $k++)//(31, 10)...
				{
					$s1=substr($shard[0][$k],1,-1);//31, 10
					$s2=explode(',',$s1);
					$s2_0 = $s2[0]+1-1;//31
					if(!in_array($s2_0,$garn_flag))
					{
						$garn_flag[] = $s2_0;//флаг повторного попадания юнитов в гарнизон (для "Способы получения")
						$build_unit[$s2_0][-1][] .= "<B><font color=\"red\">Добавление в гарнизон:</font> <font color=\"#FFCC00\">[Кампания]</font></B> - Бонус осколка;<br>";
						$build_unit2[$s2_0][-1][] .= "Добавление в гарнизон: [Кампания] - Бонус осколка; ";
					}
				}
				$i++;
			}
 		}
	}
}
//sort($garn_flag);dumper($garn_flag);
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
		$name1_table[$n]=trim($s); //имя в формате "/0 Пусто "

//echo "<br>".$k[1]."! $n  ! $max !!"; 
		$u1++;	//№ строки
}
	else
	if(eregi("^Level:",$a_file[$i]))
	{
		$s=explode(':',$a_file[$i]);
		$level_table[$n] = $lvl = $s[1]+1-1;
	}
	else
	if(eregi("^Life:",$a_file[$i]))
	{
		$s=explode(':',$a_file[$i]);
		$life_table[$n]=$s[1]+1-1;
	}
	else
	if(eregi("^Attack:",$a_file[$i]))
	{
		$s=explode(':',$a_file[$i]);
		$attack_table[$n]=$s[1]+1-1;
	}
	else
	if(eregi("^CounterAttack:",$a_file[$i]))
	{
		$s=explode(':',$a_file[$i]);
		$c_attack_table[$n]=$s[1]+1-1;
	}
	else
	if(eregi("^Defence:",$a_file[$i]))
	{
		$s=explode(':',$a_file[$i]);
		$defence_table[$n]=$s[1]+1-1;
	}
	else
	if(eregi("^RangedDefence:",$a_file[$i]))
	{
		$s=explode(':',$a_file[$i]);
		$r_defence_table[$n]=$s[1]+1-1;
	}
	else
	if(eregi("^Resist:",$a_file[$i]))
	{
		$s=explode(':',$a_file[$i]);
		$resist_table[$n]=$s[1]+1-1;
	}
	else
	if(eregi("^Speed:",$a_file[$i]))
	{
		$s=explode(':',$a_file[$i]);
		$speed_table[$n]=$s[1]+1-1;
	}
	else
	if(eregi("^RangedAttack:",$a_file[$i]))
	{
		$s=explode(':',$a_file[$i]);
		if(($s[1]+1-1) != 0)
			$r_attack_table[$n]=$s[1]+1-1;
	}
	else
	if(eregi("^ShootingRange:",$a_file[$i]))
	{
		$s=explode(':',$a_file[$i]);
		if(($s[1]+1-1) != 0)
			$s_range_table[$n]=$s[1]+1-1;
	}
	else
	if(eregi("^Ammo:",$a_file[$i]))
	{
		$s=explode(':',$a_file[$i]);
		if(($s[1]+1-1) != 0)
			$ammo_table[$n]=$s[1]+1-1;
	}
	else
	if(eregi("^Stamina:",$a_file[$i]))
	{
		$s=explode(':',$a_file[$i]);
		$stamina_table[$n]=$s[1]+1-1;
	}
	else
	if(eregi("^Morale:",$a_file[$i]))
	{
		$s=explode(':',$a_file[$i]);
		$morale_table[$n]=$s[1]+1-1;
	}
	else
	if(eregi("^Exp:",$a_file[$i]))
	{
		$s=explode(':',$a_file[$i]);
		$exp_table[$n]=$s[1]+1-1;
	}
	else
	if(eregi("^ExpMod:",$a_file[$i]))
	{
		$s=explode(':',$a_file[$i]);
		$expmod_table[$n]=$s[1]+1-1;
	}
	else
	if(eregi("^GoldPrice:",$a_file[$i]))
	{
		$s=explode(':',$a_file[$i]);
		$gold_table[$n]=$s[1]+1-1;
	}
	else
	if(eregi("^GemPrice:",$a_file[$i]))
	{
		$s=explode(':',$a_file[$i]);
		$gem_table[$n]=$s[1]+1-1;
	}
	else
	if(eregi("^GoldPayment:",$a_file[$i]))
	{
		$s=explode(':',$a_file[$i]);
		$s1 = $s[1]+1-1;
		$gold_p_table[$n]= $s1;
		if(!in_array($n,$hero_up))
		{
//			$gold_p_table2[$n]= floor($s1*(1+3/($level_table[$n]+1)));//плата на 30-ом уровне
			//S=S0(1+L/(10(T+1))); где S — содержание, S0 — базовое содержание с учётом медалей и/или наёмничества, L — уровень бойца, Т — круг бойца 
			for($j = 0; $j <= 30; $j++)
			{
				$gold_p_table2[$n][$j] = floor($s1*(1+$j/(10*($lvl+1))));
			}
		}
		if($s1 != 0)
		{
			for($j=1;$j<=5;$j++)
			{
				for($k=0;$k<=5;$k++)
				{
					$c = $j+5*$k;
					if($c < 10)
						$pos = "0".$c;
					else
						$pos = "".$c;
					$gold_p_print[$n] .= "<B><font color=\"blue\">".$pos."</font></B> = ".$gold_p_table2[$n][$c]." ";
				}
				$gold_p_print[$n] .= "<br>";
			}
			$gold_p_print[$n] = substr($gold_p_print[$n],0,-5);
		}
//dumper($gold_p_table2[$n],$u_name[$n]." - содержание");
	}
	else
	if(eregi("^GemPayment:",$a_file[$i]))
	{
		$s=explode(':',$a_file[$i]);
		$s1 = $s[1]+1-1;
		$gem_p_table[$n]=$s1;
		if(!in_array($n,$hero_up))
		{
//			$gem_p_table2[$n]= floor($s1*(1+3/($level_table[$n]+1)));//плата на 30-ом уровне
			//S=S0(1+L/(10(T+1))); где S — содержание, S0 — базовое содержание с учётом медалей и/или наёмничества, L — уровень бойца, Т — круг бойца 
			for($j = 0; $j <= 30; $j++)
			{
				$gem_p_table2[$n][$j] = floor($s1*(1+$j/(10*($lvl+1))));
			}
		}
		if($s1 != 0)
		{
			for($j=1;$j<=5;$j++)
			{
				for($k=0;$k<=5;$k++)
				{
					$c = $j+5*$k;
					if($c < 10)
						$pos = "0".$c;
					else
						$pos = "".$c;
					$gem_p_print[$n] .= "<B><font color=\"blue\">".$pos."</font></B> = ".$gem_p_table2[$n][$c]." ";
				}
				$gem_p_print[$n] .= "<br>";
			}
			$gem_p_print[$n] = substr($gem_p_print[$n],0,-5);
		}
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
			if(($s2[$j]+1-1) != 0)
				$unit_res[$n] .= $res_name[$s2[$j]+1-1]."; ";
		}
		if($unit_res[$n] != "")
			$unit_res[$n] = substr($unit_res[$n],0,-2);
		else
			$unit_res[$n] = "";
	}
	else
	if(eregi("^Subtype:",$a_file[$i]))
	{
		$s=explode(':',$a_file[$i]);
		$s1=substr(trim($s[1]),1,-1);
		$s2=explode(',',$s1);
		for($j=0;($s2[$j]!="")&&($j<10);$j++)
		{
			$subtype_table[$n] .= $unit_subtype[$s2[$j]+1-1]."; ";
			if(($s2[$j]+1-1) == 3) // Демоны для "Тёмный Пакт"
			{
				$build_unit[$n][0][] = "<B><font color=\"red\">Присоединение к отряду:</font></B> заклятье <B><font color=\"blue\">Тёмный Пакт</font></B>;<br>";
				$build_unit2[$n][0][] = "Присоединение к отряду: заклятье Тёмный Пакт; ";
			}
		}
		$subtype_table[$n] = substr($subtype_table[$n],0,-2);
	}
	else
	if(eregi("^Analogs:",$a_file[$i]))
	{
		$s=explode(':',$a_file[$i]);
		$s1=substr(trim($s[1]),1,-1);
		$s2=explode(',',$s1);
		for($j=0;($s2[$j]!="")&&($j<10);$j++)
		{
			if(($s2[$j]+1-1) != 0)
			{
				$analogs_table[$n] .= $u_name[$s2[$j]+1-1]."; ";
				$analogs_table2[$n] .= $u_name2[$s2[$j]+1-1]."; ";
			}
		}
		if($analogs_table[$n] != "")
		{
			$analogs_table[$n] = substr($analogs_table[$n],0,-2);
			$analogs_table2[$n] = substr($analogs_table2[$n],0,-2);
		}
		else
		{
			$analogs_table[$n] = "";
			$analogs_table2[$n] = "";
		}
    }
	else
	if(eregi("^Upgraded:",$a_file[$i]))
	{
		$s=explode(':',$a_file[$i]);//Upgraded: (122,30)
		$s1=substr(trim($s[1]),1,-1);//122,30
		$s2=explode(',',$s1);
		$up1=$s2[0]+1-1;
		$up2=$s2[1]+1-1;
		if($up1 > 0)//Повышение
		{
			$build_unit[$up1][-1][] = "<B><font color=\"red\">Повышение:</font></B> из юнита <B><font color=\"lime\">".$u_name[$n]."</font></B> (<B>".$up2."</B>);<br>";
			$build_unit2[$up1][-1][] = "Повышение: из юнита ".$u_name[$n]." (".$up2."); ";
			$unit_up1[$n] = $s1;//Принудительный апгрейд
//			if(($s2[0]+1-1) != 0)
				$unit_up_prn[$n] = "<B><font color=\"red\">Повышение:</font></B> ".$u_name[$s2[0]]." (<B>".trim($s2[1])."</B>)<br>";
		}
	}
	else
	if(eregi("^UnitClass:",$a_file[$i]))
	{
		$s=explode(':',$a_file[$i]);
		$unit_class_table[$n]=$unit_class[$s[1]+1-1];
	}
	else
	if(eregi("^Karma:",$a_file[$i]))
	{
		$s=explode(':',$a_file[$i]);
		$unit_karma[$n]=$s[1]+1-1;
		if($unit_karma[$n] != 0)
			$karma_flag[$unit_txt_idx[$n]] = $s[1]+1-1;//№ строки в unit.txt, куда надо вставить спойлер о карме
	}	
}
//------------------------------------------------------------


//echo "<table width=100% border=1><tr><td>№</td><td colspan=20>Units</td></tr>";

//dumper($u_abil_c,"COUNT");

//вывод умений unit.var (new)
for($i=1;$i<$max_u+1;$i++)
{ 
//	echo "<tr><td>$i ($u_name[$i])</td><td>";
	$s = explode(',',$unit_up1[$i]);
	if(($s[0]+1-1) > 0)
	{
		$p = "<B><font color=\"brown\">Повышение:</font> <font color=\"lime\">".$u_name[$s[0]]."</font> (".trim(($s[1])).")</B>; ";
	}
/*	if(isset($unit_path_abil[$i]))
	{
		$p = "<B><font color=\"brown\">".$up_name."</font> <font color=\"lime\">".$u_name[$s[0]]."</font> (".trim(($s[1])).")</B>; ";
	}
*/
	for($j=0;$j<=20;$j++)
	{
		foreach($u_abil3[$i][$j] as $v)
		{
			$p .= "<font color=\"green\">";
			$spell_fl=0;$morph_fl=0;$aura_fl=0;//флаги магических умений и превращения и ауры тотемов
			foreach($up_type[$v] as $ab)
			{
				if($ab > 3000)
					$aura_fl = 1;
				else
				if($ab > 2000)
					$spell_fl = 1;
				if(in_array($ab,$unit_abil_spell)) $spell_fl = 1;
				if($ab == 62 || $ab == 191) $morph_fl = 1;
			}
			if($j != 0)
			{
				$p2 .= "Ур.$j: $up_name[$v]";//для вывода апгрейдов вместо описаний
				$p2 .= (($u_abil_c[$i][$v]>1) ? " x".$u_abil_c[$i][$v]."; " : "; ");
			}
			if(in_array($v,$unit_aqua))
			{
				$p .= "<B>Ур.$j:</font> <font color=\"fuchsia\">".$up_name[$v]."</font>";
				$p .= (($u_abil_c[$i][$v]>1) ? " <font color=\"red\">x".$u_abil_c[$i][$v]."</B></font>; " : "</B>; ");
			}
			else
			if($aura_fl == 1)
			{
				$p .= "<B>Ур.$j:</font> <font color=\"aqua\">".$up_name[$v]."</font>";
				$p .= (($u_abil_c[$i][$v]>1) ? " <font color=\"red\">x".$u_abil_c[$i][$v]."</B></font>; " : "</B>; ");
			}
			else
			if($morph_fl == 1)
			{
				$p .= "<B>Ур.$j:</font> <font color=\"brown\">".$up_name[$v]."</font>";
				$p .= (($u_abil_c[$i][$v]>1) ? " <font color=\"red\">x".$u_abil_c[$i][$v]."</B></font>; " : "</B>; ");
			}
			else
			if(($spell_fl == 1)  && !in_array($v,$unit_bold_not_magic))
			{
				$p .= "<B><I>Ур.$j:</font> <font color=\"blue\">".$up_name[$v]."</font>";
				$p .= (($u_abil_c[$i][$v]>1) ? " <font color=\"red\">x".$u_abil_c[$i][$v]."</B></I></font>; " : "</B></I>; ");
			}
			else
			if((in_array($v,$unit_bold)) || (in_array($v,$unit_bold_not_magic)))
			{
				$p .= "<B>Ур.$j:</font> ".$up_name[$v];
				$p .= (($u_abil_c[$i][$v]>1) ? " <font color=\"red\">x".$u_abil_c[$i][$v]."</B></font>; " : "</B>; ");
			}
			else
			{
				$p .= "Ур.$j:</font> ".$up_name[$v];
				$p .= (($u_abil_c[$i][$v]>1) ? " <font color=\"red\">x".$u_abil_c[$i][$v]."</font>; " : "; ");
			}
		}
	}
	$u_abil_prn[$i]=str_replace("~","%",substr($p,0,-2));
	$u_abil_prn2[$i]=str_replace("~","%",substr($p2,0,-2));
	$p="";
	$p2="";
//	echo $u_abil_prn[$i]."</td></tr>";
}
//dumper($u_abil_prn2);

//вывод зданий для найма юнитов ($a_file="unit.var")
for($j=1;$j<=$max1;$j++) //пройдёмся по магазинам яиц (inner_build)
{
	if($build_egg[$j]==1)
	{
		for($k=0;$k<count($item_build[$j]);$k++)
		{
			$q=$item_summon[$item_build[$j][$k]];//номер юнита, вылупляемого из яйца
			if($q!=0)
			{
				$build_unit[$q][1][] = "<B><font color=\"red\">Продажа предмета найма:</font></B> здание <B><font color=\"green\">".$build_name[$j]."</font></B> (предмет <B><font color=\"brown\">".$item_name[$item_build[$j][$k]]."</font></B>);<br>";
				$build_unit2[$q][1][] = "Продажа предмета найма: здание $build_name[$j] (предмет ".$item_name2[$item_build[$j][$k]]."); ";
			}
//$build_unit[$i]=$build_unit[$i]."K=".count($item_build[$j])." МАГАЗИН ".$build_name[$j].";<br>";
		}
	}
}

foreach($export_site_enc_join as $u => $site)
{
	foreach($site as $j)
	{
		$build_unit[$u][0][] = "<B><font color=\"red\">Присоединение к отряду:</font></B> сайт <B><font color=\"fuchsia\">".$site_name[$j]."</font></B>;<br>";
		$build_unit2[$u][0][] = "Присоединение к отряду: сайт $site_name[$j]; ";
	}
}
foreach($export_ritual_enc_join as $u => $ritual)
{
	foreach($ritual as $j)
	{
		$build_unit[$u][0][] = "<B><font color=\"red\">Присоединение к отряду:</font></B> ритуал <B><font color=\"aqua\">".$ritual_name[$j]."</font></B>;<br>";
		$build_unit2[$u][0][] = "Присоединение к отряду: ритуал $ritual_name[$j]; ";
	}
}
foreach($export_enc_join as $u => $enc)
{
	foreach($enc as $j)
	{
		$build_unit[$u][0][] = "<B><font color=\"red\">Присоединение к отряду:</font></B> группа приключений <B><font color=\"teal\">№".$j." (".$EncGroupName[$j].")</font></B>;<br>";
		$build_unit2[$u][0][] = "Присоединение к отряду: группа приключений ".$j." (".$EncGroupName[$j]."); ";
	}
}
foreach($export_site_enc_naim as $u => $site)
{
	foreach($site as $j)
	{
		$build_unit[$u][1][] = "<B><font color=\"red\">Найм:</font></B> сайт <B><font color=\"fuchsia\">".$site_name[$j]."</font></B>;<br>";
		$build_unit2[$u][1][] = "Найм: сайт $site_name2[$j]; ";
	}
}
foreach($export_ritual_enc_naim as $u => $ritual)
{
	foreach($ritual as $j)
	{
		$build_unit[$u][1][] = "<B><font color=\"red\">Найм:</font></B> ритуал <B><font color=\"aqua\">".$ritual_name[$j]."</font></B>;<br>";
		$build_unit2[$u][1][] = "Найм: ритуал $ritual_name[$j]; ";
	}
}
/*
//РАЗКОММЕНТИТЬ, если в enc_unit.exp -> export_enc_naim есть что-то, кроме
(дубль)
39|201|Лавка чародея, квест на артефакт вечности, начало
39|202|Лавка чародея, квест на артефакт вечности, сдача 
205|210|Врата Бездны, после победы - не используется 
21|210|Врата Бездны, после победы
99|210|Врата Бездны, после победы
37|210|Врата Бездны, после победы
38|210|Врата Бездны, после победы
95|210|Врата Бездны, после победы
56|210|Врата Бездны, после победы
97|210|Врата Бездны, после победы
98|210|Врата Бездны, после победы
65|210|Врата Бездны, после победы 

foreach($export_enc_naim as $u => $enc)
{
	foreach($enc as $j)
		$build_unit[$u][1][] = "<B><font color=\"red\">Найм:</font></B> группа приключений <B><font color=\"teal\">№".$j." (".$EncGroupName[$j].")</font></B>;<br>";
}
*/
foreach($export_site_enc_egg as $u => $site)
{
	foreach($site as $j)
	{
		$build_unit[$item_summon[$u]][0][] = "<B><font color=\"red\">Получение предмета найма:</font></B> сайт <B><font color=\"fuchsia\">
		".$site_name[$j]."</font></B> (предмет <B><font color=\"brown\">".$item_name[$u]."</font></B>);<br>";
		$build_unit2[$item_summon[$u]][0][] = "Получение предмета найма: сайт $site_name[$j] (предмет $item_name[$u]); ";
	}
}
foreach($export_ritual_enc_egg as $u => $ritual)
{
	foreach($ritual as $j)
	{
		$build_unit[$item_summon[$u]][0][] = "<B><font color=\"red\">Получение предмета найма:</font></B> ритуал <B><font color=\"aqua\">
		".$ritual_name[$j]."</font></B> (предмет <B><font color=\"brown\">".$item_name[$u]."</font></B>);<br>";
		$build_unit2[$item_summon[$u]][0][] = "Получение предмета найма: ритуал $ritual_name[$j] (предмет $item_name[$u]); ";
	}
}
foreach($export_ritual_event_egg as $u => $ritual)
{
	foreach($ritual as $j)
	{
		$build_unit[$item_summon[$u]][0][] = "<B><font color=\"red\">Получение предмета найма:</font></B> ритуал <B><font color=\"aqua\">
		".$ritual_name[$j]."</font></B> (предмет <B><font color=\"brown\">".$item_name[$u]."</font></B>);<br>";
		$build_unit2[$item_summon[$u]][0][] = "Получение предмета найма: ритуал $ritual_name[$j] (предмет $item_name[$u]); ";
	}
}
foreach($export_enc_egg as $u => $enc)
{
	foreach($enc as $j)
	{
		$build_unit[$item_summon[$u]][0][] = "<B><font color=\"red\">Получение предмета найма:</font></B> группа приключений <B><font color=\"teal\">
		№".$j." (".$EncGroupName[$j].")</font></B> - предмет <B><font color=\"brown\">".$item_name[$u]."</font></B>;<br>";
		$build_unit2[$item_summon[$u]][0][] = "Получение предмета найма: группа приключений ".$j." (".$EncGroupName[$j].") - предмет $item_name[$u]; ";
	}
}
foreach($export_event_egg as $u => $ev)
{
	foreach($ev as $j)
	{
		$build_unit[$item_summon[$u]][0][] = "<B><font color=\"red\">Получение предмета найма:</font></B> группа событий <B><font color=\"teal\">
		№".$j." (".$EventGroupName[$j].")</font></B> - предмет <B><font color=\"brown\">".$item_name[$u]."</font></B>;<br>";
		$build_unit2[$item_summon[$u]][0][] = "Получение предмета найма: группа событий ".$j." (".$EventGroupName[$j].") - предмет $item_name[$u]; ";
	}
}
foreach($export_ritual_event_garn as $u => $ritual)
{
	foreach($ritual as $j)
	{
		$build_unit[$u][0][] = "<B><font color=\"red\">Добавление в гарнизон:</font></B> ритуал <B><font color=\"aqua\">".$ritual_name[$j]."</font></B>;<br>";
		$build_unit2[$u][0][] = "Добавление в гарнизон: ритуал $ritual_name[$j]; ";
	}
}
foreach($export_event_garn as $u => $ev)
{
	foreach($ev as $j)
	{
		$build_unit[$u][0][] = "<B><font color=\"red\">Добавление в гарнизон:</font></B> группа событий <B><font color=\"teal\">№".$j." (".$EventGroupName[$j].")</font></B>;<br>";
		$build_unit2[$u][0][] = "Добавление в гарнизон: группа событий ".$j." (".$EventGroupName[$j]."); ";
	}
}

/*
for($i = 1; $i < count($egg_file); $i++)
{
	$s=explode('|',$egg_file[$i]);
	$build_unit[$item_summon[$s[0]]][0][] = "<B><font color=\"red\">Получение предмета найма:</font></B> группа событий 
	<B><font color=\"teal\">№".$s[1]." (".$s[2].")</font></B> - предмет <B><font color=\"brown\">".$item_name[$s[0]]."</font></B>;<br>";
}

for($i = 1; $i < count($garn_file); $i++)
{
	$s=explode('|',$garn_file[$i]);
	$build_unit[$s[0]][0][] = "<B><font color=\"red\">Добавление в гарнизон:</font></B> группа событий 
	<B><font color=\"teal\">№".$s[1]." (".$s[2].")</font></B>;<br>";
}
*/

$build_unit[19][3][] = "<B><font color=\"red\">Бой:</font></B> умение <B><font color=\"teal\">Повелитель нежити</font></B>;<br>";
$build_unit[20][3][] = "<B><font color=\"red\">Бой:</font></B> умение <B><font color=\"teal\">Повелитель нежити</font></B>;<br>";
$build_unit2[19][3][] = "Бой: умение Повелитель нежити; ";
$build_unit2[20][3][] = "Бой: умение Повелитель нежити; ";
for($i=0,$j=1;$i<$max_spell+1;$i++)
{ 
	for(;($spell_effects[$i][$j]['num']!="")&&($j<10000);$j++)
	{
	    $num=$spell_effects[$i][$j]['num'];
	    $area=$spell_effects[$i][$j]['area'];
	    if($num>1000)
		{
			if($area<=0)
			{
				if($target_table[$i]==4) //труп
				{
					$build_unit[$num-1000][3][] = "<B><font color=\"red\">Бой:</font></B> заклятье <B><font color=\"blue\"> 
						".$spell_name[$i]."</font></B> (Подъятие)".($spell_unit[$i] == "" ? "" : " [юниты: ".substr($spell_unit[$i],0,-2)."]").";<br>";
					$build_unit2[$num-1000][3][] = "Бой: заклятье $spell_name2[$i] (Подъятие)".($spell_unit2[$i] == "" ? "" : " [юниты: ".substr($spell_unit2[$i],0,-2)."]")."; ";
				}
				else
				{
					$build_unit[$num-1000][3][] = "<B><font color=\"red\">Бой:</font></B> заклятье <B><font color=\"blue\"> 
						".$spell_name[$i]."</font></B> (Призыв)".($spell_unit[$i] == "" ? "" : " [юниты: ".substr($spell_unit[$i],0,-2)."]").";<br>";
					$build_unit2[$num-1000][3][] = "Бой: заклятье $spell_name2[$i] (Призыв)".($spell_unit2[$i] == "" ? "" : " [юниты: ".substr($spell_unit2[$i],0,-2)."]")."; ";
				}
			}
			else
			{
				$build_unit[$num-1000][3][] = "<B><font color=\"red\">Бой:</font></B> заклятье <B><font color=\"blue\"> 
					".$spell_name[$i]."</font></B> (Превращение)".($spell_unit[$i] == "" ? "" : " [юниты: ".substr($spell_unit[$i],0,-2)."]").";<br>";
				$build_unit2[$num-1000][3][] = "Бой: заклятье $spell_name2[$i] (Превращение)".($spell_unit2[$i] == "" ? "" : " [юниты: ".substr($spell_unit2[$i],0,-2)."]")."; ";
			}
		}
/*	    else
	    if($num==91) //Тёмный Пакт
		{
			$build_unit[21][0][] = "<B><font color=\"red\">Присоединение к отряду:</font></B> заклятье <B><font color=\"blue\"> ".$spell_name[$i]."</font></B>;<br>";
			$build_unit[37][0][] = "<B><font color=\"red\">Присоединение к отряду:</font></B> заклятье <B><font color=\"blue\"> ".$spell_name[$i]."</font></B>;<br>";
			$build_unit[38][0][] = "<B><font color=\"red\">Присоединение к отряду:</font></B> заклятье <B><font color=\"blue\"> ".$spell_name[$i]."</font></B>;<br>";
			$build_unit[56][0][] = "<B><font color=\"red\">Присоединение к отряду:</font></B> заклятье <B><font color=\"blue\"> ".$spell_name[$i]."</font></B>;<br>";
			$build_unit[65][0][] = "<B><font color=\"red\">Присоединение к отряду:</font></B> заклятье <B><font color=\"blue\"> ".$spell_name[$i]."</font></B>;<br>";
			$build_unit[94][0][] = "<B><font color=\"red\">Присоединение к отряду:</font></B> заклятье <B><font color=\"blue\"> ".$spell_name[$i]."</font></B>;<br>";
			$build_unit[95][0][] = "<B><font color=\"red\">Присоединение к отряду:</font></B> заклятье <B><font color=\"blue\"> ".$spell_name[$i]."</font></B>;<br>";
			$build_unit[97][0][] = "<B><font color=\"red\">Присоединение к отряду:</font></B> заклятье <B><font color=\"blue\"> ".$spell_name[$i]."</font></B>;<br>";
			$build_unit[98][0][] = "<B><font color=\"red\">Присоединение к отряду:</font></B> заклятье <B><font color=\"blue\"> ".$spell_name[$i]."</font></B>;<br>";
			$build_unit[99][0][] = "<B><font color=\"red\">Присоединение к отряду:</font></B> заклятье <B><font color=\"blue\"> ".$spell_name[$i]."</font></B>;<br>";
			$build_unit[160][0][] = "<B><font color=\"red\">Присоединение к отряду:</font></B> заклятье <B><font color=\"blue\"> ".$spell_name[$i]."</font></B>;<br>";
			$build_unit[191][0][] = "<B><font color=\"red\">Присоединение к отряду:</font></B> заклятье <B><font color=\"blue\"> ".$spell_name[$i]."</font></B>;<br>";
			$build_unit[257][0][] = "<B><font color=\"red\">Присоединение к отряду:</font></B> заклятье <B><font color=\"blue\"> ".$spell_name[$i]."</font></B>;<br>";
			$build_unit[283][0][] = "<B><font color=\"red\">Присоединение к отряду:</font></B> заклятье <B><font color=\"blue\"> ".$spell_name[$i]."</font></B>;<br>";
		}
*/	}
}

foreach($level_new_unit2 as $k => $v)//Возрождение как другое существо. 
{
	$p = "<B><font color=\"red\">Возрождение:</font></B> после смерти юнит";
	$p2 = "Возрождение: после смерти юнит";
	if(count($v) == 1)
	{
		$p .= "а";
		$p2 .= "а";
	}
	else
	{
		$p .= "ов";
		$p2 .= "ов";
	}
	$p .= " <B><font color=\"lime\">";
	$p2 .= " ";
	foreach($v as $u1)
	{
		$p .= $u_name[$u1].", ";
		$p2 .= $u_name[$u1].", ";
	}
	$p = substr($p, 0, -2);
	$p .= "</font></B>;<br>";
	$p2 = substr($p2, 0, -2);
	$p2 .= "; ";
	$build_unit[$k][-1][] .= $p;
	$build_unit2[$k][-1][] .= $p2;
	$p = "";
	$p2 = "";
}

for($i=1;$i<$max_u+1;$i++)
{
//	$p = "<B><font color=\"brown\">Уровневый:</font></B> ";
	if(isset($level_new_unit[$i]))
	{
		foreach($level_new_unit[$i] as $k => $v)//для "Способы получения"
		{
			$build_unit[$i][-1][] .= "<B><font color=\"red\">Апгрейд:</font></B> из юнита <B><font color=\"lime\">".$u_name[$k]."</font></B> (".substr($v,0,-2).");<br>";
//			$p .= "<B><font color=\"lime\">".$u_name[$i]."</font></B> (на уровне ".substr($v,0,-2)."); ";
		}
	}
	$p = "";
	foreach($level_new_unit3[$i] as $k => $v)//для "Апгрейды"
	{
		$p .= "$u_name[$k] (на уровне ".substr($v,0,-2)."); ";
	}
	if($p != "")
		$unit_up_prn[$i] .= "<B><font color=\"red\">Повышение:</font></B> ".substr($p,0,-2);
	foreach($level_new_unit_spoil[$i] as $k => $v)//Апгрейды (для спойлеров)
	{
		$build_unit2[$i][-1][] .= "Апгрейд: из юнита $u_name[$k] (".substr($v,0,-2)."); ";
	}
	if(in_array($i,$merc_table_all))//наёмники
	{
		for($m=0;$m<5;$m++)
		{
			if(in_array($i,$merc_table[$m]))
			{
				$build_unit[$i][1][] .= "<B><font color=\"red\">Найм:</font></B> в качестве наёмника (необходимая постройка <B><font color=\"green\">".$build_merc[$m]."</font></B>);<br>";
				$build_unit2[$i][1][] .= "Найм: в качестве наёмника (необходимая постройка $build_merc[$m]); ";
			}
		}
	}
//	echo "<tr><td>$i ($u_name[$i])</td><td>";
	$p = "";
	for($j=-1;$j<$BUILD_MAX;$j++)
	{
		foreach($build_unit[$i][$j] as $u)
		{
			$unit_give[$i][] = substr($u,0,-5);//Основные способы получения (для листа "unit")
			$p .= $u;
		}
	}
	$unit_give_basic[$i]=substr($p,0,strlen($p)-5);
	$p="";
	for($j=-1;$j<$BUILD_MAX;$j++)//для спойлерных описаний
	{
		foreach($build_unit2[$i][$j] as $u)
		{
			$unit_give2[$i][] = substr($u,0,-5);
			$p .= $u;
		}
	}
//	$p .= "<HR>";
	$unit_give_basic2[$i]=substr($p,0,strlen($p)-2);//для спойлерных описаний
	$p="";
	if(isset($build_unit[$i][$BUILD_MAX]))//дополнительные способы получения (для листа "Получение")
	{
		$unit_give[$i][] = "---";
		foreach($build_unit[$i][$BUILD_MAX] as $u)
		{
			$unit_give[$i][] = substr($u,0,-5);
		}
	}
	
	if($def_unit[$i][0]!="")
	{
		$p .= "Страж: <B><font color=\"blue\">";
		foreach($def_unit[$i] as $def)
			$p .= $def_name[$def].", ";
		$unit_meet[$i]=substr($p,0,strlen($p)-2)."</font></B><br>";//Где можно встретить
	}
	$p="";
	if($unit_guard[$i][0]!="")
	{
		$p .= "Охрана: <B><font color=\"red\">";
		foreach($unit_guard[$i] as $g)
			$p .= $g_name[$g].", ";
	}
	$unit_meet[$i] .= substr($p,0,strlen($p)-2)."</font></B>";//Где можно встретить
	$p="";
//	echo "</td></tr>";
}
//dumper($unit_give,"unit_give");
//вывод ресурсов ($a_file="unit.var")
/*
for($i=0;$i<$max+1;$i++)
{ 
//	echo "<tr><td>$i</td><td>";
	for($j=0;($res_table[$i][$j]!="")&&($j<10);$j++)
	{
		$unit_res[$i] .=  $res_table[$i][$j].(($res_table[$i][$j+1]=="") ? "" : "; ");
	}
//	echo "</td></tr>";
}
*/

/*
//формирование столбца "Апгрейды"
for($i=0;$i<$max+1;$i++)
{
	if(isset($unit_up2[$i]))
	{
		$unit_up_prn[$i] = "<B><font color=\"brown\">Уровневый:</font></B> ";
		foreach($unit_up2[$i] as $k => $v)
		{
			$build_unit[$i][-1][] .= "<B><font color=\"red\">Апгрейд:</font></B> из юнита <B><font color=\"lime\">".$u_name[$k]."</font></B> (на уровне ".substr($v,0,-2).");<br>";
//			$build_unit2[$i][-1][] .= "Апгрейд: из юнита $u_name[$k] (на уровне ".substr($v,0,-2)."); ";
//			$unit_up2[$k][$v] = $i;//Уровневый апгрейд
			$unit_up_prn[$i] .= $i;//Уровневый апгрейд
//			$p .= $u_name[$i]." (на уровне ".substr($v,0,-2)."); ";
		}
		$unit_up_prn[$i] = substr($p,0,-2);
}
*/
//----------------------------------------------------------
//вывод полной таблицы
echo "<table border=1>";
for($i=1;$i<$max_u+1;$i++)
{
/*	
	echo "<tr><td align=center>$i</td><td>$u_name[$i]</td><td></td><td align=center>";
	echo $level_table[$i]."</td><td align=center>".$life_table[$i]."</td><td align=center>".$attack_table[$i]."</td><td align=center>";
	echo $c_attack_table[$i]."</td><td align=center>".$defence_table[$i]."</td><td align=center>".$r_defence_table[$i]."</td><td align=center>";
	echo $resist_table[$i]."</td><td align=center>".$speed_table[$i]."</td><td align=center>".$r_attack_table[$i]."</td><td align=center>";
	echo $s_range_table[$i]."</td><td align=center>".$ammo_table[$i]."</td><td align=center>".$stamina_table[$i]."</td><td align=center>";
	echo $morale_table[$i]."</td><td align=center>".$exp_table[$i]."</td><td align=center>".$expmod_table[$i]."</td><td align=center>";
	echo $gold_table[$i]."</td><td align=center>".$gem_table[$i]."</td><td align=center>".$gold_p_table[$i]."</td><td align=center>";
	echo $gem_p_table[$i]."</td><td>".$unit_res[$i]."</td><td>".$unit_type_table[$i]."</td><td>".$unit_class_table[$i];
	echo "</td><td><B><font color=\"red\">K</font></B></td><td class=font9>".$unit_give[$i]."</td><td class=font9>";
	echo $unit_meet[$i]."</td><td class=font9>".$u_abil_prn[$i]."</td><td class=font9>".$u_loot_prn[$i]."</td><td class=font9>".$unit_txt[$i];
	echo "</td></tr>";
*/
		echo "<tr><td align=center>$i</td><td>$u_name[$i]</td><td></td><td align=center>";
		echo $level_table[$i]."</td><td align=center>".$life_table[$i];
		if(isset($life_table2[$i])) echo "<br>&#150;<br>".($life_table[$i]+$life_table2[$i]);
		echo "</td><td align=center>".$attack_table[$i];
		if(isset($attack_table2[$i])) echo "<br>&#150;<br>".($attack_table[$i]+$attack_table2[$i]);
		echo "</td><td align=center>".$c_attack_table[$i];
		if(isset($c_attack_table2[$i])) echo "<br>&#150;<br>".($c_attack_table[$i]+$c_attack_table2[$i]);
		echo "</td><td align=center>".$defence_table[$i];
		if(isset($defence_table2[$i])) echo "<br>&#150;<br>".($defence_table[$i]+$defence_table2[$i]);
		echo "</td><td align=center>".$r_defence_table[$i];
		if(isset($r_defence_table2[$i])) echo "<br>&#150;<br>".($r_defence_table[$i]+$r_defence_table2[$i]);
		echo "</td><td align=center>".$resist_table[$i];
		if(isset($resist_table2[$i])) echo "<br>&#150;<br>".($resist_table[$i]+$resist_table2[$i]);
		echo "</td><td align=center>".$speed_table[$i];
		if(isset($speed_table2[$i])) echo "<br>&#150;<br>".($speed_table[$i]+$speed_table2[$i]);
		echo "</td><td align=center>".$r_attack_table[$i];
		if(isset($r_attack_table2[$i])) echo "<br>&#150;<br>".($r_attack_table[$i]+$r_attack_table2[$i]);
		echo "</td><td align=center>".$s_range_table[$i];
		if(isset($s_range_table2[$i])) echo "<br>&#150;<br>".($s_range_table[$i]+$s_range_table2[$i]);
		echo "</td><td align=center>".$ammo_table[$i];
		if(isset($ammo_table2[$i])) echo "<br>&#150;<br>".($ammo_table[$i]+$ammo_table2[$i]);
		echo "</td><td align=center>".$stamina_table[$i];
		if(isset($stamina_table2[$i])) echo "<br>&#150;<br>".($stamina_table[$i]+$stamina_table2[$i]);
		echo "</td><td align=center>".$morale_table[$i];
		if(isset($morale_table2[$i])) echo "<br>&#150;<br>".($morale_table[$i]+$morale_table2[$i]);
		echo "</td><td align=center>".$exp_table[$i]."</td><td align=center>".$expmod_table[$i]."</td><td align=center>";
		echo $gold_table[$i]."</td><td align=center>".$gem_table[$i]."</td><td align=center>".$gold_p_table[$i];
//		if(isset($gold_p_table2[$i])) echo "<br>&#150;<br>".$gold_p_table2[$i];
		if(isset($gold_p_table2[$i])) echo "<br>&#150;<br>".$gold_p_table2[$i][30];
		echo "</td><td align=center>".$gem_p_table[$i];
//		if(isset($gem_p_table2[$i])) echo "<br>&#150;<br>".$gem_p_table2[$i];
		if(isset($gem_p_table2[$i])) echo "<br>&#150;<br>".$gem_p_table2[$i][30];
		echo "</td><td>".$unit_res[$i]."</td><td>".$subtype_table[$i]."</td><td>".$unit_class_table[$i]."</td><td>".$analogs_table[$i];
//		echo "</td><td>".$unit_up_prn[$i];//Столбец "Апгрейд" - можно раскомментить
		echo "</td><td><B><font color=\"red\">K</font></B></td><td class=font9>".$unit_give_basic[$i]."</td><td class=font9>";
//		echo "</td><td><B><font color=\"red\">K</font></B></td><td class=font9>";
		echo $unit_meet[$i]."</td><td class=font9>".$u_abil_prn[$i]."</td><td class=font9>".$u_loot_prn[$i]."</td><td class=font9>".$unit_txt[$i];
		echo "</td><td align=center>".$gold_p_table[$i]."</td><td align=center>".$gem_p_table[$i]."</td><td>".$gold_p_print[$i]."</td><td>".$gem_p_print[$i];
		echo "</td></tr>";
}
echo "</table><br>";

//вывод таблицы по листам
for($j=1;$j<=16;$j++)
{
	echo "<table border=1>";
	echo "<tr><td><B>TAB №$j</B></td></tr>";
	foreach($unit_tab[$j] as $i)
	{
		echo "<tr><td align=center>$i</td><td>$u_name[$i]</td><td></td><td align=center>";
		echo $level_table[$i]."</td><td align=center>".$life_table[$i];
		if(isset($life_table2[$i])) echo "<br>&#150;<br>".($life_table[$i]+$life_table2[$i]);
		echo "</td><td align=center>".$attack_table[$i];
		if(isset($attack_table2[$i])) echo "<br>&#150;<br>".($attack_table[$i]+$attack_table2[$i]);
		echo "</td><td align=center>".$c_attack_table[$i];
		if(isset($c_attack_table2[$i])) echo "<br>&#150;<br>".($c_attack_table[$i]+$c_attack_table2[$i]);
		echo "</td><td align=center>".$defence_table[$i];
		if(isset($defence_table2[$i])) echo "<br>&#150;<br>".($defence_table[$i]+$defence_table2[$i]);
		echo "</td><td align=center>".$r_defence_table[$i];
		if(isset($r_defence_table2[$i])) echo "<br>&#150;<br>".($r_defence_table[$i]+$r_defence_table2[$i]);
		echo "</td><td align=center>".$resist_table[$i];
		if(isset($resist_table2[$i])) echo "<br>&#150;<br>".($resist_table[$i]+$resist_table2[$i]);
		echo "</td><td align=center>".$speed_table[$i];
		if(isset($speed_table2[$i])) echo "<br>&#150;<br>".($speed_table[$i]+$speed_table2[$i]);
		echo "</td><td align=center>".$r_attack_table[$i];
		if(isset($r_attack_table2[$i])) echo "<br>&#150;<br>".($r_attack_table[$i]+$r_attack_table2[$i]);
		echo "</td><td align=center>".$s_range_table[$i];
		if(isset($s_range_table2[$i])) echo "<br>&#150;<br>".($s_range_table[$i]+$s_range_table2[$i]);
		echo "</td><td align=center>".$ammo_table[$i];
		if(isset($ammo_table2[$i])) echo "<br>&#150;<br>".($ammo_table[$i]+$ammo_table2[$i]);
		echo "</td><td align=center>".$stamina_table[$i];
		if(isset($stamina_table2[$i])) echo "<br>&#150;<br>".($stamina_table[$i]+$stamina_table2[$i]);
		echo "</td><td align=center>".$morale_table[$i];
		if(isset($morale_table2[$i])) echo "<br>&#150;<br>".($morale_table[$i]+$morale_table2[$i]);
		echo "</td><td align=center>".$exp_table[$i]."</td><td align=center>".$expmod_table[$i]."</td><td align=center>";
		echo $gold_table[$i]."</td><td align=center>".$gem_table[$i]."</td><td align=center>".$gold_p_table[$i];
//		if(isset($gold_p_table2[$i])) echo "<br>&#150;<br>".$gold_p_table2[$i];
		if(isset($gold_p_table2[$i])) echo "<br>&#150;<br>".$gold_p_table2[$i][30];
		echo "</td><td align=center>".$gem_p_table[$i];
//		if(isset($gem_p_table2[$i])) echo "<br>&#150;<br>".$gem_p_table2[$i];
		if(isset($gem_p_table2[$i])) echo "<br>&#150;<br>".$gem_p_table2[$i][30];
		echo "</td><td>".$unit_res[$i]."</td><td>".$subtype_table[$i]."</td><td>".$unit_class_table[$i]."</td><td>".$analogs_table[$i];
//		echo "</td><td>".$unit_up_prn[$i];//Столбец "Апгрейд" - можно раскомментить
		echo "</td><td><B><font color=\"red\">K</font></B></td><td class=font9>".$unit_give_basic[$i]."</td><td class=font9>";
//		echo "</td><td><B><font color=\"red\">K</font></B></td><td class=font9>";
		echo $unit_meet[$i]."</td><td class=font9>".$u_abil_prn[$i]."</td><td class=font9>".$u_loot_prn[$i]."</td><td class=font9>".$unit_txt[$i];
		echo "</td></tr>";
	}
	echo "</table><br>";
}

//вывод "Способы получения юнита в свою армию"
echo "<table border=0>";
for($i=1;$i<=$max_u;$i++)
{
	$num = count($unit_give[$i]);
	if($num > 0)
	{
		for($j=0;$j<$num;$j++)
		{
			echo "<tr>";
			if($j==0)
			{
				echo "<td align=center rowspan=$num class=bottom style='border-right:1.0pt solid black;'>$i</td>";
				echo "<td rowspan=$num class=bottom style='border-right:1.0pt solid black;'>$u_name[$i]</td>";
				echo "<td rowspan=$num class=bottom style='border-right:1.0pt solid black;'></td>";
			}
			if($j==$num-1)
			{
				echo "<td class=bottom>".$unit_give[$i][$j]."</td>";
			}
			else
			{
				echo "<td>".$unit_give[$i][$j]."</td>";
			}
			echo "</tr>";
		}
	}
	else
	{
		echo "<tr><td align=center class=bottom style='border-right:1.0pt solid black;'>$i</td>";
		echo "<td class=bottom style='border-right:1.0pt solid black;'>$u_name[$i]</td>";
		echo "<td class=bottom style='border-right:1.0pt solid black;'></td>";
		echo "<td class=bottom></td></tr>";
	}	
}
echo "</table><br>";

//dumper(&$GLOBALS);
//dumper($unit_event_egg,"unit_event_egg");
//dumper($unit_event_garn,"unit_event_garn");
//dumper($unit_enc_egg,"unit_enc_egg");
//dumper($unit_enc_garn,"unit_enc_garn");
//dumper($unit_enc_join,"unit_enc_join");
//dumper($unit_event_begin,"unit_event_begin");
//dumper($unit_enc_begin,"unit_enc_begin");
//dumper($up_new_unit,"up_new_unit");
//dumper($up_new_unit2,"up_new_unit2");
dumper($level_new_unit,"level_new_unit");
dumper($level_new_unit2,"level_new_unit2");
dumper($level_new_unit3,"level_new_unit3");
//dumper($unit_guard,"unit_guard");
//print_r($event_unit_egg);
?>
<style>
td
{mso-number-format:"\@";}
</style>
<?php
//вывод разноцветной кармы (a_file=unit.var)
echo "<table width=100% border=1>";
for($i=1;$i<$max_u+1;$i++)
{
	echo "<tr><td>$i</td><td align=center>";
	if($unit_karma[$i]>0)
		echo "<font color=\"green\">+".$unit_karma[$i]."</font>";
	else
	if($unit_karma[$i]<0)
		echo "<font color=\"red\">".$unit_karma[$i]."</font></td></tr>";
	echo "</td></tr>";
}
echo "</table><br>";
for($j=1;$j<=16;$j++)
{
	echo "<table border=1>";
	echo "<tr><td><B>TAB №$j</B></td></tr>";
	foreach($unit_tab[$j] as $i)
	{
		echo "<tr><td>$i</td><td align=center>";
		if($unit_karma[$i]>0)
			echo "<font color=\"green\">+".$unit_karma[$i]."</font>";
		else
		if($unit_karma[$i]<0)
			echo "<font color=\"red\">".$unit_karma[$i]."</font></td></tr>";
		echo "</td></tr>";
	}
	echo "</table><br>";
}

//вывод спойлера о карме и расширенное описание
$f=fopen("unit_spoil.txt","w") or die("Ошибка при создании файла unit_spoil.txt");

/*for($i = 0; $i < $count_unit; $i++)
{
	if(isset($unit_txt_idx2[$i]))
	{
		fwrite($f,"#");
		if($karma_flag[$i] != 0)
			fwrite($f,"[Карма: ".($karma_flag[$i] > 0 ? "+" : "").$karma_flag[$i]."]\n");
		fwrite($f,"[".$u_abil_prn2[$unit_txt_idx2[$i]]."]#\n".substr($def_txt_file[$i],1));
	}
//	else
//		fwrite($f,$unit_file[$i]);
}
fclose($f);
*/

//разбор unit.txt
for($i = 0; $i < $count_unit; $i++)
{  
    if(eregi("^([0-9]{1,})",$unit_file[$i],$k))
    {
		$n=$k[1];
		fwrite($f,$unit_file[$i]);
    }
    else
	if(substr($unit_file[$i],0,1)=="#")
	{
		fwrite($f,"#");
		fwrite($f,"[Exp:$exp_table[$n] ExpMod:$expmod_table[$n]"."]\n");
		if($analogs_table2[$n] != "")
		{
			fwrite($f,"[Аналоги: $analogs_table2[$n]"."]\n");
		}
		$s = explode(',',$unit_up1[$n]);
		if(($s[0]+1-1) != 0)
		{
			fwrite($f,"[Повышение: ".$u_name[$s[0]]." (".trim(($s[1])).")]\n");
		}
		if($u_abil_prn2[$n] != "")
		{
			fwrite($f,"\n=====-----  Апгрейды:  -----=====\n");
//		if($karma_flag[$i] != 0)
//			fwrite($f,"[Карма: ".($karma_flag[$i] > 0 ? "+" : "").$karma_flag[$i]."]\n");
			fwrite($f,$u_abil_prn2[$n]);
		}
		if($unit_give_basic2[$n] != "")
		{
			fwrite($f,"\n\n===--- Способы получения: ---===\n");
			fwrite($f,$unit_give_basic2[$n]);
		}
		fwrite($f,"#\n\n");
	}
}
fclose($f);

$f=fopen("merc_table.exp","w") or die("Ошибка при создании файла merc_table.exp");
for($i=0; $i<5; $i++)
{
	foreach($merc_table[$i] as $m)
		$m1 .= $u_name[$m]."(".$merc_table2[$i][$m]."), ";
	fwrite($f,substr($m1,0,-2)."\n");
	$m1 = "";
}
fclose($f);

?>
<br><a href='index.html'>вернуться к списку файлов</a>
</html>
