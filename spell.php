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

//��� �-�����
$spell_eadoropedia = array(1,2,4,13,20,22,23,32,38,41,44,57,58,63,64,65,66,68,78,79,86,90,97,100,103,106,116,123,
127,130,131,132,135,136,140,142,151,152,155,156,159,160,164,165,167,173,179,180,187,191,201,212,214,218,226,228,231,
232,239,240,246,250,251,254,255,256,257,261,268,270,271,278,299,300,316,352,356);
$spell_damage = array(
"4 (�����)",
"5 (������������)",
"9 (�����)",
"6 (������ ���)",
"6 (����� � �������)",
"9 (�����)",
"7 (�����)",
"5 (�����)",
"16 (�����)",
"15 (�����)",
"20 (�����)",
"10 (�����)",
"9 (�����)",
"10 (������ ���)",
"15 (�����)",
"30 (�����)",
"10 (�����)",
"13 (�����)",
"8 (������������)",
"8 (�����)",
"7 (�����)",
"13 (�����)",
"3 (�������)",
"8 (����� � �������)",
"3 (�����)",
"6 (�����)",
"15 (�����)",
"12 (�����)",
"10 (�����)",
"6 (�����)",
"18 (�����)",
"16 (�����)",
"4 (�����)",
"5 (������������)",
"15 (�����)",
"15 (�����)",
"10 (�����)",
"15 (�����)",
"10 (�����)",
"20 (�����)",
"12 (�����)",
"15 (�����)",
"12 (�����)",
"10 (�����)",
"12 (�����)",
"16 (�����)",
"20 (������ ���)",
"8 (������ ���)",
"2 (������������)",
"2 (������ ���)<br>4 (�����)",
"8 (����� � �������)",
"50 (�����)",
"12 (������������)",
"12 (�����)",
"8 (������ ���)",
"15 (�����)",
"5 (�����)",
"10 (�����)",
"15 (�����)",
"10 (�����)",
"5 (������������)",
"14 (������ ���)",
"20 (�����)",
"30 (�����)",
"20 (�����)",
"9 (�����)",
"15 (�����)",
"4 (������ ���)",
"15 (�����)",
"12 (�����)",
"15 (�����)",
"3 (������ ���)<br>3 (�����)<br>3 (������������)",
"6 (������ ���)",
"3 (�����)",
"5 (�����)",
"7 (�����)",
"4 (������ ���)");

$abil_name[73]="���� ��� ���������";
$abil_name[74]="������������";
$abil_name[75]="�������������� ���";
$abil_name[89]="��������";
$abil_name[91]="Ҹ���� ����";
$abil_numeric[91]=1;
$abil_name[92]="��������� ���� ����";
$abil_numeric[92]=1;
$abil_name[93]="������� ���������� � ������������. ��������� ����� ������� ��� �� <font color=\"green\"><B>1</B></font>";
//$abil_name[148]="����� �������� (� ��������� ����� ������������ ����������)";
//$abil_numeric[148]=1;
$abil_name[149]="������ ���������� �� ���������� �����";
$abil_name[151]="��������� ������������� �����";
$abil_name[152]="������ ������������";
$abil_name[159]="��������� �������";
$abil_name[183]="������� ������� ��� ������� ���. ������������";
//$abil_name[192]="������ ����� ������� ��� ���������� ��";
$abil_name[211]="��������� ������� ���� ������ ���";
$abil_numeric[211]=1;
$abil_name[223]="������������ ���������� (+/- �� �����/�����)";
$abil_numeric[223]=1;
$abil_name[225]="�������� �����";
$abil_name[233]="�������� ���������� ����";
$abil_name[241]="�������� ���";
$abil_name[242]="�������� ������";
$abil_name[243]="�������� �������� ������";
$abil_name[244]="�������� �������������";
$abil_name[245]="�������� �����";
$abil_name[246]="�������� ��������� �����";
$abil_name[247]="�������� ���������";
$abil_name[248]="�������� ������ ������� �������������";
$abil_name[252]="������ ������� ������� ����";
$abil_name[280]="�������� �����";
//$abil_name[285]="���� �����";
//$abil_numeric[285]=1;
$abil_name[299]="����� ������ �� ���� �����";

$unit_abil_spell = array(189,129,130,131,132,133); //������ ������, ����������� ������ ������������ ������
/*
����������� ����������� �� ���� ���������� ����� ������ �� ������
����������� ���������� ��� �����
����������� ���������� ��� ��������
����� ������ (���������� ��������� ���������� ��� �����/��������)
����� �������� (���������� ��������� ���������� ��� �����/��������)
�������� ���� (�� ���������� ������������� ����������� ����������)
*/
$unit_abil_meelee = array(16=>213,186=>142,362=>177,30=>178,21=>179); //�����, ������������� ���������� ������
/*
142. ����������� (�������� �����������).
-176. �������� ������� (��� ���������� ����� ������������� ���������� "�������"). 
177. �������� ��������� (��� ���������� ����� ������������� ���������� "���������"). 
178. �������� ������� (��� ���������� ����� ������������� ���������� "�������"). 
179. �������� ���������� (��� ���������� ����� ������������� ���������� "����������"). 
213. ������ ��� (������������ � Spell.var). ������������� ��������� ������ ��������� �������� ������������ �������� ���������� �� ����������. 
*/

$abil_xod = array(45,52,69,127,128,134,135,137);//������, ������� ����� ��������� �����
//����������� �����,����������� ������,������ �������,��������� ����,��������� �������,����������� ����,���������� �������,�������� �������

$abil_stamina = array(20,59,66,78,79);//������, ������� ������ ������������
//�������������� �������,����������� ����,�������� �����,����������� �������,������ �������

//$unit_type=array(1=>"��������","������","�����","������������","�����");
$abil_negative=array(1,10,11,12,148); //��� ������ ���� �� ��������� Negative

$max=0;$max1=0;$max_u=0;$max_e=0;$t[0]=0;$j=0;
$u1=-1;$u2=0;$u3=0;	//� ������ ����� � xls
$g1=0; //���-�� ������� � ����� �����
$a1=0; //� ������
$a2=0; //� ������� ritual
$e1=0; //� �������
$up1=0; //����� upg_type � unit_upg
$u_a=0; //������ in unit.var
$p=""; //��� ������ ��� ��������� ";"

