<html><head>
<meta http-equiv="Content-Type" content="text/html charset=windows-1251">
<title>����� - ������</title></head><body>
<?php
$q_file = file("quest.var");
$count_q = count($q_file);
$enc_file = file("encounter.var");
$count_enc = count($enc_file);
$site_file = file("site.var");
$count_site = count($site_file);
$item_file = file("item.var");
$count_item = count($item_file);
$unit_file = file("unit.var");
$count_unit = count($unit_file);
$event_file = file("event.var");
$count_event = count($event_file);
$race_file = file("race.var");
$count_race = count($race_file);
$q_txt_file = file("Quest.txt");
$count_q_txt = count($q_txt_file);

//$unit_race=array(1=>"����","�����","�����","�������","����","�����������","��������","���������","Ҹ���� �����","������");
$enc_file_name="encounter_Eador_NH_18.0601.htm";
//$enc_file_name="eador_encounter.htm";
$hero_up = array_merge(range(40,43),range(238,253),range(263,278));//��� �����

$max=0;$max1=0;$max_u=0;$max_e=0;$t[0]=0;$j=0;$in_flag=0;
$u1=-1;$u2=0;$u3=0;	//� ������ ����� � xls
$g1=0; //���-�� ������� � ����� �����
$a1=0; //� ������
$a2=0; //� ������� ritual
$e1=0; //� �������
$up1=0; //����� upg_type � unit_upg
$u_a=0; //������ in unit.var

//������ Quest.txt
for($i = 0; $i < $count_q_txt; $i++)
{  
    if(eregi("^([0-9]{1,})",$q_txt_file[$i],$k))
    {
		$n=$k[1];
//		$s=explode('.',$q_txt_file[$i]);
//		$q_txt_name[$n]=trim($s[1]);
		if($n!=0)$q_txt[$n-1]=substr($q_txt[$n-1],0,-4);
    }
    else
	if((substr($q_txt_file[$i],0,1)=="#") && ($n!=3))//���� � Quest.txt
		$q_txt_name[$n] = trim(substr($q_txt_file[$i],1));
	else
	{
		if(trim($q_txt_file[$i])!="")
			$q_txt[$n] .= str_replace("#","",$q_txt_file[$i])."<br>";
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
    else
    if(eregi("^Quests:",$race_file[$i]))
    {
		$s=explode(':',$race_file[$i]);
		$race_quest[substr(trim($s[1]),1,-1)+1-1]=$unit_race[$n];
//echo $n."-".(substr(trim($s[1]),1,-1)+1-1)."--".$race_quest[substr(trim($s[1]),1,-1)+1-1]."<br>";
	}
}

//������ encounter.var
for($i = 0,$n=0; $i < $count_enc; $i++)
{  
   if(eregi("^/([0-9]{1,})",$enc_file[$i],$k))
    {
		$n=$k[1];
		$s=substr($enc_file[$i],log10($n)+3);
//echo $n."-".$s."<br>";
		$enc_table[$n]=trim($s);
// echo $e_file[$i]."<br>".$k[0]."-".$k[1]."--".$dialog_table[$n]."<br>";
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
//				echo $n."- ����� SITE=".$s;
				$s = $s."<font color=\"fuchsia\">*</font>";
//				echo " <B>������ ��</B> ".$s."<br>";
			}
			$site_name[$n]=$s;
		}
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
//			echo $n."- ����� ITEM=".$s;
			$s .= "<font color=\"fuchsia\">*</font>";
//			echo " <B>������ ��</B> ".$s."<br>";
		}
		$item_name[$n]=$s;
    }
}

//������ unit.var
for($i = 0,$n=0; $i < $count_unit; $i++)
{  
	if(eregi("^/([0-9]{1,})",$unit_file[$i],$k))
    {
		$n=$k[1];
    }
    else
    if(eregi("^name",$unit_file[$i]))
    {
		$s=explode(':',$unit_file[$i]);
		$s=trim(substr(trim($s[1]),0,-1));
		if(in_array($n,$hero_up))//��� �����
		{
			$u_name[$n]=$s."<font color=\"fuchsia\">@</font>";
		}
		else
		{
			while(in_array($s,$u_name))
			{
//				echo $n."- ����� UNIT=".$s;
				$s = $s."<font color=\"fuchsia\">*</font>";
//				echo " <B>������ ��</B> ".$s."<br>";
			}
			$u_name[$n]=$s;
		}
    }
}

//2-� ������ unit.var
for($i = 0,$n=0; $i < $count_unit; $i++)
{  
	if(eregi("^/([0-9]{1,})",$unit_file[$i],$k))
    {
		$n=$k[1];
    }
    else
    if(eregi("^Analogs:",$unit_file[$i]))
    {
		$s=explode(':',$unit_file[$i]);
		$s1=substr(trim($s[1]),1,-1);
		$s2=explode(',',$s1);
		for($j=0;($s2[$j]!="")&&($j<10);$j++)
		{
			if(($s2[$j]+1-1) != 0)
				$u_analogs[$n] .= $u_name[$s2[$j]+1-1]."; ";
		}
		if($u_analogs[$n] != "")
			$u_analogs[$n] = substr($u_analogs[$n],0,-2);
		else
			$u_analogs[$n] = "";
    }
}

