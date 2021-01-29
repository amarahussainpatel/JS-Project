<?php
session_start();
$profileid=$_GET['profile_id'];   

$db = mysqli_connect("localhost","root","root","Wk1project") or die("couldnot connect");

$try1=mysqli_query($db,"SELECT first_name,last_name FROM profile where profile_id='$profileid'");
$row1=mysqli_num_rows($try1);

while($res1=mysqli_fetch_assoc($try1)){
$firstname=$res1['first_name'];
$lastname=$res1['last_name'];
}

if(isset($_POST['submit'])){
    $try1=mysqli_query($db,"DELETE FROM profile where profile_id='$profileid'");
    $messs = "DELETED Succesfully.";
    echo "<script type='text/javascript'>alert('$messs');</script>";
    header("Location: ./index.php");
}
if(isset($_POST['cancel'])){
    header("Location: ./index.php");
}
?>

<html>
<title>Amara Hussain</title>
<form method="POST">
	<h1>
		Deleting Profile
	</h1>
	<p>First Name:
		<?php echo $firstname ?>
	</p>
	<p>Last Name:
		<?php echo $lastname ?>
	</p>
	<input type="submit" name="submit" value="Delete">
	<input type="submit" name="cancel" value="Cancel">
</form>

</html>