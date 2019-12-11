<html><head>
<meta http-equiv="Content-Type" content="text/html charset=windows-1251">
<title>Эадор - Апгрейды и способности юнитов</title></head><body>
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
require_once "dumper.php";
$abil_file = file("ability_num.var");
$up_file = file("unit_upg.var");
$up2_file = file("unit_upg2.var");
$spell_file = file("spell.var");
$u_file = file("unit.var");
$effects_file = file("effects.var");
$medal_file = file("medal.var");
$abil_txt_file = file("ability.txt");
$up_txt_file = file("upgrade.txt");
$spell_txt_file = file("Spell.txt");
$effects_txt_file = file("Effects.txt");
$medal_txt_file = file("medal.txt");

//$abil_not=array_merge(range(122,134),array(180));//составные абилки с дублирующимися названиями
//$abil_not=array_merge(range(176,182));//составные абилки с дублирующимися названиями

//$unit_abil_spell = array(139,189,206,207,216,217,218); //массив абилок, позволяющих юнитам пользоваться магией
$unit_abil_spell = array_merge(array(115),range(129,133),array(189),array(220)); //массив абилок, позволяющих юнитам пользоваться магией

$hero_up = array_merge(range(40,43),range(238,253),range(263,278));//апы героя

$abil_xod = array(45,52,69,127,128,134,135,137);//абилки, которые висят несколько ходов
//Повреждение брони,Повреждение оружия,Тяжёлые снаряды,Калечащий удар,Калечащий выстрел,Повреждение ауры,Астральные снаряды,Насылает гниение

//для need-абилок, отменяющих предыдущую абилку (в основном описательные/скрытые абилки)
$abil_need=array_merge(range(221,259),range(320,339),array(2272));

$abil_stamina = array(20,59,66,78,79);//абилки, которые тратят выносливость
//Дополнительный выстрел,Сокрушающий удар,Круговая атака,Снайперский выстрел,Мощный выстрел

$abil_negative=array(1,10,11,12,148); //кто меняет знак от параметра Negative

//доп текст в ability.txt
$abil_txt_add[1] = "
Значение    Множитель урона
Около 0~    Около 0.5
10~         0.6
20~         0.7
30~         0.8
40~         0.9
50~         1.0
";

$abil_txt_add[2] = "
Урон = Атака * СлучайноеЧисло(0.8;1.2) - Защита
Когда Урон<=0, есть вероятность нанести 1 урона при выполнении условия
СлучайноеЧисло(1;20+Урон)>=10
";

$abil_txt_add[11] = "
Значение    Множ. урона     Скорость
0           0.4(защита 0.5) -2
1           0.5             -2
2           0.6             -2
3           0.7             -1
4           0.8             -1
5           0.9             0
";

$abil_txt_add[12] = "
Значение        Множитель урона
0               0.4+Паника
1               0.5
2               0.6
3               0.7
4               0.8
5               0.9
6-15            1
16-17           1.05
18-20           1.10
21-24           1.15
25-29           1.20
30-35           1.25
36-42           1.30
43-50           1.35
";


//Разбор ability_num.var
for($i = 0,$n=0; $i < count($abil_file); $i++)
{ 
	if(eregi("^/([0-9]{1,})",$abil_file[$i],$k))
	{
		$n=$k[1];
//		if($n>$max1)$max1=$n;
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
		$ss=$s1[1]+1-1;
//		if(!isset($abil_name[$ss]))
			$abil_name[$ss]=substr(trim($s[1]),0,-1);
		$abil_num[$ss]=$n;
		if(!isset($abil_numeric[$ss]))
			$abil_numeric[$ss]=$s2[1]+1-1;
		$abil_effect[$ss]=$s3[1]+1-1;
		$abil_percent[$ss]=$s4[1]+1-1;
	}
}

$abil_numeric[213]=1;//Разрушение заклинаний
$abil_numeric[67]=1;//Корни
$abil_name[73]="Юнит под контролем";
$abil_name[74]="Реинкарнация";
$abil_name[75]="Дополнительный ход";
$abil_name[89]="Телепорт";
$abil_name[91]="Тёмный Пакт";
$abil_numeric[91]=1;
$abil_name[92]="Удвоенный урон себе";
$abil_numeric[92]=1;
$abil_name[93]="Снимает отравление и кровотечение. Уменьшает время гниения ран на <font color=\"green\"><B>1</B></font>";
$abil_name[99]="Не влияет на моральный дух отряда";
$abil_txt2[99]="Не влияет на моральный дух отряда.";
$abil_name[151]="Обнуление дистанционной атаки";
$abil_name[152]="Запрет целительства";
$abil_name[148]="Запас снарядов (с передачей трети уничтоженных кастующему)";
$abil_numeric[148]=1;
$abil_name[149]="Запрет кастующему на применение магии";
$abil_name[153]="Газовый снаряд";
$abil_txt2[153]="Газовый снаряд (активная способность).";
$abil_numeric[158]=1;//Оплетающий выстрел
$abil_name[160]="Бронебойный даблшот";
$abil_txt2[160]="Разрешение действия Бронебойного выстрела при использовании Дополнительного выстрела.";
$abil_numeric[166]=1;//Оруженосец
$abil_numeric[167]=1;//Снабженец
$abil_name[170]="Осадный режим";
$abil_txt2[170]="Осадный режим: активная способность, воин получает бонус дистанционной атаки и дальности, но теряет способность сражаться и двигаться.";
$abil_name[171]="Осадный режим";
$abil_txt2[171]="Осадный режим: корректировка силы выстрела на Power (+ или -), при Power>1000 сила выстрела устанавливается как Power-1000.";
$abil_name[172]="Осадный режим";
$abil_txt2[172]="Осадный режим: корректировка дальности выстрела на Power (+ или -), при Power>1000 дальность выстрела устанавливается как Power-1000.";
$abil_name[173]="Осадный режим";
$abil_txt2[173]="Осадный режим: если есть эта способность, при переходе в осадный режим воин получит Взрывное оружие.";
$abil_name[174]="Осадный режим";
$abil_txt2[174]="Осадный режим: если есть эта способность, при переходе в осадный режим воин получит Цепную молнию.";
$abil_name[175]="Осадный режим";
$abil_txt2[175]="Осадный режим: если есть эта способность, при переходе в осадный режим воин увеличит свою дистанционную атаку в (Power*10/100) раз.";
//$abil_name[180]="Леденящее касание";
//$abil_txt2[180]="При рукопашной атаке накладывается заклинание \"Леденящее касание\".";
$abil_name[183]="Двойной выстрел без затраты доп. выносливости";
$abil_name[189]="Заклинание на себя";
$abil_txt2[189]="Накладывает на себя заклятье через кнопку на панели.";
//$abil_name[192]="Нельзя сжечь снаряды или восполнить их";
//$abil_txt2[192]="Нельзя сжечь снаряды или восполнить их.";
//$abil_name[195]="Нельзя украсть снаряды";
//$abil_txt2[195]="Нельзя украсть снаряды.";
//$abil_name[199]="Не медалится";
//$abil_txt2[199]="Не медалится.";
$abil_name[115]="Уязвимость к заклинанию";
$abil_txt2[115]="Уязвимость к определённому заклинанию с игнорированием всех запретов и иммунитетов.";
$abil_name[129]="Наложение заклинания при ударе";
$abil_txt2[129]="Наложение заклинания при ударе (при каждом ударе - атаке и контратаке).";
$abil_name[130]="Наложение заклинания при выстреле";
$abil_txt2[130]="Наложение заклинания при выстреле (при каждом выстреле).";
$abil_name[133]="Защитная аура";
$abil_txt2[133]="На атакующего в ближнем бою накладывается заклинание.";
$abil_name[188]="Эффект цепной молнии";
$abil_txt2[188]="Воин подвергся удару цепной молнии.";
$abil_name[192]="Возрождение: медали";
$abil_txt2[192]="Возрождение: перенос медалей после возрождения";
$abil_name[193]="Возрождение: здоровье";
$abil_txt2[193]="Возрождение: коррекция здоровья существа после возрождения";
$abil_name[194]="Возрождение: статистика";
$abil_txt2[194]="Возрождение: очистка боевой статистики существа после возрождения";
$abil_name[211]="Изменение боевого духа каждый ход";
$abil_numeric[211]=1;
$abil_name[207]="Содержание воина (золото)";
$abil_txt2[207]="Величина: %d<br>Воин требует меньшего содержания золота (значение умения - это коэффициент (в процентах), не может быть больше 100).";
$abil_name[208]="Содержание воина (кристаллы)";
$abil_txt2[208]="Величина: %d<br>Воин требует меньшего содержания кристаллов (значение умения - это коэффициент (в процентах), не может быть больше 100).";
$abil_name[309] = "Колдун - выбор ветки некроманта";
$abil_txt2[309] = "Колдун - выбор ветки некроманта";
$abil_name[310] = "Колдун - выбор ветки демонолога";
$abil_txt2[310] = "Колдун - выбор ветки демонолога";
$abil_name[311] = "Колдун с ещё не определившимися ветками развития";
$abil_txt2[311] = "Колдун с ещё не определившимися ветками развития";
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
$abil_txt2[329] = "Превращение во Владыку Бездны";
$abil_txt2[330] = "Метка Мстителя";
$abil_txt2[331] = "Метка дьявола";
$abil_txt2[332] = "Превращение в беса";
$abil_txt2[333] = "Превращение в чёрта";
$abil_txt2[334] = "Превращение в демона";

