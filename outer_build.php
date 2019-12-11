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
$a_file = file("outer_build.var");
$d_file = file("dialog.var");
$e_file = file("encounter.var");
$event_file = file("event.var");
$b_file = file("inner_build.var");
$site_file = file("site.var");
$ritual_file = file("ritual.var");
$ritual_txt_file = file("Ritual.txt");
$count_ritual_txt = count($ritual_txt_file);
$count_ritual = count($ritual_file);
$count_site = count($site_file);
$count_b = count($b_file);
$count_e = count($e_file);
$count_event = count($event_file);
$count_d = count($d_file);
$count_f = count($a_file);
$out_file = file("Outer_Build.txt");
$count_out = count($out_file);
$outer_event_file = file("outer_event.exp");
$outer_enc_file = file("outer_enc.exp");

$max=0;$max1=0;$max_u=0;$max_e=0;$t[0]=0;$j=0;
$u1=-1;$u2=0;$u3=0;	//№ строки юнита в xls
$g1=0; //кол-во стражей в одном сайте
$a1=0; //№ абилки
$a2=0; //№ эффекта ritual
$e1=0; //№ эффекта
$up1=0; //число upg_type в unit_upg
$u_a=0; //абилки in unit.var
$p=""; //для печати без последней ";"

$res_name=array(1=>"Железо", "Красное дерево", "Кони", "Мандрагора", "Арканит", "Мрамор", "Мифрил", "Дионий", "Чёрный лотос");

//разбор outer_event.exp
for($i = 0; $i < count($outer_event_file); $i++)
{
	$str = trim($outer_event_file[$i]);
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
			$EventGroupName[$s[1]] = $s[2];//имя группы событий для получения постройки
			$outer_event_cnt[$s[0]] = $s[3];//к-во чертежей постройки
		}
	}
}

foreach($export_outer_event as $outer => $ev)
{
	foreach($ev as $i)
	{
			//доп. способы получения постройки
			$outer_add[$outer][] = "Можно возвести постройку в текущей провинции от <B>группы событий (group_event) <font color=\"blue\">$i (".$EventGroupName[$i].")</font></B>";
	}
}

foreach($export_outer_event_scroll as $outer => $ev)
{
	foreach($ev as $i)
	{
			$p = "";
			$cnt = $outer_event_cnt[$outer];
			$p .= "Можно получить <B><font color=\"blue\">".$cnt." </font></B>";
			if($cnt==1)
				$p .= "чертёж";
			else
			if($cnt>1 && $cnt<5)
				$p .= "чертежа";
			else
				$p .= "чертежей";
			$p .= " постройки от <B>группы событий (group_event) <font color=\"blue\">$i (".$EventGroupName[$i].")</font></B>";
			$outer_add[$outer][] = $p;//доп. способы получения постройки
	}
}

//разбор outer_enc.exp
for($i = 0; $i < count($outer_enc_file); $i++)
{
	$str = trim($outer_enc_file[$i]);
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
			$EncGroupName[$s[1]] = $s[2];//имя группы приключений для получения постройки
			$outer_enc_cnt[$s[0]] = $s[3];//к-во чертежей постройки
		}
	}
}

foreach($export_outer_enc as $outer => $enc)
{
	foreach($enc as $i)
	{
			//доп. способы получения постройки
			$outer_add[$outer][] = "Можно возвести постройку в текущей провинции от <B>группы приключений (group_enc) <font color=\"blue\">$i (".$EncGroupName[$i].")</font></B>";
	}
}

foreach($export_outer_enc_scroll as $outer => $enc)
{
	foreach($enc as $i)
	{
			$p = "";
			$cnt = $outer_enc_cnt[$outer];
//			$s = explode("|",$str);//outer_build|EncGroup|EncGroupName|scroll_num
			$p .= "Можно получить <B><font color=\"blue\">".$cnt." </font></B>";
			if($cnt==1)
				$p .= "чертёж";
			else
			if($cnt>1 && $cnt<5)
				$p .= "чертежа";
			else
				$p .= "чертежей";
			$p .= " постройки от <B>группы приключений (group_enc) <font color=\"blue\">$i (".$EncGroupName[$i].")</font></B>";
			$outer_add[$outer][] = $p;//доп. способы получения постройки
	}
}

