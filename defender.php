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
$a_file = file("defender.var");
$count_f = count($a_file);
$def_txt_file = file("Defender.txt");
$count_def_txt = count($def_txt_file);
$u_file = file("unit.var");
$count_u = count($u_file);
$b_file = file("inner_build.var");
$count_b = count($b_file);
$race_file = file("race.var");
$count_race = count($race_file);
$def_event_file = file("def_event.exp");
$def_enc_file = file("def_enc.exp");

$def_no1=array(29,30,31,32,34,35,36,37,38,42,43,44,45,66,67,68,77,78,89,92,97);//��� ���������=""
$def_no2=array(30,31,32,34,35,36,37,38,42,43,44,45,66,67,68,77,78,89,105);//��� ������="������������ �� ������ ���������"

$res_name=array(1=>"������", "������� ������", "����", "����������", "�������", "������", "������", "������", "׸���� �����");
$max=0;$max1=0;$max_u=0;$max_e=0;$t[0]=0;$j=0;
$u1=-1;$u2=0;$u3=0;	//� ������ ����� � xls
$g1=0; //���-�� ������� � ����� �����
$a1=0; //� ������
$a2=0; //� ������� ritual
$e1=0; //� �������
$up1=0; //����� upg_type � unit_upg
$u_a=0; //������ in unit.var
$p=""; //��� ������ ��� ��������� ";"

//������ def_event.exp
for($i = 0; $i < count($def_event_file); $i++)
{
	$str = trim($def_event_file[$i]);
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
			$EventGroupName[$s[1]] = $s[2];//��� ������ ������� ��� ��������� ������
			$def_event_cnt[$s[0]] = $s[3];//�-�� ��������� �� �������
		}
	}
}

foreach($export_def_event as $def => $ev)
{
	foreach($ev as $i)
	{
			//���. ������� ��������� ������
			$def_add[$def][] = "����� ��������� ������ � ��������� �� <B>������ ������� (group_event) <font color=\"blue\">$i (".$EventGroupName[$i].")</font></B>";
	}
}

foreach($export_def_event_scroll as $def => $ev)
{
	foreach($ev as $i)
	{
			$p = "";
			$cnt = $def_event_cnt[$def];
			$p .= "����� �������� <B><font color=\"blue\">".$cnt." </font></B>";
			if($cnt==1)
				$p .= "�������";
			else
			if($cnt>1 && $cnt<5)
				$p .= "��������";
			else
				$p .= "���������";
			$p .= " �� ������� �� <B>������ ������� (group_event) <font color=\"blue\">$i (".$EventGroupName[$i].")</font></B>";
			$def_add[$def][] = $p;//���. ������� ��������� ������
	}
}

//������ def_enc.exp
for($i = 0; $i < count($def_enc_file); $i++)
{
	$str = trim($def_enc_file[$i]);
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
			$EncGroupName[$s[1]] = $s[2];//��� ������ ����������� ��� ��������� ������
			$def_enc_cnt[$s[0]] = $s[3];//�-�� ��������� �� �������
		}
	}
}

foreach($export_def_enc_scroll as $def => $ev)
{
	foreach($ev as $i)
	{
			$p = "";
			$cnt = $def_enc_cnt[$def];
			$p .= "����� �������� <B><font color=\"blue\">".$cnt." </font></B>";
			if($cnt==1)
				$p .= "�������";
			else
			if($cnt>1 && $cnt<5)
				$p .= "��������";
			else
				$p .= "���������";
			$p .= " �� ������� �� <B>������ ����������� (group_enc) <font color=\"blue\">$i (".$EncGroupName[$i].")</font></B>";
			$def_add[$def][] = $p;//���. ������� ��������� ������
	}
}

//������ Defender.txt
for($i = 0; $i < $count_def_txt; $i++)
{  
    if(eregi("^([0-9]{1,})",$def_txt_file[$i],$k))
    {
		$n=$k[1];
		if($n>$max1)$max1=$n;
    }
    else
	{
		if(substr($def_txt_file[$i],0,1)=="#")
		{
			$def_txt[$n]=$def_txt[$n].((substr(trim($def_txt_file[$i]),-1,1)=="#") ? substr(trim($def_txt_file[$i]),1,-1) : substr($def_txt_file[$i],1)."<br>");
			$def_txt_idx[$n] = $i;//� ����� ������ ��������� �������� � �����/���������
			$def_txt_idx2[$i] = $n;//���� ������ ������������� ����� ����� ������ ������
		}
		else
		if(trim($def_txt_file[$i])!="")
		{
			if(substr(trim($def_txt_file[$i]),-1,1)=="#")
			{
				$def_txt[$n]=$def_txt[$n].substr(trim($def_txt_file[$i]),0,-1);
				$i++;
			}
			else
				$def_txt[$n]=$def_txt[$n].$def_txt_file[$i]."<br>";
		}
//echo $n."-".$unit_txt[$n]."<br>";
	}

}

