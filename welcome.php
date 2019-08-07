
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Welcome Teacher</title>
<link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link href="../hope/assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU"
     crossorigin="anonymous">
	 <script type="text/javascript">
	 function showall(str)
   {
      var xmlhttp;

      if (window.XMLHttpRequest)
      {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
      }
      else
      {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }	

      xmlhttp.onreadystatechange = function() {
        if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
          document.getElementById("subjects").innerHTML = xmlhttp.responseText;
        }
      }
	  
	  xmlhttp.open("GET","load1.php?opt1="+str, true);
      xmlhttp.send();
  }
  
	 </script>
</head>
<?php
include "conn.php";
session_start();
$id=$_SESSION['id'];
$cmd="select * from profile where id='$id'";
$err="";
//echo $cmd;
$res=mysqli_query($con,$cmd);
if(mysqli_num_rows($res)>0)
{
$row=mysqli_fetch_array($res);
$name=$row['name'];
$dob=$row['dob'];
$gen=$row['gender'];
$mail=$row['mail'];
$mob=$row['mobile'];
$img=$row['photo'];
$address=$row['address'];
$designation=$row['designation'];
$department=$row['department'];
$tcode1=$row['tcode1'];
$tcode2=$row['tcode2'];
$tcode3=$row['tcode3'];
$tcode4=$row['tcode4'];
$tcode5=$row['tcode5'];
$tcode6=$row['tcode6'];
$tcode7=$row['tcode7'];
}
else
{
header("location:login.php");
}
?>
<body>
<?php
$section=$branch=$semester=$subject="";
if($_GET)
{
$section=$_GET['section'];
$semester=$_GET['semester'];
$branch=$_GET['branch'];
$subject=$_GET['subject'];
}
if(isset($_POST['submit1']))
{
$section=$_POST['section'];
$semester=$_POST['semester'];
$branch=$_POST['branch'];
$subject=$_POST['subject'];
if($branch=="Branch")
{
$err="Please choose a branch !!";
}
else if($semester=="Semester")
{
$err="Please choose a semester !!";
}
else if($section=="Section")
{
$err="Please choose a section !!";
}
else if($subject=="Subject")
{
$err="Please choose a subject !!";
}
else
{
$_SESSION['section']=$section;
$_SESSION['semester']= $semester;
$_SESSION['subject']=$subject;
$_SESSION['branch']= $branch;
/*$_SESSION['tcode1']=$tcode1;
$_SESSION['tcode2']=$tcode2;
$_SESSION['tcode3']=$tcode3;
$_SESSION['tcode4']=$tcode4;
$_SESSION['tcode5']=$tcode5;
$_SESSION['tcode6']=$tcode6;
$_SESSION['tcode7']=$tcode7;
*/
$cmd="select tcode from course where branch='$branch' and section='$section' and semester='$semester' and subject='$subject'";
$res=mysqli_query($con,$cmd);
if(mysqli_num_rows($res)>0)
{
$row=mysqli_fetch_array($res);
$tcode=$row['tcode'];
if(($tcode!=$tcode1)&&($tcode!=$tcode2)&&($tcode!=$tcode3)&&($tcode!=$tcode4)&&($tcode!=$tcode5)&&($tcode!=$tcode6)&&($tcode!=$tcode7))
{
$err="Invalid selections";
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
$err="This course is already complete for this semester";
}
else
header("location:Attendance_Update.php");
}
}
}
}
if(isset($_POST['submit2']))
{
$section=$_POST['section'];
$semester=$_POST['semester'];
$branch=$_POST['branch'];
$subject=$_POST['subject'];
if($branch=="Branch")
{
$err="Please choose a branch !!";
}
else if($semester=="Semester")
{
$err="Please choose a semester !!";
}
else if($section=="Section")
{
$err="Please choose a section !!";
}
else if($subject=="Subject")
{
$err="Please choose a subject !!";
}
else
{
$_SESSION['section']=$section;
$_SESSION['semester']= $semester;
$_SESSION['subject']=$subject;
$_SESSION['branch']= $branch;
/*$_SESSION['tcode1']=$tcode1;
$_SESSION['tcode2']=$tcode2;
$_SESSION['tcode3']=$tcode3;
$_SESSION['tcode4']=$tcode4;
$_SESSION['tcode5']=$tcode5;
$_SESSION['tcode6']=$tcode6;
$_SESSION['tcode7']=$tcode7;
*/
$cmd="select tcode from course where branch='$branch' and section='$section' and semester='$semester' and subject='$subject'";
$res=mysqli_query($con,$cmd);
if(mysqli_num_rows($res)>0)
{
$row=mysqli_fetch_array($res);
$tcode=$row['tcode'];
if(($tcode!=$tcode1)&&($tcode!=$tcode2)&&($tcode!=$tcode3)&&($tcode!=$tcode4)&&($tcode!=$tcode5)&&($tcode!=$tcode6)&&($tcode!=$tcode7))
{
$err="Invalid selections";
}
else
{
$_SESSION['back_status']=0;
header("location:display.php");
}
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
   <div class="container">
        <div class="row no-gutters">
            <div class="col-md-12">
                	<div class="content jumbotron mb-5">
					 <form action="<?php echo $_SERVER['PHP_SELF'];
						?>" method="post">
                       <table class="table-responsive">
					   <tr> <td rowspan="2"><img src="assets/images/logo.png" width="120" height="120" /></td><td colspan="7"><h1 class="display-4">Welcome <?php  echo $name ;?></h1></td></tr>
					   <tr><td><h1 class="font-italic table-dark"><?php  echo $designation ;?>, <?php  echo $department ;?> dept.</h1></td></tr>
					   </table>
                </div>
            </div>
      </div>
    </div>
	 <div class="container">
	 <div class="row no-gutters">
      <div class="col-md-5">
     <div class="jumbotron mb-5">
     <div class="col-md-12">
     <div class="card">
     <img src="<?php echo $img ;?>" class="card" height="300" width="367">
     <div class="card-body">
     <h4 class="card-title table-dark"><?php echo $name ;?></h4>
     <p class="card-text"><ul>
	  <li><?php echo $designation ;?>,<?php echo $department ;?> department</li>
     <li>E-mail : <?php echo $mail ;?></li></font>
	 <li>Phone : <?php echo $mob ;?></li>
     <li> D.O.B. : <?php echo $dob ;?></li>
     <li> Address : <?php echo $address ;?></li>
     							</ul></p>
                          </div>
                      </div>
					  </div></div></div>
			<div class="col-md-1">
			</div>
			<div class="col-md-6">
                	<div class="content jumbotron mb-5">
						<div class="row no-gutters" >
                    		<div class="col-md-12" >
                      <table class=" table table-stripped table-responsive""align="left">
					  <tr><th colspan="4"><h4 class="table-dark display-4"><center>Attendance</center> </h4></th></tr>
					  <tr><td> <select name="branch" onchange="showall(this.value,0)">
                   <option value="Branch">Branch</option>
				   <?php
				   $cmd="select distinct branch from course";
					//echo $cmd;
					$res=mysqli_query($con,$cmd);
					if(mysqli_num_rows($res)>0)
					{
					while($row=mysqli_fetch_array($res))  // loop runs till the last row
					{
					echo '<option value="'.$row['branch'].'">'.$row['branch'].'</option>';
					}
					}
				   ?>
				   </select></td>
				   <td> <select name="semester">
                   <option value="Semester">Semester</option>
				    <?php
				   $cmd="select distinct semester from course";
					//echo $cmd;
					$res=mysqli_query($con,$cmd);
					if(mysqli_num_rows($res)>0)
					{
					while($row=mysqli_fetch_array($res))  // loop runs till the last row
					{
					echo '<option value="'.$row['semester'].'">'.$row['semester'].'</option>';
					}
					}
				   ?>
				   </select></td>
				   <td> <select name="section">
                   <option value="Section">Section</option>
				    <?php
				   $cmd="select distinct section from course";
					//echo $cmd;
					$res=mysqli_query($con,$cmd);
					if(mysqli_num_rows($res)>0)
					{
					while($row=mysqli_fetch_array($res))  // loop runs till the last row
					{
					echo '<option value="'.$row['section'].'">'.$row['section'].'</option>';
					}
					}
				   ?>
				   </select></td>
				   <td> <select name="subject"id="subjects">
                   <option value="Subject">Subject</option>
				   </select></td>
				   </tr>
				   <tr><td colspan="4" align="center"><span style="color:#FF0000"><?php echo $err; ?></span></td></tr>
				   <tr><td><input type="submit" class="btn btn-dark" name="submit1" value="Update" /></td><td colspan="2" align="center"><input type="submit" class="btn btn-dark" name="submit2" value="Track Logs" /></td><td align="center" ><input type="submit" class="btn btn-danger" name="logout" value="LogOut" /></td></tr>
					  </table>
					  </form>
					  </div>
					  </div>
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