//������ quest.var
for($i = 0,$n=0; $i < $count_q; $i++)
{  
	if(eregi("^/([0-9]{1,})",$q_file[$i],$k))
    {
		$n=$k[1];
		if($n>$max)$max=$n;
    }
    else
    if(eregi("^name",$q_file[$i]))
    {
		$s=explode(':',$q_file[$i]);
		$q_name[$n]=substr(trim($s[1]),0,-1);
    }
	else
	if(eregi("^Exp:",$q_file[$i]))
	{
		$s=explode(':',$q_file[$i]);
		$q_exp[$n]=$s[1]+1-1;
	}	
	else
	if(eregi("^Type:",$q_file[$i]))
	{
		$s=explode(':',$q_file[$i]);
		$q_type[$n]=$s[1]+1-1;
	}	
	else
	if(eregi("^Giver:",$q_file[$i]))
	{
		$s=explode(':',$q_file[$i]);
		$q_giver[$n]=$s[1]+1-1;
	}	
	else
	if(eregi("^Possibility:",$q_file[$i]))
	{
		$s=explode(':',$q_file[$i]);
		$q_poss[$n]=$s[1]+1-1;
	}	
	else
	if(eregi("^EncInit:",$q_file[$i]))
	{
		$s=explode(':',$q_file[$i]);
		$q_init[$n]=$s[1]+1-1;
	}	
	else
	if(eregi("^EncWait:",$q_file[$i]))
	{
		$s=explode(':',$q_file[$i]);
		$q_wait[$n]=$s[1]+1-1;
	}	
	else
	if(eregi("^EncFound:",$q_file[$i]))
	{
		$s=explode(':',$q_file[$i]);
		$q_found[$n]=$s[1]+1-1;
	}	
	else
	if(eregi("^EncNotFound:",$q_file[$i]))
	{
		$s=explode(':',$q_file[$i]);
		$q_not_found[$n]=$s[1]+1-1;
	}	
	else
	if(eregi("^EncDone:",$q_file[$i]))
	{
		$s=explode(':',$q_file[$i]);
		$q_done[$n]=$s[1]+1-1;
	}	
	else
	if(eregi("^EncSuccess:",$q_file[$i]))
	{
		$s=explode(':',$q_file[$i]);
		$q_success[$n]=$s[1]+1-1;
	}	
	else
	if(eregi("^EncFailGiver:",$q_file[$i]))
	{
		$s=explode(':',$q_file[$i]);
		$q_fail_giver[$n]=$s[1]+1-1;
	}	
	else
	if(eregi("^\*Objectives",$q_file[$i]))
	{
		$i++;
		$s=explode(':',$q_file[$i]);
		$q_obj_index[$n]=$s[1]+1-1;
		$i++;
		$s=explode(':',$q_file[$i]);
		$q_obj_param[$n]=$s[1]+1-1;
		$i++;
		$s=explode(':',$q_file[$i]);
		$q_obj_qua[$n]=$s[1]+1-1;
		$i++;
		$s=explode(':',$q_file[$i]);
		$q_obj_target[$n]=$s[1]+1-1;
		$i++;
		$s=explode(':',$q_file[$i]);
		$q_obj_place[$n]=$s[1]+1-1;
	}	
}

$q_txt_name[3]="�������� ������.";
//$q_name[0]="";
echo "<h3 align=\"center\"> ������<br></h3>";
$s=explode(':',$q_file[0]);
echo "Quantity: <B>".$s[1]."</B><br><br>";
//echo "-------------------------------------------------------------<br>";

