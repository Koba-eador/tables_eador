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
$a_file = file("spell.var");
$count_f = count($a_file);
$u_file = file("unit.var");
$count_u = count($u_file);
$b_file = file("inner_build.var");
$count_b = count($b_file);
$abil_file = file("ability_num.var");
$count_abil = count($abil_file);
$up_file = file("unit_upg2.var");
$count_up = count($up_file);
$spell_file = file("Spell.txt");
$count_spell = count($spell_file);
$item_file = file("item.var");
$count_item = count($item_file);
$subtype_file = file("unit_subtype.var");
$count_subtype = count($subtype_file);
$spell_event_file = file("spell_event.exp");
$spell_enc_file = file("spell_enc.exp");

//для э-педии
$spell_eadoropedia = array(1,2,4,13,20,22,23,32,38,41,44,57,58,63,64,65,66,68,78,79,86,90,97,100,103,106,116,123,
127,130,131,132,135,136,140,142,151,152,155,156,159,160,164,165,167,173,179,180,187,191,201,212,214,218,226,228,231,
232,239,240,246,250,251,254,255,256,257,261,268,270,271,278,299,300,316,352,356);
$spell_damage = array(
"4 (Жизнь)",
"5 (Выносливость)",
"9 (Жизнь)",
"6 (Боевой дух)",
"6 (Жизнь и снаряды)",
"9 (Жизнь)",
"7 (Жизнь)",
"5 (Жизнь)",
"16 (Жизнь)",
"15 (Жизнь)",
"20 (Жизнь)",
"10 (Жизнь)",
"9 (Жизнь)",
"10 (Боевой дух)",
"15 (Жизнь)",
"30 (Жизнь)",
"10 (Жизнь)",
"13 (Жизнь)",
"8 (Выносливость)",
"8 (Жизнь)",
"7 (Жизнь)",
"13 (Жизнь)",
"3 (Снаряды)",
"8 (Жизнь и снаряды)",
"3 (Жизнь)",
"6 (Жизнь)",
"15 (Жизнь)",
"12 (Жизнь)",
"10 (Жизнь)",
"6 (Жизнь)",
"18 (Жизнь)",
"16 (Жизнь)",
"4 (Жизнь)",
"5 (Выносливость)",
"15 (Жизнь)",
"15 (Жизнь)",
"10 (Жизнь)",
"15 (Жизнь)",
"10 (Жизнь)",
"20 (Жизнь)",
"12 (Жизнь)",
"15 (Жизнь)",
"12 (Жизнь)",
"10 (Жизнь)",
"12 (Жизнь)",
"16 (Жизнь)",
"20 (Боевой дух)",
"8 (Боевой дух)",
"2 (Выносливость)",
"2 (Боевой дух)<br>4 (Жизнь)",
"8 (Жизнь и снаряды)",
"50 (Жизнь)",
"12 (Выносливость)",
"12 (Жизнь)",
"8 (Боевой дух)",
"15 (Жизнь)",
"5 (Жизнь)",
"10 (Жизнь)",
"15 (Жизнь)",
"10 (Жизнь)",
"5 (Выносливость)",
"14 (Боевой дух)",
"20 (Жизнь)",
"30 (Жизнь)",
"20 (Жизнь)",
"9 (Жизнь)",
"15 (Жизнь)",
"4 (Боевой дух)",
"15 (Жизнь)",
"12 (Жизнь)",
"15 (Жизнь)",
"3 (Боевой дух)<br>3 (Жизнь)<br>3 (Выносливость)",
"6 (Боевой дух)",
"3 (Жизнь)",
"5 (Жизнь)",
"7 (Жизнь)",
"4 (Боевой дух)");

$abil_name[73]="Юнит под контролем";
$abil_name[74]="Реинкарнация";
$abil_name[75]="Дополнительный ход";
$abil_name[89]="Телепорт";
$abil_name[91]="Тёмный Пакт";
$abil_numeric[91]=1;
$abil_name[92]="Удвоенный урон себе";
$abil_numeric[92]=1;
$abil_name[93]="Снимает отравление и кровотечение. Уменьшает время гниения ран на <font color=\"green\"><B>1</B></font>";
//$abil_name[148]="Запас снарядов (с передачей трети уничтоженных кастующему)";
//$abil_numeric[148]=1;
$abil_name[149]="Запрет кастующему на применение магии";
$abil_name[151]="Обнуление дистанционной атаки";
$abil_name[152]="Запрет целительства";
$abil_name[159]="Оплетение корнями";
$abil_name[183]="Двойной выстрел без затраты доп. выносливости";
//$abil_name[192]="Нельзя сжечь снаряды или восполнить их";
$abil_name[211]="Изменение боевого духа каждый ход";
$abil_numeric[211]=1;
$abil_name[223]="Длительность заклинаний (+/- на своих/чужих)";
$abil_numeric[223]=1;
$abil_name[225]="Каменная корка";
$abil_name[233]="Анимация священного шока";
$abil_name[241]="Анимация яда";
$abil_name[242]="Анимация взрыва";
$abil_name[243]="Анимация большого взрыва";
$abil_name[244]="Анимация электричества";
$abil_name[245]="Анимация порчи";
$abil_name[246]="Анимация огненного дождя";
$abil_name[247]="Анимация камнепада";
$abil_name[248]="Анимация малого разряда электричества";
$abil_name[252]="Особые эффекты второго хода";
$abil_name[280]="Духовная связь";
//$abil_name[285]="Цепь жизни";
//$abil_numeric[285]=1;
$abil_name[299]="Ходил дважды за один раунд";

$unit_abil_spell = array(189,129,130,131,132,133); //массив абилок, позволяющих юнитам пользоваться магией
/*
способность накладывать на себя заклинание через кнопку на панели
накладывать заклинание при ударе
накладывать заклинание при выстреле
Смена оружия (включаемое наложение заклинания при ударе/выстреле)
Смена снарядов (включаемое наложение заклинания при ударе/выстреле)
Защитная аура (на атакующего накладывается определённое заклинание)
*/
$unit_abil_meelee = array(16=>213,186=>142,362=>177,30=>178,21=>179); //заклы, накладываемые рукопашной атакой
/*
142. Сейсмозаряд (активная способность).
-176. Насылает проказу (при рукопашной атаке накладывается заклинание "Проказа"). 
177. Насылает лихорадку (при рукопашной атаке накладывается заклинание "Лихорадка"). 
178. Насылает чахотку (при рукопашной атаке накладывается заклинание "Чахотка"). 
179. Насылает уязвимость (при рукопашной атаке накладывается заклинание "Уязвимость"). 
213. Снятие чар (используется в Spell.var). Дополнительно позволяет каждым выстрелом понижать длительность полезных заклинаний на противнике. 
*/

$abil_xod = array(45,52,69,127,128,134,135,137);//абилки, которые висят несколько ходов
//Повреждение брони,Повреждение оружия,Тяжёлые снаряды,Калечащий удар,Калечащий выстрел,Повреждение ауры,Астральные снаряды,Насылает гниение

$abil_stamina = array(20,59,66,78,79);//абилки, которые тратят выносливость
//Дополнительный выстрел,Сокрушающий удар,Круговая атака,Снайперский выстрел,Мощный выстрел

//$unit_type=array(1=>"Смертный","Нежить","Демон","Механический","Герой");
$abil_negative=array(1,10,11,12,148); //кто меняет знак от параметра Negative

$max=0;$max1=0;$max_u=0;$max_e=0;$t[0]=0;$j=0;
$u1=-1;$u2=0;$u3=0;	//№ строки юнита в xls
$g1=0; //кол-во стражей в одном сайте
$a1=0; //№ абилки
$a2=0; //№ эффекта ritual
$e1=0; //№ эффекта
$up1=0; //число upg_type в unit_upg
$u_a=0; //абилки in unit.var
$p=""; //для печати без последней ";"