//������ spell_event.exp
for($i = 0; $i < count($spell_event_file); $i++)
{
	$str = trim($spell_event_file[$i]);
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
			$spell_event_cnt[$s[0]] = $s[3];//�-�� ������
		}
	}
}

foreach($export_spell_event_scroll as $spell => $ev)
{
	foreach($ev as $i)
	{
			$p = "";
			$cnt = $spell_event_cnt[$spell];
			$p .= "����� �������� <B><font color=\"blue\">".$cnt." </font></B>";
			if($cnt==1)
				$p .= "������";
			else
			if($cnt>1 && $cnt<5)
				$p .= "������";
			else
				$p .= "�������";
			$p .= " ���������� �� <B>������ ������� (group_event) <font color=\"blue\">$i (".$EventGroupName[$i].")</font></B>";
			$spell_add[$spell][] = $p;//���. ������� ��������� ������� ����������
	}
}

//������ spell_enc.exp
for($i = 0; $i < count($spell_enc_file); $i++)
{
	$str = trim($spell_enc_file[$i]);
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
			$spell_enc_cnt[$s[0]] = $s[3];//�-�� ������
		}
	}
}

foreach($export_spell_enc_scroll as $spell => $enc)
{
	foreach($enc as $i)
	{
			$p = "";
			$cnt = $spell_enc_cnt[$spell];
			$p .= "����� �������� <B><font color=\"blue\">".$cnt." </font></B>";
			if($cnt==1)
				$p .= "������";
			else
			if($cnt>1 && $cnt<5)
				$p .= "������";
			else
				$p .= "�������";
			$p .= " ���������� �� <B>������ ����������� (group_enc) <font color=\"blue\">$i (".$EncGroupName[$i].")</font></B>";
			$spell_add[$spell][] = $p;//���. ������� ��������� ������� ����������
	}
}

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
		$i++;
		$s1=explode(':',$abil_file[$i]); //number
		$i++;
		$s2=explode(':',$abil_file[$i]); //numeric
		$i++;
		$s3=explode(':',$abil_file[$i]); //Effect
		$i++;
		$s4=explode(':',$abil_file[$i]); //Percent
		if($abil_name[$s1[1]+1-1]!="")
			echo "<B><font color=\"red\">!!! num=".$n."-ABIL_NUM =".$s1[1]."-- (".$abil_name[$s1[1]+1-1].") ��� ����</font></B><br>";
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

