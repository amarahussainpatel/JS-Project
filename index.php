<?php
session_start();
$emailid="";
$loggedIn = false;
$added=false;
$updated=false;
if(isset($_SESSION['email'])){
	$emailid = $_SESSION['email'];
	$loggedIn = true;
}
if(isset($_SESSION['firstname'])){
	// $emailid = $_SESSION['firstname'];
	$added = true;
}

// if(isset($_SESSION['position'])){
// 	$emailid = $_SESSION['position'];
// 	$updated = true;
// }


$db = mysqli_connect("localhost","root","root","Wk1project") or die("couldnot connect");

?>

<!DOCTYPE HTML>
<html>

<head>
	<title>Amara Hussain</title>
</head>

<div class="title">
	<h1> Amara Hussain's Resume Registry </h1>
	<br>
</div>
<?php if($added){?>
<p style="color: blue;"> Profile added </p>
<?php } ?>

<?php if($updated){?>
<p style="color: blue;"> Profile updated </p>
<?php } ?>

<form>
	<?php if($loggedIn){ ?>
	<a href="./login.php">Logout</a>
	<?php }
	else{ ?>
	<a id=login href="./login.php">Please log in</a>
	<?php } ?>



	<br>
	<br>
	<br>

	<table>
		<tr>
			<th>Name</th>
			<th>Headline</th>
			<?php if($loggedIn){ ?>
			<th>Action</th>
			<?php } ?>

		</tr>
		<?php
			$try1=mysqli_query($db,"SELECT first_name,last_name,headline,profile_id FROM profile");
			$row1=mysqli_num_rows($try1);
			while($res1=mysqli_fetch_assoc($try1)){
			$profileid=$res1['profile_id'] ;
			?>
		<tr>
			<td>
				<a href="./view.php?profile_id=<?php echo $profileid;?>">
					<?php 
					echo $res1['first_name']." ".$res1['last_name'];		
		?>
				</a>
			</td>
			<td>
				<?php 
					echo $res1['headline'];
			?>
			</td>
			<?php if($loggedIn){ ?>
			<td>
				<a href="./edit.php?profile_id=<?php echo $profileid;?>">Edit</a>
				<a href="./delete.php?profile_id=<?php echo $profileid;?>">Delete</a>
			</td>
			<?php }} ?>
		</tr>
	</table>
	<br>
	<br>
	<?php if($loggedIn){ ?>
	<a href="./add.php">Add New Entry</a>
	<?php } ?>
</form>

<style>
	table,
	th,
	td {
		border: 1px solid black;
	}
</style>
<script>
	javascript: window.history.forward(1);
</script>

</html>