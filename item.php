<html>
<meta http-equiv="Content-Type" content="text/html charset=windows-1251">
<style>
br		{mso-data-placement:same-cell;}
td		{vertical-align:middle;}
.top	{border-top:1.0pt solid black;}
.bottom	{border-bottom:1.0pt solid black;}
.left	{border-left:1.0pt solid black;}
.right	{border-right:1.0pt solid black;}
.gray	{background:gray;}
.bottom_gray	{border-bottom:1.0pt solid black;background:gray;}
.font9	{font-size:9.0pt;}
</style>
<?php
require_once "dumper.php";
$a_file = file("item.var");
$count_f = count($a_file);
$item_set_file = file("item_set.var");
$count_item_set = count($item_set_file);
$item_txt_file = file("item.txt");
$count_item_txt = count($item_txt_file);
$b_file = file("inner_build.var");
$count_b = count($b_file);
$abil_file = file("ability_num.var");
$count_abil = count($abil_file);
$u_file = file("unit.var");
$count_u = count($u_file);
$s_file = file("spell.var");
$count_s = count($s_file);
$item_event_file = file("item_event.exp");
$item_enc_file = file("item_enc.exp");

$hero_up = array_merge(range(40,43),range(238,253),range(263,278));//��� �����

$abil_xod = array(45,52,69,127,128,134,135,137);//������, ������� ����� ��������� �����
//����������� �����,����������� ������,������ �������,��������� ����,��������� �������,����������� ����,���������� �������,�������� �������

$abil_stamina = array(20,59,66,78,79);//������, ������� ������ ������������
//�������������� �������,����������� ����,�������� �����,����������� �������,������ �������

$res_name=array(1=>"������", "������� ������", "����", "����������", "�������", "������", "������", "������", "׸���� �����");
$item_slot=array("���������","������ ����","����� ����","����","������","����","����","�����","����� ���","��������","��������","������","��������� �������");
$item_type=array("�������","�������� ������","������ ������","���������� ������","����","�����","˸���� �����","������� �����","������ �����","���","������ � ���������","������� �� �������","����� ���������","������ � ��������");

//�������� ������������� ����� (���, �� �������� ��� �������� ����������, ������ � "������� ������")
$tab_name=array("������� ������","�������� ������ (����� ����)","�������� ������","������ ������","���","������","����","�����","�����",
"���","������� �������� ����","˸���� ����","������� ����","������ ����","��������","������� �����",
"˸���� �����","������� �����","������ �����","����","������� ��������","˸���� ��������",
"������� ��������","������ ��������","������� �������","˸���� �����","������� �����","������ �����",
"������","����","������� �����","˸���� �����","������� �����","������ �����","�������� ������","������ ����������");
foreach($tab_name as $i) echo $q++."=$i, ";echo "<br>";
//�� ������� ������������� ����� ��������� � ������ ����� ������� �� �����
$tab_num=array(1,1,1,1,2,2,3,3,4,5,6,6,6,6,7,8,8,8,8,9,10,10,10,10,11,11,11,11,12,13,14,14,14,14,15,15,16,17);

//���� "slot,class", �� ������� ������ ����������� �� �������
// -1 - ����� ���� (������� ������ �����)
$item_sort=array(
"1,0","2,1","1,1","1,2",//������
"1,3","2,3",//���-������
"1,4","2,4",//����-�����
//"1,5",//�����
//"2,9",//���
"-1,5",//�����
"-1,9",//���
"4,0","4,6","4,7","4,8",//����
"9,0",//��������
"3,0","3,6","3,7","3,8",//�����
"6,0",//����
"8,0","8,6","8,7","8,8",//��������
"10,0","10,6","10,7","10,8",//��������
"11,0",//������
"5,0",//����
"7,0","7,6","7,7","7,8",//�����
"0,0","0,10");//���������
//echo count($tab_num),count($item_sort);
$item_cloth=array(1=>"4,0","3,0","6,0","8,0","10,0","5,0","7,0");//������
//$item_jewel=array(9,10,11);//���������

$max=0;$max1=0;$max_u=0;$max_e=0;$t[0]=0;$j=0;
$u1=-1;$u2=0;$u3=0;	//� ������ ����� � xls
$g1=0; //���-�� ������� � ����� �����
$a1=0; //� ������
$a2=0; //� ������� ritual
$e1=0; //� �������
$up1=0; //����� upg_type � unit_upg
$u_a=0; //������ in unit.var

