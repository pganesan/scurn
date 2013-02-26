<?php
include 'DBUtil.php';
session_start();
?>
<form action="view_topic.php" method="post" id ="scurnViewTopicForum" name="scurnViewTopicForum">

<?php
	if (isset($_SESSION['memberID'])) {
		echo '<table style="margin:auto;">';
		echo '<tr>';
		echo '<td><h3>What\'s on your mind?</h3></td>';
		echo '<td><textarea name="reply-content" id="reply-content" rows="1" cols="60"/></textarea></td>';
		echo '<td vertical-align: middle>';
		echo '<button id="shareButton">
						<span class="ui-icon ui-icon-comment"></span>Share
					</button>';
		echo '</td>';
		echo '</tr>';
		echo '</table>';

	} else {
		// cannot post to forum
		echo '<p class="ui-state-highlight ui-corner-all">
				<span class="ui-icon ui-icon-info"></span>
				<span>Please log in to post to forum. If you are not a member, we encourage you to sign up. It\'s free!</span>
			  </p>';
	}

	$conObj = new DBUtil();
	$conObj -> connect();
	
	if (isset($_GET['id'])) {
		$chk_id = mysql_real_escape_string($_GET['id']);
	} else {
		$chk_id = mysql_real_escape_string($_POST['chk_id']);
		$sql = "INSERT INTO  
                    forum_posts(post_content,  
                          post_date,  
                          post_topic,  
                          post_by)  
                VALUES ('" . $_POST['reply-content'] . "',  
                        NOW(),  
                        " . $chk_id . ",  
                        " . $_SESSION['memberID'] . ")";

		$conObj -> insert($sql);
	}
	$sql = "SELECT  
    topic_id,   
    topic_subject   
FROM  
    forum_topics   
WHERE  
    topic_id = " . $chk_id;

	$result = $conObj -> select($sql);

	if (!$result) {
		echo 'The topic could not be displayed, please try again later.' . mysql_error();
	} else {
		if (mysql_num_rows($result) == 0) {
			echo 'This topic does not exist.';
		} else {
			//display topic data
			if ($row = $conObj -> iterate($result)) {
				echo '<br />';
				echo '<h2 style="color:#79101a;">' . $row['topic_subject'] . '</h2>';
			}

			//do a query for the topics
			$sql = "SELECT  
             posts.post_topic,   
             posts.post_content,   
             posts.post_date,   
             posts.post_by,   
             users.member_uname,   
             users.firstname,
             users.lastname   
             FROM forum_posts posts  
             LEFT JOIN scurn_member users
             ON posts.post_by = users.member_id   
             WHERE posts.post_topic = " . $chk_id . " order by posts.post_date desc";

			$result = $conObj -> select($sql);

			if (!$result) {
				echo 'The posts could not be displayed, please try again later.';
			} else {
				if (mysql_num_rows($result) == 0) {
					echo 'There are no posts in this topic yet.';
				} else {
					//prepare the table
					echo '<br />';
					echo '<table rules="all" class="forumTable">
                <tr>  
                	<th>Message</th>
                	<th>Posted By</th> 
                </tr>';
					while ($row = mysql_fetch_assoc($result)) {
						$user_name = $row['firstname'] . " " . $row['lastname'];
						echo '<tr>';
						echo '<td width="60%">';
						echo $row['post_content'];
						echo '</td>';
						echo '<td width="40%">';
						echo $user_name;
						echo '<br />';
						echo date('m/d/Y g:i A', strtotime($row['post_date']));
						echo '</td>';
						echo '</tr>';

					}

					echo '</table>';
					echo '<input type="hidden" value="' . $chk_id . '" size="1" name="chk_id" id="chk_id" />';
				}
			}
		}
	}

	$conObj->close();
	session_write_close();
?>
<br />
<button class="forumBack"><span class="ui-icon ui-icon-arrowreturnthick-1-w"></span>Forum Index</button> 
</form>
