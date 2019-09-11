
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Attendance Details</title>
<link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link href="../hope/assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"  integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU"
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
?>
</head>
<?php
$branch=$_SESSION['branch'];
$semester=$_SESSION['semester'];
$section=$_SESSION['section'];
$subject=$_SESSION['subject'];
if(isset($_POST['logout']))
{
if(session_destroy())
{
header("location:login.php");
}
}
if(isset($_POST['back']))
{
if($_SESSION['back_status']==0)
{
header("location:welcome.php");
}
else
{
$cmd="select count(date) as 'counttime' from manage where subject='$subject' and branch='$branch' and section='$section' and semester='$semester'";
$res3=mysqli_query($con,$cmd);
//var_dump($res);
if(mysqli_num_rows($res3)>0)
{
$row3=mysqli_fetch_array($res3);
$tot=$row3['counttime'];
}
$cmd2="select count(stu_id) as 'student_id' from student where branch='$branch' and semester='$semester' and section='$section'";
$res2=mysqli_query($con,$cmd2);
if(mysqli_num_rows($res2)>0)
{
$row2=mysqli_fetch_array($res2);
$div=$row2['student_id'];
$tot=$tot/$div;
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
header("location:welcome.php");
}
else
header("location:Attendance_Update.php");

}
}
?>
<body>
<br /><br />
  <div class="container">
        <div class="row no-gutters">
            <div class="col-md-12" >
                <div class="content jumbotron mb-5" >
                       <form action="<?php echo $_SERVER['PHP_SELF'];
?>" method="post">
<table class=" table table-stripped table-responsive" align="center">
<tr><th align="center"><center><img src="assets/images/logo.png" width="100" height="100" /></center></th><th colspan="49" align="center"><h1 class="display-3">Attendance Logs</h1></th></tr>
<tr><th colspan="50" align="center"><h1 class=" display-4 table-dark"><?php echo $subject." : ".$branch." - ".$section." ( semester - ".$semester." )"; ?></h1></th></tr>
<tr><th colspan="2"><h4 class="display-7">RegNo.</h4></th>
<?php
$cmd="select distinct student_id from manage where branch='$branch' and section='$section' and subject='$subject' and semester='$semester'";
$res=mysqli_query($con,$cmd);
if(mysqli_num_rows($res)>0)
{
while($row=mysqli_fetch_array($res))  // loop runs till the last row
{
$id=$row['student_id'];
}
}
$cmd="select date from manage where branch='$branch' and section='$section' and semester='$semester' and subject='$subject' and student_id='$id'";
$res=mysqli_query($con,$cmd);
if(mysqli_num_rows($res)>0)
{
while($row=mysqli_fetch_array($res))  // loop runs till the last row
{
echo '<th><h5 class="display-7"><center>'.$row['date'].'</center></h5></th>';
}
}
;
?>
<th colspan="3"><h4 class="display-7 table-dark" align="center">Total</h4></th></tr>
<?php
$x=0;$y=0;
$att50=[];
$att75=[];
$prc50=[];
$prc75=[];
$err="";
$cmd="select distinct student_id from manage where branch='$branch' and section='$section' and subject='$subject' and semester='$semester'";
//echo $cmd,"<br>";

