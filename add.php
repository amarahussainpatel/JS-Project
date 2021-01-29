<?php
session_start();
$db = mysqli_connect("localhost","root","root","Wk1project") or die("couldnot connect");
$bool = true;
$empty=false;
$dsn = "mysql:host=localhost;dbname=Wk1project";
$user = "root";
$passwd = "root";
$pdo = new PDO($dsn, $user, $passwd);
$profileid=0;
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
			echo "All values are required";
			$bool=false;
			$empty=true;
		}

		if(!is_numeric($year) && $empty==false){
			?> <html> <br> </html> <?php
			?> <html> <p style="color: red;"> Position Year must be numeric </p> </html> <?php 
			$bool=false;
		}
	}

	if(!empty($firstname) && !empty($lastname) && !empty($email) && !empty($headline) && !empty($summary) && $bool==true){

	// $query=mysqli_query($db,"INSERT into profile(user_id,first_name,last_name,email,headline,summary) VALUES ('3','$firstname','$lastname','$email','$headline','$summary')");
	$sqlquery="INSERT into profile(user_id,first_name,last_name,email,headline,summary) VALUES ('3','$firstname','$lastname','$email','$headline','$summary')";
	if(mysqli_query($db,$sqlquery)){
	$profileid=mysqli_insert_id($db);
	
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
    $messs = "INSERTED Succesfully.";
	echo "<script type='text/javascript'>alert('$messs');</script>";
	
	$url='./index.php';
    header("Location: ".$url);
    $_SESSION['firstname']=$firstname; 
	}
}
else{
	?> <html><p color: "red">All values are required </p> </html> <?php
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
<body>
<title>Amara Hussain</title>
<h1>Adding profile for UMSI</h1>
<div class="container">
<form method="POST">
	<label>First Name:</label>
	<input type="text" name="first_name" id="fname" size="60" >
	<br>
	<br>
	<label>Last Name:</label>
	<input type="text" name="last_name" id="lname" size="60" >
	<br>
	<br>
	<label>Email:</label>
	<input type="text" name="email" id="email" size="60" >
	<br>
	<br>
	<label>Headline:</label>
	<br>
	<input type="text" name="headline" id="hd" size="60" >
	<br>
	<br>
	<label>Summary:</label>
	<br>
	<textarea type="text" name="summary" id="sum" rows="8" cols="80" ></textarea>
	<p> Position <input type="submit" id="addpos" value="+"> </p>
	<div id="position_fields">
	</div>
	<br>
	<input type="submit" name="submit" value="Add">
	<input type="submit" name="cancel" value="Cancel">
</form>

<script>
countPos=0;

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
</div>
</body>
</html>