//������ Spell.txt
for($i = 0; $i < $count_spell; $i++)
{  
    if(eregi("^([0-9]{1,})",$spell_file[$i],$k))
    {
		$n=$k[1];
    }
    else
//	if(!eregi("^#����",$spell_file[$i]))
//	{
	if(substr($spell_file[$i],0,1)=="#")
	{
	    $spell_txt[$n]=$spell_txt[$n].substr($spell_file[$i],1)."<br>";
		$spell_txt_idx[$n] = $i;//� ����� ������ ��������� �������� � �����/���������
		$spell_txt_idx2[$i+1] = $n;//� ����� ������ ��������� �������� � PowerMod � ��.
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
    if(eregi("^Building:",$item_file[$i]))
    {
		$s=explode(':',$item_file[$i]);
		if(($s[1]+1-1)!=0)
			$item_build[$n]=$s[1]+1-1;
    }
	else
    if(eregi("^Power:",$item_file[$i]))//������ effects: item.var,spell.var
    {
		$s=explode(':',$item_file[$i-1]);
//		$effects[$n][$e1]['num']=$s[1]+1-1;	//������ � ��������
		$s1=explode(':',$item_file[$i]);
//		$effects[$n][$e1]['power']=$s[1]+1-1;	//������ power, FlagEffect
		if(($s[1]+1-1) == 83) //spell
		{
//			$build_unit[$s1[1]+1-1]=$build_unit[$s1[1]+1-1].
			$build_table[$s1[1]+1-1] .= $build_name[$item_build[$n]]." (������� ������)";//��������� ��� ������� ����������
		}
//echo $n."-e1=".$e1." NUM=".$effects[$n][$e1]['num']." POWER=".$effects[$n][$e1]['power']." AREA=".$effects[$n][$e1]['area']."<br>";
    }
}

//������ unit_upg.var
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
//		if(trim($up_file[$i])=="") {$i++;break;} //������ ������
			$i++;
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
		$s = $s2 = trim(substr(trim($s[1]),0,-1));
		if(in_array($n,array_merge(range(40,43),range(238,253),range(263,278))))//��� �����
		{
			$u_name[$n]=$s."<font color=\"fuchsia\">@</font>";
			$u_name2[$n]=$s."@";
		}
		else
		{
			while(in_array($s,$u_name))
			{
				echo $n."- ����� UNIT=".$s;
				$s = $s."<font color=\"fuchsia\">*</font>";
				$s2 .= "*";
				echo " <B>������ ��</B> ".$s."<br>";
			}
			$u_name[$n]=$s;
			$u_name2[$n]=$s2;//��� ���������
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
			$u_abil[$n][$j]=$s[1]+1-1;	//������ � ������
			$u_abil2[$n][$s[1]+1-1]['count']+=1; //���-�� ���������� ������
			$u_abil2[$n][$s[1]+1-1]['lvl']=-1; //��� ����� ���������� ������, -1=���������� ���������
//echo $n." NUM=".($s[1]+1-1)." COU=".$u_abil2[$n][$s[1]+1-1]['count']."<br>";

//		$u_a++;

			for($jj=0;$jj<16;$jj++) //��������� unit_upg.var ��� ������ ���.������
			{
//echo $n." UP_TYPE=".$up_type[$u_abil[$n][$j]][$jj]."<br>";
				if($up_type[$u_abil[$n][$j]][$jj]>2000 && $up_quantity[$u_abil[$n][$j]][$jj]>=0) //��� ������ � ���.������
				{
					$sp=$up_type[$u_abil[$n][$j]][$jj]-2000; //� ����������
					if(!in_array($sp,$spell_array[$n]))//������� �����
					{
						$spell_array[$n][] = $sp;
						$spell_unit[$sp] .= "<B><font color=\"brown\">".$u_name[$n]."</font></B>(<B><font color=\"blue\">0</font></B>); ";
						$spell_unit2[$sp] .= $u_name2[$n]."(0); ";
					}
//echo $sp." ".$spell_unit[$sp]."<br>";
				}
				else
				if(in_array($up_type[$u_abil[$n][$j]][$jj],$unit_abil_spell)) //������ ������, ����������� ������ ������������ ������
				{
					if($up_need[$u_abil[$n][$j]] == 0)
					{
						$sp=$up_quantity[$u_abil[$n][$j]][$jj]; //� ����������
						if(!in_array($sp,$spell_array[$n]))//������� �����
						{
							$spell_array[$n][] = $sp;
							$spell_unit[$sp] .= "<B><font color=\"brown\">".$u_name[$n]."</font></B>(<B><font color=\"blue\">0</font></B>); ";
							$spell_unit2[$sp] .= $u_name2[$n]."(0); ";
						}
					}
//echo $sp." ".$spell_unit[$sp]."<br>";
				}
				else
				if($idx=array_search($up_type[$u_abil[$n][$j]][$jj],$unit_abil_meelee)) //�����, ������������� ���������� ������
				{
					if($up_need[$u_abil[$n][$j]] == 0)
					{
//						$sp=$up_quantity[$u_abil[$n][$j]][$jj]; //� ����������
						if(!in_array($idx,$spell_array[$n]))//������� �����
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



				for($jjj=0;$jjj<16;$jjj++) //��������� unit_upg.var ��� ������ ���.������
				{
//echo $n." jjj=".$jjj." type=".$up_type[$uu][$jjj]."<br>";
					if($up_type[$uu][$jjj]>2000 && $up_quantity[$uu][$jjj]>=0) //��� ������ � ���.������
					{
						$sp=$up_type[$uu][$jjj]-2000; //� ����������
						if(!in_array($sp,$spell_array[$n]))//������� �����
						{
							$spell_array[$n][] = $sp;
							$spell_unit[$sp] .= "<B><font color=\"brown\">".$u_name[$n]."</font></B>(<B><font color=\"blue\">".$j."</font></B>); ";
							$spell_unit2[$sp] .= $u_name2[$n]."($j); ";
						}
//echo $n." jjj=".$jjj." type=".$up_type[$uu][$jjj]." sp=".$sp." ".$spell_unit[$sp]."<br>";
					}
					else
					if(in_array($up_type[$uu][$jjj],$unit_abil_spell)) //������ ������, ����������� ������ ������������ ������
					{
						if($up_need[$uu] == 0)
						{
							$sp=$up_quantity[$uu][$jjj]; //� ����������
							if(!in_array($sp,$spell_array[$n]))//������� �����
							{
								$spell_array[$n][] = $sp;
								$spell_unit[$sp] .= "<B><font color=\"brown\">".$u_name[$n]."</font></B>(<B><font color=\"blue\">$j</font></B>); ";
								$spell_unit2[$sp] .= $u_name2[$n]."($j); ";
							}
						}
//echo $sp." ".$spell_unit[$sp]."<br>";
					}
					else
					if($idx=array_search($up_type[$uu][$jjj],$unit_abil_meelee)) //�����, ������������� ���������� ������
					{
						if($up_need[$uu] == 0)
						{
//							$sp=$up_quantity[$u_abil[$n][$j]][$jj]; //� ����������
							if(!in_array($idx,$spell_array[$n]))//������� �����
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

//������ unit_subtype.var
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
//������ ��������� �����
for($i = 0,$n=0; $i < $count_f; $i++)
{  //echo "<br>".$a_file[$i];
	if(eregi("^/([0-9]{1,})",$a_file[$i],$k))
	{
		$n=$k[1];
		if($n>$max)$max=$n;
		$u1++;	//� ������
    }
	else
    if(eregi("^Name:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
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
		while(in_array($s,$name_table))
		{
			echo $n."- ����� NAME=".$s;
			$s = $s."<font color=\"fuchsia\">*</font>";
			echo " <B>������ ��</B> ".$s."<br>";
		}
		$name_table[$n]=$s;
		$name_table_prn[$n]=str_replace("���������������", "����������-�����",$s);
		$name_table_prn[$n]=str_replace("�����������������", "�����������-������",$name_table_prn[$n]);
		$name_table_prn[$n]=str_replace("�����������������", "����������-�������",$name_table_prn[$n]);
		$name_table_prn[$n]=str_replace("�����������������", "������������-�����",$name_table_prn[$n]);
//		$name_table[$n]=substr(trim($s[1]),0,-1);
    }
/*
    else
    if(eregi("^Power:",$a_file[$i]))//������ effects: item.var,spell.var
    {
		$s=explode(':',$a_file[$i-1]);
		$effects[$n][$e1]['num']=$s[1]+1-1;	//������ � ��������
		$s=explode(':',$a_file[$i]);
		$effects[$n][$e1]['power']=$s[1]+1-1;	//������ power, FlagEffect
		$s=explode(':',$a_file[$i+1]);
		$effects[$n][$e1]['area']=$s[1]+1-1;	//������ area, Duration, FlagEffect
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
			$karma_flag[$spell_txt_idx[$n]] = $s[1]+1-1;//� ������ � spell.txt, ���� ���� �������� ������� � �����
	}	
/*
    else
    if(eregi("^FlagEffect:",$a_file[$i]))//������ effects: spell.var
    {
		$effects[$n][$e1]['flag']=1;	//������������� ������ spell.var
		$s=explode(':',$a_file[$i-1]);
		$effects[$n][$e1]['num']=$s[1]+1-1;	//������ � ��������
//echo "$n $effects[$n][$e1]['flag'] $effects[$n][$e1]['num']";
		$s=explode(':',$a_file[$i]);
		$effects[$n][$e1]['power']=$s[1]+1-1;	//������ power, FlagEffect
		$s=explode(':',$a_file[$i+1]);
		$effects[$n][$e1]['area']=$s[1]+1-1;	//������ area, Duration, FlagEffect
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
			$build_table[$n] .= $build_name[-$s1]." (������� ������)";
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
    if(eregi("^Effects:",$a_file[$i]))//������ effects: spell.var
    {
		for($j=0;$j<16;$j++) //������ ��������
		{
			while(1)
				if(trim($a_file[$i+1]) == "") //������ ������
					$i++;
				else
					break;
			$i++;
			$s=explode(':',$a_file[$i]);
			$num = $effects[$n][$e1]['num'] = $s[1]+1-1;	//������ � ��������
			$i++;
			$s=explode(':',$a_file[$i]);
			$power = $effects[$n][$e1]['power'] = $s[1]+1-1;	//������ power, FlagEffect
			$i++;
			$s=explode(':',$a_file[$i]);
			$effects[$n][$e1]['area'] = $s[1]+1-1;	//������ area, Duration, FlagEffect
			if($num==70)//���
			{
				$effects[$n][$e1]['flag']=$power;	//������������� ������ spell.var
			}
			else
			if($num==71)//��������� �����
			{
				$effects[$n][$e1]['flag']=$power;	//������������� ������ spell.var
			}
			else
			if($num==72)//����� �����
			{
				$effects[$n][$e1]['flag']=$power;	//������������� ������ spell.var
			}
			else
			if($num==251)//������ ������� ������� �������� (��������� �� ����)
			{
				$effects[$n][$e1]['flag']=$power;	//������������� ������ spell.var
			}
			else
			if($num==298)//����������� 298 - ���������� ������������ ����� �������� ���������� ����� �������� �����������
			{
				$effects[$n][$e1]['flag']=$power;	//������������� ������ spell.var
			}
/*
		$effects[$n][$e1]['flag']=1;	//������������� ������ spell.var
		$i++;
		$s=explode(':',$a_file[$i]);
		$effects[$n][$e1]['num']=$s[1]+1-1;	//������ � ��������
//echo "$n $effects[$n][$e1]['flag'] $effects[$n][$e1]['num']";
		$s=explode(':',$a_file[$i]);
		$effects[$n][$e1]['power']=$s[1]+1-1;	//������ power, FlagEffect
		$s=explode(':',$a_file[$i+1]);
		$effects[$n][$e1]['area']=$s[1]+1-1;	//������ area, Duration, FlagEffect
//echo $n."-e1=".$e1." NUM=".$effects[$n][$e1]['num']." POWER=".$effects[$n][$e1]['power']." AREA=".$effects[$n][$e1]['area']." ".$effects[$n][$e1]['flag']."<br>";
*/
			$e1++;
			$i++; //������ ������
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
		$krome = 0;//����: ��������� �� ����, �����
		$p = "";
		$p2 = "";//��� ������������ ��������
		for($j=0;($s1[$j]!="") && ($j<10);$j++)
		{
//			$unit_kind[$n] .= (($s1[$j]+1-1)<0 ? "��������� ������ �� <font color=\"blue\"><B>".$unit_subtype[-$s1[$j]+1-1]."</B></font>" : $unit_subtype[$s1[$j]+1-1]).(($s1[$j+1]=="") ? "" : ";<br>");
			if(($s1[$j]+1-1)<0)
			{
				if($krome != 1)
				{
					$p .= "��������� ������ �� <font color=\"blue\"><B>".$unit_subtype[-$s1[$j]+1-1]."</B></font>";
					$p2 .= "��������� ������ �� ".$unit_subtype[-$s1[$j]+1-1];
				}
				else
				{
					$p .= " � <font color=\"blue\"><B>".$unit_subtype[-$s1[$j]+1-1]."</B></font>";
					$p2 .= " � ".$unit_subtype[-$s1[$j]+1-1];
				}
				$krome = 1;
				$kind = $s1[$j]+1-1;//����: �� ��������� �� �� ����, �-� UnitKind: (-14, 14)
			}
			else
			{
				if($krome == 1)//��� ���� �������
				{
					if($kind == (-$s1[$j]+1-1))
						$p = $p2 = "�� ��������� �� �� ����";
					else
					{
						$p .= ", ����� ".$unit_subtype[$s1[$j]+1-1];
						$p2 .= ", ����� ".$unit_subtype[$s1[$j]+1-1];
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
//����� ������ � ������
//echo "u1=".$u1." u2=".$u2." u3=".$u3."<br>";
//for($i=1;$i<$u1;$i++)echo $str_num[$i]."-".$u_table1[$i]." ";
//dumper($build_table,"build_table");
echo "<table border=1>";
/*
for($i=0;$i<$max+1;$i++)
{
//����� unitkind
	echo "<tr><td>$i ($name_table[$i])</td><td>".$unit_kind[$i]."</td></tr>";
}

for($i=0;$i<$max+1;$i++)
{
//����� AntiEffect
	echo "<tr><td>$i ($name_table[$i])</td><td>$antieffect[$i]</td></tr>";
}

for($i=0;$i<$max+1;$i++)
{
//����� ������ � ������
	echo "<tr><td>".$i." ($name_table[$i])</td><td>".substr($spell_unit[$i],0,strlen($spell_unit[$i])-2)."</td></tr>";
}
*/
for($i=0;$i<$max+1;$i++)
{
//����� ������� ��������
	if($target_table[$i]==0)
	{
		if($area_table[$i]==0)
		{
			if($radius_table[$i]==0)
				$spell_target[$i]="������ �� ����";
			else
			{
				if($on_ally_table[$i]==0)
				{
					$spell_target[$i]="��� ����� ������ ����������� � ������� <font color=\"blue\"><B>".$radius_table[$i]."</B></font> ";
					$spell_target2[$i]="������� ������ ($radius_table[$i])";
					if($radius_table[$i]==1)
						$spell_target[$i] .= "������";
					else
						$spell_target[$i] .= "������";
				}
				else
				{
					$spell_target[$i]="�� ���� � ������� ������ �������� <font color=\"blue\"><B>".$radius_table[$i]."</B></font> ";
					if($radius_table[$i]==1)
						$spell_target[$i] .= "������";
					else
						$spell_target[$i] .= "������";
				}
			}
		}
		else
		if($area_table[$i]==1)
			$spell_target[$i]="��� ����� �� ����";
		else
		{
			$spell_target[$i]="��� ����� �� ����";
			$spell_target2[$i]="���";
		}
	}
	else
	if($target_table[$i]==1)
	{
		$spell_target[$i]="��������� ����";
		$spell_target2[$i]="����";
	}
	else
	if($target_table[$i]==3)
	{
		$spell_target[$i]="������� �������� <font color=\"blue\"><B>".$radius_table[$i]."</B></font> ";
		$spell_target2[$i]="������� ($radius_table[$i])";
		if($radius_table[$i]==1)
			$spell_target[$i] .= "������";
		else
			$spell_target[$i] .= "������";
	}
	else
	if($target_table[$i]==4)
	{
		$spell_target[$i]="���� �� ����";
	}
	else
		$spell_target[$i]="���������";
}

//EFFECTS spell
for($i=0,$j=1;$i<$max+1;$i++)
{ 
//	echo "<tr><td>$i ($name_table[$i])</td><td>";
	for($n=1;($effects[$i][$j]['num']!="")&&($j<10000);$j++,$n++)
	{
	    if($spell_not_count[$i]!=1) $p .= $n.") ";
	    $num=$effects[$i][$j]['num'];
		if($num>3000)//����
		{
			$num -= 3000;
			$effects[$i][$j]['num'] = $num;
			$p .= "<B><font color=\"aqua\">����:</B></font> ";
		}
	    $power=$effects[$i][$j]['power'];
	    $area=$effects[$i][$j]['area'];
//echo "$i $num $power $area $abil_name[$num] flag=".$effects[$i][$j]['flag']." target=".$target_table[$i]."<br>";
	    if(isset($effects[$i][$j]['flag']))//������������� ������ spell.var � FlagEffect
	    {
			$spell_not_count[$i]=1;
			$flag=$effects[$i][$j]['flag'];
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
			else
//			if($num==148)//�������� �������� �� ���� � �����������, ���� ���� ����������� 298 - ���������� ������������ ����� �������� ���������� ����� �������� �����������
			if($num==298)//�������� �������� �� ���� � �����������, ���� ���� ����������� 298 - ���������� ������������ ����� �������� ���������� ����� �������� �����������
			{
				$p .= "����� �������� <B><font color=\"red\">".-$power."</font></B> (� ��������� <B><font color=\"green\">".$flag."</B></font> ������";
				if($flag == 1)
					$p .= "�";
				else
					$p .= "��";
				$p .= " �� ���� � �����������)".($effects[$i][$j+1]['num']!="" ? "<br>" : "");
				$flag_298[$i] = 1;//���������� ����-��������, ���� ����� ������ �148 ��� �298
			}
			else
			if($num==251) //������ ������� ������� �������� (��������� �� ����)
			{
//				$p .= "��������� �� <B>".($power+1)."</B> ������ ��� ����������� ������;<br>";
				$p .= "������ <B>".($power+1)."</B> ������� <font color=\"brown\"><B>".$u_name[$effects[$i][$j+1]['num']-1000]."</B></font> �� �������� � ����� �����";
				$j++;$n++;//���������� ��������� ������ (��� �� ���� ������ ���� ������ ���������� �������)
			}
	    }
	    else
	    if($num>1000)
		{
			if($area<=0)
			{
				if(($target_table[$i]==4) || ($target_table[$i]==0 && $area_table[$i]==1)) //����
					$p .= "�������� �������� <font color=\"brown\"><B>".$u_name[$num-1000]."</B></font>";
				else
					$p .= "������ �������� <font color=\"brown\"><B>".$u_name[$num-1000]."</B></font>";
			}
			else
				$p .= "����������� � �������� <font color=\"brown\"><B>".$u_name[$num-1000]."</B></font>, ������������ <font color=\"blue\"><B>".$area."</B></font>";
			$p .= ($power>0 ? " (���� <font color=\"fuchsia\"><B>$power</B></font>)" : "").($effects[$i][$j+1]['num']!="" ? "<br>" : "");
		}
/*		else
		if($num>3000)//����
		{
			$p .= "<B><font color=\"aqua\">����:</B> "
		}
			if($qua <= 0)
						$up_abil[$n] .= "������ ������ <B><font color=\"fuchsia\">".$abil_name[$num-3000]."</font></B>; ";
					else
					{
						$up_abil[$n] .= "<B><font color=\"aqua\">����:</B> ".$abil_name[$num-3000];
						if($abil_numeric[$num-3000]==0)
							$up_abil[$n] .= "</font>; ";
						else
							$up_abil[$n] .= "</font><B> ".($qua<0 ? "<font color=\"red\">$qua" : "<font color=\"green\">+$qua").($abil_percent[$num]==1 ? "%" : "")."</font></B>; ";
					}
				}
*/	    else
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
			$p .= ($area<=0 ? "" : ", ������������ <font color=\"blue\"><B>$area</B></font>").($effects[$i][$j+1]['num']!="" ? "<br>" : "");		
		}
	    else
	    if($num==10) //����� ��������
		{
			if(($negative_table[$i]==1) && (in_array($num,$abil_negative)))
			{
				if($on_ally_table[$i]!=0 && $on_enemy_table[$i]==0)//����� - �������������, ���� Negative==1 � $power<0
					$p .= $abil_name[$num].($power<0 ? " <font color=\"green\"><B>+".abs($power)."</B></font>" : " <font color=\"red\"><B>-$power</B></font>").($effects[$i][$j+1]['num']!="" ? "<br>" : "");			
				else
					$p .= $abil_name[$num].($power<0 ? " <font color=\"red\"><B>$power</B></font>" : " <font color=\"red\"><B>-$power</B></font> (� ����������� ������)").($effects[$i][$j+1]['num']!="" ? "<br>" : "");
			}
			else
				$p .= $abil_name[$num].($power<0 ? " <font color=\"red\"><B>$power</B></font>" : " <font color=\"green\"><B>+$power</B></font>").($effects[$i][$j+1]['num']!="" ? "<br>" : "");
		}
/*
	    else
	    if($num==20) //�������������� �������
		{
			$p .= $abil_name[$num]." (<font color=\"green\"><B>������ ������� ".($power>=0 ? "</font><font color=\"blue\">$power" : "�������� �� </font><font color=\"blue\">".abs($power))."</B></font>)".($effects[$i][$j+1]['num']!="" ? "<br>" : "");
			$p .= ($area<=0 ? "" : ", ������������ <font color=\"blue\"><B>$area</B></font>").($effects[$i][$j+1]['num']!="" ? "<br>" : "");		
	    }
*/
	    else
	    if($num==47) //�������
			$p .= $abil_name[$num].", ������������ <font color=\"blue\"><B>".$area."</B></font>".($effects[$i][$j+1]['num']!="" ? "<br>" : "");
		else
	    if($num==73) //MindControl
		{
			if($area == -1)
				$p .= $abil_name[$num].", ������������� ���� �� ���� <font color=\"green\"><B>".$power;
			else
				$p .= $abil_name[$num].", ������������ <font color=\"blue\"><B>".$area;
			$p .= "</B></font>".($effects[$i][$j+1]['num']!="" ? "<br>" : "");
		}
	    else
	    if($num==74) //Reincarnation
			$p .= $abil_name[$num].", ������������ <font color=\"blue\"><B>".$area."</B></font>".($effects[$i][$j+1]['num']!="" ? "<br>" : "");
	    else
	    if($num==91) //Ҹ���� ����
			$p .= $abil_name[$num].", ������������ <font color=\"blue\"><B>".$area."</B></font>".($effects[$i][$j+1]['num']!="" ? "<br>" : "");
	    else
	    if($num==92) //������
			$p .= $abil_name[$num].", ���� <font color=\"green\"><B>".$power."</B></font>".($effects[$i][$j+1]['num']!="" ? "<br>" : "");
		else
		if($num==115)//����������� ���������� ����������� �� �����, ��������� ��� �������
		{
			$p .= "��������� �������� <B><font color=\"blue\">".$name_table[$power]."</font></B> ����������� �� �����, ��������� ��� �������";
			$p .= ", ������������ <font color=\"blue\"><B>".$area."</B></font>".($effects[$i][$j+1]['num']!="" ? "<br>" : "");
		}
		else
		if($num==145)//������ ����� ��� ����������
			$p .= "���� �� ����� <B><font color=\"red\">".$power."</font></B>, ������������ <font color=\"blue\"><B>".$area."</B></font>".($effects[$i][$j+1]['num']!="" ? "<br>" : "");
		else
		if($num==148)//�������� �������� �� ���� � �����������, ���� ���� ����������� 298 - ���������� ������������ ����� �������� ���������� ����� �������� �����������
		{
			if($flag_298[$i] != 1)//������ ������ 148, ��� 298
			{
				$p .= "����� �������� (� ��������� ����� ������������ ����������) <B><font color=\"red\">".-$power."</font></B>".($effects[$i][$j+1]['num']!="" ? "<br>" : "");
			}
		}
		else
		if($num==164)//���� ����������� �����
			$p .= "���� ����������� ����� <B><font color=\"red\">".$power."</font></B>".($effects[$i][$j+1]['num']!="" ? "<br>" : "");
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
			$p .= " ������ ���, ������������ <font color=\"blue\"><B>".$area."</B></font>".($effects[$i][$j+1]['num']!="" ? "<br>" : "");
	    }
	    else
	    if($num==200) //��������� ���������� �������
			$p .= "���������� ���������� �������".($effects[$i][$j+1]['num']!="" ? "</B><br>" : "</B>");
		else
		if($num==212)//������ ����������� ��������� �������������
		{
			$p .= "��������� ������������� �� ".($power<0 ? " <font color=\"red\"><B>$power%</B></font>" : " <font color=\"green\"><B>+$power%</B></font>");
			$p .= ", ������������ <font color=\"blue\"><B>".$area."</B></font>".($effects[$i][$j+1]['num']!="" ? "<br>" : "");
		}
		else
	    if($num==213) //dispell
			$p .= $abil_name[$num].", ���� <font color=\"green\"><B>".$power."</B></font>".($effects[$i][$j+1]['num']!="" ? "<br>" : "");
		else
		if($num==220)//���������� �� ���� ����� ������� ��������� ��� ������ (��������� ������).
		{
			$p .= "���������� �������� <B><font color=\"blue\">".$name_table[$power]."</font></B> �� ���� ����� ������� ��������� ��� ������ ����";
			$p .= ", ������������ <font color=\"blue\"><B>".$area."</B></font>".($effects[$i][$j+1]['num']!="" ? "<br>" : "");
		}
		else
	    if($num==230) //230. ������ ����������� �� ������ (������������ � Spell.var)
			$p .= "���� ������ <B><font color=\"red\">".$power."</font></B>, ������������ <font color=\"blue\"><B>���� ���</B></font>".($effects[$i][$j+1]['num']!="" ? "<br>" : "");
	    else
	    if($num==234) //����������� �� �������� - ������ ��� ������� � ��-������������� ������
		{
			if($negative_table[$i]==0)
			{
				if($area<=0)
					$p .= ($power>0 ? "������� <font color=\"green\">" : "���� <font color=\"red\">");
				else
					$p .= ($power>0 ? "����������� <font color=\"green\">" : "���� <font color=\"red\">");
				$p .= "<B>".abs($power)."</B></font>";
			}
			else
				$p .= "���� <font color=\"red\"><B>".abs($power)."</B></font>";
			$p .= " (��� ������� � ��-������������� ������)";
			$p .= ($area<=0 ? "" : ", ������������ <font color=\"blue\"><B>$area</B></font>").($effects[$i][$j+1]['num']!="" ? "<br>" : "");		
		}
	    else
	    if($num==235) //����������� �� ������������ - ������ ��� ������� � ��-������������� ������
		{
			if($negative_table[$i]==0)
			{
				$p .= "������������ ".($power>0 ? "<font color=\"green\">+" : "<font color=\"red\">");
				$p .= "<B>".$power."</B></font>";
			}
			else
				$p .= "������������ <font color=\"red\"><B>".-$power."</B></font>";
			$p .= " (��� ������� � ��-������������� ������)";
			$p .= ($area<=0 ? "" : ", ������������ <font color=\"blue\"><B>$area</B></font>").($effects[$i][$j+1]['num']!="" ? "<br>" : "");		
		}
	    else
	    if($num==236) //����������� �� ������ ��� - ������ ��� ������� � ��-������������� ������
		{
			if($negative_table[$i]==0)
			{
				$p .= "������ ��� ".($power>0 ? "<font color=\"green\">+" : "<font color=\"red\">");
				$p .= "<B>".$power."</B></font>";
			}
			else
				$p .= "������ ��� <font color=\"red\"><B>".-$power."</B></font>";
			$p .= " (��� ������� � ��-������������� ������)";
			$p .= ($area<=0 ? "" : ", ������������ <font color=\"blue\"><B>$area</B></font>").($effects[$i][$j+1]['num']!="" ? "<br>" : "");		
		}
	    else
	    if($num==237) //����������� �� �������� - ������ ��� ������� � ��-������������� ������
		{
			if($negative_table[$i]==0)
			{
				if($area<=0)
					$p .= ($power>0 ? "������� <font color=\"green\">" : "���� <font color=\"red\">");
				else
					$p .= ($power>0 ? "����������� <font color=\"green\">" : "���� <font color=\"red\">");
				$p .= "<B>".abs($power)."</B></font>";
			}
			else
				$p .= "���� <font color=\"red\"><B>".abs($power)."</B></font>";
			$p .= " (��� ������� � ��-������������� ������)";
			$p .= ($area<=0 ? "" : ", ������������ <font color=\"blue\"><B>$area</B></font>").($effects[$i][$j+1]['num']!="" ? "<br>" : "");		
		}
	    else
	    if($num==238) //����������� �� ������������ - ������ ��� ������� � ��-������������� ������
		{
			if($negative_table[$i]==0)
			{
				$p .= "������������ ".($power>0 ? "<font color=\"green\">+" : "<font color=\"red\">");
				$p .= "<B>".$power."</B></font>";
			}
			else
				$p .= "������������ <font color=\"red\"><B>".-$power."</B></font>";
			$p .= " (��� ������� � ��-������������� ������)";
			$p .= ($area<=0 ? "" : ", ������������ <font color=\"blue\"><B>$area</B></font>").($effects[$i][$j+1]['num']!="" ? "<br>" : "");		
		}
	    else
	    if($num==239) //����������� �� ������ ��� - ������ ��� ������� � ��-������������� ������
		{
			if($negative_table[$i]==0)
			{
				$p .= "������ ��� ".($power>0 ? "<font color=\"green\">+" : "<font color=\"red\">");
				$p .= "<B>".$power."</B></font>";
			}
			else
				$p .= "������ ��� <font color=\"red\"><B>".-$power."</B></font>";
			$p .= " (��� ������� � ��-������������� ������)";
			$p .= ($area<=0 ? "" : ", ������������ <font color=\"blue\"><B>$area</B></font>").($effects[$i][$j+1]['num']!="" ? "<br>" : "");		
		}
	    else
	    if($num==285) //���� �����
		{
			$p .= "���� ����� (���� <font color=\"green\"><B>".$power."</B></font>)";
			$p .= ($area<=0 ? "" : ", ������������ <font color=\"blue\"><B>$area</B></font>").($effects[$i][$j+1]['num']!="" ? "<br>" : "");		
		}
	    else
	    if($num==297) //��������� ���������� �������
			$p .= "��������� �������������� ��������, ������������ ��� ������� ����".($effects[$i][$j+1]['num']!="" ? "</B><br>" : "</B>");
//$abil_name[297]="������������ ��� ���������� �������� ����� ���� ��������, ������������ � ������� ���� � ������ ���� �����";
	    else
		if(in_array($num,$abil_stamina))
		{
			$p .= $abil_name[$num]." (������� ������������ <font color=\"red\"><B>".$power."</B></font>)";
			$p .= ($area<=0 ? "" : ", ������������ <font color=\"blue\"><B>".$area."</B></font>").($effects[$i][$j+1]['num']!="" ? "<br>" : "");
	    }
		else
		if(in_array($num,$abil_xod))
		{
			$p .= $abil_name[$num]." (��������� <font color=\"fuchsia\"><B>$power</font></B> ���";
			if($power>1 && $power<5)
				$p .= "�";
			else
			if($power>4)
				$p .= "��";
			$p .= ($area<=0 ? ")" : "), ������������ <font color=\"blue\"><B>".$area."</B></font>").($effects[$i][$j+1]['num']!="" ? "<br>" : "");
		}
		else
		if($abil_name[$num]=="")
			$p .= "!!!����������� ������ $num".($effects[$i][$j+1]['num']!="" ? "<br>" : "");
		else
	    if($abil_numeric[$num]==0) //���������������� ������
		{
			if($power<0)
				$p .= "������ ������ <font color=\"aqua\"><B>";
			$p .= $abil_name[$num];
			if($power<0)
				$p .= "</font></B>";
			$p .= ($area<=0 ? "" : ", ������������ <font color=\"blue\"><B>".$area."</B></font>").($effects[$i][$j+1]['num']!="" ? "<br>" : "");
	    }
		else
//		if($negative_table[$i]==0)
//		if($spell_not_do[$i]!=1)
//		if(($negative_table[$i]==1) && ($on_ally_table[$i]==0) && ($on_enemy_table[$i]==1))
		if(($negative_table[$i]==1) && (in_array($num,$abil_negative)))
		{
			if($on_ally_table[$i]!=0 && $on_enemy_table[$i]==0)//����� - �������������, ���� Negative==1 � $power<0
				$p .= $abil_name[$num].($power<0 ? " <font color=\"green\"><B>+".abs($power)."</B></font>" : " <font color=\"red\"><B>-$power</B></font>").($abil_percent[$num]==1 ? "%" : "").($area<=0 ? "" : ", ������������ <font color=\"blue\"><B>".$area."</B></font>").($effects[$i][$j+1]['num']!="" ? "<br>" : "");			
			else
				$p .= $abil_name[$num].($power<0 ? " <font color=\"red\"><B>$power</B></font>" : " <font color=\"red\"><B>-$power</B></font>").($abil_percent[$num]==1 ? "%" : "").($area<=0 ? "" : ", ������������ <font color=\"blue\"><B>".$area."</B></font>").($effects[$i][$j+1]['num']!="" ? "<br>" : "");
		}
		else
			$p .= $abil_name[$num].($power<0 ? " <font color=\"red\"><B>$power</B></font>" : " <font color=\"green\"><B>+$power</B></font>").($abil_percent[$num]==1 ? "%" : "").($area<=0 ? "" : ", ������������ <font color=\"blue\"><B>".$area."</B></font>").($effects[$i][$j+1]['num']!="" ? "<br>" : "");
//		$spell_not_do[$i]=0;
//		else
//			echo $abil_name[$num].($power<0 ? " <font color=\"red\"><B>$power</B></font>" : " <font color=\"red\"><B>-$power</B></font>").($area==-1 ? "" : ", ������������ <B>$area</B>").($effects[$i][$j+1]['num']!="" ? "<br>" : "");

/*
		{
			if($power<0)
				echo "<font color=\"red\">".$abil_name[$num]." <B>$power</B></font>";
			else
				echo "<font color=\"green\">".$abil_name[$num]." <B>+$power</B></font>";
			echo ($area==-1 ? "" : ", <font color=\"maroon\">������������ <B>$area</B></font>").($effects[$i][$j+1]['num']!="" ? "<br>" : "");
		}
	    else
		if($negative_table[$i]!=0)
		{
			if($power<0)
				echo "<font color=\"red\">".$abil_name[$num]." <B>$power</B></font>";
			else
				echo "<font color=\"red\">".$abil_name[$num]." <B>-$power</B></font>";
			echo ($area==-1 ? "" : ", <font color=\"maroon\">������������ <B>$area</B></font>").($effects[$i][$j+1]['num']!="" ? "<br>" : "");
		}
*/
	}
	$spell_abil_prn[$i]=$p;
	$p="";
//	echo "</td></tr>";
}

//�������� �� �������������� ����������
//���� ������������ ������� "��� ����� ���������"
$used = array(186,350);
//�����������,����� ����
for($i=1;$i<$max+1;$i++)
{
	if($level_table[$i]>4 || $itemlevel_table[$i]>6)
		if(!isset($spell_unit[$i]) && !isset($build_table[$i]) && !in_array($i,$used))
			echo "!!!$i ($name_table[$i]) - �������������� ����������<br>";
	if(isset($spell_add[$i]) || isset($spell_unit[$i]))
	{
//		$p="";
		$n=1;
		if(isset($spell_unit[$i]))
		{
			$p .= substr(($n++.") �����: $spell_unit[$i]"),0,-2);
		}
		for($k=0;$k<count($spell_add[$i]);$k++)
		{
			$p .= "<br>".$n++.") ".$spell_add[$i][$k];
		}
	}
	$spell_get[$i]=$p;
	$p="";
}

//����� ������ �������
for($i=1;$i<$max+1;$i++)
{
	echo "<tr><td align=center>$i</td><td>$name_table_prn[$i]</td><td></td><td>$spell_txt[$i]</td><td>";
	echo "$spell_abil_prn[$i]</td><td>".$spell_get[$i]."</td><td align=center>$level_table[$i]</td><td align=center>";
	echo "$itemlevel_table[$i]</td><td align=center>$cost_table[$i]</td><td align=center>$stamcost_table[$i]</td><td align=center>";
	echo "<font color=\"red\">$lifecost_table[$i]</font></td><td align=center>$spell_target[$i]</td><td>$unit_kind[$i]</td><td>$antieffect[$i]</td><td align=center>";
	echo "$build_table[$i]</td><td><B><font color=\"red\">K</font></B></td><td align=center>";
	echo "$powermod_table[$i]</td><td align=center>$durationmod_table[$i]</td><td align=center>";
	echo "$resistpower_table[$i]</td><td align=center>$resistduration_table[$i]</td><td align=center>$defencepower_table[$i]</td><td align=center>";
	echo ($negative_table[$i]==0 ? "���" : "��")."</td><td align=center>";
	echo ($on_enemy_table[$i]==0 ? "���" : "��")."</td><td align=center>";
	echo ($on_ally_table[$i]==0 ? "���" : "��")."</td><td align=center>";
	echo ($sacrifice_table[$i]==0 ? "���" : "��")."</td><td align=center>";
	echo ($restoreonly_table[$i]==0 ? "���" : "��")."</td><td align=center>";
	echo ($cumulative_table[$i]==0 ? "���" : "��")."</td><td align=center>";
	echo ($unloot_table[$i]==0 ? "���" : "��")."</td></tr>";
//	echo "</td></tr>";
}

echo "</table><br>";

$f=fopen("Spell_eadoropedia.txt","w") or die("������ ��� �������� ����� Spell_eadoropedia.txt.txt");
foreach($spell_eadoropedia as $idx => $sp)
{
	fwrite($f,"						 <tr>\n");
	fwrite($f,"						   <td width=\"150\"><div><a href=\"spells.html#".$sp."\">".$name_table[$sp]."</a></div></td>\n");
	fwrite($f,"						   <td width=\"30\"><div>".$level_table[$sp]."</div></td>\n");
	fwrite($f,"						   <td width=\"80\"><div>".($powermod_table[$sp]/100)."</div></td>\n");
	fwrite($f,"						   <td width=\"90\"><div>".($defencepower_table[$sp] != 0 ? ($defencepower_table[$sp]/100)." (������)" : $resistpower_table[$sp]/100)."</div></td>\n");
	fwrite($f,"						   <td width=\"120\"><div>".$spell_damage[$idx]."</div></td>\n");
	fwrite($f,"						   <td width=\"90\"><div>".$spell_target2[$sp]."</div></td>\n");
	fwrite($f,"						 </tr>\n");
}
fclose($f);

//����� �������� � �����
$f=fopen("Spell_spoil.txt","w") or die("������ ��� �������� ����� Spell_spoil.txt");
for($i = 0; $i < $count_spell; $i++)
{
	if($karma_flag[$i] != 0)
		fwrite($f,trim($spell_file[$i])." [�����: ".($karma_flag[$i] > 0 ? "+" : "").$karma_flag[$i]."]\n");
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
			fwrite($f,"[�����: ".substr($spell_unit2[$idx],0,-2)."]\n");
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
				fwrite($f,"[�����: ".substr($spell_unit2[$idx],0,-2)."]\n");
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
//����� ������������ �����
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

<br><a href='index.html'>��������� � ������ ������</a>
</html>