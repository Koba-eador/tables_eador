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
$a_file = file("skill.var");
$count_f = count($a_file);
$abil_file = file("ability_num.var");
$count_abil = count($abil_file);
$abil_txt_file = file("ability.txt");
$count_abil_txt = count($abil_txt_file);
$skill_txt_file = file("Skill.txt");
$count_skill_txt = count($skill_txt_file);

$max=0;$max1=0;$max_u=0;$max_e=0;$t[0]=0;$j=0;
$u1=-1;$u2=0;$u3=0;	//� ������ ����� � xls
$g1=0; //���-�� ������� � ����� �����
$a1=0; //� ������
$a2=0; //� ������� ritual
$e1=0; //� �������
$up1=0; //����� upg_type � unit_upg
$u_a=0; //������ in unit.var

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
$abil_add[909][1]="���������� ��������, <font color=\"green\"><B>+10%</B></font> �������� ������ �� ���, ";
$abil_add[909][2]="���������� ������ ������� �����, <font color=\"green\"><B>+10%</B></font> �������� ������ �� ���, ";
$abil_add[909][3]="���������� ������ ������� �����, <font color=\"green\"><B>+10%</B></font> �������� ������ �� ���, ";
$abil_add[909][4]="���������� ������ �������� �����, <font color=\"green\"><B>+10%</B></font> �������� ������ �� ���, ";
$abil_add[909][5]="���������� ��������, <font color=\"green\"><B>+10%</B></font> �������� ������ �� ���, ";

//������ �� ability_num.var
$hero_abil=array(119,100,101,81,82,83,84,85,92,93,94,95,96,97,98,99,75,76,127,89,90,91,86,87,88,136);
//sort($hero_abil);
//dumper($hero_abil);

//���������� ����-������-���-���
$skill_sort=array_merge(range(8,14),range(22,28),range(1,7),range(15,21));
//dumper($skill_sort);

//������ ability_num.var
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
//		$s=substr(trim($s[1]),0,-1);
		$i++;
		$s1=explode(':',$abil_file[$i]); //number
		$i++;
		$s2=explode(':',$abil_file[$i]); //numeric
		$i++;
		$s3=explode(':',$abil_file[$i]); //Effect
		$i++;
		$s4=explode(':',$abil_file[$i]); //Percent
		if(in_array($s,$abil_name2))
		{
			echo $n."- ����� NAME=".$s."<br>";
		}
//		$abil_name2[$n]=$s;
		$abil_name[$s1[1]+1-1]=substr(trim($s[1]),0,-1);
		$abil_name2[$n]=substr(trim($s[1]),0,-1);
		$abil_numeric[$s1[1]+1-1]=$s2[1]+1-1;
		$abil_percent[$s1[1]+1-1]=$s4[1]+1-1;
    }
}
//������ ability.txt
for($i = 0; $i < $count_abil_txt; $i++)
{  
    if(eregi("^/([0-9]{1,})",$abil_txt_file[$i],$k))
    {
		$n=$k[1]+1-1;
		if($n>$max1)$max1=$n;
    }
    else
	{
		if(substr($abil_txt_file[$i],0,1)=="#")
		{
			if(!eregi("��������:",$abil_txt_file[$i]))
				$abil_txt[$n] .= ((substr(trim($abil_txt_file[$i]),-1,1)=="#") ? substr(trim($abil_txt_file[$i]),1,-1) : substr($abil_txt_file[$i],1)."<br>");
		}
		else
		if(trim($abil_txt_file[$i])!="")
		{
			if(substr(trim($abil_txt_file[$i]),-1,1)=="#")
			{
				$abil_txt[$n] .= substr(trim($abil_txt_file[$i]),0,-1);
				$i++;
			}
			else
				$abil_txt[$n] .= $abil_txt_file[$i]."<br>";
		}
//echo $n."-".$unit_txt[$n]."<br>";
	}

}

//������ skill.txt
for($i = 0; $i < $count_skill_txt; $i++)
{  
    if(eregi("^/([0-9]{1,})",$skill_txt_file[$i],$k))
    {
		$n=$k[1]+1-1;
		if($n>$max2)$max2=$n;
    }
    else
	if(substr($skill_txt_file[$i],0,1)=="#")
		$skill_txt[$n] .= substr(trim($skill_txt_file[$i]),1,-1).".";
}