$res=mysqli_query($con,$cmd);
if(mysqli_num_rows($res)>0)
{
while($row=mysqli_fetch_array($res))  // loop runs till the last row
{
echo '<tr><td colspan="2">'.$row['student_id'].'</td>';
$id=$row['student_id'];
$cmd="select status from manage where student_id='$id' and subject='$subject' and branch='$branch' and section='$section' and semester='$semester'";
$res2=mysqli_query($con,$cmd);
if(mysqli_num_rows($res2)>0)
{
while($row2=mysqli_fetch_array($res2))  // loop runs till the last row
{
echo'<td  align="center">'.$row2['status'].'</td>';
}
$cmd="select count(status) as 'counttime' from manage where subject='$subject' and branch='$branch' and section='$section' and semester='$semester' and student_id='$id'";

$res3=mysqli_query($con,$cmd);
//var_dump($res);
if(mysqli_num_rows($res3)>0)
{
$row3=mysqli_fetch_array($res3);
$tot=$row3['counttime'];
}
$cmd="select count(status) as 'counttime' from manage where subject='$subject' and branch='$branch' and section='$section' and semester='$semester' and student_id='$id' and status !='absent'";
$res4=mysqli_query($con,$cmd);
if(mysqli_num_rows($res4)>0)
{ 
$row4=mysqli_fetch_array($res4);
$pr=$row4['counttime'];
$prc=(int)(($pr/$tot)*100);
if(($prc<75)&&($prc>=50))
{
$att75[$x]=$row['student_id'];
$prc75[$x]=$prc;
$x++;
}
else if($prc<50)
{
$att50[$y]=$row['student_id'];
$prc50[$y]=$prc;
$y++;
}
//echo $pr;
}
echo'<td class="table-dark"align="center">'.$pr.'/'.$tot.'=<b>'.$prc.'%</b>'.'</td></tr>';
}
}
}
else
{
$err="Attendance records not inserted yet.";
}
?>
<tr><td colspan="50" align="center"><span style="color:#FF0000"><?php echo $err; ?></span></td></tr>
<tr><td><input type="submit" class="btn btn-danger" name="logout" value="LogOut" /></td><td colspan="49"><input type="submit" class="btn btn-dark" name="back" value="Back" /></td></tr>
</table>
                </div>
        </div>
      </div>
    </div>
	<br /><br />
 <div class="container">
        <div class="row no-gutters">
            <div class="col-md-5" >
                <div class="content jumbotron mb-5" >
				<table class=" table table-stripped table-responsive">
				<tr><th colspan="3"><h1 class=" display-4 badge-danger">
				  <center>Defaulters-1</center></b></h1></th></tr>
				<tr><th colspan="3"><h4 align="center" class="display-7">Attendance less than 75% but more than 50%</b></h4></th></tr>
				<?php
				if(sizeof($att75)==0)
				{
				$fact="No students fall under this category";
				echo '<tr><td colspan="3">'.$fact.'</td></tr>';
				}
				else
				{
				echo '<tr><th><h5 class="display-7"><u>Regno.</u></h5></th><th><h5 class="display-7"><u>Name</u></h5></th><th><h5 class="display-7"><u>Attendance</u></h5></th></tr>';
				for($a=0;$a<$x;$a++)
				{
				$id=$att75[$a];
				$cmd="select name from student where stu_id='$id'";
				$res=mysqli_query($con,$cmd);
				if(mysqli_num_rows($res)>0)
				{ 
				$row=mysqli_fetch_array($res);
				$name=$row['name'];
				echo '<tr><td>'.$id.'</td><td>'.$name.'</td><td><center>'.$prc75[$a].'%</center></td></tr>';
				}
				}
				}
				?>
				</table>
				</div></div>
				<div class="col-md-2">
				</div>
				<div class="col-md-5" >
                <div class="content jumbotron mb-5" >
				<table class=" table table-stripped table-responsive">
				<tr><th colspan="3"><h1 class="display-4 badge-danger"><center>Defaulters-2</center></b></h1></th></tr>
				<tr><th colspan="3"><h4 align="center" class="display-7">Attendance less than 50%</b></h4></th></tr>
				<?php
				if(sizeof($att50)==0)
				{
				$fact="No students have less than 50% attendance";
				echo '<tr><td colspan="3">No students fall under this category</td></tr>';
				}
				else
				{
				echo '<tr><th><h5 class="display-7"><u>Regno.</u></h5></th><th><h5 class="display-7"><u>Name</u></h5></th><th><h5 class="display-7"><u>Attendance</u></h5></th></tr>';
				for($a=0;$a<$y;$a++)
				{
				$id=$att50[$a];
				$cmd="select name from student where stu_id='$id'";
				$res=mysqli_query($con,$cmd);
				if(mysqli_num_rows($res)>0)
				{ 
				$row=mysqli_fetch_array($res);
				$name=$row['name'];
				echo '<tr><td>'.$id.'</td><td>'.$name.'</td><td><center>'.$prc50[$a].'%</center></td></tr>';
				}
				}
				}
				?>
				</table>
				</div></div></div></div>
				</form>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery-3.3.1.slim.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.js"></script>
</body>
</html>
