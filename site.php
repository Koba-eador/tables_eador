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
$a_file = file("site.var");
$count_f = count($a_file);
$d_file = file("dialog.var");
$count_d = count($d_file);
$e_file = file("encounter.var");
$count_e = count($e_file);
$event_file = file("event.var");
$count_event = count($event_file);
$g_file = file("guard_type.var");
$count_g = count($g_file);
//$abil_file = file("ability_num.var");
//$count_abil = count($abil_file);
$prov_file = file("province_type.var");
$count_prov = count($prov_file);
$q_file = file("quest.var");
$count_q = count($q_file);
$b_file = file("inner_build.var");
$count_b = count($b_file);
$out_build_file = file("outer_build.var");
$count_out_build = count($out_build_file);
$site_file = file("Site.txt");
$count_site = count($site_file);
$site1_file = file("Site1.txt");
$count_site1 = count($site1_file);
$site_event_file = file("site_event.exp");
$site_enc_file = file("site_enc.exp");

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

//кого можно нанять/получить предмет (добавляется в середину)
$site_abil_[77] .= ", <font color=\"fuchsia\">где можно получить предмет</font> <B><font color=\"blue\">Адепт</font></B>";
$site_abil_[111] .= ", <font color=\"fuchsia\">где можно получить 2 предмета</font> <B><font color=\"blue\">Икра слизня</font></B>";

//Разбор Site.txt
for($i = 0; $i < $count_site; $i++)
{  
//    echo "<tr><td>$i</td><td>";
    if(eregi("^([0-9]{1,})",$site_file[$i],$k))
    {
		$n=$k[1];
		if($n>$max1)$max1=$n;
    }
    else
	if((substr($site_file[$i],0,1)=="#") && (substr(trim($site_file[$i]),-1,1)=="#"))
	{
		$site_txt[$n] = substr(trim($site_file[$i]),1,-1);
		$site_txt_idx[$n] = $i;//в какую строку добавлять спойлеры о карме/коррупции
		$site_txt_idx2[$i] = $n;
		$i++;
	}
	else
	if(substr($site_file[$i],0,1)=="#")
	{
		$site_txt[$n] = substr($site_file[$i],1)."<br>";
		$site_txt_idx[$n] = $i;//в какую строку добавлять спойлеры о карме/коррупции
		$site_txt_idx2[$i] = $n;
	}
	else
	if(substr(trim($site_file[$i]),-1,1)=="#")
	{
		$site_txt[$n] .= substr(trim($site_file[$i]),0,-1);
		$i++;
	}
	else
		$site_txt[$n] .= $site_file[$i]."<br>";
	$site_txt[$n] = str_replace("Нет описания","",str_replace("~","%",$site_txt[$n]));
}
/*		$s=explode('.',$site_file[$i]);
		$site_id[$n]=trim($s[1]);
    }
    else
    {
		$site_name[$n]=$site_name[$n].$site_file[$i];
//	$site_name[$n]=$site_name[$n].$site_file[$i].(substr(trim($site_file[$i]),-1)=="#" ? "" : "<br>");
    }
}
for($i=0;$i<$max1+1;$i++)
{
//	echo "<tr><td>$i</td><td>";
	$site_txt[$i]=str_replace("Нет описания","",str_replace("~","%",str_replace("#","",$site_name[$i])));
}
*/

//Разбор Site1.txt
for($i = 0; $i < $count_site1; $i++)
{  
//    echo "<tr><td>$i</td><td>";
    if(eregi("^([0-9]{1,})",$site1_file[$i],$k))
    {
		$n=$k[1];
		if($n>$max1)$max1=$n;
    }
    else
    {
		$site1_name[$n]=$site1_name[$n].$site1_file[$i];
//	$site1_name[$n]=$site1_name[$n].$site1_file[$i].(substr(trim($site1_file[$i]),-1)=="#" ? "" : "<br>");
    }
}
for($i=0;$i<$max1+1;$i++)
{
//	echo "<tr><td>$i</td><td>";
	$site1_txt[$i]=str_replace("~","%",str_replace("#","",str_replace("Нет описания","",$site1_name[$i])));
}

