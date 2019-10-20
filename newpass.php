
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Password Updation</title>
 <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link href="../hope/assets/css/style.css" rel="stylesheet">
   <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"  integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU"
     crossorigin="anonymous">
<?php	
session_start();
$c=0;
include "conn.php";
$id=$oldcnf="";
$id=$_SESSION['id'];
$oldcnf=$_SESSION['password'];
$cmd="select * from profile where id='$id'";
$res=mysqli_query($con,$cmd);
if(!(mysqli_num_rows($res)>0))
{
header("location:login.php");
}
?>
</head>
<?php
$old=$new=$cnf=$err=$scc=$btn_status="";
if(isset($_POST['back']))
{
header("location:login.php");
}
if(isset($_POST['submit']))
{
$old=$_POST['old'];
//$old=sha1($old);
$new=$_POST['new'];
$cnf=$_POST['cnf'];
if(empty($_POST['old']))
{
$err="please enter the current password";
}
else if(empty($_POST['new']))
{
$err="please enter the new passord";
}
else if(empty($_POST['cnf']))
{
$err="please confirm the new password";
}
else if($oldcnf!=$old)
{
$err="old password mismatch";
}
 else if($cnf!=$new)
{
$err="new password mismatch";
}
 else if($old==$new)
{
$err="nothing to update";
}
else
{
//$new=sha1($new);
$cmd="update profile set password='$new' where id= $id";
if(mysqli_query($con,$cmd))
{
echo "<script>alert('password updated successfully')</script>";
$btn_status="disabled";
$old=$cnf=$new="";
}
else
{
$err="error in updation ";
}
}
}
if (isset($_POST['reset']))
{
$old=$new=$cnf="";
}
?>
<body>
<br /><br/>
  <div class="container">
        <div class="row no-gutters">
		 <div class="col md-3" >
			</div>
            <div class="col-md-6">
                <div class="content jumbotron mb-8" >
                        <div class="row no-gutters" >
                                <div class="col-md-12">
                       <form action="<?php echo $_SERVER['PHP_SELF'];
?>" method="post">
<table class="table responsive table table-stripped">
<tr><th colspan="3" align="center"> <center><img src="assets/images/logo.png" alt="logo" width="120"height="120"></center></th></tr>
<tr><th colspan="3"><h3 style="font-size:medium"><center>Please create a strong password between 8-16 characters using uppercase, special characters and numbers<br /></center></h3></th></tr>
<tr><td>Current password</td><td colspan="2"><input type="password" name="old" value="<?php echo $old; ?>" placeholder="Enter current password" /></td></tr>
<tr><td>New password</td><td colspan="2"><input type="password" name="new" value="<?php echo $new; ?>"  placeholder="Enter new password" /></td></tr>
<tr><td>Confirm new password</td><td colspan="2"><input type="password" name="cnf" value="<?php echo $cnf; ?>"  placeholder="Confirm new password" /></td></tr>
<tr><td colspan="3" align="center"><span style="color:#FF0000"><?php echo $err; ?></span></td></tr>
<tr><td><input type="submit" class="btn btn-dark" name="back" value="Back"/></td><td>
  <input type="submit" class="btn btn-dark" name="reset" value="Reset" <?php echo $btn_status;?> />
</td><td align="right"><input type="submit" class="btn btn-dark" name="submit" value="OK" <?php echo $btn_status;?> /></td></tr>
</table>
</form>

                        </div>
                     </div>
                </div>
        </div>
		<div class="col md-3" >
			</div>
      </div>
    </div>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery-3.3.1.slim.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.js"></script>
</body>
</html>
