<?php
include 'DBUtil.php';

if (isset($_GET["validate"])) {
	$dbutil = new DBUtil();
	$dbutil -> connect();
	$query = sprintf("select 1 from scurn_member where member_uname='%s'", 
					mysql_real_escape_string($_POST["uname"]));
	
	$result = $dbutil -> select($query);
	if ($row = $dbutil -> iterate($result)) {
		// username already exists
		header('HTTP/1.1 500 Internal Server Error');
		echo "Username already exists. Please choose another user name.";				
	} else {
		foreach ($_POST as $key => $value) { 
    		$_POST[$key] = mysql_real_escape_string($value); 
  		} 
		
		// insert scurn member info
		$query = sprintf("insert into scurn_member(firstname,middlename,lastname,member_addr1,
						city,state,zipcode,email,phone,member_pwd,member_uname) 
						values('".$_POST['fname']."','".$_POST['mname']."','".$_POST['lname']."','".
						$_POST['addr']."','".$_POST["city"]."','".$_POST["state"]."',".$_POST['zip'].",'".$_POST['email']."','".
						$_POST['phone']."','".$_POST['pwd']."','".$_POST['uname']."')");
		$memberID = $dbutil -> insert($query);		
				
		if ($_POST["cardnum"] != "") {
			// insert member payment info
			$query = sprintf("insert into member_payment(member_id,card_type,card_number,card_name,exp_mm,exp_y) 
							values(".$memberID.",'".$_POST['cardtype']."','".$_POST['cardnum'].
							"','".$_POST['cardHolderName']."',".$_POST['expMM'].",".$_POST['expYr'].")");
			
			$dbutil -> insert($query);		
				
		}
		echo "Thank you for registering with SCURN. Your username is <strong>".$_POST["uname"].
			"</strong>. Please log in to purchase products and participate in forum discussions.";		
	}
	
	$dbutil -> close();	
} else {
?>

<form action="scurnregister.php?validate" method="post" id="scurnregister" name="scurnregister">
	<p id="registerError" class="ui-state-error ui-corner-all">
		<span class="ui-icon ui-icon-alert"></span>
		<span>Fields marked with * are required</span>
	</p>
	<fieldset title="Profile Information">
		<legend>
			Profile Information
		</legend>
		<table summary="profile">
			<tr>
				<td><label for="fname">First Name*</label></td>
				<td>
				<input type="text" name="fname" id="fname" value="" size="20" maxlength="20"/>
				</td>
				<td><label for="mname">Middle Name</label></td>
				<td>
				<input type="text" name="mname" id="mname" value="" size="20" maxlength="20"/>
				</td>
				<td><label for="lname">Last Name*</label></td>
				<td>
				<input type="text" name="lname" id="lname" value="" size="20" maxlength="20"/>
				</td>
			</tr>
			<tr>
				<td><label for="addr">Address*</label></td>
				<td colspan="3">
				<input type="text" name="addr" id="addr" value="" size="60" maxlength="60"/>
				</td>
				<td><label for="city">City*</label></td>
				<td>
				<input type="text" name="city" id="city" value="" size="20" maxlength="20"/>
				</td>
			</tr>
			<tr>
				<td><label for="state">State*</label></td>
				<td>
				<input type="text" name="state" id="state" value="" size="3" maxlength="2"/>
				<span class="tiny">(state code)</span>
				</td>
				<td><label for="zip">Zip Code*</label></td>
				<td>
				<input type="text" name="zip" id="zip" value="" size="5" maxlength="5"/>
				<span class="tiny">(xxxxx)</span></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td><label for="email">Email*</label></td>
				<td>
				<input type="text" name="email" id="email" value="" size="40" maxlength="40"/>
				</td>
				<td colspan="2"><span class="tiny">(abc@xyz.com)</span></td>
				<td><label for="phone">Phone</label></td>
				<td>
				<input type="text" name="phone" id="phone" value="" size="13" maxlength="12"/>
				<span class="tiny">(xxx-xxx-xxxx)</span></td>
			</tr>
		</table>
	</fieldset>
	<br />
	<fieldset title="Account Information">
		<legend>
			Account Information
		</legend>
		<table summary="account">
			<tr>
				<td><label for="uname">User Name*</label></td>
				<td>
				<input type="text" name="uname" id="uname" value="" size="20" maxlength="20"/>
				</td>
				<td><span class="tiny">(Allowed a-z,0-9,_)&nbsp;&nbsp;&nbsp;</span></td>
				<td><label for="pwd">Password*</label></td>
				<td>
				<input type="password" name="pwd" id="pwd" value="" size="20" maxlength="20"/>
				</td>
				<td></td>
			</tr>
		</table>
	</fieldset>
	<br />
	<fieldset title="Billing Information">
		<legend>
			Billing Information
		</legend>
		<table summary="billing">
			<tr>
				<td><label for="cardtype">Card Type&nbsp;</label></td>
				<td>
				<select id="cardtype" name="cardtype" size="1">
					<option value="Master Card">Master Card</option>
					<option value="VISA">VISA</option>
				</select></td>
				<td>&nbsp;&nbsp;&nbsp;<label for="cardnum">Card Number&nbsp;</label></td>
				<td>
				<input type="text" name="cardnum" id="cardnum" value="" size="22" maxlength="19"/>
				<span class="tiny">(xxxx-xxxx-xxxx-xxxx)</span></td>
				<td>&nbsp;&nbsp;&nbsp;<label for="expMM">Expiration Date&nbsp;</td></label></td>
				<td>
				<select id="expMM" name="expMM">
					<?php
					for ($z = 1; $z < 13; $z++) {
						echo "<option>$z</option>";
					}
					?>
				</select>
				<select id="expYr" name="expYr">
					<?php
					for ($y = 2011; $y < 2020; $y++) {
						echo "<option>$y</option>";
					}
					?>
				</select>
				<span class="tiny">(only month and year required)</span>
				</td>					
			</tr>
			<tr>
				<td colspan="2"><label for="cardHolderName">Card Holder's Name</label></td>
				<td colspan="4">&nbsp;&nbsp;&nbsp;
				<input type="text" name="cardHolderName" id="cardHolderName" value="" size="40" maxlength="40"/>
				<span class="tiny">(as it appears on the credit card)</span>
				</td>
		</tr>
		</table>
	</fieldset>
</form>
<?php
}
?>