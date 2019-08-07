<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Update Attendance</title>
<link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link href="../hope/assets/css/style.css" rel="stylesheet">
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU"
     crossorigin="anonymous">
<?php	
session_start();
include "conn.php";
$id=$_SESSION['id'];
$cmd="select * from profile where id='$id'";
$res=mysqli_query($con,$cmd);
if(!(mysqli_num_rows($res)>0))
{
header("location:login.php");
}
$err="";
//$id=$_SESSION['id'];
$section=$_SESSION['section'];
$semester=$_SESSION['semester'];
$branch=$_SESSION['branch'];
$subject=$_SESSION['subject'];
?>
<style type="text/css">
<!--
.style1 {font-style: italic}
-->
</style>
</head>
<body>
<br /><br />
 <div class="container">
        <div class="row no-gutters">
            <div class="col-md-3">
			</div>
				<div class="col-md-6">
                	<div class="content jumbotron mb-5">
					<form action="<?php echo $_SERVER['PHP_SELF'];
?>" method="post">
<table align="center" class="table table-stripped table-responsive">
<tr><th width="22%"><img src="assets/images/logo.png" alt="logo" width="120"height="120"></th>
<th colspan="4" ><h1 class="display-4">Attendance Sheet</center></h1></th></tr>
<tr><th colspan="5"><h3 class=" display-4 table-dark"><center><?php echo $_SESSION['branch']."-".$_SESSION['section'].", semester: ".$_SESSION['semester']; ?></center></h3></th></tr>
<tr><th><h4 class="display-5"><b><center>RegNo.</center></b></h4></th><th colspan="2"><h4 class="display-5"><b><center>Name</center></b></h4></th><th colspan="2"><h4 class="display-5"><b><center>Status</center></b></h4></th></tr>
<?php 
$err1="";
$name1=0;
$regno=array();
$cmd="select stu_id, name from student where branch='$branch' and section= '$section' and semester='$semester' order by stu_id";
$res=mysqli_query($con,$cmd);
if(mysqli_num_rows($res)>0)
{
$i=1; // to count the number of students
while($row=mysqli_fetch_array($res))
{
$regno[$i]=$row['stu_id'];
echo '<tr><td><center>'.$row['stu_id'].'</center></td><td colspan="2"><center>'.$row['name'].'</center></td><td colspan="2"><center><input type="checkbox" name="chk[]" value="chk_'.$i.'"/></center></td></tr>';
$i++;
}
}
if(isset($_POST['details']))
{
$_SESSION['back_status']=1;
header("location:display.php");
}
if(isset($_POST['submit']))
{
if(!(isset($_POST['chk'])))
{
$id1=$regno[1];
$cmd="select count(status) as 'counttime' from manage where subject='$subject' and branch='$branch' and section='$section' and semester='$semester' and student_id='$id1'";

$res3=mysqli_query($con,$cmd);
//var_dump($res);
if(mysqli_num_rows($res3)>0)
{
$row3=mysqli_fetch_array($res3);
$tot=$row3['counttime'];
}
$cmd="select tclass from course where subject='$subject' and semester='$semester' and section='$section' and branch='$branch'";

$res4=mysqli_query($con,$cmd);
//var_dump($res);
if(mysqli_num_rows($res4)>0)
{
$row4=mysqli_fetch_array($res4);
$valid=$row4['tclass'];
}
if($tot>=$valid)
{
$err1="This course is already completed for this semester";
}
else
{
$check=0;
for($j=1;$j<$i;$j++)
{
$name1=$regno[$j];
$date=date("Y-m-d");
$cmd="insert into manage values ('$name1','$branch','$semester','$section','$subject','$date','absent')";
//mysqli_query($con,$cmd);
if((mysqli_query($con,$cmd)))
{
$check++;
}
}
$rem=$valid-$tot-1; // -1 because total is calculated before updation
if ($check!=0)
echo "<script>alert('Attendance Updated,remaining classes: $rem')</script>";
else
echo "<script>alert('Attendance Updation failed')</script>";
}
}
else
{
$id1=$regno[1];
$cmd="select count(status) as 'counttime' from manage where subject='$subject' and branch='$branch' and section='$section' and semester='$semester' and student_id='$id1'";

$res3=mysqli_query($con,$cmd);
//var_dump($res);
if(mysqli_num_rows($res3)>0)
{
$row3=mysqli_fetch_array($res3);
$tot=$row3['counttime'];
}
$cmd="select tclass from course where subject='$subject' and semester='$semester' and section='$section' and branch='$branch'";

$res4=mysqli_query($con,$cmd);
//var_dump($res);
if(mysqli_num_rows($res4)>0)
{
$row4=mysqli_fetch_array($res4);
$valid=$row4['tclass'];
}
if($tot>=$valid)
{
$err1="This course is already completed for this semester";
}
else
{
$check=0;
$present=$_POST['chk'];
for($j=1;$j<$i;$j++)
{
if(in_array("chk_".$j,$present))
{
$name1=$regno[$j];
$date=date("Y-m-d");
$cmd="insert into manage values ('$name1','$branch','$semester','$section','$subject','$date','present')";
//mysqli_query($con,$cmd);
if((mysqli_query($con,$cmd)))
{
$check++;
}
}
else
{
$name1=$regno[$j];
$date=date("Y-m-d");
$cmd="insert into manage values ('$name1','$branch','$semester','$section','$subject','$date','absent')";
//mysqli_query($con,$cmd);
if((mysqli_query($con,$cmd)))
{
$check++;
}
}
}
$rem=$valid-$tot-1; // -1 because total is calculated before updation
if ($check!=0)
echo "<script>alert('Attendance Updated,remaining classes: $rem')</script>";
else
echo "<script>alert('Attendance Updation failed')</script>";
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
if(isset($_POST['back']))
{
header("location:welcome.php");

}
?>
<tr><td colspan="5" align="center"><span style="color:#FF0000"><?php echo $err1; ?></span></td></tr>
<tr><td><input type="submit" class="btn btn-danger" name="logout" value="LogOut" /></td><td><input type="submit" class="btn btn-dark" name="back" value="Back" /></td><td>
  <input type="submit" class="btn btn-dark" name="reset" value="Reset" /></td><td><input type="submit" class="btn btn-dark" name="submit" value="OK" /></td><td><input type="submit" class="btn btn-dark" name="details" value="Logs" /></td></tr>
</table>
</form>
                  </div>
                     </div>
                </div>
        </div>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery-3.3.1.slim.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.js"></script>
</body>
</html>