//Разбор Outer_Build.txt
for($i = 0; $i < $count_out; $i++)
{
	if(eregi("^([0-9]{1,})\.",$out_file[$i],$k))
	{
		$n=$k[1];
		if($n>$max1)$max1=$n;
		$flag = 0;
//		$i++;
	}
	else
	if(trim($out_file[$i]) == "")
	{}
	else
	if(substr(trim($out_file[$i]),0,1)=="#")
	{
		if($flag == 0)//первая #
		{
			$out_txt[$n] .= ((substr(trim($out_file[$i]),-1,1)=="#") ? substr(trim($out_file[$i]),1,-1) : substr($out_file[$i],1)."<br>");
			$out_txt_idx[$n] = $i;//в какую строку добавлять спойлеры о карме/коррупции
			$out_txt_idx2[$i] = $n;
			$flag = 1;
		}
		else
			$out_txt[$n] = substr($out_txt[$n],0,-4);//в txt зачем-то есть одиночные '#' => убираем предыдущий <br>

	}
	else
	if(substr(trim($out_file[$i]),-1,1)=="#")
	{
		$out_txt[$n] .= substr(trim($out_file[$i]),0,-1);
		$out_txt_idx_end[$i] = $n;//номер здания (для добавления спойлера в конец описания)
	}
	else
		$out_txt[$n] .= $out_file[$i]."<br>";
/*
	if(eregi("^([0-9]{1,})\.",$out_file[$i],$k))
	{
		$n=$k[1];
		if($n>$max1)$max1=$n;
	}
	else
	{
		if(substr($out_file[$i],0,1)=="#")
		{
			$out_txt[$n] .= ((substr(trim($out_file[$i]),-1,1)=="#") ? substr(trim($out_file[$i]),1,-1) : substr($out_file[$i],1)."<br>");
			$out_txt_idx[$n] = $i;//в какую строку добавлять спойлеры о карме/коррупции
			$out_txt_idx2[$i] = $n;
		}
		else
		if(trim($out_file[$i])!="")
		{
			if(substr(trim($out_file[$i]),-1,1)=="#")
			{
				$out_txt[$n] .= substr(trim($out_file[$i]),0,-1);
				$i++;
			}
			else
				$out_txt[$n] .= $out_file[$i]."<br>";
		}
	}
*/
/*
	if(substr($out_file[$i],0,1)=="#")
	    $out_txt[$n]=$out_txt[$n].substr($out_file[$i],1)."<br>";
	else
	    if(substr(trim($out_file[$i]),-1,1)=="#")
	    {
			$out_txt[$n]=$out_txt[$n].substr(trim($out_file[$i]),0,-1);
			$i++;
	    }
	    else
			$out_txt[$n]=$out_txt[$n].$out_file[$i]."<br>";
*/
}
//dumper($out_txt_idx,"out_txt_idx");
//dumper($out_txt_idx2,"out_txt_idx2");

