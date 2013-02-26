<?php
include 'DBUtil.php';
?>
<form action="view_category.php" method="post" id ="scurnViewCatForum" name="scurnViewCatForum">
<?php
$conObj = new DBUtil();
$conObj -> connect();
//first select the category based on $_GET['cat_id']

$sql = "SELECT  
            cat_id,  
            cat_name,  
            cat_description  
        FROM  
            forum_categories  
        WHERE  
            cat_id =" . mysql_real_escape_string($_GET['id']);

$result = $conObj -> select($sql);

if (!$result) {
	echo 'The category could not be displayed, please try again later.';
} else {
	if (mysql_num_rows($result) == 0) {
		echo 'This category does not exist.';
		echo '<br />';
		echo '<br />';
	} else {
		//display category data
		while ($row = $conObj -> iterate($result)) {
			$a = $row['cat_name'];
			echo '<br />';
			echo '<h2 style="color:#79101a;">' . $a . '</h2>';
			echo '<br />';
		}

		//do a query for the topics
		$sql = "SELECT  
                    topic_id,  
                    topic_subject,  
                    topic_date,  
                    topic_cat  
                FROM  
                    forum_topics  
                WHERE  
                    topic_cat = " . mysql_real_escape_string($_GET['id']);

		$result = $conObj -> select($sql);

		if (!$result) {
			echo 'The topics could not be displayed, please try again later.';
			echo '<br />';
		} else {
			if (mysql_num_rows($result) == 0) {
				echo 'There are no topics in this category yet.';
				echo '<br />';
			} else {
				//prepare the table
				echo '<table rules="all" class="forumTable">  
                      <tr>  
                        <th>Topic</th>  
                        <th>Created at</th>  
                      </tr>';

				while ($row = $conObj -> iterate($result)) {
					echo '<tr>';
					echo '<td width="70%">';
					echo '<a href="view_topic.php?id=' . $row['topic_id'] . '">' . $row['topic_subject'] . '</a>';

					echo '</td>';
					echo '<td width="30%">';
					echo date('m/d/Y g:i A', strtotime($row['topic_date']));
					echo '</td>';
					echo '</tr>';
				}
				echo '</table>';
			}
		}
	}
}

$conObj->close();
?>
<br />
<button class="forumBack"><span class="ui-icon ui-icon-arrowreturnthick-1-w"></span>Forum Index</button> 
</form>