//разбор spell_event.exp
for($i = 0; $i < count($spell_event_file); $i++)
{
	$str = trim($spell_event_file[$i]);
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
			$EventGroupName[$s[1]] = $s[2];//имя группы событий для получения заклов
			$spell_event_cnt[$s[0]] = $s[3];//к-во заклов
		}
	}
}

foreach($export_spell_event_scroll as $spell => $ev)
{
	foreach($ev as $i)
	{
			$p = "";
			$cnt = $spell_event_cnt[$spell];
			$p .= "Можно получить <B><font color=\"blue\">".$cnt." </font></B>";
			if($cnt==1)
				$p .= "свиток";
			else
			if($cnt>1 && $cnt<5)
				$p .= "свитка";
			else
				$p .= "свитков";
			$p .= " заклинания от <B>группы событий (group_event) <font color=\"blue\">$i (".$EventGroupName[$i].")</font></B>";
			$spell_add[$spell][] = $p;//доп. способы получения свитков заклинания
	}
}

//разбор spell_enc.exp
for($i = 0; $i < count($spell_enc_file); $i++)
{
	$str = trim($spell_enc_file[$i]);
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
			$EncGroupName[$s[1]] = $s[2];//имя группы приключений для получения заклов
			$spell_enc_cnt[$s[0]] = $s[3];//к-во заклов
		}
	}
}

