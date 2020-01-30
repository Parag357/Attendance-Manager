<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Welcome Student</title>
<link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link href="../hope/assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
</head>
<?php
include "conn.php";
session_start();
$name=$branch=$section=$semester="";
$id=$_SESSION['id'];
//echo "The Id is \t".$id;
$cmd="select * from student where stu_id=$id";
$err="";
//echo $cmd;
$res=mysqli_query($con,$cmd);
if(mysqli_num_rows($res)>0)
{
$row=mysqli_fetch_array($res);
$name=$row['name'];
$branch=$row['branch'];
$semester=$row['semester'];
$section=$row['section'];
}
else
{
header("location:login.php");
}
?>
<body>
<br /><br />
   <div class="container">
        <div class="row no-gutters">
            <div class="col-md-12">
                <div class="content jumbotron bg-light">
					<form action="<?php echo $_SERVER['PHP_SELF'];
						?>" method="post">
                       <table class="table-responsive">
					   <tr> <td rowspan="2"><img src="assets/images/logo.png" width="120" height="120" /></td><td colspan="10"><h1 class="font-italic table-dark">Welcome <?php  echo $name ;?></h1></td></tr>
					   <tr><td colspan="3"><h2 class="display-5"><?php  echo $branch ;?>-<?php  echo $section ;?> <b>|</b> sem-<?php echo $semester ;?></h2></td><td colspan="7" align ="right"><input type="submit" class="btn btn-danger" name="logout" value="LogOut" /></td></tr></table>
<table class=" table table-stripped table-responsive" align="center">
<!--<tr><th colspan="50" align="center"><h1 class="display-3">Attendance Logs</h1></th></tr>-->
<?php
$cmd="select distinct(subject) from manage where student_id=$id";// change the static student id
$res10=mysqli_query($con,$cmd);
if(mysqli_num_rows($res10)>0)
{
while($row10=mysqli_fetch_array($res10))  // loop runs till the last row
{
//echo $row10['subject'].",,";
//<tr><th colspan="50" align="center"><h1 class="font-italic table-dark">$row10['subject']</h1></th></tr>
//}
//}
?>
<tr><th colspan="50" align="center"><h3 class="font-italic table-dark"><?php echo $row10['subject']?></h3></th></tr>
<?php 
$cmd1="select date from manage where subject= '".$row10['subject']."' and student_id=$id";// change the static values
$res1=mysqli_query($con,$cmd1);
if(mysqli_num_rows($res1)>0)
{
while($row1=mysqli_fetch_array($res1))  // loop runs till the last row
{
$d=$row1['date'];
echo '<td><b>'.$d[8],$d[9].'/'.$d[5],$d[6].'/'.$d[2],$d[3].'</b></td>';
}
}
?>
<th colspan="3"><h4 class="display-7 table-dark" align="center">Total</h4></th></tr>
<?php
$x=0;$y=0;
$att50=[];
$att75=[];
$prc50=[];
$prc75=[];
$err="";
$cmd="select status from manage where student_id=$id and subject='".$row10['subject']."'";// change the static values
$res2=mysqli_query($con,$cmd);
if(mysqli_num_rows($res2)>0)
{
while($row2=mysqli_fetch_array($res2))  // loop runs till the last row
{
$status=$row2['status'];
if($status=='present')
	$status='prs';
else
	$status='abs';
echo'<td  align="center">'.$status.'</td>';
}
$cmd="select count(status) as 'counttime' from manage where subject='".$row10['subject']."' and student_id=$id";// change the static values
$res3=mysqli_query($con,$cmd);
//var_dump($res);
if(mysqli_num_rows($res3)>0)
{
$row3=mysqli_fetch_array($res3);
$tot=$row3['counttime'];
}
$cmd="select count(status) as 'counttime' from manage where subject='".$row10['subject']."' and student_id=$id and status !='absent'";// change the static values
$res4=mysqli_query($con,$cmd);
if(mysqli_num_rows($res4)>0)
{ 
$row4=mysqli_fetch_array($res4);
$pr=$row4['counttime'];
$prc=(int)(($pr/$tot)*100);
if(($prc<75)&&($prc>=50))
{
$att75[$x]=$row[1];//change 1 with student id
$prc75[$x]=$prc;
$x++;
}
else if($prc<50)
{
$att50[$y]=$row[1];//change 1 with student id
$prc50[$y]=$prc;
$y++;
}
//echo $pr;
}
echo'<td class="table-dark"><center>'.$pr.'/'.$tot.'=<b>'.$prc.'%</b>'.'</center></td></tr>';
}
else
{
$err="Attendance records not inserted yet.";
}
}
} 
if(isset($_POST['logout']))
{
if(session_destroy())
{
header("location:login.php");
}
}
?>
</table>
<!--<table><tr><td colspan="100" align="right"><input type="submit" class="btn btn-danger" name="logout" value="LogOut" /></td></tr>
</table>-->
</div></div></div></div>
</form>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery-3.3.1.slim.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.js"></script>
</body>
</html>