<?php
include 'DBUtil.php';
session_start();

$dbutil = new DBUtil();
$dbutil -> connect();
$query = sprintf("select member_id, firstname, middlename,lastname from scurn_member 
				where member_uname='%s' and member_pwd='%s'", 
				mysql_real_escape_string($_POST["user"]), mysql_real_escape_string($_POST["pass"]));

$result = $dbutil -> select($query);
if ($row = $dbutil -> iterate($result)) {
	// valid user
	$_SESSION['memberID'] = $row["member_id"];
	$_SESSION['memberName'] = $row["firstname"]." ". $row["middlename"]." ". $row["lastname"];
	$_SESSION['memberUname'] = $_POST["user"];
} 
$dbutil -> close();

if ($_SESSION) {
	echo "<script>\$(\"#signin\").button(\"option\",\"label\",\"".$_SESSION["memberName"]."\");</script>";
?>

<form action="login.php" method="post" id="logout" name="logout">
	<br />
	<br />
	<p>
		Hello <span style="font-size:11pt;font-weight:bold;color:#3fa12b"><?php echo $_SESSION['memberName']?></span>
		<br /> Welcome to SCURN.
	</p>
	<br/>
	<button id="myProfile"><span class="ui-icon ui-icon-gear"></span>My Profile</button>
	&nbsp;&nbsp;&nbsp; <input type="submit" value="Sign Out" id="logoutButton" name="logoutButton" />
</form>

<?php
} else {
	header('HTTP/1.1 500 Internal Server Error');
	echo "Username/password is incorrect";
}
?>