foreach($export_spell_enc_scroll as $spell => $enc)
{
	foreach($enc as $i)
	{
			$p = "";
			$cnt = $spell_enc_cnt[$spell];
			$p .= "Можно получить <B><font color=\"blue\">".$cnt." </font></B>";
			if($cnt==1)
				$p .= "свиток";
			else
			if($cnt>1 && $cnt<5)
				$p .= "свитка";
			else
				$p .= "свитков";
			$p .= " заклинания от <B>группы приключений (group_enc) <font color=\"blue\">$i (".$EncGroupName[$i].")</font></B>";
			$spell_add[$spell][] = $p;//доп. способы получения свитков заклинания
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
/*
for($i=1;$i<2000;$i++)
{
	if($abil_name[$i] != "")
		echo "$i - $abil_name[$i]<br>";
}
*/

//Разбор Spell.txt
for($i = 0; $i < $count_spell; $i++)
{  
    if(eregi("^([0-9]{1,})",$spell_file[$i],$k))
    {
		$n=$k[1];
    }
    else
//	if(!eregi("^#Круг",$spell_file[$i]))
//	{
	if(substr($spell_file[$i],0,1)=="#")
	{
	    $spell_txt[$n]=$spell_txt[$n].substr($spell_file[$i],1)."<br>";
		$spell_txt_idx[$n] = $i;//в какую строку добавлять спойлеры о карме/коррупции
		$spell_txt_idx2[$i+1] = $n;//в какую строку добавлять спойлеры о PowerMod и др.
	}
	else
	    if(substr(trim($spell_file[$i]),-1,1)=="#")
	    {
			$spell_txt[$n] .= substr(trim($spell_file[$i]),0,-1);
			$i++;
	    }
	    else
			$spell_txt[$n] .= $spell_file[$i]."<br>";
//echo $n."-".strlen
//	}
	$spell_txt[$n] = str_replace("~","%",$spell_txt[$n]);
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
    if(eregi("^Building:",$item_file[$i]))
    {
		$s=explode(':',$item_file[$i]);
		if(($s[1]+1-1)!=0)
			$item_build[$n]=$s[1]+1-1;
    }
	else
    if(eregi("^Power:",$item_file[$i]))//разбор effects: item.var,spell.var
    {
		$s=explode(':',$item_file[$i-1]);
//		$effects[$n][$e1]['num']=$s[1]+1-1;	//массив № эффектов
		$s1=explode(':',$item_file[$i]);
//		$effects[$n][$e1]['power']=$s[1]+1-1;	//массив power, FlagEffect
		if(($s[1]+1-1) == 83) //spell
		{
//			$build_unit[$s1[1]+1-1]=$build_unit[$s1[1]+1-1].
			$build_table[$s1[1]+1-1] .= $build_name[$item_build[$n]]." (продажа свитка)";//постройка для свитков заклинаний
		}
//echo $n."-e1=".$e1." NUM=".$effects[$n][$e1]['num']." POWER=".$effects[$n][$e1]['power']." AREA=".$effects[$n][$e1]['area']."<br>";
    }
}

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
		$up_name[$n]=substr(trim($s[1]),0,-1);
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
		for($j=0;$j<16;$j++)
		{
			$s=explode(':',$up_file[$i]);
			$up_type[$n][$j]=$s[1]+1-1;	
			$i++;
			$s1=explode(':',$up_file[$i]);
			$up_quantity[$n][$j]=$s1[1]+1-1;
//echo $n." j=".$j." TYPE=".$up_type[$n][$j]." QUA=".$up_quantity[$n][$j]."<br>";
			if(substr(trim($up_file[$i]),-1,1)==";") break; //for
			$i++;
//		if(trim($up_file[$i])=="") {$i++;break;} //пустая строка
			$i++;
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
		$s = $s2 = trim(substr(trim($s[1]),0,-1));
		if(in_array($n,array_merge(range(40,43),range(238,253),range(263,278))))//апы героя
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
    if(eregi("^Abilityes:",$u_file[$i]))
    {
//echo $n."-".$u_file[$i]."<br>";
		$i++;
		for($j=0;$j<20;$j++)
		{
			$s=explode(':',$u_file[$i]);
			$u_abil[$n][$j]=$s[1]+1-1;	//массив № абилок
			$u_abil2[$n][$s[1]+1-1]['count']+=1; //кол-во одинаковых абилок
			$u_abil2[$n][$s[1]+1-1]['lvl']=-1; //мин левел одинаковых абилок, -1=изначально имеющаяся
//echo $n." NUM=".($s[1]+1-1)." COU=".$u_abil2[$n][$s[1]+1-1]['count']."<br>";

//		$u_a++;

			for($jj=0;$jj<16;$jj++) //сканируем unit_upg.var для поиска маг.юнитов
			{
//echo $n." UP_TYPE=".$up_type[$u_abil[$n][$j]][$jj]."<br>";
				if($up_type[$u_abil[$n][$j]][$jj]>2000 && $up_quantity[$u_abil[$n][$j]][$jj]>=0) //для юнитов с маг.книгой
				{
					$sp=$up_type[$u_abil[$n][$j]][$jj]-2000; //№ заклининия
					if(!in_array($sp,$spell_array[$n]))//убираем дубли
					{
						$spell_array[$n][] = $sp;
						$spell_unit[$sp] .= "<B><font color=\"brown\">".$u_name[$n]."</font></B>(<B><font color=\"blue\">0</font></B>); ";
						$spell_unit2[$sp] .= $u_name2[$n]."(0); ";
					}
//echo $sp." ".$spell_unit[$sp]."<br>";
				}
				else
				if(in_array($up_type[$u_abil[$n][$j]][$jj],$unit_abil_spell)) //массив абилок, позволяющих юнитам пользоваться магией
				{
					if($up_need[$u_abil[$n][$j]] == 0)
					{
						$sp=$up_quantity[$u_abil[$n][$j]][$jj]; //№ заклининия
						if(!in_array($sp,$spell_array[$n]))//убираем дубли
						{
							$spell_array[$n][] = $sp;
							$spell_unit[$sp] .= "<B><font color=\"brown\">".$u_name[$n]."</font></B>(<B><font color=\"blue\">0</font></B>); ";
							$spell_unit2[$sp] .= $u_name2[$n]."(0); ";
						}
					}
//echo $sp." ".$spell_unit[$sp]."<br>";
				}
				else
				if($idx=array_search($up_type[$u_abil[$n][$j]][$jj],$unit_abil_meelee)) //заклы, накладываемые рукопашной атакой
				{
					if($up_need[$u_abil[$n][$j]] == 0)
					{
//						$sp=$up_quantity[$u_abil[$n][$j]][$jj]; //№ заклининия
						if(!in_array($idx,$spell_array[$n]))//убираем дубли
						{
							$spell_array[$n][] = $idx;
							$spell_unit[$idx] .= "<B><font color=\"brown\">".$u_name[$n]."</font></B>(<B><font color=\"blue\">0</font></B>); ";
							$spell_unit2[$idx] .= $u_name2[$n]."(0); ";
						}
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
		for($j=1;$j<=20;$j++)
		{
			$s=explode(':',$u_file[$i]);	// Lvl 01 upgrades: (3, 4; 4, 4; 13, 4)
//echo $n." ".$j." s=".$s[1];
			$s1=explode(';',$s[1]);		// (3, 4; 4, 4; 13, 4)
//echo " s1=".$s1[0]." ".$s1[1]." ".$s1[2]." ".$s1[3]." ".$s1[4]." ".$s1[5]." ".$s1[6]." ".$s1[7]."<br>";
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
				$uu=$s2[0]+1-1;
				$u_abil_lvl[$n][$j][$jj]=$uu;		// 3
				$u_abil2[$n][$uu]['count']+=1;
//			if(($u_abil2[$n][$uu]['lvl']=="") || ($u_abil2[$n][$uu]['lvl']==0))
				if($u_abil2[$n][$uu]['count']==1)
					$u_abil2[$n][$uu]['lvl']=$j;
//echo $n." uu=".$uu." (".$up_name[$uu].") JJ=".$jj." COU=".$u_abil2[$n][$uu]['count']." LVL=".$u_abil2[$n][$uu]['lvl']."<br>";



				for($jjj=0;$jjj<16;$jjj++) //сканируем unit_upg.var для поиска маг.юнитов
				{
//echo $n." jjj=".$jjj." type=".$up_type[$uu][$jjj]."<br>";
					if($up_type[$uu][$jjj]>2000 && $up_quantity[$uu][$jjj]>=0) //для юнитов с маг.книгой
					{
						$sp=$up_type[$uu][$jjj]-2000; //№ заклининия
						if(!in_array($sp,$spell_array[$n]))//убираем дубли
						{
							$spell_array[$n][] = $sp;
							$spell_unit[$sp] .= "<B><font color=\"brown\">".$u_name[$n]."</font></B>(<B><font color=\"blue\">".$j."</font></B>); ";
							$spell_unit2[$sp] .= $u_name2[$n]."($j); ";
						}
//echo $n." jjj=".$jjj." type=".$up_type[$uu][$jjj]." sp=".$sp." ".$spell_unit[$sp]."<br>";
					}
					else
					if(in_array($up_type[$uu][$jjj],$unit_abil_spell)) //массив абилок, позволяющих юнитам пользоваться магией
					{
						if($up_need[$uu] == 0)
						{
							$sp=$up_quantity[$uu][$jjj]; //№ заклининия
							if(!in_array($sp,$spell_array[$n]))//убираем дубли
							{
								$spell_array[$n][] = $sp;
								$spell_unit[$sp] .= "<B><font color=\"brown\">".$u_name[$n]."</font></B>(<B><font color=\"blue\">$j</font></B>); ";
								$spell_unit2[$sp] .= $u_name2[$n]."($j); ";
							}
						}
//echo $sp." ".$spell_unit[$sp]."<br>";
					}
					else
					if($idx=array_search($up_type[$uu][$jjj],$unit_abil_meelee)) //заклы, накладываемые рукопашной атакой
					{
						if($up_need[$uu] == 0)
						{
//							$sp=$up_quantity[$u_abil[$n][$j]][$jj]; //№ заклининия
							if(!in_array($idx,$spell_array[$n]))//убираем дубли
							{
								$spell_array[$n][] = $idx;
								$spell_unit[$idx] .= "<B><font color=\"brown\">".$u_name[$n]."</font></B>(<B><font color=\"blue\">$j</font></B>); ";
								$spell_unit2[$idx] .= $u_name2[$n]."($j); ";
							}
						}
					}
				}



			}
			$i++;
		}
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
		if($n != 0)
			$unit_subtype[$n]=substr(trim($s[1]),0,-1);
    }
}

//-------------------------------------------------------------
//Разбор основного файла
for($i = 0,$n=0; $i < $count_f; $i++)
{  //echo "<br>".$a_file[$i];
	if(eregi("^/([0-9]{1,})",$a_file[$i],$k))
	{
		$n=$k[1];
		if($n>$max)$max=$n;
		$u1++;	//№ строки
    }
	else
    if(eregi("^Name:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
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
		while(in_array($s,$name_table))
		{
			echo $n."- Дубль NAME=".$s;
			$s = $s."<font color=\"fuchsia\">*</font>";
			echo " <B>Замена на</B> ".$s."<br>";
		}
		$name_table[$n]=$s;
		$name_table_prn[$n]=str_replace("Стремительность", "Стремитель-ность",$s);
		$name_table_prn[$n]=str_replace("Землепроходчество", "Землепроход-чество",$name_table_prn[$n]);
		$name_table_prn[$n]=str_replace("хладоустойчивость", "хладоустой-чивость",$name_table_prn[$n]);
		$name_table_prn[$n]=str_replace("Самопожертвование", "Самопожертво-вание",$name_table_prn[$n]);
//		$name_table[$n]=substr(trim($s[1]),0,-1);
    }
/*
    else
    if(eregi("^Power:",$a_file[$i]))//разбор effects: item.var,spell.var
    {
		$s=explode(':',$a_file[$i-1]);
		$effects[$n][$e1]['num']=$s[1]+1-1;	//массив № эффектов
		$s=explode(':',$a_file[$i]);
		$effects[$n][$e1]['power']=$s[1]+1-1;	//массив power, FlagEffect
		$s=explode(':',$a_file[$i+1]);
		$effects[$n][$e1]['area']=$s[1]+1-1;	//массив area, Duration, FlagEffect
//echo $n."-e1=".$e1." NUM=".$effects[$n][$e1]['num']." POWER=".$effects[$n][$e1]['power']." AREA=".$effects[$n][$e1]['area']."<br>";
		$e1++;
    }
*/
    else
    if(eregi("^Cost:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$cost_table[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^LifeCost:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		if(($s[1]+1-1) != 0)
			$lifecost_table[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^StamCost:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$stamcost_table[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^ItemLevel:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$itemlevel_table[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^Level:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$level_table[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^PowerMod:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$powermod_table[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^DurationMod:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$durationmod_table[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^Target:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$target_table[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^Area:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$area_table[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^Radius:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$radius_table[$n]=$s[1]+1-1;
    }
	else
	if(eregi("^Karma:",$a_file[$i]))
	{
		$s=explode(':',$a_file[$i]);
		$spell_karma[$n]=$s[1]+1-1;
		if($spell_karma[$n] != 0)
			$karma_flag[$spell_txt_idx[$n]] = $s[1]+1-1;//№ строки в spell.txt, куда надо вставить спойлер о карме
	}	
/*
    else
    if(eregi("^FlagEffect:",$a_file[$i]))//разбор effects: spell.var
    {
		$effects[$n][$e1]['flag']=1;	//нестандартный эффект spell.var
		$s=explode(':',$a_file[$i-1]);
		$effects[$n][$e1]['num']=$s[1]+1-1;	//массив № эффектов
//echo "$n $effects[$n][$e1]['flag'] $effects[$n][$e1]['num']";
		$s=explode(':',$a_file[$i]);
		$effects[$n][$e1]['power']=$s[1]+1-1;	//массив power, FlagEffect
		$s=explode(':',$a_file[$i+1]);
		$effects[$n][$e1]['area']=$s[1]+1-1;	//массив area, Duration, FlagEffect
//echo $n."-e1=".$e1." NUM=".$effects[$n][$e1]['num']." POWER=".$effects[$n][$e1]['power']." AREA=".$effects[$n][$e1]['area']." ".$effects[$n][$e1]['flag']."<br>";
		$e1++;
		$i++;
    }
*/
    else
    if(eregi("^Building:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$s1 = $s[1]+1-1;
		if($s1>0)
			$build_table[$n] .= $build_name[$s1];
		else
		if($s1<0)
			$build_table[$n] .= $build_name[-$s1]." (продажа свитка)";
    }
    else
    if(eregi("^Negative:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$negative_table[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^OnEnemy:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$on_enemy_table[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^OnAlly:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$on_ally_table[$n]=$s[1]+1-1;
    }
 	else
	if(eregi("^Sacrifice:",$a_file[$i]))
	{
		$s=explode(':',$a_file[$i]);
		$sacrifice_table[$n]=$s[1]+1-1;
	}	
 	else
	if(eregi("^ResistPower:",$a_file[$i]))
	{
		$s=explode(':',$a_file[$i]);
		$resistpower_table[$n]=$s[1]+1-1;
	}	
 	else
	if(eregi("^ResistDuration:",$a_file[$i]))
	{
		$s=explode(':',$a_file[$i]);
		$resistduration_table[$n]=$s[1]+1-1;
	}	
 	else
	if(eregi("^DefencePower:",$a_file[$i]))
	{
		$s=explode(':',$a_file[$i]);
		$defencepower_table[$n]=$s[1]+1-1;
	}	
 	else
	if(eregi("^RestoreOnly:",$a_file[$i]))
	{
		$s=explode(':',$a_file[$i]);
		$restoreonly_table[$n]=$s[1]+1-1;
	}	
 	else
	if(eregi("^Cumulative:",$a_file[$i]))
	{
		$s=explode(':',$a_file[$i]);
		$cumulative_table[$n]=$s[1]+1-1;
	}	
 	else
	if(eregi("^Unloot:",$a_file[$i]))
	{
		$s=explode(':',$a_file[$i]);
		$unloot_table[$n]=$s[1]+1-1;
	}	
	else
    if(eregi("^AntiEffect:",$a_file[$i]))
    {
		$s=explode('(',$a_file[$i]);
//echo $n."-".$s[0]."--".$s[1]."---".$s[2]."<br>";
		$s1=explode(',',$s[1]);
//echo $n."-".($s1[0]+1-1)."--".($s1[1]+1-1)."---".($s1[2]+1-1)."<br>";
		for($j=0;(($s1[$j]+1-1)!=0) && ($j<=10);$j++)
		{
			$antieffect[$n] .= $abil_name[$s1[$j]+1-1].(($s1[$j+1]=="") ? "" : ";<br>");
			$antieffect2[$n] .= $abil_name[$s1[$j]+1-1].(($s1[$j+1]=="") ? "" : "; ");
		}
//echo $n."-".$unit_kind[$n]."<br>";
    }
    else
    if(eregi("^Effects:",$a_file[$i]))//разбор effects: spell.var
    {
		for($j=0;$j<16;$j++) //тройки эффектов
		{
			while(1)
				if(trim($a_file[$i+1]) == "") //пустая строка
					$i++;
				else
					break;
			$i++;
			$s=explode(':',$a_file[$i]);
			$num = $effects[$n][$e1]['num'] = $s[1]+1-1;	//массив № эффектов
			$i++;
			$s=explode(':',$a_file[$i]);
			$power = $effects[$n][$e1]['power'] = $s[1]+1-1;	//массив power, FlagEffect
			$i++;
			$s=explode(':',$a_file[$i]);
			$effects[$n][$e1]['area'] = $s[1]+1-1;	//массив area, Duration, FlagEffect
			if($num==70)//Сон
			{
				$effects[$n][$e1]['flag']=$power;	//нестандартный эффект spell.var
			}
			else
			if($num==71)//Похищение жизни
			{
				$effects[$n][$e1]['flag']=$power;	//нестандартный эффект spell.var
			}
			else
			if($num==72)//Белая магия
			{
				$effects[$n][$e1]['flag']=$power;	//нестандартный эффект spell.var
			}
			else
			if($num==251)//Особые эффекты призыва существа (несколько за каст)
			{
				$effects[$n][$e1]['flag']=$power;	//нестандартный эффект spell.var
			}
			else
			if($num==298)//способность 298 - количество восполняемых магом снарядов становится равно значению способности
			{
				$effects[$n][$e1]['flag']=$power;	//нестандартный эффект spell.var
			}
/*
		$effects[$n][$e1]['flag']=1;	//нестандартный эффект spell.var
		$i++;
		$s=explode(':',$a_file[$i]);
		$effects[$n][$e1]['num']=$s[1]+1-1;	//массив № эффектов
//echo "$n $effects[$n][$e1]['flag'] $effects[$n][$e1]['num']";
		$s=explode(':',$a_file[$i]);
		$effects[$n][$e1]['power']=$s[1]+1-1;	//массив power, FlagEffect
		$s=explode(':',$a_file[$i+1]);
		$effects[$n][$e1]['area']=$s[1]+1-1;	//массив area, Duration, FlagEffect
//echo $n."-e1=".$e1." NUM=".$effects[$n][$e1]['num']." POWER=".$effects[$n][$e1]['power']." AREA=".$effects[$n][$e1]['area']." ".$effects[$n][$e1]['flag']."<br>";
*/
			$e1++;
			$i++; //пустая строка
			if(substr(trim($a_file[$i-1]),-1,1)==";") 
			{
				break; //for $j
			}
 		}
	}
	else
    if(eregi("^UnitKind:",$a_file[$i])) //spell.var
    {
		$s=explode('(',$a_file[$i]);
//echo $n."-".$s[0]."--".$s[1]."---".$s[2]."<br>";
		$s1=explode(',',$s[1]);
//echo $n."-".($s1[0]+1-1)."--".($s1[1]+1-1)."---".($s1[2]+1-1)."<br>";
		$krome = 0;//Флаг: Действует на всех, кроме
		$p = "";
		$p2 = "";//для расширенного описания
		for($j=0;($s1[$j]!="") && ($j<10);$j++)
		{
//			$unit_kind[$n] .= (($s1[$j]+1-1)<0 ? "Действует только на <font color=\"blue\"><B>".$unit_subtype[-$s1[$j]+1-1]."</B></font>" : $unit_subtype[$s1[$j]+1-1]).(($s1[$j+1]=="") ? "" : ";<br>");
			if(($s1[$j]+1-1)<0)
			{
				if($krome != 1)
				{
					$p .= "Действует только на <font color=\"blue\"><B>".$unit_subtype[-$s1[$j]+1-1]."</B></font>";
					$p2 .= "Действует только на ".$unit_subtype[-$s1[$j]+1-1];
				}
				else
				{
					$p .= " и <font color=\"blue\"><B>".$unit_subtype[-$s1[$j]+1-1]."</B></font>";
					$p2 .= " и ".$unit_subtype[-$s1[$j]+1-1];
				}
				$krome = 1;
				$kind = $s1[$j]+1-1;//Флаг: Не действует ни на кого, н-р UnitKind: (-14, 14)
			}
			else
			{
				if($krome == 1)//уже есть квантор
				{
					if($kind == (-$s1[$j]+1-1))
						$p = $p2 = "Не действует ни на кого";
					else
					{
						$p .= ", кроме ".$unit_subtype[$s1[$j]+1-1];
						$p2 .= ", кроме ".$unit_subtype[$s1[$j]+1-1];
					}
				}
				else
				{
					$p .= (($j==0) ? "" : ";<br>").$unit_subtype[$s1[$j]+1-1];
					$p2 .= (($j==0) ? "" : "; ").$unit_subtype[$s1[$j]+1-1];
				}
			}
		}
		$unit_kind[$n] = $p;
		$unit_kind2[$n] = $p2;
//echo $n."-".$unit_kind[$n]."<br>";
    }
}
//------------------------------------------------------------
//конец работы с файлом
//echo "u1=".$u1." u2=".$u2." u3=".$u3."<br>";
//for($i=1;$i<$u1;$i++)echo $str_num[$i]."-".$u_table1[$i]." ";
//dumper($build_table,"build_table");
echo "<table border=1>";
/*
for($i=0;$i<$max+1;$i++)
{
//вывод unitkind
	echo "<tr><td>$i ($name_table[$i])</td><td>".$unit_kind[$i]."</td></tr>";
}

for($i=0;$i<$max+1;$i++)
{
//вывод AntiEffect
	echo "<tr><td>$i ($name_table[$i])</td><td>$antieffect[$i]</td></tr>";
}

for($i=0;$i<$max+1;$i++)
{
//вывод юнитов с магией
	echo "<tr><td>".$i." ($name_table[$i])</td><td>".substr($spell_unit[$i],0,strlen($spell_unit[$i])-2)."</td></tr>";
}
*/
for($i=0;$i<$max+1;$i++)
{
//вывод области действия
	if($target_table[$i]==0)
	{
		if($area_table[$i]==0)
		{
			if($radius_table[$i]==0)
				$spell_target[$i]="Только на себя";
			else
			{
				if($on_ally_table[$i]==0)
				{
					$spell_target[$i]="Все враги вокруг заклинателя в радиусе <font color=\"blue\"><B>".$radius_table[$i]."</B></font> ";
					$spell_target2[$i]="Область вокруг ($radius_table[$i])";
					if($radius_table[$i]==1)
						$spell_target[$i] .= "клетки";
					else
						$spell_target[$i] .= "клеток";
				}
				else
				{
					$spell_target[$i]="На себя и площадь вокруг радиусом <font color=\"blue\"><B>".$radius_table[$i]."</B></font> ";
					if($radius_table[$i]==1)
						$spell_target[$i] .= "клетка";
					else
						$spell_target[$i] .= "клетки";
				}
			}
		}
		else
		if($area_table[$i]==1)
			$spell_target[$i]="Все трупы на поле";
		else
		{
			$spell_target[$i]="Все воины на поле";
			$spell_target2[$i]="Все";
		}
	}
	else
	if($target_table[$i]==1)
	{
		$spell_target[$i]="Единичная цель";
		$spell_target2[$i]="Цель";
	}
	else
	if($target_table[$i]==3)
	{
		$spell_target[$i]="Площадь радиусом <font color=\"blue\"><B>".$radius_table[$i]."</B></font> ";
		$spell_target2[$i]="Область ($radius_table[$i])";
		if($radius_table[$i]==1)
			$spell_target[$i] .= "клетка";
		else
			$spell_target[$i] .= "клетки";
	}
	else
	if($target_table[$i]==4)
	{
		$spell_target[$i]="Труп на поле";
	}
	else
		$spell_target[$i]="Кастующий";
}

//EFFECTS spell
for($i=0,$j=1;$i<$max+1;$i++)
{ 
//	echo "<tr><td>$i ($name_table[$i])</td><td>";
	for($n=1;($effects[$i][$j]['num']!="")&&($j<10000);$j++,$n++)
	{
	    if($spell_not_count[$i]!=1) $p .= $n.") ";
	    $num=$effects[$i][$j]['num'];
		if($num>3000)//Аура
		{
			$num -= 3000;
			$effects[$i][$j]['num'] = $num;
			$p .= "<B><font color=\"aqua\">Аура:</B></font> ";
		}
	    $power=$effects[$i][$j]['power'];
	    $area=$effects[$i][$j]['area'];
//echo "$i $num $power $area $abil_name[$num] flag=".$effects[$i][$j]['flag']." target=".$target_table[$i]."<br>";
	    if(isset($effects[$i][$j]['flag']))//нестандартный эффект spell.var с FlagEffect
	    {
			$spell_not_count[$i]=1;
			$flag=$effects[$i][$j]['flag'];
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
			else
//			if($num==148)//Передача снарядов от цели к заклинателю, если есть способность 298 - количество восполняемых магом снарядов становится равно значению способности
			if($num==298)//Передача снарядов от цели к заклинателю, если есть способность 298 - количество восполняемых магом снарядов становится равно значению способности
			{
				$p .= "Запас снарядов <B><font color=\"red\">".-$power."</font></B> (с передачей <B><font color=\"green\">".$flag."</B></font> снаряд";
				if($flag == 1)
					$p .= "а";
				else
					$p .= "ов";
				$p .= " от цели к заклинателю)".($effects[$i][$j+1]['num']!="" ? "<br>" : "");
				$flag_298[$i] = 1;//некрасивый флаг-заглушка, если будет абилка №148 без №298
			}
			else
			if($num==251) //Особые эффекты призыва существа (несколько за каст)
			{
//				$p .= "Выделение до <B>".($power+1)."</B> тайлов для призываемых юнитов;<br>";
				$p .= "Призыв <B>".($power+1)."</B> существ <font color=\"brown\"><B>".$u_name[$effects[$i][$j+1]['num']-1000]."</B></font> на соседнем с магом тайле";
				$j++;$n++;//пропускаем следующий эффект (где по идее должен быть саммон конкретных существ)
			}
	    }
	    else
	    if($num>1000)
		{
			if($area<=0)
			{
				if(($target_table[$i]==4) || ($target_table[$i]==0 && $area_table[$i]==1)) //труп
					$p .= "Подъятие существа <font color=\"brown\"><B>".$u_name[$num-1000]."</B></font>";
				else
					$p .= "Призыв существа <font color=\"brown\"><B>".$u_name[$num-1000]."</B></font>";
			}
			else
				$p .= "Превращение в существо <font color=\"brown\"><B>".$u_name[$num-1000]."</B></font>, длительность <font color=\"blue\"><B>".$area."</B></font>";
			$p .= ($power>0 ? " (сила <font color=\"fuchsia\"><B>$power</B></font>)" : "").($effects[$i][$j+1]['num']!="" ? "<br>" : "");
		}
/*		else
		if($num>3000)//аура
		{
			$p .= "<B><font color=\"aqua\">Аура:</B> "
		}
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
*/	    else
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
			$p .= ($area<=0 ? "" : ", длительность <font color=\"blue\"><B>$area</B></font>").($effects[$i][$j+1]['num']!="" ? "<br>" : "");		
		}
	    else
	    if($num==10) //Запас снарядов
		{
			if(($negative_table[$i]==1) && (in_array($num,$abil_negative)))
			{
				if($on_ally_table[$i]!=0 && $on_enemy_table[$i]==0)//своим - положительные, если Negative==1 и $power<0
					$p .= $abil_name[$num].($power<0 ? " <font color=\"green\"><B>+".abs($power)."</B></font>" : " <font color=\"red\"><B>-$power</B></font>").($effects[$i][$j+1]['num']!="" ? "<br>" : "");			
				else
					$p .= $abil_name[$num].($power<0 ? " <font color=\"red\"><B>$power</B></font>" : " <font color=\"red\"><B>-$power</B></font> (с аналогичным уроном)").($effects[$i][$j+1]['num']!="" ? "<br>" : "");
			}
			else
				$p .= $abil_name[$num].($power<0 ? " <font color=\"red\"><B>$power</B></font>" : " <font color=\"green\"><B>+$power</B></font>").($effects[$i][$j+1]['num']!="" ? "<br>" : "");
		}
/*
	    else
	    if($num==20) //Дополнительный выстрел
		{
			$p .= $abil_name[$num]." (<font color=\"green\"><B>расход энергии ".($power>=0 ? "</font><font color=\"blue\">$power" : "уменьшен на </font><font color=\"blue\">".abs($power))."</B></font>)".($effects[$i][$j+1]['num']!="" ? "<br>" : "");
			$p .= ($area<=0 ? "" : ", длительность <font color=\"blue\"><B>$area</B></font>").($effects[$i][$j+1]['num']!="" ? "<br>" : "");		
	    }
*/
	    else
	    if($num==47) //Паутина
			$p .= $abil_name[$num].", длительность <font color=\"blue\"><B>".$area."</B></font>".($effects[$i][$j+1]['num']!="" ? "<br>" : "");
		else
	    if($num==73) //MindControl
		{
			if($area == -1)
				$p .= $abil_name[$num].", сопротивление цели не выше <font color=\"green\"><B>".$power;
			else
				$p .= $abil_name[$num].", длительность <font color=\"blue\"><B>".$area;
			$p .= "</B></font>".($effects[$i][$j+1]['num']!="" ? "<br>" : "");
		}
	    else
	    if($num==74) //Reincarnation
			$p .= $abil_name[$num].", длительность <font color=\"blue\"><B>".$area."</B></font>".($effects[$i][$j+1]['num']!="" ? "<br>" : "");
	    else
	    if($num==91) //Тёмный Пакт
			$p .= $abil_name[$num].", длительность <font color=\"blue\"><B>".$area."</B></font>".($effects[$i][$j+1]['num']!="" ? "<br>" : "");
	    else
	    if($num==92) //Суицид
			$p .= $abil_name[$num].", сила <font color=\"green\"><B>".$power."</B></font>".($effects[$i][$j+1]['num']!="" ? "<br>" : "");
		else
		if($num==115)//позволяющий заклинанию действовать на юнита, игнорируя все запреты
		{
			$p .= "Позволяет заклятью <B><font color=\"blue\">".$name_table[$power]."</font></B> действовать на юнита, игнорируя все запреты";
			$p .= ", длительность <font color=\"blue\"><B>".$area."</B></font>".($effects[$i][$j+1]['num']!="" ? "<br>" : "");
		}
		else
		if($num==145)//эффект ожога для заклинаний
			$p .= "Урон от ожога <B><font color=\"red\">".$power."</font></B>, длительность <font color=\"blue\"><B>".$area."</B></font>".($effects[$i][$j+1]['num']!="" ? "<br>" : "");
		else
		if($num==148)//Передача снарядов от цели к заклинателю, если есть способность 298 - количество восполняемых магом снарядов становится равно значению способности
		{
			if($flag_298[$i] != 1)//только абилка 148, без 298
			{
				$p .= "Запас снарядов (с передачей трети уничтоженных кастующему) <B><font color=\"red\">".-$power."</font></B>".($effects[$i][$j+1]['num']!="" ? "<br>" : "");
			}
		}
		else
		if($num==164)//Урон призванному юниту
			$p .= "Урон призванному юниту <B><font color=\"red\">".$power."</font></B>".($effects[$i][$j+1]['num']!="" ? "<br>" : "");
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
			$p .= " каждый ход, длительность <font color=\"blue\"><B>".$area."</B></font>".($effects[$i][$j+1]['num']!="" ? "<br>" : "");
	    }
	    else
	    if($num==200) //Позволяет восполнять снаряды
			$p .= "Разрешение восполнять снаряды".($effects[$i][$j+1]['num']!="" ? "</B><br>" : "</B>");
		else
		if($num==212)//эффект процентного изменения сопротивления
		{
			$p .= "Изменение сопротивления на ".($power<0 ? " <font color=\"red\"><B>$power%</B></font>" : " <font color=\"green\"><B>+$power%</B></font>");
			$p .= ", длительность <font color=\"blue\"><B>".$area."</B></font>".($effects[$i][$j+1]['num']!="" ? "<br>" : "");
		}
		else
	    if($num==213) //dispell
			$p .= $abil_name[$num].", сила <font color=\"green\"><B>".$power."</B></font>".($effects[$i][$j+1]['num']!="" ? "<br>" : "");
		else
		if($num==220)//Заклинание по всем рядом стоящим существам при смерти (невидимая абилка).
		{
			$p .= "Применение заклятья <B><font color=\"blue\">".$name_table[$power]."</font></B> по всем рядом стоящим существам при смерти цели";
			$p .= ", длительность <font color=\"blue\"><B>".$area."</B></font>".($effects[$i][$j+1]['num']!="" ? "<br>" : "");
		}
		else
	    if($num==230) //230. Особое воздействие на нежить (используется в Spell.var)
			$p .= "Урон нежити <B><font color=\"red\">".$power."</font></B>, длительность <font color=\"blue\"><B>весь бой</B></font>".($effects[$i][$j+1]['num']!="" ? "<br>" : "");
	    else
	    if($num==234) //Воздействие на здоровье - только для существ с не-положительной кармой
		{
			if($negative_table[$i]==0)
			{
				if($area<=0)
					$p .= ($power>0 ? "Лечение <font color=\"green\">" : "Урон <font color=\"red\">");
				else
					$p .= ($power>0 ? "Регенерация <font color=\"green\">" : "Урон <font color=\"red\">");
				$p .= "<B>".abs($power)."</B></font>";
			}
			else
				$p .= "Урон <font color=\"red\"><B>".abs($power)."</B></font>";
			$p .= " (для существ с не-положительной кармой)";
			$p .= ($area<=0 ? "" : ", длительность <font color=\"blue\"><B>$area</B></font>").($effects[$i][$j+1]['num']!="" ? "<br>" : "");		
		}
	    else
	    if($num==235) //Воздействие на выносливость - только для существ с не-положительной кармой
		{
			if($negative_table[$i]==0)
			{
				$p .= "Выносливость ".($power>0 ? "<font color=\"green\">+" : "<font color=\"red\">");
				$p .= "<B>".$power."</B></font>";
			}
			else
				$p .= "Выносливость <font color=\"red\"><B>".-$power."</B></font>";
			$p .= " (для существ с не-положительной кармой)";
			$p .= ($area<=0 ? "" : ", длительность <font color=\"blue\"><B>$area</B></font>").($effects[$i][$j+1]['num']!="" ? "<br>" : "");		
		}
	    else
	    if($num==236) //Воздействие на боевой дух - только для существ с не-положительной кармой
		{
			if($negative_table[$i]==0)
			{
				$p .= "Боевой дух ".($power>0 ? "<font color=\"green\">+" : "<font color=\"red\">");
				$p .= "<B>".$power."</B></font>";
			}
			else
				$p .= "Боевой дух <font color=\"red\"><B>".-$power."</B></font>";
			$p .= " (для существ с не-положительной кармой)";
			$p .= ($area<=0 ? "" : ", длительность <font color=\"blue\"><B>$area</B></font>").($effects[$i][$j+1]['num']!="" ? "<br>" : "");		
		}
	    else
	    if($num==237) //Воздействие на здоровье - только для существ с не-отрицательной кармой
		{
			if($negative_table[$i]==0)
			{
				if($area<=0)
					$p .= ($power>0 ? "Лечение <font color=\"green\">" : "Урон <font color=\"red\">");
				else
					$p .= ($power>0 ? "Регенерация <font color=\"green\">" : "Урон <font color=\"red\">");
				$p .= "<B>".abs($power)."</B></font>";
			}
			else
				$p .= "Урон <font color=\"red\"><B>".abs($power)."</B></font>";
			$p .= " (для существ с не-отрицательной кармой)";
			$p .= ($area<=0 ? "" : ", длительность <font color=\"blue\"><B>$area</B></font>").($effects[$i][$j+1]['num']!="" ? "<br>" : "");		
		}
	    else
	    if($num==238) //Воздействие на выносливость - только для существ с не-отрицательной кармой
		{
			if($negative_table[$i]==0)
			{
				$p .= "Выносливость ".($power>0 ? "<font color=\"green\">+" : "<font color=\"red\">");
				$p .= "<B>".$power."</B></font>";
			}
			else
				$p .= "Выносливость <font color=\"red\"><B>".-$power."</B></font>";
			$p .= " (для существ с не-отрицательной кармой)";
			$p .= ($area<=0 ? "" : ", длительность <font color=\"blue\"><B>$area</B></font>").($effects[$i][$j+1]['num']!="" ? "<br>" : "");		
		}
	    else
	    if($num==239) //Воздействие на боевой дух - только для существ с не-отрицательной кармой
		{
			if($negative_table[$i]==0)
			{
				$p .= "Боевой дух ".($power>0 ? "<font color=\"green\">+" : "<font color=\"red\">");
				$p .= "<B>".$power."</B></font>";
			}
			else
				$p .= "Боевой дух <font color=\"red\"><B>".-$power."</B></font>";
			$p .= " (для существ с не-отрицательной кармой)";
			$p .= ($area<=0 ? "" : ", длительность <font color=\"blue\"><B>$area</B></font>").($effects[$i][$j+1]['num']!="" ? "<br>" : "");		
		}
	    else
	    if($num==285) //Цепь жизни
		{
			$p .= "Цепь жизни (сила <font color=\"green\"><B>".$power."</B></font>)";
			$p .= ($area<=0 ? "" : ", длительность <font color=\"blue\"><B>$area</B></font>").($effects[$i][$j+1]['num']!="" ? "<br>" : "");		
		}
	    else
	    if($num==297) //Позволяет восполнять снаряды
			$p .= "Коррекция отрицательного здоровья, выносливости или боевого духа".($effects[$i][$j+1]['num']!="" ? "</B><br>" : "</B>");
//$abil_name[297]="Используется для блокировки перехода через ноль здоровья, выносливости и боевого духа с ростом Силы магии";
	    else
		if(in_array($num,$abil_stamina))
		{
			$p .= $abil_name[$num]." (затраты выносливости <font color=\"red\"><B>".$power."</B></font>)";
			$p .= ($area<=0 ? "" : ", длительность <font color=\"blue\"><B>".$area."</B></font>").($effects[$i][$j+1]['num']!="" ? "<br>" : "");
	    }
		else
		if(in_array($num,$abil_xod))
		{
			$p .= $abil_name[$num]." (действует <font color=\"fuchsia\"><B>$power</font></B> ход";
			if($power>1 && $power<5)
				$p .= "а";
			else
			if($power>4)
				$p .= "ов";
			$p .= ($area<=0 ? ")" : "), длительность <font color=\"blue\"><B>".$area."</B></font>").($effects[$i][$j+1]['num']!="" ? "<br>" : "");
		}
		else
		if($abil_name[$num]=="")
			$p .= "!!!Неизвестная абилка $num".($effects[$i][$j+1]['num']!="" ? "<br>" : "");
		else
	    if($abil_numeric[$num]==0) //одноразодаваемые абилки
		{
			if($power<0)
				$p .= "Отмена умения <font color=\"aqua\"><B>";
			$p .= $abil_name[$num];
			if($power<0)
				$p .= "</font></B>";
			$p .= ($area<=0 ? "" : ", длительность <font color=\"blue\"><B>".$area."</B></font>").($effects[$i][$j+1]['num']!="" ? "<br>" : "");
	    }
		else
//		if($negative_table[$i]==0)
//		if($spell_not_do[$i]!=1)
//		if(($negative_table[$i]==1) && ($on_ally_table[$i]==0) && ($on_enemy_table[$i]==1))
		if(($negative_table[$i]==1) && (in_array($num,$abil_negative)))
		{
			if($on_ally_table[$i]!=0 && $on_enemy_table[$i]==0)//своим - положительные, если Negative==1 и $power<0
				$p .= $abil_name[$num].($power<0 ? " <font color=\"green\"><B>+".abs($power)."</B></font>" : " <font color=\"red\"><B>-$power</B></font>").($abil_percent[$num]==1 ? "%" : "").($area<=0 ? "" : ", длительность <font color=\"blue\"><B>".$area."</B></font>").($effects[$i][$j+1]['num']!="" ? "<br>" : "");			
			else
				$p .= $abil_name[$num].($power<0 ? " <font color=\"red\"><B>$power</B></font>" : " <font color=\"red\"><B>-$power</B></font>").($abil_percent[$num]==1 ? "%" : "").($area<=0 ? "" : ", длительность <font color=\"blue\"><B>".$area."</B></font>").($effects[$i][$j+1]['num']!="" ? "<br>" : "");
		}
		else
			$p .= $abil_name[$num].($power<0 ? " <font color=\"red\"><B>$power</B></font>" : " <font color=\"green\"><B>+$power</B></font>").($abil_percent[$num]==1 ? "%" : "").($area<=0 ? "" : ", длительность <font color=\"blue\"><B>".$area."</B></font>").($effects[$i][$j+1]['num']!="" ? "<br>" : "");
//		$spell_not_do[$i]=0;
//		else
//			echo $abil_name[$num].($power<0 ? " <font color=\"red\"><B>$power</B></font>" : " <font color=\"red\"><B>-$power</B></font>").($area==-1 ? "" : ", длительность <B>$area</B>").($effects[$i][$j+1]['num']!="" ? "<br>" : "");

/*
		{
			if($power<0)
				echo "<font color=\"red\">".$abil_name[$num]." <B>$power</B></font>";
			else
				echo "<font color=\"green\">".$abil_name[$num]." <B>+$power</B></font>";
			echo ($area==-1 ? "" : ", <font color=\"maroon\">длительность <B>$area</B></font>").($effects[$i][$j+1]['num']!="" ? "<br>" : "");
		}
	    else
		if($negative_table[$i]!=0)
		{
			if($power<0)
				echo "<font color=\"red\">".$abil_name[$num]." <B>$power</B></font>";
			else
				echo "<font color=\"red\">".$abil_name[$num]." <B>-$power</B></font>";
			echo ($area==-1 ? "" : ", <font color=\"maroon\">длительность <B>$area</B></font>").($effects[$i][$j+1]['num']!="" ? "<br>" : "");
		}
*/
	}
	$spell_abil_prn[$i]=$p;
	$p="";
//	echo "</td></tr>";
}

//проверка на неиспользуемые заклинания
//Плюс формирование столбца "Где можно встретить"
$used = array(186,350);
//Сейсмозаряд,Шторм Тьмы
for($i=1;$i<$max+1;$i++)
{
	if($level_table[$i]>4 || $itemlevel_table[$i]>6)
		if(!isset($spell_unit[$i]) && !isset($build_table[$i]) && !in_array($i,$used))
			echo "!!!$i ($name_table[$i]) - Неиспользуемое заклинание<br>";
	if(isset($spell_add[$i]) || isset($spell_unit[$i]))
	{
//		$p="";
		$n=1;
		if(isset($spell_unit[$i]))
		{
			$p .= substr(($n++.") Юниты: $spell_unit[$i]"),0,-2);
		}
		for($k=0;$k<count($spell_add[$i]);$k++)
		{
			$p .= "<br>".$n++.") ".$spell_add[$i][$k];
		}
	}
	$spell_get[$i]=$p;
	$p="";
}

//вывод полной таблицы
for($i=1;$i<$max+1;$i++)
{
	echo "<tr><td align=center>$i</td><td>$name_table_prn[$i]</td><td></td><td>$spell_txt[$i]</td><td>";
	echo "$spell_abil_prn[$i]</td><td>".$spell_get[$i]."</td><td align=center>$level_table[$i]</td><td align=center>";
	echo "$itemlevel_table[$i]</td><td align=center>$cost_table[$i]</td><td align=center>$stamcost_table[$i]</td><td align=center>";
	echo "<font color=\"red\">$lifecost_table[$i]</font></td><td align=center>$spell_target[$i]</td><td>$unit_kind[$i]</td><td>$antieffect[$i]</td><td align=center>";
	echo "$build_table[$i]</td><td><B><font color=\"red\">K</font></B></td><td align=center>";
	echo "$powermod_table[$i]</td><td align=center>$durationmod_table[$i]</td><td align=center>";
	echo "$resistpower_table[$i]</td><td align=center>$resistduration_table[$i]</td><td align=center>$defencepower_table[$i]</td><td align=center>";
	echo ($negative_table[$i]==0 ? "Нет" : "Да")."</td><td align=center>";
	echo ($on_enemy_table[$i]==0 ? "Нет" : "Да")."</td><td align=center>";
	echo ($on_ally_table[$i]==0 ? "Нет" : "Да")."</td><td align=center>";
	echo ($sacrifice_table[$i]==0 ? "Нет" : "Да")."</td><td align=center>";
	echo ($restoreonly_table[$i]==0 ? "Нет" : "Да")."</td><td align=center>";
	echo ($cumulative_table[$i]==0 ? "Нет" : "Да")."</td><td align=center>";
	echo ($unloot_table[$i]==0 ? "Нет" : "Да")."</td></tr>";
//	echo "</td></tr>";
}

echo "</table><br>";

$f=fopen("Spell_eadoropedia.txt","w") or die("Ошибка при создании файла Spell_eadoropedia.txt.txt");
foreach($spell_eadoropedia as $idx => $sp)
{
	fwrite($f,"						 <tr>\n");
	fwrite($f,"						   <td width=\"150\"><div><a href=\"spells.html#".$sp."\">".$name_table[$sp]."</a></div></td>\n");
	fwrite($f,"						   <td width=\"30\"><div>".$level_table[$sp]."</div></td>\n");
	fwrite($f,"						   <td width=\"80\"><div>".($powermod_table[$sp]/100)."</div></td>\n");
	fwrite($f,"						   <td width=\"90\"><div>".($defencepower_table[$sp] != 0 ? ($defencepower_table[$sp]/100)." (защита)" : $resistpower_table[$sp]/100)."</div></td>\n");
	fwrite($f,"						   <td width=\"120\"><div>".$spell_damage[$idx]."</div></td>\n");
	fwrite($f,"						   <td width=\"90\"><div>".$spell_target2[$sp]."</div></td>\n");
	fwrite($f,"						 </tr>\n");
}
fclose($f);

//вывод спойлера о карме
$f=fopen("Spell_spoil.txt","w") or die("Ошибка при создании файла Spell_spoil.txt");
for($i = 0; $i < $count_spell; $i++)
{
	if($karma_flag[$i] != 0)
		fwrite($f,trim($spell_file[$i])." [Карма: ".($karma_flag[$i] > 0 ? "+" : "").$karma_flag[$i]."]\n");
	else
	if(isset($spell_txt_idx2[$i]))
	{
		$idx = $spell_txt_idx2[$i];
		$p = "[ ";
		if($powermod_table[$idx] != 0)
			$p .= "PowerMod:$powermod_table[$idx] ";
		if($durationmod_table[$idx] != 0)
			$p .= "DurMod:$durationmod_table[$idx] ";
		if($resistpower_table[$idx] != 0)
			$p .= "ResistPower:$resistpower_table[$idx] ";
		if($resistduration_table[$idx] != 0)
			$p .= "ResistDur:$resistduration_table[$idx] ";
		if($defencepower_table[$idx] != 0)
			$p .= "DefencePower:$defencepower_table[$idx] ";
//		fwrite($f,"[PowerMod:$powermod_table[$idx], DurationMod:$durationmod_table[$idx], ResistPower:$resistpower_table[$idx], ResistDur:$resistduration_table[$idx]]");
		$p .= "]\n";
		if($p != "[ ]\n")
			fwrite($f,$p);
/*		if($unit_kind2[$idx] != "")
		{
			fwrite($f,"[UnitKind: ".$unit_kind2[$idx]."]\n");
		}
		if($antieffect2[$idx] != "")
		{
			fwrite($f,"[AntiEffect: ".$antieffect2[$idx]."]\n");
		}
*/		if($spell_unit2[$idx] != "")
		{
			fwrite($f,"[Юниты: ".substr($spell_unit2[$idx],0,-2)."]\n");
		}
		fwrite($f,"\n".$spell_file[$i]);
/*
		if($spell_unit2[$idx] != "" || $powermod_table[$idx]!=0 || $durationmod_table[$idx]!=0 || $resistpower_table[$idx]!=0 || $resistduration_table[$idx]!=0 || $defencepower_table[$idx]!=0)
		{
			fwrite($f,"[ ");
			if($powermod_table[$idx] != 0)
				fwrite($f,"PowerMod:$powermod_table[$idx] ");
			if($durationmod_table[$idx] != 0)
				fwrite($f,"DurMod:$durationmod_table[$idx] ");
			if($resistpower_table[$idx] != 0)
				fwrite($f,"ResistPower:$resistpower_table[$idx] ");
			if($resistduration_table[$idx] != 0)
				fwrite($f,"ResistDur:$resistduration_table[$idx] ");
			if($defencepower_table[$idx] != 0)
				fwrite($f,"DefencePower:$defencepower_table[$idx] ");
//		fwrite($f,"[PowerMod:$powermod_table[$idx], DurationMod:$durationmod_table[$idx], ResistPower:$resistpower_table[$idx], ResistDur:$resistduration_table[$idx]]");
			fwrite($f,"]\n");
			if($spell_unit2[$idx] != "")
			{
				fwrite($f,"[Юниты: ".substr($spell_unit2[$idx],0,-2)."]\n");
			}
			fwrite($f,$spell_file[$i]);
		}
		else
			fwrite($f,$spell_file[$i]);
*/
	}
	else
		fwrite($f,$spell_file[$i]);
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
	if($spell_karma[$i]>0)
		echo "<font color=\"green\">+".$spell_karma[$i]."</font>";
	else
	if($spell_karma[$i]<0)
		echo "<font color=\"red\">".$spell_karma[$i]."</font>";
	echo "</td></tr>";
}
?>

<br><a href='index.html'>вернуться к списку файлов</a>
</html>