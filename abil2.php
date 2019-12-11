<html><head>
<meta http-equiv="Content-Type" content="text/html charset=windows-1251">
<title>����� - �������� � ����������� ������</title></head><body>
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

//$abil_not=array_merge(range(122,134),array(180));//��������� ������ � �������������� ����������
//$abil_not=array_merge(range(176,182));//��������� ������ � �������������� ����������

//$unit_abil_spell = array(139,189,206,207,216,217,218); //������ ������, ����������� ������ ������������ ������
$unit_abil_spell = array_merge(array(115),range(129,133),array(189),array(220)); //������ ������, ����������� ������ ������������ ������

$hero_up = array_merge(range(40,43),range(238,253),range(263,278));//��� �����

$abil_xod = array(45,52,69,127,128,134,135,137);//������, ������� ����� ��������� �����
//����������� �����,����������� ������,������ �������,��������� ����,��������� �������,����������� ����,���������� �������,�������� �������

//��� need-������, ���������� ���������� ������ (� �������� ������������/������� ������)
$abil_need=array_merge(range(221,259),range(320,339),array(2272));

$abil_stamina = array(20,59,66,78,79);//������, ������� ������ ������������
//�������������� �������,����������� ����,�������� �����,����������� �������,������ �������

$abil_negative=array(1,10,11,12,148); //��� ������ ���� �� ��������� Negative

//��� ����� � ability.txt
$abil_txt_add[1] = "
��������    ��������� �����
����� 0~    ����� 0.5
10~         0.6
20~         0.7
30~         0.8
40~         0.9
50~         1.0
";

$abil_txt_add[2] = "
���� = ����� * ��������������(0.8;1.2) - ������
����� ����<=0, ���� ����������� ������� 1 ����� ��� ���������� �������
��������������(1;20+����)>=10
";

$abil_txt_add[11] = "
��������    ����. �����     ��������
0           0.4(������ 0.5) -2
1           0.5             -2
2           0.6             -2
3           0.7             -1
4           0.8             -1
5           0.9             0
";

$abil_txt_add[12] = "
��������        ��������� �����
0               0.4+������
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


//������ ability_num.var
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

