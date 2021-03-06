<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>SCURN - Santa Clara University Recycling Network</title>
		<link rel="stylesheet" type="text/css" href="../lib/jquery-ui.css"/>
		<link rel="stylesheet" type="text/css" href="../css/scurn.css"/>
		<script src="../lib/jquery.js" type="text/javascript"></script>
		<script src="../lib/jquery-ui.js" type="text/javascript"></script>
		<script src="../js/scurn.js" type="text/javascript"></script>
		<script src="../js/utility.js" type="text/javascript"></script>
	</head>
	<body>
		<div id="fb-root"></div>
		<script>
			( function(d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if(d.getElementById(id)) {
					return;
				}
				js = d.createElement(s);
				js.id = id;
				js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=310578175627018";
				fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
		</script>		
		<div id="header">
			<table summary="header" width="100%">
				<tr>
					<td width="15%"><img id=logo alt="Site logo" src="../images/scurn.png" /></td>
					<td class="title">SCURN - Santa Clara University Recycling Network</td>
					<td width="15%">
					<button id="signin">
						Sign in
					</button></td>
				</tr>
			</table>
		</div>
		<div id="loginbox" class="ui-widget-content ui-corner-all"></div>
		<div id="registerDialog" title="Member Registration"></div>
		<div id="profileDialog" title="Member Profile"></div>
		<div id="createCatDialog" title="Create Category"></div>
		<div id="createTopicDialog" title="Create Topic"></div>
		<div class="scurnInfo" title=""></div>
		<div id="content">
			<div class="scurnbg">
				<img src="../images/capture1.jpg" height="100%" width="100%"/>
			</div>
			<div id="menu">
				<ul>
					<li>
						<a href="home.php">Home</a>
					</li>
					<li>
						<a href="scurnproducts.php">Our Products</a>
					</li>
					<li>
						<a href="scurnforum.php">Forum</a>
					</li>
					<li>
						<a href="scurnquiz.php">Quiz</a>
					</li>
					<li>
						<a href="recycle_map.php">Locate a Recycling Station</a>
					</li>
				</ul>
			</div>
			<div class="scurnbg"><img src="../images/capture2.jpg" height="100%" width="100%"/>
			</div>
		</div>
		<div id="footer">
			<p id="copyright">
				&copy; The content of these web pages is not generated by and does not represent the views of Santa Clara University or
				any of its departments or organizations.				
			</p>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<div class="fb-like" data-href="http://localhost/" data-send="false" data-layout="standard" data-width="200" data-show-faces="false"></div>
		</div>
	</body>
</html>
