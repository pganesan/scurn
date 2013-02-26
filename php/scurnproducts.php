<?php
include 'DBUtil.php';
?>
<form action="scurnorder.php" method="post" id="scurnproducts" name="scurnproducts" >
	<table border="0" summary="header" width="100%" cellspacing="10px">
		<tr>
			<td width="75%">
			<p id="productsError" class="ui-state-error ui-corner-all">
				<span class="ui-icon ui-icon-alert"></span>
				<span>Select product(s) and click on Checkout button to complete the purchase</span>
			</p></td>
			<td width="10%">&nbsp;</td>
			<td width="15%">
			<button id="checkoutButton" type="submit" name="checkoutButton"><span class="ui-icon ui-icon-cart"></span>Checkout</button>
			</td>
		</tr>
	</table>
	<?php
	$dbutil = new DBUtil();
	$dbutil -> connect();

	// example of select sql
	$result = $dbutil -> select("select item_code, item_name,item_image_url,quantity,price from scurn_inventory");
	?>
	<table border="0" summary="items in inventory" cellspacing="25px" cellpadding="25px" class="productsList" width="75%">
		<?php
$i=0;
while ($row = $dbutil->iterate($result)) {
$i=$i+1;
		?>
		<tr>
			<td width="40%"><img class="itemImg" alt="item image" src="<?php echo $row["item_image_url"]?>" /></td>
			<td width="40%"><?php
			if ($row["quantity"] != 0) {
				echo "<span style=\"color:#3fa12b;font-weight:bold;font-size:12pt\">In Stock</span>";
			} else {
				echo "<span style=\"color:#3fa12b;font-weight:bold;font-size:12pt\">Sold Out</span>";
			}
			echo "<br />";
			echo "<span style=\"color:#79101a;font-weight:bold;font-size:14pt\">".$row['item_name']."</span>";
			echo "<br />";
			echo "<span style=\"font-size:12pt\">"."$" . $row["price"]."</span>";
			?></td>
			<td width="20%"><input type="checkbox" class="addCart" name="product<?php echo $i;?>" id="prod<?php echo $i;?>" value="<?php echo $row["item_code"];?>"/><label for="prod<?php echo $i;?>">Add to Cart</label></td>
		</tr>
		<?php
		}
		?>
		<input type="hidden" name="ivalue" value="<?php echo $i;?>" />
	</table>
</form>