$abil_numeric[213]=1;//���������� ����������
$abil_numeric[67]=1;//�����
$abil_name[73]="���� ��� ���������";
$abil_name[74]="������������";
$abil_name[75]="�������������� ���";
$abil_name[89]="��������";
$abil_name[91]="Ҹ���� ����";
$abil_numeric[91]=1;
$abil_name[92]="��������� ���� ����";
$abil_numeric[92]=1;
$abil_name[93]="������� ���������� � ������������. ��������� ����� ������� ��� �� <font color=\"green\"><B>1</B></font>";
$abil_name[99]="�� ������ �� ��������� ��� ������";
$abil_txt2[99]="�� ������ �� ��������� ��� ������.";
$abil_name[151]="��������� ������������� �����";
$abil_name[152]="������ ������������";
$abil_name[148]="����� �������� (� ��������� ����� ������������ ����������)";
$abil_numeric[148]=1;
$abil_name[149]="������ ���������� �� ���������� �����";
$abil_name[153]="������� ������";
$abil_txt2[153]="������� ������ (�������� �����������).";
$abil_numeric[158]=1;//���������� �������
$abil_name[160]="����������� �������";
$abil_txt2[160]="���������� �������� ������������ �������� ��� ������������� ��������������� ��������.";
$abil_numeric[166]=1;//����������
$abil_numeric[167]=1;//���������
$abil_name[170]="������� �����";
$abil_txt2[170]="������� �����: �������� �����������, ���� �������� ����� ������������� ����� � ���������, �� ������ ����������� ��������� � ���������.";
$abil_name[171]="������� �����";
$abil_txt2[171]="������� �����: ������������� ���� �������� �� Power (+ ��� -), ��� Power>1000 ���� �������� ��������������� ��� Power-1000.";
$abil_name[172]="������� �����";
$abil_txt2[172]="������� �����: ������������� ��������� �������� �� Power (+ ��� -), ��� Power>1000 ��������� �������� ��������������� ��� Power-1000.";
$abil_name[173]="������� �����";
$abil_txt2[173]="������� �����: ���� ���� ��� �����������, ��� �������� � ������� ����� ���� ������� �������� ������.";
$abil_name[174]="������� �����";
$abil_txt2[174]="������� �����: ���� ���� ��� �����������, ��� �������� � ������� ����� ���� ������� ������ ������.";
$abil_name[175]="������� �����";
$abil_txt2[175]="������� �����: ���� ���� ��� �����������, ��� �������� � ������� ����� ���� �������� ���� ������������� ����� � (Power*10/100) ���.";
//$abil_name[180]="��������� �������";
//$abil_txt2[180]="��� ���������� ����� ������������� ���������� \"��������� �������\".";
$abil_name[183]="������� ������� ��� ������� ���. ������������";
$abil_name[189]="���������� �� ����";
$abil_txt2[189]="����������� �� ���� �������� ����� ������ �� ������.";
//$abil_name[192]="������ ����� ������� ��� ���������� ��";
//$abil_txt2[192]="������ ����� ������� ��� ���������� ��.";
//$abil_name[195]="������ ������� �������";
//$abil_txt2[195]="������ ������� �������.";
//$abil_name[199]="�� ���������";
//$abil_txt2[199]="�� ���������.";
$abil_name[115]="���������� � ����������";
$abil_txt2[115]="���������� � ������������ ���������� � �������������� ���� �������� � �����������.";
$abil_name[129]="��������� ���������� ��� �����";
$abil_txt2[129]="��������� ���������� ��� ����� (��� ������ ����� - ����� � ����������).";
$abil_name[130]="��������� ���������� ��� ��������";
$abil_txt2[130]="��������� ���������� ��� �������� (��� ������ ��������).";
$abil_name[133]="�������� ����";
$abil_txt2[133]="�� ���������� � ������� ��� ������������� ����������.";
$abil_name[188]="������ ������ ������";
$abil_txt2[188]="���� ��������� ����� ������ ������.";
$abil_name[192]="�����������: ������";
$abil_txt2[192]="�����������: ������� ������� ����� �����������";
$abil_name[193]="�����������: ��������";
$abil_txt2[193]="�����������: ��������� �������� �������� ����� �����������";
$abil_name[194]="�����������: ����������";
$abil_txt2[194]="�����������: ������� ������ ���������� �������� ����� �����������";
$abil_name[211]="��������� ������� ���� ������ ���";
$abil_numeric[211]=1;
$abil_name[207]="���������� ����� (������)";
$abil_txt2[207]="��������: %d<br>���� ������� �������� ���������� ������ (�������� ������ - ��� ����������� (� ���������), �� ����� ���� ������ 100).";
$abil_name[208]="���������� ����� (���������)";
$abil_txt2[208]="��������: %d<br>���� ������� �������� ���������� ���������� (�������� ������ - ��� ����������� (� ���������), �� ����� ���� ������ 100).";
$abil_name[309] = "������ - ����� ����� ����������";
$abil_txt2[309] = "������ - ����� ����� ����������";
$abil_name[310] = "������ - ����� ����� ����������";
$abil_txt2[310] = "������ - ����� ����� ����������";
$abil_name[311] = "������ � ��� �� ��������������� ������� ��������";
$abil_txt2[311] = "������ � ��� �� ��������������� ������� ��������";
$abil_name[320] = "�������� ����� ����� (1)";
$abil_numeric[320]=0;
$abil_name[321] = "�������� ����� ����� (2)";
$abil_numeric[321]=0;
$abil_name[322] = "�������� ����� ����� (3)";
$abil_numeric[322]=0;
$abil_name[323] = "�������� ��������� (1)";
$abil_numeric[323]=0;
$abil_name[324] = "�������� ��������� (2)";
$abil_numeric[324]=0;
$abil_name[325] = "�������� ��������� (3)";
$abil_numeric[325]=0;
$abil_name[326] = "�������� ��������� (1)";
$abil_numeric[326]=0;
$abil_name[327] = "�������� ��������� (2)";
$abil_numeric[327]=0;
$abil_name[328] = "�������� ��������� (3)";
$abil_numeric[328]=0;
$abil_name[335] = "�������� ����� ����� (4)";
$abil_numeric[335]=0;
$abil_name[336] = "����������� ���� (1)";
$abil_numeric[336]=0;
$abil_name[337] = "����������� ���� (2)";
$abil_numeric[337]=0;
$abil_name[338] = "����������� ���� (3)";
$abil_numeric[338]=0;
$abil_name[339] = "����������� ���� (4)";
$abil_numeric[339]=0;
$abil_name[329] = "����������� �� ������� ������";
$abil_name[330] = "����� ��������";
$abil_name[331] = "����� �������";
$abil_name[332] = "����������� � ����";
$abil_name[333] = "����������� � �����";
$abil_name[334] = "����������� � ������";
$abil_txt2[329] = "����������� �� ������� ������";
$abil_txt2[330] = "����� ��������";
$abil_txt2[331] = "����� �������";
$abil_txt2[332] = "����������� � ����";
$abil_txt2[333] = "����������� � �����";
$abil_txt2[334] = "����������� � ������";

//$up_abil[909] = "���� ������� ������; ";

//������ upgrade.txt
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

//������ ability.txt
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
//			if(!eregi("��������:",$abil_txt_file[$i]))
				$abil_txt[$n] .= ((substr(trim($abil_txt_file[$i]),-1,1)=="#") ? substr(trim($abil_txt_file[$i]),1,-1) : substr($abil_txt_file[$i],1)."<br>");
		}
		else
		if(trim($abil_txt_file[$i])!="")
		{
			if(substr(trim($abil_txt_file[$i]),-1,1)=="#")
			{
				$abil_txt[$n] .= substr(trim($abil_txt_file[$i]),0,-1);
				$abil_txt_idx[$i] = $n;//����� ������ (��� ���������� �������� � ����� ��������)
				$i++;
			}
			else
				$abil_txt[$n] .= $abil_txt_file[$i]."<br>";
		}
		$abil_txt[$n] = str_replace("~","%",$abil_txt[$n]);
	}
}

//������ medal.txt
for($i = 0; $i < count($medal_txt_file); $i++)
{  
    if(eregi("^/([0-9]{1,})",$medal_txt_file[$i],$k))
    {
		$n=$k[1];
		if($n!=0)$medal_txt[$n-1]=substr($medal_txt[$n-1],0,-4);//�������� ������ ������
    }
    else
	{
//		if(trim($medal_txt_file[$i])!="")
			$medal_txt[$n] .= str_replace("#","",str_replace("~","%",$medal_txt_file[$i]))."<br>";
	}
}
$medal_txt[$medal_max] .= "<br>";

