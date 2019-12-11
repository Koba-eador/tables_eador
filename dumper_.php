<?php
function dumper($obj,$str="")
{
	echo "<pre>";
	echo ($str ? "<span style='color:blue'>".$str.": </span>" : "");
	echo htmlspecialchars(dumperGet($obj)),"</pre>";
//	echo "<font size=2><pre>",htmlspecialchars(dumperGet($obj)),"</pre></font>";
}
function dumperGet(&$obj,$leftSp="")
{
	if(is_array($obj))
		$type="Array[".count($obj)."]";
	elseif(is_object($obj))
		$type="Object";
	elseif(gettype($obj)=="boolean")
		return $obj ? "true" : "false";
	else
		return "\"$obj\"";
	$buf=$type;
	$leftSp .= "    ";
	for(Reset($obj); list($k,$v) = each($obj);)
	{
		if($k==="GLOBALS") continue;
		$buf .= "\n$leftSp$k => ".dumperGet($v,$leftSp);
	}
	return $buf;
}

function get_plural($var,$s1,$s2,$s3)//всякие склонения типа "свитков", "чертежей"...
{
	while($var > 100)
		$var -= 100;
	if($var > 20)
		$var %= 10;
	if($fl == 0)//свитков
	{
		if($var == 1)
		{
			return "ок";
		}
		else
		if($var>1 && $var<5)
		{
			return "ка";
		}
		else
			return "ков";
	}
	else
	if($fl == 1)//чертежей
	{
		if($var == 1)
		{
			return "ёж";
		}
		else
		if($var>1 && $var<5)
		{
			return "ежа";
		}
		else
			return "ежей";
	}
}?>