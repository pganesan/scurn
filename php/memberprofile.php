<?php
include 'DBUtil.php';

session_start();
$dbutil = new DBUtil();
$dbutil -> connect();

if (isset($_GET["update"])) {
	foreach ($_POST as $key => $value) { 
		$_POST[$key] = mysql_real_escape_string($value); 
	} 
	
	// insert scurn member info
	$query = "update scurn_member set firstname='".$_POST['fname']."',middlename='".$_POST['mname'].
				"',lastname='".$_POST['lname']."',member_addr1='".$_POST['addr']."',city='".$_POST['city'].
				"',state='".$_POST['state']."',zipcode=".$_POST['zip'].",email='".$_POST['email'].
				"',phone='".$_POST['phone']."',member_pwd='".$_POST['pwd']."' where member_id = ".$_SESSION["memberID"];
	$dbutil -> update($query);		
			
	if ($_POST["cardnum"] != "") {
		// insert member payment info
		$query = "update member_payment set card_type='".$_POST['cardtype']."',card_number='".$_POST['cardnum'].
				"',card_name='".$_POST['cardHolderName']."',exp_mm=".$_POST['expMM'].",exp_y=".$_POST['expYr'].
				" where member_id = ".$_SESSION["memberID"];
		
		$dbutil -> update($query);					
	} else {
		// insert member payment info
		$query = "delete from member_payment where member_id = ".$_SESSION["memberID"];
		
		$dbutil -> delete($query);					
	}
	
	echo "Your Member Profile has been updated successfully.";		
} else {
	$query = sprintf("select m.firstname,m.middlename,m.lastname,m.member_addr1,m.city,m.state,
						m.zipcode,m.email,m.phone,m.member_uname,m.member_pwd,p.card_type,p.card_number,
						p.card_name,p.exp_mm,p.exp_y from scurn_member m 
						LEFT JOIN member_payment p on m.member_id = p.member_id
						where m.member_id = %s", 
					mysql_real_escape_string($_SESSION["memberID"]));
	
	$result = $dbutil -> select($query);
	$row = $dbutil -> iterate($result);
?>

<form action="memberprofile.php?update" method="post" id="scurnprofile" name="scurnprofile">
	<p id="profileError" class="ui-state-error ui-corner-all">
		<span class="ui-icon ui-icon-alert"></span>
		<span>Click on the 'Update' button to submit changes to your profile</span>
	</p>
	<fieldset title="Profile Information">
		<legend>
			Profile Information
		</legend>
		<table summary="profile">
			<tr>
				<td><label for="fname">First Name*</label></td>
				<td>
				<input type="text" name="fname" id="fname" value="<?php echo $row['firstname'];?>" size="20" maxlength="20"/>
				</td>
				<td><label for="mname">Middle Name</label></td>
				<td>
				<input type="text" name="mname" id="mname" value="<?php echo $row['middlename'];?>" size="20" maxlength="20"/>
				</td>
				<td><label for="lname">Last Name*</label></td>
				<td>
				<input type="text" name="lname" id="lname" value="<?php echo $row['lastname'];?>" size="20" maxlength="20"/>
				</td>
			</tr>
			<tr>
				<td><label for="addr">Address*</label></td>
				<td colspan="3">
				<input type="text" name="addr" id="addr" value="<?php echo $row['member_addr1'];?>" size="60" maxlength="60"/>
				</td>
				<td><label for="city">City*</label></td>
				<td>
				<input type="text" name="city" id="city" value="<?php echo $row['city'];?>" size="20" maxlength="20"/>
				</td>
			</tr>
			<tr>
				<td><label for="state">State*</label></td>
				<td>
				<input type="text" name="state" id="state" value="<?php echo $row['state'];?>" size="3" maxlength="2"/>
				</td>
				<td><label for="zip">Zip Code*</label></td>
				<td>
				<input type="text" name="zip" id="zip" value="<?php echo $row['zipcode'];?>" size="5" maxlength="5"/>
				<span class="tiny">(xxxxx)</span></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td><label for="email">Email*</label></td>
				<td>
				<input type="text" name="email" id="email" value="<?php echo $row['email'];?>" size="40" maxlength="40"/>
				</td>
				<td colspan="2"><span class="tiny">(abc@xyz.com)</span></td>
				<td><label for="phone">Phone</label></td>
				<td>
				<input type="text" name="phone" id="phone" value="<?php echo $row['phone'];?>" size="13" maxlength="12"/>
				<span class="tiny">(xxx-xxx-xxxx)</span></td>
			</tr>
		</table>
	</fieldset>
	<br />
	<fieldset title="Change Password">
		<legend>
			Change Password
		</legend>
		<table summary="account">
			<tr>
				<td><label for="uname">User Name*</label></td>
				<td>
				<input type="text" name="uname" id="uname" value="<?php echo $row['member_uname'];?>" size="20" maxlength="20" disabled="true"/>
				</td>
				<td>&nbsp;&nbsp;</td>
				<td><label for="pwd">Password*</label></td>
				<td>
				<input type="password" name="pwd" id="pwd" value="<?php echo $row['member_pwd'];?>" size="20" maxlength="20"/>
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
					<?php
					$cards = array("Master Card","VISA");
					for ($i=0; $i < count($cards); $i++) { 
						if ($row['card_type'] == $cards[$i]) {
							echo "<option selected value=\"$cards[$i]\">$cards[$i]</option>";
						} else {
							echo "<option value=\"$cards[$i]\">$cards[$i]</option>";
						}						
					}
					?>
				</select></td>
				<td>&nbsp;&nbsp;&nbsp;<label for="cardnum">Card Number&nbsp;</label></td>
				<td>
				<input type="text" name="cardnum" id="cardnum" value="<?php echo $row['card_number'];?>" size="22" maxlength="19"/>
				<span class="tiny">(xxxx-xxxx-xxxx-xxxx)</span></td>
				<td>&nbsp;&nbsp;&nbsp;<label for="expMM">Expiration Date&nbsp;</td></label></td>
				<td>
				<select id="expMM" name="expMM">
					<?php
					for ($z = 1; $z < 13; $z++) {
						if ($row['exp_mm'] == $z) {
							echo "<option selected value=\"$z\">$z</option>";
						} else {
							echo "<option>$z</option>";
						}
					}
					?>
				</select>
				<select id="expYr" name="expYr">
					<?php
					for ($y = 2011; $y < 2020; $y++) {
						if ($row['exp_y'] == $y) {
							echo "<option selected value=\"$y\">$y</option>";
						} else {
							echo "<option>$y</option>";
						}
					}
					?>
				</select><span class="tiny">(only month and year required)</span></td>
			</tr>
			<tr>
				<td colspan="2"><label for="cardHolderName">Card Holder's Name</label></td>
				<td colspan="4">&nbsp;&nbsp;&nbsp;
				<input type="text" name="cardHolderName" id="cardHolderName" value="<?php echo $row['card_name'];?>" size="40" maxlength="40"/>
				<span class="tiny">(as it appears on the credit card)</span></td>
			</tr>
		</table>
	</fieldset>
</form>
<?php
}

$dbutil ->close();
session_write_close();
?>