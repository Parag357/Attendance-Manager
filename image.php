<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<!-- java script usage-->
<script type="text/javascript">
function preview(event)
{
var reader= new FileReader();<!--var is used to declare variable/object in js-->
reader.onload=function()
{
var output= document.getElementById('output_image');
output.src=reader.result;
}
reader.readAsDataURL(event.target.files[0]);
}
</script>
</head>
<?php
include "conn.php";
$filerr="";
if(isset($_POST['submit']))
{
$id=$_POST['id'];
if(is_uploaded_file($_FILES['file']['tmp_name']))
{
$file=file_get_contents($_FILES['file']['tmp_name']);
$img=base64_encode($file); // to conver the longblob datatype into strings and decimal using base64
$filetype=$_FILES['file']['type'];// to get the mime code of file
$img="data:$filetype;base64,$img";// furter explanation reqd
$cmd="update profile set photo='$img' where id='$id'";
if(mysqli_query($con,$cmd))
{
echo "image inserted successfully";
}
else
{
echo "error in insertion - $cmd";
}
}
else
{
$filerr= "please choose an image";
}
}
?>
<body>
<form action="<?php echo $_SERVER['PHP_SELF'];
?>" method="post" enctype="multipart/form-data">
<table>
<tr><th colspan="3">Please choose an image : </th></tr>
<tr><td>enter id</td><td colspan="2"><input type="text" name="id"  /></td></tr>
<tr>
<td>Upload Image</td><td><input type="file" name="file" onchange="preview(event)" /></td><td width="100px" height="100px"><img id="output_image" width="100%" /></td><td><span style="color:#FF0000"><?php echo $filerr; ?></span></td>
</tr>
<tr><td colspan="2"><input type="reset"name="reset" value="cancel"/></td><td><input type="submit" name="submit" value="submit"/></td><td></td></tr>
</table>
</form>
</body>
</html>