//������ race.var
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
			$i++;
			$s1=explode(':',$b_file[$i]);//param2
			$build_param2=$s1[1]+1-1;
			if($build_abil==15)
				if($build_param2<=0)
					$def_build[$build_param1] .= $build_name[$n]."; ";
				else
				{
					$def_build[$build_param1] .= $build_name[$n]." (<B><font color=\"blue\">$build_param2</font></B> ";
					if($build_param2==1)
						$def_build[$build_param1] .= "�������";
					else
					if($build_param2<5)
						$def_build[$build_param1] .= "��������";
					else
						$def_build[$build_param1] .= "���������";
					$def_build[$build_param1] .= "); ";
				}
		}
	}
}

//������ unit.var
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
		$s=trim(substr(trim($s[1]),0,-1));
		if(in_array($n,array_merge(range(40,43),range(238,253),range(263,278))))//��� �����
		{
			$u_name[$n]=$s."<font color=\"fuchsia\">@</font>";
		}
		else
		{
			while(in_array($s,$u_name))
			{
				echo $n."- ����� UNIT=".$s;
				$s = $s."<font color=\"fuchsia\">*</font>";
				echo " <B>������ ��</B> ".$s."<br>";
			}
			$u_name[$n]=$s;
		}
    }
}

//-------------------------------------------------------------
//������ ��������� �����
for($i = 0,$n=0; $i < $count_f; $i++)
{
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
		$s=substr(trim($s[1]),0,-1);
		while(in_array($s,$name_table))
		{
			echo $n."- ����� NAME=".$s;
			$s = $s."<font color=\"fuchsia\">*</font>";
			echo " <B>������ ��</B> ".$s."<br>";
		}
		$name_table[$n]=$s;
//		$name_table[$n]=substr(trim($s[1]),0,-1);
    }
    else
    if(eregi("^Plain",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		if(($s[1]+1-1)!=0) $terrain[$n] .= "�������; ";
//echo $n."-".$terrain[$n][0]."<br>";
//echo $n."-".substr($terrain[$n][0],9);
    }
    else
    if(eregi("^Forest",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		if(($s[1]+1-1)!=0) $terrain[$n] .= "����; ";
    }
    else
    if(eregi("^Hill",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		if(($s[1]+1-1)!=0) $terrain[$n] .= "�����; ";
    }
    else
    if(eregi("^Swamp",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		if(($s[1]+1-1)!=0) $terrain[$n] .= "������; ";
    }
/*    if(eregi("^Plain",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$terrain[$n][0]="�������:".$s[1];
//echo $n."-".$terrain[$n][0]."<br>";
//echo $n."-".substr($terrain[$n][0],9);
    }
    else
    if(eregi("^Forest",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$terrain[$n][1]="   ����:".$s[1];
    }
    else
    if(eregi("^Hill",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$terrain[$n][2]="  �����:".$s[1];
    }
    else
    if(eregi("^Swamp",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$terrain[$n][3]=" ������:".$s[1];
    }
    else
    if(eregi("^Desert",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$terrain[$n][4]="�������:".$s[1];
    }
    if(eregi("^Tundra",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$terrain[$n][5]="  ������:".$s[1];
    }
*/
    else
    if(eregi("^Power:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$Power[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^GoldCost:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$GoldCost[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^GemGost:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$GemGost[$n]=$s[1]+1-1;
	}
    else
    if(eregi("^GoldPayment:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$GoldPayment[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^GemPayment:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$GemPayment[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^Initiative:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$Initiative[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^LootPoss:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$LootPoss[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^LootNum:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$LootNum[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^NoDismiss:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		if(($s[1]+1-1)!=0) $NoDismiss[$n]="��";
    }
    else
    if(eregi("^Karma:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$Karma[$n]=$s[1]+1-1;
		if($Karma[$n] != 0)
			$karma_flag[$def_txt_idx[$n]] = $s[1]+1-1;//� ������ � Ritual.txt, ���� ���� �������� ������� � �����
    }
    else
    if(eregi("^Building:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		if(($s[1]+1-1)!=0) $build_table[$n]=$build_name[$s[1]+1-1];
//echo $n."-".$build_table[$n]."<br>";
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
    if((eregi("^Unit",$a_file[$i])) && (!eregi("^Units",$a_file[$i])))
    {
		$s=explode(':',$a_file[$i]);
		$re[$n][$u2]=explode(',',$s[1]);
		if (($re[$n][$u2][2]+1-1)!=0) //���������� ������ 
		{
			$u_table[$n][$u2]=$u_name[$re[$n][$u2][0]+1-1];
			$u_lvl[$n][$u2]=$re[$n][$u2][1]+1-1;
			$u_cnt[$n][$u2]=$re[$n][$u2][2]+1-1;
//echo $n."-".$u_qua[$n]."<br>";
//     echo "u1=".$u1." u2=".$u2." ".$u_table1[$u1][$u2]."<br>";
// echo "u1=".$u1." u2=".$u2." u_lvl1=".$u_lvl1[$u1][$u2]." u_cnt1=".$u_cnt1[$u1][$u2]." ".$u_table1[$u1][$u2]."<br>";
 //     $str_num[$u1]=count($u_table1[$u1]);
			$u2++;	
		}
	}
    else
    if(eregi("^Ability",$a_file[$i])) //Ability � site.var ��� defender.var
    {
//echo $n."-".$a_file[$i]."<br>";
		if(trim($a_file[$i])!="Ability:")
		{
			$s=explode(':',$a_file[$i]);
			$abil[$n][$a1]['num']=$s[1];	//������ � ������
//echo $n."-".$abil[$n][$a1]['num']."<br>";
			$i++;
			$s=explode(':',$a_file[$i]);
			$abil[$n][$a1]['param1']=$s[1]+1-1;	//������ param1 ������
			$i++;
			$s=explode(':',$a_file[$i]);
			$abil[$n][$a1]['param2']=$s[1]+1-1;	//������ param2 ������
			$a1++;
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

//echo "<table width=100% border=1><tr><td>�</td><td colspan=20>Units</td></tr>";

//����� ������
for($i=0,$j=0;$i<$max+1;$i++)
{ 
//	echo "<tr><td>$i</td><td>";
	for(;($u_table[$i][$j]!="")&&($j<10000);$j++)
	{
		$p = $p.$u_table[$i][$j].":<B><font color=\"red\">".$u_cnt[$i][$j];
		$p = $p."</font></B> (<font color=\"green\">��. <B>".$u_lvl[$i][$j]."</B></font>); ";
		$def_unit2[$i] .= $u_table[$i][$j].":".$u_cnt[$i][$j]." (��. ".$u_lvl[$i][$j]."); ";
	}
	if(in_array($i,$def_no2))
	{
		$def_unit[$i]="<B><font color=\"fuchsia\">������������ �� ������ ���������</font></B>";
		$def_unit2[$i]="������ ������������ �� ������ ���������";
	}
	else
	{
		$def_unit[$i]=substr($p,0,strlen($p)-2);
		$def_unit2[$i]=substr($def_unit2[$i],0,strlen($def_unit2[$i])-2);
	}
	$p="";
//	echo "</td></tr>";
}
//dumper($def_unit2);

//����� ��������
for($i=0;$i<$max+1;$i++)
{ 
//	echo "<tr><td>$i</td><td>";
	for($j=0;($res_table[$i][$j]!="")&&($j<10);$j++)
		$def_res[$i] .= $res_table[$i][$j].(($res_table[$i][$j+1]=="") ? "" : "; ");
//	echo "</td></tr>";
}

//���������
for($i=0;$i<$max+1;$i++)
{
//	echo "<tr><td>$i</td><td>";
	if(!in_array($i,$def_no1))
	{
		if(count(explode(";",$terrain[$i]))==5)
			$def_terrain[$i]="�����";
		else
			$def_terrain[$i]=substr($terrain[$i],0,-2);
	}
//	echo "</td></tr>";
}

//������ 
for($i=0,$j=0;$i<$max+1;$i++)
{ 
//	echo "<tr><td>$i</td><td>";
	for($n=1;($abil[$i][$j]['num']!="")&&($j<10000);$j++,$n++)
	{
		$num=$abil[$i][$j]['num']+1-1;
		$param1=$abil[$i][$j]['param1'];
		$param2=$abil[$i][$j]['param2'];
		if($num==0)
//			$p .= "���";
			$n--;
		else
//		if($num!=0)
			$p .= $n.") ";
		if($num==1)
		{
		    if($param1!=0)
			{
				$p .= "����� ������ � ��������� <B>".(($param1>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param1."%</font>";
			}
		    if($param2!=0)
				$p .= (($param1!=0) ? "</B>; �" : "�")."���� ���������� � ��������� <B>".(($param2>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param2."%";
		}
		else
		if($num==2)
		{
			if($param2==0)
				$p .= "���������� ������� <B>".(($param1>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param1;
			else
			if($param2<0)
			{
				$p .= "���������� ������� <B>".(($param1>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param1;
				$p .= "</font></B>. �� ������� ���������� � ���������� ���� <B><font color=\"teal\">".$unit_race[abs($param2)];
			}
			else
				$p .= "����������� ���������� � ������ ���� <B><font color=\"teal\">".$unit_race[$param2]."</font></B> �� <B><font color=\"green\">$param1";
		}
		else
		if($num==3)
		{
			$p .= "�������� �������� ���������� ������������ �� <B><font color=\"green\">".$param1;
		}
		else
		if($num==4)
		{
			$p .= "�������� ����� ������� ��������� �� <B><font color=\"green\">".$param1."%";
		}
		else
		if($num==5)
		{
			$p .= "���������� ������ ���������� ������ ���������";
		}
		else
		if($num==6)
		{
			$p .= "��������� �������������� ����� ����� �� <B><font color=\"green\">".$param1."%";
		}
		else
		if($num==7)
		{
			$p .= "����� ������ <B>".(($param2>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param2."</font></B>";
			$p .= ", ���� � ��������� ���� <B><font color=\"blue\">".$res_name[$param1];
		}
		else
		if($num==8)
		{
			$p .= "��������� �������������� ���������� � ��������� �� <B><font color=\"green\">".$param1."%";
		}
		else
		if($num==9)
		{
			$p .= "������� ��������� <B>".(($param1>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param1;
		}
		else
		if($num==10)
		{
			$p .= "���������� ������� ��� ����� ������, ������� <B><font color=\"blue\">".$param1."</font></B>, �������� <B><font color=\"blue\">".$param2;
		}
		else
		if($num==11)
		{
			if($param1>0)
				$p .= "������������";
			else
				$p .= "<B>!!!ERROR NUM=11 - Param1 ������ ���� ������ 0";
		}
		else
		if($num==12)
		{
			if($param1>0)
				$p .= "�����������";
			else
				$p .= "<B>!!!ERROR NUM=12 - Param1 ������ ���� ������ 0";
		}
		else
		if($num==13)
		{
			if($param1>0)
				$p .= "���� �������� ��������� ���������";
			else
				$p .= "<B>!!!ERROR NUM=13 - Param1 ������ ���� ������ 0";
		}
		else
		if($num==14)
		{
			$p .= "�� ����� ���� ���������� � ������� ���������";
		}
		else
			$p .= ($num==0 ? "" : "<B>!!!ERROR!!! NUM=".$num);
		$p .= "</font></B>";
		$p .= (($abil[$i][$j+1]['num']!="") ? "<br>" : "");
	}
	if(isset($def_add[$i]))
	{
		if($p != "</font></B>")
			$p .= "<br>";
		for($k=0;$k<count($def_add[$i]);$k++)
		{
			$p .= $n++.") ".$def_add[$i][$k]."</font></B><br>";
		}
		$p = substr($p,0,-4);
	}
	$def_abil[$i]=substr($p,0,-11);
	$p="";
}

//����� ������ �������
echo "<table border=1>";
$def_build[64] = "����� �����������; "; //��� �������� ������ :(
for($i=1;$i<$max+1;$i++)
{
	echo "<tr><td align=center>$i</td><td></td><td>$name_table[$i]</td><td align=center>$Power[$i]";
	echo "</td><td align=center>$GoldCost[$i]</td><td align=center>$GemGost[$i]</td><td align=center>$GoldPayment[$i]";
	echo "</td><td align=center>$GemPayment[$i]</td><td align=center>$Initiative[$i]</td><td></td>";
	echo "<td align=center>$NoDismiss[$i]</td><td>$def_terrain[$i]</td><td>$def_res[$i]</td><td>";
	echo substr($def_build[$i],0,-2)."</td>".(in_array($i,$def_no2) ? "<td align=center>" : "<td>");
	echo "$def_unit[$i]</td><td>$def_abil[$i]</td><td>";
	echo str_replace("~","%",$def_txt[$i])."</td></tr>";
}

echo "</table><br>";

//����� �������� � ����� � ����������� ��������
$f=fopen("Defender_spoil.txt","w") or die("������ ��� �������� ����� Defender_spoil.txt");
for($i = 0; $i < $count_def_txt; $i++)
{
//	if($karma_flag[$i] != 0)
	if(isset($def_txt_idx2[$i]))
	{
		$idx = $def_txt_idx2[$i];
		fwrite($f,"#");
		fwrite($f,"[����������: ".$Initiative[$idx]."]\n");
		if($karma_flag[$i] != 0)
			fwrite($f,"[�����: ".($karma_flag[$i] > 0 ? "+" : "").$karma_flag[$i]."]\n");
		fwrite($f,"[".$def_unit2[$idx]."]\n\n".substr($def_txt_file[$i],1));
	}
	else
		fwrite($f,$def_txt_file[$i]);
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
		echo "<font color=\"red\">".$Karma[$i]."</font></td></tr>";
	echo "</td></tr>";
}

?>
<br><a href='index.html'>��������� � ������ ������</a>
</html>