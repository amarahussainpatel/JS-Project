<?php
session_start();
$profileid=$_GET['profile_id'];   

$db = mysqli_connect("localhost","root","root","Wk1project") or die("couldnot connect");

$try1=mysqli_query($db,"SELECT first_name,last_name,email,headline,summary FROM profile where profile_id='$profileid'");
$row1=mysqli_num_rows($try1);

while($res1=mysqli_fetch_assoc($try1)){

$firstname=$res1['first_name'];
$lastname=$res1['last_name'];
$email=$res1['email'];
$headline=$res1['headline'];
$summary=$res1['summary'];
}

$sql=mysqli_query($db,"SELECT year,description from position where profile_id='$profileid' ORDER BY rank");
$row1=mysqli_num_rows($sql);
?>
<html>
<title>Amara Hussain</title>
<h1>
	Profile Information
</h1>
<p>First Name:
	<?php echo $firstname ?>
</p>
<p>Last Name:
	<?php echo $lastname ?>
</p>
<p>Email:
	<?php echo $email ?>
</p>
<p>Headline:
	<br>
	<?php echo $headline ?>
</p>
<p>Summary:
	<br>
	<?php echo $summary ?>
</p>
<p>Position:  <ul>
<?php
while($res1=mysqli_fetch_assoc($sql)){
	?> <li> <?php echo $res1['year']." : ". $res1['description'] ?> </li> <?php
} ?>
</ul>
<br>
<br>
<a href="./index.php">Done</a>

</html>