//$up_abil[909] = "Сила призыва нежити; ";

//Разбор upgrade.txt
for($i = 0; $i < count($up_txt_file); $i++)
{  
    if(eregi("^/([0-9]{1,})",$up_txt_file[$i],$k))
    {
		$n=$k[1]+1-1;
//		if($n>$max1)$max1=$n;
    }
    else
	{
		if(substr($up_txt_file[$i],0,1)=="#")
		{
			$up_txt[$n] .= ((substr(trim($up_txt_file[$i]),-1,1)=="#") ? substr(trim($up_txt_file[$i]),1,-1) : substr($up_txt_file[$i],1)."<br>");
		}
		else
		if(trim($up_txt_file[$i])!="")
		{
			if(substr(trim($up_txt_file[$i]),-1,1)=="#")
			{
				$up_txt[$n] .= substr(trim($up_txt_file[$i]),0,-1);
				$i++;
			}
			else
				$up_txt[$n] .= $up_txt_file[$i]."<br>";
		}
		$up_txt[$n] = str_replace("~","%",$up_txt[$n]);
	}
}

//Разбор ability.txt
for($i = 0; $i < count($abil_txt_file); $i++)
{  
    if(eregi("^/([0-9]{1,})",$abil_txt_file[$i],$k))
    {
		$n=$k[1]+1-1;
    }
    else
	{
		if(substr($abil_txt_file[$i],0,1)=="#")
		{
//			if(!eregi("Величина:",$abil_txt_file[$i]))
				$abil_txt[$n] .= ((substr(trim($abil_txt_file[$i]),-1,1)=="#") ? substr(trim($abil_txt_file[$i]),1,-1) : substr($abil_txt_file[$i],1)."<br>");
		}
		else
		if(trim($abil_txt_file[$i])!="")
		{
			if(substr(trim($abil_txt_file[$i]),-1,1)=="#")
			{
				$abil_txt[$n] .= substr(trim($abil_txt_file[$i]),0,-1);
				$abil_txt_idx[$i] = $n;//номер абилки (для добавления спойлера в конец описания)
				$i++;
			}
			else
				$abil_txt[$n] .= $abil_txt_file[$i]."<br>";
		}
		$abil_txt[$n] = str_replace("~","%",$abil_txt[$n]);
	}
}

//Разбор medal.txt
for($i = 0; $i < count($medal_txt_file); $i++)
{  
    if(eregi("^/([0-9]{1,})",$medal_txt_file[$i],$k))
    {
		$n=$k[1];
		if($n!=0)$medal_txt[$n-1]=substr($medal_txt[$n-1],0,-4);//удаление пустой строки
    }
    else
	{
//		if(trim($medal_txt_file[$i])!="")
			$medal_txt[$n] .= str_replace("#","",str_replace("~","%",$medal_txt_file[$i]))."<br>";
	}
}
$medal_txt[$medal_max] .= "<br>";

