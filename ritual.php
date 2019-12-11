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
$a_file = file("ritual.var");
$count_f = count($a_file);
$e_file = file("encounter.var");
$count_e = count($e_file);
$event_file = file("event.var");
$count_event = count($event_file);
$b_file = file("inner_build.var");
$count_b = count($b_file);
$out_build_file = file("outer_build.var");
$count_out_build = count($out_build_file);
$ritual_file = file("Ritual.txt");
$count_ritual = count($ritual_file);
$ritual_event_file = file("ritual_event.exp");
$ritual_enc_file = file("ritual_enc.exp");

$res_name=array(1=>"Железо", "Красное дерево", "Кони", "Мандрагора", "Арканит", "Мрамор", "Мифрил", "Дионий", "Чёрный лотос");

//добавление в Ritual.txt Вероятности получения юнитов (определённых уровней) в свою армию через ритуалы:
$ritual_txt_unit[6] = "
Скелет (ур. 1-5)            -   33~
Зомби (ур. 0-4)             -   32~
Костяной копейщик (ур. 1-3) - 18,9~
Жнец (ур. 2-6)              -  8,1~
Мумия (ур. 0-1)             -    8~";

$ritual_txt_unit[11] = "
Адская гончая (ур. 0-4) -    45~
Чёрт (ур. 0-4)          -    15~
Отродье (ур. 7-12)      -  12,5~
Суккуб (ур. 2-3)        -    10~
Бес (ур. 5-10)          - 9,375~
Цербер (ур. 2-4)        -     5~
Пересмешник (ур. 1-3)   - 3,125~";

$ritual_txt_unit[27] = "
Скелет Мрака (ур. 4-8)     -     25~
Лорд Мрака (ур. 2-5)       - 16,875~
Чёрный рыцарь (ур. 2-5)    - 16,875~
Спектр (ур. 2-4)           -   13,5~
Затронутый Смертью(ур.0-2) - 13,125~
Призрак (ур. 2-4)          -      9~
Баньши (ур. 0-2)           -  5,625~";

$ritual_txt_unit[34] = "
1 кобольд (ур. 0-4)  - 24~
2 кобольда (ур. 0-4) - 58~
3 кобольда (ур. 0-4) - 18~";

$ritual_txt_unit[41] = "
Слизняк (ур. 2-5)           -   20~
Паук (ур. 1-3)              -   20~
Болотная стрекоза (ур. 2-6) - 12,5~
Гигантский орёл (ур. 3-9)   - 12,5~
Василиск (ур. 3-7)          - 12,5~
Птицелов (ур. 4-6)          - 12,5~
Ужасный медведь (ур. 0-1)   -   10~";

//доп текст
$ritual_txt_add[3] = "Золото +(15-25)*Уровень провинции;\nОтношение провинции -1";
$ritual_txt_add[5] = "Кристаллы +(4-9)*Уровень провинции;\nОтношение провинции -1;\nКоличество населения -(5-10)~";
$ritual_txt_add[7] = "Настроение населения +2;\nПрирост населения +4";
$ritual_txt_add[8] = "Герой и его воины +(20-30) опыта;\nБоевой дух отряда героя -(0-3)";
$ritual_txt_add[9] = "Получить случайный предмет уровня 2, c редкостью не ниже 1 (вероятность 60~) ИЛИ случайный предмет уровня 3, c редкостью не ниже 1 (вероятность 24~)";
$ritual_txt_add[9] .= " ИЛИ случайный предмет уровня 4, c редкостью не ниже 1 (вероятность 16~)";
$ritual_txt_add[10] = "Доход +10/+3";
$ritual_txt_add[12] = "Настроение населения -2";
$ritual_txt_add[13] = "Состав охраны:\nПегас:4 (ур. 12); Грифон:3 (ур. 9); Валькирия:2 (ур. 4)";
$ritual_txt_add[16] = "Золото -(10-20)*Уровень провинции;\nДоход -5;\nПрирост населения -3;\nКоличество населения -(5-10)~";
$ritual_txt_add[17] = "Количество населения -(10-20)~";
$ritual_txt_add[18] = "Атакующий отряд: Нежить, уровень 1";
$ritual_txt_add[19] = "Золото +(500-900) ИЛИ кристаллы +(150-250) ИЛИ случайный предмет уровня 4, c редкостью не ниже 2 (вероятность 70~) ИЛИ ";
$ritual_txt_add[19] .= "случайный предмет уровня 5, c редкостью не ниже 2 (вероятность 30~) ИЛИ отношение провинции +5, накопленное недовольство -500";
$ritual_txt_add[21] = "Башня Молний: +5 кристаллов/ход, доступ к библиотеке";
$ritual_txt_add[22] = "Разрушить 2 постройки;\nКоличество населения -(40-60)~;\nПовредить укрепления на (30-50)";
$ritual_txt_add[23] = "Атакующий отряд: Демоны, уровень 2";
$ritual_txt_add[24] = "Настроение населения -1;\nПрирост населения -5";
$ritual_txt_add[29] = "Настроение населения -1;\nПрирост населения -2";
$ritual_txt_add[30] = "Отношение провинции -1;\nКоличество населения -10~";
$ritual_txt_add[36] = "Золото +(15-25)*Уровень провинции";
$ritual_txt_add[37] = "Золото +(15-25)*Уровень провинции;\nДоход +6/+2";
$ritual_txt_add[39] = "Атакующий отряд: Инквизиторы, уровень 2";
$ritual_txt_add[40] = "Прирост населения +8";
$ritual_txt_add[42] = "Появляется сайт Плодородная долина ИЛИ Тайная лощина ИЛИ Живописная долина";

