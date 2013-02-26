<?php include 'DBUtil.php';?>

<form action="scurnquiz.php?checkAnswer" method="post" id="scurnquiz" name="scurnquiz">
	<table class="quizTable">
	
	<?php
		if(isset($_GET['checkAnswer'])){
			$dbutil = new DBUtil();
			$dbutil -> connect();
			
			$quizQuery = $dbutil -> select("select * from scurn_quiz");
			$i = 0;
			$correct = 0;
			$incorrect = 0;
			$notAttended = 0;
			while ($quizQuestions = $dbutil->iterate($quizQuery)) {
				$i = $i + 1;	
				if(!isset($_POST['anschoice'.$i])){
					$notAttended++;
				}
				else if($quizQuestions['right_answer'] == ($_POST['anschoice'.$i])){
					$correct++;
				}
				else {
					$incorrect++;
				}
				
			}
			if ($incorrect != 0){
				echo "<p>You answered ".$correct." correct, ".$incorrect." questions wrong and did not attempt ".$notAttended." </p>";
			}
			else if($correct == 0 && $incorrect == 0){
				echo "You have not attempted any question";
			} 
			else {
				echo "<p>Congratulations you answered all the questions correct :)</p>";
			}
			echo "<p>";
			echo "<br />";
			echo "<span class='gamelink'><a href=\"http://students.engr.scu.edu/~bsivalin/wordbin/wordbin.html\" target=\"_blank\">Click Here!</a> for more such interesting games.</span>";
			echo "</p>";
		}
		
		else{
		?>
			<h2 style="text-align:center;color:#79101a">Test Your Recycling Knowledge</h2>
			<img id ="quizimage" src="../images/thinkingman.gif" alt="Recycle" height="130px" width="100px" />
			<br/>
			<p style="font-size: 10pt;">
				The following questions deal with different aspects of recycling. Click on the circle next to your answer for each question.
				When you are finshed, click on the  'score' button to see results.
			</p>
	
			<br/>
			<br/>
			<h3 style="text-align: center; color: #3fa12b"> QUESTIONS</h3>
			<br />
		<?php	
			$dbutil = new DBUtil();
			$dbutil -> connect();
			
			$quizQuery = $dbutil -> select("select * from scurn_quiz");
			$i = 0;
			while ($quizQuestions = $dbutil->iterate($quizQuery)) {
				$i = $i + 1;	
	?>
		<tr>
			<td><?php    echo $quizQuestions['q_no'] . ". " . $quizQuestions['question'];?></td>
		</tr>
		<tr>
			<td width="39%">
				<input type = "radio" name="anschoice<?php echo $i;?>" value="<?php echo $quizQuestions['answer_choice2'] ?>">
				<?php echo $quizQuestions['answer_choice2'];?>
				<br/>
				<input type = "radio" name="anschoice<?php echo $i;?>" value="<?php echo $quizQuestions['answer_choice3'] ?>">
				<?php    echo $quizQuestions['answer_choice3'];?>
				<br/>
				<input type = "radio" name="anschoice<?php echo $i;?>" value="<?php echo $quizQuestions['answer_choice4'] ?>">
				<?php    echo $quizQuestions['answer_choice4'];?>
				<br/>
				<input type = "radio" name="anschoice<?php echo $i;?>" value="<?php echo $quizQuestions['answer_choice5'] ?>">
				<?php    echo $quizQuestions['answer_choice5'];?>
	
				<br/>
				<br/>
			</td>
	</tr>
	
	<?php	
			}
	?>
	
		</table>	
		<p style="text-align:center;">	
		<input type="submit" id="submitButton" name="submitButton" value="Score" />
		<br />
		<span class="gamelink"><a href="http://students.engr.scu.edu/~bsivalin/wordbin/wordbin.html" target="_blank">Click Here!</a> for more such interesting games.</span>
		</p>
	<?php		
	}
	?>
	
</form>