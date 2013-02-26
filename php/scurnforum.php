<?php
include 'DBUtil.php';
session_start();
?>
<form action="view_category.php" method="post" id ="scurnforum" name="scurnforum">
<?php
	$conObj = new DBUtil();
	$conObj -> connect();

	echo '<h2 style="color:#79101a;">Forum Index</h2>';

	$sql = "SELECT  
            cat_id,  
            cat_name,  
            cat_description,
            cat_created_on 
        FROM 
            forum_categories";

	$result = $conObj -> select($sql);

	if (!$result) {
		echo 'The categories could not be displayed, please try again later.';
	} else {
		if (mysql_num_rows($result) == 0) {
			echo 'No categories defined yet.';
		} else {
			//prepare the table
			echo '<br />';
			echo '<table rules="all" class="forumTable">  
              <tr>  
                <th>Category</th>  
                <th>Description</th>  
                <th>Created On</th>
              </tr>';

			while ($row = mysql_fetch_assoc($result)) {
				echo '<tr>';
				echo '<td width="33%">';
				echo '<a href="view_category.php?id=' . $row['cat_id'] . '">' . $row['cat_name'] . '</a>';
				echo '</td>';
				echo '<td width="39%">';
				echo $row['cat_description'];
				echo '</td>';
				echo '<td width="28%">';
				echo date('m/d/Y g:i A', strtotime($row['cat_created_on']));
				echo '</td>';				
				echo '</tr>';
			}
			echo '</table>';
		}
	}
	echo '<br />';
	if (isset($_SESSION['memberID'])) {
	?>
		<button id="createtopic">
			<span class="ui-icon ui-icon-note"></span>Create New Topic
		</button>
		&nbsp;&nbsp;
		<button id="createcat">
			<span class="ui-icon ui-icon-suitcase"></span>Create New Category
		</button>
	<?php
	} else {
		// cannot post to forum
		echo '<p class="ui-state-highlight ui-corner-all">
		<span class="ui-icon ui-icon-info"></span>
		<span>Please log in to create a new category or topic. If you are not a member, we encourage you to sign up. It\'s free!</span>
		</p>';
	}

	$conObj->close();
	session_write_close();
	?>
</form>
