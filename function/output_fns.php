<?php
/**
 * Created by PhpStorm.
 * User: tonytan
 * Date: 22/11/2015
 * Time: 4:40 PM
 */

// do_html_header, called in index.php

function do_html_header($header) {
global $total_price;
global $items;
if(isset($_SESSION['total_price'])){
    $items = $_SESSION['items'];
    $total_price = $_SESSION['total_price'];
    }

?>
<html>
<body bgcolor=white>

<table width=100% border=0 bgcolor=white>
    <tr>
        <td valign=center rowspan=2 align=center>
            <a href="index.php"><img src="/myPHP/shoppingcart/images/bookorama.gif" ></a>
        </td>
        <td bgcolor="#cccccc" align=center valign=middle>
            Total Items: <?=$items?>
        </td>
        <td bgcolor="#cccccc" align=center valign=middle rowspan=2>
            <?
            display_button("show_cart.php", "view-cart", "View Cart");
            ?>
        </td>
    </tr>
    <tr>
        <td bgcolor="#cccccc" align=center valign=middle>
            Total Price: $<?=$total_price?>
        </td>
    </tr>
</table>

<hr><strong> <?=$header?></strong>  <hr/>
<?
}



// display_button, called in do_html_header

function display_button($target, $image, $alt){

    ?>
    <a href="<?= "/myPHP/ShoppingCart/model/".$target ?>"><img src="/myPHP/ShoppingCart/images/<?=$image ?>.gif" alt="<?=$alt?>"
                                  border=0
                                  height=50
                                  width=135></a>
    <?
}

// do_html_footer, called in index.php
function do_html_footer(){

?>
</body></html>
<?

}


function do_html_url ($url, $title) {
    ?>

    <a href="<?=$url?>"><?=$title?></a>

    <?

}



function display_cart($cart, $change = true, $images = true)
{
	// display items in shopping cart
	// optionally allow change (true or false)
	// optionally allow include images (true or false)
?>
<table border='0' width='100%' cellspacing='0' >
<form action='show_cart.php' method='post'>
  <tr bgcolor="#cccccc">
<?php
	// display title
	if ($images) {
		echo '<th colspan="2">Item</th>';
	} else {
		echo '<th>Item</th>';
	}
?>
  <th>Price</th>
  <th>Quantity</th>
  <th align='right'>Total</th>
  </tr>
<?php
	// display items
	foreach ($cart as $isbn => $qty) {
		$book = get_book_details($isbn);
		$pic = "images/book/$isbn.jpg";
		echo "<tr>";
		if ($images) {
			echo "<td align='left'>";
			if (file_exists($pic)) {
				$size = GetImageSize($pic);
				if ($size[0]>0 && $size[1]>0)
					echo '<img src="' . $pic . '" '
						. 'style="border : 1px solid black" '
						. 'width="' . $size[0]/3 . '" '
						. 'height="' . $size[1]/3 . '"/>';
			} else {
				echo '&nbsp;';
			}
			echo "</td>";
		}
?>
	<td align='left'>
	  <a href='show_book.php?isbn=<?php echo $isbn; ?>'/>
	  <?php echo $book['title']; ?></a><br />
	  by&nbsp;<?php echo $book['author'] ?>
	</td>
	<td align='center'>
	  <strong>$</strong><?php echo number_format($book['price'], 2); ?>
	</td>
	<td align='center'>
<?php
	// if num of items can be changed
		if ($change) {
			echo "<input type='text' name='" . $isbn . "' value='" . $qty
				. "' size='2'>";
		} else {
			echo $qty;
		}
?>
    </td>
	<td align='right'>
	  <strong>$</strong><?php echo number_format($book['price']*$qty, 2); ?>
	</td>
<?php
    echo "</tr>";
	}
	// display total row
?>
	<tr bgcolor='#cccccc' align='center'>
	<th colspan="
<?php
		if ($images) {
			echo 3;
		} else {
			echo 2;
		}
?>"
		>&nbsp;</th>
	<th><?php echo $_SESSION['items']; ?></th>
	<th align='right'>$<?php echo number_format($_SESSION['total_price'], 2); ?></th>
	</tr>
<?php
	if ($change) {
		$colspan = 2;
		if ($images)
			$colspan =3;
?>
	<tr>
	  <td colspan="<?php echo $colspan; ?>">&nbsp;</td>
	  <td align='center' colspan='2' >
	    <input type='hidden' name='save' value='submit' />
	    <input type='image' src='../images/save-changes.gif' value="submit"
			border='0' alt='Save Changes' />
	  </td>
	</tr>
<?php
	}
?>
</form>
</table>
<?php
}


