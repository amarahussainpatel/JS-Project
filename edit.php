<html>
<h1>Editing profile for UMSI</h1>
<?php
session_start();
$db = mysqli_connect("localhost","root","root","Wk1project") or die("couldnot connect");
$profileid=$_GET['profile_id'];   
$bool = true;
$email="123@a";
$try1=mysqli_query($db,"SELECT first_name,last_name,email,headline,summary FROM profile where profile_id='$profileid'");
$row1=mysqli_num_rows($try1);

while($res1=mysqli_fetch_assoc($try1)){
$firstname=$res1['first_name'];
$lastname=$res1['last_name'];
$email=$res1['email'];
$headline=$res1['headline'];
$summary=$res1['summary'];
};

$sqlquery=mysqli_query($db,"SELECT year,description,rank from position where profile_id ='$profileid' ORDER BY rank"); 
$row1=mysqli_num_rows($sqlquery);
$positions=array();
while($res1=mysqli_fetch_array($sqlquery)){
	$positions[]=$res1;
}

?>
<?php
if(isset($_POST['submit'])){
    $firstname = mysqli_real_escape_string($db,$_POST['first_name']);
    $lastname = mysqli_real_escape_string($db,$_POST['last_name']);
    $email=mysqli_real_escape_string($db,$_POST['email']);
    $headline= mysqli_real_escape_string($db,$_POST['headline']);
	$summary= mysqli_real_escape_string($db,$_POST['summary']);
	for($i=1;$i<=9;$i++){
		// $year= mysqli_real_escape_string($db,$_POST['year'.$i]);
	    // $desc= mysqli_real_escape_string($db,$_POST['desc'.$i]);
		if(!isset($_POST['year'.$i])) continue;
		if(!isset($_POST['desc'.$i])) continue;
		$year=	$_POST['year'.$i];
		$desc=$_POST['desc'.$i];
		if(strlen($year)==0 || strlen($desc)==0){
			?> <html> <p style="color: red;"> All fields are required </p> </html> <?php 
			$bool=false;
		}
		if(! is_numeric($year)){
			?> <html> <br> </html> <?php
			?> <html> <p style="color: red;"> Position Year must be numeric </p> </html> <?php 
			$bool=false;
		}
	}
	if(!empty($firstname) && !empty($lastname) && !empty($email) && !empty($headline) && !empty($summary) && $bool==true){
	if(strpos($email,'@') !== false){
    $query=mysqli_query($db,"UPDATE profile SET first_name='$firstname',last_name='$lastname',email='$email',headline='$headline',summary='$summary' where profile_id='$profileid'");
	$sqlquery=mysqli_query($db,"DELETE FROM position where profile_id='$profileid'");
	$rank=1;
	for($i=1;$i<=9;$i++){
		
		if(! isset($_POST['year'.$i])) continue;
		if(! isset($_POST['desc'.$i])) continue;
	
		$year=$_POST['year'.$i];
		$desc=$_POST['desc'.$i];
		$sql="INSERT INTO position (profile_id,rank,year,description) VALUES ('$profileid','$rank','$year','$desc')";
		mysqli_query($db,$sql);
		// $rank++;
		// $stmt=$pdo->prepare("INSERT INTO position(profile_id,rank,year,description) values ( :pid, :rank, :year, :desc)");
		// $stmt->execute(array(
		// 	':pid'=> $profileid,
		// 	':rank' => $rank,
		// 	':year' => $year,
		// 	':desc' => $desc
		// ));
		$rank++;
	}
	$messs = "Updated Succesfully.";
	echo "<script type='text/javascript'>alert('$messs');</script>";
	$_SESSION['position']=$email; 
    header("Location: ./index.php");
}
else{
	echo "Email must contain '@'";
}
}
}
if(isset($_POST['cancel'])){
    header("Location: ./index.php");
}
?>

<html>
<head>
<script src="./node_modules/jquery/dist/jquery.min.js"></script>
</head>
<div id="container">
<body>
<title>Amara Hussain</title>
<br>
<br>
<br>
<form method="POST">
	<label>First Name:</label>
	<input type="text" name="first_name" id="fname" size="60" value=<?php echo $firstname ?>>
	<br>
	<br>
	<label>Last Name:</label>
	<input type="text" name="last_name" id="lname" size="60" value=<?php echo $lastname ?>>
	<br>
	<br>
	<label>Email:</label>
	<input type="text" name="email" id="email" size="60" value=<?php echo $email ?>>
	<br>
	<br>
	<label>Headline:</label>
	<input type="text" name="headline" id="hd" size="60" value=<?php echo $headline ?>>
	<br>
	<br>
	<label>Summary:</label>
	<input type="text" name="summary" id="sum" size="60" value=<?php echo $summary ?>>
	<br>
	<!-- <p> Position <input type="submit" id="addpos" value="+"> </p>
	<div id="position_fields">
	</div> -->
	<?php
	$pos=0;
	echo('<p> Position <input type="submit" id="addpos" value="+">'."\n");
	echo ('<div id="position_fields">'."\n");
	foreach($positions as $position){
		$pos++;
		echo('<div id="position'.$pos.'">'."\n");
		echo('<p>Year: <input type="text" name="year'.$pos.'"');
		echo('value="'.$position['year'].'"/>'."\n");
		echo('<input type="button" value="-"');
		echo('onclick="$(\'#position'.$pos.'\').remove(); return false;">'."\n");
		echo("\n");
		echo("<br>");
		echo("<br>");
		echo('<textarea type="text" name="desc'.$pos.'" rows="8" cols="80">');
		echo(''.$position['description'].'</textarea>'."\n");
		echo("</div>");
	}
	echo("</div></p>\n");
	?>
	<br>
	<input type="submit" name="submit" value="Save">
	<input type="submit" name="cancel" value="Cancel">

	<script>
countPos= <?= $pos ?>;

$(document).ready(function(){
	$('#addpos').click(function(event){
		event.preventDefault();
if(countPos >= 9){
	alert("Maximum of nine positions allowed");
	return;
}
countPos++;
$('#position_fields').append(
	'<div id="position'+countPos+'">  \
	<p> Year: <input type="text" name="year'+countPos+'" value="" /> \
	<input type="button" id="minpos" value="-" \
	onclick="$(\'#position'+countPos+'\').remove();return false;" >  </p> \
	<textarea name="desc'+countPos+'" rows="8" cols="80"></textarea> \
	</div>'); 
	});
});

</script> 
</form>
</div>
</body>
</html>