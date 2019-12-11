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

$res_name=array(1=>"������", "������� ������", "����", "����������", "�������", "������", "������", "������", "׸���� �����");

//���������� � Ritual.txt ����������� ��������� ������ (����������� �������) � ���� ����� ����� �������:
$ritual_txt_unit[6] = "
������ (��. 1-5)            -   33~
����� (��. 0-4)             -   32~
�������� �������� (��. 1-3) - 18,9~
���� (��. 2-6)              -  8,1~
����� (��. 0-1)             -    8~";

$ritual_txt_unit[11] = "
������ ������ (��. 0-4) -    45~
׸�� (��. 0-4)          -    15~
������� (��. 7-12)      -  12,5~
������ (��. 2-3)        -    10~
��� (��. 5-10)          - 9,375~
������ (��. 2-4)        -     5~
����������� (��. 1-3)   - 3,125~";

$ritual_txt_unit[27] = "
������ ����� (��. 4-8)     -     25~
���� ����� (��. 2-5)       - 16,875~
׸���� ������ (��. 2-5)    - 16,875~
������ (��. 2-4)           -   13,5~
���������� �������(��.0-2) - 13,125~
������� (��. 2-4)          -      9~
������ (��. 0-2)           -  5,625~";

$ritual_txt_unit[34] = "
1 ������� (��. 0-4)  - 24~
2 �������� (��. 0-4) - 58~
3 �������� (��. 0-4) - 18~";

$ritual_txt_unit[41] = "
������� (��. 2-5)           -   20~
���� (��. 1-3)              -   20~
�������� �������� (��. 2-6) - 12,5~
���������� ��� (��. 3-9)   - 12,5~
�������� (��. 3-7)          - 12,5~
�������� (��. 4-6)          - 12,5~
������� ������� (��. 0-1)   -   10~";

//��� �����
$ritual_txt_add[3] = "������ +(15-25)*������� ���������;\n��������� ��������� -1";
$ritual_txt_add[5] = "��������� +(4-9)*������� ���������;\n��������� ��������� -1;\n���������� ��������� -(5-10)~";
$ritual_txt_add[7] = "���������� ��������� +2;\n������� ��������� +4";
$ritual_txt_add[8] = "����� � ��� ����� +(20-30) �����;\n������ ��� ������ ����� -(0-3)";
$ritual_txt_add[9] = "�������� ��������� ������� ������ 2, c ��������� �� ���� 1 (����������� 60~) ��� ��������� ������� ������ 3, c ��������� �� ���� 1 (����������� 24~)";
$ritual_txt_add[9] .= " ��� ��������� ������� ������ 4, c ��������� �� ���� 1 (����������� 16~)";
$ritual_txt_add[10] = "����� +10/+3";
$ritual_txt_add[12] = "���������� ��������� -2";
$ritual_txt_add[13] = "������ ������:\n�����:4 (��. 12); ������:3 (��. 9); ���������:2 (��. 4)";
$ritual_txt_add[16] = "������ -(10-20)*������� ���������;\n����� -5;\n������� ��������� -3;\n���������� ��������� -(5-10)~";
$ritual_txt_add[17] = "���������� ��������� -(10-20)~";
$ritual_txt_add[18] = "��������� �����: ������, ������� 1";
$ritual_txt_add[19] = "������ +(500-900) ��� ��������� +(150-250) ��� ��������� ������� ������ 4, c ��������� �� ���� 2 (����������� 70~) ��� ";
$ritual_txt_add[19] .= "��������� ������� ������ 5, c ��������� �� ���� 2 (����������� 30~) ��� ��������� ��������� +5, ����������� ������������ -500";
$ritual_txt_add[21] = "����� ������: +5 ����������/���, ������ � ����������";
$ritual_txt_add[22] = "��������� 2 ���������;\n���������� ��������� -(40-60)~;\n��������� ���������� �� (30-50)";
$ritual_txt_add[23] = "��������� �����: ������, ������� 2";
$ritual_txt_add[24] = "���������� ��������� -1;\n������� ��������� -5";
$ritual_txt_add[29] = "���������� ��������� -1;\n������� ��������� -2";
$ritual_txt_add[30] = "��������� ��������� -1;\n���������� ��������� -10~";
$ritual_txt_add[36] = "������ +(15-25)*������� ���������";
$ritual_txt_add[37] = "������ +(15-25)*������� ���������;\n����� +6/+2";
$ritual_txt_add[39] = "��������� �����: �����������, ������� 2";
$ritual_txt_add[40] = "������� ��������� +8";
$ritual_txt_add[42] = "���������� ���� ����������� ������ ��� ������ ������ ��� ���������� ������";

