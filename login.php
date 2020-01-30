 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
if(isset($_POST)){
$user_id=$password=$uid=$pwd=$err=$user=$radio="";
 
/*if(isset($_POST['rem'])) # the value of checkbox is used
{
if(empty($_POST['uid']))
{
$err="please enter the user-ID";
}
elseif(empty($_POST['pwd']))
{
$err="please enter a password";
}
else
{
$user_id=$_POST['uid'];
$password=$_POST['pwd'];
setcookie("user",$user_id,time()+(86400*30),"/");
setcookie("password",$password,time()+(86400*30),"/");
}
}
if(isset($_COOKIE['user'])&& isset($_COOKIE['password']))
{
$uid=$_COOKIE['user'];
$pwd=$_COOKIE['password'];
}*/
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Login Page</title>
 <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link href="../hope/assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU"
     crossorigin="anonymous">
</head>
<?php
include "conn.php";
$user="faculty";
if(isset($_POST['submit']))
{
$user=$_POST['user'];
if(empty($user))
{
$err="please select student or faculty";
}
else if(empty($_POST['uid']))
{
$err="please enter the user-ID";
}
else if(empty($_POST['pwd']))
{
$err="please enter the password";
}
else if(!preg_match("/^(?=.*\d).{1,5}$/",$_POST['uid']))// validation of name format 
{
$err="either of the above is incorrect";
}
else if(!preg_match("/^((?=.*\d)(?=.*[a-z]).{3,20})$/",$_POST['pwd']))// validation of password format 
{
$err="either of the above is incorrect";
}
else
{
$uid=secure($_POST['uid']);
$pwd=secure($_POST['pwd']);
if($user=="student")
{
$cmd1="select * from student where stu_id= '$uid' and password='$pwd'";
$res1=mysqli_query($con,$cmd1);
if(mysqli_num_rows($res1)>0)
{
$row1=mysqli_fetch_array($res1);
session_start();
$_SESSION['id']=$row1['stu_id'];
$_SESSION['password']=$row1['password'];
header("location:studisplay.php");
}
else
{
$err="either of the above is incorrect";
}
}
else
{
$cmd="select * from profile where id='$uid' and password='$pwd'";
$res=mysqli_query($con,$cmd);
if(mysqli_num_rows($res)>0)
{
$row=mysqli_fetch_array($res);
session_start();
$_SESSION['id']=$row['id'];
$_SESSION['password']=$row['password'];
header("location:welcome.php");
}
else
{
$err="either of the above is incorrect";
}
}
}
}
if (isset($_POST['reset']))
{
$uid=$pwd="";
}
// coding for password change
if (isset($_POST['change']))
{
$user=$_POST['user'];
if(empty($user))
{
$err="please select student or faculty";
}
else if(empty($_POST['uid']))
{
$err="please enter the user-ID";
}
else if(empty($_POST['pwd']))
{
$err="please enter the password";
}
else if(!preg_match("/^(?=.*\d).{1,5}$/",$_POST['uid']))// validation of name format 
{
$err="either of the above is incorrect";
}
else if(!preg_match("/^((?=.*\d)(?=.*[a-z]).{3,20})$/",$_POST['pwd']))// validation of password format 
{
$err="either of the above is incorrect";
}
else
{
$uid=secure($_POST['uid']);
$pwd=secure($_POST['pwd']);
if($user=="student")
{
$cmd1="select * from student where stu_id= '$uid' and password='$pwd'";
$res1=mysqli_query($con,$cmd1);
if(mysqli_num_rows($res1)>0)
{
$row1=mysqli_fetch_array($res1);
session_start();
$_SESSION['id']=$row1['stu_id'];
$_SESSION['password']=$row1['password'];
header("location:newpass.php");
}
else
{
$err="either of the above is incorrect";
}
}
else
{
$cmd="select * from profile where id='$uid'";
$res=mysqli_query($con,$cmd);
if(mysqli_num_rows($res)>0)
{
$row=mysqli_fetch_array($res);
session_start();
$_SESSION['id']=$row['id'];
$_SESSION['password']=$row['password'];
//echo '<a href="newpass.php">change password</a>';
header('location:newpass.php');
}
}
}
}
}
function secure($test)
{
$test=htmlspecialchars(stripslashes(trim($test)));
return $test;
}
?>
<body>
<br /><br />
  <div class="container">
        <div class="row no-gutters">
            <div class="col md-4" >
			</div>
			<div class="col md-4" >
                <div class="content jumbotron mb-5" >
                        <div class="row no-gutters" >
                                <div class="col-md-12" >
                       <form action="<?php echo $_SERVER['PHP_SELF'];
?>" method="post">
<table align="center" class="align-self-center">
<tr><th colspan="4" align="center"> <center><img src="assets/images/logo.png" alt="logo" width="120"height="120"></center></th></tr>
<!--<tr><td colspan="4"><br /></td></tr>-->
<tr><th colspan="4"><h1 class="display-4"><center>Portal<br /></center></h1></th></tr>
<tr><td colspan="2"><input type="radio" name="user" value="student" <?php echo ($user=="student")?"checked":"";?> align="left"> Student</td>
<td colspan="2"><input type="radio" name="user" value="faculty" <?php echo ($user=="faculty")?"checked":"";?> align="right"> Faculty</td></tr>
<tr><td colspan="4"><br /></td></tr>
<tr><td>ID</td><td colspan="3"><input type="text" name="uid" value="<?php echo $uid; ?>" placeholder="Enter ID" /></td></tr>
<tr><td colspan="4"><br /></td></tr>
<tr><td>Password</td><td colspan="3"><input type="password" name="pwd" value="<?php echo $pwd; ?>" placeholder="Enter password" /></td><!--<td><input type="checkbox" name="rem" class="btn-lg"/> its me</td>--></tr>
<tr><td colspan="4"><br /></td></tr>
<tr><td colspan="4" align="center"><span style="color:#FF0000"><?php echo $err; ?></span></td></tr>
<tr><td colspan="4"><br /></td></tr>
<tr><td align="left"><input type="submit" class="btn btn-dark" name="reset" value="Reset" /></td><td><input type="submit" class="btn btn-dark" name="change" value="Change Password" /></td><td align="right"><input type="submit" class="btn btn-success" name="submit" value="Login" /></td></tr>
</table>
</form>
                        </div>
                     </div>
                </div>
        </div>
		 <div class="col md-4" >
			</div>
      </div>
    </div>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery-3.3.1.slim.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.js"></script>
</body>
</html>