//Разбор Ritual.txt
for($i = 0; $i < $count_ritual_txt; $i++)
{  
    if(eregi("^([0-9]{1,})",$ritual_txt_file[$i],$k))
    {
		$n=$k[1];
		if($n>$max1)$max1=$n;
    }
    else
	if((substr($ritual_txt_file[$i],0,1)=="#") && (substr(trim($ritual_txt_file[$i]),-1,1)=="#"))
	{
		$ritual_txt[$n] = substr(trim($ritual_txt_file[$i]),1,-1);
		$ritual_txt_idx[$n] = $i;//в какую строку добавлять спойлеры о карме/коррупции
		$ritual_txt_idx2[$i] = $n;
		$i++;
	}
	else
	if(substr($ritual_txt_file[$i],0,1)=="#")
	{
		$ritual_txt[$n] = substr($ritual_txt_file[$i],1)."<br>";
		$ritual_txt_idx[$n] = $i;//в какую строку добавлять спойлеры о карме/коррупции
		$ritual_txt_idx2[$i] = $n;
	}
	else
	if(substr(trim($ritual_txt_file[$i]),-1,1)=="#")
	{
		$ritual_txt[$n] .= substr(trim($ritual_txt_file[$i]),0,-1);
		$i++;
	}
	else
		$ritual_txt[$n] .= $ritual_txt_file[$i]."<br>";
	$ritual_txt[$n] = str_replace("~","%",$ritual_txt[$n]);
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
				echo $n."- Дубль SITE=".$s;
				$s = $s."<font color=\"fuchsia\">*</font>";
				echo " <B>Замена на</B> ".$s."<br>";
			}
			$site_name[$n]=$s;
		}
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
			if($build_abil==11)
			//Открывает доступ к внешней постройке Param1.Если Param2>0 - дает Param2 чертежей этой постройки
			{
				$p=$build_name[$n];
				if($build_param2>0)
				{
					$p .= "<br>(даёт <B><font color=\"blue\">$build_param2</font></B> ";
					if($build_param2==1)
						$p .= "чертёж";
					else
					if(($build_param2>1) && ($build_param2<5))
						$p .= "чертежа";
					else
						$p .= "чертежей";
					$p .= " постройки)";
				}
				$build_table[$build_param1]=$p;
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
	else
	if(eregi("^\*Effects\*:",$event_file[$i]))
	{
		for($j=0;$j<16;$j++) //четвёрки эффектов
		{
			$p = "";
			while(1)
				if(trim($event_file[$i+1]) == "") //пустая строка
					$i++;
				else
					break;
			$i++;
			$s=explode(':',$event_file[$i]);
			$event_effects[$n][$j]['num']=$s[1];
			$num = $s[1]+1-1;
			while(1)
				if(trim($event_file[$i+1]) == "") //пустая строка
					$i++;
				else
					break;
			$i++;
			$s=explode(':',$event_file[$i]);
			$power = $s[1]+1-1;
			//echo "-".$s[1];
			while(1)
				if(trim($event_file[$i+1]) == "") //пустая строка
					$i++;
				else
					break;
			$i++;
			$s=explode(':',$event_file[$i]);
			$param1 = $s[1]+1-1;
			while(1)
				if(trim($event_file[$i+1]) == "") //пустая строка
					$i++;
				else
					break;
			$i++;
			$s=explode(':',$event_file[$i]);
			$param2 = $s[1]+1-1;
			if($num==12)//Получить Param1 чертежей постройки Power
			{
			}
			$i++; //пустая строка
			if(substr(trim($event_file[$i-1]),-1,1)==";") 
			{
				break; //for $j
			}
		}
	}
}
dumper($outer_add,"outer_add");
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
    if(eregi("^Plain",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		if(($s[1]+1-1)!=0) $terrain[$n] .= "Равнины; ";
//echo $n."-".$terrain[$n][0]."<br>";
//echo $n."-".substr($terrain[$n][0],9);
    }
    else
    if(eregi("^Forest",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		if(($s[1]+1-1)!=0) $terrain[$n] .= "Леса; ";
    }
    else
    if(eregi("^Hill",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		if(($s[1]+1-1)!=0) $terrain[$n] .= "Холмы; ";
    }
    else
    if(eregi("^Swamp",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		if(($s[1]+1-1)!=0) $terrain[$n] .= "Болота; ";
    }
    else
    if(eregi("^Upgrade:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$Upgrade[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^Building:",$a_file[$i]))//obsolete :(
    {
//		$s=explode(':',$a_file[$i]);
//		if(($s[1]+1-1)!=0) $build_table[$n] .= $build_name[$s[1]+1-1];
//echo $n."-".$build_table[$n]."<br>";
    }
    else
    if(eregi("^GoldCost:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$GoldCost[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^GemCost:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$GemCost[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^GoldAdd:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$GoldAdd[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^GemAdd:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$GemAdd[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^GoldPerc:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$GoldPerc[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^GemPerc:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$GemPerc[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^Mood:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$Mood[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^Attitude:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$Attitude[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^Grow:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$Grow[$n]=$s[1]+1-1;
		if($Grow[$n] != 0)
			$grow_flag[$out_txt_idx[$n]] = $s[1]+1-1;//№ строки в Outer_Build.txt, куда надо вставить спойлер о приросте населения
    }
    else
    if(eregi("^Karma:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$Karma[$n]=$s[1]+1-1;
		if($Karma[$n] != 0)
			$karma_flag[$out_txt_idx[$n]] = $s[1]+1-1;//№ строки в Outer_Build.txt, куда надо вставить спойлер о карме
    }
    else
    if(eregi("^Heal:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$Heal[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^Coastal:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$Coastal[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^Wall:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$Wall[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^TowerHealth:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		if(($s[1]+1-1)!=0) $TowerHealth[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^TowerShoot:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		if(($s[1]+1-1)!=0) $TowerShoot[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^TowerType:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$TowerType[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^Library:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$library[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^Shop:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$shop[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^Port:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$port[$n]=$s[1]+1-1;
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
    else
    if(eregi("^ResourceBonus:",$a_file[$i]))
    {
		for($j=0;$j<16;$j++)
		{
			$i++;
			$s=explode(':',$a_file[$i]);
			$res_bonus[$n][$j]['res']=$s[1]+1-1;
			$i++;
			$s=explode(':',$a_file[$i]);
			$res_bonus[$n][$j]['bonus']=$s[1]+1-1;
			$i++; //пустая строка
//echo "LAST=".substr(trim($enc_file[$i-1]),-1,1)."<br>";
			if(substr(trim($a_file[$i-1]),-1,1)==";") 
			{
//echo "BREAK<br>";			
				break; //for $j
			}
		}
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
		$ob_res[$i] .= $res_table[$i][$j].(($res_table[$i][$j+1]=="") ? "" : "; ");
	}
//	echo "</td></tr>";
}


//местность
for($i=0;$i<$max+1;$i++)
{
/*
	echo "<tr><td>$i</td><td>";
	for($j=0;$j<4;$j++)
	{ 
		$s=trim(substr($terrain[$i][$j],9)+1-1);
		if($s!=0)
//			echo rtrim($terrain[$i][$j]).";";
			$p=$p.rtrim($terrain[$i][$j]).";";
	}
	echo substr($p,0,strlen($p)-1);
	$p="";
	echo "</td></tr>";
*/
//echo $i."-".$terrain[$i]."<br>";
	if(count(explode(";",$terrain[$i]))==5)
	{
		$ob_terrain[$i]="Везде";
	}
	else
	{
		$ob_terrain[$i]=substr($terrain[$i],0,-2);
	}
	if($Coastal[$i]==1)
		$ob_terrain[$i] .= "<br>(только на берегу)";
}
//echo "</tr></table><br>";

//Абилки построек
for($i=0,$j=0;$i<$max+1;$i++)
{ 
//	echo "<tr><td>$i ($name_table[$i])</td><td>";
	$n=1;
	if($Upgrade[$i]>0)
	{
		$p .= $n.") Улучшение постройки <B><font color=\"blue\">".$name_table[$Upgrade[$i]]."</font></B><br>";
		$n++;
	}
	for($k=0;($res_bonus[$i][$k]['res']!="")&&($k<16);$k++,$n++)
	{
		$res=$res_bonus[$i][$k]['res']+1-1;
		$bonus=$res_bonus[$i][$k]['bonus']+1-1;
		$p .= $n.") ";
		$p .= "Доход от ресурса <font color=\"blue\"><B>".$res_name[$res]."</font>";
		$p .= ($bonus>0 ? " <font color=\"green\">+" : " <font color=\"red\">").$bonus."</font></B><br>";
	}
	if($library[$i]>0)
	{
		$p .= $n.") Доступ к библиотеке из этой провинции<br>";
		$n++;
	}
	if($shop[$i]>0)
	{
		$p .= $n.") Доступ к торговле и сокровищнице из этой провинции<br>";
		$n++;
	}
	if($port[$i]>0)
	{
		$p .= $n.") Позволяет герою перемещаться через прилежащую морскую провинцию<br>";
		$n++;
	}
	for(;($abil[$i][$j]['num']!="") && ($j<10000);$j++,$n++)
	{
		$num=$abil[$i][$j]['num']+1-1;
		$param1=$abil[$i][$j]['param1']+1-1;
		$param2=$abil[$i][$j]['param2']+1-1;
		if($num!=0)
			$p .= $n.") ";
		if($num==1)
		{
			$p .= "Нельзя сносить";
		}
		else
		if($num==2)
		{
			$p .= "Ускорение героя на <B><font color=\"green\">$param1</font></B>";
		}
		else
		if($num==3)
		{
			$p .= "Увеличивает настроение на <B>".(($param1>0) ? "<font color=\"green\">+" : "<font color=\"red\">");
			$p .= $param1."</font></B>, если в замке есть постройка <B><font color=\"blue\">".$build_name[$param2];
		}
		else
		if($num==4)
		{
			$p .= "Гарнизон <B><font color=\"blue\">".$param1."</font></B> уровень. Количество войск: <B><font color=\"blue\">".$param2;
		}
		else
		if($num==5)
		{
			$p .= "Замедляет накопление недовольства на <B>";
			$p .= (($param1>0) ? "<font color=\"green\">" : "<font color=\"red\">").$param1;
			$out_txt_add[$i] .= "Замедляет накопление недовольства на $param1\n";
		}
		else
		if($num==6)
		{
			$p .= "Увеличивает доход на <B>".(($param1>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param1;
			$p .= "</font></B>, если в замке есть постройка <B><font color=\"blue\">".$build_name[$param2];
		}
		else
		if($num==7)
		{
			$p .= "Изменяет шанс события <B><font color=\"blue\">".$param1." (".$event_table2[$param1].")</font></B> на <B>";
			$p .= (($param2>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param2."%";
			$out_txt_add[$i] .= "Изменяет шанс события ".$param1." (".$event_table2[$param1].") на ";
			$out_txt_add[$i] .= (($param2>0) ? "+" : "").$param2."~\n";
		}
		else
		if($num==8)
		{
			$p .= "Существует чертёж постройки: уровень <B><font color=\"blue\">".$param1."</font></B>, редкость <B><font color=\"blue\">".$param2;
		}
		else
		if($num==9)
		{
			$p .= "Изменяет уровень коррупции в провинции на <B>";
			$p .= (($param1>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param1."%";
			$cor_flag[$out_txt_idx[$i]] = $param1;//№ строки в Outer_Build.txt, куда надо вставить спойлер о карме
		}
		else
		if($num==10)
		{
			$p .= "Изменяет боевой дух защитников провинции на <B>";
			$p .= (($param1>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param1;
		}
		else
		if($num==11)
		{
			$p .= "Увеличивает радиус обзора";
		}
		else
		if($num==12)
		{
			$p .= "При строительстве в провинции появляется сайт <B><font color=\"blue\">".$site_name[$param1]."</font></B>, уровень <B><font color=\"blue\">".$param2;
		}
		else
		if($num==13)
		{
			$p .= "При сносе постройки уничтожается сайт <B><font color=\"blue\">".$site_name[$param1];
		}
		else
		if($num==14)
		{
			$p .= "Возведение постройки не уменьшает лимит строительства внешних зданий в ход.";
		}
		else
		if($num==15)
		{
			$p .= "Позволяет герою использовать ритуал <B><font color=\"blue\">".$ritual_name[$param1]."</B></font> (только в этой провинции)";
			$out_txt_add[$i] .= "Ритуал $ritual_name[$param1]: ".$ritual_txt[$param1];
		}
		else
		if($num==16)
		{
			$p .= "Наделяет охрану провинции неустрашимостью (они не отступают при превосходстве противника в мощи).";
		}
		else
			$p .= ($num==0 ? "" : "<B>!!!ERROR!!! NUM=".$num);
		$p .= "</font></B>";
		if($abil[$i][$j+1]['num']!="") $p .= "<br>";
	}
	if(isset($outer_add[$i]))
	{
		for($k=0;$k<count($outer_add[$i]);$k++)
		{
			$p .= "<br>".$n++.") ".$outer_add[$i][$k]."</font></B>";
		}
	}
	$ob_abil[$i]=substr($p,0,-11);
	if(isset($out_txt_add[$i]))
		$out_txt_add[$i] = substr($out_txt_add[$i],0,-1);
	$p="";
}

dumper($out_txt_add,"out_txt_add");
//вывод полной таблицы
echo "<table border=1>";

for($i=1;$i<$max1+1;$i++)
{
	echo "<tr><td align=center>$i</td><td>$name_table[$i]</td><td></td><td>";
	echo str_replace("~","%",$out_txt[$i])."</td><td>$ob_abil[$i]</td><td>";
	echo "$ob_terrain[$i]</td><td align=center>$GoldCost[$i]</td><td align=center>$GemCost[$i]</td><td>";
	echo "$ob_res[$i]</td><td>$build_table[$i]</td><td></td><td></td><td></td><td></td><td>";
	echo "</td><td></td><td align=center>$TowerHealth[$i]</td><td align=center>$TowerShoot[$i]</td></tr>";
//	echo "</td></tr>";
//	echo str_replace("~","%",$out_txt[$i])."</td></tr>";
}

echo "</table><br>";
?>
<style>
td
{mso-number-format:"\@";}
</style>
<?php
//вывод разноцветной фигни
echo "<table border=1>";

//доход
for($i=0;$i<$max+1;$i++)
{
	if($GoldAdd[$i]!=0)
	{
		if($GoldAdd[$i]>0)
			$ob_gold[$i] .= "<font color=\"green\">+";
		else
		if($GoldAdd[$i]<0)
			$ob_gold[$i] .= "<font color=\"red\">";
		$ob_gold[$i] .= $GoldAdd[$i]."</font>";
	}
	if($GoldPerc[$i]!=0)
	{
		if($GoldPerc[$i]!=0)
			$ob_gold[$i] .= "<br>";
		if($GoldPerc[$i]>0)
			$ob_gold[$i] .= "<font color=\"green\">+";
		else
		if($GoldPerc[$i]<0)
			$ob_gold[$i] .= "<font color=\"red\">";
		$ob_gold[$i] .= $GoldPerc[$i]."%</font>";
	}
	if($GemAdd[$i]!=0)
	{
		if($GemAdd[$i]>0)
			$ob_gem[$i] .= "<font color=\"green\">+";
		else
		if($GemAdd[$i]<0)
			$ob_gem[$i] .= "<font color=\"red\">";
		$ob_gem[$i] .= $GemAdd[$i]."</font>";
	}
	if($GemPerc[$i]!=0)
	{
		if($GemAdd[$i]!=0)
			$ob_gem[$i] .= "<br>";
		if($GemPerc[$i]>0)
			$ob_gem[$i] .= "<font color=\"green\">+";
		else
		if($GemPerc[$i]<0)
			$ob_gem[$i] .= "<font color=\"red\">";
		$ob_gem[$i] .= $GemPerc[$i]."%</font>";
	}
	if($Mood[$i]!=0)
	{
		if($Mood[$i]>0)
			$ob_mood[$i] .= "<font color=\"green\">+";
		else
		if($Mood[$i]<0)
			$ob_mood[$i] .= "<font color=\"red\">";
		$ob_mood[$i] .= $Mood[$i]."</font>";
	}
	if($Karma[$i]!=0)
	{
		if($Karma[$i]>0)
			$ob_karma[$i] .= "<font color=\"green\">+";
		else
		if($Karma[$i]<0)
			$ob_karma[$i] .= "<font color=\"red\">";
		$ob_karma[$i] .= $Karma[$i]."</font>";
	}
	if($Grow[$i]!=0)
	{
		if($Grow[$i]>0)
			$ob_grow[$i] .= "<font color=\"green\">+";
		else
		if($Grow[$i]<0)
			$ob_grow[$i] .= "<font color=\"red\">";
		$ob_grow[$i] .= $Grow[$i]."</font>";
	}
	if($Heal[$i]!=0)
	{
		if($Heal[$i]>0)
			$ob_heal[$i] .= "<font color=\"green\">+";
		else
		if($Heal[$i]<0)
			$ob_heal[$i] .= "<font color=\"red\">";
		$ob_heal[$i] .= $Heal[$i]."%</font>";
	}
	echo "<tr><td>$i ($name_table[$i])</td><td align=center>$ob_gold[$i]</td><td align=center>$ob_gem[$i]</td>";
	echo "<td align=center>$ob_mood[$i]</td><td align=center>$ob_karma[$i]</td><td align=center>";
	echo "$ob_grow[$i]</td><td align=center>$ob_heal[$i]</td></tr>";
}
/*
//вывод спойлера о карме/коррупции
$p = "";
$f=fopen("Outer_Build_spoil.txt","w") or die("Ошибка при создании файла Outer_Build_spoil.txt");
for($i = 0; $i < $count_out; $i++)
{
	if($karma_flag[$i] != 0)
		$p .= "#[Карма: ".($karma_flag[$i] > 0 ? "+" : "").$karma_flag[$i]."]\n";
	if($cor_flag[$i] != 0)
		$p .= "#[Коррупция: ".($cor_flag[$i] > 0 ? "+" : "").$cor_flag[$i]."~]\n";
	if($karma_flag[$i] != 0 || $cor_flag[$i] != 0)
		$p .= substr($out_file[$i],1);
	else
		$p = $out_file[$i];
	fwrite($f,$p);
}
fclose($f);
*/

//вывод спойлера о карме
$f=fopen("Outer_Build_spoil.txt","w") or die("Ошибка при создании файла Outer_Build_spoil.txt");
for($i = 0; $i < $count_out; $i++)
{
//	if($karma_flag[$i] != 0 || $grow_flag[$i] != 0)
	if(isset($out_txt_idx2[$i]))//добавка в начале
	{
		$idx = $out_txt_idx2[$i];
		fwrite($f,"#");
		if($karma_flag[$i] != 0)
			fwrite($f,"[Карма: ".($karma_flag[$i] > 0 ? "+" : "").$karma_flag[$i]."]\n");
		if($grow_flag[$i] != 0)
			fwrite($f,"[Прирост населения: ".($grow_flag[$i] > 0 ? "+" : "").$grow_flag[$i]."]\n");
		if($karma_flag[$i] != 0 || $grow_flag[$i] != 0)
			fwrite($f,"\n");//отделительная строка между спойлером и описанием
		fwrite($f,substr($out_file[$i],1));
	}
	else
	if(isset($out_txt_idx_end[$i]))//добавка в конце
	{
		$idx = $out_txt_idx_end[$i];
		fwrite($f,substr(trim($out_file[$i]),0,-1));
		if(isset($out_txt_add[$idx]))
			fwrite($f,"\n\n[".$out_txt_add[$idx]."]");
		fwrite($f,"#\n");
	}
	else
		fwrite($f,$out_file[$i]);
}
fclose($f);

?>
<br><a href='index.html'>вернуться к списку файлов</a>
</html>