function display_checkout_form(){
// display the form as for name and address
?>
<br />
    <form action='../model/purchase.php' method='post'>
<table border='0' width='100%' cellspacing='0'>

        <tr>
            <th colspan='2' bgcolor='#cccccc'>Your Details</th>
        </tr>
        <tr>
            <td align='right'>Name:</td>
            <td><input type='text' name='name' value='' maxlength='40' size='40' /></td>
        </tr>
        <tr>
            <td align='right'>Address:</td>
            <td><input type='text' name='address' value='' maxlength='40' size='40' /></td align='right'>
        </tr>
        <tr>
            <td align='right'>City/Suburb:</td>
            <td><input type='text' name='city' value='' maxlength='20' size='40' /></td>
        </tr>
        <tr>
            <td align='right'>State/Province:</td>
            <td><input type='text' name='state' value='' maxlength='20' size='40' /></td>
        </tr>
        <tr>
            <td align='right'>Postal Code/Zip Code:</td>
            <td><input type='text' name='zip' value='' maxlength='10' size='40' /></td>
        </tr>
        <tr>
            <td align='right'>Country:</td>
            <td><input type='text' name='country' value='' maxlength='20' size='40' /></td>
        </tr>
        <tr>
            <th colspan='2' bgcolor='#cccccc'>Shipping Address
                (leave blank if as above)</th>
        </tr>
        <tr>
            <td align='right'>Name:</td>
            <td><input type='text' name='ship_name' value='' maxlength='40' size='40' /></td>
        </tr>
        <tr>
            <td align='right'>Address:</td>
            <td><input type='text' name='ship_address' value='' maxlength='40' size='40' /></td>
        </tr>
        <tr>
            <td align='right'>City/Suburb:</td>
            <td><input type='text' name='ship_city' value='' maxlength='20' size='40' /></td>
        </tr>
        <tr>
            <td align='right'>State/Province:</td>
            <td><input type='text' name='ship_state' value='' maxlength='20' size='40' /></td>
        </tr>
        <tr>
            <td align='right'>Postal Code/Zip Code:</td>
            <td><input type='text' name='ship_zip' value='' maxlength='10' size='40' /></td>
        </tr>
        <tr>
            <td align='right'>Country:</td>
            <td><input type='text' name='ship_country' value='' maxlength='20' size='40' /></td>
        </tr>
        <tr>
            <td colspan='2' align='center'>
                <p><strong>Please press <em>Purchase</em> to confirm your purchase, or
                        <em>Continue Shopping</em> to add or remove items.</strong></p>
                <?php display_form_button('purchase', "Purchase These Items"); ?>
            </td>
        </tr>
</table></form>
    <hr />
<?
}


function display_form_button ($image, $alt)
{
    ?>
    <div align='center'>
        <input type='image' src='/myPHP/ShoppingCart/images/<?php echo $image; ?>.gif'
               alt='<?php echo $alt; ?>' border='0' height='50' width='135' />
    </div>
    <?php
}

