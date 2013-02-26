<?php
	include 'DBUtil.php';
	session_start();
?>
<form action="" method="post" class="scurnForm">
	<?php
	$dbutil = new DBUtil();
	$dbutil -> connect();
	$name = $_POST['fname'] . " " . $_POST['lname'];
	$card4digits = substr($_POST["cNumber"], -4);
	echo "<p style='font-weight: bold;color: #c16e34;font-size: 12pt;' >";
	echo "Thank you " . $name . " for your order! Your card xxxx-xxxx-xxxx-" . $card4digits . " was charged for <span style='color: #3fa12b;'>\$" . $_POST['hiddenval'] . "</span>";
	echo "</p>";
	echo "<br />";
	$range = $_POST["numProducts"];
	//fetching member details

	if (isset($_SESSION['memberID'])) {
		$memID = $_SESSION['memberID'];
		$memCard = $dbutil -> select("select * from member_payment where member_id=$memID");
		$card = $dbutil -> iterate($memCard);
		if ($card) {
			$payment_id = $card['member_payment_id'];
			//Inserting into scurn_order the order details
			$query = "insert into scurn_order(member_payment_id,totalprice,firstname,middlename,lastname,shipping_addr1,shipping_zipcode,shipping_code)
			 values('" . $payment_id . "' ,'" . $_POST['hiddenval'] . "' ,'" . $_POST['fname'] . "' ,'" . $_POST['mname'] . "' ,'" . $_POST['lname'] . "' ,'" . $_POST['addr'] . "'
			 ,'" . $_POST['zip'] . "' ,'" . $_POST['shipcode'] . "' )";

		} else {
			//Inserting into scurn_order the order details
			$query = "insert into scurn_order(totalprice,firstname,middlename,lastname,shipping_addr1,shipping_zipcode,shipping_code)
			 values('" . $_POST['hiddenval'] . "' ,'" . $_POST['fname'] . "' ,'" . $_POST['mname'] . "' ,'" . $_POST['lname'] . "' ,'" . $_POST['addr'] . "'
			 ,'" . $_POST['zip'] . "' ,'" . $_POST['shipcode'] . "' )";

		}

		$orderNumber = $dbutil -> insert($query);
	} else {
		$query = "insert into scurn_order(totalprice,firstname,middlename,lastname,shipping_addr1,shipping_zipcode,shipping_code)
			values('" . $_POST['hiddenval'] . "' ,'" . $_POST['fname'] . "' ,'" . $_POST['mname'] . "' ,'" . $_POST['lname'] . "' ,'" . $_POST['addr'] . "'
			,'" . $_POST['zip'] . "' ,'" . $_POST['shipcode'] . "' )";

		$orderNumber = $dbutil -> insert($query);
	}

	//Inserting into item_order

	for ($i = 1; $i <= $range; $i++) {
		$vari = "itemCode" . $i;
		$varia = "selected" . $i;
		if (isset($_POST[$vari])) {
			$itemCode = $_POST[$vari];
			$quantity = $_POST[$varia];

			$orderQuery = "insert into item_order(order_number,item_code,order_quantity)
					values('" . $orderNumber . "' ,'" . $itemCode . "' ,'" . $quantity . "')";
			$item = $dbutil -> insert($orderQuery);

			//Getting the present quantity from Inventory
			$selectQuery = "select quantity from scurn_inventory where item_code = $itemCode";
			$result = $dbutil -> select($selectQuery);
			$inter = $dbutil -> iterate($result);
			$pQuantity = $inter['quantity'];
			$remaining = $pQuantity - $quantity;

			if ($remaining < 0) {
				$remaining = 0;
			}
			//Updating Inventory
			$updateQuery = "update scurn_inventory
					set quantity = '" . $remaining . "'
					where item_code = $itemCode";
			$updated = $dbutil -> update($updateQuery);
		}
	}
	?>
	<br />
	<a style="text-align: center;float: right; margin-right: 10%;" href="javascript:window.print()"> <img src="../images/printer-icon.png" width="58px" height="58px" /> </a>
	<br />
	<table cellpadding="10px" cellspacing="13px" class="receiptTable" >
		<tr>
			<th colspan = "7" class="bold" style="text-align: left">ORDER RECEIPT</th>
		</tr>
		<tr>
			<td colspan="7">
			<hr />
			</td>
		</tr>
		<tr>
			<th class="purchase">Items Purchased</th>
			<th></th>
			<th>Quantity</th>
			<th></th>
			<th>Price/Item</th>
			<th></th>
			<th>Total</th>
		</tr>
		<?php

for ($i = 1; $i <= $range; $i++) {
$vari = "itemCode" . $i;
$varia = "selected" . $i;
if (isset($_POST["$vari"])) {
$itemCode = $_POST["$vari"];
$quantity = $_POST[$varia];
$result = $dbutil -> select("select item_name,price from scurn_inventory where item_code='$itemCode' ");
$prod = $dbutil->iterate($result);
echo "<tr>";
echo "<td class=\"purchase\">";
echo $prod['item_name'];
echo "</td>";
echo "<td></td>";
echo "<td>";
echo $quantity;
echo "</td>";
echo "<td></td>";
echo "<td>";
echo "$".$prod['price'];
echo "<td></td>";
echo "<td>";
echo "$".(number_format(($quantity * $prod['price']),2,'.',''));
echo "</td>";
echo "</tr>";
}
}
if(isset($_SESSION['memberID'])){
		?>
		<tr>
			<td colspan = "2" class="bold">Discount</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td><?php echo "$" . $_POST['discount'];?></td>
		</tr>
		<?php }?>
		<tr>
			<td colspan = "2" class="bold">Tax</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td><?php echo "$" . $_POST['tax'];?></td>
		</tr>
		<tr>
			<td colspan="7">
			<hr />
			</td>
		</tr>
		<tr>
			<td colspan = "2" class="bold">Order Total Price</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td><b><?php echo "$" . $_POST['hiddenval'];?><b></td>
		</tr>
	</table>
	<?php
	$dbutil -> close();
	?>
	<br />
	<p style="width: 50%;margin-left: auto;margin-right: auto;">
		<label style='font-weight: bold;color: #c16e34;font-size: 12pt;' >Do visit us again soon!</label>
		&nbsp;&nbsp;&nbsp;&nbsp;
		<button class="productsBack">
			<span class="ui-icon ui-icon-arrowreturnthick-1-w"></span>Products Catalog
		</button>
	</p>
</form>