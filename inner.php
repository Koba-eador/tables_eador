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
$b_file = file("inner_build.var");
$count_b = count($b_file);
$b_g_file = file("build_group.var");
$count_b_g = count($b_g_file);
$b_txt_file = file("Inner_Build.txt");
$count_b_txt = count($b_txt_file);
$u_file = file("unit.var");
$count_u = count($u_file);
$out_build_file = file("outer_build.var");
$count_out_build = count($out_build_file);
$item_file = file("item.var");
$count_item = count($item_file);
$spell_file = file("spell.var");
$count_spell = count($spell_file);
$ritual_file = file("ritual.var");
$count_ritual = count($ritual_file);
$def_file = file("defender.var");
$count_def = count($def_file);
$event_file = file("event.var");
$count_event = count($event_file);
$race_file = file("race.var");
$count_race = count($race_file);
$site_file = file("site.var");
$count_site = count($site_file);

$max=0;$max1=0;$max_u=0;$max_e=0;$t[0]=0;$j=0;
$u1=-1;$u2=0;$u3=0;	//� ������ ����� � xls
$g1=0; //���-�� ������� � ����� �����
$a1=0; //� ������
$a2=0; //� ������� ritual
$e1=0; //� �������
$up1=0; //����� upg_type � unit_upg
$u_a=0; //������ in unit.var

$res_name=array(1=>"������", "������� ������", "����", "����������", "�������", "������", "������", "������", "׸���� �����");
$terrain = array(1=>"�������","���","�����","������","�������","������");
/*
$abil_name[901]="�������������� ���� ��� ���������� I �����";
$abil_name[902]="�������������� ���� ��� ���������� II �����";
$abil_name[903]="�������������� ���� ��� ���������� III �����";
$abil_name[904]="�������������� ���� ��� ���������� IV �����";

//������ ����������� �������
$abil_add[996][1]="����� ��������� ��������, ";
$abil_add[996][2]="����� ������� ������ �������, ";
$abil_add[996][3]="����� �������� ������ ����, ";
$abil_add[996][4]="����� �������� ������, ";
$abil_add[996][5]="�������� � �������� ������� �� <font color=\"green\"><B>50%</B></font>, ";
$abil_add[985][1]="���� ���� �� <font color=\"green\"><B>10%</B></font>, ";
$abil_add[985][2]="���� ���� �� <font color=\"green\"><B>10%</B></font>, ";
$abil_add[985][3]="���� ���� �� <font color=\"green\"><B>10%</B></font>, ";
$abil_add[985][4]="���� ���� �� <font color=\"green\"><B>10%</B></font>, ";
$abil_add[985][5]="���� ���� �� <font color=\"green\"><B>10%</B></font>, ";
$abil_add[907][1]="������������ ������ ������� <font color=\"green\"><B>+1</B></font>, ";
$abil_add[907][2]="������������ ������ ������� <font color=\"green\"><B>+1</B></font>, ";
$abil_add[907][3]="������������ ������ ������� <font color=\"green\"><B>+1</B></font>, ";
$abil_add[907][4]="������������ ������ ������� <font color=\"green\"><B>+1</B></font>, ";
$abil_add[907][5]="������������ ������ ������� <font color=\"green\"><B>+1</B></font>, ";
$abil_add[909][1]="��������� �������� �������, <font color=\"green\"><B>+10%</B></font> ����� �� ���, ";
$abil_add[909][2]="��������� �������� ������ ������� �����, <font color=\"green\"><B>+10%</B></font> ����� �� ���, ";
$abil_add[909][3]="��������� �������� ������ ������� �����, <font color=\"green\"><B>+10%</B></font> ����� �� ���, ";
$abil_add[909][4]="��������� �������� ������ �������� �����, <font color=\"green\"><B>+10%</B></font> ����� �� ���, ";
$abil_add[909][5]="��������� �������� �������, <font color=\"green\"><B>+10%</B></font> ����� �� ���, ";
*/
/*
//������ - ���������� �����:
�������:
1 - group=1
2 - abil=1(�������), item_effect=84, unit_level=1
	abil=8 unit_level[abil]=1
3 - group=3
4 - abil=1(�������), item_effect=84, unit_level=2
	abil=8 unit_level[abil]=2
5 - group=7
6 - abil=1(�������), item_effect=84, unit_level=3
	abil=8 unit_level[abil]=3
7 - group=11
8 - abil=1(�������), item_effect=84, unit_level=4
	abil=8 unit_level[abil]=4
9 - get_slot=2
10 - get_slot=3
*/

/*
function get_slot(&$start,$num)//��������������/�������
{
//echo "START: NUM=$num<br>";
	global $build_upgrade,$build_slot,$build_place;
	if($build_upgrade[$num]==0)
	{
//echo "RET: ".$build_slot[$num]."<br>";
		$build_place[$start]=$build_slot[$num];
		return;
	}
//echo "IN: UP=".$build_upgrade[$num]."<br>";
	get_slot($start,$build_upgrade[$num]);
}
*/

function get_slot($num)//��������������/�������
{
//echo "START: NUM=$num<br>";
	global $build_upgrade;
	if($build_upgrade[$num]==0)
	{
//echo "RET: ".$num."<br>";
		return $num;
	}
//echo "IN: UP=".$build_upgrade[$num]."<br>";
	return get_slot($build_upgrade[$num]);
}

//������ build_group.var
for($i = 0,$n=0; $i < $count_b_g; $i++)
{  
	if(eregi("^/([0-9]{1,})",$b_g_file[$i],$k))
    {
		$n=$k[1];
    }
    else
    if(eregi("^max",$b_g_file[$i]))
    {
		$s=explode(':',$b_g_file[$i]);
		$b_g_max[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^name",$b_g_file[$i]))
    {
		$s=explode(':',$b_g_file[$i]);
		$b_g_name[$n]=str_replace("���������������", "�����������-����",substr(trim($s[1]),0,-1));
    }
}

//������ site.var
for($i = 0,$n=0; $i < $count_site; $i++)
{  
   if(eregi("^/([0-9]{1,})",$site_file[$i],$k))
    {
		$n=$k[1];
    }
    else
    if(eregi("^name",$site_file[$i]))
    {
		$s=explode(':',$site_file[$i]);
		if($n==51)
			$site_name[$n]="������� ����� <font color=\"fuchsia\">(� ������)</font>";
		else
		if($n==53)
			$site_name[$n]="������� ������������";
		else
		if($n==56)
			$site_name[$n]="������";
		else
		if($n==57)
			$site_name[$n]="����� ������������ <font color=\"fuchsia\">(+3)</font>";
		else
		if($n==58)
			$site_name[$n]="����� ������������ <font color=\"fuchsia\">(+1)</font>";
		else
		if($n==60)
			$site_name[$n]="�������� ����������";
/*
		else
		if($n==79)
			$name_table[$n]="�������� ���� <font color=\"fuchsia\">(��'���������)</font>";
		else
		if($n==80)
			$name_table[$n]="�������� ���� <font color=\"fuchsia\">(�'�����)</font>";
*/
		else
		{
			$s=substr(trim($s[1]),0,-1);
			while(in_array($s,$site_name))
			{
				echo $n."- ����� SITE=".$s;
				$s = $s."<font color=\"fuchsia\">*</font>";
				echo " <B>������ ��</B> ".$s."<br>";
			}
			$site_name[$n]=$s;
		}
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

//������ event.var
for($i = 0,$n=0; $i < $count_event; $i++)
{  
   if(eregi("^/([0-9]{1,})",$event_file[$i],$k))
    {
		$n=$k[1];
		if($n>$max_e)$max_e=$n;
		$s=substr($event_file[$i],log10($n)+3);
		$event_table[$n]=trim($s);
		if($event_table[$n][0]=='(')
			$event_table2[$n]=substr($event_table[$n],1,-1);
		else
			$event_table2[$n]=$event_table[$n];
    }
}

//������ ritual.var
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

//������ defender.var
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
			echo $n."- ����� DEFENDER=".$s;
			$s = $s."<font color=\"fuchsia\">*</font>";
			echo " <B>������ ��</B> ".$s."<br>";
		}
		$def_name[$n]=$s;
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
    else
    if(eregi("^Level",$u_file[$i]))
    {
		$s=explode(':',$u_file[$i]);
		$u_level[$n]=$s[1]+1-1;
    }
}

//������ item.var
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
			echo $n."- ����� ITEM=".$s;
			$s .= "<font color=\"fuchsia\">*</font>";
			echo " <B>������ ��</B> ".$s."<br>";
		}
		$item_name[$n]=$s;
    }
    else
    if(eregi("^Building",$item_file[$i]))
    {
		$s=explode(':',$item_file[$i]);
		if(($s[1]+1-1)!=0)
			$build_item[$s[1]+1-1] .= $item_name[$n].", ";
    }
}

