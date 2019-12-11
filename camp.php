<html><head>
<meta http-equiv="Content-Type" content="text/html charset=windows-1251">
<title>Эадор - События Кампании</title></head><body>
<?php
$c_file = file("camp_event.var");
$count_c = count($c_file);
$d_file = file("campaign_dialog.var");
$count_d = count($d_file);
$question_file = file("question.var");
$count_question = count($question_file);
$q_file = file("quest.var");
$count_q = count($q_file);
$p_file = file("players.var");
$count_p = count($p_file);
$j_file = file("journal.txt");
$count_j = count($j_file);
$event_file = file("event.var");
$count_event = count($event_file);
$enc_file = file("encounter.var");
$count_enc = count($enc_file);

$q_file_name="quest_Eador_NH_18.0601.htm";
//$q_file_name="eador_quest.htm";
$event_file_name="event_Eador_NH_18.0601.htm";
//$event_file_name="eador_event.htm";
$enc_file_name="encounter_Eador_NH_18.0601.htm";
//$enc_file_name="eador_encounter.htm";

$dialog_param = array (1=>"имя игрока","величина из первого эффекта",10=>"расширенный диалог");
//$nastr = array(-5=>"Полны ненависти",-4=>"В ярости",-3=>"Возмущены",-2=>"Очень недовольны",-1=>"Недовольны","Спокойны","Довольны","Очень довольны","Счастливы");

$max=0;$max1=0;$max_u=0;$max_e=0;$t[0]=0;$j=0;$in_flag=0;
$u1=-1;$u2=0;$u3=0;	//№ строки юнита в xls
$g1=0; //кол-во стражей в одном сайте
$a1=0; //№ абилки
$a2=0; //№ эффекта ritual
$e1=0; //№ эффекта
$up1=0; //число upg_type в unit_upg
$u_a=0; //абилки in unit.var

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
			$enc_effects[$n][$j]['num']=$s[1];
//echo $n."-".$enc_effects[$n][$j]['num']."<br>";;
			while(1)
				if(trim($enc_file[$i+1]) == "") //пустая строка
					$i++;
				else
					break;
			$i++;
			$s=explode(':',$enc_file[$i]);
			$enc_effects[$n][$j]['power']=$s[1]+1-1;
			//echo "-".$s[1];
			while(1)
				if(trim($enc_file[$i+1]) == "") //пустая строка
					$i++;
				else
					break;
			$i++;
			$s=explode(':',$enc_file[$i]);
			$enc_effects[$n][$j]['param1']=$s[1]+1-1;
//echo "-".$s[1];
			while(1)
				if(trim($enc_file[$i+1]) == "") //пустая строка
					$i++;
				else
					break;
			$i++;
			$s=explode(':',$enc_file[$i]);
			$enc_effects[$n][$j]['param2']=$s[1]+1-1;
//echo "-".$s[1]."<br>";
			if(($enc_effects[$n][$j]['num']+1-1)==15 && ($enc_effects[$n][$j]['power']+1-1)==13) //ссылки на данное событие из др.событий, обработка кодов переходов
			{
				$f_check_enc[$enc_effects[$n][$j]['param1']]=$f_check_enc[$enc_effects[$n][$j]['param1']].$n.",";//флаг где изменяется
//echo $n." FLAG[".$enc_effects[$n][$j]['param1']."]=".$f_check_enc[$enc_effects[$n][$j]['param1']];
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
//echo $n."-".$event_effects[$n][$j]['num']."<br>";;
			while(1)
				if(trim($event_file[$i+1]) == "") //пустая строка
					$i++;
				else
					break;
			$i++;
			$s=explode(':',$event_file[$i]);
			$event_effects[$n][$j]['power']=$s[1]+1-1;
			//echo "-".$s[1];
			while(1)
				if(trim($event_file[$i+1]) == "") //пустая строка
					$i++;
				else
					break;
			$i++;
			$s=explode(':',$event_file[$i]);
			$event_effects[$n][$j]['param1']=$s[1]+1-1;
//echo "-".$s[1];
			while(1)
				if(trim($event_file[$i+1]) == "") //пустая строка
					$i++;
				else
					break;
			$i++;
			$s=explode(':',$event_file[$i]);
			$event_effects[$n][$j]['param2']=$s[1]+1-1;
//echo "-".$s[1]."<br>";
			if(($event_effects[$n][$j]['num']+1-1)==8) //ссылки на данное событие из др.событий, обработка кодов переходов
			{
				if($event_effects[$n][$j]['power']==26)
				{
				$f_check_event[$event_effects[$n][$j]['param1']]=$f_check_event[$event_effects[$n][$j]['param1']].$n.",";//флаг где изменяется
//echo $n." FLAG[".$event_effects[$n][$j]['param1']."]=".$f_check_event[$event_effects[$n][$j]['param1']];
				}
			}
			else
			if(($event_effects[$n][$j]['num']+1-1)==33) //ссылки на данное событие из др.событий, обработка кодов переходов
			{
				$f_set_event[$event_effects[$n][$j]['power']]=$f_set_event[$event_effects[$n][$j]['power']].$n.",";//флаг где изменяется
			}
			else
			if(($event_effects[$n][$j]['num']+1-1)==37) //ссылки на данное событие из др.событий, обработка кодов переходов
			{
				$c_in_event[$event_effects[$n][$j]['power']]=$c_in_event[$event_effects[$n][$j]['power']].$n.",";
//echo $n." event[".$event_effects[$n][$j]['power']."]=".$c_in_event[$event_effects[$n][$j]['power']];
			}
			$i++; //пустая строка
//echo "LAST=".substr(trim($event_file[$i-1]),-1,1)."<br>";
			if(substr(trim($event_file[$i-1]),-1,1)==";") 
			{
//echo "BREAK<br>";			
				break; //for $j
			}
		}
	}
}

