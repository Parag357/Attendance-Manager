  <?php
  $branch = $_GET['opt1'];
  
  if ($opt == 'Branch')
  	{
		
	}
	else
	{
		include ('conn.php');
		$sql = "SELECT distinct subject FROM course WHERE branch = '$branch'";
		$res = $con->query($sql);
		if($res->num_rows > 0)
		{
			$html = '<option value="Subject">Subject</option>';
			while($r = $res->fetch_assoc())
		{
			$sub = $r['subject'];
			
			
			$html .= '<option value="'.$sub.'">'.$sub.'</option>';
		}
			echo $html;
		}
		else
		{
			echo '<option value="Subject">Subject</option>';
		}
	}
?>