//������ spell.var
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
			$s .= " <font color=\"fuchsia\">��������</font>";
		else
		if($n == 336)
			$s .= " <font color=\"fuchsia\">�����</font>";
		else
		if($n == 342)
			$s .= " <font color=\"fuchsia\">��������</font>";
		else
		if($n == 344)
			$s .= " <font color=\"fuchsia\">������</font>";
		else
		if($n == 345)
			$s .= " <font color=\"fuchsia\">��������</font>";
		else
		if($n == 347)
			$s .= " <font color=\"fuchsia\">���������</font>";
		while(in_array($s,$spell_name))
		{
			echo $n."- ����� SPELL=".$s;
			$s = $s."<font color=\"fuchsia\">*</font>";
			echo " <B>������ ��</B> ".$s."<br>";
		}
		$spell_name[$n]=$s;
    }
    else
    if(eregi("^Building",$spell_file[$i]))
    {
		$s=explode(':',$spell_file[$i]);
		$s1 = $s[1]+1-1;
		if($s1 > 0)//�������� ������
			$build_spell[$s1] .= $spell_name[$n].", ";
		else
		if($s1 < 0)//������
			$build_spell_scroll[-$s1] .= $spell_name[$n].", ";
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
}

//������ Inner_Build.txt
for($i = 0; $i < $count_b_txt; $i++)
{  
    if(eregi("^([0-9]{1,})",$b_txt_file[$i],$k))
    {
		$n=$k[1];
		if($n!=0)$build_txt[$n-1]=substr($build_txt[$n-1],0,-4);//�������� ������ ������
    }
    else
	{
		if(trim($b_txt_file[$i])!="")
			$build_txt[$n] .= str_replace("#","",str_replace("~","%",$b_txt_file[$i]))."<br>";
	}
	if(substr(trim($b_txt_file[$i]),0,1)=="#")
		$b_txt_idx[$n] = $i;//� ����� ������ ��������� �������� � �����/���������
}