//Разбор medal.var
for($i = 0,$n=0; $i < count($medal_file); $i++)
{  
	if(eregi("^/([0-9]{1,})",$medal_file[$i],$k))
	{
		$n=$k[1];
		if($n>$max)$medal_max=$n;
		$ul=1;//номера пунктов в абилках
	}
	else
	if(eregi("^Name",$medal_file[$i]))
	{
		$s=explode(':',$medal_file[$i]);
		$medal_name[$n]=trim(substr($s[1],0,-3));
	}
	else
	if(eregi("^GoldSpent:",$medal_file[$i]))
	{
		$s=explode(':',$medal_file[$i]);
//		if(($s[1]+1-1)!=0)
			$medal_GoldSpent[$n]=$s[1]+1-1;
	}
	else
	if(eregi("^GemSpent:",$medal_file[$i]))
	{
		$s=explode(':',$medal_file[$i]);
//		if(($s[1]+1-1)!=0)
			$medal_GemSpent[$n]=$s[1]+1-1;
	}
	else
	if(eregi("^Rarity:",$medal_file[$i]))
	{
		$s=explode(':',$medal_file[$i]);
//		if(($s[1]+1-1)!=0)
			$medal_Rarity[$n]=$s[1]+1-1;
	}
	else
	if(eregi("^Power:",$medal_file[$i]))//разбор effects: item.var,spell.var
	{
		$s=explode(':',$medal_file[$i-1]);
		$num=$s[1]+1-1;	//массив № эффектов
		$s=explode(':',$medal_file[$i]);
		$power=$s[1]+1-1;	//массив power, FlagEffect
		$medal_abil[$n] .= $ul.") ";
	    if($num==85) //Увеличенная плата
			$medal_abil[$n] .= $abil_name[$num]." на <font color=\"red\"><B>".$power."%</B></font><br>";
	    else
	    if($num==209) //Воин получает меньше опыта за бой
		{
			$medal_abil[$n] .= "Воин получает только <font color=\"red\"><B>".$power."%</B></font> опыта за бой<br>";
			$medal_txt[$n] = str_replace("%d","<font color=\"red\"><B>$power</B></font>",$medal_txt[$n]);
	    }
		else
		if($abil_name[$num]=="")
			$medal_abil[$n] .= "!!!Неизвестная абилка $num <br>";
		else
		if($abil_numeric[$num]==0)
		{
			$medal_abil[$n] .= $abil_name[$num]."<br>";
		}
		else
			$medal_abil[$n] .= $abil_name[$num].($power<0 ? " <B><font color=\"red\">$power" : " <B><font color=\"green\">+$power").($abil_percent[$num]==1 ? "%" : "")."</font></B><br>";
		$ul++;
	}
}

//Разбор effects.txt
for($i = 0; $i < count($effects_txt_file); $i++)
{  
    if(eregi("^([0-9]{1,})",$effects_txt_file[$i],$k))
    {
		$n=$k[1]+1-1;
		$s=explode('.',$effects_txt_file[$i]);
		$effects_name[$n]=trim($s[1]);
    }
    else
	{
		if(substr($effects_txt_file[$i],0,1)=="#")
		{
			$effects_txt[$n] .= ((substr(trim($effects_txt_file[$i]),-1,1)=="#") ? substr(trim($effects_txt_file[$i]),1,-1) : substr($effects_txt_file[$i],1)."<br>");
		}
		else
		if(trim($effects_txt_file[$i])!="")
		{
			if(substr(trim($effects_txt_file[$i]),-1,1)=="#")
			{
				$effects_txt[$n] .= substr(trim($effects_txt_file[$i]),0,-1);
				$i++;
			}
			else
				$effects_txt[$n] .= $effects_txt_file[$i]."<br>";
		}
		$effects_txt[$n] = str_replace("~","%",str_replace("%d","<B><font color=\"green\">%d</font></B>",$effects_txt[$n]));
	}
}


//Разбор effects.var
for($i = 0,$n=0; $i < count($effects_file); $i++)
{  
   if(eregi("^/([0-9]{1,})",$effects_file[$i],$k))
    {
		$n=$k[1];
		if($n>$max_effects) $max_effects=$n;
    }
    else
/*    
	if(eregi("^Name",$effects_file[$i]))
    {
		$s=explode(':',$effects_file[$i]);
		$effects_name[$n]=substr(trim($s[1]),0,-1);
    }
    else
*/
    if(eregi("^Ability:",$effects_file[$i]))
    {
		$s=explode(':',$effects_file[$i]);
		$s1 = $s[1]+1-1;
		if($s1 != 0)
			$effects_ability[$n]=$s1;
		if($s1 == 170)//Осадный режим, hook :(
			$effects_ability[$n]=305;
    }
    else
    if(eregi("^Spell:",$effects_file[$i]))
    {
		$s=explode(':',$effects_file[$i]);
		$s1 = $s[1]+1-1;
		if($s1 != 0)
			$effects_spell[$n]=$s1;
		if(isset($effects_ability[$n]) && isset($effects_spell[$n]))
		{
			echo "!!!У эффекта №$n установлены и Ability, и Spell<br>";
			unset($effects_spell[$n]);
		}
		if(!isset($effects_ability[$n]) && !isset($effects_spell[$n]))
			echo "!!!У эффекта №$n НЕ установлены Ability и Spell<br>";
    }
    else
    if(eregi("^Numeric:",$effects_file[$i]))
    {
		$s=explode(':',$effects_file[$i]);
		$s1 = $s[1]+1-1;
		if($s1 != 0)
		{
			$effects_numeric[$n]=$s1;
//			$effects_name[$n] .= "<br><B><font color=\"fuchsia\">(накапливается)</font></B>";
		}
    }
}
/*
dumper($abil_txt,"abil_txt");
dumper($up_txt,"up_txt");
dumper($effects_txt,"effects_txt");
dumper($effects_name,"effects_name");
*/
//Разбор Spell.txt
for($i = 0; $i < count($spell_txt_file); $i++)
{  
    if(eregi("^([0-9]{1,})",$spell_txt_file[$i],$k))
    {
		$n=$k[1];
    }
    else
	if(!eregi("^#Круг",$spell_txt_file[$i]) && !eregi("^Школа",$spell_txt_file[$i]))
	{
		if(substr($spell_txt_file[$i],0,1)=="#")
		{
			$spell_txt[$n]=$spell_txt[$n].substr($spell_txt_file[$i],1)."<br>";
		}
		else
		if(trim($spell_txt_file[$i]) == "")//игнорируем литературные описания
		{
//		echo ($i+1)." ($n)<br>";
			$i++;
			while(!eregi("^([0-9]{1,})",$spell_txt_file[$i]))
				$i++;
			$i--;
		}
		else
	    if(substr(trim($spell_txt_file[$i]),-1,1)=="#")
	    {
			$spell_txt[$n] .= substr(trim($spell_txt_file[$i]),0,-1);
			$i++;
	    }
	    else
			$spell_txt[$n] .= $spell_txt_file[$i];
	}
	$spell_txt[$n] = str_replace("~","%",$spell_txt[$n]);
}

//Разбор spell.var
for($i = 0,$n=0; $i < count($spell_file); $i++)
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
			$s = $s."<font color=\"fuchsia\">*</font>";
		}
		$spell_name[$n]=$s;
