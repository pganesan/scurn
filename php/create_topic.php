<?php
//create_cat.php
include 'DBUtil.php';
session_start();

$conObj = new DBUtil();
$conObj -> connect();

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	//the form hasn't been posted yet, display it
	//retrieve the categories from the database for use in the dropdown
	$sql = "SELECT  
                    cat_id,  
                    cat_name,  
                    cat_description  
                FROM  
                    forum_categories";

	$result = $conObj -> select($sql);

	if (!$result) {
		//the query failed.
		echo 'Error while selecting from database. Please try again later.';
	} else {
		if (mysql_num_rows($result) == 0) {
			//there are no categories, so a topic can't be posted
			echo 'You have not created categories yet. Please create a category first before creating topic';
		} else {
			echo '<form action="create_topic.php" method="post" id="createTopicForm" name="createTopicForm">';
			echo '<p id="createTopicError" class="ui-state-error ui-corner-all">';
			echo '<span class="ui-icon ui-icon-alert"></span>';
			echo '<span>Fields marked with * are required</span>';
			echo '</p>';
			echo 'Topic*<br/><input type="text" name="topic_subject" id="topic_subject" value="" size="40" maxlength="40" />';
			echo '<br />';
			echo '<br />';
			echo 'Category';
			echo '<br/>';
			echo '<select name="topic_cat" id="topic_cat">';
			// All the categories listed here in a combo
			while ($row = mysql_fetch_assoc($result)) {
				echo '<option value="' . $row['cat_id'] . '">' . $row['cat_name'] . '</option>';
			}
			echo '</select>';
			echo '<br />';
			echo '<br />';
			echo 'Message*';
			echo '<br/>';
			echo '<textarea name="post_content" id="post_content" rows="4" cols="60"/></textarea>';
			echo '</form>';
		}
	}
} else {
	//start the transaction
	$query = "BEGIN WORK;";
	$result = mysql_query($query);

	if (!$result) {
		echo 'An error occured while creating your topic. Please try again later.';
	} else {
		//the form has been posted, so save it
		//insert the topic into the topics table first, then we'll save the post into the posts table
		$sql = "INSERT INTO  
                    forum_topics(topic_subject,  
                           topic_date,  
                           topic_cat,  
                           topic_by)  
                  VALUES('" . mysql_real_escape_string($_POST['topic_subject']) . "',  
                           NOW(),  
                           " . mysql_real_escape_string($_POST['topic_cat']) . ",  
                           " . $_SESSION['memberID'] . ")";

		$result = $conObj -> insert($sql);
		if (!$result) {
			//something went wrong, display the error
			echo 'An error occured while inserting your data. Please try again later.' . mysql_error();
			$sql = "ROLLBACK;";
			$result = mysql_query($sql);
		} else {
			//the first query worked, now start the second, posts query
			//retrieve the id of the freshly created topic for usage in the posts query
			$topic_id = mysql_insert_id();

			$sql = "INSERT INTO  
                        forum_posts(post_content,  
                              post_date,  
                              post_topic,  
                              post_by)  
                       VALUES  
                        ('" . mysql_real_escape_string($_POST['post_content']) . "',  
                              NOW(),  
                              " . $topic_id . ",  
                              " . $_SESSION['memberID'] . "  
                        )";
			$result = $conObj -> insert($sql);

			if (!$result) {
				//something went wrong, display the error
				echo 'An error occured while inserting your post. Please try again later.' . mysql_error();
				$sql = "ROLLBACK;";
				$result = mysql_query($sql);
			} else {
				$sql = "COMMIT;";
				$result = mysql_query($sql);

				echo 'A topic <b>'.$_POST['topic_subject'].'</b> has been created. Please choose the category from Forum Index to view the topic';
			}
		}
	}
}

$conObj->close();
session_write_close();
?>