$max=0;$max1=0;$max_u=0;$max_e=0;$t[0]=0;$j=0;
$u1=-1;$u2=0;$u3=0;	//№ строки юнита в xls
$g1=0; //кол-во стражей в одном сайте
$a1=0; //№ абилки
$a2=0; //№ эффекта ritual
$e1=0; //№ эффекта
$up1=0; //число upg_type в unit_upg
$u_a=0; //абилки in unit.var

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
			$EventGroupName[$s[1]] = $s[2];//имя группы событий для получения ритуала
			$ritual_event_cnt[$s[0]] = $s[3];//к-во ритуалов
		}
	}
}

foreach($export_ritual_event_scroll as $ritual => $ev)
{
	foreach($ev as $i)
	{
			$p = "";
			$cnt = $ritual_event_cnt[$ritual];
			$p .= "Можно получить <B><font color=\"blue\">".$cnt." </font></B>";
			if($cnt==1)
				$p .= "свиток";
			else
			if($cnt>1 && $cnt<5)
				$p .= "свитка";
			else
				$p .= "свитков";
			$p .= " ритуала от <B>группы событий (group_event) <font color=\"blue\">$i (".$EventGroupName[$i].")</font></B>";
			$ritual_add[$ritual][] = $p;//доп. способы получения свитков ритуала
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
			eval($var."[$s[0]][] = $s[1];");
			$EncGroupName[$s[1]] = $s[2];//имя группы приключений для получения ритуала
			$ritual_enc_cnt[$s[0]] = $s[3];//к-во ритуалов
		}
	}
}

foreach($export_ritual_enc_scroll as $ritual => $enc)
{
	foreach($enc as $i)
	{
			$p = "";
			$cnt = $ritual_enc_cnt[$ritual];
			$p .= "Можно получить <B><font color=\"blue\">".$cnt." </font></B>";
			if($cnt==1)
				$p .= "свиток";
			else
			if($cnt>1 && $cnt<5)
				$p .= "свитка";
			else
				$p .= "свитков";
			$p .= " ритуала от <B>группы приключений (group_enc) <font color=\"blue\">$i (".$EncGroupName[$i].")</font></B>";
			$ritual_add[$ritual][] = $p;//доп. способы получения свитков ритуала
	}
}

//Разбор Ritual.txt
for($i = 0; $i < $count_ritual; $i++)
{  
    if(eregi("^([0-9]{1,})",$ritual_file[$i],$k))
    {
		$n=$k[1];
		if($n>$max1)$max1=$n;
    }
    else
	if((substr($ritual_file[$i],0,1)=="#") && (substr(trim($ritual_file[$i]),-1,1)=="#"))
	{
		$ritual_txt[$n] = substr(trim($ritual_file[$i]),1,-1);
		$ritual_txt_idx[$n] = $i;//в какую строку добавлять спойлеры о карме/коррупции
		$ritual_txt_idx2[$i] = $n;
		$i++;
	}
	else
	if(substr($ritual_file[$i],0,1)=="#")
	{
		$ritual_txt[$n] = substr($ritual_file[$i],1)."<br>";
		$ritual_txt_idx[$n] = $i;//в какую строку добавлять спойлеры о карме/коррупции
		$ritual_txt_idx2[$i] = $n;
	}
	else
	if(substr(trim($ritual_file[$i]),-1,1)=="#")
	{
		$ritual_txt[$n] .= substr(trim($ritual_file[$i]),0,-1);
		$i++;
	}
	else
		$ritual_txt[$n] .= $ritual_file[$i]."<br>";
	$ritual_txt[$n] = str_replace("~","%",$ritual_txt[$n]);
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
			if($build_abil==27)//Позволяет проводить ритуал Param1
				$ritual_build[$build_param1][]=$build_name[$n];
		}
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
			$abil_num=$s[1]+1-1;	//массив № абилок
			$i++;
			$s=explode(':',$out_build_file[$i]);
			$abil_param1=$s[1]+1-1;	//массив param1 абилок
			if($abil_num==15) //Позволяет герою использовать ритуал Param1 (только в этой провинции)
			{
				$ritual_build2[$abil_param1][] = $out_build_name[$n];
			}
		}
    }
}

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
		$name1_table[$n]=trim($s); //имя в формате "/0 Пусто "