function display_card_form($name){
// display form for asking credit card details
?>
<form action='../model/process.php' method='post'>
<table border='0' width='100%' cellspacing='0'>
        <tr>
            <th colspan='2' bgcolor="#cccccc">Credit Card Details</th>
        </tr>
        <tr>
            <td align='right'>Type:</td>
            <td>
                <select name='card_type'>
                    <option value='VISA'>VISA</option>
                    <option value='MasterCard'>MasterCard</option>
                    <option value='American Express'>American Express</option>
                </select>
            </td>
        </tr>
        <tr>
            <td align='right'>Number:</td>
            <td>
                <input type='text' name='card_number' value='' maxlength='16' size='40'>
            </td>
        </tr>
        <tr>
            <td align='right'>AMEX code (if required):</td>
            <td>
                <input type='text' name='amex_code' value='' maxlength='4' size='4'>
            </td>
        </tr>
        <tr>
            <td align='right'>Expiry Date:</td>
            <td>Month
                <select name='card_month'>
                    <option value='01'>01</option>
                    <option value='02'>02</option>
                    <option value='03'>03</option>
                    <option value='04'>04</option>
                    <option value='05'>05</option>
                    <option value='06'>06</option>
                    <option value='07'>07</option>
                    <option value='08'>08</option>
                    <option value='09'>09</option>
                    <option value='10'>10</option>
                    <option value='11'>11</option>
                    <option value='12'>12</option>
                </select>
                Year
                <select name='card_year'>
                    <?php
                    for ($year=date('Y'); $year<date('Y')+10; $year++) {
                        echo '<option value="' . $year . '">' . $year . '</option>';
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td align='right'>Name on Card:</td>
            <td>
                <input type='text' name='card_name' value='<?php echo $name; ?>'
                       maxlength='40' size='40'>
            </td>
        </tr>
        <tr>
            <td colspan='2' align='center'>
                <p><strong>Please press <em>Purchase</em> to confirm your purchase, or
                        <em>Continue Shopping</em> to add or remove items.</em></strong></p>
                <?php display_form_button('purchase', 'Purchase These Items'); ?>
            </td>
        </tr>
    </form>
<?
}


function display_shipping($cost)
{
?>
<table border='0' width='100%' cellspacing='0'>
<tr>
  <td align='left'>Shipping</td>
  <td align='right'>
  <strong>$</strong><?php echo number_format($cost, 2); ?>
  </td>
</tr>
<tr>
  <th bgcolor='#cccccc' align='left'>TOTAL INCLUDING SHIPPING</th>
  <th bgcolor='#cccccc' align='right'>
  <strong>$</strong><?php echo number_format($cost+$_SESSION['total_price'], 2); ?>
  </th>
</tr>
</table>

<?php
}


function display_category_form($category = ''){
	// This display the category form
	// This form can be used for inserting or editing categries
	// To insert, don't pass any parameters
	// To update, pass an array containing a category
	$edit = is_array($category);
?>
<form method='post'
      action='<?php echo $edit?'edit_category.php':'insert_category.php'; ?>'>
<table border='0'>
  <tr>
    <td>Category Name:</td>
	<td><input type='text' name='catname' size='40' maxlength='40'
	           value='<?php echo $edit?$category['catname']:''; ?>' /></td>
  </tr>
  <tr>
    <td <?php if (!$edit) echo "colspan='2'"; ?> align='center'>
<?php
if ($edit)
	echo "<input type='hidden' name='catid' value='" . $category['catid']
		. "' />";
?>
	  <input type='submit'
	         value="<?php echo $edit?'Rename':'Add'; ?> Category" /></td>
	         </form>
<?php
	if ($edit)
		echo '<form method="post" action="/myPHP/ShoppingCart/model/admin/delete_category.php">
				<td align="center">
				<input type="hidden" name="catid" value="' . $category['catid'] .'" />
				<input type="submit" value="Delete Category" />
			 	</td>
			</form>';
?>


<?php
}

function display_book_form($book = '')
{
	// This display the book form
	// It is very similar to display_category_function
	// This can be used for inserting or editing book
	// To insert, don't pass any parameters.
	// To edit , pass an array contains a book
	$edit = is_array($book);
?>
<form method='post'
      action='<?php echo $edit?'edit_book.php':'insert_book.php'; ?>'>
<table border='0'>
<tr>
  <td align='right'>ISBN:</td>
  <td><input type='text' name='isbn'
             value='<?php echo $edit?$book['isbn']:''; ?>' /></td>
</tr>
<tr>
  <td align='right'>Book Title:</td>
  <td><input type='text' name='title'
             value='<?php echo $edit?$book['title']:''; ?>' /></td>
</tr>
<tr>
  <td align='right'>Book Author:</td>
  <td><input type='text' name='author'
             value='<?php echo $edit?$book['author']:''; ?>' /></td>
</tr>
<tr>
  <td align='right'>Category:</td>
  <td><select name='catid'>
<?php
    $cat_arr = get_categories();
	foreach ($cat_arr as $cat) {
		echo "<option value='" . $cat['catid'] . "'";
		if (($edit) && ($cat['catid'] == $book['catid'])) {
			echo " selected='selected'";
		}
		echo ">" . $cat['catname'] . "</option>";
	}
?>
  </select>
  </td>
</tr>
<tr>
  <td align='right'>Price ($):</td>
  <td><input type='text' name='price'
             value='<?php echo $edit?$book['price']:''; ?>' /></td>
</tr>
<tr>
  <td align='right'>Description:</td>
  <td><textarea rows='5' cols='50' name='description'><?php
      echo $edit?$book['description']:''; ?></textarea></td>
</tr>
<tr>
  <td <?php if (!$edit) echo 'colspan=2'; ?> align='center' >
    <?php
	if ($edit)
		echo "<input type='hidden' name='oldisbn' value='"
			. $book['isbn'] . "' />";
	?>
	<input type='submit'
	       value='<?php echo $edit?'Update':'Add'; ?> Book' />
  </td></form>
  <?php
    if ($edit) {
		echo "<form method='post' action='delete_book.php'>
			   <td>
			   <input type='hidden' name='isbn' value='" . $book['isbn'] . "'>
			   <input type='submit' value='Delete Book'>
			   <td/>
			  </form>";
	}
  ?>
<?php
}


function display_login_form()
{
    ?>
    <form action="admin.php" method="get" >
        <table bgcolor="#cccccc">
            <tr>
                <td>Username:</td>
                <td><input type="text" name="username"/></td></tr>
            <tr>
                <td>Password:</td>
                <td><input type="password" name="password"/></td></tr>
            <tr>
                <td colspan="2" align="center">
                    <input type="submit" value="Log in"/></td></tr>
            <tr>
        </table></form>
    <?php
}

function display_password_form()
{
?>
 <br />
   <form action="/ShoppingCart/model/admin/change_password.php" method="post">
   <table width="250" cellpadding="2" cellspacing="0" bgcolor="#cccccc">
   <tr><td>Old password:</td>
       <td><input type="password" name="old_passwd" size="16" maxlength="16" /></td>
   </tr>
   <tr><td>New password:</td>
       <td><input type="password" name="new_passwd" size="16" maxlength="16" /></td>
   </tr>
   <tr><td>Repeat new password:</td>
       <td><input type="password" name="new_passwd2" size="16" maxlength="16" /></td>
   </tr>
   <tr><td colspan=2 align="center"><input type="submit" value="Change password">
   </td></tr>
   </table>
   <br />
<?php
}


function display_admin_menu(){
    ?>
    <br />
    <a href='http://localhost:63342/myPHP/ShoppingCart/model/index.php'>Go to mian site</a><br />
    <a href='/myPHP/ShoppingCart/model/admin/insert_category_form.php'>Add a new category</a><br />
    <a href='/myPHP/ShoppingCart/model/admin/insert_book_form.php'>Add a new book</a><br />
    <a href='/myPHP/ShoppingCart/model/admin/change_password_form.php'>Change admin password</a>
    <br />
<?
}





