<html>
<meta http-equiv="Content-Type" content="text/html charset=windows-1251">
<style>
br
	{mso-data-placement:same-cell;}
</style>
<?php
echo $TEMPDIR;
echo $fname = $_FILES['userfile']['tmp_name'],"<br>";
echo $uname = $_FILES['userfile']['name'],"<br>";
echo $fsize = $_FILES['userfile']['size'],"<br>";
echo $ftype = $_FILES['userfile']['type'],"<br>";
?>
<br><a href='index.html'>вернуться к списку файлов</a>
</html>