//Разбор journal.txt
for($i = 1,$n=0; $i < $count_j; $i++)
{  
	if(eregi("^([0-9]{1,}\.)",$j_file[$i],$k))
    {
		$n=$k[1]+1-1;
    }
	else
	if(eregi("^Name:",$j_file[$i]))
	{
		$s=explode(':',$j_file[$i]);
		$j_name[$n]=substr(trim($s[1]),0,-1);
//echo $n."---".$j_name[$n]."<br>";
	}
	else
	{
		if(substr($j_file[$i],0,1)=="#")
			$j_txt[$n]=$j_txt[$n].((substr(trim($j_file[$i]),-1,1)=="#") ? substr(trim($j_file[$i]),1,-1) : substr($j_file[$i],1)."<br>");
		else
		if(trim($j_file[$i])!="")
		{
			if(substr(trim($j_file[$i]),-1,1)=="#")
			{
				$j_txt[$n]=$j_txt[$n].substr(trim($j_file[$i]),0,-1);
				$i++;
			}
			else
				$j_txt[$n]=$j_txt[$n].$j_file[$i]."<br>";
		}
//echo $n."-".$j_txt[$n]."<br>";
	}
}

//Разбор camp_dialog.var
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
		(substr($s1,-1,1)=="#") ? $dialog_text[$n]=$dialog_text[$n].substr($s1,1,-1) : $dialog_text[$n]=$dialog_text[$n].substr($s1,1)."<br>";