//		$spell_name[$n]=substr(trim($s[1]),0,-1);
/*		$idx = $abil_num[$n+2000];
		if(isset($idx))//абилка-закл (вылетает, зараза :((((((
		{
			$abil_txt_add[$idx] = "------------------------------------\nЗаклятье \"$spell_name[$n]\":\n";
			$abil_txt_add[$idx] .= str_replace("<br>","",str_replace("#","",$spell_txt[$n]));
		}
*/
	}
    else
    if(eregi("^Target:",$spell_file[$i]))
    {
		$s=explode(':',$spell_file[$i]);
		$target_table[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^Negative:",$spell_file[$i]))
    {
		$s=explode(':',$spell_file[$i]);
		$negative_table[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^OnEnemy:",$spell_file[$i]))
    {
		$s=explode(':',$spell_file[$i]);
		$on_enemy_table[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^OnAlly:",$spell_file[$i]))
    {
		$s=explode(':',$spell_file[$i]);
		$on_ally_table[$n]=$s[1]+1-1;
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

/*
//EFFECTS spell
for($i=0,$j=1;$i<$max_spell+1;$i++)
{ 
//	echo "<tr><td>$i ($name_table[$i])</td><td>";
	for($n=1;($spell_effects[$i][$j]['num']!="")&&($j<10000);$j++,$n++)
	{
//	    if($spell_not_count[$i]!=1) $p .= $n.") ";
	    $num=$spell_effects[$i][$j]['num'];
	    $power=$spell_effects[$i][$j]['power'];
	    $area=$spell_effects[$i][$j]['area'];
	    if($spell_effects[$i][$j]['flag']==1)
	    {
			$spell_not_count[$i]=1;
			if($num==70) //сон
				$p .= "<B>Сон:</B><br>";
			else
			if($num==71) //Похищение жизни
				$p .= "<B>Похищение жизни:</B><br>";
			else
			if($num==72) //Белая магия
			{
				$p .= "<B>Лечение для своих/урон для чужих:</B><br>";
				$spell_white_magic[$i]=1;
			}
	    }
	    else
	    if($num>1000)
		{
			if($area<=0)
			{
				if($target_table[$i]==4) //труп
					$p .= "Подъятие существа <font color=\"brown\"><B>".$u_name[$num-1000]."</B></font>";
				else
					$p .= "Призыв существа <font color=\"brown\"><B>".$u_name[$num-1000]."</B></font>";
			}
			else
				$p .= "Превращение в существо <font color=\"brown\"><B>".$u_name[$num-1000]."</B></font>, длительность <font color=\"blue\"><B>".$area."</B></font>";
			$p .= ($power>0 ? " (сила <font color=\"fuchsia\"><B>$power</B></font>)" : "").($spell_effects[$i][$j+1]['num']!="" ? "<br>" : "");
		}
	    else
	    if($num==1) //урон, лечение, воскрешение
		{
//			$spell_not_do[$i]=1;
			if($spell_white_magic[$i]==1) //Белая магия
				$p .= "Жизнь <B><font color=\"green\">+</font>/<font color=\"red\">-</font> ".$power."</B>";
			else
			if($target_table[$i]==4) //труп
				$p .= "Воскрешение, жизнь <font color=\"green\"><B>".$power."%</B></font>";
			else
			if($negative_table[$i]==0)
			{
				if($area<=0)
					$p .= ($power>0 ? "Лечение <font color=\"green\">" : "Урон <font color=\"red\">");
				else
					$p .= ($power>0 ? "Регенерация <font color=\"green\">" : "Урон <font color=\"red\">");
//					echo ($area<=0 ? "Лечение" : "Регенерация");
				$p .= "<B>".abs($power)."</B></font>";
//				echo " <font color=\"green\"><B>".$power."</B></font>";
			}
			else
				$p .= "Урон <font color=\"red\"><B>".abs($power)."</B></font>";
			$p .= ($area<=0 ? "" : ", длительность <font color=\"blue\"><B>$area</B></font>").($spell_effects[$i][$j+1]['num']!="" ? "<br>" : "");		
		}
		else
	    if($num==31) //dispell
			$p .= $abil_name[$num].", сила <font color=\"green\"><B>".$power."</B></font>".($spell_effects[$i][$j+1]['num']!="" ? "<br>" : "");
	    else
	    if($num==47) //Паутина
			$p .= $abil_name[$num].($spell_effects[$i][$j+1]['num']!="" ? "</B><br>" : "</B>");
		else
	    if($num==73) //MindControl
		{
			if($area == -1)
				$p .= $abil_name[$num].", сопротивление цели не выше <font color=\"green\"><B>".$power;
			else
				$p .= $abil_name[$num].", длительность <font color=\"blue\"><B>".$area;
			$p .= "</B></font>".($spell_effects[$i][$j+1]['num']!="" ? "<br>" : "");
		}
	    else
	    if($num==74) //Reincarnation
			$p .= $abil_name[$num].", длительность <font color=\"blue\"><B>".$area."</B></font>".($spell_effects[$i][$j+1]['num']!="" ? "<br>" : "");
	    else
	    if($num==91) //Тёмный Пакт
			$p .= $abil_name[$num].", длительность <font color=\"blue\"><B>".$area."</B></font>".($spell_effects[$i][$j+1]['num']!="" ? "<br>" : "");
	    else
	    if($num==92) //Суицид
			$p .= $abil_name[$num].", сила <font color=\"green\"><B>".$power."</B></font>".($spell_effects[$i][$j+1]['num']!="" ? "<br>" : "");
		else
		if($num==145)//эффект ожога для заклинаний
			$p .= "Урон от ожога <B><font color=\"red\">".$power."</font></B>, длительность <font color=\"blue\"><B>".$area."</B></font>".($spell_effects[$i][$j+1]['num']!="" ? "<br>" : "");
	    else
	    if($num==184) //восполнение снарядов каждый ход
		{
			if($power>0)
				$p .= "Восполнение <font color=\"green\"><B>".$power."</B></font> ";
			else
				$p .= "Трата <font color=\"red\"><B>".abs($power)."</B></font> ";
			if(abs($power) == 1)
				$p .= "снаряда";
			else
				$p .= "снарядов";
			$p .= " каждый ход, длительность <font color=\"blue\"><B>".$area."</B></font>".($spell_effects[$i][$j+1]['num']!="" ? "<br>" : "");
	    }
		else
		if($num==205)//позволяющий заклинанию действовать на юнита, игнорируя все запреты
		{
			$p .= "Позволяет заклятью <B><font color=\"blue\">".$name_table[$power]."</font></B> действовать на юнита, игнорируя все запреты";
			$p .= ", длительность <font color=\"blue\"><B>".$area."</B></font>".($spell_effects[$i][$j+1]['num']!="" ? "<br>" : "");
		}
		else
		if($num==223)//эффект процентного изменения сопротивления
		{
			$p .= "Изменение сопротивления на ".($power<0 ? " <font color=\"red\"><B>$power%</B></font>" : " <font color=\"green\"><B>+$power%</B></font>");
			$p .= ", длительность <font color=\"blue\"><B>".$area."</B></font>".($spell_effects[$i][$j+1]['num']!="" ? "<br>" : "");
		}
	    else
		if(in_array($num,$abil_stamina))
		{
			$p .= $abil_name[$num]." (затраты выносливости <font color=\"red\"><B>".$power."</B></font>)";
			$p .= ($area<=0 ? "" : ", длительность <font color=\"blue\"><B>".$area."</B></font>").($spell_effects[$i][$j+1]['num']!="" ? "<br>" : "");
	    }
		else
		if(in_array($num,$abil_xod))
		{
			$p .= $abil_name[$num]." (действует <font color=\"fuchsia\"><B>$power</font></B> ход";
			if($power>1 && $power<5)
				$p .= "а";
			else
				$p .= "ов";
			$p .= ($area<=0 ? ")" : "), длительность <font color=\"blue\"><B>".$area."</B></font>").($spell_effects[$i][$j+1]['num']!="" ? "<br>" : "");
		}
		else
		if($abil_name[$num]=="")
			$p .= "!!!Неизвестная абилка $num".($spell_effects[$i][$j+1]['num']!="" ? "<br>" : "");
		else
	    if($abil_numeric[$num]==0) //одноразодаваемые абилки
		{
			if($power<0)
				$p .= "Отмена умения <font color=\"aqua\"><B>";
			$p .= $abil_name[$num];
			if($power<0)
				$p .= "</font></B>";
			$p .= ($area<=0 ? "" : ", длительность <font color=\"blue\"><B>".$area."</B></font>").($spell_effects[$i][$j+1]['num']!="" ? "<br>" : "");
	    }
		else
//		if($negative_table[$i]==0)
//		if($spell_not_do[$i]!=1)
//		if(($negative_table[$i]==1) && ($on_ally_table[$i]==0) && ($on_enemy_table[$i]==1))
		if(($negative_table[$i]==1) && (in_array($num,$abil_negative)))
		{
			if($on_ally_table[$i]!=0 && $on_enemy_table[$i]==0)//своим - положительные, если Negative==1 и $power<0
				$p .= $abil_name[$num].($power<0 ? " <font color=\"green\"><B>+".abs($power)."</B></font>" : " <font color=\"red\"><B>-$power</B></font>").($abil_percent[$num]==1 ? "%" : "").($area<=0 ? "" : ", длительность <font color=\"blue\"><B>".$area."</B></font>").($spell_effects[$i][$j+1]['num']!="" ? "<br>" : "");			
			else
				$p .= $abil_name[$num].($power<0 ? " <font color=\"red\"><B>$power</B></font>" : " <font color=\"red\"><B>-$power</B></font>").($abil_percent[$num]==1 ? "%" : "").($area<=0 ? "" : ", длительность <font color=\"blue\"><B>".$area."</B></font>").($spell_effects[$i][$j+1]['num']!="" ? "<br>" : "");
		}
		else
			$p .= $abil_name[$num].($power<0 ? " <font color=\"red\"><B>$power</B></font>" : " <font color=\"green\"><B>+$power</B></font>").($abil_percent[$num]==1 ? "%" : "").($area<=0 ? "" : ", длительность <font color=\"blue\"><B>".$area."</B></font>").($spell_effects[$i][$j+1]['num']!="" ? "<br>" : "");
	}
	$spell_abil_prn[$i]=$p;
	$p="";
//	echo "</td></tr>";
}
*/

//предварительный разбор unit.var для unit_upg.var
for($i = 0,$n=0; $i < count($u_file); $i++)
{  
	if(eregi("^/([0-9]{1,})",$u_file[$i],$k))
    {
		$n=$k[1];
//		if($n>$max_u)$max_u=$n;
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
				$s = $s."<font color=\"fuchsia\">*</font>";
			}
			$u_name[$n]=$s;
		}
    }
    else
    if(eregi("^Subtype:",$u_file[$i]))
    {
		$s=explode(':',$u_file[$i]);
		$s1=substr(trim($s[1]),1,-1);
		$s2=explode(',',$s1);
		for($j=0;($s2[$j]!="")&&($j<10);$j++)
		{
			if(($s2[$j]+1-1) == 2) //таблица нежити (для "Повелителя нежити - зомби"
				$u_undead[] = $n;
		}
    }
}
//dumper($u_undead,"u_undead");

//Предварительный разбор unit_upg.var для need-абилок, отменяющих предыдущую абилку
for($i = 0,$n=0; $i < count($up_file); $i++)
{
	if(eregi("^/([0-9]{1,})",$up_file[$i],$k))
    {
		$n=$k[1];
		if($n>$max)$max=$n;
    }
    else
    if(eregi("^name",$up_file[$i]))
    {
		$s=explode(':',$up_file[$i]);
		$s=substr(trim($s[1]),0,-1);
		$up_name[$n]=$s;
    }
    else
    if(eregi("^need",$up_file[$i]))
    {
		$s=explode(':',$up_file[$i]);
		$s1=substr(trim($s[1]),1,-1);
		$up_need[$n]=$s1+1-1;
    }
    else
    if(eregi("^Upg",$up_file[$i]))
    {
//		$up_abil[$n] = "<B><font color=\"fuchsia\">".$up_name[$n]."</B></font> - ";
		for($j=0;$j<16;$j++)
		{
			$s=explode(':',$up_file[$i]);
			$up_type[$n][$j] = $num = $s[1]+1-1;
			$i++;
			$s1=explode(':',$up_file[$i]);
			$up_quantity[$n][$j] = $qua = $s1[1]+1-1;
			$up_type2[$n][$num] = $qua;//для коррекции последующей абилки со значением в предыдущей
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

//вся эта херня для принудительного суммирования совпадающих абилок в цепочках замещающих друг друга апов
for($i = 1; $i <= $max; $i++)
{
	if(in_array($up_need[$i],$abil_need))
	{
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

//печать unit_upg
for($n=1; $n <= $max; $n++)
{
//	$up_abil[$n] = "<B><font color=\"fuchsia\">".$up_name[$n]."</B></font> - ";
	foreach($up_type[$n] as $key => $num)
		{
			$qua = $up_quantity[$n][$key];
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
					$num3 = $num-3000;
					if($qua == 0)
						$up_abil[$n] .= "Отмена умения <B><font color=\"fuchsia\">".$abil_name[$num]."</font></B>; ";
					else
					{
//						$up_abil[$n] .= "Аура: <B><font color=\"fuchsia\">".$abil_name[$num3]."</font></B> ".($qua<0 ? "<font color=\"red\">$qua" : "<font color=\"green\">+$qua").($abil_percent[$num]==1 ? "%" : "")."</font></B>; ";
						$up_abil[$n] .= "Аура: <B><font color=\"fuchsia\">";
						if(in_array($num3,$abil_stamina))
						{
							$up_abil[$n] .= $abil_name[$num3]." (затраты выносливости <font color=\"red\"><B>".$qua."</B></font>); ";
						}
						else
						if(in_array($num3,$abil_xod))
						{
							$up_abil[$n] .= $abil_name[$num3]." (действует <font color=\"fuchsia\"><B>$qua</font></B> ход";
							if($qua>1 && $qua<5)
								$up_abil[$n] .= "а";
							else
							if($qua>4)
								$up_abil[$n] .= "ов";
							$up_abil[$n] .= ")";
						}
						else
						if($abil_name[$num3]=="")
							$up_abil[$n] .= "!!!Неизвестная абилка $num3; ";
						else
						if($abil_numeric[$num3]==0)
							$up_abil[$n] .= $abil_name[$num3]."</font></B>; ";
						else
							$up_abil[$n] .= $abil_name[$num3]."</font></B>".($qua<0 ? " <B><font color=\"red\">$qua" : " <B><font color=\"green\">+$qua").($abil_percent[$num]==1 ? "%" : "")."</font></B>; ";
					}
				}
				else
				if($num>2000)//заклы
				{
//					$spell_abil_flag[$n] = 1;//флаг, что абилка - магия
					if($qua < 0)
						$up_abil[$n] .= "Отмена умения <B><font color=\"fuchsia\">".$abil_name[$num]."</font></B>";
					else
						$up_abil[$n] .= "Заклятье <B><font color=\"blue\">".$spell_name[$num-2000]." $qua</font></B>";
					$up_abil[$n] .= " [<font color=\"fuchsia\">".trim($spell_txt[$num-2000])."</font>]; ";
//					$up_abil[$n] .= " [ <font color=\"fuchsia\">".$spell_abil_prn[$num-2000]."</font> ];<br>";
				}
				else
				if($num==23)//Сбор снарядов
				{
					if($qua>=0)
						$up_abil[$n] .= $abil_name[$num]." <B><font color=\"green\">0-".$qua."</font></B>; ";
					else
						$up_abil[$n] .= "Отмена умения <B><font color=\"fuchsia\">$abil_name[$num]</font></B>; ";
				}
				else
				if($num==62)//Смена типа
					$up_abil[$n] .= "Смена типа: стать юнитом <B><font color=\"brown\">".$u_name[$qua]."</font></B>; ";
				else
				if($num==64)//Повелитель нежити
				{
					if($up_need[$n]==0)
						$up_abil[$n] .= "Повелитель нежити (<B><font color=\"brown\">".$u_name[$qua]."</font></B>); ";
					else
					{
//						$u_undead_idx += $qua;//индекс нежити при need!=0
						$up_abil[$n] .= "Повелитель нежити (<B><font color=\"brown\">".$u_name[$u_undead[$qua]]."</font></B>); ";
					}
				}
				else
				if($num==99)//99. Не влияет на моральный дух отряда. 
					$up_abil[$n] .= "Не влияет на моральный дух отряда; ";
				else
				if($num==153)//отвечает за кнопку
					$up_abil[$n] .= "Поместить абилку на панель юнита (в качестве кнопки); ";
				else
				if($num==160)//игнорирует ограничение на бронебой при даблшоте
//					$up_abil[$n] .= "Учитываются умения <B><font color=\"fuchsia\">Бронебойный выстрел</font></B> и <B><font color=\"fuchsia\">Точный выстрел</font></B> при даблшоте; ";
					$up_abil[$n] .= "Учитывается умение <B><font color=\"fuchsia\">Бронебойный выстрел</font></B> при даблшоте; ";
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
/*				else
				if($num>=305 && $num<=308)//Осадный режим
					{}
*/				else
				if($num==180)//Леденящее касание
					$up_abil[$n] .= "Леденящее касание; ";
				else
				if($num==189)//способность накладывать на себя заклинание через кнопку на панели
				{
					$up_abil[$n] .= "Накладывает на себя заклятье <B><font color=\"blue\">".$spell_name[$qua]."</font></B> через кнопку на панели";
					$up_abil[$n] .= " [<font color=\"fuchsia\">".trim($spell_txt[$qua])."</font>]; ";
				}
				else
				if($num==191)//Возрождение
				{
					$up_abil[$n] .= $abil_name[$num]." (в виде юнита <B><font color=\"brown\">".$u_name[$qua]."</font></B>); ";
				}
				else
				if($num==115)//позволяющий заклинанию действовать на юнита, игнорируя все запреты
				{
					$up_abil[$n] .= "Позволяет заклятью <B><font color=\"blue\">".$spell_name[$qua]."</font></B> действовать на юнита, игнорируя все запреты";
					$up_abil[$n] .= " [<font color=\"fuchsia\">".trim($spell_txt[$qua])."</font>]; ";
				}
				else
				if($num==129)//навык, позволяющий воину ударом накладывать на врага заклинание
				{
					$up_abil[$n] .= "Заклятье при ударе <B><font color=\"blue\">".$spell_name[$qua]."</font></B>";
					$up_abil[$n] .= " [<font color=\"fuchsia\">".trim($spell_txt[$qua])."</font>]; ";
				}
				else
				if($num==130)//навык, позволяющий воину выстрелом накладывать на врага заклинание
				{
					$up_abil[$n] .= "Заклятье при выстреле <B><font color=\"blue\">".$spell_name[$qua]."</font></B>";
					$up_abil[$n] .= " [<font color=\"fuchsia\">".trim($spell_txt[$qua])."</font>]; ";
				}
				else
				if($num==131)//Смена оружия (активная способность, при ударе на цель будет наложено заклинание).
				{
					if($qua==2027)
						$up_abil[$n] .= "Смена снарядов: магический удар; ";
					else
					{
						$up_abil[$n] .= "Смена снарядов: заклятье при ударе <B><font color=\"blue\">".$spell_name[$qua]."</font></B>";
						$up_abil[$n] .= " [<font color=\"fuchsia\">".trim($spell_txt[$qua])."</font>]; ";
					}
				}
				else
				if($num==132)//Смена снарядов (активная способность, при выстреле на цель будет наложено заклинание). 
				{
					if($qua==2028)
						$up_abil[$n] .= "Смена снарядов: магический выстрел; ";
					else
					{
						$up_abil[$n] .= "Смена снарядов: заклятье при выстреле <B><font color=\"blue\">".$spell_name[$qua]."</font></B>";
						$up_abil[$n] .= " [<font color=\"fuchsia\">".trim($spell_txt[$qua])."</font>]; ";
					}
				}
				else
				if($num==133)//Защитная аура(на атакующего накладывается определённое заклинание)
				{
					if($up_need[$n] == 0)
					{
						$up_abil[$n] .= "На атакующего врукопашную накладывается заклятье <B><font color=\"blue\">".$spell_name[$qua]."</font></B>";
						$up_abil[$n] .= " [<font color=\"fuchsia\">".trim($spell_txt[$qua])."</font>]; ";
					}
				}
				else
				if($num==207)//Воин требует меньшего содержания золота
					$up_abil[$n] .= "Содержание воина <B><font color=\"red\">-".(100-$qua)."%</font></B> (золото); ";
				else
				if($num==208)//Воин требует меньшего содержания кристаллов
					$up_abil[$n] .= "Содержание воина <B><font color=\"red\">-".(100-$qua)."%</font></B> (кристаллы); ";
/*					else
					if($up_need[$n] == $num)//отмена родительской абилки
						$up_abil[$n] .= "Отмена умения <B><font color=\"fuchsia\">".$abil_name[$num]."</font></B>; ";
*/				
				else
				if(in_array($num,$abil_stamina))
				{
					$up_abil[$n] .= $abil_name[$num]." (затраты выносливости <font color=\"red\"><B>".$qua."</B></font>); ";
//					$up_abil[$n] .= ($area<=0 ? "" : ", длительность <font color=\"blue\"><B>".$area."</B></font>").($effects[$i][$j+1]['num']!="" ? "<br>" : "");
				}
				else
				if(in_array($num,$abil_xod))
				{
					$up_abil[$n] .= $abil_name[$num]." (действует <font color=\"fuchsia\"><B>$qua</font></B> ход";
					if($qua>1 && $qua<5)
						$up_abil[$n] .= "а";
					else
					if($qua>4)
						$up_abil[$n] .= "ов";
					$up_abil[$n] .= "); ";
				}
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
		$up_abil[$n] = substr($up_abil[$n],0,-2);
}
//unset($up_abil[430]);//Животное
//unset($up_abil[589]);//Леденящее касание
//Шторм Тьмы
//$up_abil[690] .= " - (При атаке врукопашную накладывается заклятье <B><font color=\"blue\">".$spell_name[350]."</font></B>)";
//$up_abil[690] .= " [<font color=\"fuchsia\">".trim($spell_txt[350])."</font>]";
//$up_abil[690].="Отмена умения <B><font color=\"fuchsia\">".$abil_name[348]."</font></B>; Шторм Тьмы";
//$up_abil[]="<B><font color=\"fuchsia\">Голод 5</B></font> - Трупоед 5";
//$up_abil[]="<B><font color=\"fuchsia\">Голод 2</B></font> - Берсерк +2";
//$up_abil[]="<B><font color=\"fuchsia\">Обездвиживание 2</B></font> - Корни <B>2</B>";
//$up_abil[]="<B><font color=\"fuchsia\">Освободить кобольда</B></font> - Стать кобольдом";
//$up_abil[]="<B><font color=\"fuchsia\">Рейнджерский выстрел -2</B></font> - Дополнительный выстрел <B>-2</B> (<font color=green><B>расход энергии уменьшен на </font><font color=blue>2</B></font>)";
//$up_abil[]="<B><font color=\"fuchsia\">Яростная атака 2</B></font> - Круговая атака <B>2</B>";

//sort($up_abil);
/*
//dumper($up_abil,"up_abil");
foreach($up_abil as $p) echo ($ttt++)." ".$p."<br>";
$p = "";
echo "<br>";
*/

//Разбор unit_upg2.var
for($i = 0,$n=0; $i < count($up2_file); $i++)
{
	if(eregi("^/([0-9]{1,})",$up2_file[$i],$k))
    {
		$n=$k[1];
    }
    else
    if(eregi("^name",$up2_file[$i]))
    {
		$s=explode(':',$up2_file[$i]);
		$s=substr(trim($s[1]),0,-1);
		if($up_name[$n] != $s)
			$up_name[$n] .= "<br><font color=\"fuchsia\">".$s."</font>";
    }
}


echo "<h3 align=\"center\">Апгрейды и способности юнитов<br></h3>";
$s=explode(':',$up_file[0]);
echo "Quantity: <B>".$s[1]."</B><br><br>";
//echo "-------------------------------------------------------------<br>";

//вывод абилок апгрейдов юнитов(unit_upg.var)
echo "<table border=1>";
for($i=1;$i<$max+1;$i++)
{
//	echo "<HR>";
//	echo "<span style='color:fuchsia'><a name=\"e".$i."\"></a><B>/".$i." <img src=i/u".$i.".gif align=center> ".$up_name[$i]."</B></span><br>";
	$num = count($up_type[$i]);
	for($j=0;$j<$num;$j++)
	{
		$type=$up_type[$i][$j];
		$qua=$up_quantity[$i][$j];
//		$aura_flag = 0;
		if($type>3000)//Аура
		{
			$type -= 3000;
			$aura_flag[$i] = 1;
		}
		if($type==64)//Повелитель нежити
		{
			$s=explode("%s",$abil_txt[$abil_num[$type]]);
			if($up_need[$i]==0)
				$abil_txt_prn[$abil_num[$type]] = $s[0]."<B><font color=\"brown\">".$u_name[$qua]."</font></B>".$s[1];
			else
				$abil_txt_prn[$abil_num[$type]] = $s[0]."<B><font color=\"brown\">".$u_name[$u_undead[$qua]]."</font></B>".$s[1];
		}
		else
		if($type==165)//Опытный лекарь
		{
			if($qua==1)
				$abil_txt_prn[$abil_num[$type]] = str_replace("%s","ход",$abil_txt[$abil_num[$type]]);
			else
				$abil_txt_prn[$abil_num[$type]] = str_replace("%s","хода",$abil_txt[$abil_num[$type]]);
		}
		else
		if($type==191)//Возрождение
		{
			$s=explode("%s",$abil_txt[$abil_num[$type]]);
			$abil_txt_prn[$abil_num[$type]] = $s[0]."<B><font color=\"brown\">".$u_name[$qua]."</font></B>".$s[1];
		}
		else
		if($type==185)//Глухая оборона
		{
			$s=explode("%d",$abil_txt[$abil_num[$type]]);
			$abil_txt_prn[$abil_num[$type]] = $s[0]."%d".$s[1]."<B><font color=\"green\">".ceil(($qua*2))."</font></B>".$s[2];
//			$abil_txt[83] = str_replace("%a","<B><font color=\"green\">".($qua/2)."</font></B>",$abil_txt[83]);
//			$abil_txt[83] = str_replace("%b","<B><font color=\"green\">".($qua*2)."</font></B>",$abil_txt[83]);
		}
		else
		if($type==131)//Сменить снаряды: удар
		{
			$s=explode("%s",$abil_txt[$abil_num[$type]]);
			$abil_txt_prn[$abil_num[$type]] = str_replace("%d","?",$s[0]."<B><font color=\"blue\">".$spell_name[$qua]."</font></B>".$s[1]);
			if($qua==2027)
				$abil_txt_prn[$abil_num[$type]] = $up_txt[$i];
		}
		else
		if($type==132)//Сменить снаряды: выстрел
		{
			$s=explode("%s",$abil_txt[$abil_num[$type]]);
			$abil_txt_prn[$abil_num[$type]] = str_replace("%d","<B><font color=\"red\">?</font></B>",$s[0]."<B><font color=\"blue\">".$spell_name[$qua]."</font></B>".$s[1]);
			if($qua==2028)
				$abil_txt_prn[$abil_num[$type]] = $up_txt[$i];
		}
		else
/*		if($type==218)//Защитная аура
		{
//		echo "@@@$abil_txt2[$type]<br>";
			$s=explode("%s",$abil_txt2[$type]);
			$abil_txt_prn[$abil_num[$type]] = $s[0]."<B><font color=\"blue\">".$spell_name[$qua]."</font></B>".$s[1];
		}
		else
*/
		if($type==907)//Сила призыва
		{
			$s=explode("%d",$abil_txt[$abil_num[$type]]);
			$abil_txt_prn[$abil_num[$type]] = $s[0]."%d".$s[1]."<B><font color=\"green\">".($qua/4)."</font></B>".$s[2];
//			$abil_txt[83] = str_replace("%a","<B><font color=\"green\">".($qua/2)."</font></B>",$abil_txt[83]);
//			$abil_txt[83] = str_replace("%b","<B><font color=\"green\">".($qua*2)."</font></B>",$abil_txt[83]);
		}
		else
			$abil_txt_prn[$abil_num[$type]] = isset($abil_txt[$abil_num[$type]]) ? $abil_txt[$abil_num[$type]] : $abil_txt2[$type];
		$replace = "<B><font color=\"";
		if($qua<0)
			$replace = "<B><font color=\"red\">".$qua."</font></B>";
		else
		if($qua>0)
			$replace = "<B><font color=\"green\">".$qua."</font></B>";
		else
			$replace = "<B>$qua</B>";
		echo "<tr>";
		if($j==0)
		{
			echo "<td align=center rowspan=$num class=bottom>$i</td>";
			echo "<td rowspan=$num class=bottom>$up_name[$i]</td>";
			echo "<td align=center rowspan=$num class=bottom><img align=center src=i/u".$i.".gif></td>";
//			echo "<td align=center rowspan=$num class=bottom></td>";
			echo "<td rowspan=$num class=bottom style='border-right:1.0pt solid black;'>$up_txt[$i]</td>";
		}
//style='border-bottom:1.0pt solid black;'
//		else
//			echo "<td></td><td></td>";
		if($j==$num-1)
		{
			echo "<td class=bottom>".$abil_name[$type]."</td><td align=center class=bottom>";
			echo "<img align=center src=i/a".($abil_num[$type]+1-1).".gif></td><td class=bottom>";
//			echo "</td><td class=bottom>";
			if($aura_flag[$i] == 1) echo "<B><font color=\"aqua\">Аура:</font></B> ";
			echo str_replace("%d",$replace,$abil_txt_prn[$abil_num[$type]]);
			echo "</td><td align=center class=bottom>".($abil_num[$type]+1-1)."</td>";//для XLA-вставки картинок
		}
		else
		{
			echo "<td>".$abil_name[$type]."</td><td align=center><img align=center src=i/a".($abil_num[$type]+1-1).".gif></td><td>";
//			echo "<td>".$abil_name[$type]."</td><td align=center></td><td>";
			if($aura_flag[$i] == 1) echo "<B><font color=\"aqua\">Аура:</font></B> ";
			echo str_replace("%d",$replace,$abil_txt_prn[$abil_num[$type]]);
			echo "</td><td align=center>".($abil_num[$type]+1-1)."</td>";//для XLA-вставки картинок
		}
		if($j==0)
			echo "<td rowspan=$num class=bottom>".$up_abil[$i]."</td>";
//		else
//			echo "<td></td>";
		echo "</tr>";
	}
/*
	echo "<tr><td><img src=i/u".$i.".gif align=center></td></tr>";
	echo "<tr><td width=2%>ID</td><td width=15%>Имя</td><td width=5%><img src=i/u".$i.".gif align=center></img></td><td width=50%>Описание</td><td width=28%>Свойства</td></tr>";
	echo "<tr><td width=5%>$i ($num)</td><td width=15%>".$up_name[$i]."</td><td width=50%>".$abil_txt[$i]."</td><td width=30%>".$up_txt[$i]."</td></tr>";
*/
}
echo "</table><br>";

//вывод эффектов (effects.var)
echo "<table border=1>";
for($i=1;$i<=$max_effects;$i++)
{
	echo "<tr><td align=center>$i</td><td>$effects_name[$i]</td><td align=center><img align=center src=i/";
//	echo isset($effects_ability[$i]) ? "a".$abil_num[$effects_ability[$i]] : "s".$effects_spell[$i];
	if(isset($effects_ability[$i]))
	{
		echo $s = "a".$abil_num[$effects_ability[$i]];
		copy("i/$s.gif","i/e$i.gif");//для XLA-вставки картинок - делаем файлы вида e1.gif из абилок/спеллов
	}
	else
	{
		echo $s = "s".$effects_spell[$i];
		copy("i/$s.gif","i/e$i.gif");//для XLA-вставки картинок - делаем файлы вида e1.gif из абилок/спеллов
	}
	echo ".gif></td><td>".$effects_txt[$i]."</td><td>";
	echo "ABIL=".($effects_ability[$i] ? $effects_ability[$i]." (".$abil_name[$effects_ability[$i]].")" : "")."<br>";
	echo "SPELL=".($effects_spell[$i] ? $effects_spell[$i]." (".$spell_name[$effects_spell[$i]].")" : "")."</td>";
	echo "</tr>";
}
echo "</table><br>";

//вывод медалей
echo "<table border=1>";
for($i=1;$i<=$medal_max;$i++)
{
	echo "<tr><td align=center>$i</td><td>$medal_name[$i]</td><td></td><td>".substr($medal_txt[$i],0,-6)."</td><td align=center>";
	echo $medal_GoldSpent[$i]."</td><td align=center>".$medal_GemSpent[$i]."</td><td align=center>".$medal_Rarity[$i]."</td><td>";
	echo substr($medal_abil[$i],0,-4)."</td></tr>";
}
echo "</table><br>";

//доп описания
$f=fopen("ability_spoil.txt","w") or die("Ошибка при создании файла ability_spoil.txt");
for($i = 0; $i < count($abil_txt_file); $i++)
{
	if(isset($abil_txt_idx[$i]))//добавка в конце
	{
		$idx = $abil_txt_idx[$i];
		fwrite($f,substr(trim($abil_txt_file[$i]),0,-1));
		if(isset($abil_txt_add[$idx]))
			fwrite($f,"\n\n".$abil_txt_add[$idx]);
		fwrite($f,"#\n");
	}
	else
		fwrite($f,$abil_txt_file[$i]);
}
fclose($f);

?>
</body></html>