/*
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
//echo $n."-".$s[1]."--".$s1[1]."<br>";
		if($abil_name[$s1[1]+1-1]!="")
			echo "<B><font color=\"red\">!!! num=".$n."-ABIL_NUM =".$s1[1]."-- (".$abil_name[$s1[1]+1-1].") УЖЕ ЕСТЬ</font></B><br>";
		$abil_name[$s1[1]+1-1]=trim(substr($s[1],0,-3));
		$abil_numeric[$s1[1]+1-1]=$s2[1]+1-1;
// echo $n."-".$s1[1]."--".$abil_name[$s1[1]+1-1]."<br>";
    }
}
*/

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
			$i++;
			$s=explode(':',$out_build_file[$i]);
			$abil_param2=$s[1]+1-1;	//массив param2 абилок
			if($abil_num==12) //При постройке в провинции появляется сайт Param1 уровня Param2
			{
				$site_add[$abil_param1][] = "Сайт уровня <B><font color=\"blue\">$abil_param2</B></font> ставится в провинции при возведении внешней постройки <B><font color=\"blue\">$out_build_name[$n]</B></font>";
			}
		}
    }
}
dumper($site_add,"site_add");
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
			$i++;
			$s1=explode(':',$b_file[$i]);//param2
			$build_param2=$s1[1]+1-1;
			if($build_abil==50)//Добавляет в родовой провинции сайт Param1 уровня Param2
			{
				$site_add[$build_param1][] = "Сайт уровня <B><font color=\"blue\">$build_param2</B></font> ставится в родовой провинции при возведении замковой постройки <B><font color=\"blue\">$build_name[$n]</B></font>";
			}
		}
	}
}

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
	if(eregi("^Text:",$d_file[$i]))
	{
		$s=explode('Text:',$d_file[$i]);
		$s1=trim($s[1]);
		(substr($s1,-1,1)=="#") ? $dialog_text[$n]=$dialog_text[$n].substr($s1,1,-1) : $dialog_text[$n]=$dialog_text[$n].substr($s1,1);
//		(substr($s1,-1,1)=="#") ? $dialog_text[$n]=$dialog_text[$n].substr($s1,1,-1) : $dialog_text[$n]=$dialog_text[$n].substr($s1,1);
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
		$dialog_text[$n]=str_replace("Результаты разведки:","",$dialog_text[$n]);
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


//Разбор guard site.var
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
    }
}

//разбор site_event.exp
for($i = 0; $i < count($site_event_file); $i++)
{
	$str = trim($site_event_file[$i]);
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
			$EventGroupName[$s[1]] = $s[2];//имя группы событий для получения сайтов
//			$site_event_cnt[$s[0]] = $s[3];//к-во сайтов
		}
	}
}

foreach($export_site_event as $site => $ev)
{
	foreach($ev as $i)
	{
			//доп. способы получения сайтов
			$site_add[$site][] = "Сайт может появиться в провинции от <B>группы событий (group_event) <font color=\"blue\">$i (".$EventGroupName[$i].")</font></B>";
	}
}

//разбор site_enc.exp
for($i = 0; $i < count($site_enc_file); $i++)
{
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
			eval($var."[$s[0]][] = $s[1];");
			$EncGroupName[$s[1]] = $s[2];//имя группы приключений для получения сайтов
			$site_enc_hide[$s[0]] = $s[3];//флаг скрытый/открытый
		}
	}
}

foreach($export_site_enc as $site => $ev)
{
	foreach($ev as $i)
	{
			//доп. способы получения сайтов
			$site_add[$site][] = "Сайт (".($site_enc_hide[$site]==0 ? "открытый" : "скрытый").") может появиться в провинции от <B>группы приключений (group_enc) <font color=\"blue\">$i (".$EncGroupName[$i].")</font></B>";
	}
}

//-------------------------------------------------------------
//Разбор основного файла
for($i = 0,$n=0; $i < $count_f; $i++)
{
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
		$u1++;	//№ строки
    }
	else
    if(eregi("^Name:",$a_file[$i]))
    {
		if($n==51)
			$name_table[$n]="Гильдия воров <font color=\"fuchsia\">(в законе)</font>";
		else
		if($n==53)
			$name_table[$n]="Команда авантюристов";
		else
		if($n==56)
			$name_table[$n]="Тролли";
		else
		if($n==57)
			$name_table[$n]="Хутор половинчиков <font color=\"fuchsia\">(+3)</font>";
		else
		if($n==58)
			$name_table[$n]="Хутор половинчиков <font color=\"fuchsia\">(+1)</font>";
		else
		if($n==60)
			$name_table[$n]="Торговец редкостями";
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
			$s=explode(':',$a_file[$i]);
			$s=substr(trim($s[1]),0,-1);
			while(in_array($s,$name_table))
			{
				echo $n."- Дубль NAME=".$s;
				$s = $s."<font color=\"fuchsia\">*</font>";
				echo " <B>Замена на</B> ".$s."<br>";
			}
			$name_table[$n]=$s;
		}