for($i=1;$i<=$max;$i++)
{
	$index=$q_obj_index[$i];
	$param=$q_obj_param[$i];
	$qua=$q_obj_qua[$i];
	$target=$q_obj_target[$i];
	$place=$q_obj_place[$i];
	
//	echo "<HR WIDTH=\"100%\" SIZE=\"1\">";
	echo "<HR>";
	echo "<span style='color:fuchsia'><a name=\"e".$i."\"></a><B>/".$i." ".$q_name[$i]."</B></span><br>";
	if($q_giver[$i]>0)
	{
		echo "����-������������:<B> ".$site_name[$q_giver[$i]]."</B>";
	}
	else
	if($q_giver[$i]<0)
	{
		echo "����� ��������";
		$q_camp[$i]=1; //���� �������� (�������, �� ������������)
	}
	else
	{
		if($q_init[$i]!=0)
		{
			echo "������� ����� <B>(<span style='color:aqua'>";
			if($race_quest[$i]!="")
				echo $race_quest[$i]."</span>)</B>";
//echo $q_init[$i]."-".$race_quest[$q_init[$i]]."--".$unit_race[$race_quest[$q_init[$i]]]." ";
		}
		else
		{
			echo "����� ��������";
			$q_camp[$i]=1;
		}
	}
	echo "<br>";
	echo "<span style='color:red'>����������� ��������� ������� ������:</span> <B>".$q_poss[$i]."</B><br>";
	if(!$q_camp[$i])
	{
		echo "<span style='color:red'>���� ����� �� ����������:</span> <B>".$q_exp[$i]."</B><br>";
		echo "<br><B>$q_txt_name[$i]</B><br>".$q_txt[$i];
		echo "<pre>";
		if($q_init[$i]!=0)
			echo "<span style='color:green'>�����������, ������������ �����:                                       </span> <B><a href=\"".$enc_file_name."#e".$q_init[$i]."\">".$q_init[$i]." (".$enc_table[$q_init[$i]].")</a></B><br>";
		if($q_wait[$i]!=0)
			echo "<span style='color:green'>����������� ��� ��������� � ������������, ���������� ���������� ������:</span> <B><a href=\"".$enc_file_name."#e".$q_wait[$i]."\">".$q_wait[$i]." (".$enc_table[$q_wait[$i]].")</a></B><br>";
		if($q_found[$i]!=0)
			echo "<span style='color:green'>����������� ��� �������� ���������� ������� ������:                    </span> <B><a href=\"".$enc_file_name."#e".$q_found[$i]."\">".$q_found[$i]." (".$enc_table[$q_found[$i]].")</a></B><br>";
		if($q_not_found[$i]!=0)
			echo "<span style='color:green'>����������� ��� ��������� ������ ���������� �����:                     </span> <B><a href=\"".$enc_file_name."#e".$q_not_found[$i]."\">".$q_not_found[$i]." (".$enc_table[$q_not_found[$i]].")</a></B><br>";
		if($q_done[$i]!=0)
			echo "<span style='color:green'>����������� ��� ������ ���������� ������� ������:                      </span> <B><a href=\"".$enc_file_name."#e".$q_done[$i]."\">".$q_done[$i]." (".$enc_table[$q_done[$i]].")</a></B><br>";
		if($q_success[$i]!=0)
			echo "<span style='color:green'>����������� ��� ����� ������ ������������:                             </span> <B><a href=\"".$enc_file_name."#e".$q_success[$i]."\">".$q_success[$i]." (".$enc_table[$q_success[$i]].")</a></B><br>";
		if($q_fail_giver[$i]!=0)
			echo "<span style='color:green'>����������� ��� ����������� �����/������� ��������� ������������:      </span> <B><a href=\"".$enc_file_name."#e".$q_fail_giver[$i]."\">".$q_fail_giver[$i]." (".$enc_table[$q_fail_giver[$i]].")</a></B><br>";
		echo "</pre>";
//		echo "<br>";
		echo "<span style='color:red'><B>���� ������:</span> </B><br>";
		if($q_type[$i]==1)
		{
			echo "����������� ���� <B>".$site_name[$index];
			echo "</B>, ���� ���������� ������� ������: <B>".$param."%</B>";
			if($qua>1)
				echo "<B>, (".$qua.")</B> ���";
			if(($qua>1) && ($qua<5))
				echo "�";
		}
		else
		if($q_type[$i]==2)
		{
			echo "������ <B>".$qua."</B> ";
			if($qua==1)
				echo "�������";
			else
			if(($qua>1) && ($qua<5))
				echo "��������";
			else
				echo "���������";
			echo " �� ������� <B>".$u_name[$index];
			if($u_analogs[$index] != "")
				echo "</B> (��� <B>".$u_analogs[$index]."</B>)";
//			if($param!=0)
				echo "</B>, ���� ��������� ��������: <B>".(($param==0) ? 100 : $param)."%";
		}
		else
		if($q_type[$i]==3)
		{
			echo "����� <B>".$qua."</B> ";
			if($qua==1)
				echo "�������";
			else
				echo "��������";
			echo " <B>".$u_name[$index];
			if($u_analogs[$index] != "")
				echo "</B> (��� <B>".$u_analogs[$index]."</B>)";
		}
		else
		if($q_type[$i]==6)
		{
			echo "��������� <B>".$qua."</B> ������";
			if($param!=0)
				echo ", � ���������, ��������� ����� <B>".$unit_race[$param];
		}
		else
		if($q_type[$i]==7)
		{
			echo "������ ��������� ";
			echo (($index==0) ? "�������" : "������");
		}
		else
		if($q_type[$i]==8)
		{
			echo "������� ���������";
		}
		else
		if($q_type[$i]==9)
		{
			echo "������ ������� <B>".$item_name[$param];
		}
		echo "</B><br>";
	}
}


?>
</body></html>