$max=0;$max1=0;$max_u=0;$max_e=0;$t[0]=0;$j=0;
$u1=-1;$u2=0;$u3=0;	//� ������ ����� � xls
$g1=0; //���-�� ������� � ����� �����
$a1=0; //� ������
$a2=0; //� ������� ritual
$e1=0; //� �������
$up1=0; //����� upg_type � unit_upg
$u_a=0; //������ in unit.var

//������ ritual_event.exp
for($i = 0; $i < count($ritual_event_file); $i++)
{
	$str = trim($ritual_event_file[$i]);
	if(!eregi("^#",$str))//�� �����������
	{
		if(eregi("^\\\$",$str))//����������
		{
			$var = $str;//������� ��� ���������� ���� �� �����
		}
		else
		{
			$s = explode("|",$str);
			eval($var."[$s[0]][] = $s[1];");
			$EventGroupName[$s[1]] = $s[2];//��� ������ ������� ��� ��������� �������
			$ritual_event_cnt[$s[0]] = $s[3];//�-�� ��������
		}
	}
}

foreach($export_ritual_event_scroll as $ritual => $ev)
{
	foreach($ev as $i)
	{
			$p = "";
			$cnt = $ritual_event_cnt[$ritual];
			$p .= "����� �������� <B><font color=\"blue\">".$cnt." </font></B>";
			if($cnt==1)
				$p .= "������";
			else
			if($cnt>1 && $cnt<5)
				$p .= "������";
			else
				$p .= "�������";
			$p .= " ������� �� <B>������ ������� (group_event) <font color=\"blue\">$i (".$EventGroupName[$i].")</font></B>";
			$ritual_add[$ritual][] = $p;//���. ������� ��������� ������� �������
	}
}

//������ ritual_enc.exp
for($i = 0; $i < count($ritual_enc_file); $i++)
{
	$str = trim($ritual_enc_file[$i]);
	if(!eregi("^#",$str))//�� �����������
	{
		if(eregi("^\\\$",$str))//����������
		{
			$var = $str;//������� ��� ���������� ���� �� �����
		}
		else
		{
			$s = explode("|",$str);
			eval($var."[$s[0]][] = $s[1];");
			$EncGroupName[$s[1]] = $s[2];//��� ������ ����������� ��� ��������� �������
			$ritual_enc_cnt[$s[0]] = $s[3];//�-�� ��������
		}
	}
}

foreach($export_ritual_enc_scroll as $ritual => $enc)
{
	foreach($enc as $i)
	{
			$p = "";
			$cnt = $ritual_enc_cnt[$ritual];
			$p .= "����� �������� <B><font color=\"blue\">".$cnt." </font></B>";
			if($cnt==1)
				$p .= "������";
			else
			if($cnt>1 && $cnt<5)
				$p .= "������";
			else
				$p .= "�������";
			$p .= " ������� �� <B>������ ����������� (group_enc) <font color=\"blue\">$i (".$EncGroupName[$i].")</font></B>";
			$ritual_add[$ritual][] = $p;//���. ������� ��������� ������� �������
	}
}

//������ Ritual.txt
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
		$ritual_txt_idx[$n] = $i;//� ����� ������ ��������� �������� � �����/���������
		$ritual_txt_idx2[$i] = $n;
		$i++;
	}
	else
	if(substr($ritual_file[$i],0,1)=="#")
	{
		$ritual_txt[$n] = substr($ritual_file[$i],1)."<br>";
		$ritual_txt_idx[$n] = $i;//� ����� ������ ��������� �������� � �����/���������
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

//������ inner_build.var
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
    if(eregi("^Ability",$b_file[$i])) //Ability � site.var ��� defender.var
    {
		if(trim($b_file[$i])!="Ability:")
		{
			$s=explode(':',$b_file[$i]);
			$build_abil=$s[1];
			$i++;
			$s1=explode(':',$b_file[$i]);//param1
			$build_param1=$s1[1]+1-1;
			if($build_abil==27)//��������� ��������� ������ Param1
				$ritual_build[$build_param1][]=$build_name[$n];
		}
	}
}