//		(substr($s1,-1,1)=="#") ? $dialog_text[$n]=$dialog_text[$n].substr($s1,1,-1) : $dialog_text[$n]=$dialog_text[$n].substr($s1,1);
		for($j=0;!eregi("^Answer",$d_file[$i+1]) && ($j<8);$j++)
		{
			$i++;
			$s1=trim($d_file[$i]);
			(substr($s1,-1,1)=="#") ? $dialog_text[$n]=$dialog_text[$n].substr($s1,0,-1)."<br>" : $dialog_text[$n]=$dialog_text[$n].$s1."<br>";
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
//			$ss="Answer".$j.":";
			$s=explode(':',$d_file[$i]);
//echo $s[0]."-".$s[1]."<br>";
			$s1=trim($s[1]);
			(substr($s1,-1,1)=="#") ? $dialog_answer[$n][$j]=substr($s1,0,-6) : $dialog_answer[$n][$j]=substr($s1,0,-1);
//			$dialog_answer[$n][$j]=substr($s1,0,-1);
//echo $n."(".$j.")".$dialog_answer[$n][$j]."<br>";
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

//Разбор players.var
for($i = 0,$n=0; $i < $count_p; $i++)
{  
	if(eregi("^/([0-9]{1,})",$p_file[$i],$k))
    {
		$n=$k[1];
    }
    else
    if(eregi("^name:",$p_file[$i]))
    {
		$s=explode(':',$p_file[$i]);
		$p_name[$n]=substr(trim($s[1]),0,-1);
//echo $n."-".$p_name[$n]."<br>";
    }
}

//Предварительный разбор camp_event.var для инициализации $c_table для question.var
for($i = 0,$n=0,$count=0; $i < $count_c; $i++)
{  
	if(eregi("^/([0-9]{1,})",$c_file[$i],$k))
    {
		$n=$k[1];
		if($count != $n) //неправильная нумерация событий
		{
			echo "!!!Сбитая нумерация №".$n."!!!<br>";
			$count=$n;
		}
		$count++;
		if($n>$max)$max=$n;
		$s=substr($c_file[$i],log10($n)+3);
//echo $n."-".$s."<br>";
		$c_table[$n]=trim($s);
    }
}
//Разбор question.var
for($i = 0,$n=0; $i < $count_question; $i++)
{  
	if(eregi("^/([0-9]{1,})",$question_file[$i],$k))
    {
		$n=$k[1];
		if($n>$max1)$max1=$n;
    }
    else
    if(eregi("^Quester",$question_file[$i]))
    {
		$s=explode(':',$question_file[$i]);
		$question_quester[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^Trigger",$question_file[$i]))
    {
		$s=explode(':',$question_file[$i]);
		$question_trigger[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^Event",$question_file[$i]))
    {
		$s=explode(':',$question_file[$i]);
		$question_event[$n]=$s[1]+1-1;
		if($s[1]+1-1==0) 
			$len=2;
		else
			$len=strlen($c_table[$s[1]+1-1]);
		if($len>($question_len[$question_quester[$n]]+1-1)) //макс длина ссылки для расширенного диалога
			$question_len[$question_quester[$n]]=$len; 
 //echo $n."-".$question_len[$question_quester[$n]]."<br>";
	}
    else
    if(eregi("^Text",$question_file[$i]))
    {
		$s=explode('#',$question_file[$i]);
		$question_text[$n]=trim($s[1]);
//echo $n."-".$question_text[$n]."<br>";
    }
}

//Разбор camp_event.var
for($i = 0,$n=0,$count=0; $i < $count_c; $i++)
{  
	if(eregi("^/([0-9]{1,})",$c_file[$i],$k))
    {
		$n=$k[1];
    }
	else
	if(eregi("^\*Answers\*:",$c_file[$i]))
	{
		while(1)
			if(trim($c_file[$i+1]) == "") //пустая строка
				$i++;
			else
				break;
		for($j=1;(eregi("^Answer",$c_file[$i+1])) && ($j<8);$j++)
		{
			$i++;
			$s=explode(':',$c_file[$i]);
			$c_answer[$n][$j]=$s[1];
			foreach(explode(',',$c_in[$s[1]+1-1]) as $val) //поиск дублей ссылок
				if($val==$n) $in_flag=1;
			if($in_flag!=1)
				$c_in[$s[1]+1-1]=$c_in[$s[1]+1-1].$n.",";
			$in_flag=0;
//			$enc_cnt[$s[1]+1-1]++;
//			$enc_in[$s[1]+1-1][$enc_cnt[$s[1]+1-1]]=$n; //ссылки на данное событие из др.событий
//echo $n."(".$j.")".$enc_answer[$n][$j]."LEN=".$answer_len[$n]."<br>";
		}
	}	
	else
	if(eregi("^\*Effects\*:",$c_file[$i]))
	{
		while(1)
			if(trim($c_file[$i+1]) == "") //пустая строка
				$i++;
			else
				break;
		for($j=0;$j<16;$j++) //четвёрки эффектов
		{
			while(1)
				if(trim($c_file[$i+1]) == "") //пустая строка
					$i++;
				else
					break;
			$i++;
			$s=explode(':',$c_file[$i]);
			$c_effects[$n][$j]['num']=$s[1];
//echo $n."-".$enc_effects[$n][$j]['num']."<br>";;
			while(1)
				if(trim($c_file[$i+1]) == "") //пустая строка
					$i++;
				else
					break;
			$i++;
			$s=explode(':',$c_file[$i]);
			$c_effects[$n][$j]['power']=$s[1]+1-1;
			//echo "-".$s[1];
			while(1)
				if(trim($c_file[$i+1]) == "") //пустая строка
					$i++;
				else
					break;
			$i++;
			$s=explode(':',$c_file[$i]);
			$c_effects[$n][$j]['param1']=$s[1]+1-1;
//echo "-".$s[1];
			while(1)
				if(trim($c_file[$i+1]) == "") //пустая строка
					$i++;
				else
					break;
			$i++;
			$s=explode(':',$c_file[$i]);
			$c_effects[$n][$j]['param2']=$s[1]+1-1;
//echo "-".$s[1]."<br>";
			if(($c_effects[$n][$j]['num']+1-1)==8) //ссылки на данное событие из др.событий, обработка кодов переходов
			{
				for($k=0;$k<=$max1;$k++) 
				{
					if($question_quester[$k]==$c_effects[$n][$j]['power'])
					{
						foreach(explode(',',$c_in[$question_event[$k]]) as $val) //поиск дублей ссылок
							if($val==$n) $in_flag=1;
						if($in_flag!=1)
							$c_in[$question_event[$k]]=$c_in[$question_event[$k]].$n.",";
						$in_flag=0;
					}
				}
			}
			if(($c_effects[$n][$j]['num']+1-1)==9) //ссылки на данное событие из др.событий, обработка кодов переходов
			{
				foreach(explode(',',$c_in[$c_effects[$n][$j]['param2']]) as $val) //поиск дублей ссылок
					if($val==$n) $in_flag=1;
				if($in_flag!=1)
					$c_in[$c_effects[$n][$j]['param2']]=$c_in[$c_effects[$n][$j]['param2']].$n.",";
				$in_flag=0;
			}
			else
			if((($c_effects[$n][$j]['num']+1-1)==10) || (($c_effects[$n][$j]['num']+1-1)==26)) //ссылки на данное событие из др.событий, обработка кодов переходов
			{
				foreach(explode(',',$c_in[$c_effects[$n][$j]['param1']]) as $val) //поиск дублей ссылок
					if($val==$n) $in_flag=1;
				if($in_flag!=1)
					$c_in[$c_effects[$n][$j]['param1']]=$c_in[$c_effects[$n][$j]['param1']].$n.",";
				$in_flag=0;
				foreach(explode(',',$c_in[$c_effects[$n][$j]['param2']]) as $val) //поиск дублей ссылок
					if($val==$n) $in_flag=1;
				if($in_flag!=1)
					$c_in[$c_effects[$n][$j]['param2']]=$c_in[$c_effects[$n][$j]['param2']].$n.",";
				$in_flag=0;
			}
			else
			if(($c_effects[$n][$j]['num']+1-1)==11) //ссылки на данное событие из др.событий, обработка кодов переходов
			{
				foreach(explode(',',$c_in[$c_effects[$n][$j]['power']]) as $val) //поиск дублей ссылок
					if($val==$n) $in_flag=1;
				if($in_flag!=1)
					$c_in[$c_effects[$n][$j]['power']]=$c_in[$c_effects[$n][$j]['power']].$n.",";
				$in_flag=0;
				if($c_effects[$n][$j]['param1']>0)
				{
					foreach(explode(',',$c_in[$c_effects[$n][$j]['param1']]) as $val) //поиск дублей ссылок
						if($val==$n) $in_flag=1;
					if($in_flag!=1)
						$c_in[$c_effects[$n][$j]['param1']]=$c_in[$c_effects[$n][$j]['param1']].$n.",";
					$in_flag=0;
				}
			}
			else
			if((($c_effects[$n][$j]['num']+1-1)==17) || (($c_effects[$n][$j]['num']+1-1)==19))
			{
				foreach(explode(',',$c_in[$c_effects[$n][$j]['power']]) as $val) //поиск дублей ссылок
					if($val==$n) $in_flag=1;
				if($in_flag!=1)
					$c_in[$c_effects[$n][$j]['power']]=$c_in[$c_effects[$n][$j]['power']].$n.",";
				$in_flag=0;
			}
			$i++; //пустая строка
//echo "LAST=".substr(trim($enc_file[$i-1]),-1,1)."<br>";
			if(substr(trim($c_file[$i-1]),-1,1)==";") 
			{
//echo "BREAK<br>";			
				break; //for $j
			}
		}
	}
	else
	if(eregi("^Possibility:",$c_file[$i]))
	{
		$s=explode(':',$c_file[$i]);
		$c_poss[$n]=$s[1]+1-1;
	}	
	else
	if(eregi("^Dialog:",$c_file[$i]))
	{
		$s=explode(':',$c_file[$i]);
		$c_dialog[$n]=$s[1]+1-1;
	}	
	else
	if(eregi("^DlgParam1:",$c_file[$i]))
	{
		$s=explode(':',$c_file[$i]);
		$c_dialog_param1[$n]=$s[1]+1-1;
	}	
	else
	if(eregi("^DlgParam2:",$c_file[$i]))
	{
		$s=explode(':',$c_file[$i]);
		$c_dialog_param2[$n]=$s[1]+1-1;
	}	
	else
	if(eregi("^Attacker:",$c_file[$i]))
	{
		$s=explode(':',$c_file[$i]);
		$c_attacker[$n]=$s[1]+1-1;
	}	
	else
	if(eregi("^Karma:",$c_file[$i]))
	{
		$s=explode(':',$c_file[$i]);
		$c_karma[$n]=$s[1]+1-1;
	}	
}

//Разбор answer camp_event.var для длины строки
for($i = 0,$n=0; $i < $count_c; $i++)
{  
   if(eregi("^/([0-9]{1,})",$c_file[$i],$k))
    {
		$n=$k[1];
    }
	else
	if(eregi("^\*Answers\*:",$c_file[$i]))
	{
		for($j=1;(eregi("^Answer",$c_file[$i+1])) && ($j<8);$j++)
		{
			$i++;
			$s=explode(':',$c_file[$i]);
			if($s[1]+1-1==0) 
				$len=2;
			else
//				$len=strlen($enc_table[$s[1]+1-1])+floor(log10($s[1]+1-1))-1;
				$len=strlen($c_table[$s[1]+1-1]);
//echo $n."-".$len."<br>";			
			if($len>($answer_len[$n]+1-1)) $answer_len[$n]=$len;
//echo $n."(".$j.")".$enc_answer[$n][$j]."LEN=".$answer_len[$n]."<br>";
		}
	}	
}


//---------------------------------------------------------

$c_table[0]="";

echo "<h3 align=\"center\">События Кампании<br></h3>";
$s=explode(':',$c_file[0]);
echo "Quantity: <B>".$s[1]."</B><br><br>";
//echo "-------------------------------------------------------------<br>";

for($i=1;$i<$max+1;$i++)
{
//	echo "<HR WIDTH=\"100%\" SIZE=\"1\">";
	echo "<HR>";
	echo "<span style='color:fuchsia'><a name=\"e".$i."\"></a><B>/".$i." ".$c_table[$i]."</B></span><br>";
	if($i!=0) echo "<B>Ссылки из:</B> ";
//	if($i!=0) echo (($c_in[$i]=="") ? "" :"<B>Ссылки из:</B> ");
//	print_r(array_count_values (explode(',',$enc_in_print[$i])));
	if($i!=0)
	{
		foreach(explode(',',$c_in[$i]) as $val)
			if($val!="") echo "<a href=\"#e".$val."\">".$val." (".$c_table[$val].")</a> ";
		foreach(explode(',',$c_in_event[$i]) as $val)
			if($val!="") echo "<a href=\"".$event_file_name."#e".$val."\">EVENT_".$val." (".$event_table2[$val].")</a> ";
	}
	echo "<br>";
	echo "<span style='color:brown'>Карма:</span> <B>";
//	echo (($c_karma[$i]>0) ? "+".$c_karma[$i] : $c_karma[$i])."</B>";
	if($c_karma[$i]>0)
		echo "<span style='color:green'>+";
	else
	if($c_karma[$i]<0)
		echo "<span style='color:red'>";
	echo $c_karma[$i]."</span></B>";
	echo (($c_poss[$i]==0) ? "" : ", <span style='color:brown'>Вероятность:</span> <B>".$c_poss[$i])."</B>";
	if($c_dialog_param1[$i]!=0)
		echo "<br><span style='color:brown'>DlgParam1: </span> <B>".$dialog_param[$c_dialog_param1[$i]]."</B>";
	if($c_dialog_param2[$i]!=0)
		echo "<br><span style='color:brown'>DlgParam2: </span> <B>".$dialog_param[$c_dialog_param2[$i]]."</B>";
	echo "<br>";
	if($c_attacker[$i]!=0)
	{
		echo "<span style='color:brown'>Атакующий отряд:</span> <B>".$c_attacker[$i]."</B>";
		echo "<br>";
	}
	echo "<br>";
	if($c_dialog[$i]!=0)
	{
		echo "<B><span style='color:brown'>Диалог:</span></B><br>";
		echo $dialog_text[$c_dialog[$i]];
		echo "<br><br><B><span style='color:brown'>Ответы:</span></B><br>";
		echo "<pre>";
		for($j=1;($c_answer[$i][$j]!="") && ($j<8);$j++)
		{
			$ans=$c_answer[$i][$j]+1-1;
			if($ans==0)	$l=1; else	$l=floor(log10($ans))+1;
			if($l==1) $ll="    ";
			else if($l==2) $ll="   ";
			else if($l==3) $ll="  ";
			else if($l==4) $ll=" ";
			echo "<B>".$j.":[=><a href=\"#e".$ans."\">".$ans."</a>";
//			printf ("$ll%-90s",$enc_table[$ans]);
			printf ("$ll%-".$answer_len[$i]."s",$c_table[$ans]);
			echo "]</B> ";
			echo str_replace("$","зол.",str_replace("&","кр.",$dialog_answer[$c_dialog[$i]][$j]));
			echo "\n";
		}
		if(($c_effects[$i][0]['num']+1-1)==8) //расширенный диалог
		{
			for($k=0;$k<=$max1;$k++) 
			{
				if($question_quester[$k]==$c_effects[$i][0]['power'])
				{
					$f_name[$question_trigger[$k]]=1;//перечень флагов
					foreach(explode(',',$f_check[$question_trigger[$k]]) as $val) //поиск дублей ссылок
						if($val==$i) $in_flag=1;
					if($in_flag!=1)
						$f_check[$question_trigger[$k]]=$f_check[$question_trigger[$k]].$i.",";//флаг где проверяется
					$in_flag=0;
					$ans=$question_trigger[$k]; //пробелы для выравнивания Флаг_
					if($ans==0)	$l=1; else	$l=floor(log10($ans))+1;
					if($l==1) $ll="   ";
					else if($l==2) $ll="  ";
					else if($l==3) $ll=" ";
					else if($l==4) $ll="";
					$ans2=$question_event[$k]; //пробелы для выравнивания ссылок
					if($ans2==0)	$l2=1; else	$l2=floor(log10($ans2))+1;
					if($l2==1) $ll2="    ";
					else if($l2==2) $ll2="   ";
					else if($l2==3) $ll2="  ";
					else if($l2==4) $ll2=" ";
					echo "<B><a href=\"#f".$question_trigger[$k]."\">Флаг ".$question_trigger[$k]."</a>:".$ll;
					echo "[=><a href=\"#e".$question_event[$k]."\">".$question_event[$k]."</a>";
//echo $question_len[$ans2];					
					printf ("$ll2%-".$question_len[$question_quester[$k]]."s",$c_table[$ans2]);
					echo "]</B> ".$question_text[$k]."\n";
				}
			}
		}
		echo "</pre><br>";
	}
	echo "<B><span style='color:brown'>Эффекты:</span></B>";
	echo "<ul>";
	for($j=0;($c_effects[$i][$j]['num']!="")&&($j<16);$j++)
	{
		echo "<li>";
		$num=$c_effects[$i][$j]['num']+1-1;
		$power=$c_effects[$i][$j]['power'];
		$param1=$c_effects[$i][$j]['param1'];
		$param2=$c_effects[$i][$j]['param2'];
//echo $i."-".$num."<br>";		
		if(($num==0) || ($num==8))
		{
			echo "Нет";
		}
		else
		if($num==1)
		{
			echo "Изменить астральную энергию игрока на <B>";
			if($power>=0)
			{
				echo "<span style='color:green'>+";
				if($param1==0)
					echo $power;
				else
					echo "(".$power."-".($param1+$power).")";
			}
			else
			{
				echo "<span style='color:red'>-";
				if($param1==0)
					echo abs($power);
				else
					echo "(".abs($param1+$power)."-".abs($power).")";
			}
			echo "</span>";
		}
		else
		if($num==2)
		{
			echo "Изменить отношение ";
			echo (($param1==0) ? "текущего правителя" : "правителя <B>".$p_name[$param1]."</B>");
			echo " на <B>";
			echo (($power>0) ? "<span style='color:green'>+" : "<span style='color:red'>");
			echo $power."</span>";
		}
		else
		if($num==3)
		{
			$f_name[$power]=1;//перечень флагов
			foreach(explode(',',$f_set[$power]) as $val) //поиск дублей ссылок
				if($val==$i) $in_flag=1;
			if($in_flag!=1)
				$f_set[$power]=$f_set[$power].$i.",";//флаг где изменяется
			$in_flag=0;
			echo "<B><a href=\"#f".$power."\">Флаг ".$power."</a> = ".$param1;
			if($param2>0)
			{
				$f_name[$param2]=1;//перечень флагов
				foreach(explode(',',$f_check[$param2]) as $val) //поиск дублей ссылок
					if($val==$i) $in_flag=1;
				if($in_flag!=1)
					$f_check[$param2]=$f_check[$param2].$i.",";//флаг где проверяется
				$in_flag=0;
				echo "</B> (только если <B><a href=\"#f".$param2."\">Флаг ".$param2."</a> > 0</B>)";
			}
		}
		else
		if($num==4)
		{
			echo "Ответ <B>".$power."</B> появляется, если <B>";
			if($param1==1)
				echo "астральная энергия >= ".$param2;
			else
			if($param1==2)
			{
				$f_name[$param2]=1;//перечень флагов
				foreach(explode(',',$f_check[$param2]) as $val) //поиск дублей ссылок
					if($val==$i) $in_flag=1;
				if($in_flag!=1)
					$f_check[$param2]=$f_check[$param2].$i.",";//флаг где проверяется
				$in_flag=0;
				echo "<a href=\"#f".$param2."\">Флаг ".$param2."</a> > 0";
			}
			else
			if($param1==3)
				echo "Деталей > 0";
			else
			if($param1==4)
				echo "Ключ правды найден";
			else
			if($param1==5)
			{
				$f_name[$param2]=1;//перечень флагов
				foreach(explode(',',$f_check[$param2]) as $val) //поиск дублей ссылок
					if($val==$i) $in_flag=1;
				if($in_flag!=1)
					$f_check[$param2]=$f_check[$param2].$i.",";//флаг где проверяется
				$in_flag=0;
				echo "<a href=\"#f".$param2."\">Флаг ".$param2."</a> = 0";
			}
			else
				echo $i." !!!!NUM=4";
		}
		else
		if($num==5)
		{
			echo "Изменить доход астральной энергии игрока на <B>";
			if($power>=0)
			{
				echo "<span style='color:green'>+";
				if($param1==0)
					echo $power;
				else
					echo "(".$power."-".($param1+$power).")";
			}
			else
			{
				echo "<span style='color:red'>-";
				if($param1==0)
					echo abs($power);
				else
					echo "(".abs($param1+$power)."-".abs($power).")";
			}
			echo "</span>";
		}
		else
		if($num==6)
		{
			echo "Установить внутренний параметр в значение <B>".$power;
		}
		else
		if($num==7) //НЕ ДЕЛАЛ, Т.К. NOT USE
		{
			echo "!!!НЕ ДЕЛАЛ, Т.К. NOT USE - Изменить карму на <B>";
			if($power>=0)
			{
				echo "+";
				if($param1==0)
					echo $power;
				else
					echo "(".$power."-".($param1+$power).")";
			}
			else
			{
				echo "-";
				if($param1==0)
					echo abs($power);
				else
					echo "(".abs($param1+$power)."-".abs($power).")";
			}
		}
		else
		if($num==9)
		{
			echo "Если отношения игрока с правителем <B>".$p_name[$power]." < ";
			if(($param1>=-30000) && ($param1<=-50))
				echo "Ненависть";
			else
			if(($param1>=-49) && ($param1<=-40))
				echo "Вражда";
			else
			if(($param1>=-39) && ($param1<=-30))
				echo "Отвращение";
			else
			if(($param1>=-29) && ($param1<=-20))
				echo "Презрение";
			else
			if(($param1>=-19) && ($param1<=-10))
				echo "Неприязнь";
			else
			if(($param1>=-9) && ($param1<=9))
				echo "Равнодушие";
			else
			if(($param1>=10) && ($param1<=19))
				echo "Благосклонность";
			else
			if(($param1>=20) && ($param1<=29))
				echo "Симпатия";
			else
			if(($param1>=30) && ($param1<=39))
				echo "Признание";
			else
			if(($param1>=40) && ($param1<=49))
				echo "Уважение";
			else
			if(($param1>=50) && ($param1<=30000))
				echo "Дружба";
			echo "</B>, перейти к событию <B><a href=\"#e".$param2."\">".$param2." (".$c_table[$param2].")</a>";
		}
		else
		if($num==10)
		{
			$f_name[$power]=1;//перечень флагов
			foreach(explode(',',$f_check[$power]) as $val) //поиск дублей ссылок
				if($val==$i) $in_flag=1;
			if($in_flag!=1)
				$f_check[$power]=$f_check[$power].$i.",";//флаг где проверяется
			$in_flag=0;
			echo "Если <B><a href=\"#f".$power."\">Флаг ".$power."</a> > 0</B>, ";
			if($param1!=0)
				echo "перейти к событию <B><a href=\"#e".$param1."\">".$param1." (".$c_table[$param1].")</a></B>, иначе ";
			else
				echo "перейти к следующему условию, иначе ";
			if($param2!=0)
				echo "перейти к событию <B><a href=\"#e".$param2."\">".$param2." (".$c_table[$param2].")</a>";
			else
				echo "перейти к следующему условию";
		}
		else
		if($num==11)
		{
			if($param1>0)
			{
				echo "С вероятностью <B>".$param2."%</B> вызвать событие <B><a href=\"#e";
				echo $power."\">".$power." (".$c_table[$power].")</a></B>";
				echo ", иначе вызвать событие <B><a href=\"#e".$param1."\">".$param1;
				echo " (".$c_table[$param1].")</a>";
			}
			else
				echo "Вызвать событие <B><a href=\"#e".$power."\">".$power." (".$c_table[$power].")</a>";
		}
		else
		if($num==12)
		{
			echo "Установить союзные отношения с правителем <B>".$p_name[$power]."</B> в значение <B>".$param1;
		}
		else
		if($num==13)
		{
			echo "<span style='color:aqua'>Установить состояние квеста</span> <B><a href=\"".$q_file_name."#e".$power."\">".$power." (".$q_name[$power].")</a></B>";
			echo " <span style='color:aqua'>в значение</span> <B>".$param1;
		}
		else
		if($num==14)
		{
			echo "Установить флаг вторжения в значение <B>".$power;
		}
		else
		if($num==15)
		{
			if($param2==0)
			{
				echo "Изменить ";
				if($power==0)
					echo "количество собранных <B>Ключей";
				else
				if($power==1)
					echo "количество собранных <B>Деталей";
				else
				if($power==2)
					echo "доступное количество <B>Деталей";
				echo "</B> на <B>";
				echo (($param1>0) ? "<span style='color:green'>+" : "<span style='color:red'>");
				echo $param1;
				echo "</span>";
			}
			else
			{
				echo "Прибавить к ";
				if($power==0)
					echo "количеству собранных <B>Ключей";
				else
				if($power==1)
					echo "количеству собранных <B>Деталей";
				else
				if($power==2)
					echo "доступному количеству <B>Деталей";

				echo "</B> ";
				if($param2==0)
					echo "количество собранных <B>Ключей";
				else
				if($param2==1)
					echo "количество собранных <B>Деталей";
				else
				if($param2==2)
					echo "доступное количество <B>Деталей";
			}
		}
		else
		if($num==16)
		{
			echo "Выдать сообщение о лжи (если ключ правды найден)";
		}
		else
		if($num==17)
		{
			echo "Добавить событие <B><a href=\"#e".$power."\">".$power." (".$c_table[$power].")</a>";
			echo "</B> в начало списка активных событий";
		}
		else
		if($num==18)
		{
			echo "Уничтожить правителя <B>".$p_name[$power];
		}
		else
		if($num==19)
		{
			echo "Перейти к событию <B><a href=\"#e".$power."\">".$power." (".$c_table[$power].")</a></B>";
			echo ", если правитель <B>".$p_name[$param1]."</B> жив (переход осуществляется в момент, когда условие встречено в тексте)";
		}
		else
		if($num==20)
		{
			echo "Вызвать финал кампании с индексом <B>".$power;
		}
		else
		if($num==21)
		{
			echo "Правитель <B>".$p_name[$power]."</B> атакует игрока";
		}
		else
		if($num==22)
		{
			echo "Уменьшить доход энергии с мира игрока на <B><span style='color:red'>";
			if($param1==0)
				echo $power;
			else
				echo "(".$power."-".($param1+$power).")";
			echo "</span>";
		}
		else
		if($num==23)
		{
			echo "Установить запись журнала <B>".$j_name[$power]."</B> в значение <B>";
			echo $param1."</B> (".$j_txt[$power].")";
		}
		else
		if($num==24)
		{
			echo "Изменить длительность кампании на <B>";
				echo (($power>=0) ? "<span style='color:green'>+" : "<span style='color:red'>");
			if(abs($power)==1)
				echo $power."</B> ход";
			else
			if((abs($power)>1) && (abs($power)<5))
				echo $power."</B> хода";
			else
				echo $power."</B> ходов";
		}
		else
		if($num==25)
		{
			echo "Изменить славу игрока на <B>";
			echo (($power>=0) ? "<span style='color:green'>+" : "<span style='color:red'>").$power;
		}
		else
		if($num==26)
		{
			echo "Если слава игрока >= <B>".$power;
			echo "</B> - перейти к событию <B><a href=\"#e".$param1."\">".$param1." (".$c_table[$param1].")</a></B>";
			echo ", иначе к событию <B><a href=\"#e".$param2."\">".$param2." (".$c_table[$param2].")</a>";
		}
		else
			echo "<B>!!!ERROR!!! NUM=".$num;
		echo "</B></li>";
	}
	echo "</ul>";
}

echo "<HR><h3 align=\"center\">Флаги (всего ".count($f_name).")</h3>";
//echo "<table width=100% border=1><tr><td>№</td><td colspan=20>где устанавливаются</td><td colspan=20>где изменяются</td></tr>";
echo "<table width=100% border=1><tr><td align=\"center\"><B>№</B></td><td align=\"center\"><B>где изменяется</B></td><td align=\"center\"><B>где проверяется</B></td></tr>";

//foreach($f_name as $num => $val)
for($i=0;$i<=999;$i++)
{
	if($f_name[$i]==1)
	{
		echo "<tr><td valign=\"top\" align=\"center\"><a name=\"f".$i."\">".$i."</a></td><td>";
		if(($f_set[$i]=="") && ($f_set_event[$i]=="")) echo "-";
		foreach(explode(',',$f_set[$i]) as $s)
			if($s!="") echo "<a href=\"#e".$s."\">".$s." (".$c_table[$s].")</a><br>";
		foreach(explode(',',$f_set_event[$i]) as $s)
			if($s!="") echo "<a href=\"".$event_file_name."#e".$s."\">EVENT ".$s." (".$event_table2[$s].")</a><br>";
		echo "</td><td>";
		if(($f_check[$i]=="") && ($f_check_event[$i]=="") && ($f_check_enc[$i]=="")) echo "-";
		foreach(explode(',',$f_check[$i]) as $c)
			if($c!="") echo "<a href=\"#e".$c."\">".$c." (".$c_table[$c].")</a><br>";
		foreach(explode(',',$f_check_event[$i]) as $c)
			if($c!="") echo "<a href=\"".$event_file_name."#e".$c."\">EVENT ".$c." (".$event_table2[$c].")</a><br>";
		foreach(explode(',',$f_check_enc[$i]) as $c)
			if($c!="") echo "<a href=\"".$enc_file_name."#e".$c."\">ENCOUNTER ".$c." (".$enc_table[$c].")</a><br>";
		echo "</td></tr>";
	}
}

echo "</table>";
?>
</body></html>