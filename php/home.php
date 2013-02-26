<?php
include 'DBUtil.php';
?>
<form action="http://www.google.com/search" method="get" id="home" name="home" target="_blank">
	<h3> Welcome to SCURN - Santa Clara University Recycling Network. We are a small, voluntary group working
	together with students to keep our campus green. </h3>
	<br/>
	<div class="homeBox">
		<p id="recycleVideo">
			<object>
				<param name="movie" value="http://www.youtube.com/v/D8BwXp7ICs0?version=3&amp;hl=en_US&amp;rel=0">
				</param>
				<param name="allowFullScreen" value="true">
				</param>
				<param name="allowscriptaccess" value="always">
				</param>
				<embed src="http://www.youtube.com/v/D8BwXp7ICs0?version=3&amp;hl=en_US&amp;rel=0"
				type="application/x-shockwave-flash" width="280px" height="185px" allowscriptaccess="always"
				allowfullscreen="true" wmode="opaque"></embed>
			</object>
		</p>
		<br />
		<p>
			How much do you know about recycling? Test your knowledge by taking our <a id="quizLink" href="" alt="quiz">quiz</a>.
			<br />
			<br />
			Check out our forum to know how the campus students are enjoying the benefits of recycling.
			<br />
			Share your thoughts and comments! We would love to hear from you.
		</p>
	</div>
	<div class="homeBox">
		<input type="text" name="q" size="30" maxlength="255" value="" />
		<button id="googleSrch">
			<span class="ui-icon ui-icon-search"></span>Google
		</button>
		<br />
		<h3 style="color:#c16e34;">Campus news on recycling</h3>
		<div class="newsBox">
			<p>
				Can Plastic Bags Be Recycled On Campus?
			</p>
			<p>
				Plastic bags cannot be recycled on the campus, but they can be recycled in off-campus homes.
			</p>
			<p>
				<a href="http://www.scu.edu/sustainability/stewardship/recyclingfaq.cfm?c=11262" target="_blank" alt="news1">Read More &gt;&gt;</a>
			</p>
		</div>
		<div class="newsBox">
			<p>
				I have a bunch of books I don't need... what should I do?
			</p>
			<p>
				You can donate or recycle them. Please don't put them in the blue paper recycling bags.
			</p>
			<p>
				<a href="http://www.scu.edu/sustainability/stewardship/recyclingfaq.cfm?c=10415" target="_blank" alt="news2">Read More &gt;&gt;</a>
			</p>
		</div>
		<div class="newsBox" style="border: none;">
			<p>
				Paper vs Plastic: Can Laminated Paper Be Recycled?
			</p>
			<p>
				Laminated Paper cannot be recycled due to differences in the recycling process.
			</p>
			<p>
				<a href="http://www.scu.edu/sustainability/stewardship/recyclingfaq.cfm?c=10890" target="_blank" alt="news3">Read More &gt;&gt;</a>
			</p>
		</div>
	</div>
	<div class="homeBox">
		<p style="text-align: center;">
			<img src="../images/recycleBox.jpg" alt="Recycle" height="185px" width="159px"/>
			<br /><br />
			<h3>Don't forget to sign up - it is free and you will enjoy member discounts!</h3><br />
			<h4 style="color:#c16e34;">REDUCE, REUSE, RECYCLE!</h4> 
			Locate a recycling station <a id="recycleMapLink" href="" alt="here">here</a><br />			
		</p>
	</div>
</form>