//������ outer_build.var
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
			$abil_num=$s[1]+1-1;	//������ � ������
			$i++;
			$s=explode(':',$out_build_file[$i]);
			$abil_param1=$s[1]+1-1;	//������ param1 ������
			if($abil_num==15) //��������� ����� ������������ ������ Param1 (������ � ���� ���������)
			{
				$ritual_build2[$abil_param1][] = $out_build_name[$n];
			}
		}
    }
}

//������ encounter.var
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

//������ event.var
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
//������ ��������� �����
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
		$name1_table[$n]=trim($s); //��� � ������� "/0 ����� "

//echo "<br>".$k[1]."! $n  ! $max !!"; 
		$u1++;	//� ������
    }
	else
    if(eregi("^Name:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$s1=substr(trim($s[1]),0,-1);
		if(in_array($s1,$name_table))
			echo $n."- ����� NAME=".$s1."<br>";
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
			$karma_flag[$ritual_txt_idx[$n]] = $s[1]+1-1;//� ������ � Ritual.txt, ���� ���� �������� ������� � �����
    }
    else
    if(eregi("^OnEnemy:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$OnEnemy[$n]=(($s[1]+1-1)==0) ? "���" : "��";
    }
    else
    if(eregi("^OnAlly:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$OnAlly[$n]=(($s[1]+1-1)==0) ? "���" : "��";
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
    if(eregi("^Effect:",$a_file[$i])) //effect  � ritual.var
    {
//echo $n."-".$a_file[$i]."<br>";
		$s=explode(':',$a_file[$i]);
		$ritual_effect[$n][$a2]['num']=$s[1];	//������ � ������
		$i++;
		$s=explode(':',$a_file[$i]);
		$ritual_effect[$n][$a2]['param1']=$s[1]+1-1;	//������ param1 ������
		$i++;
		$s=explode(':',$a_file[$i]);
		$ritual_effect[$n][$a2]['param2']=$s[1]+1-1;	//������ param2 ������
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
//����� ������ � ������
//echo "u1=".$u1." u2=".$u2." u3=".$u3."<br>";
//for($i=1;$i<$u1;$i++)echo $str_num[$i]."-".$u_table1[$i]." ";
/*
//�����

echo "<table width=100% border=1><tr><td>�</td>";
for($i=1;$i<$t[0];$i++)echo "<td>$t[$i]</td>";
echo "</tr><tr>";
//��� ��������� ����
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

//����� ��������
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
			$p .= "�������� ���������� ��������� �� <B>".(($param1>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param1;
		}
		else
		if($num==2)
		{
			$p .= "�������� ������� ��������� �� <B>".(($param1>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param1;
		}
		else
		if($num==3)
		{
			$p .= "������� � ��������� ������� <B><font color=\"blue\">".$param1." (".$event_table2[$param1].")";
		}
		else
		if($num==4)
		{
			$p .= "��������� ������, ���� � ������ �� ������ ��� ����� ������� ���������";
		}
		else
		if($num==5)
		{
			$p .= "������� ��� ����� ����������� <B><font color=\"blue\">".$param1." (".$enc_table[$param1].")";
			if($param2!=0) $p .= "<br><B>!!!ERROR $i: 5. ������� ��� ����� �����������(encounter) Param1 (Param2 ������ ���� ����� 0)";
		}
		else
		if($num==6)
		{
		    if($param1!=0)
			{
				$p .= "����� ������ <B>".(($param1>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param1."</font></B>";
				if($param2!=0) $p .= ";<br>";
			}
		    if($param2!=0)
				$p .= "����� ���������� <B>".(($param2>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param2;
		}
		else
		if($num==8)
		{
			$p .= "����� � ��������� ���������� ��� � �������� ����������� <B><font color=\"blue\">\"������� �����\"";
		}
		else
		if($num==12)
		{
			$p .= "��������� ������ ���� � ���������, ��������� ��������� �������";
		}
		else
		if($num==18)
		{
			$p .= "��������� � ������� ���������";
		}
		else
		if($num==19)
		{
			$p .= "��������� � ��������� ���������";
		}
		else
		if($num==20)
		{
			$p .= "���� ������� - �����";
		}
		else
		if($num==22)
		{
			$p .= "��������� ������ � ���������, ��� ��� ����� ��� ��������";
		}
		else
		if($num==23)
		{
			$p .= "��������� ������ � ��������� � ���������� <B><font color=\"blue\">".$out_build_name[$param1];
		}
		else
		if($num==24)
		{
			$p .= "� ��������� ������ ���� ������";
		}
		else
		if($num==25)
		{
			$p .= "���������, ���� � ��������� ������������� �����";
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

$ritual_abil[3] .= "<br>[<font color=\"fuchsia\">�������� ������ ������ ��</font><br><B><font color=\"green\"> +(15-25)*�������_���������</font></B>;";
$ritual_abil[3] .= "<br><font color=\"fuchsia\">�������� ��������� ��������� ��</font><B><font color=\"red\"> -1</font></B>]";
$ritual_abil[5] .= "<br>[<font color=\"fuchsia\">�������� ��������� ������ ��</font><br><B><font color=\"green\"> +(4-9)*�������_���������</font></B>;";
$ritual_abil[5] .= "<br><font color=\"fuchsia\">�������� ��������� ��������� ��</font><B><font color=\"red\"> -1</font></B>;";
$ritual_abil[5] .= "<br><font color=\"fuchsia\">�������� ���������� ��������� ��������� ��</font><B><font color=\"red\"> -(5-10)%</font></B>]";
$ritual_abil[8] .= "<br>[<font color=\"fuchsia\">���� ����� � ��� ������</font><B><font color=\"green\"> (20-30)</font></B> <font color=\"fuchsia\">�����</font>;";
$ritual_abil[8] .= "<br><font color=\"fuchsia\">�������� ������ ��� ������ ����� ��</font><B><font color=\"red\"> -(0-3)</font></B>]";
$ritual_abil[9] .= "<br>[<font color=\"fuchsia\">�������� ��������� ������� ������</font> <B>2</B>, <font color=\"fuchsia\">c ��������� �� ����</font> <B>1</B> (<font color=\"blue\">����������� <B>60%</B></font>);";
$ritual_abil[9] .= "<br>��� <font color=\"fuchsia\">�������� ��������� ������� ������</font> <B>3</B>, <font color=\"fuchsia\">c ��������� �� ����</font> <B>1</B> (<font color=\"blue\">����������� <B>24%</B></font>);";
$ritual_abil[9] .= "<br>��� <font color=\"fuchsia\">�������� ��������� ������� ������</font> <B>4</B>, <font color=\"fuchsia\">c ��������� �� ����</font> <B>1</B> (<font color=\"blue\">����������� <B>16%</B></font>)]";
$ritual_abil[16] .= "<br>[<font color=\"fuchsia\">�������� ������ ������ ��</font><br><B><font color=\"red\"> -(10-20)*�������_���������</font></B>;";
$ritual_abil[16] .= "<br><font color=\"fuchsia\">�������� ���������� ��������� ��������� ��</font><B><font color=\"red\"> -(5-10)%</font></B>]";
$ritual_abil[17] .= "[<font color=\"fuchsia\">�������� ���������� ��������� ��������� ��</font><B><font color=\"red\"> -(10-20)%</font></B>;";
$ritual_abil[17] .= "<br><font color=\"fuchsia\">�������� ���� ������� � ��������� � ��������� ����������� ��</font><B><font color=\"red\"> 10</font></B> <font color=\"fuchsia\">(� ������ �������������)</font>]";
$ritual_abil[18] .= "[<font color=\"fuchsia\">��������� �����: </font><B>������</B><br><font color=\"fuchsia\">���������� ������� ���������� ������ � </font><B>1</B>]";
$ritual_abil[19] .= "<br>[<font color=\"fuchsia\">�������� ������ ������ ��</font><B><font color=\"green\"> +(500-900)</font></B>;";
$ritual_abil[19] .= "<br>��� <font color=\"fuchsia\">�������� ��������� ������ ��</font><B><font color=\"green\"> +(150-250)</font></B>;";
$ritual_abil[19] .= "<br>��� <font color=\"fuchsia\">�������� ��������� ������� ������</font> <B>4</B>, <font color=\"fuchsia\">c ��������� �� ����</font> <B>2</B> (<font color=\"blue\">����������� <B>70%</B></font>);";
$ritual_abil[19] .= "<br>��� <font color=\"fuchsia\">�������� ��������� ������� ������</font> <B>5</B>, <font color=\"fuchsia\">c ��������� �� ����</font> <B>2</B> (<font color=\"blue\">����������� <B>30%</B></font>);";
$ritual_abil[19] .= "<br>��� <font color=\"fuchsia\">�������� ��������� ��������� ��</font><B><font color=\"green\"> +5</font></B>, ";
$ritual_abil[19] .= "<font color=\"fuchsia\">����������� ������������ ��</font><B><font color=\"red\"> -500</font></B>]";
$ritual_abil[22] .= "[<font color=\"fuchsia\">�������� ���� ������� � ��������� � ��������� ����������� ��</font><B><font color=\"red\"> 15</font></B> <font color=\"fuchsia\">(� ������ �������������)</font>;";
$ritual_abil[22] .= "<br><font color=\"fuchsia\">���������</font> <B>2</B> <font color=\"fuchsia\">��������� � ���������</font>;";
$ritual_abil[22] .= "<br><font color=\"fuchsia\">�������� ���������� ��������� ��������� ��</font><B><font color=\"red\"> -(40-60)%</font></B>;";
$ritual_abil[22] .= "<br><font color=\"fuchsia\">��������� ���������� � ��������� ��</font><B><font color=\"red\"> (30-50)</font></B>]";
$ritual_abil[23] .= "[<font color=\"fuchsia\">��������� �����: </font><B>������</B><br><font color=\"fuchsia\">���������� ������� ���������� ������ � </font><B>2</B>]";
$ritual_abil[30] .= "<br>[<font color=\"fuchsia\">�������� ���� ������� � ��������� � ��������� ����������� ��</font><B><font color=\"red\"> 20</font></B> <font color=\"fuchsia\">(� ������ �������������)</font>;";
$ritual_abil[30] .= "<br><font color=\"fuchsia\">�������� ��������� ��������� ��</font><B><font color=\"red\"> -1</font></B>;";
$ritual_abil[30] .= "<br><font color=\"fuchsia\">�������� ���������� ��������� ��������� ��</font><B><font color=\"red\"> -10%</font></B>]";
$ritual_abil[31] .= "<br>[<font color=\"fuchsia\">��������� �����: </font><B>���������� �����</B>]";
$ritual_abil[32] .= "<br>[<font color=\"fuchsia\">������������ � ������ ����� ����� <B><font color=\"brown\">����</B></font> ������</font> <B>(1-5)</B></font>]";
$ritual_abil[36] .= "<br>[<font color=\"fuchsia\">�������� ������ ������ ��</font><br><B><font color=\"green\"> +(15-25)*�������_���������</font></B>]";
$ritual_abil[37] .= "<br>[<font color=\"fuchsia\">�������� ������ ������ ��</font><br><B><font color=\"green\"> +(15-25)*�������_���������</font></B>;";
$ritual_abil[37] .= "<br><font color=\"fuchsia\">�������� ��������� ��������� ��</font><B><font color=\"green\"> +1</font></B>]";
$ritual_abil[39] .= "[<font color=\"fuchsia\">��������� �����: </font><B>�����������</B><br><font color=\"fuchsia\">���������� ������� ���������� ������ � </font><B>2</B>]";
$ritual_abil[42] .= "<br>[<font color=\"fuchsia\">� ��������� ���������� ���� </font><B><font color=\"aqua\">����������� ������</font></B>";
$ritual_abil[42] .= "<br>��� <B><font color=\"aqua\">������ ������</font></B><br>��� <B><font color=\"aqua\">���������� ������</font></B>]";

//����� ������ ������� ("��������" � ���� �������� - colspan=2)
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

//����� �������� � �����
$f=fopen("Ritual_spoil.txt","w") or die("������ ��� �������� ����� Ritual_spoil.txt");
for($i = 0; $i < $count_ritual; $i++)
{
	if(isset($ritual_txt_idx2[$i]))
	{
		$idx = $ritual_txt_idx2[$i];
		fwrite($f,"#");
		if($karma_flag[$i] != 0)
			fwrite($f,"[�����: ".($karma_flag[$i] > 0 ? "+" : "").$karma_flag[$i]."]\n");
		if(isset($ritual_txt_add[$idx]))
			fwrite($f,"[".$ritual_txt_add[$idx]."]\n");
		if(isset($ritual_txt_unit[$idx]))
			fwrite($f,"[����������� ���������: ]".$ritual_txt_unit[$idx]."\n");
		if($karma_flag[$i] != 0 || isset($ritual_txt_unit[$idx]) || isset($ritual_txt_add[$idx]))
			fwrite($f,"\n");//������������� ������ ����� ��������� � ���������
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
//����� ������������ �����
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
<br><a href='index.html'>��������� � ������ ������</a>
</html>