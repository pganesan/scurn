<?php   
//create_cat.php   
include 'DBUtil.php'; 
session_start();
$conObj = new DBUtil();
$conObj ->connect();

// Following code checks if the user has logged in before creating the category.
// isset — Determine if a variable is set and is not NULL.
// isset() will return TRUE only if all of the parameters are set.

/*if (!isset($_SESSION)) 
{   
    //the user is not signed in   
    echo 'Sorry, you have to be <a href="../php/login.php">signed in</a> to create a category.'; 
	echo '<br />';
    echo '<br />';  
}  
else
{ */ 
if($_SERVER['REQUEST_METHOD'] != 'POST') {
	//the form hasn't been posted yet, display it
?>

<form action="create_category.php" method="post" id="createCatForm" name="createCatForm">
	<p id="createCatError" class="ui-state-error ui-corner-all">
		<span class="ui-icon ui-icon-alert"></span>
		<span>Fields marked with * are required</span>
	</p>	
	Category name*
	<br/>
	<input type="text" name="cat_name" id="cat_name" value="" size="40" maxlength="40"/>
	<br />
	<br />
	Category description*
	<br />
	<textarea name="cat_description" id="cat_description" rows="4" cols="60"></textarea>
</form>
<?php
} else {
	//the form has been posted, so save it
	$sql = "INSERT INTO forum_categories(cat_name, cat_created_on, cat_description)
	VALUES('" . mysql_real_escape_string($_POST['cat_name']) . "',
	NOW(),
	'" . mysql_real_escape_string($_POST['cat_description']) . "')";
	$result = $conObj -> insert($sql);
	echo 'A new category <b>'.$_POST['cat_name']."</b> has been added to the forum. You may choose the category from the Forum Index";
}

//}
$conObj->close();
session_write_close();

?>
	