//������ item.txt
for($i = 0; $i < $count_item_txt; $i++)
{  
    if(eregi("^([0-9]{1,})",$item_txt_file[$i],$k))
    {
		$n=$k[1];
		if($n>$max)$max=$n;
    }
    else
	{
		if(substr($item_txt_file[$i],0,1)=="#")
		{
			$item_txt[$n] .= ((substr(trim($item_txt_file[$i]),-1,1)=="#") ? substr(trim($item_txt_file[$i]),1,-1) : substr($item_txt_file[$i],1)."<br>");
		}
		else
		if(trim($item_txt_file[$i])!="")
		{
			if(substr(trim($item_txt_file[$i]),-1,1)=="#")
			{
				$item_txt[$n] .= substr(trim($item_txt_file[$i]),0,-1);
				$i++;
			}
			else
				$item_txt[$n] .= $item_txt_file[$i]."<br>";
		}
	}
//echo $n."-".$item_txt[$n]."<br>";
}
//dumper($item_txt,"item_txt");
//echo $item_txt[576]." ".strlen($item_txt[576])."<br>";

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
//$abil_numeric[23]=1;//���� ��������
$abil_numeric[187]=0;//������ ������

//������ spell.var
for($i = 0,$n=0; $i < $count_s; $i++)
{  
   if(eregi("^/([0-9]{1,})",$s_file[$i],$k))
    {
		$n=$k[1];
    }
    else
    if(eregi("^name",$s_file[$i]))
    {
		$s=explode(':',$s_file[$i]);
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
		if(in_array($n,$hero_up))//��� �����
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
    if(eregi("^Lvl ([0-9]{1,}) loot",$u_file[$i])) //Lvl 01 loot: (3, 4; 4, 4; 13, 4) ... Lvl 20
    {
		for($j=1;$j<=20;$j++)
		{
			$s=explode('loot:',$u_file[$i]);	// Lvl 01 loot: (3, 4; 4, 4; 13, 4)
			$s1=explode(';',$s[1]);		// (3, 4; 4, 4; 13, 4)
			for($jj=0;$jj<9;$jj++)
			{
				$s2=explode(',',$s1[$jj]);	// (3, 4
				$s2[0]=trim($s2[0]);
				$s2_1=$s2[1]+1-1;//4
				if(substr($s2[0],0,1)=="(") 
				{
					$s2[0]=substr($s2[0],1);
				}
				$s2_0=$s2[0]+1-1;//3
				if(($s2_1) > 0) //������������� ��� (����� ������������ � ��������� �� ������)
				{
					if($s2_0 != 0)	// 3
					{
						if(!in_array($n,$item_get2[$s2_0]))
							$item_get2[$s2_0][] = $n; //��������� �������� �� ���� �� �������� ������
					}
				}
			}
			$i++;
		}
		$u_loot_prn[$n]=substr($u_loot_prn[$n],0,-2);
	}
}
//dumper($item_get2,"item_get2");

//������ item_set.var
for($i = 0,$n=0; $i < $count_item_set; $i++)
{  //echo "<br>".$a_file[$i];
	if(eregi("^/([0-9]{1,})",$item_set_file[$i],$k))
	{
		$n=$k[1];
 		if($n>$max1)$max1=$n;
	}
    else
    if(eregi("^name",$item_set_file[$i]))
    {
		$s=explode(':',$item_set_file[$i]);
		$item_set_name[$n]=substr(trim($s[1]),0,-1);
		$i++;
		$s=explode(':',$item_set_file[$i]);
		$item_set_num[$n]=$s[1]+1-1;
		$i++;
		$s=explode(':',$item_set_file[$i]);
		$s1=explode(',',$s[1]);
		if($item_set_num[$n] != count($s1))
		{
			echo "!!!$n - ItemsNum=$item_set_num[$n] Items=".count($s1)."<br>";
		}
//		echo "$n - ".count($s1)."<br>";
		for($j=0;$j<$item_set_num[$n];$j++)
		{
			$item_set_items[$n][$j]=$s1[$j]+1-1;
			$item_set_items_name[$s1[$j]+1-1]=$item_set_name[$n];
//echo 	$item_name[$item_set_items[$n][$j]].", ";
		}
//echo "<br>";
		$i++;
		$s=explode(':',$item_set_file[$i]);
		$item_set_bonus[$n]=$s[1]+1-1;
		if($item_set_bonus[$n] > $item_set_num[$n])
			echo "!!!$n - bonus ($item_set_bonus[$n]) > ItemsNum ($item_set_num[$n])<br>";
	}
    else
    if(eregi("^Items:",$item_set_file[$i]))
    {
//echo " <font color=\"fuchsia\"><B>$n</B></font> ";
		$s=explode(':',$item_set_file[$i]);
		$item=$s[1]+1-1;
		$bonus_compare[$n]++;//��� �������� �� ������������ ���������� ������� � item_set_bonus
//		echo "$n - Items: ($item)<br>";
//		echo "$n - bonus_compare: ($bonus_compare[$n])<br>";
		if($item > $item_set_num[$n])
			echo "!!!$n - Items: ($item) > ItemsNum ($item_set_num[$n])<br>";
		for($j=0;$j<8;$j++)
		{
			$set_abil[$n] .= "<font color=\"blue\"><B>(".$item.")</B></font> ";
			$i++;
			$s=explode(':',$item_set_file[$i]);
			$num=$s[1]+1-1;
			$i++;
			$s=explode(':',$item_set_file[$i]);
			$power=$s[1]+1-1;
			$i++;
			$s=explode(':',$item_set_file[$i]);
			$area=$s[1]+1-1;
			$i++; //������ ������
			if($num==83) //����
				$set_abil[$n] .= $abil_name[$num]." <B><font color=\"blue\">".$spell_name[$power]."</font></B><br>";
			else
			if($num==84) //������
				$set_abil[$n] .= $abil_name[$num]." <B><font color=\"brown\">".$u_name[$power]."</font></B><br>";
			else
			if($num == 997)//���������� ����� �������
			{
				$set_abil[$n] .= "���������� ����� �������: ������ �� <font color=\"green\"><B>".$power."%</B></font>";
				$set_abil[$n] .= ", ���������� �� <font color=\"green\"><B>".($power/2)."%</B></font><br>";
			}
			else
			{
				if($abil_numeric[$num]==0)
					$set_abil[$n] .= $abil_name[$num];
				else
				if($num==983)//�������� ���� ��������
					$set_abil[$n] .= $abil_name[$num]." <font color=\"green\"><B>�� ".$power."%</B></font>";
				else
				if($num==984)//������ �������� (������ ��� �����)
					$set_abil[$n] .= $abil_name[$num]." (��������� ������� <= <font color=\"green\"><B>".$power."</B></font>)";
				else
				if($num==20)//�������������� �������
					$set_abil[$n] .= $abil_name[$num]." (<font color=\"green\"><B>������ ������� ".($power>=0 ? "</font><font color=\"blue\">$power" : "�������� �� </font><font color=\"blue\">".abs($power))."</B></font>)";
				else
				if($abil_name[$num]=="")
					$set_abil[$n] .= "!!!����������� ������ $num<br>";
				else
					$set_abil[$n] .= $abil_name[$num].($power<0 ? " <B><font color=\"red\">$power" : " <B><font color=\"green\">+$power").($abil_percent[$num]==1 ? "%" : "")."</font></B>";
				$set_abil[$n] .= ($area==1 ? " <font color=\"aqua\">(�����)</font>" : "")."<br>";
			}
			if(substr(trim($s[1]),-1)==";") break; // for j, items
		}
//echo		$set_abil[$n]=substr($p,0,-4);
	//	$p="";
	}
}
for($i=1;$i<$max1+1;$i++)//��� �������� �� ������������ ���������� ������� � item_set_bonus
{
	if($item_set_bonus[$i] != $bonus_compare[$i])
		echo "!!!$i - bonus ($item_set_bonus[$i]) != bonus_compare ($bonus_compare[$i])<br>";
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
		$s=substr(trim($s[1]),0,-1);
		while(in_array($s,$name_table))
		{
			echo $n."- ����� NAME=".$s;
			$s .= "*";
			echo " <B>������ ��</B> ".$s."<br>";
		}
		$name_table[$n]=$s;
    }
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
	else
    if(eregi("^Slot:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		if($s[1]==100)$s[1]="12";//���������
		$slot_table[$n]=$s[1]+1-1;
		if($slot_table[$n]==9)//��������
			$tab_jewel[0][]=$n;
		else
		if($slot_table[$n]==10)//��������
			$tab_jewel[1][]=$n;
		else
		if($slot_table[$n]==11)//������
			$tab_jewel[2][]=$n;
//echo $n."-".$slot_table[$n]."<br>";
    }
    else
    if(eregi("^Class:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$class_table[$n]=$s[1]+1-1;
		if($class_table[$n] == 5)//�����
			$str = "-1,5";
		else
		if($class_table[$n] == 9)//���
			$str = "-1,9";
		else
			$str=($slot_table[$n]==12 ? 1 : $slot_table[$n]).",".$class_table[$n];
		$sort=array_keys($item_sort,$str);
		if($sort[0] == 1) $sort[0] = 2;//����������� "�������� ������ (����� ����)" � "�������� ������"
//		echo $n;dumper($sort);
		if(($n+1-1)!=0)$tab_item[$sort[0]+1-1][]=$n;//� ����� ���� ��������� ������ ��������
		$sort=array_keys($item_cloth,$str);
		if(($sort[0]) != "")
		{
			$tab_cloth[$sort[0]+1-1][]=$n;//������
//			echo $n."(".$name_table[$n].") - ����=".$str."<br>";
		}
//echo $n." - SORT=".$str."<br>";
//echo $n."-".$class_table[$n]."<br>";
    }
    else
    if(eregi("^GoldCost:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$gold_table[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^GemCost:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$gem_table[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^Durability:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$dur_table[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^ShopLevel:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$shop_table[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^Rarity:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$rarity_table[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^Pic:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		$pic_table[$n]=$s[1]+1-1;
    }
    else
    if(eregi("^Building:",$a_file[$i]))
    {
		$s=explode(':',$a_file[$i]);
		if(($s[1]+1-1) != 0)//��� ����� ���������
			$item_get[$n][] = "��������� � ����� <B><font color=\"blue\">".$build_name[$s[1]+1-1]."</font></B>";
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

//������ item_event.exp
for($i = 0; $i < count($item_event_file); $i++)
{
	$str = trim($item_event_file[$i]);
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
			$EventGroupName[$s[1]] = $s[2];//��� ������ ������� ��� ��������� ��������
		}
	}
}

foreach($export_item_event as $item => $ev)
{
	foreach($ev as $i)
	{
			//���. ������� ��������� ��������
			$item_get[$item][] = "������ ������� (group_event) <B><font color=\"blue\">$i (".$EventGroupName[$i].")</font></B>";
	}
}

//������ item_enc.exp
for($i = 0; $i < count($item_enc_file); $i++)
{
	$str = trim($item_enc_file[$i]);
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
			$EncGroupName[$s[1]] = $s[2];//��� ������ ����������� ��� ��������� ��������
		}
	}
}

foreach($export_item_enc as $item => $ev)
{
	foreach($ev as $i)
	{
			//���. ������� ��������� ��������
			$item_get[$item][] = "������ ����������� (group_enc) <B><font color=\"blue\">$i (".$EncGroupName[$i].")</font></B>";
	}
}

//echo "u1=".$u1." u2=".$u2." u3=".$u3."<br>";
//for($i=1;$i<$u1;$i++)echo $str_num[$i]."-".$u_table1[$i]." ";

//�����
/*
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


//�������� �� ���������� �����
for($i=0;$i<$max+1;$i++)
{
	$q=count(array_keys($name_table, $name_table[$i]));
	if($q>1)
		echo $name_table[$i]."($i)=".$q."<br>";
}

//echo "<table width=100% border=1><tr><td>�</td><td colspan=20>Units</td></tr>";

//����� ��������
for($i=0;$i<$max+1;$i++)
{ 
//	echo "<tr><td>$i</td><td>";
	for($j=0;($res_table[$i][$j]!="")&&($j<10);$j++)
	{
		$item_res[$i] .= $res_table[$i][$j].(($res_table[$i][$j+1]=="") ? "" : "; ");
	}
//	echo $item_res[$i]."</td></tr>";
}
/*
//����� ������ building
echo "<tr><td>building</td></tr>";
for($i=0;$i<$max+1;$i++)
{
	echo "<tr><td>$i</td><td>$build_table[$i]</td></tr>";
}

//����� item_Slot
echo "<tr><td>item_Slot</td></tr>";
for($i=0;$i<$max+1;$i++)
{
	echo "<tr><td>$i</td><td>".$item_slot[$slot_table[$i]]."</td></tr>";
}
*/
//����� item_rarity
//echo "<tr><td>item_rarity</td></tr>";
for($i=0;$i<$max+1;$i++)
{
//	echo "<tr><td>$i</td><td>";
	if($rarity_table[$i]==1)
		$item_color_name[$i] = "<B><font color=\"yellow\">";
//		$item_color_name[$i] = "<B><font color=\"#DCDC32\">";
	else
	if($rarity_table[$i]==2)
		$item_color_name[$i] = "<B><font color=\"lime\">";
//		$item_color_name[$i] = "<B><font color=\"#32FA32\">";
	else
	if($rarity_table[$i]==3)
//		$item_color_name[$i] = "<B><font color=\"aqua\">";
		$item_color_name[$i] = "<B><font color=\"#32DCDC\">";
	else
	if($rarity_table[$i]==4)
//		$item_color_name[$i] = "<B><font color=\"darkblue\">";
		$item_color_name[$i] = "<B><font color=\"#8282FF\">";
//		echo "<font color=\"navy\">";
	else
	if($rarity_table[$i]==5)
		$item_color_name[$i] = "<B><font color=\"purple\">";
//		$item_color_name[$i] = "<B><font color=\"#B446FA\">";
	else
	if($rarity_table[$i]==6)
		$item_color_name[$i] = "<B><font color=\"red\">";
//		$item_color_name[$i] = "<B><font color=\"#FA3232\">";
	else
		$item_color_name[$i] = "<B><font color=\"white\">";
	$item_color_name[$i] .= $name_table[$i]."</B></font>";
//	echo $item_color_name[$i]."</td></tr>";
}
/*
//����� item_class
echo "<tr><td>item_class</td></tr>";
for($i=0;$i<$max+1;$i++)
{
	echo "<tr><td>$i</td><td>".$item_type[$class_table[$i]]."</td></tr>";
}

//����� item_set
echo "<tr><td>item_set</td></tr>";
for($i=0;$i<$max+1;$i++)
{
	echo "<tr><td>$i</td><td>";
	if($item_set_items[$i]!="")
		echo $item_set_items[$i];
	echo "</td></tr>";
}
*/
//EFFECTS item
for($i=1,$j=1;$i<$max+1;$i++)
{ 
//	echo "<tr><td>$i</td><td>";
	for($n=1;($effects[$i][$j]['num']!="")&&($j<10000);$j++,$n++)
	{
	    $item_effect[$i] .= $n.") ";
	    $num=$effects[$i][$j]['num'];
	    $power=$effects[$i][$j]['power'];
	    $area=$effects[$i][$j]['area'];
		if($num==23)//���� ��������
			$item_effect[$i] .= "���� �������� (<B><font color=\"green\">1-".($power+1)."</font></B>)".($effects[$i][$j+1]['num']!="" ? "<br>" : "");
		else
		if($num==64)//���������� ������
			$item_effect[$i] .= "���������� ������ (<B><font color=\"brown\">".$u_name[$power]."</font></B>)".($effects[$i][$j+1]['num']!="" ? "<br>" : "");
		else
	    if($num==83) //����
			$item_effect[$i] .= $abil_name[$num]." <B><font color=\"blue\">".$spell_name[$power]."</font></B>".($effects[$i][$j+1]['num']!="" ? "<br>" : "");
	    else
	    if($num==84) //������
			$item_effect[$i] .= $abil_name[$num]." <B><font color=\"brown\">".$u_name[$power]."</font></B>".($effects[$i][$j+1]['num']!="" ? "<br>" : "");
		else
		if($num==984)//������ �������� (������ ��� �����)
			$item_effect[$i] .= $abil_name[$num]." (��������� ������� <= <font color=\"green\"><B>".$power."</B></font>)";
		else
		if($num == 997)//���������� ����� �������
		{
			$item_effect[$i] .= "���������� ����� �������: ������ �� <font color=\"green\"><B>".$power."%</B></font>";
			$item_effect[$i] .= ", ���������� �� <font color=\"green\"><B>".($power/2)."%</B></font>".($effects[$i][$j+1]['num']!="" ? "<br>" : "");
		}
		else
		if(in_array($num,$abil_stamina))
		{
			$item_effect[$i] .= $abil_name[$num]." (������� ������������ <font color=\"red\"><B>".$power."</B></font>)";
			$item_effect[$i] .= ($effects[$i][$j+1]['num']!="" ? "<br>" : "");
		}
		else
		if(in_array($num,$abil_xod))
		{
			$item_effect[$i] .= $abil_name[$num]." (��������� <font color=\"fuchsia\"><B>$power</font></B> ���";
			if($power>1 && $power<5)
				$item_effect[$i] .= "�";
			else
				$item_effect[$i] .= "��";
			$item_effect[$i] .= ")".($effects[$i][$j+1]['num']!="" ? "<br>" : "");
		}
		else
		if($abil_name[$num]=="")
			$up_abil[$n] .= "!!!����������� ������ $num; ";
	    else
	    {
			if($abil_numeric[$num]==0)
				$item_effect[$i] .= $abil_name[$num];
//		else
			else
			if($num==983)//�������� ���� ��������
				$item_effect[$i] .= $abil_name[$num]." <font color=\"green\"><B>�� ".$power."%</B></font>";
/*
			else
			if($num==20)//�������������� �������
				$item_effect[$i] .= $abil_name[$num]." (<font color=\"green\"><B>������ ������� ".($power>=0 ? "</font><font color=\"blue\">$power" : "�������� �� </font><font color=\"blue\">".abs($power))."</B></font>)";

*/
			else
				$item_effect[$i] .= $abil_name[$num].($power<0 ? " <B><font color=\"red\">$power" : " <B><font color=\"green\">+$power").($abil_percent[$num]==1 ? "%" : "")."</font></B>";
//		    $item_effect[$i] .= $abil_name[$num].($power<0 ? " <B><font color=\"red\">$power</font></B>" : " <B><font color=\"green\">+$power</font></B>");
			$item_effect[$i] .= ($area==1 ? " <font color=\"aqua\">(�����)</font>" : "").($effects[$i][$j+1]['num']!="" ? "<br>" : "");
	    }
	}
//	echo $item_effect[$i]."</td></tr>";
	$n1 = 1;
	foreach($item_get[$i] as $v)
	{
		$item_get_prn[$i] .= $n1++.") ".$v."<br>";
	}
	foreach($item_get2[$i] as $v)
	{
		$item_get2_prn[$i] .= $u_name[$v].", ";
	}
	$item_get_prn[$i] = substr($item_get_prn[$i],0,-4);
	$item_get2_prn[$i] = substr($item_get2_prn[$i],0,-2);
}

echo "<table width=100% border=1>";
//����� �� ������(�����)
for($v=1;$v<=$max;$v++)
{
	echo "<tr><td align=center>$v</td><td class=gray>".$item_color_name[$v]."</td><td>";
//	echo "<img src=\"i/".$pic_table[$v].".bmp\"></td><td>";
	echo "</td><td>";
	echo $item_effect[$v]."</td><td>".$item_type[$class_table[$v]]."</td><td>";
	echo $item_slot[$slot_table[$v]]."</td><td align=center>".$gold_table[$v]."</td><td align=center>";
	echo $gem_table[$v]."</td><td>".$item_res[$v]."</td><td>";
	echo $item_get_prn[$v]."</td><td align=center>".$dur_table[$v]."</td><td align=center>";
	echo $shop_table[$v]."</td><td align=center>".$rarity_table[$v]."</td><td>";
	if($item_set_items_name[$v]!="")echo $item_set_items_name[$v];
	echo "</td><td class=font9 align=center>".$item_get2_prn[$v]."</td>";
	echo "</td><td class=font9 align=center>".$item_txt[$v]."</td></tr>";
}
echo "</table><br>";
//echo "<B><font color=\"red\">---����� �� ������---</font></B><br><br>";
for($i=0;$i<count($item_sort);$i++)
{
	echo "<table width=100% border=1>";
	echo "<tr><td></td><td><B><font color=\"red\">$i $tab_name[$i]</font></B></td></tr><br><br>";
	$num=1;
	foreach($tab_item[$i] as $v)
	{
//		settype($v,"integer");
		$file_str[$tab_num[$i]] .= $pic_table[$v].",";//������������ ������� ������ � ������
		if(count($tab_item[$i])==$num)//�������������� ������ �����
		{
			echo "<tr><td class=bottom align=center>".$v."</td><td class=bottom_gray>".$item_color_name[$v]."</td><td class=bottom>";
//			echo "<img src=\"i/".$pic_table[$v].".bmp\"></td><td>";
			echo "</td><td class=bottom>";
			echo $item_effect[$v]."</td><td class=bottom>".$item_type[$class_table[$v]]."</td><td class=bottom>";
			echo $item_slot[$slot_table[$v]]."</td><td class=bottom align=center>".$gold_table[$v]."</td><td class=bottom align=center>";
			echo $gem_table[$v]."</td><td class=bottom>".$item_res[$v]."</td><td class=bottom>";
			echo $item_get_prn[$v]."</td><td class=bottom align=center>".$dur_table[$v]."</td><td class=bottom align=center>";
			echo $shop_table[$v]."</td><td class=bottom align=center>".$rarity_table[$v]."</td><td class=bottom>";
			if($item_set_items_name[$v]!="")echo $item_set_items_name[$v]."</td></tr>";
			echo "<tr></tr>";
		}
		else
		{
			echo "<tr><td align=center>".$v."</td><td class=gray>".$item_color_name[$v]."</td><td>";
//			echo "<img src=\"i/".$pic_table[$v].".bmp\"></td><td>";
			echo "</td><td>";
			echo $item_effect[$v]."</td><td>".$item_type[$class_table[$v]]."</td><td>";
			echo $item_slot[$slot_table[$v]]."</td><td align=center>".$gold_table[$v]."</td><td align=center>";
			echo $gem_table[$v]."</td><td>".$item_res[$v]."</td><td>";
			echo $item_get_prn[$v]."</td><td align=center>".$dur_table[$v]."</td><td align=center>";
			echo $shop_table[$v]."</td><td align=center>".$rarity_table[$v]."</td><td>";
			if($item_set_items_name[$v]!="")echo $item_set_items_name[$v]."</td></tr>";
		}
		$num++;
	}
	echo "</table><br>";
}

echo "<br><table width=100% border=1>";
echo "<tr><td></td><td><B><font color=\"red\">������</font></B></td></tr><br><br>";
//����� ������
for($i=1;$i<=count($item_cloth);$i++)
{
	foreach($tab_cloth[$i] as $v)
	{
		$file_str[16] .= $pic_table[$v].",";
		if(($i!=5) || ($dur_table[$v]>1))
		{
			echo "<tr><td align=center>".$v."</td><td class=gray>".$item_color_name[$v]."</td><td>";
//			echo "<img src=\"i/".$pic_table[$v].".bmp\"></td><td>";
			echo "</td><td>";
			echo $item_effect[$v]."</td><td>".$item_type[$class_table[$v]]."</td><td>";
			echo $item_slot[$slot_table[$v]]."</td><td align=center>".$gold_table[$v]."</td><td align=center>";
			echo $gem_table[$v]."</td><td>".$item_res[$v]."</td><td>";
			echo $item_get_prn[$v]."</td><td align=center>".$dur_table[$v]."</td><td align=center>";
			echo $shop_table[$v]."</td><td align=center>".$rarity_table[$v]."</td><td>";
			if($item_set_items_name[$v]!="")echo $item_set_items_name[$v]."</td></tr>";
		}
	}
}

echo "</table><br>";
echo "<B><font color=\"red\">���������</font></B><br><br>";
echo "<br><table width=100% border=1>";
//����� ���������
for($i=0;$i<3;$i++)
{
	foreach($tab_jewel[$i] as $v)
	{
		$file_str[17] .= $pic_table[$v].",";
		if(($i!=1) || ($dur_table[$v]==1))
		{
			echo "<tr><td align=center>".$v."</td><td class=gray>".$item_color_name[$v]."</td><td>";
//			echo "<img src=\"i/".$pic_table[$v].".bmp\"></td><td>";
			echo "</td><td>";
			echo $item_effect[$v]."</td><td>".$item_type[$class_table[$v]]."</td><td>";
			echo $item_slot[$slot_table[$v]]."</td><td align=center>".$gold_table[$v]."</td><td align=center>";
			echo $gem_table[$v]."</td><td>".$item_res[$v]."</td><td>";
			echo $item_get_prn[$v]."</td><td align=center>".$dur_table[$v]."</td><td align=center>";
			echo $shop_table[$v]."</td><td align=center>".$rarity_table[$v]."</td><td>";
			if($item_set_items_name[$v]!="")echo $item_set_items_name[$v]."</td></tr>";
		}
	}
}

echo "</table><br>";
/*
//����� ����� (������ ������)
echo "<table border=1>";

for($i=1;$i<$max1+1;$i++)
{
//	echo "<tr><td>$i</td><td>$item_set_name[$i]</td>";
	for($j=0;$j<$item_set_num[$i];$j++)
	{
		echo "<tr>";
		if($j==0)
			echo "<td>$i</td><td>$item_set_name[$i]</td>";
		else
			echo "<td></td><td></td>";
		$q=$item_set_items[$i][$j];
		echo "<td>".$item_color_name[$q]."</td><td></td><td>";
		echo $item_type[$class_table[$q]]."</td><td>".$item_slot[$slot_table[$q]]."</td>";
		if($j==0)
			echo "<td>$set_abil[$i]</td>";
		else
			echo "<td></td>";
		echo "</tr>";
	}
}
echo "</table><br>";
*/

//����� �����
echo "<B><font color=\"red\">����</font></B><br><br>";
echo "<table border=1>";
//echo "<col span=8>";
for($i=1;$i<$max1+1;$i++)
{
//	echo "<tr><td>$i</td><td>$item_set_name[$i]</td>";
	$num=$item_set_num[$i];
	for($j=0;$j<$num;$j++)
	{
		echo "<tr>";
		if($j==0)
		{
			echo "<td align=center rowspan=$num class=bottom>$i</td>";
			echo "<td rowspan=$num class=bottom style='border-right:1.0pt solid black;'>$item_set_name[$i]</td>";
		}
//style='border-bottom:1.0pt solid black;'
//		else
//			echo "<td></td><td></td>";
		$q=$item_set_items[$i][$j];
		if($j==$num-1)
		{
			echo "<td class=bottom_gray>".$item_color_name[$q];
			echo "</td><td class=bottom></td><td class=bottom>";
			echo $item_effect[$q]."</td><td class=bottom>";
			echo $item_type[$class_table[$q]]."</td><td class=bottom>";
			echo $item_slot[$slot_table[$q]]."</td>";
		}
		else
		{
			echo "<td class=gray>".$item_color_name[$q]."</td><td></td><td>".$item_effect[$q]."</td><td>";
			echo $item_type[$class_table[$q]]."</td><td>".$item_slot[$slot_table[$q]]."</td>";
		}
		if($j==0)
			echo "<td rowspan=$num class=bottom style='border-left:1.0pt solid black;'>".substr($set_abil[$i],0,-4)."</td>";
//		else
//			echo "<td></td>";
		echo "</tr>";
	}
}
echo "</table><br>";
/*	if($file_flag[$tab_num[$i]]) //���� ��������������� ������ � ����� txt-����� (�����-������ ����� etc...)
	{
		$f=fopen(dirname(__FILE__) . "/images/filenum" . $tab_num[$i] . ".txt","w") or die("������ �������� ����� filenum$i.txt");
		fwrite($f,"#\n");
	}
	$p[$tab_num[$i]]=substr($p[$tab_num[$i]],0,-1);
	fwrite($f,$p[$tab_num[$i]]);
	fclose($f);
*/
dumper($file_str,"file_str");
//��� ���������� ������ ������, ���� ����� ����� ����������� � �����...
for($i=1;$i<=count($file_str);$i++)
{
	$dir=dirname(__FILE__)."/images/filenum".($i>9 ? $i : "0$i").".txt";
	$f=fopen($dir,"w") or die("������ �������� ����� $dir");
	fwrite($f,"#\n");
	fwrite($f,substr($file_str[$i],0,-1));
	fclose($f);
}
?>
<br><a href='index.html'>��������� � ������ ������</a>
</html>
