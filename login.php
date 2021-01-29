<?php
session_start();
if(isset($_SESSION['email'])){
	unset($_SESSION['email']);
}
$db = mysqli_connect("localhost","root","root","wk1project") or die("couldnot connect");

$email="1";
$pass="3";
$dbpass="";
$dbemail="1";
$bool=false;
$rows=0;


if(isset($_POST['login'])){

    $email = mysqli_real_escape_string($db,$_POST['email']);
    $pasw = mysqli_real_escape_string($db,$_POST['pass']);

	$salt='XyZzy12*_';
	$pass=hash('md5', $salt.$pasw);

	$sql1=mysqli_query($db,"SELECT email,password from users");
	$rows=mysqli_num_rows($sql1);
	
    while($fetch=mysqli_fetch_assoc($sql1)){
          $dbemail=$fetch['email'];
          $dbpass=$fetch['password'];
    
    if(($email==$dbemail) && ($pass==$dbpass)){
		$_SESSION['email'] = $email;
		// $_SESSION['email'] = $fetch['email']; 
        // $_SESSION['user_id'] = $fetch['user_id'];
        $mes = "Done.";
        echo "<script type='text/javascript'> alert('$mes'); </script>";
        header("Location: ./index.php?email=$email");  
        $bool=true;      
    }
}
if($email!=$dbemail && $bool==false ){
        $mes = "Incorrect password/email.";
        echo "<script type='text/javascript'>alert('$mes');</script>";
    }
}
?>

<html>
<title>Amara Hussain</title>
<form method="POST" action="">
	<h1>Please Log In</h1>
	<label for="email">Email:</label>
	<input type="text" id="email" name="email" require>
	<br>
	<br>

	<label for="pass">Password:</label>
	<input type="password" id="psw" name="pass" onclick="return dovalidate();" require>
	<br>
	<br>

	<input type="submit" name="login" value="Log In">
	<a href="./index.php">
		<input type="button" name="cancel" value="Cancel">
	</a>
</form>

<script>
	function doValidate() {
		console.log('Validating...');
		try {
			pw = document.getElementById('psw').value;
			console.log("Validating pw=" + pw);
			em = document.getElementById('email').value;
			console.log("Validating em=" + em);
			if (em == null || em == "") {
				alert("Both fields must be filled out");
				return false;
			}
			return true;
		} catch (e) {
			return false;
		}
		return false;
	}
	javascript: window.history.forward(1);

	function cancelhref() {

	}
</script>

</html>