//-------------------------------------------------------------
//������ ��������� �����
for($i = 0,$n=0; $i < $count_f; $i++)
{
	if(eregi("^/([0-9]{1,})",$a_file[$i],$k))
	{
		$n=$k[1];
		if($n>$max)$max=$n;
    }
	else
    if(eregi("^Name:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$name_table[$n]=substr(trim($s[1]),0,-1);
    }
	else
    if(eregi("^Class:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$skill_class[$n]=$s[1]+1-1;
    }
    else
	if(eregi("^Hero",$a_file[$i]))
    {
		$i++;
		for($j=1;$j<=5;$j++)
		{
			$skill_abil[$n][$j]="<font color=\"blue\"><B>������� ".$j."</B></font>: ";
			$s=explode(':',$a_file[$i]);//Lvl1: (997, 10; 55, 5)
			$s1=explode(';',$s[1]);		// (997, 10; 55, 5)
			for($jj=0;$jj<count($s1);$jj++)
			{
				$s2=explode(',',$s1[$jj]);	// (997, 10
				$s2[0]=trim($s2[0]);
				if(substr($s2[0],0,1)=="(") 
				{
					$s2[0]=substr($s2[0],1);
				}
				$ss=$s2[0]+1-1;// 997 - � ������
				$ss2=$s2[1]+1-1;// 10 - ������
				if($ss == 997)//���������� ����� �������
				{
					$skill_abil[$n][$j] .= "���������� ����� �������: ������ �� <font color=\"green\"><B>".$ss2."%</B></font>";
					$skill_abil[$n][$j] .= ", ���������� �� <font color=\"green\"><B>".($ss2/2)."%</B></font>, ".$abil_add[$ss][$j];
				}
				else
				if($abil_name[$ss]=="")
					$skill_abil[$n][$j] .= "!!!����������� ������ $num";
				else
				if($ss>0)
				{
					$skill_abil[$n][$j] .= $abil_name[$ss];
					if($abil_numeric[$ss]!=0)
					{
						if($ss2>=0)
							$skill_abil[$n][$j] .= " <font color=\"green\"><B>+".$ss2.($abil_percent[$ss]==0 ? "" : "%");
						else
							$skill_abil[$n][$j] .= " <font color=\"red\"><B>".$ss2.($abil_percent[$ss]==0 ? "" : "%");
					}
					$skill_abil[$n][$j] .= "</B></font>, ".$abil_add[$ss][$j];
				}
			}
			$i++;
		}
    }
    else
	if(eregi("^Squad",$a_file[$i]))
    {
		$i++;
		for($j=1;$j<=5;$j++)
		{
//			$skill_abil[$n][$j]="������� ".$j.": ";
			$s=explode(':',$a_file[$i]);//Lvl1: (997, 10; 55, 5)
			$s1=explode(';',$s[1]);		// (997, 10; 55, 5)
			for($jj=0;$jj<count($s1);$jj++)
			{
				$s2=explode(',',$s1[$jj]);	// (997, 10
				$s2[0]=trim($s2[0]);
				if(substr($s2[0],0,1)=="(") 
				{
					$s2[0]=substr($s2[0],1);
				}
				$ss=$s2[0]+1-1;// 997 - � ������
				$ss2=$s2[1]+1-1;// 10 - ������
				if($abil_name[$ss]=="")
					$skill_abil[$n][$j] .= "!!!����������� ������ $num";
				else
				if($ss>0)
				{
					if($abil_numeric[$ss]!=0)
					{
						$skill_abil[$n][$j] .= $abil_name[$ss];
						if($ss2>=0)
							$skill_abil[$n][$j] .= " <font color=\"green\"><B>+".$ss2.($abil_percent[$ss]==0 ? "" : "%")."</B></font> <font color=\"aqua\">(�����)</font>";
						else
							$skill_abil[$n][$j] .= " ".$ss2.($abil_percent[$ss]==0 ? "<font color=\"red\"><B>" : "%")."</B></font> <font color=\"aqua\">(�����)</font>";
					}
					$skill_abil[$n][$j] .= ", ".$abil_add[$ss][$j];
				}
			}
			$i++;
		}
    }
}
//------------------------------------------------------------
//����� ������ � ������
echo "<table width=100% border=1>";

//for($i=1;$i<$max+1;$i++)
foreach($skill_sort as $i)
{
	echo "<tr><td>$name_table[$i]</td><td></td><td>$skill_txt[$i]</td><td>";
	for($j=1;$j<=5;$j++)
	{
		$skill_abil_p[$i] .= substr($skill_abil[$i][$j],0,-2)."<br>";
	}
	echo substr($skill_abil_p[$i],0,-4)."</td></tr>";
}
/*
for($i=1;$i<$max1+1;$i++)
{
	echo "<tr><td>$i</td><td>";
	echo $abil_txt[$i]."</td></tr>";
}
*/
echo "</table><br>";
echo "<table border=1>";

foreach($hero_abil as $i)
{
//	echo "<tr><td>$i $abil_name2[$i]</td><td align=center valign=center><img src=\"h_skill2/".$i.".bmp\"></td><td>";
	echo "<tr><td>$i $abil_name2[$i]</td><td></td><td>";
//	echo str_replace(" �� %d","",str_replace("~","",$abil_txt[$i]))."</td></tr>";
	echo str_replace("%d","<font color=\"green\"><B>%d</B></font>",str_replace("~","<font color=\"blue\"><B>%</B></font>",$abil_txt[$i]))."</td></tr>";
}

?>
<br><a href='index.html'>��������� � ������ ������</a>
</html>