//������ medal.var
for($i = 0,$n=0; $i < count($medal_file); $i++)
{  
	if(eregi("^/([0-9]{1,})",$medal_file[$i],$k))
	{
		$n=$k[1];
		if($n>$max)$medal_max=$n;
		$ul=1;//������ ������� � �������
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
	if(eregi("^Power:",$medal_file[$i]))//������ effects: item.var,spell.var
	{
		$s=explode(':',$medal_file[$i-1]);
		$num=$s[1]+1-1;	//������ � ��������
		$s=explode(':',$medal_file[$i]);
		$power=$s[1]+1-1;	//������ power, FlagEffect
		$medal_abil[$n] .= $ul.") ";
	    if($num==85) //����������� �����
			$medal_abil[$n] .= $abil_name[$num]." �� <font color=\"red\"><B>".$power."%</B></font><br>";
	    else
	    if($num==209) //���� �������� ������ ����� �� ���
		{
			$medal_abil[$n] .= "���� �������� ������ <font color=\"red\"><B>".$power."%</B></font> ����� �� ���<br>";
			$medal_txt[$n] = str_replace("%d","<font color=\"red\"><B>$power</B></font>",$medal_txt[$n]);
	    }
		else
		if($abil_name[$num]=="")
			$medal_abil[$n] .= "!!!����������� ������ $num <br>";
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

//������ effects.txt
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


//������ effects.var
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
		if($s1 == 170)//������� �����, hook :(
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
			echo "!!!� ������� �$n ����������� � Ability, � Spell<br>";
			unset($effects_spell[$n]);
		}
		if(!isset($effects_ability[$n]) && !isset($effects_spell[$n]))
			echo "!!!� ������� �$n �� ����������� Ability � Spell<br>";
    }
    else
    if(eregi("^Numeric:",$effects_file[$i]))
    {
		$s=explode(':',$effects_file[$i]);
		$s1 = $s[1]+1-1;
		if($s1 != 0)
		{
			$effects_numeric[$n]=$s1;
//			$effects_name[$n] .= "<br><B><font color=\"fuchsia\">(�������������)</font></B>";
		}
    }
}
/*
dumper($abil_txt,"abil_txt");
dumper($up_txt,"up_txt");
dumper($effects_txt,"effects_txt");
dumper($effects_name,"effects_name");
*/
//������ Spell.txt
for($i = 0; $i < count($spell_txt_file); $i++)
{  
    if(eregi("^([0-9]{1,})",$spell_txt_file[$i],$k))
    {
		$n=$k[1];
    }
    else
	if(!eregi("^#����",$spell_txt_file[$i]) && !eregi("^�����",$spell_txt_file[$i]))
	{
		if(substr($spell_txt_file[$i],0,1)=="#")
		{
			$spell_txt[$n]=$spell_txt[$n].substr($spell_txt_file[$i],1)."<br>";
		}
		else
		if(trim($spell_txt_file[$i]) == "")//���������� ������������ ��������
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

//������ spell.var
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
			$s = $s."<font color=\"fuchsia\">*</font>";
		}
		$spell_name[$n]=$s;
//		$spell_name[$n]=substr(trim($s[1]),0,-1);
/*		$idx = $abil_num[$n+2000];
		if(isset($idx))//������-���� (��������, ������ :((((((
		{
			$abil_txt_add[$idx] = "------------------------------------\n�������� \"$spell_name[$n]\":\n";
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
    if(eregi("^Power:",$spell_file[$i]))//������ effects: item.var,spell.var
    {
		$s=explode(':',$spell_file[$i-1]);
		$spell_effects[$n][$e1]['num']=$s[1]+1-1;	//������ � ��������
		$s=explode(':',$spell_file[$i]);
		$spell_effects[$n][$e1]['power']=$s[1]+1-1;	//������ power, FlagEffect
		$s=explode(':',$spell_file[$i+1]);
		$spell_effects[$n][$e1]['area']=$s[1]+1-1;	//������ area, Duration, FlagEffect
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
			if($num==70) //���
				$p .= "<B>���:</B><br>";
			else
			if($num==71) //��������� �����
				$p .= "<B>��������� �����:</B><br>";
			else
			if($num==72) //����� �����
			{
				$p .= "<B>������� ��� �����/���� ��� �����:</B><br>";
				$spell_white_magic[$i]=1;
			}
	    }
	    else
	    if($num>1000)
		{
			if($area<=0)
			{
				if($target_table[$i]==4) //����
					$p .= "�������� �������� <font color=\"brown\"><B>".$u_name[$num-1000]."</B></font>";
				else
					$p .= "������ �������� <font color=\"brown\"><B>".$u_name[$num-1000]."</B></font>";
			}
			else
				$p .= "����������� � �������� <font color=\"brown\"><B>".$u_name[$num-1000]."</B></font>, ������������ <font color=\"blue\"><B>".$area."</B></font>";
			$p .= ($power>0 ? " (���� <font color=\"fuchsia\"><B>$power</B></font>)" : "").($spell_effects[$i][$j+1]['num']!="" ? "<br>" : "");
		}
	    else
	    if($num==1) //����, �������, �����������
		{
//			$spell_not_do[$i]=1;
			if($spell_white_magic[$i]==1) //����� �����
				$p .= "����� <B><font color=\"green\">+</font>/<font color=\"red\">-</font> ".$power."</B>";
			else
			if($target_table[$i]==4) //����
				$p .= "�����������, ����� <font color=\"green\"><B>".$power."%</B></font>";
			else
			if($negative_table[$i]==0)
			{
				if($area<=0)
					$p .= ($power>0 ? "������� <font color=\"green\">" : "���� <font color=\"red\">");
				else
					$p .= ($power>0 ? "����������� <font color=\"green\">" : "���� <font color=\"red\">");
//					echo ($area<=0 ? "�������" : "�����������");
				$p .= "<B>".abs($power)."</B></font>";
//				echo " <font color=\"green\"><B>".$power."</B></font>";
			}
			else
				$p .= "���� <font color=\"red\"><B>".abs($power)."</B></font>";
			$p .= ($area<=0 ? "" : ", ������������ <font color=\"blue\"><B>$area</B></font>").($spell_effects[$i][$j+1]['num']!="" ? "<br>" : "");		
		}
		else
	    if($num==31) //dispell
			$p .= $abil_name[$num].", ���� <font color=\"green\"><B>".$power."</B></font>".($spell_effects[$i][$j+1]['num']!="" ? "<br>" : "");
	    else
	    if($num==47) //�������
			$p .= $abil_name[$num].($spell_effects[$i][$j+1]['num']!="" ? "</B><br>" : "</B>");
		else
	    if($num==73) //MindControl
		{
			if($area == -1)
				$p .= $abil_name[$num].", ������������� ���� �� ���� <font color=\"green\"><B>".$power;
			else
				$p .= $abil_name[$num].", ������������ <font color=\"blue\"><B>".$area;
			$p .= "</B></font>".($spell_effects[$i][$j+1]['num']!="" ? "<br>" : "");
		}
	    else
	    if($num==74) //Reincarnation
			$p .= $abil_name[$num].", ������������ <font color=\"blue\"><B>".$area."</B></font>".($spell_effects[$i][$j+1]['num']!="" ? "<br>" : "");
	    else
	    if($num==91) //Ҹ���� ����
			$p .= $abil_name[$num].", ������������ <font color=\"blue\"><B>".$area."</B></font>".($spell_effects[$i][$j+1]['num']!="" ? "<br>" : "");
	    else
	    if($num==92) //������
			$p .= $abil_name[$num].", ���� <font color=\"green\"><B>".$power."</B></font>".($spell_effects[$i][$j+1]['num']!="" ? "<br>" : "");
		else
		if($num==145)//������ ����� ��� ����������
			$p .= "���� �� ����� <B><font color=\"red\">".$power."</font></B>, ������������ <font color=\"blue\"><B>".$area."</B></font>".($spell_effects[$i][$j+1]['num']!="" ? "<br>" : "");
	    else
	    if($num==184) //����������� �������� ������ ���
		{
			if($power>0)
				$p .= "����������� <font color=\"green\"><B>".$power."</B></font> ";
			else
				$p .= "����� <font color=\"red\"><B>".abs($power)."</B></font> ";
			if(abs($power) == 1)
				$p .= "�������";
			else
				$p .= "��������";
			$p .= " ������ ���, ������������ <font color=\"blue\"><B>".$area."</B></font>".($spell_effects[$i][$j+1]['num']!="" ? "<br>" : "");
	    }
		else
		if($num==205)//����������� ���������� ����������� �� �����, ��������� ��� �������
		{
			$p .= "��������� �������� <B><font color=\"blue\">".$name_table[$power]."</font></B> ����������� �� �����, ��������� ��� �������";
			$p .= ", ������������ <font color=\"blue\"><B>".$area."</B></font>".($spell_effects[$i][$j+1]['num']!="" ? "<br>" : "");
		}
		else
		if($num==223)//������ ����������� ��������� �������������
		{
			$p .= "��������� ������������� �� ".($power<0 ? " <font color=\"red\"><B>$power%</B></font>" : " <font color=\"green\"><B>+$power%</B></font>");
			$p .= ", ������������ <font color=\"blue\"><B>".$area."</B></font>".($spell_effects[$i][$j+1]['num']!="" ? "<br>" : "");
		}
	    else
		if(in_array($num,$abil_stamina))
		{
			$p .= $abil_name[$num]." (������� ������������ <font color=\"red\"><B>".$power."</B></font>)";
			$p .= ($area<=0 ? "" : ", ������������ <font color=\"blue\"><B>".$area."</B></font>").($spell_effects[$i][$j+1]['num']!="" ? "<br>" : "");
	    }
		else
		if(in_array($num,$abil_xod))
		{
			$p .= $abil_name[$num]." (��������� <font color=\"fuchsia\"><B>$power</font></B> ���";
			if($power>1 && $power<5)
				$p .= "�";
			else
				$p .= "��";
			$p .= ($area<=0 ? ")" : "), ������������ <font color=\"blue\"><B>".$area."</B></font>").($spell_effects[$i][$j+1]['num']!="" ? "<br>" : "");
		}
		else
		if($abil_name[$num]=="")
			$p .= "!!!����������� ������ $num".($spell_effects[$i][$j+1]['num']!="" ? "<br>" : "");
		else
	    if($abil_numeric[$num]==0) //���������������� ������
		{
			if($power<0)
				$p .= "������ ������ <font color=\"aqua\"><B>";
			$p .= $abil_name[$num];
			if($power<0)
				$p .= "</font></B>";
			$p .= ($area<=0 ? "" : ", ������������ <font color=\"blue\"><B>".$area."</B></font>").($spell_effects[$i][$j+1]['num']!="" ? "<br>" : "");
	    }
		else
//		if($negative_table[$i]==0)
//		if($spell_not_do[$i]!=1)
//		if(($negative_table[$i]==1) && ($on_ally_table[$i]==0) && ($on_enemy_table[$i]==1))
		if(($negative_table[$i]==1) && (in_array($num,$abil_negative)))
		{
			if($on_ally_table[$i]!=0 && $on_enemy_table[$i]==0)//����� - �������������, ���� Negative==1 � $power<0
				$p .= $abil_name[$num].($power<0 ? " <font color=\"green\"><B>+".abs($power)."</B></font>" : " <font color=\"red\"><B>-$power</B></font>").($abil_percent[$num]==1 ? "%" : "").($area<=0 ? "" : ", ������������ <font color=\"blue\"><B>".$area."</B></font>").($spell_effects[$i][$j+1]['num']!="" ? "<br>" : "");			
			else
				$p .= $abil_name[$num].($power<0 ? " <font color=\"red\"><B>$power</B></font>" : " <font color=\"red\"><B>-$power</B></font>").($abil_percent[$num]==1 ? "%" : "").($area<=0 ? "" : ", ������������ <font color=\"blue\"><B>".$area."</B></font>").($spell_effects[$i][$j+1]['num']!="" ? "<br>" : "");
		}
		else
			$p .= $abil_name[$num].($power<0 ? " <font color=\"red\"><B>$power</B></font>" : " <font color=\"green\"><B>+$power</B></font>").($abil_percent[$num]==1 ? "%" : "").($area<=0 ? "" : ", ������������ <font color=\"blue\"><B>".$area."</B></font>").($spell_effects[$i][$j+1]['num']!="" ? "<br>" : "");
	}
	$spell_abil_prn[$i]=$p;
	$p="";
//	echo "</td></tr>";
}
*/

//��������������� ������ unit.var ��� unit_upg.var
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
		if(in_array($n,$hero_up))//��� �����
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
			if(($s2[$j]+1-1) == 2) //������� ������ (��� "���������� ������ - �����"
				$u_undead[] = $n;
		}
    }
}
//dumper($u_undead,"u_undead");