//echo "<br>".$k[1]."! $n  ! $max !!"; 
		$u1++;	//№ строки
    }
	else
    if(eregi("^Name:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$s1=substr(trim($s[1]),0,-1);
		if(in_array($s1,$name_table))
			echo $n."- Дубль NAME=".$s1."<br>";
		$name_table[$n]=$s1;
//		$name_table[$n]=substr(trim($s[1]),0,-1);
    }
    else
    if(eregi("^GoldCost:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		if(($s[1]+1-1)!=0) $GoldCost[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^GemCost:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		if(($s[1]+1-1)!=0) $GemCost[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^Karma:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$Karma[$n]=$s[1]+1-1;
		if($Karma[$n] != 0)
			$karma_flag[$ritual_txt_idx[$n]] = $s[1]+1-1;//№ строки в Ritual.txt, куда надо вставить спойлер о карме
    }
    else
    if(eregi("^OnEnemy:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$OnEnemy[$n]=(($s[1]+1-1)==0) ? "Нет" : "Да";
    }
    else
    if(eregi("^OnAlly:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$OnAlly[$n]=(($s[1]+1-1)==0) ? "Нет" : "Да";
    }
    else
    if(eregi("^Time:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		if(($s[1]+1-1)!=0) $Time[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^Cooldown:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$Cooldown[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^ItemLevel:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$ItemLevel[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^ItemRarity:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$ItemRarity[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^Event:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		if(($s[1]+1-1)!=0) $Event[$n]=$s[1]." (".$event_table2[$s[1]+1-1].")";
    }
    else
    if(eregi("^Effect:",$a_file[$i])) //effect  в ritual.var
    {
//echo $n."-".$a_file[$i]."<br>";
		$s=explode(':',$a_file[$i]);
		$ritual_effect[$n][$a2]['num']=$s[1];	//массив № абилок
		$i++;
		$s=explode(':',$a_file[$i]);
		$ritual_effect[$n][$a2]['param1']=$s[1]+1-1;	//массив param1 абилок
		$i++;
		$s=explode(':',$a_file[$i]);
		$ritual_effect[$n][$a2]['param2']=$s[1]+1-1;	//массив param2 абилок
//echo $n."-a2=".$a2." ".$ritual_effect[$n][$a2]['num']." ".$ritual_effect[$n][$a2]['param1']." ".$ritual_effect[$n][$a2]['param2']."<br>";
		$a2++;
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

//вывод ресурсов
for($i=0;$i<$max+1;$i++)
{ 
//	echo "<tr><td>$i</td><td>";
	for($j=0;($res_table[$i][$j]!="")&&($j<10);$j++)
	{
		$ritual_res[$i] .= $res_table[$i][$j].(($res_table[$i][$j+1]=="") ? "" : "; ");
	}
//	echo "</td></tr>";
}

//effects in ritual.var
for($i=0,$j=0;$i<$max+1;$i++)
{ 
//	echo "<tr><td>$i</td><td>";
//echo $i."-".$j." RIT=".($ritual_effect[$i][$j]['num']=="").$ritual_effect[$i][$j]['num']."<br>";
//$j++;
	for($n=1;($ritual_effect[$i][$j]['num']!="")&&($j<1000);$j++,$n++)
	{
		$num=$ritual_effect[$i][$j]['num']+1-1;
		$param1=$ritual_effect[$i][$j]['param1'];
		$param2=$ritual_effect[$i][$j]['param2'];
		if($num!=0)
			$p .= $n.") ";
		if($num==1)
		{
			$p .= "Изменяет настроение населения на <B>".(($param1>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param1;
		}
		else
		if($num==2)
		{
			$p .= "Изменяет прирост населения на <B>".(($param1>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param1;
		}
		else
		if($num==3)
		{
			$p .= "Вызвать в провинции событие <B><font color=\"blue\">".$param1." (".$event_table2[$param1].")";
		}
		else
		if($num==4)
		{
			$p .= "Запретить ритуал, если у одного из героев уже взято задание кристалла";
		}
		else
		if($num==5)
		{
			$p .= "Вызвать для героя приключение <B><font color=\"blue\">".$param1." (".$enc_table[$param1].")";
			if($param2!=0) $p .= "<br><B>!!!ERROR $i: 5. Вызвать для героя приключение(encounter) Param1 (Param2 должен быть равен 0)";
		}
		else
		if($num==6)
		{
		    if($param1!=0)
			{
				$p .= "Доход золота <B>".(($param1>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param1."</font></B>";
				if($param2!=0) $p .= ";<br>";
			}
		    if($param2!=0)
				$p .= "Доход кристаллов <B>".(($param2>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param2;
		}
		else
		if($num==8)
		{
			$p .= "Герои в провинции пропускают ход и получают приключение <B><font color=\"blue\">\"Снежный буран\"";
		}
		else
		if($num==12)
		{
			$p .= "Запретить врагам вход в провинцию, блокирует вражеские ритуалы";
		}
		else
		if($num==18)
		{
			$p .= "Запретить в родовой провинции";
		}
		else
		if($num==19)
		{
			$p .= "Запретить в осаждённой провинции";
		}
		else
		if($num==20)
		{
			$p .= "Цель ритуала - герой";
		}
		else
		if($num==22)
		{
			$p .= "Запретить ритуал в провинции, где нет места для построек";
		}
		else
		if($num==23)
		{
			$p .= "Запретить ритуал в провинции с постройкой <B><font color=\"blue\">".$out_build_name[$param1];
		}
		else
		if($num==24)
		{
			$p .= "В провинции должны быть жители";
		}
		else
		if($num==25)
		{
			$p .= "Запретить, если в провинции неувольняемый страж";
		}
		else
			$p .= ($num==0 ? "" : "<B>!!!ERROR!!! NUM=".$num);
		$p .= "</font></B>";
		if($ritual_effect[$i][$j+1]['num']!="") $p .= "<br>";
	}
	if(isset($ritual_add[$i]))
	{
		for($k=0;$k<count($ritual_add[$i]);$k++)
		{
			$p .= "<br>".$n++.") ".$ritual_add[$i][$k];
		}
	}
	if(isset($ritual_build[$i]) || isset($ritual_build2[$i]))
	{
		if(isset($ritual_build[$i]))
		{
			for($k=0;$k<count($ritual_build[$i]);$k++)
			{
				$ritual_build_prn[$i] .= $ritual_build[$i][$k]."; ";
			}
			$ritual_build_prn[$i] = substr($ritual_build_prn[$i],0,-2)."<br>";
		}
		if(isset($ritual_build2[$i]))
		{
			$ritual_build_prn[$i] .= "(";
			for($k=0;$k<count($ritual_build2[$i]);$k++)
			{
				$ritual_build_prn[$i] .= "<font color=\"red\">".$ritual_build2[$i][$k]."</font>; ";
			}
			$ritual_build_prn[$i] = substr($ritual_build_prn[$i],0,-2).")<br>";
		}
		$ritual_build_prn[$i] = substr($ritual_build_prn[$i],0,-4);
	}
//	$ritual_abil[$i]=substr($p,0,-11);
	$ritual_abil[$i]=$p;
	$p="";
}

$ritual_abil[3] .= "<br>[<font color=\"fuchsia\">Изменить золото игрока на</font><br><B><font color=\"green\"> +(15-25)*Уровень_провинции</font></B>;";
$ritual_abil[3] .= "<br><font color=\"fuchsia\">Изменить отношение провинции на</font><B><font color=\"red\"> -1</font></B>]";
$ritual_abil[5] .= "<br>[<font color=\"fuchsia\">Изменить кристаллы игрока на</font><br><B><font color=\"green\"> +(4-9)*Уровень_провинции</font></B>;";
$ritual_abil[5] .= "<br><font color=\"fuchsia\">Изменить отношение провинции на</font><B><font color=\"red\"> -1</font></B>;";
$ritual_abil[5] .= "<br><font color=\"fuchsia\">Изменить количество населения провинции на</font><B><font color=\"red\"> -(5-10)%</font></B>]";
$ritual_abil[8] .= "<br>[<font color=\"fuchsia\">Дать герою и его воинам</font><B><font color=\"green\"> (20-30)</font></B> <font color=\"fuchsia\">опыта</font>;";
$ritual_abil[8] .= "<br><font color=\"fuchsia\">Изменить боевой дух отряда героя на</font><B><font color=\"red\"> -(0-3)</font></B>]";
$ritual_abil[9] .= "<br>[<font color=\"fuchsia\">Получить случайный предмет уровня</font> <B>2</B>, <font color=\"fuchsia\">c редкостью не ниже</font> <B>1</B> (<font color=\"blue\">вероятность <B>60%</B></font>);";
$ritual_abil[9] .= "<br>или <font color=\"fuchsia\">Получить случайный предмет уровня</font> <B>3</B>, <font color=\"fuchsia\">c редкостью не ниже</font> <B>1</B> (<font color=\"blue\">вероятность <B>24%</B></font>);";
$ritual_abil[9] .= "<br>или <font color=\"fuchsia\">Получить случайный предмет уровня</font> <B>4</B>, <font color=\"fuchsia\">c редкостью не ниже</font> <B>1</B> (<font color=\"blue\">вероятность <B>16%</B></font>)]";
$ritual_abil[16] .= "<br>[<font color=\"fuchsia\">Изменить золото игрока на</font><br><B><font color=\"red\"> -(10-20)*Уровень_провинции</font></B>;";
$ritual_abil[16] .= "<br><font color=\"fuchsia\">Изменить количество населения провинции на</font><B><font color=\"red\"> -(5-10)%</font></B>]";
$ritual_abil[17] .= "[<font color=\"fuchsia\">Изменить количество населения провинции на</font><B><font color=\"red\"> -(10-20)%</font></B>;";
$ritual_abil[17] .= "<br><font color=\"fuchsia\">Здоровье всех отрядов и охранника в провинции уменьшается на</font><B><font color=\"red\"> 10</font></B> <font color=\"fuchsia\">(с учётом Сопротивления)</font>]";
$ritual_abil[18] .= "[<font color=\"fuchsia\">Атакующий отряд: </font><B>Нежить</B><br><font color=\"fuchsia\">Установить уровень атакующего отряда в </font><B>1</B>]";
$ritual_abil[19] .= "<br>[<font color=\"fuchsia\">Изменить золото игрока на</font><B><font color=\"green\"> +(500-900)</font></B>;";
$ritual_abil[19] .= "<br>или <font color=\"fuchsia\">Изменить кристаллы игрока на</font><B><font color=\"green\"> +(150-250)</font></B>;";
$ritual_abil[19] .= "<br>или <font color=\"fuchsia\">Получить случайный предмет уровня</font> <B>4</B>, <font color=\"fuchsia\">c редкостью не ниже</font> <B>2</B> (<font color=\"blue\">вероятность <B>70%</B></font>);";
$ritual_abil[19] .= "<br>или <font color=\"fuchsia\">Получить случайный предмет уровня</font> <B>5</B>, <font color=\"fuchsia\">c редкостью не ниже</font> <B>2</B> (<font color=\"blue\">вероятность <B>30%</B></font>);";
$ritual_abil[19] .= "<br>или <font color=\"fuchsia\">Изменить отношение провинции на</font><B><font color=\"green\"> +5</font></B>, ";
$ritual_abil[19] .= "<font color=\"fuchsia\">накопленное недовольство на</font><B><font color=\"red\"> -500</font></B>]";
$ritual_abil[22] .= "[<font color=\"fuchsia\">Здоровье всех отрядов и охранника в провинции уменьшается на</font><B><font color=\"red\"> 15</font></B> <font color=\"fuchsia\">(с учётом Сопротивления)</font>;";
$ritual_abil[22] .= "<br><font color=\"fuchsia\">Разрушить</font> <B>2</B> <font color=\"fuchsia\">постройки в провинции</font>;";
$ritual_abil[22] .= "<br><font color=\"fuchsia\">Изменить количество населения провинции на</font><B><font color=\"red\"> -(40-60)%</font></B>;";
$ritual_abil[22] .= "<br><font color=\"fuchsia\">Повредить укрепления в провинции на</font><B><font color=\"red\"> (30-50)</font></B>]";
$ritual_abil[23] .= "[<font color=\"fuchsia\">Атакующий отряд: </font><B>Демоны</B><br><font color=\"fuchsia\">Установить уровень атакующего отряда в </font><B>2</B>]";
$ritual_abil[30] .= "<br>[<font color=\"fuchsia\">Здоровье всех отрядов и охранника в провинции уменьшается на</font><B><font color=\"red\"> 20</font></B> <font color=\"fuchsia\">(с учётом Сопротивления)</font>;";
$ritual_abil[30] .= "<br><font color=\"fuchsia\">Изменить отношение провинции на</font><B><font color=\"red\"> -1</font></B>;";
$ritual_abil[30] .= "<br><font color=\"fuchsia\">Изменить количество населения провинции на</font><B><font color=\"red\"> -10%</font></B>]";
$ritual_abil[31] .= "<br>[<font color=\"fuchsia\">Атакующий отряд: </font><B>Астральный шпион</B>]";
$ritual_abil[32] .= "<br>[<font color=\"fuchsia\">Присоединить к отряду героя юнита <B><font color=\"brown\">Икар</B></font> уровня</font> <B>(1-5)</B></font>]";
$ritual_abil[36] .= "<br>[<font color=\"fuchsia\">Изменить золото игрока на</font><br><B><font color=\"green\"> +(15-25)*Уровень_провинции</font></B>]";
$ritual_abil[37] .= "<br>[<font color=\"fuchsia\">Изменить золото игрока на</font><br><B><font color=\"green\"> +(15-25)*Уровень_провинции</font></B>;";
$ritual_abil[37] .= "<br><font color=\"fuchsia\">Изменить отношение провинции на</font><B><font color=\"green\"> +1</font></B>]";
$ritual_abil[39] .= "[<font color=\"fuchsia\">Атакующий отряд: </font><B>Инквизиторы</B><br><font color=\"fuchsia\">Установить уровень атакующего отряда в </font><B>2</B>]";
$ritual_abil[42] .= "<br>[<font color=\"fuchsia\">В провинции появляется сайт </font><B><font color=\"aqua\">Плодородная долина</font></B>";
$ritual_abil[42] .= "<br>или <B><font color=\"aqua\">Тайная лощина</font></B><br>или <B><font color=\"aqua\">Живописная долина</font></B>]";

//вывод полной таблицы ("Название" в двух столбцах - colspan=2)
echo "<table border=1>";
for($i=1;$i<$max1+1;$i++)
{
	echo "<tr><td align=center>$i</td><td colspan=2>$name_table[$i]</td><td></td><td>$ritual_txt[$i]</td><td>";
	echo "$ritual_abil[$i]</td><td align=center>$GoldCost[$i]</td><td align=center>$GemCost[$i]</td><td>";
	echo "$ritual_res[$i]</td><td>$ritual_build_prn[$i]</td><td><B><font color=\"red\">K</font></B></td>";
	echo "<td align=center>$OnAlly[$i]</td><td align=center>$OnEnemy[$i]</td><td align=center>";
	echo "$Time[$i]</td><td align=center>$Cooldown[$i]</td><td>$Event[$i]</td><td align=center>";
	echo "$ItemLevel[$i]</td><td align=center>$ItemRarity[$i]</td></tr>";
//	echo "</td></tr>";
}
echo "</table><br>";

//вывод спойлера о карме
$f=fopen("Ritual_spoil.txt","w") or die("Ошибка при создании файла Ritual_spoil.txt");
for($i = 0; $i < $count_ritual; $i++)
{
	if(isset($ritual_txt_idx2[$i]))
	{
		$idx = $ritual_txt_idx2[$i];
		fwrite($f,"#");
		if($karma_flag[$i] != 0)
			fwrite($f,"[Карма: ".($karma_flag[$i] > 0 ? "+" : "").$karma_flag[$i]."]\n");
		if(isset($ritual_txt_add[$idx]))
			fwrite($f,"[".$ritual_txt_add[$idx]."]\n");
		if(isset($ritual_txt_unit[$idx]))
			fwrite($f,"[Вероятности появления: ]".$ritual_txt_unit[$idx]."\n");
		if($karma_flag[$i] != 0 || isset($ritual_txt_unit[$idx]) || isset($ritual_txt_add[$idx]))
			fwrite($f,"\n");//отделительная строка между спойлером и описанием
		fwrite($f,substr($ritual_file[$i],1));
	}
	else
		fwrite($f,$ritual_file[$i]);
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
		echo "<font color=\"red\">".$Karma[$i]."</font>";
	echo "</td></tr>";
}

?>
<br><a href='index.html'>вернуться к списку файлов</a>
</html>