<?php
include 'DBUtil.php';
session_start();
?>

<form action="scurnreceipt.php" method="post" id="scurnorder" name="scurnorder">
	<p id="orderError" class="ui-state-error ui-corner-all">
		<span class="ui-icon ui-icon-alert"></span>
		<span></span>
	</p>
	<fieldset title="Product and Shipping Details">
		<legend>
			Product and Shipping Details
		</legend>
		<span style="font-weight: bold;font-style:italic;color: #c16e34;font-size: 14pt;text-align: center;margin-left: 5%"> <?php
		if (!isset($_SESSION['memberID'])) {
			echo "Register with us to avail a 10% discount";
		}
			?></span>
		<table cellspacing="20px" cellpadding="20px" class="orderTable">
			<tr>
				<th>Product Name</th>
				<th>Price</th>
				<th>Quantity</th>
				<th></th>
				<?php
						$isMember = 0;
						if (isset($_SESSION['memberID'])) {
							$isMember = 1;
						} else {
							$isMember = 0;
						}
						$dbutil = new DBUtil();
						$dbutil -> connect();
						$range = $_POST["ivalue"];
					
						$count = 0;
						for($j=1; $j <= $range; $j++) {
							if( isset($_POST["product$j"]) ) {
								$count=$count+1;
							}
						}

						$idnum = 0; 
						$total = 0;
						$x=0;
						for($j=1; $j <= $range; $j++) {
							if( isset($_POST["product$j"]) ) {
								$x++;
								$idnum++;
								echo "<tr>";
								echo "<td>";
								$prodId = $_POST["product$j"];
								$result = $dbutil -> select("select item_name,item_image_url,quantity,price from scurn_inventory where item_code='$prodId' ");
								$prod = $dbutil->iterate($result);
								echo $prod['item_name'];
								echo "</td>";

				?>

				<td>
				&#36; <input type="text" name="price<?php echo $idnum;?>" id="price<?php echo $idnum;?>" value="<?php echo $prod['price'];?>" readonly	="true" size="8" />
				</td>
				<td>
				<input type="hidden" id="shipcode" name="shipcode" />
				<input type="hidden" id="hiddenval" name="hiddenval" />
				<input type="hidden" name="numProducts" id="numProducts" value="<?php echo $range;?>" />
				<input type="hidden" name="itemCode<?php echo $idnum;?>" value="<?php echo $prodId;?>" />
				<select name="selected<?php echo $idnum;?>" id="selected<?php echo $idnum;?>" value="<?php echo $prodId;?>" onchange="quantValue(this.value,<?php echo $idnum;?>,<?php echo $prod['price'];?>,<?php echo $count;?>,<?php echo $isMember?>)">
					<?php
					if ($prod['quantity'] > 10) {
						$limit = 10;
					} else if ($prod['quantity'] < 10 && $prod['quantity'] != 0) {
						$limit = $prod['quantity'];
					} else if ($prod['quantity'] == 0) {
						$limit = 10;
					} else {
						$limit = 10;
					}
					for ($i = 1; $i <= $limit; $i++) {
						echo "<option id=\"quantity" . $i . "\" value=\"" . $i . "\">$i</option>";
					}
					?>
				</select></td><td valign="middle"><?php
				if ($prod['quantity'] == 0) {
					echo "&nbsp;<span style='color: #79101a; font-size: 9pt; font-weight: bold' >
						(Expect delay in shipping since the product is out of stock now.<br/>
						 You will receive an email notification when the product is available)
						</span>";
				}
				?></td>
				<?php

				$total += $prod['price'];
				}
				}
				?>
			</tr>
			<tr>
				<td class="bold">Shipping</td>
				<td colspan="3">
				<select name="shipping" id="shipping" onchange="shippingChanged(<?php echo $count;?>,<?php echo $isMember?>)">
					<option id="ship0" value="blank" selected="selected">Choose a shipping category</option>
					<?php
					$dbutil = new DBUtil();
					$dbutil -> connect();
					$ship = $dbutil -> select("select * from scurn_shipping");
					$j = 0;
					while ($shipinfo = $dbutil -> iterate($ship)) {
						$j++;
						echo "<option id=\"ship" . $j . "\" value=\"" . $shipinfo['shipping_cost'] . "\">" . $shipinfo['shipping_type'] . " $" . $shipinfo['shipping_cost'] . "</option>";
					}
					?>
				</select></td>
			</tr>
			<?php
				if ($isMember == 1) {
					$discount =  ($total*0.1);
					$tax = ($total*0.085);
					$discount = number_format($discount, 2, '.', '');
					$tax = number_format($tax, 2, '.', '');
			?>
			<tr>
				<td class="bold">Discount</td>
				<td> &#36;
				<input type="text" id="discount" name="discount" value="<?php echo $discount;?>" readonly="true" size="8" />
				</td>
				<td class="tiny">(10% of order price)</td>
				<td></td>
			</tr>
			<?php
			}
			else{
			$tax = $total * 0.085;
			$tax = number_format($tax, 2, '.', '');
			}
			?>
			<tr>
				<td class="bold">Tax</td>
				<td> &#36;
				<input type="text" id="tax" name="tax" value="<?php echo $tax;?>" readonly = "true" size="8" />
				</td>
				<td class="tiny">(8.5% of order price)</td>
				<td></td>
			</tr>
			<tr>
				<td class="bold">Total</td>
				<td colspan="3"><?php
				if (isset($discount)) {
					$ntotal = $total + $tax - $discount;
					$ntotal = number_format($ntotal, 2, '.', '');
				} else {
					$ntotal = $total + $tax;
					$ntotal = number_format($ntotal, 2, '.', '');
				}
				?>
				&#36;
				<input type="text" id="total" name="ftotal" value="<?php echo $ntotal;?>" readonly = "true" size="8" />
				</td>
			</tr>
		</table>
	</fieldset>
	<br />
	<?php
	if ($isMember == 1) {
		// get payment info from session for logged in user
		$memID = $_SESSION['memberID'];
		$dbutil = new DBUtil();
		$dbutil -> connect();
		$memInfo = $dbutil -> select("select * from scurn_member where member_id=$memID");
		$row = $dbutil -> iterate($memInfo);
		$memCard = $dbutil -> select("select * from member_payment where member_id=$memID");
		$card = $dbutil -> iterate($memCard);
		$dbutil -> close();
		if ($card) {
			$card_number = $card['card_number'];
			$card_name = $card['card_name'];
			$card_month = $card['exp_mm'];
			$card_year = $card['exp_y'];
		} else {
			$card_number = "";
			$card_name = "";
			$card_month = "";
			$card_year = "";
		}
		$fname = $row['firstname'];
		$mname = $row['middlename'];
		$lname = $row['lastname'];
		$addr = $row['member_addr1'];
		$city = $row['city'];
		$state = $row['state'];
		$zipcode = $row['zipcode'];
		$email = $row['email'];
		$phone = $row['phone'];
	} else {
		// non-member, prompt for payment info
		$card_number = "";
		$card_name = "";
		$card_month = "";
		$card_year = "";
		$fname = "";
		$mname = "";
		$lname = "";
		$addr = "";
		$city = "";
		$state = "";
		$zipcode = "";
		$email = "";
		$phone = "";
	}
	?>
	<fieldset>
		<legend>
			Card Details
		</legend>
		<table cellpadding="10" cellspacing="5">
			<tr>
				<td>Card Number*
				<br />
				<span class="tiny">(xxxx-xxxx-xxxx-xxxx)</span></td>
				<td>
				<input type="text" id="cNumber" name="cNumber" value="<?php echo $card_number;?>" maxlength="19" size="22" />
				</td>
				<td></td>
				<td></td>
				<td>Cardholder's Name*
				<br />
				<span class="tiny">(as it appears on the credit card)</span></td>
				<td>
				<input type="text" id="cName" name="cName" value="<?php echo $card_name;?>" maxlength="35" size="35"/>
				</td>
				<td></td>
				<td>Expiration Date*
				<br />
				<span class="tiny">(only month and year required)</span></td>
				<td>
				<select id="cMonth" name="cMonth">
					<?php
					for ($z = 1; $z < 13; $z++) {
						if ($card_month == $z) {
							echo "<option selected value=\"$z\">$z</option>";
						} else {
							echo "<option>$z</option>";
						}
					}
					?>
				</select></td>
				<td></td>
				<td>
				<select id="cYear" name="cYear">
					<?php
					for ($y = 2011; $y < 2020; $y++) {
						if ($card_year == $y) {
							echo "<option selected value=\"$y\">$y</option>";
						} else {
							echo "<option>$y</option>";
						}
					}
					?>
				</select></td>
			</tr>
		</table>
	</fieldset>
	<br />
	<fieldset title="Shipping Address">
		<legend>
			Shipping Address
		</legend>
		<table summary="profile">
			<tr>
				<td>First Name*</td>
				<td>
				<input type="text" name="fname" id="fname" value="<?php echo $fname;?>" size="20" maxlength="20"/>
				</td>
				<td><label for="mname">Middle Name</label></td>
				<td>
				<input type="text" name="mname" id="mname" value="<?php echo $mname;?>" size="20" maxlength="20"/>
				</td>
				<td><label for="lname">Last Name*</label></td>
				<td>
				<input type="text" name="lname" id="lname" value="<?php echo $lname;?>" size="20" maxlength="20"/>
				</td>
			</tr>
			<tr>
				<td>Address*</td>
				<td>
				<input type="text" name="addr" id="addr" value="<?php echo $addr;?>" size="20" maxlength="60"/>
				</td>
				<td>City*</td>
				<td>
				<input type="text" name="city" id="city" value="<?php echo $city;?>" size="20" maxlength="20"/>
				</td>
			</tr>
			<tr>
				<td><label for="state">State*</label></td>
				<td>
				<input type="text" name="state" id="state" value="<?php echo $state;?>" size="3" maxlength="20"/>
				<span class="tiny">(state code)</span></td>
				<td><label for="zip">Zip Code*</label></td>
				<td>
				<input type="text" name="zip" id="zip" value="<?php echo $zipcode;?>" size="5" maxlength="5"/>
				<span class="tiny">(xxxxx)</span></td>
				<td></td>
			</tr>
			<tr>
				<td><label for="email">Email*</label></td>
				<td>
				<input type="text" name="email" id="email" value="<?php echo $email;?>" size="20" maxlength="40"/>
				<span class="tiny">(abc@xyz.com)&nbsp;&nbsp;</span></td>
				<td><label for="phone">Phone</label></td>
				<td>
				<input type="text" name="phone" id="phone" value="<?php echo $phone;?>" size="13" maxlength="12"/>
				<span class="tiny">(xxx-xxx-xxxx)</span></td>
			</tr>
		</table>
	</fieldset>
	<br />
	<p style="text-align:center;">
		<input type="submit" id="confirmButton" name="confirmButton" value="Confirm Order" />
		&nbsp;&nbsp;&nbsp;
		<input type="button" id="orderCancelBtn" name="orderCancelBtn" value="Cancel" />
	</p>
</form>
<?php
session_write_close();
?>