//��������������� ������ unit_upg.var ��� need-������, ���������� ���������� ������
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
			$up_type2[$n][$num] = $qua;//��� ��������� ����������� ������ �� ��������� � ����������
			if(in_array($num,$abil_need))//������� � ������ �������
			{
				if($qua > 0)
					$need_flag[$num] = $n+1-1;//���� ����, ��� � ������ ��� ���� ������, ���������� ������ ������
			}
			if(substr(trim($up_file[$i]),-1,1)==";") break; //for
			$i++;
			while(1)
				if(trim($up_file[$i]) == "") //������ ������
					$i++;
				else
					break;
		}
	}
}

//��� ��� ����� ��� ��������������� ������������ ����������� ������ � �������� ���������� ���� ����� ����
for($i = 1; $i <= $max; $i++)
{
	if(in_array($up_need[$i],$abil_need))
	{
		$prev = $need_flag[$up_need[$i]];//���������� �� � �������
		foreach($up_type[$prev] as $key => $num)
		{
//			if(!in_array($num,$up_type[$i]))
			$pos = array_search($num,$up_type[$i]);
			if($pos !== false)
			{
				$up_quantity[$i][$pos] += $up_quantity[$prev][$key];//���������� � ��� �������������
			}
			else
			if(!in_array($num,$abil_need))
			{
				$up_type[$i][] = $num;//����� ��, �� ������������ � ���������
				$up_quantity[$i][] = $up_quantity[$prev][$key];
			}
		}
	}
}