//		$name_table[$n]=substr(trim($s[1]),0,-1);
    }
	else
    if(eregi("^Guarded:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$Guarded[$n]=$s[1]+1-1;
    }
	else
    if(eregi("^MinLevel:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$MinLevel[$n]=$s[1]+1-1;
    }
	else
    if(eregi("^MaxLevel:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$MaxLevel[$n]=$s[1]+1-1;
    }
	else
    if(eregi("^Treasure:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$Treasure[$n]=$s[1]+1-1;
    }
	else
    if(eregi("^WorkHide:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$WorkHide[$n]=(($s[1]+1-1)==0) ? "Нет" : "Да";
    }
	else
    if(eregi("^WorkGuard:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$WorkGuard[$n]=(($s[1]+1-1)==0) ? "Нет" : "Да";
    }
	else
    if(eregi("^WorkFree:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$WorkFree[$n]=(($s[1]+1-1)==0) ? "Нет" : "Да";
    }
	else
    if(eregi("^CanEnter:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$CanEnter[$n]=(($s[1]+1-1)==0) ? "Нет" : "Да";
    }
	else
    if(eregi("^SelfDestroy:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$SelfDestroy[$n]=(($s[1]+1-1)==0) ? "Нет" : "Да";
    }
	else
    if(eregi("^Place:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$place[$n]=$s[1]+1-1;
    }
	else
    if(eregi("^Difficult:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$Difficult[$n]=$s[1]+1-1;
    }
	else
    if(eregi("^Ability",$a_file[$i])) //Ability в site.var или defender.var
    {
//echo $n."-".$a_file[$i]."<br>";
		if(trim($a_file[$i])!="Ability:")
		{
			$s=explode(':',$a_file[$i]);
			$abil[$n][$a1]['num']=$s[1];	//массив № абилок
//echo $n."-".$abil[$n][$a1]['num']."<br>";
			$i++;
			$s=explode(':',$a_file[$i]);
			$abil[$n][$a1]['param1']=$s[1]+1-1;	//массив param1 абилок
			$i++;
			$s=explode(':',$a_file[$i]);
			$abil[$n][$a1]['param2']=$s[1]+1-1;	//массив param2 абилок
			$a1++;
		}
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
    if(eregi("^Dialog:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$site_dialog_num[$n]=$s[1]+1-1;
		$site_dialog[$n]=$s[1]." (".$dialog_table[$s[1]+1-1].")";
//echo $n."-".$s[1]."--".$site_dialog[$n]."<br>";
    }
    else
    if(eregi("^Dialog2:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$site_dialog_num_2[$n]=$s[1]+1-1;
		$site_dialog_2[$n]=$s[1]." (".$dialog_table[$s[1]+1-1].")";
//echo $n."-".$s[1]."--".$site_dialog_2[$n]."<br>";
    }
    else
    if(eregi("^Encounter:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		if(($s[1]+1-1)!=0)
			$enc_dialog[$n]=$s[1]." (".$enc_table[$s[1]+1-1].")";
//echo $n."-".$s[1]."--".$enc_dialog[$n]."<br>";
    }
    else
    if(eregi("^Guard:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
//     $g_table[$n][$g1]=trim($g_name[$s[1]+1-1]);
		$g_table[$n][$g1]=$g_name[$s[1]+1-1];
		$i++;
		$s=explode(':',$a_file[$i]);
		$g_poss[$n][$g1]=$s[1]+1-1;
// echo $n."-".$g_table[$n][$g1]."<br>";
		$g1++;
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

echo "<table border=1>";
/*
for($i=0;$i<$max+1;$i++)
{
//поле диалог у site
//	echo "<tr><td>$i</td><td>".$site_dialog[$i]."</td></tr>";
	echo "<tr><td>$i</td><td>".str_replace("Пусто","",$dialog_text[$site_dialog_num[$i]])."</td></tr>";
}

for($i=0;$i<$max+1;$i++)
{
//поле диалог2 у site
//	echo "<tr><td>$i</td><td>".$site_dialog[$i]."</td></tr>";
	echo "<tr><td>$i</td><td>".str_replace("Пусто","",$dialog_text[$site_dialog_num_2[$i]])."</td></tr>";
}


for($i=0;$i<$max+1;$i++)
{
//поле Encounter у site
	echo "<tr><td>$i</td><td>".$enc_dialog[$i]."</td></tr>";
}
*/
//охрана сайтов
for($i=0,$j=0;$i<$max+1;$i++)
{ 
//	echo "<tr><td>$i</td><td>";
	for(;($g_table[$i][$j]!="")&&($j<10000);$j++)
	{
		if($g_table[$i][$j]!="Пусто")
			$site_guard[$i] .= $g_table[$i][$j]."(<B><font color=\"blue\">".$g_poss[$i][$j]."</font></B>)";
		$site_guard[$i] .= ($g_table[$i][$j+1]!="") ? "; " : "";
//    echo $g_name[$i][$j]." (ур. ".$u_lvl2[$i][$j].");";
	}
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
	$site_terrain[$i] .= substr($p,0,-5);
	$p="";
//	echo "</td></tr>";
}

//Абилки сайтов
for($i=0,$j=0;$i<$max+1;$i++)
{ 
//	echo "<tr><td>$i</td><td>";
//echo "$i - N= $n<br>";
	$n=1;
	if(($Guarded[$i]!=0) && ($Guarded[$i]!=100))//вероятность появления охраны
	{
		$p .= $n++.") Вероятность появления охраны <B><font color=\"blue\">".$Guarded[$i]."%</font></B><br>";
//		$n++;
	}
	for(;($abil[$i][$j]['num']!="")&&($j<10000);$j++,$n++)
	{
		$num=$abil[$i][$j]['num']+1-1;
		$param1=$abil[$i][$j]['param1'];
		$param2=$abil[$i][$j]['param2'];
		if($num==0)
			$n--;
		else
			$p .= $n.") ";
		if($num==1)
		{
			$p .= "Месторождение ресурса <B><font color=\"blue\">".$res_name[$param1];
		}
		else
		if($num==2)
		{
		    if($param1!=0)
			{
				$p .= "Доход золота <B>".(($param1>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param1."</font></B> ";
			}
		    if($param2!=0)
				$p .= "Доход кристаллов <B>".(($param2>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param2;
		}
		else
		if($num==3)
		{
//			$p .= "Сайт содержит лут";// тип <B><font color=\"blue\">".$param1;
			if($param1 == 1)
				$p .= "Дроп золота и кристаллов снижен на <B><font color=\"red\">".($param2*10)."%";
			else
			if($param1 == 2)
				$p .= "С сайта падают только кристаллы (всё сгенерированное золото превращается в кристаллы по курсу в <B>2.5</B> раза меньше)";
			else
			if($param1 == 3)
				$p .= "С сайта падает только золото (все сгенерированные кристаллы превращаются в золото по курсу в <B>2.5</B> раза больше)";
			else
				$p .= "Дроп золота и кристаллов повышен на <B><font color=\"green\">".(($param1-3)*25)."%";
		}
		else
		if($num==4)
		{
			$p .= "Генерирует событие <B><font color=\"blue\">".$param1." (".$event_table2[$param1].")</B></font> с вероятностью <B><font color=\"blue\">".$param2."%";
			$p .= $site_abil_[$i];
		}
		else
		if($num==5)
		{
			$p .= "Обязательно появляется в провинции с типом <B><font color=\"blue\">".$param1." (".$prov_name[$param1].")";
		}
		else
		if($num==6)
		{
			$p .= "Изменяет доход золота с провинции на <B>".(($param1>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param1."%";
		}
		else
		if($num==7)
		{
			$p .= "Изменяет прирост населения в провинции на <B>".(($param1>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param1;
		}
		else
		if($num==8)
		{
			$p .= "Уровень охраны всегда равен <B><font color=\"blue\">".$param1;
		}
		else
		if($num==9)
		{
			$p .= "Дать нашедшему <B><font color=\"blue\">".$param1."+Уровень_героя*".$param2." </B></font>опыта";
		}
		else
		if($num==10)
		{
			$p .= "Дать нашедшему <B><font color=\"blue\">".$param1."+Уровень_героя*".$param2."</B></font> золота";
		}
		else
		if($num==11)
		{
			$p .= "Дать нашедшему <B><font color=\"blue\">".$param1."+Уровень_героя*".$param2."</B></font> кристаллов";
		}
		else
		if($num==12)
		{
			$p .= "Дать нашедшему стандартное сокровище";
		}
		else
		if($num==13)
		{
			$type=$param1;
			$p .= "Магазин, торгующий предметами типа <B><font color=\"blue\">".$type." (";
			if(($type==1) || ($type==2) ||($type==9))
				$p .= "Оружие и щиты";
			else
			if($type==3)
				$p .= "Луки и стрелы";
			else
			if($type==4)
				$p .= "Жезлы и сферы";
			else
			if($type==5)
				$p .= "Знамёна";
			else
			if($type==6)
				$p .= "Кожа и пояса";
			else
			if($type==7)
				$p .= "Кольчуги";
			else
			if($type==8)
				$p .= "Латы";
			else
			if($type==10)
				$p .= "Свитки";
			else
			if($type==11)
				$p .= "Договор со стражем";
			else
			if($type==12)
				$p .= "Чертёж постройки";
			else
			if($type==13)
				$p .= "Ритуал";
			else
			if($type==-1)
				$p .= "Одежда";
			else
			if($type==-2)
				$p .= "Украшения";
			else
				$p .= "<B>$i !!!ERROR NUM=".$num."Получить случайный предмет: неизвестный тип $type</B>";
			$p .= ")</B></font>, с уровнем до <B><font color=\"blue\">".$param2."</B></font>, ";
		}
		else
		if($num==14)
		{
			$p=substr($p,0,-7);
			$p .= "количеством предметов <B><font color=\"blue\">".$param1."</B></font>, ценовой коэффициент <font color=\"blue\"><B>".$param2;
			$n--;
		}
		else
		if($num==15)
		{
			$p .= "Может содержать квест <B><font color=\"blue\">".$param1." (".$q_name[$param1].")</B></font> с вероятностью <B><font color=\"blue\">".$param2."%";
		}
		else
		if($num==16)
		{
			$p .= "Арена";
		}
		else
		if($num==17)
		{
			$p .= "После победы происходит приключение <B><font color=\"blue\">".$param1." (".$enc_table[$param1].")";
		}
		else
		if($num==18)
		{
			$p .= "Повторяющийся квест кристалла";
		}
		else
		if($num==19)
		{
			$p .= "Изменяет настроение жителей в провинции на <B>".(($param1>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param1;
		}
		else
		if($num==20)
		{
			$p .= "Изменяет коррупцию в провинции на <B>".(($param1>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param1."%";
		}
		else
		if($num==21)
		{
			$p .= "Замена стандартного диалога на диалог <B><font color=\"blue\">".$param1." (".$dialog_table[$param1].")</B></font>. Сайт удаляется после обнаружения";
		}
		else
		if($num==22)
		{
//			$p .= "<font color=\"red\"><B>Ability: 22</B></font> (Бродячий торговец)";
			$p .= "Магазин бродячего торговца (ассортимент генерируется при встрече, а не при создании карты)";
		}
		else
		if($num==23)
		{
			$p=substr($p,0,-7);
			if($param1 != 0 && $param2 != 0)
			{
				$p .= ", к результату добавляется <B>($param1 * УС) + ($param2 * УС * УС) / 10 </B>золота ";
				$p .= "и <B>($param1 * [УС-1] / 8) + ($param2 * [УС-1] * УС) / 80 </B>кристаллов<br><B>УС</B> - Уровень сайта";
			}
			else
			if($param1 != 0)
			{
				$p .= ", к результату добавляется <B>($param1 * УС) </B>золота ";
				$p .= "и <B>($param1 * [УС-1] / 8) </B>кристаллов<br><B>УС</B> - Уровень сайта";
			}
			else
			{
				$p .= ", к результату добавляется <B>($param2 * УС * УС) / 10 </B>золота ";
				$p .= "и <B>($param2 * [УС-1] * УС) / 80 </B>кристаллов<br><B>УС</B> - Уровень сайта";
			}
			$n--;
//			$p .= ", результат корректируется в зависимости от уровня сайта";
		}
		else
			$p .= ($num==0 ? "" : "<B>!!!ERROR!!! NUM=".$num);
		$p .= "</font></B>";
		$p .= (($abil[$i][$j+1]['num']!="") ? "<br>" : "");
	}
//	$site_abil[$i]=substr($p,0,-11);
	if(isset($site_add[$i]))
	{
		for($k=0;$k<count($site_add[$i]);$k++)
		{
			$p .= "<br>".$n++.") ".$site_add[$i][$k];
		}
	}
	$site_abil[$i]=$p;
	$p="";
//	echo "</td></tr>";
}

//кого можно нанять/получить предмет (добавляется в конец)
$site_abil[26] .= "<br>(<font color=\"fuchsia\">Можно нанять юнитов</font> <B><font color=\"brown\">Скелет, Зомби, Упырь, Скелет Мрака, Чёрный рыцарь, Затронутый Смертью</font></B>)";
$site_abil[35] .= "<br>(<font color=\"fuchsia\">Можно нанять юнита</font> <B><font color=\"brown\">Горгулья</font></B>)";
$site_abil[42] .= "<br>(<font color=\"fuchsia\">Можно нанять юнита</font> <B><font color=\"brown\">Минотавр</font></B>)";
$site_abil[43] .= "<br>(<font color=\"fuchsia\">Можно нанять юнитов</font> <B><font color=\"brown\">Фея, Дриада</font></B>)";
$site_abil[44] .= "<br>(<font color=\"fuchsia\">Можно нанять юнита</font> <B><font color=\"brown\">Гарпия</font></B>)";
$site_abil[45] .= "<br>(<font color=\"fuchsia\">Можно нанять юнита</font> <B><font color=\"brown\">Тролль</font></B>)";
$site_abil[51] .= "<br>(<font color=\"fuchsia\">Можно нанять юнитов</font> <B><font color=\"brown\">Вор, Разбойник, Вольный стрелок, Убийца</font></B>)";
$site_abil[54] .= "<br>(<font color=\"fuchsia\">Можно присоединить к отряду героя юнита</font> <B><font color=\"brown\">Единорог</font></B> <font color=\"fuchsia\">уровня</font> (<B>0-5</B>))";
$site_abil[65] .= "<br>(<font color=\"fuchsia\">Можно получить предметы</font> <B><font color=\"blue\">Паучье яйцо, Яйцо птицелова</font></B>)";
$site_abil[66] .= "<br>(<font color=\"fuchsia\">Можно нанять юнита</font> <B><font color=\"brown\">Ведьмак</font></B>)";
$site_abil[67] .= "<br>(<font color=\"fuchsia\">Можно нанять юнита</font> <B><font color=\"brown\">Мастер меча</font></B>)";
$site_abil[68] .= "<br>(<font color=\"fuchsia\">Можно нанять юнитов</font> <B><font color=\"brown\">Пересмешник, Отродье, Чёрт, Адская гончая, Суккуб, Демон, Разрушитель, Владыка бездны, Дьявол</font></B>)";
$site_abil[69] .= "<br>(<font color=\"fuchsia\">Можно нанять юнитов</font> <B><font color=\"brown\">Эльф, Медиум, Следопыт, Меняющий Облик, Хранитель Леса, Владычица эльфов</font></B>)";
$site_abil[70] .= "<br>(<font color=\"fuchsia\">Можно нанять юнитов</font> <B><font color=\"brown\">Гном, Рунный кузнец, Алхимик, Подгорный страж, Мастер рун, \"Скорпион\", Сотрясатель Тверди, Колосс</font></B>)";
$site_abil[71] .= "<br>(<font color=\"fuchsia\">Можно нанять юнитов</font> <B><font color=\"brown\">Бука, Орк, Видящий духов, Рубака, Наездник на волке, Заклинатель духов, Бугай, Вожак</font></B>)";
$site_abil[72] .= "<br>(<font color=\"fuchsia\">Можно нанять юнитов</font> <B><font color=\"brown\">Людоящер, Загонщик, Шепчущий, Воин Топей, Чемпион Топей, Шипящий</font></B>)";
$site_abil[73] .= "<br>(<font color=\"fuchsia\">Можно нанять юнитов</font> <B><font color=\"brown\">Юный кентавр, Кентавр, Кентавр-воин, Говорящий-с-Духами, Кентавр-вождь</font></B>)";
$site_abil[74] .= "<br>(<font color=\"fuchsia\">Можно нанять юнитов</font> <B><font color=\"brown\">Гоблин, Охотник, Наездник на волке, Траппер, Повелитель тварей, Эрикуба</font></B>)";
$site_abil[75] .= "<br>(<font color=\"fuchsia\">Можно нанять юнитов</font> <B><font color=\"brown\">Половинчик, Травница, Ослик, Бард, Плут, Пограничник</font></B>)";
$site_abil[76] .= "<br>(<font color=\"fuchsia\">Можно нанять юнитов</font> <B><font color=\"brown\">Охотник на ведьм, Инквизитор, Карающая длань, Страж душ, Великий инквизитор, Фанатик веры</font></B>)";
$site_abil[79] .= "<br>(<font color=\"fuchsia\">Можно нанять юнитов</font> <B><font color=\"brown\">Ночная Тень, Кровавый мотылёк, Погонщик, Ночной охотник, Тёмная жрица, Страж Тьмы, Алчущий Тьмы, Избранная Тьмой</font></B>)";
//$site_abil[80] .= "<br>(<font color=\"fuchsia\">Можно нанять юнитов</font> <B><font color=\"brown\">Кобольд-раб, Погонщик, Ночной охотник, Страж Тьмы, Созерцатель</font></B>)";
$site_abil[90] .= "<br><font color=\"fuchsia\">Изменить золото игрока на</font><br><B><font color=\"green\"> +(150-300)*Уровень_провинции</font></B>;";
$site_abil[90] .= "<br><font color=\"fuchsia\">Изменить кристаллы игрока на</font><br><B><font color=\"green\"> +(50-90)*Уровень_провинции</font></B>;";
$site_abil[90] .= "<br><font color=\"fuchsia\">Получить случайный предмет типа</font> <B><font color=\"blue\">\"Луки и стрелы\"</font></B>, <font color=\"fuchsia\">уровня</font> <B>6</B>, <font color=\"fuchsia\">c редкостью не ниже</font> <B>5</B>;";
$site_abil[90] .= "<br><font color=\"fuchsia\">Получить случайный предмет типа</font> <B><font color=\"blue\">\"Кожа и пояса\"</font></B>, <font color=\"fuchsia\">уровня</font> <B>6</B>, <font color=\"fuchsia\">c редкостью не ниже</font> <B>5</B>;";
$site_abil[90] .= "<br><font color=\"fuchsia\">Получить случайный предмет типа</font> <B><font color=\"blue\">\"Луки и стрелы\"</font></B>, <font color=\"fuchsia\">уровня</font> <B>4</B>, <font color=\"fuchsia\">c редкостью не ниже</font> <B>4</B>";
$site_abil[91] .= "<br><font color=\"fuchsia\">Изменить золото игрока на</font><br><B><font color=\"green\"> +(250-400)*Уровень_провинции</font></B>;";
$site_abil[91] .= "<br><font color=\"fuchsia\">Изменить кристаллы игрока на</font><br><B><font color=\"green\"> +(20-40)*Уровень_провинции</font></B>;";
$site_abil[91] .= "<br><font color=\"fuchsia\">Получить случайный предмет типа</font> <B><font color=\"blue\">\"Знамёна\"</font></B>, <font color=\"fuchsia\">уровня</font> <B>6</B>, <font color=\"fuchsia\">c редкостью не ниже</font> <B>5</B>;";
$site_abil[91] .= "<br><font color=\"fuchsia\">Получить случайный предмет типа</font> <B><font color=\"blue\">\"Кольчуги\"</font></B>, <font color=\"fuchsia\">уровня</font> <B>6</B>, <font color=\"fuchsia\">c редкостью не ниже</font> <B>5</B>;";
$site_abil[91] .= "<br><font color=\"fuchsia\">Получить случайный предмет типа</font> <B><font color=\"blue\">\"Украшения\"</font></B>, <font color=\"fuchsia\">уровня</font> <B>6</B>, <font color=\"fuchsia\">c редкостью не ниже</font> <B>5</B>";
$site_abil[92] .= "<br><font color=\"fuchsia\">Изменить золото игрока на</font><br><B><font color=\"green\"> +(100-200)*Уровень_провинции</font></B>;";
$site_abil[92] .= "<br><font color=\"fuchsia\">Изменить кристаллы игрока на</font><br><B><font color=\"green\"> +(40-80)*Уровень_провинции</font></B>;";
$site_abil[92] .= "<br><font color=\"fuchsia\">Получить случайный предмет типа</font> <B><font color=\"blue\">\"Оружие и щиты\"</font></B>, <font color=\"fuchsia\">уровня</font> <B>5</B>, <font color=\"fuchsia\">c редкостью не ниже</font> <B>5</B>;";
$site_abil[92] .= "<br><font color=\"fuchsia\">Получить случайный предмет типа</font> <B><font color=\"blue\">\"Оружие и щиты\"</font></B>, <font color=\"fuchsia\">уровня</font> <B>5</B>, <font color=\"fuchsia\">c редкостью не ниже</font> <B>4</B>;";
$site_abil[92] .= "<br><font color=\"fuchsia\">Получить случайный предмет типа</font> <B><font color=\"blue\">\"Латы\"</font></B>, <font color=\"fuchsia\">уровня</font> <B>6</B>, <font color=\"fuchsia\">c редкостью не ниже</font> <B>5</B>";
$site_abil[92] .= "<br><font color=\"fuchsia\">Получить случайный предмет типа</font> <B><font color=\"blue\">\"Оружие и щиты\"</font></B>, <font color=\"fuchsia\">уровня</font> <B>6</B>, <font color=\"fuchsia\">c редкостью не ниже</font> <B>5</B>";
$site_abil[93] .= "<br><font color=\"fuchsia\">Изменить золото игрока на</font><br><B><font color=\"green\"> +(150-300)*Уровень_провинции</font></B>;";
$site_abil[93] .= "<br><font color=\"fuchsia\">Изменить кристаллы игрока на</font><br><B><font color=\"green\"> +(50-90)*Уровень_провинции</font></B>;";
$site_abil[93] .= "<br><font color=\"fuchsia\">Получить случайный предмет типа</font> <B><font color=\"blue\">\"Жезлы и сферы\"</font></B>, <font color=\"fuchsia\">уровня</font> <B>5</B>, <font color=\"fuchsia\">c редкостью не ниже</font> <B>4</B>;";
$site_abil[93] .= "<br><font color=\"fuchsia\">Получить случайный предмет типа</font> <B><font color=\"blue\">\"Одежда\"</font></B>, <font color=\"fuchsia\">уровня</font> <B>5</B>, <font color=\"fuchsia\">c редкостью не ниже</font> <B>4</B>;";
$site_abil[93] .= "<br><font color=\"fuchsia\">Получить случайный предмет типа</font> <B><font color=\"blue\">\"Свитки\"</font></B>, <font color=\"fuchsia\">уровня</font> <B>4</B>, <font color=\"fuchsia\">c редкостью не ниже</font> <B>1</B>";
$site_abil[93] .= "<br><font color=\"fuchsia\">Получить случайный предмет типа</font> <B><font color=\"blue\">\"Свитки\"</font></B>, <font color=\"fuchsia\">уровня</font> <B>3</B>, <font color=\"fuchsia\">c редкостью не ниже</font> <B>1</B>";
$site_abil[94] .= "<br>(<font color=\"fuchsia\">Можно нанять юнитов</font> <B><font color=\"brown\">Воин Стаи, Мучитель, Тиран, Пожиратель</font></B>)";
$site_abil[96] .= "<br>(<font color=\"fuchsia\">Можно нанять юнитов</font> <B><font color=\"brown\">Икар, Светоч, Ловчий, Свидетель, Воспрявший Светоч, Хранитель памяти, Вечный ментор</font></B>)";
$site_abil[98] .= "<br>(<font color=\"fuchsia\">Можно присоединить к отряду героя юнита</font> <B><font color=\"brown\">Ликан</font></B> <font color=\"fuchsia\">уровня</font> (<B>1-4</B>))";
$site_abil[108] .= ", <font color=\"fuchsia\">где можно получить 2 предмета</font> <B><font color=\"blue\">Икра слизня</font></B>";
$site_abil[109] .= "<br>(<font color=\"fuchsia\">Можно нанять юнита</font> <B><font color=\"brown\">Крысолюд</font></B>)";
$site_abil[113] .= "<br>(<font color=\"fuchsia\">Можно нанять юнита</font> <B><font color=\"brown\">Коготь тени</font></B>)";
$site_abil[114] .= "<br>(<font color=\"fuchsia\">Можно нанять юнита</font> <B><font color=\"brown\">Чумной воин</font></B>)";
$site_abil[126] .= "<br>(<font color=\"fuchsia\">Можно присоединить к отряду героя юнита</font> <B><font color=\"brown\">Охотник на ведьм</font></B> <font color=\"fuchsia\">уровня</font> (<B>4-7</B>))";
$site_abil[142] .= "<br>(<font color=\"fuchsia\">Можно присоединить к отряду героя юнитов</font> <B><font color=\"brown\">Целитель</font></B> <font color=\"fuchsia\">уровня</font> (<B>1-3</B>) <font color=\"fuchsia\">или </font><B><font color=\"brown\">Лекарь</font></B> <font color=\"fuchsia\">уровня</font> (<B>2-6</B>))";

//вывод полной таблицы
for($i=1;$i<10;$i++)//ресурсы (с двумя диалогами)
{
	echo "<tr><td align=center>$i</td><td>$name_table[$i]</td><td></td><td>$site_abil[$i]</td><td>";
	echo "$site_terrain[$i]</td><td>$site_guard[$i]</td><td align=center>$place[$i]</td><td>";
	echo "<B><font color=\"fuchsia\">(Сайт с охраной)</font></B><br>".str_replace("Пусто","",$dialog_text[$site_dialog_num[$i]])."</td><td>";
	echo "<B><font color=\"fuchsia\">(Сайт без охраны)</font></B><br>".str_replace("Пусто","",$dialog_text[$site_dialog_num_2[$i]])."</td><td>";
	echo "$enc_dialog[$i]</td><td align=center>$MinLevel[$i]</td><td align=center>$MaxLevel[$i]</td><td align=center>";
	echo "$Difficult[$i]</td><td align=center>$Treasure[$i]</td><td align=center>$WorkHide[$i]</td><td align=center>$WorkGuard[$i]";
	echo "</td><td align=center>$WorkFree[$i]</td><td align=center>$CanEnter[$i]</td><td align=center>$SelfDestroy[$i]</td><td>";
	echo "$site_txt[$i]</td><td>$site1_txt[$i]</td></tr>";
}
for($i=10;$i<$max+1;$i++)
{
	echo "<tr><td align=center>$i</td><td>$name_table[$i]</td><td></td><td>$site_abil[$i]</td><td>";
	echo "$site_terrain[$i]</td><td>$site_guard[$i]</td><td align=center>$place[$i]</td><td colspan=2>";
	echo str_replace("Пусто","",$dialog_text[$site_dialog_num[$i]])."</td><td>";
	echo "$enc_dialog[$i]</td><td align=center>$MinLevel[$i]</td><td align=center>$MaxLevel[$i]</td><td align=center>";
	echo "$Difficult[$i]</td><td align=center>$Treasure[$i]</td><td align=center>$WorkHide[$i]</td><td align=center>$WorkGuard[$i]";
	echo "</td><td align=center>$WorkFree[$i]</td><td align=center>$CanEnter[$i]</td><td align=center>$SelfDestroy[$i]</td><td>";
	echo "$site_txt[$i]</td><td>$site1_txt[$i]</td></tr>";
}
echo "</table><br><br>";

?>
<br><a href='index.html'>вернуться к списку файлов</a>
</html>