//������ inner_build.var (��� build_name)
for($i = 0,$n=0; $i < $count_b; $i++)
{  
	if(eregi("^/([0-9]{1,})",$b_file[$i],$k))
    {
		$n=$k[1];
		if($n>$max)$max=$n;
    }
    else
    if(eregi("^Name",$b_file[$i]))
    {
		$s=explode(':',$b_file[$i]);
		$s=substr(trim($s[1]),0,-1);
		if(in_array($s,$build_name))
		{
			echo $n."- ����� NAME=".$s."<br>";
		}
		$build_name[$n]=$s;
// echo $n."-".$build_name[$n]."<br>";
    }
}
//-------------------------------------------------------------
//������ ��������� �����
//������ inner_build.var
for($i = 0,$n=0; $i < $count_b; $i++)
{  
	if(eregi("^/([0-9]{1,})",$b_file[$i],$k))
    {
		$n=$k[1];
		if($n>$max)$max=$n;
    }
    else
    if(eregi("^GoldCost",$b_file[$i]))
    {
		$s=explode(':',$b_file[$i]);
		$build_gold[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^GemCost",$b_file[$i]))
    {
		$s=explode(':',$b_file[$i]);
		$build_gem[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^Group",$b_file[$i]))
    {
		$s=explode(':',$b_file[$i]);
		$build_group[$n]=$s[1]+1-1;
/*
		if($build_group[$n]==1)
			$build_tab[1][]=$n;
		else
		if($build_group[$n]==3)
			$build_tab[2][]=$n;
		else
		if($build_group[$n]==7)
			$build_tab[3][]=$n;
		else
		if($build_group[$n]==11)
			$build_tab[4][]=$n;
		else
		if($build_group[$n]==2)
			$build_tab[31][]=$n;
		else
		if($build_group[$n]==4)
			$build_tab[32][]=$n;
		else
		if($build_group[$n]==8)
			$build_tab[33][]=$n;
		else
		if($build_group[$n]==12)
			$build_tab[34][]=$n;
*/
    }
    else
    if(eregi("^Slot",$b_file[$i]))
    {
		$s=explode(':',$b_file[$i]);
		$build_slot[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^Upgrade",$b_file[$i]))
    {
		$s=explode(':',$b_file[$i]);
		$build_upgrade[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^Hidden",$b_file[$i]))
    {
		$s=explode(':',$b_file[$i]);
		$build_hidden[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^Level",$b_file[$i]))
    {
		$s=explode(':',$b_file[$i]);
		$build_level[$n]=$s[1]+1-1;
    }
    else
	if(eregi("^Building",$b_file[$i]))
    {
		$s=explode(':',$b_file[$i]);
		$s1=substr(trim($s[1]),1,-1);
		$s2=explode(',',$s1);
		for($j=0;($s2[$j]!="")&&($j<20);$j++)
		{
			if($s2[$j]!=0)
			{
				if($s2[$j]<1000)
				{
					$build_build[$n] .= $build_name[$s2[$j]+1-1]."(<B><font color=\"fuchsia\">".($s2[$j]+1-1)."</font></B>), ";//����������� ���������
					$build_in[$s2[$j]+1-1][]=$n;//��������� ������ � ����������
				}
				else
				{
					$q=$b_g_max[$s2[$j]-1000];
					$build_build[$n] .= "<B><font color=\"blue\">";
					if($q==1)
						$build_build[$n] .= "1</font></B> ���������";
					else
						$build_build[$n] .= "$q</font></B> ���������";
					$build_build[$n] .= " ���� <B><font color=\"blue\">".$b_g_name[$s2[$j]-1000]."</font></B>, ";
				}
			}
		}
//echo $n." - B=";
//dumper($build_build[$n]);
		}
    else
	if((eregi("^Resourse:",$b_file[$i])) || (eregi("^Resource:",$b_file[$i])))
    {
		$s=explode(':',$b_file[$i]);
		$s1=substr(trim($s[1]),1,-1);
		$s2=explode(',',$s1);
		for($j=0;($s2[$j]!="")&&($j<20);$j++)
		{
			$build_res[$n] .= $res_name[$s2[$j]+1-1]."; ";
		}
		$build_res[$n]=substr($build_res[$n],0,-2);
    }
    else
    if(eregi("^Ability",$b_file[$i])) //Ability � site.var ��� defender.var
    {
		if(trim($b_file[$i])!="Ability:")
		{
			$s=explode(':',$b_file[$i]);
			$build_abil[$n][]=$s[1];
			$i++;
			$s1=explode(':',$b_file[$i]);//param1
			$build_param1[$n][]=$s1[1]+1-1;
			$i++;
			$s2=explode(':',$b_file[$i]);//param2
			$build_param2[$n][]=$s2[1]+1-1;
/*			if(($s[1]+1-1) == 1) //�������
			{
//				foreach($build_summon[$n][1] as $v)
					
			}
			if(($s[1]+1-1) == 8) //���� ������
				$build_unit[$s1[1]+1-1][1][] = "<B><font color=\"red\">����:</font></B> ������ <B><font color=\"green\">".$build_name[$n]."</font></B>;<br>";
			else
			if(($s[1]+1-1) == 31) //��������� �������� �� ���
			{
				$q=$item_summon[$s1[1]+1-1];
				$build_unit[$q][2][] = "<B><font color=\"red\">���������� �����:</font></B> ������ <B><font color=\"green\">".$build_name[$n]."</font></B> (�� �������� <B><font color=\"brown\">".$item_name[$s1[1]+1-1]."</font></B>);<br>";
			}
			else
			if(($s[1]+1-1) == 1) //������� ���
			{
				$build_egg[$n]=1;
			}
//echo $n." UNIT=".($s1[1]+1-1)."(".$build_unit[$s1[1]+1-1].") EGG=".$build_egg[$n]."<br>";
*/
		}
    }
}
//------------------------------------------------------------
//����� ������ � ������

//������ 
for($i=1;$i<$max+1;$i++)
{ 
	for($j=0,$n=1;($build_abil[$i][$j]!="")&&($j<20);$j++,$n++)
	{
		$num=$build_abil[$i][$j]+1-1;
		$param1=$build_param1[$i][$j];
		$param2=$build_param2[$i][$j];
		if($num==0)
			$p .= "���";
/*		else
		if($num == 60 && count(explode(",",$build_spell_scroll[$i])) < 2)//������ ������� ����������
		{
		}
*/		else
			$p .= $n.") ";
		if($num==1)
		{
			$c=count(explode(",",$build_item[$i]));
			$p .= "<B>�������:</B> ������� ";
			if($param1==2)
			{
				$p .= "<font color=\"blue\"><B>".(7-$param2)."</B></font> ";
				if((7-$param2)==1)
					$p .= "���������� �������� ������ <B><font color=\"blue\">$param2</font></B>";
				else
					$p .= "��������� ��������� ������ <B><font color=\"blue\">$param2</font></B> (�� ������)";
			}
/*
			else
			{
				$c=count(explode(",",$build_item[$i]));
				if($c==2)
					$p .= "��������";
				else
					$p .= "���������";
				$p .= " <font color=\"blue\"><B>".substr($build_item[$i],0,-2)."</B></font> ";
				if($param1==0)
					$p .= "(�������������� ����������)";
				else
				if($param1==1)
				{
					if($c==2)
						$p .= "(���� �����)";
					else
						$p .= "(�� ������)";
				}
			}
*/
			else
			if($param1==1)
			{
				if($c==2)
					$p .= "��������";
				else
					$p .= "���������";
				$p .= " <font color=\"blue\"><B>".substr($build_item[$i],0,-2)."</B></font> ";
				if($param2==1)
				{
					if($c!=2)
					{
						$p .= "(�� ������)";
					}
				}
				else
					$p .= "(<font color=\"blue\"><B>$param2</B></font> ��.)";
			}
			else
			if($param1==0)
			{
				if($c==2)
					$p .= "��������";
				else
					$p .= "���������";
				$p .= " <font color=\"blue\"><B>".substr($build_item[$i],0,-2)."</B></font> (�������������� ����������)";
			}
			else
				$p .= "<B>!!!ERROR �������: param1=".$param1;
		}
		else
		if($num==2)
		{
			$p .= "<B>����������:</B> �������� ";
				if(count(explode(",",$build_spell[$i]))==2)
					$p .= "����������";
				else
					$p .= "����������";
				$p .= " <font color=\"blue\"><B>".substr($build_spell[$i],0,-2)."</B></font> ";
		}
		else
		if($num==3)
		{
			if($param1!=0)
			{
				$p .= "��������� �������� ��������� � ������� ��������� �� <B>";
				$p .= (($param1>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param1."</font>";
				if($param2!=0)
					$p .= "</B>, ";
			}
			if($param2!=0)
			{
				$p .= "��������� �������� ��������� �� ���� ���������� �� <B>";
				$p .= (($param2>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param2."</font>";
			}
		}
		else
		if($num==4)
		{
			$p .= "���������� � �������� ����� ��� <font color=\"blue\"><B>$param2</B></font> ������ ����� <font color=\"blue\"><B>$param1</B></font>";
		}
		else
		if($num==5)
		{
			if($param1!=0)
			{
				$p .= "����� ������ <B>".(($param1>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param1."</font>";
				if($param2!=0)
					$p .= "</B>, ";
			}
			if($param2!=0)
				$p .= "����� ���������� <B>".(($param2>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param2."</font>";
		}
		else
		if($num==6)
		{
			$p .= "������ � �������� ������ ��������<B><font color=\"blue\"> 1";
			if($merc != 0)
				$p .= "-".($merc+$param1);
			$p .= "</font>";
			$merc++;
		}
		else
		if($num==7)
		{
			$p .= "�������� ����� �� ����������� ����� � ���������� �������� �� <B><font color=\"green\">$param1%</font>";
		}
		else
		if($num==8)
		{
			$p .= "���� ����� <B><font color=\"blue\">".$u_name[$param1]."</font>";
			if($param2>0)
				$p .= "</B> (��������� ����� � ����� ������ � ���������)";
		}
		else
		if($num==9)
		{
			$p .= "��������� ������ � ������� <B><font color=\"blue\">".$res_name[$param1]."</font></B>";
			$p .= " �� <B>".(($param2>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param2."</font>";
		}
		else
		if($num==10)
		{
			$p .= "��������� �������� ����� �� ������� ��������� �� <B><font color=\"green\">$param1</font>";
		}
		else
		if($num==11)
		{
			if($param2>0)
			{
				$p .= "��������� <B><font color=\"blue\">$param2</font></B> ";
				if($param2==1)
					$p .= "�������";
				else
					$p .= "��������";
				$p .= " ������� ���������";
			}
			else
				$p .= "�������� ������� � ������� ���������";
			$p .= " <B><font color=\"blue\">".$out_build_name[$param1]."</font>";
		}
		else
		if($num==12)
		{
			if($param1!=0)
			{
				$p .= "��������� ���������� ������� � ������� ��������� �� <B>";
				$p .= (($param1>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param1."</font>";
				if($param2!=0)
					$p .= "</B>, ";
			}
			if($param2!=0)
			{
				$p .= "��������� ���������� ������� �� ���� ���������� �� <B>";
				$p .= (($param2>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param2."</font>";
			}
		}
		else
		if($num==13)
		{
			$p .= "�������� ��������� ����� ����� �� <B><font color=\"green\">$param1%</font>";
		}
		else
		if($num==14)
		{
			$p .= "��������� ������ � ";
			if($param1==0)
				$p .= "������ ���������";
			else
			if($param1==8)
				$p .= "���������� ���������";
			else
				$p .= "��������� ���������� ���� <B><font color=\"blue\">".$terrain[$param1]."</font></B>";
			$p .= " �� <B>".(($param2>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param2."</font>";
		}
		else
		if($num==15)
		{
			if($param2>0)
			{
				$p .= "��������� <B><font color=\"blue\">$param2</font></B> ";
				if($param2==1)
					$p .= "��������";
				else
					$p .= "���������";
				$p .= " �� �������";
			}
			else
				$p .= "���������� ����� ������";
			$p .= " <B><font color=\"blue\">".$def_name[$param1]."</font>";
		}
		else
		if($num==16)
		{
			$p .= "�������� ��������� �������� � ����� �� <B><font color=\"green\">$param1%</font>";
		}
		else
		if($num==17)
		{
			$p .= "�������� ����� �� ������� �� <B><font color=\"green\">$param1%</font>";
		}
		else
		if($num==18)
		{
			$p .= "�������� ��������� ������ ������ �� <B><font color=\"green\">$param1%</font>";
		}
		else
		if($num==19)
		{
			$p .= "��������� ������� ���� ���������� ������� ���������";
			$p .= " �� <B>".(($param1>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param1."</font>";
		}
		else
		if($num==20)
		{
			$p .= "��������� ����� �����������";
			$p .= " �� <B>".(($param1>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param1."</font>";
		}
		else
		if($num==21)
		{
			$p .= "��������� �������������� �������� ������ � ������� ��������� �� <B><font color=\"green\">$param1%</font></B> � ���";
		}
		else
		if($num==22)
		{
			$p .= "��������� ������ ������ ������ ";
			$p .= "�� <B>".(($param1>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param1."%</font>";
		}
		else
		if($num==23)
		{
			if($param1!=0)
			{
				$p .= "���������� ���������� ������������ � ������� ��������� �� <B>";
				$p .= (($param1>0) ? "<font color=\"green\">" : "<font color=\"red\">").$param1."</font>";
				if($param2!=0)
					$p .= "</B>, ";
			}
			if($param2!=0)
			{
				$p .= "���������� ���������� ������������ �� ���� ���������� �� <B>";
				$p .= (($param2>0) ? "<font color=\"green\">" : "<font color=\"red\">").$param2."</font>";
			}
		}
		else
		if($num==24)
		{
			$p .= "����� ������ �� ���������� ������ (������ � ����������). ��������� ��������� ����� ��������.";
		}
		else
		if($num==25)
		{
			$p .= "��������� ������������ ��������� �� <B><font color=\"green\">$param1%</font>";
		}
		else
		if($num==26)
		{
			$p .= "��������� ������� ������������� � ���������� � ����������� ���� <B><font color=\"blue\">".$terrain[$param1]."</font>";
		}
		else
		if($num==27)
		{
			$p .= "���������� ���������� ������� <B><font color=\"blue\">".$ritual_name[$param1]."</font>";
		}
		else
		if($num==28)
		{
			$p .= "�������� ����� ������ ������� ���������� �� <B><font color=\"green\">$param1%</font>";
		}
		else
		if($num==29)
		{
			$p .= "��������� ������ ���������� �� <B>";
			$p .= (($param1>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param1."</font>";
		}
		else
		if($num==30)
		{
			$p .= "���������� ���� �������� ����� � ������� ����� �� <B><font color=\"green\">$param1</font></B>";
			$p .= (($param2>0) ? " � �� ��������� �� <B><font color=\"green\">$param2</font>" : "");
		}
		else
		if($num==31)
		{
			$p .= "���������� ������������ ������� ������ <B><font color=\"blue\">".$item_name[$param1]."</font>";
			if($param2<=0)$p .= "<br>!!! Param2 ������ ���� >0";
		}
		else
		if($num==32)
		{
			$p .= "����� �� ������������ ������ <B><font color=\"green\">+$param1%</font>";
		}
		else
		if($num==33)
		{
			$p .= "���������� ������ ������ ��� ������� ���������� �� <B><font color=\"green\">".($param1*10)."%</font>";
		}
		else
		if($num==34)
		{
			$p .= "���������� ������������ ������ � ����������";
		}
		else
		if($num==35)
		{
			$p .= "�������� ��������� ���� ���������� �� <B><font color=\"green\">$param1</font>";
		}
		else
		if($num==36)
		{
			$p .= "���������� � ����������� <B><font color=\"blue\">$param1</font></B> ";
			if($param1==1)
				$p .= "�����";
			else
				$p .= "�����";
		}
		else
		if($num==37)
		{
			$p .= "���������� ����� �������� ������ �� <B><font color=\"green\">$param1</font>";
		}
		else
		if($num==38)
		{
			$p .= "�� <B><font color=\"green\">$param1%</font></B> ������ ����������� ������� �������, ������ ������";
		}
		else
		if($num==39)
		{
			$p .= "���������� �������� <B><font color=\"blue\">$param1</font></B> ";
			if($param1==1)
				$p .= "��������������� ������";
			else
				$p .= "�������������� �������";
			$p .= " �� ���";
		}
		else
		if($num==40)
		{
			$p .= "���������� ������� <B><font color=\"blue\">$param1</font></B> ";
			if($param1==1)
				$p .= "�������������� ������� ���������";
			else
				$p .= "�������������� ������� ��������";
			$p .= " �� ���";
		}
		else
		if($num==41)
		{
			$p .= "��������� ������ �� ������� � ������� ��������� �� <B> ";
			$p .= (($param1>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param1."%</font>";
		}
		else
		if($num==42)
		{
			$p .= "���������� ��������� ����� ������ �� <B><font color=\"green\">$param1</font>";
		}
		else
		if($num==43)
		{
			$p .= "��������� ��������������� ��������� �� <B><font color=\"green\">$param1</font>";
		}
		else
		if($num==44)
		{
			$p .= "<B>����:</B> ���������� ������ �������������� ����� <B><font color=\"green\">";
			$p .= ++$port."</font></B> ";
			if($port==1)
				$p .= "������� ���������";
			else
				$p .= "������� ���������";
		}
		else
		if($num==45)
		{
			$p .= "��������� ����������� ��������� <B>������� (event) <font color=\"blue\">$param1 (".$event_table2[$param1].")</font></B>";
			$p .= " �� <B>".(($param2>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param2."%</font>";
		}
		else
		if($num==46)
		{
			$p .= "��������� ����� �� <B>";
			$p .= (($param1>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param1."</font>";
			$karma_flag[$b_txt_idx[$i]] = $param1;//� ������ � Inner_Build.txt, ���� ���� �������� ������� � �����
		}
		else
		if($num==47)
		{
			$p .= "��� ��������� ����� ���� � ����� <B><font color=\"blue\">".$unit_race[$param1]."</font>";
		}
		else
		if($num==48)
		{
			$p .= "���������� <B>������� (event) <font color=\"blue\">$param1 (".$event_table2[$param1].")</font></B>";
			$p .= " ����� <B><font color=\"green\">$param2</font></B> ";
			if($param2==1)
				$p .= "���";
			else
			if(($param2>1) && ($param2<5))
				$p .= "����";
			else
				$p .= "�����";
		}
		else
		if($num==49)
		{
			$p .= "��������� ������ ������ � ���������, ��������� ����� <B><font color=\"blue\">".$unit_race[$param1]."</font></B>";
			$p .= " �� <B>".(($param2>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param2."</font>";
		}
		else
		if($num==50)
		{
			$p .= "���������� � ������� ��������� ����� <B><font color=\"blue\">".$site_name[$param1]."</font></B>";
			$p .= (($param2>0) ? " ������ <B><font color=\"green\">$param2</font>" : "");
		}
		else
		if($num==51)
		{
			$p .= "��������� ��������� �� <B>";
			$p .= (($param1>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param1."%</font>";
		}
		else
		if($num==52)
		{
			$p .= "���������� ����� ���� <B><font color=\"blue\">".$param1."</font></B>";
			$p .= ", � ����� �������� <B><font color=\"green\">$param2</font>";
		}
		else
		if($num==53)
		{
			$p .= "���������� ������� ���������� �������� �� <B><font color=\"green\">$param1</font>";
		}
		else
		if($num==54)
		{
			$p .= "���������� ��������� <B><font color=\"blue\">$param1</font></B> ";
			if($param1==1)
				$p .= "�������������� ������";
			else
				$p .= "�������������� ��������";
			$p .= " �� ���";
		}
		else
		if($num==55)
		{
			$p .= "��������� ������ ���������� � ���������, ��������� ����� <B><font color=\"blue\">".$unit_race[$param1]."</font></B>";
			$p .= " �� <B>".(($param2>0) ? "<font color=\"green\">+" : "<font color=\"red\">").$param2."</font>";
		}
		else
		if($num==56)
		{
			$p .= "�������� ���������� ������ �� <B><font color=\"green\">$param1</font>";
		}
		else
		if($num==57)
		{
			$p .= "������ ����� ���������� ���������� ��������� �� <B><font color=\"green\">".$param1."%</font>";
		}
		else
		if($num==58)
		{
			$p .= "��������� ������������ �� ����� ������ �� ������ ���������� <B><font color=\"green\">";
			$p .= ++$spell_lvl."</font></B> �����";
		}
		else
		if($num==59)
		{
			$p .= "���� (����� ������) �������� ����� <B><font color=\"blue\">".$u_name[$param1]."</font>";
//			if($param2>0)
//				$p .= "</B> (��������� ����� � ����� ������ � ���������)";
		}
		else
		if($num==60)
		{
			$c=count(explode(",",$build_spell_scroll[$i]));
			if($c>1)
			{
				$p .= "<B>�������:</B> ������� ";
				if($c==2)
					$p .= "������ ����������";
				else
					$p .= "������� ����������";
				$p .= " <font color=\"blue\"><B>".substr($build_spell_scroll[$i],0,-2)."</B></font>";
			}
			else
				$p .= "�������: ������ ������� �� ������� ������� ����������";
		}
		else
		if($num==61)
		{
			$p .= "��������� ������������ �� ���� �������������� �����";
		}
		else
		if($num==62)
		{
			$p .= "��������� ������������ ������ <B><font color=\"blue\">".$ritual_name[$param1]."</B></font> (������ � ������� ���������)";
		}
		else
		if($num==63)
		{
			$p .= "����������� ����� ������ � ���������, ��������� ����� <B><font color=\"blue\">".$unit_race[$param1]."</font></B>, ��� ������� ����������";
			$p .= " (<B>��������: <font color=\"green\">+1</font>; ����� ��������: <font color=\"green\">+2</font>; ���������: <font color=\"green\">+3</font></B>)";
		}
		else
		if($num==64)
		{
			$p .= "����������� ����� ���������� � ���������, ��������� ����� <B><font color=\"blue\">".$unit_race[$param1]."</font></B>, ��� ������� ����������";
			$p .= " (<B>��������: <font color=\"green\">+1</font>; ����� ��������: <font color=\"green\">+2</font>; ���������: <font color=\"green\">+3</font></B>)";
		}
		else
			$p .= "<B>!!!ERROR NUM=".$num;
		$p .= "</B><br>";
	}
	if($build_group[$i]!=0)
	{
		$b=$b_g_max[$build_group[$i]];
		$p .= $n.") � ����� ����� ���� �� ����� <B><font color=\"blue\">";
		if($b==1)
			$p .= "����� </B></font> ��������� ������� ����";
		else
			$p .= $b."-�</B></font> �������� ������� ����";
		$p .= "</B><br>";
	}
	$build_abil_prn[$i] = substr($p,0,-8);
	$p="";
}
//dumper($karma_flag,"�����");

//����� ��������������/�������
for($i=1;$i<$max+1;$i++)
{
	$slot=$build_slot[get_slot($i)];
	if($slot==1)
	{
		$build_slot_prn[$i]="���� ���������";
	}
	else
	if(in_array($slot,range(2,16)))
	{
		$build_slot_prn[$i]="������� �������";
	}
	else
	if(in_array($slot,range(17,27)))
	{
		$build_slot_prn[$i]="�������� �������";
	}
	else
	if(in_array($slot,range(28,35)))
	{
		$build_slot_prn[$i]="���������� �������";
	}
	else
	if(in_array($slot,range(36,41)))
	{
		$build_slot_prn[$i]="������������";
	}
	else
	if(in_array($slot,range(42,46)))
	{
		$build_slot_prn[$i]="�������� �������";
	}
	else
	if(in_array($slot,range(47,51)))
	{
		$build_slot_prn[$i]="����������� �������";
	}
	else
	if(in_array($slot,range(52,54)))
	{
		$build_slot_prn[$i]="������� ������";
	}
	else
	if(in_array($slot,range(55,59)))
	{
		$build_slot_prn[$i]="������ �������";
	}
	else
	if(in_array($slot,range(60,62)))
	{
		$build_slot_prn[$i]="������� ���������";
	}
	else
		echo "!!!$i - ����������� �������";
//��������� ������ � ����������
	foreach($build_in[$i] as $v)
		$build_in_prn[$i] .= $build_name[$v]."(<B><font color=\"fuchsia\">$v</font></B>), ";

}

//����� �� ������ �����
for($i=1;$i<71;$i++)
{
	$slot=$build_slot[get_slot($i)];
	$build_tab[$slot][]=$i;//���������� �� �����
	if($i==5) $build_tab[$slot][]=241;//��� "��������" :(
	$build_tab_naim[1][$slot][]=$i;//���������
/*
	if($slot==2)
		$build_tab[5][]=$i;
	else
	if($slot==3)
		$build_tab[6][]=$i;
	else
	if($slot==4)
	{
		if(!in_array($i,$build_tab[1])) $build_tab[7][]=$i;
	}
	else
	if($slot==5)
	{
		if(!in_array($i,$build_tab[1])) $build_tab[8][]=$i;
	}
	else
	if($slot==6)
	{
		if(!in_array($i,$build_tab[1])) $build_tab[9][]=$i;
	}
	else
	if($slot==7)
	{
		if(!in_array($i,$build_tab[1])) $build_tab[10][]=$i;
	}
	else
	if($slot==8)
	{
		if(!in_array($i,$build_tab[1])) $build_tab[11][]=$i;
	}
	else
	if($slot==9)
	{
		if(!in_array($i,$build_tab[1])) $build_tab[12][]=$i;
	}
	else
	if($slot==10)
	{
		if(!in_array($i,$build_tab[1])) $build_tab[13][]=$i;
	}
	else
	if($slot==11)
	{
		if(!in_array($i,$build_tab[1])) $build_tab[14][]=$i;
	}
	else
	if($slot==12)
	{
		if(!in_array($i,$build_tab[1])) $build_tab[15][]=$i;
	}
	else
	if($slot==13)
	{
		if(!in_array($i,$build_tab[1])) $build_tab[16][]=$i;
	}
	else
	if($slot==14)
	{
		if(!in_array($i,$build_tab[1])) $build_tab[17][]=$i;
	}
	else
	if($slot==15)
	{
		if(!in_array($i,$build_tab[1])) $build_tab[18][]=$i;
	}
	else
	if($slot==16)
	{
		if(!in_array($i,$build_tab[1])) $build_tab[19][]=$i;
	}
	else
	if($slot==20)
		$build_tab[20][]=$i;
	else
	if($slot==21)
		$build_tab[21][]=$i;
	else
	if($slot==22)
		$build_tab[22][]=$i;
	else
	if($slot==23)
		$build_tab[23][]=$i;
	else
	if($slot==24)
		$build_tab[24][]=$i;
	else
	if($slot==25)
		$build_tab[25][]=$i;
	else
	if($slot==26)
		$build_tab[26][]=$i;
	else
	if($slot==27)
		$build_tab[27][]=$i;
	else
	if($slot==17)
		$build_tab[28][]=$i;
	else
	if($slot==18)
		$build_tab[29][]=$i;
	else
	if($slot==19)
		$build_tab[30][]=$i;
*/
}

for($i=71;$i<126;$i++)
{
	$slot=$build_slot[get_slot($i)];
	$build_tab[$slot][]=$i;//���������� �� �����
	if($i==97)
	{
		$build_tab[$slot][]=240;//��� "������� ���������" :(
		$build_tab[$slot][]=263;//��� "������� ��������������" :(
	}
	$build_tab_naim[2][$slot][]=$i;//���������
}

for($i=126;$i<170;$i++)
{
	$slot=$build_slot[get_slot($i)];
	$build_tab[$slot][]=$i;//���������� �� �����
	if($i==137) $build_tab[$slot][]=262;//��� "������ ������" :(
	$build_tab_naim[3][$slot][]=$i;//���������
}

for($i=170;$i<=$max;$i++)
{
	if(($i!=240) && ($i!=241) && ($i!=262) && ($i!=263)) //������ ����������
	{
		$slot=$build_slot[get_slot($i)];
		$build_tab[$slot][]=$i;//���������� �� �����
		$build_tab_naim[4][$slot][]=$i;//���������
	}
}

echo "<table border=1>";

//����� ����� �������
for($i=1;$i<$max+1;$i++)
//foreach($skill_sort as $i)
{
	echo "<tr><td align=center>$i</td><td>$build_name[$i]</td><td></td><td>$build_txt[$i]</td><td>";//<img src=\"inner/".$i.".bmp\">
	echo $build_abil_prn[$i]."</td><td align=center>".$build_gold[$i]."</td><td align=center>".$build_gem[$i]."</td><td>";
	echo $build_res[$i]."</td><td align=center>".$build_slot_prn[$i];
	echo "<br><B><font color=\"blue\">(".$build_slot[get_slot($i)].")</B></font></td><td>";
	echo ($build_upgrade[$i]==0 ? "" : $build_name[$build_upgrade[$i]]."(<B><font color=\"fuchsia\">".$build_upgrade[$i]."</B></font>)")."</td><td>";
	echo substr($build_build[$i],0,-2)."</td><td>".substr($build_in_prn[$i],0,-2)."</td><td align=center>";
	echo (($build_group[$i]==0) ? "" : "<B><font color=\"blue\">$build_group[$i]</B></font><br> (".$b_g_name[$build_group[$i]].")")."</td><td align=center>";
	echo $build_level[$i]."</td><td align=center>".(($build_hidden[$i]==0) ? "" : "��");
	echo "</td></tr>";
}
/*
for($i=1;$i<$max1+1;$i++)
{
	echo "<tr><td>$i</td><td>";
	echo $abil_txt[$i]."</td></tr>";
}
*/
echo "</table><br>";

//����� �� ������ �����
echo "<table border=1>";

//������� �������
echo "<tr><td></td><td><B><font color=\"red\">������� �������</B></font></td></tr>";
//��������
/*
for($i=191;$i<210;$i+=3)
	$build_tab_naim[1][16][]=$i;
$build_tab_naim[1][16][]=251;$build_tab_naim[1][16][]=254;$build_tab_naim[1][16][]=264;
$build_tab_naim[1][16][]=272;$build_tab_naim[1][16][]=278;$build_tab_naim[1][16][]=279;
*/
//���������
for($j=1;$j<=4;$j++)
{
	for($k=4;$k<=16;$k++)
	{
		foreach($build_tab_naim[$j][$k] as $i)
		{
			echo "<tr><td align=center>$i</td><td>$build_name[$i]</td><td></td><td>$build_txt[$i]</td><td>";
			echo $build_abil_prn[$i]."</td><td align=center>".$build_gold[$i]."</td><td align=center>".$build_gem[$i]."</td><td>";
			echo $build_res[$i]."</td><td align=center>".$build_slot_prn[$i];
			echo "<br><B><font color=\"blue\">(".$build_slot[get_slot($i)].")</B></font></td><td>";
			echo ($build_upgrade[$i]==0 ? "" : $build_name[$build_upgrade[$i]]."(<B><font color=\"fuchsia\">".$build_upgrade[$i]."</B></font>)")."</td><td>";
			echo substr($build_build[$i],0,-2)."</td><td>".substr($build_in_prn[$i],0,-2)."</td><td align=center>";
			echo (($build_group[$i]==0) ? "" : "<B><font color=\"blue\">$build_group[$i]</B></font><br> (".$b_g_name[$build_group[$i]].")")."</td><td align=center>";
			echo $build_level[$i]."</td><td align=center>".(($build_hidden[$i]==0) ? "" : "��");
			echo "</td></tr>";
		}
	}
}
echo "</table><br><br>";
echo "<table border=1>";

//���� � ���������
echo "<tr><td></td><td><B><font color=\"red\">���� � ���������</B></font></td></tr>";
for($j=2;$j<=3;$j++)
{
	foreach($build_tab[$j] as $i)
	{
		echo "<tr><td align=center>$i</td><td>$build_name[$i]</td><td></td><td>$build_txt[$i]</td><td>";
		echo $build_abil_prn[$i]."</td><td align=center>".$build_gold[$i]."</td><td align=center>".$build_gem[$i]."</td><td>";
		echo $build_res[$i]."</td><td align=center>".$build_slot_prn[$i];
		echo "<br><B><font color=\"blue\">(".$build_slot[get_slot($i)].")</B></font></td><td>";
		echo ($build_upgrade[$i]==0 ? "" : $build_name[$build_upgrade[$i]]."(<B><font color=\"fuchsia\">".$build_upgrade[$i]."</B></font>)")."</td><td>";
		echo substr($build_build[$i],0,-2)."</td><td>".substr($build_in_prn[$i],0,-2)."</td><td align=center>";
		echo (($build_group[$i]==0) ? "" : "<B><font color=\"blue\">$build_group[$i]</B></font><br> (".$b_g_name[$build_group[$i]].")")."</td><td align=center>";
		echo $build_level[$i]."</td><td align=center>".(($build_hidden[$i]==0) ? "" : "��");
		echo "</td></tr>";
	}
}
echo "</table><br><br>";
echo "<table border=1>";

//�������� �������
echo "<tr><td></td><td><B><font color=\"red\">�������� �������</B></font></td></tr>";
//�����
for($j=20;$j<=27;$j++)
{
	foreach($build_tab[$j] as $i)
	{
		echo "<tr><td align=center>$i</td><td>$build_name[$i]</td><td></td><td>$build_txt[$i]</td><td>";
		echo $build_abil_prn[$i]."</td><td align=center>".$build_gold[$i]."</td><td align=center>".$build_gem[$i]."</td><td>";
		echo $build_res[$i]."</td><td align=center>".$build_slot_prn[$i];
		echo "<br><B><font color=\"blue\">(".$build_slot[get_slot($i)].")</B></font></td><td>";
		echo ($build_upgrade[$i]==0 ? "" : $build_name[$build_upgrade[$i]]."(<B><font color=\"fuchsia\">".$build_upgrade[$i]."</B></font>)")."</td><td>";
		echo substr($build_build[$i],0,-2)."</td><td>".substr($build_in_prn[$i],0,-2)."</td><td align=center>";
		echo (($build_group[$i]==0) ? "" : "<B><font color=\"blue\">$build_group[$i]</B></font><br> (".$b_g_name[$build_group[$i]].")")."</td><td align=center>";
		echo $build_level[$i]."</td><td align=center>".(($build_hidden[$i]==0) ? "" : "��");
		echo "</td></tr>";
	}
}
echo "</table><br><br>";
echo "<table border=1>";

//�����...
echo "<tr><td></td><td><B><font color=\"red\">�����...</B></font></td></tr>";
for($j=17;$j<=19;$j++)
{
	foreach($build_tab[$j] as $i)
	{
		echo "<tr><td align=center>$i</td><td>$build_name[$i]</td><td></td><td>$build_txt[$i]</td><td>";
		echo $build_abil_prn[$i]."</td><td align=center>".$build_gold[$i]."</td><td align=center>".$build_gem[$i]."</td><td>";
		echo $build_res[$i]."</td><td align=center>".$build_slot_prn[$i];
		echo "<br><B><font color=\"blue\">(".$build_slot[get_slot($i)].")</B></font></td><td>";
		echo ($build_upgrade[$i]==0 ? "" : $build_name[$build_upgrade[$i]]."(<B><font color=\"fuchsia\">".$build_upgrade[$i]."</B></font>)")."</td><td>";
		echo substr($build_build[$i],0,-2)."</td><td>".substr($build_in_prn[$i],0,-2)."</td><td align=center>";
		echo (($build_group[$i]==0) ? "" : "<B><font color=\"blue\">$build_group[$i]</B></font><br> (".$b_g_name[$build_group[$i]].")")."</td><td align=center>";
		echo $build_level[$i]."</td><td align=center>".(($build_hidden[$i]==0) ? "" : "��");
		echo "</td></tr>";
	}
}
echo "</table><br><br>";
echo "<table border=1>";

//���������� �������
echo "<tr><td></td><td><B><font color=\"red\">���������� �������</B></font></td></tr>";
//����� �����
for($j=29;$j<=35;$j++)
{
	foreach($build_tab[$j] as $i)
	{
		echo "<tr><td align=center>$i</td><td>$build_name[$i]</td><td></td><td>$build_txt[$i]</td><td>";
		echo $build_abil_prn[$i]."</td><td align=center>".$build_gold[$i]."</td><td align=center>".$build_gem[$i]."</td><td>";
		echo $build_res[$i]."</td><td align=center>".$build_slot_prn[$i];
		echo "<br><B><font color=\"blue\">(".$build_slot[get_slot($i)].")</B></font></td><td>";
		echo ($build_upgrade[$i]==0 ? "" : $build_name[$build_upgrade[$i]]."(<B><font color=\"fuchsia\">".$build_upgrade[$i]."</B></font>)")."</td><td>";
		echo substr($build_build[$i],0,-2)."</td><td>".substr($build_in_prn[$i],0,-2)."</td><td align=center>";
		echo (($build_group[$i]==0) ? "" : "<B><font color=\"blue\">$build_group[$i]</B></font><br> (".$b_g_name[$build_group[$i]].")")."</td><td align=center>";
		echo $build_level[$i]."</td><td align=center>".(($build_hidden[$i]==0) ? "" : "��");
		echo "</td></tr>";
	}
}
echo "</table><br><br>";
echo "<table border=1>";

//����������...
echo "<tr><td></td><td><B><font color=\"red\">����������...</B></font></td></tr>";
for($j=28;$j<=28;$j++)
{
	foreach($build_tab[$j] as $i)
	{
		echo "<tr><td align=center>$i</td><td>$build_name[$i]</td><td></td><td>$build_txt[$i]</td><td>";
		echo $build_abil_prn[$i]."</td><td align=center>".$build_gold[$i]."</td><td align=center>".$build_gem[$i]."</td><td>";
		echo $build_res[$i]."</td><td align=center>".$build_slot_prn[$i];
		echo "<br><B><font color=\"blue\">(".$build_slot[get_slot($i)].")</B></font></td><td>";
		echo ($build_upgrade[$i]==0 ? "" : $build_name[$build_upgrade[$i]]."(<B><font color=\"fuchsia\">".$build_upgrade[$i]."</B></font>)")."</td><td>";
		echo substr($build_build[$i],0,-2)."</td><td>".substr($build_in_prn[$i],0,-2)."</td><td align=center>";
		echo (($build_group[$i]==0) ? "" : "<B><font color=\"blue\">$build_group[$i]</B></font><br> (".$b_g_name[$build_group[$i]].")")."</td><td align=center>";
		echo $build_level[$i]."</td><td align=center>".(($build_hidden[$i]==0) ? "" : "��");
		echo "</td></tr>";
	}
}
echo "</table><br><br>";
echo "<table border=1>";

//������������, �����, �����, �������, ������ ��������
echo "<tr><td></td><td><B><font color=\"red\">MISC (���������� �������)</B></font></td></tr>";
for($j=36;$j<=59;$j++)
{
	foreach($build_tab[$j] as $i)
	{
		echo "<tr><td align=center>$i</td><td>$build_name[$i]</td><td></td><td>$build_txt[$i]</td><td>";
		echo $build_abil_prn[$i]."</td><td align=center>".$build_gold[$i]."</td><td align=center>".$build_gem[$i]."</td><td>";
		echo $build_res[$i]."</td><td align=center>".$build_slot_prn[$i];
		echo "<br><B><font color=\"blue\">(".$build_slot[get_slot($i)].")</B></font></td><td>";
		echo ($build_upgrade[$i]==0 ? "" : $build_name[$build_upgrade[$i]]."(<B><font color=\"fuchsia\">".$build_upgrade[$i]."</B></font>)")."</td><td>";
		echo substr($build_build[$i],0,-2)."</td><td>".substr($build_in_prn[$i],0,-2)."</td><td align=center>";
		echo (($build_group[$i]==0) ? "" : "<B><font color=\"blue\">$build_group[$i]</B></font><br> (".$b_g_name[$build_group[$i]].")")."</td><td align=center>";
		echo $build_level[$i]."</td><td align=center>".(($build_hidden[$i]==0) ? "" : "��");
		echo "</td></tr>";
	}
}
echo "</table><br><br>";

echo "<table border=1>";

//��������
echo "<tr><td></td><td><B><font color=\"red\">�������� (� ��������, ����� � �����������, ���� ����� �����)</B></font></td></tr>";

$build_tab_ally=array(
191, //(60) ���������� �������
194, //(60) ������ �������
197, //(60) ���������� �������
200, //(60) ������ �������
203, //(60) ������� ������������
206, //(60) ����� ���������
209, //(60) ������� ����������
213, //(60) ���������� ��������
215, //(60) ������� ������
216, //(60) ���������� ���
218, //(60) ������� ������
219, //(60) ������ ��������
221, //(60) ������ ��������
222, //(60) ������� �����
224, //(60) ������� ������
225, //(60) �������� ������������
228, //(60) ������ ���������
230, //(60) �������� ���������
231, //(60) ������ ��������
233, //(60) ���� ����
251, //(60) ������ ���������
252, //(60) ������� ��������������
253, //(60) ������� ����� ��������
260, //(60) �������� ����
264, //(60) ������� �������
265, //(60) �������� �������
268, //(60) ������� ��������
272, //(60) ������� ������
273, //(60) ����� �����
277, //(60) ������� �����
278, //(60) ������ ����������
279, //(60) ������ ����������
280, //(60) ������� �����������
192, //(61) ���������� ����
195, //(61) ������� ��������
198, //(61) �����
201, //(61) �������� ����
204, //(61) ����� ������������
207, //(61) ��������� �����
210, //(61) �������� �����
214, //(61) ���������� ����
217, //(61) ���� ��������
220, //(61) ����
223, //(61) �������� �������
226, //(61) ������ ������������
229, //(61) ��������� �����
232, //(61) �������� ����
254, //(61) ������ �����������
255, //(61) Ҹ���� ����
256, //(61) �������� ���������
261, //(61) ������ ����
266, //(61) ������� ������
274, //(61) �������� ���
276, //(61) ��������
281, //(61) ���� ����
283, //(61) ������� �������
284, //(61) ������� �������
193, //(62) ���������� �����
196, //(62) ������ �����
199, //(62) ������ ������
202, //(62) ����� ����
205, //(62) ������� ������������
208, //(62) ����� �����
211, //(62) ����
227, //(62) ������� �����
257, //(62) ���� ����
258, //(62) ����� ����
259, //(62) �������� ����
267, //(62) ���� ������
275, //(62) ����������� ������
282 //(62) ������� ������
);
$build_tab_ally=array(191,213,215,192,214,193,194,216,218,195,217,196,227,197,219,221,198,220,199,200,222,224,201,223,202,203,225,204,226,
205,206,228,230,207,229,208,209,231,233,210,232,211,251,252,253,260,254,255,256,261,257,258,259,264,265,268,266,283,284,267,272,273,277,274,276,275,278,279,280,281,282);
//� ��������, ����� � �����������, ���� ����� �����...
foreach($build_tab_ally as $i)
{
	echo "<tr><td align=center>$i</td><td>$build_name[$i]</td><td></td><td>$build_txt[$i]</td><td>";
	echo $build_abil_prn[$i]."</td><td align=center>".$build_gold[$i]."</td><td align=center>".$build_gem[$i]."</td><td>";
	echo $build_res[$i]."</td><td align=center>".$build_slot_prn[$i];
	echo "<br><B><font color=\"blue\">(".$build_slot[get_slot($i)].")</B></font></td><td>";
	echo ($build_upgrade[$i]==0 ? "" : $build_name[$build_upgrade[$i]]."(<B><font color=\"fuchsia\">".$build_upgrade[$i]."</B></font>)")."</td><td>";
	echo substr($build_build[$i],0,-2)."</td><td>".substr($build_in_prn[$i],0,-2)."</td><td align=center>";
	echo (($build_group[$i]==0) ? "" : "<B><font color=\"blue\">$build_group[$i]</B></font><br> (".$b_g_name[$build_group[$i]].")")."</td><td align=center>";
	echo $build_level[$i]."</td><td align=center>".(($build_hidden[$i]==0) ? "" : "��");
	echo "</td></tr>";
}
echo "</table><br><br>";

echo "\$build_tab_ally=array(<br>";
for($j=60;$j<=62;$j++)
{
	foreach($build_tab[$j] as $i)
	{
		echo $i.", //($j) $build_name[$i]<br>";
	}
}
echo ");";

//echo "<table width=100% border=1>";
//dumper($build_tab);

//����� �������� � �����
$f=fopen("Inner_Build_spoil.txt","w") or die("������ ��� �������� ����� Inner_Build_spoil.txt");
for($i = 0; $i < $count_b_txt; $i++)
{
	if($karma_flag[$i] != 0)
		fwrite($f,"#[�����: ".($karma_flag[$i] > 0 ? "+" : "").$karma_flag[$i]."]\n".substr(trim($b_txt_file[$i]),1));
	else
		fwrite($f,$b_txt_file[$i]);
}
fclose($f);

?>
<br><a href='index.html'>��������� � ������ ������</a>
</html>