//������ unit_upg
for($n=1; $n <= $max; $n++)
{
//	$up_abil[$n] = "<B><font color=\"fuchsia\">".$up_name[$n]."</B></font> - ";
	foreach($up_type[$n] as $key => $num)
		{
			$qua = $up_quantity[$n][$key];
			if($num==62)//����� ���� (��� ������� "��������� �����")
				$up_new_unit[]=$n;
			if($num==191)//����������� (��� ������� "��������� �����")
			{
				$up_new_unit2[]=$n;
				$up_new_unit2_idx[]=$key;//�� ������ ����� ��������� � ��������
			}
			if(!in_array($num,$abil_not))
			{
				if($qua == 0)
					$up_abil[$n] .= "������ ������ <B><font color=\"fuchsia\">$abil_name[$num]</font></B>; ";
				else
				if($num>3000)//����
				{
					$num3 = $num-3000;
					if($qua == 0)
						$up_abil[$n] .= "������ ������ <B><font color=\"fuchsia\">".$abil_name[$num]."</font></B>; ";
					else
					{
//						$up_abil[$n] .= "����: <B><font color=\"fuchsia\">".$abil_name[$num3]."</font></B> ".($qua<0 ? "<font color=\"red\">$qua" : "<font color=\"green\">+$qua").($abil_percent[$num]==1 ? "%" : "")."</font></B>; ";
						$up_abil[$n] .= "����: <B><font color=\"fuchsia\">";
						if(in_array($num3,$abil_stamina))
						{
							$up_abil[$n] .= $abil_name[$num3]." (������� ������������ <font color=\"red\"><B>".$qua."</B></font>); ";
						}
						else
						if(in_array($num3,$abil_xod))
						{
							$up_abil[$n] .= $abil_name[$num3]." (��������� <font color=\"fuchsia\"><B>$qua</font></B> ���";
							if($qua>1 && $qua<5)
								$up_abil[$n] .= "�";
							else
							if($qua>4)
								$up_abil[$n] .= "��";
							$up_abil[$n] .= ")";
						}
						else
						if($abil_name[$num3]=="")
							$up_abil[$n] .= "!!!����������� ������ $num3; ";
						else
						if($abil_numeric[$num3]==0)
							$up_abil[$n] .= $abil_name[$num3]."</font></B>; ";
						else
							$up_abil[$n] .= $abil_name[$num3]."</font></B>".($qua<0 ? " <B><font color=\"red\">$qua" : " <B><font color=\"green\">+$qua").($abil_percent[$num]==1 ? "%" : "")."</font></B>; ";
					}
				}
				else
				if($num>2000)//�����
				{
//					$spell_abil_flag[$n] = 1;//����, ��� ������ - �����
					if($qua < 0)
						$up_abil[$n] .= "������ ������ <B><font color=\"fuchsia\">".$abil_name[$num]."</font></B>";
					else
						$up_abil[$n] .= "�������� <B><font color=\"blue\">".$spell_name[$num-2000]." $qua</font></B>";
					$up_abil[$n] .= " [<font color=\"fuchsia\">".trim($spell_txt[$num-2000])."</font>]; ";
//					$up_abil[$n] .= " [ <font color=\"fuchsia\">".$spell_abil_prn[$num-2000]."</font> ];<br>";
				}
				else
				if($num==23)//���� ��������
				{
					if($qua>=0)
						$up_abil[$n] .= $abil_name[$num]." <B><font color=\"green\">0-".$qua."</font></B>; ";
					else
						$up_abil[$n] .= "������ ������ <B><font color=\"fuchsia\">$abil_name[$num]</font></B>; ";
				}
				else
				if($num==62)//����� ����
					$up_abil[$n] .= "����� ����: ����� ������ <B><font color=\"brown\">".$u_name[$qua]."</font></B>; ";
				else
				if($num==64)//���������� ������
				{
					if($up_need[$n]==0)
						$up_abil[$n] .= "���������� ������ (<B><font color=\"brown\">".$u_name[$qua]."</font></B>); ";
					else
					{
//						$u_undead_idx += $qua;//������ ������ ��� need!=0
						$up_abil[$n] .= "���������� ������ (<B><font color=\"brown\">".$u_name[$u_undead[$qua]]."</font></B>); ";
					}
				}
				else
				if($num==99)//99. �� ������ �� ��������� ��� ������. 
					$up_abil[$n] .= "�� ������ �� ��������� ��� ������; ";
				else
				if($num==153)//�������� �� ������
					$up_abil[$n] .= "��������� ������ �� ������ ����� (� �������� ������); ";
				else
				if($num==160)//���������� ����������� �� �������� ��� ��������
//					$up_abil[$n] .= "����������� ������ <B><font color=\"fuchsia\">����������� �������</font></B> � <B><font color=\"fuchsia\">������ �������</font></B> ��� ��������; ";
					$up_abil[$n] .= "����������� ������ <B><font color=\"fuchsia\">����������� �������</font></B> ��� ��������; ";
				else
				if($num==170)//������� �����
					$up_abil[$n] .= "������� �����: ";
				else
				if($num==171)//������� �����
				{
					$up_abil[$n] .= "���� �������� ";
					if($qua > 1000)
						$up_abil[$n] .= "= <B>".($qua-1000)."</B>; ";
					else
					if($qua >= 0)
						$up_abil[$n] .= "<B><font color=\"green\">+$qua</font></B>; ";
					else
						$up_abil[$n] .= "<B><font color=\"red\">$qua</font></B>; ";
				}
				else
				if($num==172)//������� �����
				{
					$up_abil[$n] .= "��������� �������� ";
					if($qua > 1000)
						$up_abil[$n] .= "= <B>".($qua-1000)."</B>; ";
					else
					if($qua >= 0)
						$up_abil[$n] .= "<B><font color=\"green\">+$qua</font></B>; ";
					else
						$up_abil[$n] .= "<B><font color=\"red\">$qua</font></B>; ";
				}
				else
				if($num==173)//������� �����
					$up_abil[$n] .= "��������� ��������� ������; ";
				else
				if($num==174)//������� �����
					$up_abil[$n] .= "��������� ������ ������; ";
				else
				if($num==175)//������� �����
				{
					$q = $qua/10;
					$up_abil[$n] .= "���� �������� ��������� � <B><font color=\"green\">$q</font></B> ���";
					if($q>1 && $q<5)
						$up_abil[$n] .= "�";
					$up_abil[$n] .= "; ";
				}
/*				else
				if($num>=305 && $num<=308)//������� �����
					{}
*/				else
				if($num==180)//��������� �������
					$up_abil[$n] .= "��������� �������; ";
				else
				if($num==189)//����������� ����������� �� ���� ���������� ����� ������ �� ������
				{
					$up_abil[$n] .= "����������� �� ���� �������� <B><font color=\"blue\">".$spell_name[$qua]."</font></B> ����� ������ �� ������";
					$up_abil[$n] .= " [<font color=\"fuchsia\">".trim($spell_txt[$qua])."</font>]; ";
				}
				else
				if($num==191)//�����������
				{
					$up_abil[$n] .= $abil_name[$num]." (� ���� ����� <B><font color=\"brown\">".$u_name[$qua]."</font></B>); ";
				}
				else
				if($num==115)//����������� ���������� ����������� �� �����, ��������� ��� �������
				{
					$up_abil[$n] .= "��������� �������� <B><font color=\"blue\">".$spell_name[$qua]."</font></B> ����������� �� �����, ��������� ��� �������";
					$up_abil[$n] .= " [<font color=\"fuchsia\">".trim($spell_txt[$qua])."</font>]; ";
				}
				else
				if($num==129)//�����, ����������� ����� ������ ����������� �� ����� ����������
				{
					$up_abil[$n] .= "�������� ��� ����� <B><font color=\"blue\">".$spell_name[$qua]."</font></B>";
					$up_abil[$n] .= " [<font color=\"fuchsia\">".trim($spell_txt[$qua])."</font>]; ";
				}
				else
				if($num==130)//�����, ����������� ����� ��������� ����������� �� ����� ����������
				{
					$up_abil[$n] .= "�������� ��� �������� <B><font color=\"blue\">".$spell_name[$qua]."</font></B>";
					$up_abil[$n] .= " [<font color=\"fuchsia\">".trim($spell_txt[$qua])."</font>]; ";
				}
				else
				if($num==131)//����� ������ (�������� �����������, ��� ����� �� ���� ����� �������� ����������).
				{
					if($qua==2027)
						$up_abil[$n] .= "����� ��������: ���������� ����; ";
					else
					{
						$up_abil[$n] .= "����� ��������: �������� ��� ����� <B><font color=\"blue\">".$spell_name[$qua]."</font></B>";
						$up_abil[$n] .= " [<font color=\"fuchsia\">".trim($spell_txt[$qua])."</font>]; ";
					}
				}
				else
				if($num==132)//����� �������� (�������� �����������, ��� �������� �� ���� ����� �������� ����������). 
				{
					if($qua==2028)
						$up_abil[$n] .= "����� ��������: ���������� �������; ";
					else
					{
						$up_abil[$n] .= "����� ��������: �������� ��� �������� <B><font color=\"blue\">".$spell_name[$qua]."</font></B>";
						$up_abil[$n] .= " [<font color=\"fuchsia\">".trim($spell_txt[$qua])."</font>]; ";
					}
				}
				else
				if($num==133)//�������� ����(�� ���������� ������������� ����������� ����������)
				{
					if($up_need[$n] == 0)
					{
						$up_abil[$n] .= "�� ���������� ����������� ������������� �������� <B><font color=\"blue\">".$spell_name[$qua]."</font></B>";
						$up_abil[$n] .= " [<font color=\"fuchsia\">".trim($spell_txt[$qua])."</font>]; ";
					}
				}
				else
				if($num==207)//���� ������� �������� ���������� ������
					$up_abil[$n] .= "���������� ����� <B><font color=\"red\">-".(100-$qua)."%</font></B> (������); ";
				else
				if($num==208)//���� ������� �������� ���������� ����������
					$up_abil[$n] .= "���������� ����� <B><font color=\"red\">-".(100-$qua)."%</font></B> (���������); ";
/*					else
					if($up_need[$n] == $num)//������ ������������ ������
						$up_abil[$n] .= "������ ������ <B><font color=\"fuchsia\">".$abil_name[$num]."</font></B>; ";
*/				
				else
				if(in_array($num,$abil_stamina))
				{
					$up_abil[$n] .= $abil_name[$num]." (������� ������������ <font color=\"red\"><B>".$qua."</B></font>); ";
//					$up_abil[$n] .= ($area<=0 ? "" : ", ������������ <font color=\"blue\"><B>".$area."</B></font>").($effects[$i][$j+1]['num']!="" ? "<br>" : "");
				}
				else
				if(in_array($num,$abil_xod))
				{
					$up_abil[$n] .= $abil_name[$num]." (��������� <font color=\"fuchsia\"><B>$qua</font></B> ���";
					if($qua>1 && $qua<5)
						$up_abil[$n] .= "�";
					else
					if($qua>4)
						$up_abil[$n] .= "��";
					$up_abil[$n] .= "); ";
				}
				else
				if($abil_name[$num]=="")
					$up_abil[$n] .= "!!!����������� ������ $num; ";
				else
				if($abil_numeric[$num]==0)
				{
					if($qua<0)
						$up_abil[$n] .= "������ ������ <B><font color=\"fuchsia\">";
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
//unset($up_abil[430]);//��������
//unset($up_abil[589]);//��������� �������
//����� ����
//$up_abil[690] .= " - (��� ����� ����������� ������������� �������� <B><font color=\"blue\">".$spell_name[350]."</font></B>)";
//$up_abil[690] .= " [<font color=\"fuchsia\">".trim($spell_txt[350])."</font>]";
//$up_abil[690].="������ ������ <B><font color=\"fuchsia\">".$abil_name[348]."</font></B>; ����� ����";
//$up_abil[]="<B><font color=\"fuchsia\">����� 5</B></font> - ������� 5";
//$up_abil[]="<B><font color=\"fuchsia\">����� 2</B></font> - ������� +2";
//$up_abil[]="<B><font color=\"fuchsia\">�������������� 2</B></font> - ����� <B>2</B>";
//$up_abil[]="<B><font color=\"fuchsia\">���������� ��������</B></font> - ����� ���������";
//$up_abil[]="<B><font color=\"fuchsia\">������������ ������� -2</B></font> - �������������� ������� <B>-2</B> (<font color=green><B>������ ������� �������� �� </font><font color=blue>2</B></font>)";
//$up_abil[]="<B><font color=\"fuchsia\">�������� ����� 2</B></font> - �������� ����� <B>2</B>";

//sort($up_abil);
/*
//dumper($up_abil,"up_abil");
foreach($up_abil as $p) echo ($ttt++)." ".$p."<br>";
$p = "";
echo "<br>";
*/

//������ unit_upg2.var
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


echo "<h3 align=\"center\">�������� � ����������� ������<br></h3>";
$s=explode(':',$up_file[0]);
echo "Quantity: <B>".$s[1]."</B><br><br>";
//echo "-------------------------------------------------------------<br>";

//����� ������ ��������� ������(unit_upg.var)
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
		if($type>3000)//����
		{
			$type -= 3000;
			$aura_flag[$i] = 1;
		}
		if($type==64)//���������� ������
		{
			$s=explode("%s",$abil_txt[$abil_num[$type]]);
			if($up_need[$i]==0)
				$abil_txt_prn[$abil_num[$type]] = $s[0]."<B><font color=\"brown\">".$u_name[$qua]."</font></B>".$s[1];
			else
				$abil_txt_prn[$abil_num[$type]] = $s[0]."<B><font color=\"brown\">".$u_name[$u_undead[$qua]]."</font></B>".$s[1];
		}
		else
		if($type==165)//������� ������
		{
			if($qua==1)
				$abil_txt_prn[$abil_num[$type]] = str_replace("%s","���",$abil_txt[$abil_num[$type]]);
			else
				$abil_txt_prn[$abil_num[$type]] = str_replace("%s","����",$abil_txt[$abil_num[$type]]);
		}
		else
		if($type==191)//�����������
		{
			$s=explode("%s",$abil_txt[$abil_num[$type]]);
			$abil_txt_prn[$abil_num[$type]] = $s[0]."<B><font color=\"brown\">".$u_name[$qua]."</font></B>".$s[1];
		}
		else
		if($type==185)//������ �������
		{
			$s=explode("%d",$abil_txt[$abil_num[$type]]);
			$abil_txt_prn[$abil_num[$type]] = $s[0]."%d".$s[1]."<B><font color=\"green\">".ceil(($qua*2))."</font></B>".$s[2];
//			$abil_txt[83] = str_replace("%a","<B><font color=\"green\">".($qua/2)."</font></B>",$abil_txt[83]);
//			$abil_txt[83] = str_replace("%b","<B><font color=\"green\">".($qua*2)."</font></B>",$abil_txt[83]);
		}
		else
		if($type==131)//������� �������: ����
		{
			$s=explode("%s",$abil_txt[$abil_num[$type]]);
			$abil_txt_prn[$abil_num[$type]] = str_replace("%d","?",$s[0]."<B><font color=\"blue\">".$spell_name[$qua]."</font></B>".$s[1]);
			if($qua==2027)
				$abil_txt_prn[$abil_num[$type]] = $up_txt[$i];
		}
		else
		if($type==132)//������� �������: �������
		{
			$s=explode("%s",$abil_txt[$abil_num[$type]]);
			$abil_txt_prn[$abil_num[$type]] = str_replace("%d","<B><font color=\"red\">?</font></B>",$s[0]."<B><font color=\"blue\">".$spell_name[$qua]."</font></B>".$s[1]);
			if($qua==2028)
				$abil_txt_prn[$abil_num[$type]] = $up_txt[$i];
		}
		else
/*		if($type==218)//�������� ����
		{
//		echo "@@@$abil_txt2[$type]<br>";
			$s=explode("%s",$abil_txt2[$type]);
			$abil_txt_prn[$abil_num[$type]] = $s[0]."<B><font color=\"blue\">".$spell_name[$qua]."</font></B>".$s[1];
		}
		else
*/
		if($type==907)//���� �������
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
			if($aura_flag[$i] == 1) echo "<B><font color=\"aqua\">����:</font></B> ";
			echo str_replace("%d",$replace,$abil_txt_prn[$abil_num[$type]]);
			echo "</td><td align=center class=bottom>".($abil_num[$type]+1-1)."</td>";//��� XLA-������� ��������
		}
		else
		{
			echo "<td>".$abil_name[$type]."</td><td align=center><img align=center src=i/a".($abil_num[$type]+1-1).".gif></td><td>";
//			echo "<td>".$abil_name[$type]."</td><td align=center></td><td>";
			if($aura_flag[$i] == 1) echo "<B><font color=\"aqua\">����:</font></B> ";
			echo str_replace("%d",$replace,$abil_txt_prn[$abil_num[$type]]);
			echo "</td><td align=center>".($abil_num[$type]+1-1)."</td>";//��� XLA-������� ��������
		}
		if($j==0)
			echo "<td rowspan=$num class=bottom>".$up_abil[$i]."</td>";
//		else
//			echo "<td></td>";
		echo "</tr>";
	}
/*
	echo "<tr><td><img src=i/u".$i.".gif align=center></td></tr>";
	echo "<tr><td width=2%>ID</td><td width=15%>���</td><td width=5%><img src=i/u".$i.".gif align=center></img></td><td width=50%>��������</td><td width=28%>��������</td></tr>";
	echo "<tr><td width=5%>$i ($num)</td><td width=15%>".$up_name[$i]."</td><td width=50%>".$abil_txt[$i]."</td><td width=30%>".$up_txt[$i]."</td></tr>";
*/
}
echo "</table><br>";

//����� �������� (effects.var)
echo "<table border=1>";
for($i=1;$i<=$max_effects;$i++)
{
	echo "<tr><td align=center>$i</td><td>$effects_name[$i]</td><td align=center><img align=center src=i/";
//	echo isset($effects_ability[$i]) ? "a".$abil_num[$effects_ability[$i]] : "s".$effects_spell[$i];
	if(isset($effects_ability[$i]))
	{
		echo $s = "a".$abil_num[$effects_ability[$i]];
		copy("i/$s.gif","i/e$i.gif");//��� XLA-������� �������� - ������ ����� ���� e1.gif �� ������/�������
	}
	else
	{
		echo $s = "s".$effects_spell[$i];
		copy("i/$s.gif","i/e$i.gif");//��� XLA-������� �������� - ������ ����� ���� e1.gif �� ������/�������
	}
	echo ".gif></td><td>".$effects_txt[$i]."</td><td>";
	echo "ABIL=".($effects_ability[$i] ? $effects_ability[$i]." (".$abil_name[$effects_ability[$i]].")" : "")."<br>";
	echo "SPELL=".($effects_spell[$i] ? $effects_spell[$i]." (".$spell_name[$effects_spell[$i]].")" : "")."</td>";
	echo "</tr>";
}
echo "</table><br>";

//����� �������
echo "<table border=1>";
for($i=1;$i<=$medal_max;$i++)
{
	echo "<tr><td align=center>$i</td><td>$medal_name[$i]</td><td></td><td>".substr($medal_txt[$i],0,-6)."</td><td align=center>";
	echo $medal_GoldSpent[$i]."</td><td align=center>".$medal_GemSpent[$i]."</td><td align=center>".$medal_Rarity[$i]."</td><td>";
	echo substr($medal_abil[$i],0,-4)."</td></tr>";
}
echo "</table><br>";

//��� ��������
$f=fopen("ability_spoil.txt","w") or die("������ ��� �������� ����� ability_spoil.txt");
for($i = 0; $i < count($abil_txt_file); $i++)
{
	if(isset($abil_txt_idx[$i]))//������� � �����
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
